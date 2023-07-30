<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Product;
use App\Model\Table\ProductsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;
use Cake\Core\Configure;

/**
 * Products Controller
 *
 * @property ProductsTable $Products
 * @method Product[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        $controller = 'Products';
        $this->set('controller', $controller);

        //calculation for total qty
        $inventories = $this->Products->Inventories->find();
        $inventories->select(['sum' => $inventories->func()->sum('quantity'), 'product_id'])->group('product_id');

        $inventories = $inventories->toList();

//        $countInventories = $this->Products->Inventories->find();
//        $countInventories = $countInventories->toArray();

        $p = $this->Products->find();
        $p = $p->toList();

        for ($i = 0; $i < count($p); $i++) {
            $reset['total_quantity'] = 0;
            $this->Products->updateAll($reset, ['id' => $p[$i]['id']]);
        }

        for ($i = 0; $i < count($inventories); $i++) {

//            $qty = $this->Products->Inventories->find('all')->where(['product_id' => $p[$i]['id']]);
//            $qty = $qty->toArray();
            //retrieve qty from the sorted array
//            $qty = array_sum(array_column($qty, 'quantity'));
//            debug($inventories);

            if ($inventories != null) {
                $inData['total_quantity'] = $inventories[$i]['sum'];
                $this->Products->updateAll($inData, ['id' => $inventories[$i]['product_id']]);
            }


        }
    }


    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        //search box
        $key = $this->request->getQuery('key');

        $userRole = $this->getRequest()->getAttribute('identity')->get('role');

        if (($userRole === 'admin')) {

            if ($key) {
                $query = $this->paginate($this->Products->find('all', ['contain' => ['CategoriesProducts','Manufacturers', 'Packagings']])
                    ->where(['Or' => ['Products.title like' => '%' . $key . '%', 'Products.sku like' => '%' . $key . '%', 'CategoriesProducts.name like' => '%' . $key . '%',
                        'Manufacturers.primary_contact_name like' => '%' . $key . '%', 'Packagings.title like' => '%' . $key . '%']]));
            }
            else {
                $query = $this->paginate($this->Products->find('all', ['contain' => ['CategoriesProducts', 'Manufacturers', 'Packagings']]), ['limit' => 20]);
            }


            $productNotifications = $this->Products->find()
                ->select(['id', 'total_quantity', 'title', 'rop'])
                ->where([
                    'total_quantity <= rop'
                ]);

            foreach ($productNotifications as $product):
                if ($product->total_quantity < $product->rop) {

                    $this->Flash->error(__('Low Shipments: {0} units of {1}', $product->total_quantity, $product->title), [

                        'params' => [
                            'product' => $product->id
                        ]
                    ]);
                }
            endforeach;

            $products = $query;
            $this->set(compact('products'));

        }
        if ($userRole == 'customer') {


            $key = $this->request->getQuery('key');
            if ($key) {
                $query = $this->paginate($this->Products->find('all', ['contain' => ['CategoriesProducts','Manufacturers', 'Packagings']])
                    ->where([
                        'availability' => 'available'
                    ])
                    ->where(['Or' => ['Products.title like' => '%' . $key . '%', 'Products.sku like' => '%' . $key . '%', 'CategoriesProducts.name like' => '%' . $key . '%',
                        'Manufacturers.primary_contact_name like' => '%' . $key . '%', 'Packagings.title like' => '%' . $key . '%']]));
            }
            else {
                $query = $this->paginate($this->Products->find('all', ['contain' => ['CategoriesProducts', 'Manufacturers', 'Packagings']])
                    ->where([
                        'availability' => 'available'
                    ]), ['limit' => 20]);

            }

            $products = $query;

            $this->set(compact('products'));

        }

    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public
    function view($id = null)
    {

        $product = $this->Products->get($id, [
            'contain' => ['CategoriesProducts', 'Packagings', 'Manufacturers', 'Inventories'],
        ]);

        $userRole = $this->getRequest()->getAttribute('identity')->get('role');

        if (($userRole === 'admin')) {

            if ($this->request->getQuery('type') == 'Quantity') {
                $graphType = 'Quantity';

            } else {
                $graphType = 'Revenue';
            }
            $months = $this->request->getQuery('Months');
            if (!isset($months) || $months == 0) {
                $months = 12;
            }

//      Create Array for Labels: Months Leading up to current month
            $date = new FrozenTime('now', 'Australia/Melbourne');
            $labels = [];
            for ($i = 0; $i > -$months; $i--) {

                $month = $date->month;

                switch ($month) {
                    case 1:
                        array_push($labels, "January " . $date->year);
                        break;
                    case 2:
                        array_push($labels, "February " . $date->year);

                        break;
                    case 3:
                        array_push($labels, "March " . $date->year);

                        break;
                    case 4:
                        array_push($labels, "April " . $date->year);

                        break;
                    case 5:
                        array_push($labels, "May " . $date->year);

                        break;
                    case 6:
                        array_push($labels, "June " . $date->year);

                        break;
                    case 7:
                        array_push($labels, "July " . $date->year);

                        break;
                    case 8:
                        array_push($labels, "August " . $date->year);

                        break;
                    case 9:
                        array_push($labels, "September " . $date->year);

                        break;
                    case 10:
                        array_push($labels, "October " . $date->year);

                        break;
                    case 11:
                        array_push($labels, "November " . $date->year);

                        break;
                    case 12:
                        array_push($labels, "December " . $date->year);

                        break;
                }
                $date = $date->modify('-1 month');
            }
            $labels = array_reverse($labels);

            $this->loadModel('Sales');

            $sales = $this->Sales->find()->contain(['Users'])
                ->select(['quantity', 'price', 'product_name', 'sales_date'])
                ->where(['product_id >=' => $id])
                ->where(['sales_date >=' => $date])
                ->where(['status !=' => "canceled"])
                ->where(['status !=' => "pending"]);


            $this->set(compact('sales', 'labels', 'graphType', 'months'));
        }
        $this->set(compact('product'));

    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public
    function add()
    {
        //restrict customer access to add new products
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to add products'));
        } else {
            $product = $this->Products->newEmptyEntity();
            if ($this->request->is('post')) {
                $product = $this->Products->patchEntity($product, $this->request->getData());

                //upload an image
                if (!$product->getErrors) {

                    $image = $this->request->getData('image_file');

                    $name = $image->getClientFilename();
                    $targetPath = WWW_ROOT . 'img' . DS . $name;
                    if ($name)
                        $image->moveTo($targetPath);
                    $product->image = $name;

                }

//                find its related packaging
                $packagings = TableRegistry::getTableLocator()->get('Packagings');
                // Start a new query.
                $query = $packagings->find()
                    ->where(['id' => $product['packaging_id']])
                    ->first();
// if the dimensions of the product are bigger than its packaging throw an error
                if ($query['height'] < $product['height'] || $query['length'] < $product['length'] || $query['width'] < $product['width']) {
                    $this->Flash->error(__('The dimensions of your product are too large for the select packaging, please check your selection again'));
                } else {

                    if ($this->Products->save($product)) {
                        $this->Flash->success(__('The new product has been saved successfully.'));
                        if ($product->total_quantity < $product->rop) {
                            $this->Goods_sentEmail();
                        }
                        return $this->redirect(['action' => 'index']);
                    }

                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                }
            }

            $packagings = $this->Products->Packagings->find('list', ['limit' => 200])->order(['title' => 'DESC']);
            $manufacturers = $this->Products->Manufacturers->find('list', ['limit' => 200])->order(['name' => 'ASC']);
            $categoriesProducts = $this->Products->CategoriesProducts->find('list', ['limit' => 200]) ->order(['name' => 'ASC']);;
            $this->set(compact('product', 'packagings', 'manufacturers', 'categoriesProducts'));
        }
    }

    public function Goods_sentEmail()
    {

        $product = $this->Products->newEmptyEntity();
        $product = $this->Products->patchEntity($product, $this->request->getData());


        $mailer = new Mailer('default');
        $mailer
            ->setEmailFormat('html')
            ->setTo(Configure::read('sendEmail.to'))
            ->setFrom(Configure::read('sendEmail.from'))
            ->setSubject('Low Stock Reminder')
            ->viewBuilder()
            ->disableAutoLayout()
            ->setTemplate('lowstock');


        $mailer->setViewVars([
            'id' => $product->id,
            'product' => $product->title,

        ]);
        $email_result = $mailer->deliver();

        if ($email_result) {
            $this->Flash->success(__('A low stock reminder email has been sent to your email account.'));
        } else {
            $this->Flash->error(__('Email failed to send. Please try again later.'));
        }

    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public
    function edit($id = null)
    {
        //restrict customer access to edit products
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to edit products'));
        } else {
            $product = $this->Products->get($id);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $product = $this->Products->patchEntity($product, $this->request->getData());
                $image = $this->request->getData('image_file');

                $name = $image->getClientFilename();
                if ($name != "") {
                    $targetPath = WWW_ROOT . 'img' . DS . $name;
                    if ($name)
                        $image->moveTo($targetPath);
                    $product->image = $name;
                }

                $packagings = TableRegistry::getTableLocator()->get('Packagings');
                // Start a new query.
                $query = $packagings->find()
                    ->where(['id' => $product['packaging_id']])
                    ->first();

                if ($query['height'] < $product['height'] || $query['length'] < $product['length'] || $query['width'] < $product['width']) {
                    $this->Flash->error(__('The dimensions of your product are too large for the select packaging, please check your selection again'));
                } else {


                    //print_r($product);
                    //exit;

                    if ($this->Products->save($product)) {
                        $this->Flash->success(__('The {0} has been updated successfully.', $product->title));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                }
            } else {

            }
            $packagings = $this->Products->Packagings->find('list', ['limit' => 200]);
            $manufacturers = $this->Products->Manufacturers->find('list', ['limit' => 200]);
            $categoriesProducts = $this->Products->CategoriesProducts->find('list', ['limit' => 200]);
            $this->set(compact('product', 'packagings', 'manufacturers', 'categoriesProducts'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public
    function delete($id = null)
    {
        //restrict customer access to delete products
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to delete products'));
        } else {
            $this->request->allowMethod(['post', 'delete']);
            $product = $this->Products->get($id);
            if ($this->Products->delete($product)) {
                $this->Flash->success(__('The {0} has been deleted.', $product->title));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', $product->title));
            }

            return $this->redirect(['action' => 'index']);
        }
    }
}
