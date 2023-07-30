<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use Cake\I18n\FrozenTime;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return Response|null
     * @throws ForbiddenException When a directory traversal attempt.
     * @throws MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {

//        When the notifications page is requested display stock notifications
        if ($this->request->is(['get']) && $this->request->getParam('_matchedRoute') == '/notifications') {

//         Use date 6 months from now to find expiring products
            $expiryDateReference = new FrozenTime('6 month', 'Australia/Melbourne');

//            today's date
            $dateToday = new FrozenTime('now', 'Australia/Melbourne');

//            Find expiring inventory items
            $this->loadModel('Inventories');
            $this->loadModel('Products');

            $expiringInventories = $this->Inventories
                ->find('all', ['contain' => ['Products']])
                ->where(['expiry_date <=' => $expiryDateReference])
                ->where(['quantity !=' => 0])
                ->select();

//            Find count of expiring records
            $expiringInventoriesTotal = $expiringInventories
                ->count();

            //  Find count of expired records
            $expiredInventoriesTotal = $this->Inventories
                ->find('all', ['contain' => ['Products']])
                ->where(['expiry_date <=' => $expiryDateReference])
                ->where(['expiry_date >=' => $dateToday])
                ->where(['quantity !=' => 0])
                ->count();

            if ($expiringInventoriesTotal == 0) {
                $this->Flash->success(__('There are no expiring inventory items'));
            }

            if ($expiredInventoriesTotal == 0) {
                $this->Flash->success(__('There are no expired inventory items'));
            }

            foreach ($expiringInventories as $inventory):

//                    show notification for expiring inventory items
                    if ($inventory->expiry_date >= $dateToday) {
//                   Display error message to alert of expiring stock
                        $this->Flash->error(__('Expiring Shipments: {0} units of {1} expiring {2}', $inventory->quantity, $inventory->product->title, $inventory->expiry_date), [

                            'params' => [
                                'id' => $inventory->id
                            ]
                        ]);

                    }

//                    show notification for expired inventory items
                    else {
                        //                   Display error message to alert of expiring stock
                        $this->Flash->error(__(' Shipment Expired: {0} units of {1} expired on {2}', $inventory->quantity, $inventory->product->title, $inventory->expiry_date), [

                            'params' => [
                                'id' => $inventory->id
                            ]
                        ]);

                    }

            endforeach;

//          Find all products
            $expiringInventories = $this->Products
                ->find()
                ->all();

//            count of low stocked items
            $total = 0;

//            for each low stocked record send a notification
            foreach ($expiringInventories as $product):
                if ($product->total_quantity < $product->rop) {

                    $this->Flash->error(__('Low Shipments: {0} units of {1}', $product->total_quantity, $product->title), [

                        'params' => [
                            'product' => $product->id
                        ]
                    ]);
                    $total++;
                }
            endforeach;

//                If there are no low stocked products confirm this with the user
            if ($total == 0) {
                $this->Flash->success(__('There are no low stocked Products'));
            }

//                Find all packagings
            $this->loadModel('Packagings');
            $expiringInventories = $this->Packagings
                ->find()
                ->all();

//            count of low stocked items
            $total = 0;

            // if the quantity in stock is lower than the reorder point
            foreach ($expiringInventories as $packaging):
                if ($packaging->total_quantity < $packaging->rop) {
                    // send a notification to alert this and include a link to the packaging item
                    $this->Flash->error(__('Low Shipments: {0} units of {1}', $packaging->total_quantity, $packaging->title), [

                        'params' => [
                            'packaging' => $packaging->id
                        ]
                    ]);
                    $total++;
                }
            endforeach;

            //                If there are no low stocked packaging confirm this with the user
            if ($total == 0) {
                $this->Flash->success(__('There are no low stocked Packaging'));
            }
        }


        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}
