<?php
/**
 * @var AppView $this
 * @var Sale[]|CollectionInterface $sales
 */

use App\Model\Entity\Sale;
use Cake\ORM\TableRegistry;


/**
 * @var AppView $this
 * @var Inventory[]|CollectionInterface $inventories
 */

use App\Model\Entity\Inventory;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\I18n\FrozenTime;


?>


<?php
$userRole = $this
    ->Identity
    ->get('role');
if ($userRole === 'customer') {
    $this->layout = 'customerLayout';
}

?>


<?php

$userRole = $this->Identity->get('role');

if ($userRole === 'admin') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);


    $this->Breadcrumbs->add([
        [

            'title' => 'Sales',
            'url' => ['controller' => 'sales', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Order Detail',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
    ]);
}

if ($userRole === 'customer') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'retailer_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);


    $this->Breadcrumbs->add([
        [

            'title' => 'My Order',
            'url' => ['controller' => 'sales', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Order Detail',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
    ]);
}

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);


echo $this->Breadcrumbs->render(); ?>

<?php if ($userRole == 'admin') { ?>
<div class="container-fluid">

    <div class="column-responsive column-80">
        <div class="sales view content">
            <div class="search-list">
                <div class="userData ml-3">
                    <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Order Detail</h2>
                    <div class="text-left">
                        <div class="col-xs-12">


                        </div>
                    </div>
                </div>


                <table class="table" id="myTable">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th> <i class="fa fa-credit-card"></i>
                            <?= $this->Html->link(__('receipt'), ['label' => 'Receipt','action' => 'backup', $sale->id]) ?></th>
                    </tr>
                    </thead>
                    <tbody>


                    <tr>
                        <td><h6 style="font-weight:bold;"><?= __('Reference No.') ?></h6></td>
                        <td>  <h6><?= h($sale->id) ?></h6>

                        </td>
                    </tr>

                    <tr>
                        <td><h6 style="font-weight:bold;"><?= __('Sales Date') ?></h6></td>
                        <td><h6><?= h($sale->sales_date) ?></h6></td>
                    </tr>
                    <tr>
                        <td><h6 style="font-weight:bold;"><?= __('User') ?></h6></td>
                        <td>

                            <h6> <?= $this->Html->link([$sale->user->first_name, " ", $sale->user->last_name],
                                ['controller' => 'Users', 'action' => 'view', $sale->user->id]) ?></h6></td>
                    </tr>

                    <tr>
                        <td><h6 style="font-weight:bold;"><?= __('Product') ?></h6></td>
                        <?php
                        $productsTable = TableRegistry::getTableLocator()->get('Products');
                        $resultsObject = $productsTable
                            ->find()
                            ->select(['title'])
                            ->where(['id' => $sale->product_id])
                            ->first(); ?>

                                 <td><h6><?= h($resultsObject["title"]) ?></h6></td>
                    </tr>


                    <tr>
                        <td><h6 style="font-weight:bold;"><?= __('Ordered Quantity') ?></h6></td>
                        <td><h6><?= $this->Number->format($sale->quantity) ?> units</h6></td>
                    </tr>
                    <tr>
                        <td><h6 style="font-weight:bold;"><?= __('Total Payment') ?></h6></td>
                        <td>  <h6>$ <?= $this->Number->format($sale->price) ?> AUD</h6>

                        </td>
                    </tr>

                    <tr >
                        <td colspan="1"></td>
                        <td>


                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sale->id],
                                ['confirm' => __('Are you sure you want to delete the order of Reference No# {0}?', $sale->id),
                                    'class' => ' button float-left  btn btn-danger']) ?>
                        </td>

                        </form>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>




    <?php } else if ($userRole === 'customer') { ?>


    <div class="container-fluid">

        <div class="column-responsive column-80">
            <div class="sales view content">
                <div class="search-list">
                    <div class="userData ml-3">
                        <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Order Detail</h2>
                        <div class="text-left">
                            <div class="col-xs-12">


                            </div>
                        </div>
                    </div>


                    <table class="table" id="myTable">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th> <i class="fa fa-credit-card"></i>
                                <?= $this->Html->link(__('receipt'), ['label'=> 'Receipt','action' => 'backup', $sale->id]) ?></th>
                        </tr>
                        </thead>
                        <tbody>


                        <tr>
                            <td><h6 style="font-weight:bold;"><?= __('Reference No.') ?></h6></td>
                            <td>  <h6><?= h($sale->id) ?></h6>

                            </td>
                        </tr>

                        <tr>
                            <td><h6 style="font-weight:bold;"><?= __('Sales Date') ?></h6></td>
                            <td><h6><?= h($sale->sales_date) ?></h6></td>
                        </tr>


                        <tr>
                            <td><h6 style="font-weight:bold;"><?= __('Product') ?></h6></td>
                           <td><h6><?= h($sale->product_name) ?></h6></td>
                        </tr>


                        <tr>
                            <td><h6 style="font-weight:bold;"><?= __('Ordered Quantity') ?></h6></td>
                            <td><h6><?= $this->Number->format($sale->quantity) ?> units</h6></td>
                        </tr>
                        <tr>
                            <td><h6 style="font-weight:bold;"><?= __('Total Payment') ?></h6></td>
                            <td>  <h6>$ <?= $this->Number->format($sale->price) ?> AUD</h6>

                            </td>
                        </tr>

                        <?php if ($sale->status == 'completed') { ?>
                        <tr>
                            <td><h6 style="font-weight:bold;"> <label style="font-weight:bold;"><i class="fa fa-star" aria-hidden="true"></i> Order Status</label></h6></td>
                            <td> <h6><label style="font-weight:bold;"><?= h($sale->status) ?></label></h6>

                            </td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td><h6 style="font-weight:bold;"><i class="fa fa-spinner" aria-hidden="true"></i> <label style="font-weight:bold;">Order Status</label></h6></td>
                            <td> <h6><label style="font-weight:bold;"><?= h($sale->status) ?></label></h6>

                            </td>
                        </tr>
                        <?php } ?>

                            </form>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

<?php } ?>


