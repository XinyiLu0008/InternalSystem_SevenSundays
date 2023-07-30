<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CategoriesProducts Controller
 *
 * @property \App\Model\Table\CategoriesProductsTable $CategoriesProducts
 * @method \App\Model\Entity\CategoriesProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesProductsController extends AppController
{
    //restrict customer access to categories page
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $controller = 'Categories';
        $this->set('controller', $controller);

        parent::beforeFilter($event);
        $identity = $this->getRequest()->getAttribute('identity');
        if ($identity == null) {
            $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else if ($identity->get('role') != 'admin') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to view categories page'));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $categoriesProducts = $this->paginate($this->CategoriesProducts);

        $this->set(compact('categoriesProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Categories Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoriesProduct = $this->CategoriesProducts->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('categoriesProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //for fixing nullentity error
        $this->loadModel('CategoriesProducts');
        $categoriesProduct = $this->CategoriesProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $categoriesProduct = $this->CategoriesProducts->patchEntity($categoriesProduct, $this->request->getData());
            if ($this->CategoriesProducts->save($categoriesProduct)) {
                $this->Flash->success(__('The category of {0} has been saved successfully.',$categoriesProduct->name));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categories product could not be saved. Please, try again.'));
        }
        $this->set(compact('categoriesProduct'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categories Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriesProduct = $this->CategoriesProducts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriesProduct = $this->CategoriesProducts->patchEntity($categoriesProduct, $this->request->getData());
            if ($this->CategoriesProducts->save($categoriesProduct)) {
                $this->Flash->success(__('The category of {0} has been updated successfully.',$categoriesProduct->name));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categories product could not be saved. Please, try again.'));
        }
        $this->set(compact('categoriesProduct'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categories Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriesProduct = $this->CategoriesProducts->get($id);
        if ($this->CategoriesProducts->delete($categoriesProduct)) {
            $this->Flash->success(__('The category of {0} has been deleted.',$categoriesProduct->name));
        } else {
            $this->Flash->error(__('The categories product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
