<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Shopifysale;
use App\Model\Table\ShopifysalesTable;
use Cake\Datasource\ResultSetInterface;
use Cake\I18n\FrozenTime;
use PHPExcel;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_Excel5;
/**
 * Shopifysales Controller
 *
 * @property ShopifysalesTable $Shopifysales
 * @method Shopifysale[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShopifysalesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $controller = 'Shopifysales';
        $this->set('controller', $controller);

        parent::beforeFilter($event);
        $identity = $this->getRequest()->getAttribute('identity');
        if ($identity == null) {
            $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else if ($identity->get('role') != 'admin') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to view manufacturers page'));
        }
    }

    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {

        $key = $this->request->getQuery('key');
        if ($key) {
            $query = $this->paginate($this->Shopifysales->find('all')
                ->where(['Or' => ['Name like' => '%' . $key . '%', 'Email like' => '%' . $key . '%',
                    'Financial_Status like' => '%' . $key . '%',
                    'LineItem_name like' => '%' . $key . '%']]));
        } else {
            $query = $this->paginate($this->Shopifysales->find('all'), ['limit' => 20]);
        }

        $shopifysales = $query;
        $this->set(compact('shopifysales'));
    }

    public function importsexcel()
    {


        if (!empty($_FILES['excel']['name'])) {


            $file_info = $this->uploadexcel('excel');
            $file_url = $file_info['filename'];

            $exts = $file_info['exts'];
            if (!empty($file_url) && file_exists($file_url)) {
                $this->data_import($file_url, $exts, 3);
            }

        }
        return $this->redirect(['action' => 'index']);
    }


    public function uploadexcel($file_name)
    {

        $filename = $_FILES[$file_name]['tmp_name'];
        $file = $_FILES[$file_name]['name'];
        $file_type = substr(strrchr($file, '.'), 1);
        $file_name = time() . rand(1000, 9999) . '.' . $file_type;

        $path = 'upload/excel/' . date("Ymd", time());
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
        $destination = $path . '/' . $file_name;
        move_uploaded_file($filename, $destination);
        return array('filename' => $destination, 'exts' => $file_type);


    }

    public function data_import($filename, $exts = 'xls', $or)
    {
        require_once 'PHPExcel/PHPExcel.php';
        $PHPExcel = new PHPExcel();


        if ($exts == 'xls') {
            require_once 'PHPExcel/PHPExcel/Reader/Excel5.php';
            $PHPReader = new PHPExcel_Reader_Excel5();
        } else if ($exts == 'xlsx') {
            require_once 'PHPExcel/PHPExcel/Reader/Excel2007.php';
            $PHPReader = new PHPExcel_Reader_Excel2007();
        } else {
            $this->Flash->error(__('Please only import an .xls file'));
            return $this->redirect(['action' => 'index']);
        }


        $PHPExcel = $PHPReader->load($filename);

        $currentSheet = $PHPExcel->getSheet(0);

        $allColumn = $currentSheet->getHighestColumn();

        $allRow = $currentSheet->getHighestRow();
        $data = [];
        $this->loadModel('Products');
        $this->loadModel('Inventories');
        $inventoriesInfo = [];

        for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
            $insertData['Name'] = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
            $insertData['Email'] = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
            $insertData['Financial_Status'] = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();
            $insertData['Paid_at'] = $PHPExcel->getActiveSheet()->getCell("D" . $currentRow)->getValue();
            $insertData['Subtotal'] = $PHPExcel->getActiveSheet()->getCell("I" . $currentRow)->getValue();
            $insertData['Shipping'] = $PHPExcel->getActiveSheet()->getCell("J" . $currentRow)->getValue();
            $insertData['Taxes'] = $PHPExcel->getActiveSheet()->getCell("K" . $currentRow)->getValue();
            $insertData['Total'] = $PHPExcel->getActiveSheet()->getCell("L" . $currentRow)->getValue();
            $insertData['LineItem_name'] = $PHPExcel->getActiveSheet()->getCell("R" . $currentRow)->getValue();
            if (!isset($insertData['LineItem_name'])) {
                $this->Flash->error(__(' No product was specified on line {0}', $currentRow));
            } else {
            $insertData['LineItem_quantity'] = $PHPExcel->getActiveSheet()->getCell("Q" . $currentRow)->getValue();
            $product = $this->Products->find()->where(['title' => $insertData['LineItem_name']])->first();
            $inventories = $this->Inventories->find()->where(['product_id' => $product->id])->order('received_date')->first();

            if (!$product) {
                return $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $insertData['LineItem_name']));
                return $this->redirect(['action' => 'index']);
            } elseif (!$inventories) {
                return $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $insertData['LineItem_name']));
                return $this->redirect(['action' => 'index']);
            } else {
                $inventoriesInfo[] = [
                    'id' => $inventories->id,
                    'num' => $inventories->quantity - $insertData['LineItem_quantity'],
                    'obj' => $inventories
                ];
                $insertData['LineItem_price'] = $PHPExcel->getActiveSheet()->getCell("S" . $currentRow)->getValue();

                array_push($data, $insertData);
            }
        }
}
        $this->insert_data($data);
    }

    public function insert_data($data)
    {

        foreach ($data as $k => $v) {

            $info['Name'] = $v['Name'];
            $info['Email'] = $v['Email'];
            $info['Financial_Status'] = $v['Financial_Status'];
            $info['Paid_at'] = empty($v['Paid_at']) ? null : date('Y-m-d H:i:s', strtotime($v['Paid_at']));
            $info['Subtotal'] = (int)$v['Subtotal'];
            $info['Shipping'] = (int)$v['Shipping'];
            $info['Taxes'] = (int)$v['Taxes'];
            $info['Total'] = (int)$v['Total'];
            $info['LineItem_name'] = $v['LineItem_name'];

            $info['LineItem_quantity'] = (int)$v['LineItem_quantity'];
            $info['LineItem_price'] = (int)$v['LineItem_price'];
            $inventory = $this->Shopifysales->newEmptyEntity();
            $inventory = $this->Shopifysales->patchEntity($inventory, $info);
            if ($this->Shopifysales->save($inventory)) {
                $this->Flash->success(__(' {0} units of {1} to {2} have been added', $info['LineItem_quantity'], $info['LineItem_name'], $info['Name']));
            } else {
                $this->Flash->error(__(' {0} units of {1} to {2} could not be imported. Please add this row in manually,
                or import it again separately. ', $info['Total'], $info['LineItem_name'], $info['Name']));
            }

        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * View method
     *
     * @param string|null $id Shopifysale id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shopifysale = $this->Shopifysales->get($id, [
            'contain' => [],
        ]);

        $products = $this->Shopifysales->find('all', array('conditions' => array('Email' => $shopifysale->Email), 'fields' => array('LineItem_name', 'LineItem_quantity', 'LineItem_price', 'Subtotal', 'Shipping', 'Taxes', 'Total', 'Paid_at'),));
        $productsData = [];
        $Subtotal = 0;
        $Shipping = 0;
        $Taxes = 0;
        $Total = 0;
        foreach ($products as $v) {
            $insert['LineItem_name'] = $v->LineItem_name;
            $insert['LineItem_quantity'] = $v->LineItem_quantity;
            $insert['LineItem_price'] = $v->LineItem_price;
            $insert['Paid_at'] = $v->Paid_at;
            $Subtotal += $v->Subtotal;
            $Shipping += $v->Shipping;
            $Taxes += $v->Taxes;
            $Total += $v->Total;
            array_push($productsData, $insert);
        }
        $shopifysale->Subtotal = $Subtotal;
        $shopifysale->Shipping = $Shipping;
        $shopifysale->Taxes = $Taxes;
        $shopifysale->Total = $Total;
        $this->set(compact('shopifysale', 'productsData'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shopifysale = $this->Shopifysales->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->loadModel('Products');
            $this->loadModel('Inventories');
            $data = $this->request->getData();
            $data['Subtotal'] = (int)$data['Subtotal'];
            $data['Shipping'] = (int)$data['Shipping'];
            $data['Taxes'] = (int)$data['Taxes'];
            $data['Total'] = (int)$data['Total'];
            $data['LineItem_quantity'] = (int)$data['LineItem_quantity'];
            $data['LineItem_price'] = (int)$data['LineItem_price'];
            $data['Paid_at'] = date('Y-m-d H:i:s', strtotime($data['Paid_at']));
            $product = $this->Products->find()->where(['title' => $data['LineItem_name']])->first();
            if (!$product) {
                return $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $data['LineItem_name']));
            }
            $inventories = $this->Inventories->find()->where(['product_id' => $product->id])->order('received_date asc')->find('all');
            $productNum = 0;
            foreach ($inventories as $v){
                $time = $v->expiry_date->i18nFormat('yyyy-MM-dd');
                if(strtotime($time)>time()){
                    $productNum += $v->quantity;
                }
            }
            if ($productNum < $data['LineItem_quantity']) {
                return $this->Flash->error(__('It seems like there is no available stock'));
            }
            //$num = $inventories->quantity - $data['LineItem_quantity'];
            // $this->Inventories->updateAll(['quantity'=>$num],['id'=>$inventories->id]);
            $shopifysale = $this->Shopifysales->patchEntity($shopifysale, $this->request->getData());
            if ($this->Shopifysales->save($shopifysale)) {
                $this->Flash->success(__('The shopifysale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            return $this->Flash->error(__('The Shopify Sale could not be saved. Please, try again.'));
        }
        $time = new FrozenTime('now', 'Australia/Melbourne');
        $this->set(compact('shopifysale', 'time'));


    }

    /**
     * Edit method
     *
     * @param string|null $id Shopifysale id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shopifysale = $this->Shopifysales->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shopifysale = $this->Shopifysales->patchEntity($shopifysale, $this->request->getData());
            if ($this->Shopifysales->save($shopifysale)) {
                $this->Flash->success(__('The shopifysale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Sale could not be saved. Please, try again.'));
        }
        $this->set(compact('shopifysale'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shopifysale id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shopifysale = $this->Shopifysales->get($id);
        if ($this->Shopifysales->delete($shopifysale)) {
            $this->Flash->success(__('The shopify sales order has been deleted.'));
        } else {
            $this->Flash->error(__('The shopify sales order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

        public function ship($id = null)
    {
        $shopifysale = $this->Shopifysales->get($id, [
            'contain' => [],
        ]);
        $this->loadModel('Products');
        $this->loadModel('Inventories');
        $product = $this->Products->find()->where(['title' => $shopifysale->LineItem_name])->first();
        if (!$product) {
            $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $shopifysale->LineItem_name));
            return $this->redirect(['action' => 'index']);
        }
        $inventories = $this->Inventories->find()->where(['product_id' => $product->id])->order('received_date asc')->find('all');
        if(!$inventories){
            $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $shopifysale->LineItem_name));
            return $this->redirect(['action' => 'index']);
        }
        $productNum = 0;
        $inventoriesArr = [];
        foreach ($inventories as $v){
           if(!empty($v->expiry_date)){
               $time = $v->expiry_date->i18nFormat('yyyy-MM-dd');
               if(strtotime($time)>time()){
                   $productNum += $v->quantity;
                   array_push($inventoriesArr,$v);
               }
           }else{
               $productNum += $v->quantity;
               array_push($inventoriesArr,$v);
           }
        }
        if ($productNum < $shopifysale->LineItem_quantity) {
             $this->Flash->error(__('It seems like there is no available stock'));
            return $this->redirect(['action' => 'index']);
        }
        $now_num = $shopifysale->LineItem_quantity;
        foreach ($inventoriesArr as $v){
            if($v->quantity<$now_num){
                $this->Inventories->updateAll(['quantity'=>0],['id'=>$v->id]);
                $now_num -= $v->quantity;
            }else{
                $num = $v->quantity-$now_num;
                $this->Inventories->updateAll(['quantity'=>$num],['id'=>$v->id]);
                break;
            }
        }
        $shopifysale = $this->Shopifysales->patchEntity($shopifysale,['is_ship'=>0]);
        if($this->Shopifysales->save($shopifysale)){
            $this->Flash->success(__('The Sale has successfully shipped.'));
        }
        else {
            $this->Flash->error(__('The Sale could not be updated, please try again'));

        }
        return $this->redirect(['action' => 'index']);

    }


    public function return($id = null){
        $shopifysale = $this->Shopifysales->get($id, [
            'contain' => [],
        ]);
        $this->loadModel('Products');
        $this->loadModel('Inventories');
        $product = $this->Products->find()->where(['title' => $shopifysale->LineItem_name])->first();
        if (!$product) {
            $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $shopifysale->LineItem_name));
            return $this->redirect(['action' => 'index']);
        }
        $inventories = $this->Inventories->find()->where(['product_id' => $product->id])->order('received_date asc')->first();
        if(!$inventories){
            $this->Flash->error(__('It seems like you don’t have this product in inventories :' . $shopifysale->LineItem_name));
            return $this->redirect(['action' => 'index']);
        }
        $now_num = $shopifysale->LineItem_quantity+$inventories->quantity;
        $this->Inventories->updateAll(['quantity'=>$now_num],['id'=>$inventories->id]);
        $shopifysale = $this->Shopifysales->patchEntity($shopifysale,['is_ship'=>1]);
        if($this->Shopifysales->save($shopifysale)){
            $this->Flash->success(__('The inventory quantity has been returned.'));
        }
        else {
            $this->Flash->error(__('The Sale could not be updated, please try again'));

        }
        return $this->redirect(['action' => 'index']);
    }
}
