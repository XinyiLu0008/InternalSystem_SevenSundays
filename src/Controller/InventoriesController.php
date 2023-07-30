<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Inventory;
use App\Model\Table\InventoriesTable;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;

use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;
use PHPExcel;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_Excel5;
use function PHPUnit\Framework\isEmpty;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

/**
 * Inventories Controller
 *
 * @property InventoriesTable $Inventories
 * @method Inventory[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class InventoriesController extends AppController
{

    //restrict customer access to inventories page
    public function beforeFilter(EventInterface $event)
    {
        $controller = 'Inventories';
        $this->set('controller', $controller);

        parent::beforeFilter($event);
        $identity = $this->getRequest()->getAttribute('identity');
        if ($identity == null) {
            $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else if ($identity->get('role') != 'admin') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to view inventories page'));
        }
    }

    /**
     * @return bool[]
     */
    public function modifyCheckbox()
    {
        $vid = $this->request->getQuery('vid');
        $add = $this->request->getQuery('add');
        $inventory = $this->Inventories->get($vid);
        if ($add == 1) {
            $inventory = $this->Inventories->patchEntity($inventory, ['checkbox' => 1]);
        } else {
            $inventory = $this->Inventories->patchEntity($inventory, ['checkbox' => 0]);
        }
        $this->Inventories->save($inventory);

        //

        $product = $this->Inventories->Products->get($inventory['product_id']);
        $packaging = $this->Inventories->Products->Packagings->get($product['packaging_id']);
        if ($packaging['total_quantity'] >= $inventory['quantity']) {


            if ($add == 1) {
                $packaging['total_quantity'] -= $inventory['quantity'];
                $this->Flash->success(__('The packaging quantity of the {0} has been deducted successfully.', $packaging->title));
            } else {
                $packaging['total_quantity'] += $inventory['quantity'];

                $this->Flash->success(__('The packaging quantity of the {0} has been updated.', $packaging->title));
            }
            $this->Inventories->Products->Packagings->save($packaging);
            //$packaging=json_decode(json_encode(array('result' => true, 'vid' => $vid, 'add' => $add)),true);
            die(json_encode(array('result' => true,'vid'=>$vid,'add'=>$add))) ;

        } else {
            if($add != 1) {
                $packaging['total_quantity'] +=$inventory['quantity'];
                $this->Flash->success(__('The packaging stock has been updated.'));
                $this->Inventories->Products->Packagings->save($packaging);


            }else{
                $inventory = $this->Inventories->get($vid);
                $inventory = $this->Inventories->patchEntity($inventory, ['checkbox' => 0]);
                $this->Inventories->save($inventory);
                //echo "<script>alert('Unable to deduct the corresponding packaging quantity. The packaging stock is insufficient.');</script>";
                //exit;
               $this->Flash->error(__('Unable to deduct the corresponding packaging quantity. The packaging stock is insufficient.'));
                }
            die(json_encode(array('result' => true,'vid'=>$vid,'add'=>$add))) ;

        }

    }

    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products'],
        ];
        $inventories = $this->paginate($this->Inventories);

        $key = $this->request->getQuery('key');
        if ($key) {
            $query = $this->paginate($this->Inventories->find('all', ['contain' => ['Products']])
                ->where(['Or' => ['Products.title like' => '%' . $key . '%', 'Products.sku like' => '%' . $key . '%']]));
        } else {

            $query = $this->paginate($this->Inventories->find('all', ['contain' => ['Products']]), ['limit' => 20]);
        }
        $inventories = $query;
        $this->set(compact('inventories'));

        // add 6 months  from todays date
        $expiryDateReference = new FrozenTime('6 month', 'Australia/Melbourne');

        $inventoriesExpiring = $this->Inventories->find('all', ['contain' => ['Products']])
            ->where(['expiry_date <=' => $expiryDateReference])
            ->where(['quantity !=' => 0]);

        foreach ($inventoriesExpiring as $inventory):
            // if  there are any inventory items set to expire in the next 6 months, display a notification of this
            if (isset($inventory->expiry_date) && $inventory->expiry_date < $expiryDateReference && $inventory->quantity != 0) {
                $this->Flash->error(__('Expiring Shipments: {0} units of {1} on {2}', $inventory->quantity, $inventory->product->title, $inventory->expiry_date), [
                    'key' => 'low_stock',
                    'params' => [
                        'id' => $inventory->id
                    ]
                ]);
            }

        endforeach;
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

        for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
            $insertData['received_date'] = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
            $insertData['quantity'] = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();
            $insertData['expiry_date'] = $PHPExcel->getActiveSheet()->getCell("D" . $currentRow)->getValue();
            $insertData['product_id'] = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
            array_push($data, $insertData);
        }
        $data = array_unique($data, SORT_REGULAR);
        $inventoriesData = $this->Inventories->find("all");
        $inventoriesData = json_decode(json_encode($inventoriesData), true);
        foreach ($inventoriesData as &$vo) {
            unset($vo['id']);
        }
        foreach ($data as $k => $v) {
            if (in_array($v, $inventoriesData)) {
                unset($data[$k]);
            }
        }
        $this->insert_data($data);
        //$html = "<div style='text-align: center;margin: 300px auto 0 auto;'><div>Import <span style='color:red'>".count($data)."</span>records</div><a href='/boyang/team073-app_fit3048/inventories/'>Back</a></div>";
        //echo $html;
        //exit;

    }

    public function insert_data($data)
    {
        $this->loadModel('Products');
        $index = 2;
        foreach ($data as $k => $v) {

            if (isset($v['product_id'])) {

                $query = $this->Products
                    ->find()
                    ->select(['id'])
                    ->where(['title' => $v['product_id']])
                    ->first();

                if (!isset($query)) {
                    $this->Flash->error(__('No record found for Product declare on line {0} of the file', $index));
                } else {

                    $info['product_id'] = $query['id'];
                    $info['received_date'] = $v['received_date'];
                    $info['quantity'] = (int)$v['quantity'];
                    $info['expiry_date'] = $v['expiry_date'];

                    $productName = $this->Products
                        ->find()
                        ->where(['id' => $info['product_id']])
                        ->first();

                    $inventory = $this->Inventories->newEmptyEntity();
                    $inventory = $this->Inventories->patchEntity($inventory, $info);

                    if ($this->Inventories->save($inventory)) {
                        $this->Flash->success(__(' {0} units of {1} have been added', (int)$v['quantity'], $productName["title"]));
                    } else {
                        $this->Flash->error(__('Row {0} of the file could not be imported', $index));
                    }
                }
            }
            $index++;
        }

        //return true;
        return $this->redirect(['action' => 'index']);

    }

    /**
     * View method
     *
     * @param string|null $id Inventory id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventory = $this->Inventories->get($id, [
            'contain' => ['Products', 'Sales'],
        ]);

        $this->set(compact('inventory'));
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventory = $this->Inventories->newEmptyEntity();
        if ($this->request->is('post')) {
            $newData = $this->request->getData();
            if (isset($newData['lifetime']) && !empty($newData['lifetime'])) {
                $time = strtotime("+{$newData['lifetime']} years", strtotime($newData['received_date']));
                $newData['expiry_date'] = date("Y-m-d", $time);
            } else {
                $this->loadModel('Products');
                $product = $this->Products->find()->where(['id' => $newData['product_id']])->first();
                if (isset($product->shelf_life)) {
                    $time = strtotime("+{$product->shelf_life} years", strtotime($newData['received_date']));
                    $newData['expiry_date'] = date("Y-m-d", $time);
                    $newData['lifetime'] = $product->shelf_life;
                }
            }

            $inventory = $this->Inventories->patchEntity($inventory, $newData);
            $date = $inventory['received_date'];

            $time = FrozenTime::now('Australia/Melbourne');
            if ($date > $time) {
                $this->Flash->error(__('The input of the Received Date should be earlier than today. Please check.'));
            } else {
                if ($this->Inventories->save($inventory)) {
                    $this->Flash->success(__('The inventory has been saved.'));

                    $NewDate = Date('d/m/y', strtotime('+90 days'));

                    if ($inventory->expiry_date < $NewDate && isset($inventory->expiry_date)) {

                        //$this->Goods_sentEmail(); //call mail function
                    }
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The inventory could not be saved. Please, try again.'));
            }
        }
        $products = $this->Inventories->Products->find('list', ['limit' => 200]);
        $this->set(compact('inventory', 'products'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Inventory id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventory = $this->Inventories->get($id, [
            'contain' => [],

        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $newData = $this->request->getData();
            $inventory = $this->Inventories->patchEntity($inventory, $newData);

            $date = $inventory['received_date'];
            $time = FrozenTime::now('Australia/Melbourne');
            if ($date > $time) {
                $this->Flash->error(__('The input of the Received Date is should be earlier than today. Please check.'));
            } else {
                if ($this->Inventories->save($inventory)) {
                    $this->Flash->success(__('The inventory record of batch no. #{0} has been updated successfully.', $inventory->id));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The inventory could not be saved. Please, try again.'));
            }
        }
        $products = $this->Inventories->Products->find('list', ['limit' => 200]);
        $this->set(compact('inventory', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventory = $this->Inventories->get($id);

        if ($this->Inventories->delete($inventory)) {

            $this->Flash->success(__('The inventory record of batch no. #{0} has been deleted.', $inventory->id));
        } else {
            $this->Flash->error(__('The inventory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function confirm($id = null)
    {

        if ($this->request->is(['patch', 'post', 'put'])) {
            $InventoryTable = TableRegistry::getTableLocator()->get('Inventories');
            $query = $InventoryTable->query();
            $inventory = $InventoryTable->get($id);

            // update the currently selected inventory record so the received date is now
            $query->update()
                ->set(['received_date' => time()])
                ->where(['id' => $id])
                ->execute();


            $InventoryTable->save($inventory);

            $this->Flash->success(__('The inventory record of batch no. #{0} have been received.', $inventory->id));
            return $this->redirect(['controller' => 'Inventories', 'action' => 'index']);

        } else {

            $this->Flash->error(__('The order could not be confirmed'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function deleteAll()
    {

        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->getData('id');

        if (count(array_keys($id, 0)) == count($id)) {
            $this->Flash->error(__('Please specify at least one inventory batch to delete'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Inventories->deleteAll(['Inventories.id IN' => $id])) {
            $this->Flash->success(__('The inventory items has been deleted successfully.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The inventory item {0} could not be deleted. Please, try again.', $id));
    }

    //    Add stock input to existing totals.
    public function bulkDeduct()
    {
        $this->loadModel('Products');

//      create new entities for each row passed by inventories: bulkUpdate
        $entities = $this
            ->Inventories
            ->newEntities($this
                ->request
                ->getData());


        if ($this
            ->request
            ->is(['patch', 'post', 'put'])) {

            foreach ($entities as $entity) {
                $productName = $this->Products->find()->select(['title'])->where(['id' => strVal($entity["product_id"])])->first();

                $inventories = $this->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => strVal($entity["product_id"])]);
                $inventories = json_decode(json_encode($inventories), true);

                if (empty($inventories)) {
                    $this->Flash->error(__('There was an error encountered with the Product you specified'));
                    return $this->redirect(['action' => 'bulk_deduct']);
                }

                //check for expiry inventories records/batches
                //if expired inventories record exists, then do not deduct the expired qty
                for ($i = 0; $i < count($inventories); $i++) {
                    $getExpiry = $inventories[$i]['expiry_date'];

                    //get current time
                    $currentDate = FrozenDate::now()->toDateString();
                    if ($getExpiry < $currentDate) {
                        unset($inventories[$i]);
                    }

                }

                //get total inventory product qty
                $totalqty = array_sum(array_column($inventories, 'quantity'));

//               if there is not enough stock available to deduct in the inventory
                if ($entity["quantity"] > $totalqty) {
                    $this->Flash->error(__('Failed to deduct {0} units of {1} due to the product quantity exceeding the total inventory quantity.', $entity->quantity, $productName->title));
                    return $this->redirect(['action' => 'bulk_deduct']);
                } else {

                    $entityQuantity = $entity->quantity;

                    //start of FIFO
                    foreach ($inventories as $i) {
                        //subtract the order's qty from each inventory qty
                        $num = $i['quantity'] - $entityQuantity;

                        //base case of recursive loop
                        if ($num >= 0) {
                            $inData['quantity'] = $num;
                            if ($this->Inventories->updateAll($inData, ['id' => $i['id']])) {
                                $this
                                    ->Flash
                                    ->success(__('{0} units of {1} were deducted from the inventory successfully', $entity->quantity, $productName->title));
                            } else {
                                $this->Flash->error(__('Failed to deduct {0} units of {1} from the total inventory. Please Try Again', $entity->quantity, $productName->title));
                                return $this->redirect(['action' => 'bulk_deduct']);
                            }
                            //exit loop: order qty satisfied
                            break;

                        } else if ($i != null) {
                            $inData['quantity'] = 0;
                            $this->Inventories->updateAll($inData, ['id' => $i['id']]);

                            $entityQuantity = abs($num);

                        }

                    }

                }

            }

            return $this->redirect(['action' => 'index']);
        }

        $products = $this
            ->Products
            ->find('list', ['limit' => 200]);
        $this->set(compact('products'));

    }

}
