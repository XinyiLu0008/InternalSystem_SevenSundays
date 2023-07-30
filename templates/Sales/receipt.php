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
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Table\Sale $sale
 */
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
            'title' => 'Order Info',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
        [
            'title' => 'Receipt',
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
            'title' => 'Place Order',
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
    $this->Breadcrumbs->add([
        [
            'title' => 'Order Receipt',
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
}

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);


echo $this->Breadcrumbs->render(); ?>

<?php if ($userRole == 'admin') { ?>
<div class="container-fluid">

    <div class="column-responsive column-80">
        <section class="content content_content" style="width: 70%; margin: auto;">
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <h2 class="d-block" style="color: #5D51AF; font-size: 1.5rem; font-weight: bold"><i class="fa fa-globe"></i>  SevenSundays</h2>

                        </h2>
                    </div><!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">

                        <address>
                            <strong>
                            </strong>
                        </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>
                                <?= $this->Html->link([$sale->user->first_name, " ",
                                    $sale->user->last_name], ['controller' => 'Users', 'action' => 'view', $sale->user->id]) ?> </strong>
                            <br>
                            <br>
                            Phone: <?= h($sale->user->phone) ?>
                         <br>
                            Email: <?= h($sale->user->email) ?>                               </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 invoice-col">

                        <br>
                        <b>Order ID:</b> # <?= h($sale->id) ?><br>
                        <b>Order Date:</b> <br><?= h($sale->sales_date) ?>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td><?= $this->Number->format($sale->quantity) ?></td>
                                <td><?php
                                    $productsTable = TableRegistry::getTableLocator()->get('Products');
                                    $resultsObject = $productsTable
                                        ->find()
                                        ->select(['title'])
                                        ->where(['id' => $sale->product_id])
                                        ->first(); ?>
                                    <?php

                                    $total = $sale->price;
                                    $q = $sale->quantity;
                                    $per= $total / $q;

                                    ?>
                                    <?= h($resultsObject["title"]) ?></td>
                                <td>$ <?= $this->Number->format(h($per) )?> AUD</td>
                                <td>$ <?= $this->Number->format(h($sale->price) )?> AUD</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>GST (10%)</td>
                                <td></td>
                                <?php

                                $gst=$total*0.1;
                                $payment=$total*0.1+$total;
                                ?>
                                <td>$ <?= $this->Number->format($gst) ?> AUD</td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-md-12">
                        <p class="lead"></p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>


                                <tr>
                                    <td><h6> <label style="font-weight:bold;">Total Payment:</label></h6> </td>
                                    <td><h6><label style="font-weight:bold;"> $ <?= $this->Number->format($payment) ?> AUD </label></h6></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Html->link(__('OK'), ['action' => 'index', $sale->id],
                            ['style'=>'width: 90%','padding: 10%' , 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>

                        <?= $this->Form->end() ?>
                    </div>



                </div>


            </section>
        </section>
    </div>







    <?php } else if ($userRole === 'customer') { ?>

    <div class="column-responsive column-80">
        <section class="content content_content" style="width: 70%; margin: auto;">
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold">
                                <a href="javascript:void(0);"><i class="fa fa-globe"></i>  SevenSundays</a></h2>

                        </h2>
                    </div><!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">

                        <address>
                            <strong>
                            </strong>
                        </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>
                                <?= $sale->user->first_name, " ",
                                    $sale->user->last_name ?> </strong>
                            <br>
                            <br>
                            Phone: <?= h($sale->user->phone) ?>
                            <br>
                            Email: <?= h($sale->user->email) ?>                               </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 invoice-col">

                        <br>
                        <b>Order ID:</b> # <?= h($sale->id) ?><br>
                        <b>Order Date:</b> <br><?= h($sale->sales_date) ?>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td><?= $this->Number->format($sale->quantity) ?></td>
                                <td><?php
                                    $productsTable = TableRegistry::getTableLocator()->get('Products');
                                    $resultsObject = $productsTable
                                        ->find()
                                        ->select(['title'])
                                        ->where(['id' => $sale->product_id])
                                        ->first(); ?>
                                    <?php
                                    $total = $sale->price;
                                    $q= $this->Number->format($sale->quantity);
                                    $per=$total/$q;

                                    ?>
                                    <?= h($resultsObject["title"]) ?></td>
                                <td>$ <?=h($per)?> AUD</td>
                                <td>$ <?= $this->Number->format($sale->price) ?> AUD</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>GST (10%)</td>
                                <td></td>
                                <td><?php

                                    $gst=$total*0.1;
                                    $payment=$total*0.1+$total;
                                    ?>
                                    $ <?=h($gst)?> AUD </td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-md-12">
                        <p class="lead"></p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>


                                <tr>
                                    <td><h6> <label style="font-weight:bold;">Total Payment:</label></h6> </td>
                                    <td><h6><label style="font-weight:bold;"> $ <?= $this->Number->format($payment) ?> AUD </label></h6></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Html->link(__('Confirm'), ['action' => 'index', $sale->id],
                            ['style'=>'width: 90%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>

                        <?= $this->Form->end() ?>
                    </div>



                </div>


            </section>
        </section>
    </div>
<?php } ?>
