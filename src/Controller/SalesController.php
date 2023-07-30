<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Product;
use App\Model\Entity\Sale;
use App\Model\Table\InventoriesTable;
use App\Model\Table\ProductsTable;
use App\Model\Table\SalesInventoriesTable;
use App\Model\Table\SalesTable;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;
use Exception;

/**
 * Sales Controller
 *
 * @property SalesTable $Sales
 * @property ProductsTable $Products
 * @method Sale[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        if ($this->request->getParam('action') == 'history') {
            $controller = "History";
            $this->set('controller', $controller);
        } else {
            $controller = 'Sales';
            $this->set('controller', $controller);
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
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');

        if ($userRole === 'admin') {
            if ($key) {
                $query = $this->paginate($this->Sales->find('all', ['contain' => ['Users']])
                    ->where(['Or' => ['status like' => '%' . $key . '%', 'Users.first_name like' => '%' . $key . '%',
                        'Users.last_name like' => '%' . $key . '%']]));
            } else {

                $query = $this->paginate($this->Sales->find('all', ['contain' => ['Users']])
                    ->where(['Or' => ['status like' => '%' . $key . '%', 'Users.first_name like' => '%' . $key . '%',
                        'Users.last_name like' => '%' . $key . '%']]));

            }

            $daysQuery = $this->request->getQuery('daysQuery');
            if (!$daysQuery) {
                $daysQuery = 30;
            }

            // date,  used to show recent orders since this date
            $startDate = new FrozenTime('-' . $daysQuery . ' days', 'Australia/Melbourne');

            // get the highest product_id from the sales table.
            $highestProductID = $this->Sales
                ->find()
                ->select(['product_id'])
                ->where(['sales_date >=' => $startDate])
                ->where(['status !=' => "canceled"])
                ->where(['status !=' => "pending"])
                ->order(['product_id' => 'DESC'])
                ->first();

            if (isset($highestProductID["product_id"])) {
                $maxID = $highestProductID["product_id"];
            } else {
                $maxID = 0;
            }


            //    retrieve all sales objects sorted by date ascending
            $chartSales = $this->Sales
                ->find()
                ->select(['sales_date', 'product_name', 'product_id', 'quantity'])
                ->where(['sales_date >=' => $startDate])
                ->where(['status !=' => "canceled"])
                ->where(['status !=' => "pending"])
                ->order(['sales_date' => 'ASC']);

            $sales = $query;
            $this->set(compact('sales', 'daysQuery', 'chartSales', 'maxID'));

        } else if ($userRole === 'customer') {
            $userID = $this->getRequest()->getAttribute('identity')->get('id');

            if ($key) {
                $query = $this->paginate($this->Sales->find('all', ['contain' => ['Users']])
                    ->where(['Sales.user_id' => $userID])
                    ->where(['status !=' => 'completed'])
                    ->where(['Or' => ['status like' => '%' . $key . '%', 'sales_date like' => '%' . $key . '%']]));
            } else {

                $query = $this->paginate($this->Sales->find('all', ['contain' => ['Users']])
                    ->where(['Sales.user_id' => $userID])
                    ->where(['status !=' => 'completed'])
                    ->where(['Or' => ['status like' => '%' . $key . '%', 'sales_date like' => '%' . $key . '%']]));

            }


            $products = $this->Sales->Products->find('list', ['limit' => 200]);
            $sales = $query;
            $this->set(compact('sales', 'products'));

        }
    }

    public function charts()
    {

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

        // get the highest product_id from the sales table.
        $resultsObject = $this->Sales
            ->find()
            ->select(['product_id'])
            ->where(['sales_date >=' => $date])
            ->where(['status !=' => "canceled"])
            ->where(['status !=' => "pending"])
            ->order(['product_id' => 'DESC'])
            ->first();

//        Set the max product Id to 0 if it is NULL
        if (isset($resultsObject["product_id"])) {
            $maxID = $resultsObject["product_id"];
        } else {
            $maxID = 0;
        }

        $sales = $this->Sales->find()->contain(['Users'])->where(['sales_date >=' => $date]);
        $this->set(compact('sales', 'labels', 'maxID', 'graphType', 'months'));


    }

    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        //restrict customer access to view only their orders
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole === 'admin') {
            $sale = $this->Sales->get($id, [
                'contain' => ['Users']]);
            $this->set(compact('sale', 'sale'));

        } else if ($userRole === 'customer') {
            $userID = $this->getRequest()->getAttribute('identity')->get('id');
//            $sale = $this->Sales->find('all')->where(['Sales.user_id' => $userID]);
            try {
                $sale = $this->Sales->get($id, [
                    'conditions' => ['Sales.user_id' => $userID],
                    'contain' => ['Users']
                ]);
                $this->set(compact('sale', 'sale'));
            } catch (Exception $e) {
                $this->Flash->error(__('Restricted view. You are not allowed to view this page.'));
                return $this->redirect(['action' => 'index']);
            }

        }
    }

    /*public function ajaxCheck(){
         $data = $_POST;
         $msg="";
         if (!isset($data['quantity']) || empty($data['quantity'])) {
             $msg = $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
             //$msg = "The sale order could not be saved. Please, try again.";
             echo $msg;exit;
         }
         if (!isset($data['status'])) {
             $msg = $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
             echo $msg;exit;
         }
         if (!isset($data['user_id']) || empty($data['user_id'])) {
             $msg = $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
             echo $msg;exit;
         }
         if (!isset($data['sales_date']) || empty($data['sales_date'])) {
             $msg = $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
             echo $msg;exit;
         }
         if (!isset($data['product_id']) || empty($data['product_id'])) {
             $msg = $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
             echo $msg;exit;
         }
         $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity'])->where(['product_id' => $data['product_id']]);

         $inventories = json_decode(json_encode($inventories), true);
         if (empty($inventories)) {
             $msg = $msg = $this->Flash->error(__('Running out of stock'));;
             //$msg = "Running out of stock.";
             echo $msg;exit;
         }
     }
 */
    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $_POST;

        if (!empty($data)) {
            if (!isset($data['quantity']) || empty($data['quantity'])) {

                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);

            }
            if (!isset($data['status'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
            if (!isset($data['user_id']) || empty($data['user_id'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
            if (!isset($data['sales_date']) || empty($data['sales_date'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
            if (!isset($data['product_id']) || empty($data['product_id'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
//            $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity'])->where(['product_id' => $data['product_id']]);
            $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => $data['product_id']]);


            $inventories = json_decode(json_encode($inventories), true);
            if (empty($inventories)) {
                $this->Flash->error(__('Running out of stock.'));
                return $this->redirect(['action' => 'add']);
            }

            //When adding new sales, if status is set to shipped, then qty will be deducted
            if ($data['status'] == 'shipped') {

                //check for expiry inventories records/batches
                //if expired inventories record exists, then do not deduct the expired qty
                for ($i = 0; $i < count($inventories); $i++) {
                    $getExpiry = $inventories[$i]['expiry_date'];

                    //get current time
                    $currentDate = FrozenDate::now()->toDateString();
//                    $year = $currentTime->year;


                    if ($getExpiry < $currentDate) {

                        unset($inventories[$i]);
//                        $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => $data['product_id']])
//                            ->where(['expiry_date <' => $year]);
//                        $inventories = json_decode(json_encode($inventories), true);

                    }

                }


                $totalqty = array_sum(array_column($inventories, 'quantity'));

                if ($data['quantity'] <= $totalqty) {
                    $q = $data['quantity'];

                    for ($i = 0; $i < count($inventories); $i++) {

                        $num = $inventories[$i]['quantity'] - $q;

                        if ($num >= 0) {
                            $inData['quantity'] = $num;
                            $this->Sales->Inventories->updateAll($inData, ['id' => $inventories[$i]['id']]);

                            break;
                        } else if ($inventories[$i] != null) {
                            $inData['quantity'] = 0;
                            $this->Sales->Inventories->updateAll($inData, ['id' => $inventories[$i]['id']]);

                            $q = abs($num);

                        }
                    }
                } else {
                    $this->Flash->error(__('Failed to save sale due to the order quantity exceeding the total inventory quantity.'));
                    return $this->redirect(['action' => 'index']);
                }
            }

            $product = $this->Sales->Products->find()->select(['price', 'title'])->where(['id' => $data['product_id']]);
            $product = json_decode(json_encode($product), true);


            for ($i = 0; $i < count($product); $i++) {

                $data['product_name'] = $product[$i]['title'];
                $data['product_price'] = $product[$i]['price'];
                $data['price'] = $data['product_price'] * $data['quantity'];

                unset($data['_csrfToken']);
                $sale = $this->Sales->newEmptyEntity();

                $sale = $this->Sales->patchEntity($sale, $data);
                $this->Sales->save($sale);
                $salesIn['sale_id'] = $sale->id;
                $salesIn['price'] = $data['price'];
                $salesIn['quantity'] = $data['quantity'];
                $salesIn['inventory_id'] = $inventories[$i]['id'];


                $salesInTable = new SalesInventoriesTable();
                $salesInObj = $salesInTable->newEmptyEntity();
                $salesInObj = $salesInTable->patchEntity($salesInObj, $salesIn);
                $data = $salesInTable->save($salesInObj);

                $sale = $this->Sales->get($sale->id, [
                    'contain' => ['Users'],
                ]);
            }


            $saleID = $data->sale_id;

            //send email to admin and retailer
            $userRole = $this->getRequest()->getAttribute('identity')->get('role');

            if ($userRole == 'admin') {
                $this->loadModel('Products');
                $product = $this->Products->find()->where(['id' => $sale->product_id])->first();
                // Send order confirmation email
                $mailer = new Mailer('default');
                // Setup email parameters
                $mailer
                    ->setEmailFormat('html')
                    ->setTo(Configure::read('sendEmail.to'))
                    ->setFrom(Configure::read('sendEmail.from'))
                    ->setSubject('New Order Notification for ' . h($sale->user->first_name) . " " . h($sale->user->last_name) . " <" . h($sale->user->email) . ">")
                    ->viewBuilder()
                    ->disableAutoLayout()
                    ->setTemplate('notification');

                // Send data to the email template
                $mailer->setViewVars([
                    'id' => $sale->id,
                    'first_name' => $sale->user->first_name,
                    'last_name' => $sale->user->last_name,
                    'email' => $sale->user->email,
                    'quantity' => $sale->quantity,
                    'price' => $sale->price,
                    'sales_date' => $sale->sales_date,
                    'title' => $product->title
                ]);
                //Send email
                $email_result = $mailer->deliver();
                if ($email_result) {
                    $this->Flash->success(__('A new order notification email with a reference no. of #' . $sale->id . ' has been sent to SevenSundays.'));
                } else {
                    $this->Flash->error(__('Email failed to send. Please try again later.'));
                }
                //end of email function
            } else if ($userRole == 'customer') {
                $this->loadModel('Products');
                $product = $this->Products->find()->where(['id' => $sale->product_id])->first();
                // Send order confirmation email
                $mailer = new Mailer('default');
                // Setup email parameters
                $mailer
                    ->setEmailFormat('html')
                    ->setTo($sale->user->email)
                    ->setFrom(Configure::read('sendEmail.from'))
                    ->setSubject('New Order Notification for ' . h($sale->user->first_name) . " " . h($sale->user->last_name) . " <" . h($sale->user->email) . ">")
                    ->viewBuilder()
                    ->disableAutoLayout()
                    ->setTemplate('customernotification');

                // Send data to the email template
                $mailer->setViewVars([
                    'id' => $sale->id,
                    'first_name' => $sale->user->first_name,
                    'last_name' => $sale->user->last_name,
                    'email' => $sale->user->email,
                    'quantity' => $sale->quantity,
                    'price' => $sale->price,
                    'sales_date' => $sale->sales_date,
                    'title' => $product->title
                ]);
                //Send email
                $email_result = $mailer->deliver();
                if ($email_result) {
                    $this->Flash->success(__('A new order email with a reference no. of #' . $sale->id . ' has been sent to your email.'));
                } else {
                    $this->Flash->error(__('Email failed to send. Please try again later.'));
                }
            }


            $this->Flash->success(__('The sale order details with a reference no. of #' . $sale->id . ' have been saved. The receipt can be check in the order detail.'));
            return $this->redirect(['action' => 'receipt', $saleID]);
//            exit;
        } else {
            $sale = $this->Sales->newEmptyEntity();
            if ($this->request->is('post')) {
                $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                $data = $this->Sales->save($sale);
                if ($data) {
                    $this->Flash->success(__('The sale order details have been saved.The receipt can be check in the order detail.'));

                    $saleID = $data->sale_id;
                    return $this->redirect(['action' => 'receipt', $saleID]);
                }
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
            }

            $users = $this->Sales->Users
                ->find('list', ['limit' => 200])
                ->select(['id', 'role'])
                ->where(['role  !=' => 'admin']);
            $products = $this->Sales->Products->find('list', ['limit' => 200])->select(['id', 'title'])->where(['availability =' => 'Available']);

            $loggedInUser = $this->request->getAttribute('authentication')->getIdentity();
            //get userID to transfer to view Sales/add
            $userID = $loggedInUser->get('id');
            $time = new FrozenTime('now', 'Australia/Melbourne');

            $this->set(compact('sale', 'users', 'products', 'userID', 'time'));
        }

    }


    /**
     * Edit method
     *
     * @param string|null $id Sale id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public
    function edit($id = null)
    {

        $data = $_POST;
        if (!empty($data)) {
            if (!isset($data['quantity']) || empty($data['quantity'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'edit']);
            }
            if (!isset($data['status'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'edit']);
            }
            if (!isset($data['user_id']) || empty($data['user_id'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'edit']);
            }
            if (!isset($data['sales_date']) || empty($data['sales_date'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'edit']);
            }
            if (!isset($data['product_id']) || empty($data['product_id'])) {
                $this->Flash->error(__('The sale order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'edit']);
            }
            $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity'])->where(['product_id' => $data['product_id']]);
            $inventories = json_decode(json_encode($inventories), true);
            if (empty($inventories)) {
                $this->Flash->error(__('Running out of stock.'));
                return $this->redirect(['action' => 'edit']);
            }


            $product = $this->Sales->Products->find()->select(['price', 'title'])->where(['id' => $data['product_id']]);
            $product = json_decode(json_encode($product), true);
            $data['product_name'] = $product[0]['title'];
            $data['product_price'] = $product[0]['price'];


            unset($data['_method']);
            unset($data['_csrfToken']);
            $this->Sales->updateAll($data, ['id' => $id]);

            $salesIn['price'] = $data['price'];
            $salesIn['quantity'] = $data['quantity'];
            $salesIn['inventory_id'] = $inventories[0]['id'];

            $salesInTable = new SalesInventoriesTable();
            $salesInTable->updateAll($salesIn, ['sale_id' => $id]);
            $this->Flash->success(__('The sale with a reference no. of #' . $id . ' has been updated.'));
            return $this->redirect(['action' => 'index']);

        } else {
            $sale = $this->Sales->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                if ($this->Sales->save($sale)) {
                    $this->Flash->success(__('The sale has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The sale could not be saved. Please, try again.'));
            }
            $users = $this->Sales->Users->find('list', ['limit' => 200]);

            $products = $this->Sales->Products->find('list', ['limit' => 200])->select(['id', 'title']);
            $this->set(compact('sale', 'users', 'products'));
        }

    }

    /**
     * Delete method
     *
     * @param string|null $id Sale id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public
    function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sale = $this->Sales->get($id);
        if ($this->Sales->delete($sale)) {
            $this->Flash->success(__('The sale order no # {0} has been deleted.', $sale->id));
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public
    function history()
    {
//        if a customer is logged in
        $key = $this->request->getQuery('key');
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');

        if ($userRole == 'customer') {
//            get the customers id
            $userID = $this->getRequest()->getAttribute('identity')->get('id');

// find all sales for this user

            $query = $this->paginate($this->Sales->find('all', ['contain' => ['Users']])
                ->where(['Sales.user_id' => $userID])
                ->where(['status =' => 'completed'])
                ->where(['Or' => ['status like' => '%' . $key . '%', 'sales_date like' => '%' . $key . '%']]));

            $sales = $query;
            $this->set(compact('sales'));
        }

//        if admin is logged in load all sales
        if ($userRole == 'admin') {
            $query = $this->paginate($this->Sales->find('all', ['contain' => ['Users']]), ['limit' => 20]);

            $sales = $query;
            $this->set(compact('sales'));

        }
    }

    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function receipt($id = null)
    {

        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole === 'admin') {
            $sale = $this->Sales->get($id, [
                'contain' => ['Users']]);
            $this->set(compact('sale', 'sale'));

        } else if ($userRole === 'customer') {
            $userID = $this->getRequest()->getAttribute('identity')->get('id');
            try {
                $sale = $this->Sales->get($id, [
                    'conditions' => ['Sales.user_id' => $userID],
                    'contain' => ['Users']
                ]);
                $this->set(compact('sale', 'sale'));
            } catch (Exception $e) {
                $this->Flash->error(__('Restricted view. You are not allowed to view this page.'));
                return $this->redirect(['action' => 'index']);
            }

        }
    }


    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function backup($id = null)
    {

        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole === 'admin') {
            $sale = $this->Sales->get($id, [
                'contain' => ['Users']]);
            $this->set(compact('sale', 'sale'));

        } else if ($userRole === 'customer') {
            $userID = $this->getRequest()->getAttribute('identity')->get('id');
            try {
                $sale = $this->Sales->get($id, [
                    'conditions' => ['Sales.user_id' => $userID],
                    'contain' => ['Users']
                ]);
                $this->set(compact('sale', 'sale'));
            } catch (Exception $e) {
                $this->Flash->error(__('Restricted view. You are not allowed to view this page.'));
                return $this->redirect(['action' => 'index']);
            }

        }
    }


    /**
     * @param string|null $id Sales id.
     * @return Response|null|void Redirects to index.
     */
    public
    function cancel($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Users'],
        ]);

        $saleStatus = $this->Sales->get($id)->status;
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($saleStatus === 'pending') {
                $sales = TableRegistry::getTableLocator()->get('Sales');
                $query = $sales->query();
                $query->update()
                    ->set(['status' => 'canceled'])
                    ->where(['id' => $id])
                    ->execute();

                $identity = $this->Authentication->getIdentity()->get('role');
                if ($identity === 'admin') {
                    $this->Flash->success(__('The order has been successfully cancel.'));
                } else if ($identity === 'customer') {
                    // Send order cancellation email to admin
                    $mailer = new Mailer('default');
                    // Setup email parameters
                    $mailer
                        ->setEmailFormat('html')
                        ->setTo(Configure::read('sendEmail.to'))
                        ->setFrom(Configure::read('sendEmail.from'))
                        ->setSubject('Order Cancellation for ' . h($sale->user->first_name) . " " . h($sale->user->last_name) . " <" . h($sale->user->email) . ">")
                        ->viewBuilder()
                        ->disableAutoLayout()
                        ->setTemplate('cancellation');

                    // Send data to the email template
                    $mailer->setViewVars([
                        'id' => $sale->id,
                        'first_name' => $sale->user->first_name,
                        'last_name' => $sale->user->last_name,
                        'email' => $sale->user->email,
                        'quantity' => $sale->quantity,
                        'price' => $sale->price,
                        'sales_date' => $sale->sales_date
                    ]);
                    //Send email
                    $email_result = $mailer->deliver();

                    if ($email_result) {
                        $this->Flash->success(__('The order cancellation email with a reference no. of #' . $sale->id . ' has been sent to Seven Sundays via email.'));
                    } else {
                        $this->Flash->error(__('Failed to send order cancellation email. Please check the order in the system later.'));
                    }

                }

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order with a reference no. of #' . $sale->id . ' could not be cancel. Only pending orders can be canceled.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    public function ship($id = null)
    {

        $sale = $this->Sales->get($id, [
            'contain' => ['Users'],
        ]);


        $saleStatus = $this->Sales->get($id)->status;
        if ($saleStatus === 'pending') {
//            $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity'])->where(['product_id' => $sale->product_id]);
            $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => $sale->product_id]);


            $inventories = json_decode(json_encode($inventories), true);
            if (empty($inventories)) {
                $this->Flash->error(__('Please Check the Product of the Sale'));
                return $this->redirect(['action' => 'index']);
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




            //get total product qty
            $totalqty = array_sum(array_column($inventories, 'quantity'));

            if ($sale->quantity <= $totalqty) {
                $sales = TableRegistry::getTableLocator()->get('Sales');
                $query = $sales->query();
                $query->update()
                    ->set(['status' => 'shipped'])
                    ->where(['id' => $id])
                    ->execute();

                $q = $sale->quantity;

                //start of FIFO
                foreach ($inventories as $i) {
                    //subtract the order's qty from each inventory qty

                    $num = $i['quantity'] - $q;

                    //base case of recursive loop
                    if ($num >= 0) {
                        $inData['quantity'] = $num;
                        $this->Sales->Inventories->updateAll($inData, ['id' =>  $i['id']]);
                        //exit loop: order qty satisfied
                        break;
                    } else if ($i != null) {
                        $inData['quantity'] = 0;
                        $this->Sales->Inventories->updateAll($inData, ['id' =>  $i['id']]);

                        $q = abs($num);


                    }

//                    $this->Sales->Inventories->updateAll($inData, ['id' => $inventories[$i + 1]['id']]);
                }
                $this->Flash->success(__('The order with a reference no. of #' . $sale->id . ' has successfully shipped.'));
                return $this->redirect(['action' => 'index']);
            } else if ($sale->quantity > $totalqty) {
                $this->Flash->error(__('Failed to shipped order due to the order quantity exceeding the total inventory quantity.'));
                return $this->redirect(['action' => 'index']);
            }

        }

        $this->set(compact('sale', 'sale'));
    }


    /**
     * @param string|null $id Sales id.
     * @return Response|null|void Redirects to index.
     */
    public
    function requestforreturn($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Users'],
        ]);

        $saleStatus = $this->Sales->get($id)->status;
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($saleStatus === 'shipped') {

                $identity = $this->Authentication->getIdentity()->get('role');
                if ($identity === 'customer') {
                    // Send order return email
                    $mailer = new Mailer('default');
                    // Setup email parameters
                    $mailer
                        ->setEmailFormat('html')
                        ->setTo(Configure::read('sendEmail.to'))
                        ->setFrom(Configure::read('sendEmail.from'))
                        ->setSubject('Request for Order Return from ' . h($sale->user->first_name) . " " . h($sale->user->last_name) . " <" . h($sale->user->email) . ">")
                        ->viewBuilder()
                        ->disableAutoLayout()
                        ->setTemplate('return');

                    // Send data to the email template
                    $mailer->setViewVars([
                        'id' => $sale->id,
                        'first_name' => $sale->user->first_name,
                        'last_name' => $sale->user->last_name,
                        'email' => $sale->user->email,
                        'quantity' => $sale->quantity,
                        'price' => $sale->price,
                        'sales_date' => $sale->sales_date
                    ]);
                    //Send email
                    $email_result = $mailer->deliver();
                    if ($email_result) {
                        $sales = TableRegistry::getTableLocator()->get('Sales');
                        $query = $sales->query();
                        $query->update()
                            ->set(['status' => 'requested'])
                            ->where(['id' => $id])
                            ->execute();

                        $this->Flash->success(__('The status of the order with a reference no. of #' . $sale->id . ' has been changed to requested and the request for order return email has been sent to SevenSundays.'));
                    } else {
                        $this->Flash->error(__('Failed to send the request for order return email. Please check the order in the system later. '));
                    }
                }
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->Flash->error(__('The order could not be request for return. Only received orders can request for return.'));
            return $this->redirect(['action' => 'index']);
        }

    }


    /**
     * @param string|null $id Sales id.
     * @return Response|null|void Redirects to index.
     */
    public
    function return($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Users', 'Inventories'],
        ]);
        $saleBooking = $this->Sales->get($id)->status;
        if ($saleBooking === 'requested') {
//        $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => $sale->product_id]);
//        $inventories = json_decode(json_encode($inventories), true);

            //the commented code below is for adding back qty to packagings
//        $packagings = $this->Sales->Inventories->Products->Packagings->find()->select(['id', 'total_quantity'])->where(['id' => $products[0]['packaging_id']]);
//        $packagings = json_decode(json_encode($packagings), true);

            $products = $this->Sales->Inventories->Products->find()->select(['id', 'shelf_life', 'packaging_id'])->where(['id' => $sale->product_id]);
            $products = json_decode(json_encode($products), true);

            $salesInventories = $sale->inventories;
            //check for expiry inventories records/batches
            for ($i = 0; $i < count($salesInventories); $i++) {
                $getExpiry = $salesInventories[$i]['expiry_date'];

                //get current time
                $currentDate = FrozenDate::now()->toDateString();
                if ($getExpiry < $currentDate) {
                    unset($salesInventories[$i]);
                }
            }


            //if the order being returned does not exist in inventories, create a new record in inventories
            if ($salesInventories == null) {
                //get current time
                $currentDate = FrozenDate::now()->toDateString();
                $inventoriesIn['received_date'] = $currentDate;
                $inventoriesIn['quantity'] = $sale->quantity;
                $expiryDate = FrozenDate::now()->addYears($products[0]['shelf_life'])->toDateString();
                $inventoriesIn['expiry_date'] = $expiryDate;
                $inventoriesIn['lifetime'] = $products[0]['shelf_life'];
                $inventoriesIn['product_id'] = $products[0]['id'];


                $inventoriesInTable = new InventoriesTable();
                $inventoriesInObj = $inventoriesInTable->newEmptyEntity();
                $inventoriesInObj = $inventoriesInTable->patchEntity($inventoriesInObj, $inventoriesIn);
                $inventoriesInTable->save($inventoriesInObj);

                $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => $sale->product_id]);
                $inventories = json_decode(json_encode($inventories), true);


                $salesIn['sale_id'] = $sale->id;
                $salesIn['price'] = $sale->price;
                $salesIn['quantity'] = $sale->quantity;
                $salesIn['inventory_id'] = $inventories[0]['id'];

                $salesInTable = new SalesInventoriesTable();
                $salesInObj = $salesInTable->newEmptyEntity();
                $salesInObj = $salesInTable->patchEntity($salesInObj, $salesIn);
                $salesInTable->save($salesInObj);

//            $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])->where(['product_id' => $sale->product_id]);
//            $inventories = json_decode(json_encode($inventories), true);


                if ($this->request->is(['patch', 'post', 'put'])) {
                    //get total product qty
                    $totalqty = array_sum(array_column($inventories, 'quantity'));

                    if ($sale->quantity <= $totalqty || $sale->quantity >= $totalqty) {
                        //add back product qty to inventories
//                        $q = $sale->quantity;
                        $num = $inventories[0]['quantity'];
                        $inData['quantity'] = $num;
                        $this->Sales->Inventories->updateAll($inData, ['id' => $inventories[0]['id']]);
                        $this->Flash->success(__('The order with a reference no. of #' . $sale->id . ' has been successfully returned.'));
                    } else {
                        $this->Flash->error(__('The order could not be return.'));
                    }
                }
            } else {
                $inventories = $this->Sales->Inventories->find()->select(['id', 'quantity', 'expiry_date'])
                    ->where(['product_id' => $sale->product_id])
                    ->where(['id' => $sale->inventories[0]['id']]);
                $inventories = json_decode(json_encode($inventories), true);
                //check for expiry inventories records/batches
                //if expired inventories record exists, then do not add back the expired qty record
                for ($i = 0; $i < count($inventories); $i++) {
                    $getExpiry = $inventories[$i]['expiry_date'];

                    //get current time
                    $currentDate = FrozenDate::now()->toDateString();
                    if ($getExpiry < $currentDate) {
                        unset($inventories[$i]);
                    }
                }

                if ($this->request->is(['patch', 'post', 'put'])) {
                    //get total product qty
                    $totalqty = array_sum(array_column($inventories, 'quantity'));

                    if ($sale->quantity <= $totalqty || $sale->quantity >= $totalqty) {
//                        $salesInventories = $sale->inventories;

                        //add back product qty to inventories
                        $q = $sale->quantity;
                        $num = $inventories[0]['quantity'] + $q;
                        $inData['quantity'] = $num;
                        $this->Sales->Inventories->updateAll($inData, ['id' => $inventories[0]['id']]);

                        //add back packaging qty to packagings
//                    $num2 = $packagings[0]['total_quantity'] + $q;
//                    $inData2['total_quantity'] = $num2;
//                    $this->Sales->Inventories->Products->Packagings->updateAll($inData2, ['id' => $packagings[0]['id']]);
                        $this->Flash->success(__('The order with a reference no. of #' . $sale->id . ' has been successfully returned.'));
                    } else {
                        $this->Flash->error(__('The order could not be return.'));
                    }
                }
            }

            //update the status to returned
            $sales = TableRegistry::getTableLocator()->get('Sales');
            $query = $sales->query();
            $query->update()
                ->set(['status' => 'returned'])
                ->where(['id' => $id])
                ->execute();

            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Failed to return order. Only order with a status of Requested can return order.'));
            return $this->redirect(['action' => 'index']);
        }
    }


    /**
     * @param string|null $id Sales id.
     * @return Response|null|void Redirects to index.
     */
    public
    function reject($id = null)
    {

        $saleBooking = $this->Sales->get($id)->status;
        if ($saleBooking === 'requested') {
            //update the status to rejected
            $sales = TableRegistry::getTableLocator()->get('Sales');
            $query = $sales->query();
            $query->update()
                ->set(['status' => 'rejected'])
                ->where(['id' => $id])
                ->execute();
            $this->Flash->success(__('The order return with a reference no. of #' . $id . ' has been successfully rejected.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Failed to reject order return. Only order with a status of Requested can be rejected.'));
            return $this->redirect(['action' => 'index']);
        }

    }

}
