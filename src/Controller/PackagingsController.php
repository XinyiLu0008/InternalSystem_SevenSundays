<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Packaging;
use App\Model\Table\PackagingsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

/**
 * Packagings Controller
 *
 * @property PackagingsTable $Packagings
 * @method Packaging[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class PackagingsController extends AppController
{
    //restrict customer access to packagings page
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $controller = 'Packagings';
        $this->set('controller', $controller);

        $identity = $this->getRequest()
            ->getAttribute('identity');
        //        $identity = $this->getRequest()->getAttribute('identity')->get('role');
        //        debug($identity);
        ////        exit();
        if ($identity == null) {
            $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else if ($identity->get('role') != 'admin') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this
                ->Flash
                ->error(__('You are not authorised to view packagings page'));
        }
    }

    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $controller = 'Sales';
        $this->set($controller);

        $this->paginate = ['contain' => ['Manufacturers'],];
        $packagings = $this->paginate($this->Packagings);

        $this->set(compact('packagings'));

        $key = $this
            ->request
            ->getQuery('key');
        if ($key) {
            $query = $this->paginate($this
                ->Packagings
                ->find('all', ['contain' => ['Manufacturers']])
                ->where(['Or' => ['title like' => '%' . $key . '%', 'type like' => '%' . $key . '%', 'sku like' => '%' . $key . '%', 'Manufacturers.name like' => '%' . $key . '%']]));
        } else {
            $query = $this->paginate($this
                ->Packagings
                ->find('all', ['contain' => ['Manufacturers']]), ['limit' => 20]);
        }
        $packagings = $query;

        $this->set(compact('packagings'));

        // if the quantity in stock is lower than the reorder point
        $userRole = $this->getRequest()
            ->getAttribute('identity')
            ->get('role');

        if (($userRole === 'admin')) {
            foreach ($packagings as $packaging):
                if ($packaging->total_quantity < $packaging->rop) {
                    // send a notification to alert this and include a link to the packaging item
                    $this
                        ->Flash
                        ->error(__('Low Shipments: {0} units of {1}', $packaging->total_quantity, $packaging->title), [

                            'params' => ['packaging' => $packaging->id]]);
                }
            endforeach;
        }
    }

    /**
     * View method
     *
     * @param string|null $id Packaging id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $packaging = $this
            ->Packagings
            ->get($id, ['contain' => ['Manufacturers', 'Products'],]);

        $this->set(compact('packaging'));
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $packaging = $this
            ->Packagings
            ->newEmptyEntity();
        if ($this
            ->request
            ->is('post')) {
            $packaging = $this
                ->Packagings
                ->patchEntity($packaging, $this
                    ->request
                    ->getData());

            //upload an image
            if (!$packaging->getErrors) {

                $image = $this
                    ->request
                    ->getData('image_file');

                $name = $image->getClientFilename();
                $targetPath = WWW_ROOT . 'img' . DS . $name;
                if ($name) $image->moveTo($targetPath);
                $packaging->image = $name;

            }
            if ($this
                ->Packagings
                ->save($packaging)) {
                $this
                    ->Flash
                    ->success(__('The packaging has been saved successfully.'));

                return $this->redirect(['action' => 'index']);
            }
            $this
                ->Flash
                ->error(__('The packaging could not be saved. Please, try again.'));
        }

        $manufacturers = $this
            ->Packagings
            ->Manufacturers
            ->find('list', ['limit' => 200]);
        $this->set(compact('packaging', 'manufacturers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Packaging id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $packaging = $this
            ->Packagings
            ->get($id, ['contain' => [],]);

        if ($this
            ->request
            ->is(['patch', 'post', 'put'])) {
            $packaging = $this
                ->Packagings
                ->patchEntity($packaging, $this
                    ->request
                    ->getData());

            //upload an image
            if ($packaging->getErrors) {
                $this
                    ->Flash
                    ->error(__('The file you uploaded was of the wrong type'));
            }
            else {

                $image = $this
                    ->request
                    ->getData('image_file');

                $name = $image->getClientFilename();
                $targetPath = WWW_ROOT . 'img' . DS . $name;
                if ($name) $image->moveTo($targetPath);
                $packaging->image = $name;

                if ($this
                    ->Packagings
                    ->save($packaging)) {
                    $this
                        ->Flash
                        ->success(__('The packaging has been updated successfully.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this
                    ->Flash
                    ->error(__('The packaging could not be saved. Please, try again.'));
            }
        }
        $manufacturers = $this
            ->Packagings
            ->Manufacturers
            ->find('list', ['limit' => 200]);
        $this->set(compact('packaging', 'manufacturers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Packaging id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this
            ->request
            ->allowMethod(['post', 'delete']);
        $packaging = $this
            ->Packagings
            ->get($id);
        if ($this
            ->Packagings
            ->delete($packaging)) {
            $this
                ->Flash
                ->success(__('The packaging has been deleted.'));
        } else {
            $this
                ->Flash
                ->error(__('The packaging could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



//    Add stock input to existing totals.
    public function bulkUpdate()
    {
//        create new entities for each row passed by packagings: bulkUpdate
        $entities = $this
            ->Packagings
            ->newEntities($this
                ->request
                ->getData());


        if ($this
            ->request
            ->is(['patch', 'post', 'put'])) {

//             for each row of the form
            foreach ($entities as $entity) {

//                 get the associated packaging from the id
                $packaging = $this
                    ->Packagings
                    ->get(strVal($entity["id"]));

//                 add the quantity from the form to the current packaging total quantity
                $entity["total_quantity"] = $entity["total_quantity"] + $packaging["total_quantity"];

                $query = $this
                    ->Packagings->query();
// update the current total quantity
                if ($query->update()
                    ->set(['total_quantity' => $entity["total_quantity"]])
                    ->where(['id' => $entity["id"]])
                    ->execute()) {
                    $this
                        ->Flash
                        ->success(__('The quantities have been updated.'));
// if this fails show this through an error


                } else {
                    $this
                        ->Flash
                        ->error(__('The packaging {0} could not be saved. Please, try again.', $entity->title));
                    return $this->redirect(['action' => 'index']);
                }

            }
            return $this->redirect(['action' => 'index']);

        }

        $packagings = $this
            ->Packagings
            ->find('list', ['limit' => 200]);
        $this->set(compact('packagings'));

    }

}

