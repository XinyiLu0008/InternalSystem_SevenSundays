<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Webpage;
use App\Model\Table\WebpagesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Webpages Controller
 *
 * @property WebpagesTable $Webpages
 * @method Webpage[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class WebpagesController extends AppController
{

    //restrict customer access to webpages page
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $controller = 'Webpages';
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
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $webpages = $this->paginate($this->Webpages);

        $this->set(compact('webpages'));
    }

    /**
     * View method
     *
     * @param string|null $id Webpage id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $webpage = $this->Webpages->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('webpage'));
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $webpage = $this->Webpages->newEmptyEntity();
        if ($this->request->is('post')) {
            $webpage = $this->Webpages->patchEntity($webpage, $this->request->getData());
            if ($this->Webpages->save($webpage)) {
                $this->Flash->success(__('The webpage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The webpage could not be saved. Please, try again.'));
        }
        $this->set(compact('webpage'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Webpage id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $webpage = $this->Webpages->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $webpage = $this->Webpages->patchEntity($webpage, $this->request->getData());
            if (!$webpage->getErrors) {
                $image = $this->request->getData('image_file');

                $name = $webpage->title . '.png';
                $targetPath = WWW_ROOT . 'img' . DS . $name;

                if ($name)
                    $image->moveTo($targetPath);

                $webpage->image = $name;

                if ($this->Webpages->save($webpage)) {
                    $this->Flash->success(__('The webpage has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The webpage could not be saved. Please, try again.'));
            }


        }


        $this->set(compact('webpage'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Webpage id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $webpage = $this->Webpages->get($id);
        if ($this->Webpages->delete($webpage)) {
            $this->Flash->success(__('The webpage has been deleted.'));
        } else {
            $this->Flash->error(__('The webpage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
