<?php
/**
 * @var AppView $this
 * @var Sale[]|CollectionInterface $sales
 */

use App\Model\Entity\Inventory;
use App\Model\Entity\Sale;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;


/**
 * @var AppView $this
 * @var Inventory[]|CollectionInterface $inventories
 */


?>

<?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.css', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]); ?>


<?php
$userRole = $this
    ->Identity
    ->get('role');
if ($userRole === 'customer') {
    $this->layout = 'customerLayout';
} ?>

<?php
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
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
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
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
}


$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render(); ?>


<div class="container-fluid">
    <div class="sales index content">

        <?php
        $userRole = $this->Identity->get('role');
        if ($userRole === 'admin') { ?>
            <?= $this->Html->link(__('Add a Sale Order'), ['action' => 'add'], [
                'class' => 'button float-right  btn btn-sm btn-primary shadow-sm', 'style' => 'margin: 15px']) ?>
            <?= $this->Html->link(__('Charts'), ['action' => 'charts'], ['style' => 'margin: 15px', 'class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
            <br>
            <h3><?= __('Sales') ?></h3>

        <?php } ?>

        <?php
        if ($userRole === 'customer') {
            ?>

            <h3><?= __('My Orders') ?></h3>

        <?php } ?>


        <div class="card shadow mb-4 ">
            <div class="card-header py-3 d-flex">
                <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0']) ?>
                <?= $this->Form->input('key', ['label' => 'Search', 'class' => 'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <!--For admin-->
        <?php
        $userRole = $this->Identity->get('role');
        if ($userRole === 'admin') { ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'Reference No.') ?></th>
                        <th><?= $this->Paginator->sort('Product') ?></th>
                        <th><?= $this->Paginator->sort('users_id') ?></th>
                        <th><?= $this->Paginator->sort('quantity') ?></th>
                        <th><?= $this->Paginator->sort('status') ?></th>

                        <th><?= $this->Paginator->sort('Total Price') ?></th>
                        <th><?= $this->Paginator->sort('sales_date') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= h($sale->id) ?></td>

                            <td><?= h($sale->product_name) ?> </td>

                            <td><?= $sale->has('user') ? $this->Html->link([$sale->user->first_name, " ",
                                    $sale->user->last_name], ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                            <td><?= $this->Number->format($sale->quantity) ?></td>
                            <td><?= h($sale->status) ?></td>

                            <td>$<?= $this->Number->format($sale->price) ?> AUD</td>
                            <td><?= h($sale->sales_date) ?></td>

                            <td class="actions">
                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['action' => 'view', $sale->id],
                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>

                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $sale->id],
                                    ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['action' => 'delete', $sale->id],
                                    ['confirm' => __('Are you sure you want to delete the order no # {0}?', $sale->id), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>

                                <?php if ($sale->status == 'pending') { ?>
                                    <?= $this->Form->postLink("<span class=\"fas fa-shipping-fast\"></span>" . __(' Ship'), ['action' => 'ship', $sale->id],
                                        ['confirm' => __('Are you sure you want to ship this order?', $sale->user->first_name, $sale->user->last_name), 'escape' => false, 'title' => __('Ship'), 'class' => 'btn btn-secondary btn-sm']);
                                } ?>


                                <?php if ($sale->status == 'pending') { ?>
                                    <?= $this->Form->postLink("<span class=\"fas fa-window-close\"></span>" . __(' Cancel'), ['action' => 'cancel', $sale->id],
                                        ['confirm' => __('Are you sure you want to cancel order to {0} {1}?', $sale->user->first_name, $sale->user->last_name), 'escape' => false, 'title' => __('Cancel'), 'class' => 'btn btn-light btn-sm']);
                                } ?>


                                <?php
                                $orderStatus = $sale->status;
                                if ($orderStatus === "requested") { ?>
                                    <?= $this->Form->postLink("<span class=\"fas fa-exchange-alt\"></span>" . __(' Return'), ['action' => 'return', $sale->id],
                                        ['confirm' => __('Are you sure that you want to confirm the order return for your customer order (made on {0})?', $sale->sales_date), 'escape' => false, 'title' => __('Return'), 'class' => 'btn btn-primary btn-sm']);
                                    ?>
                                <?php } ?>

                                <?php
                                $orderStatus = $sale->status;
                                if ($orderStatus === "requested") { ?>
                                    <?= $this->Form->postLink("<span class=\"fas fa-ban\"></span>" . __(' Reject'), ['action' => 'reject', $sale->id],
                                        ['confirm' => __('Are you sure that you want to reject the order return for your customer order (made on {0})?', $sale->sales_date), 'escape' => false, 'title' => __('Reject'), 'class' => 'btn btn-dark btn-sm']);
                                    ?>
                                <?php } ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!--        Paging Stylings -->
            <div class="" style="text-align: center; padding: 1%">
                <ul class="pagination justify-content-center">
                    <?php $this->Paginator->setTemplates([
                        'first' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                        'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'prevDisabled' => '<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                        'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'nextDisabled' => '<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                        'last' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                    ]); ?>

                    <?= $this->Paginator->prev(__('Previous')) ?>

                    <div class="form-group row" style="padding-left: 10px; padding-right: 10px">
                        <?= $this->Paginator->numbers() ?>
                    </div>

                    <?= $this->Paginator->next(__('Next')) ?>


                </ul>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
            <!--For customer-->
        <?php }
        else if ($userRole == 'customer') { ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>

                        <th><?= $this->Paginator->sort('id', 'Reference No.') ?></th>
                        <th><?= $this->Paginator->sort('Product') ?></th>
                        <th><?= $this->Paginator->sort('Total price') ?></th>
                        <th><?= $this->Paginator->sort('quantity') ?></th>
                        <th><?= $this->Paginator->sort('status') ?></th>

                        <th><?= $this->Paginator->sort('sales_date') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= h($sale->id) ?></td>
                            <td><?= h($sale->product_name) ?></td>
                            <td>$<?= $this->Number->format($sale->price) ?> AUD</td>
                            <td><?= $this->Number->format($sale->quantity) ?></td>
                            <td><?= h($sale->status) ?></td>

                            <td><?= h($sale->sales_date) ?></td>
                            <td class="actions">

                                <?= $this->Html->link(__('View'), ['action' => 'view', $sale->id], ['class' => 'btn btn-primary']) ?>


                                <?php
                                $orderStatus = $sale->status;
                                if ($orderStatus === 'pending') { ?>

                                    <?= $this->Form->postLink(__('Cancel'), ['action' => 'cancel', $sale->id],

                                        ['class' => 'btn btn-danger',
                                            'confirm' => __('Are you sure you want to cancel this order?')]) ?>

                                <?php } ?>


                                <?php
                                $orderStatus = $sale->status;
                                if ($orderStatus === "shipped") { ?>
                                    <?= $this->Form->postLink(__('Request for Return'), ['action' => 'requestforreturn', $sale->id],
                                        ['class' => 'btn btn-warning',
                                            'confirm' => __('Are you sure that you want to request for return for your order (made on {0})?', $sale->sales_date)]) ?>
                                <?php } ?>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!--        Paging Stylings -->
            <div class="" style="text-align: center; padding: 1%">
                <ul class="pagination justify-content-center">
                    <?php $this->Paginator->setTemplates([
                        'first' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                        'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'prevDisabled' => '<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                        'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'nextDisabled' => '<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                        'last' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                    ]); ?>

                    <?= $this->Paginator->prev(__('Previous')) ?>

                    <div class="form-group row" style="padding-left: 8px; padding-right: 8px">
                        <?= $this->Paginator->numbers() ?>
                    </div>

                    <?= $this->Paginator->next(__('Next')) ?>


                </ul>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
        <?php } ?>

    </div>
    <br>
    <br>
    <br>

</div>


<!--Display Chart is admin is logged in-->
<?php if ($userRole === 'admin') { ?>

<!--    Scripts for  line charts-->
<head>
    <!-- Charts JavaScript-->
    <?= $this
        ->Html
        ->script('linechart.js'); ?>
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>

<!--    Create bootstrap accordion menu to hold chart -->
<div class="container-fluid">

    <div class="card shadow mb-4" id="accordion">
        <div class="card">
            <!--            Header For outer accordion-->
            <div class="card-header py-3" id="headingOne">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button class=" m-0 font-weight-bold text-primary btn btn-link" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Current Trending Sales
                    </button>
                </h6>
            </div>
            <!--            Outer Accordion Body-->
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                <div class="card-body" id="child1">

                    <div class="card">
                        <!--                        Inner Accordion Header-->
                        <div class="card-header py-3">
                            <a href="#" class="m-0 font-weight-bold text-primary btn btn-link" data-toggle="collapse"
                               data-target="#collapseOneA">Filters</a>
                        </div>
                        <!--                        Inner Accordion Body-->
                        <div class="card-body collapse show" data-parent="#child1" id="collapseOneA">
                            <div class="col-sm-4 mb-6 mb-sm-0">
                                <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0']) ?>
                                <span> Last Number of Days &nbsp </span> &nbsp  &nbsp  &nbsp

                                <div class="form-group row">

                                    <?= $this->Form->input('daysQuery', ['label' => 'Last Number of Days', 'class' => 'form-control mr-sm-2 ', 'value' => $this->request->getQuery('daysQuery'), 'type' => 'number', 'min' => '1', 'max' => '730']) ?>

                                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Filter</button>
                                </div>
                                <?= $this->Form->end() ?> </div>
                        </div>
                    </div>

                </div>

                <div class="card-body" style="
  height: 60vh;
  width: 100%;">
                    <canvas id="canvas"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!--Load Data from Models-->
    <?php

    foreach ($chartSales as $sale) {

//            Store needed data in an array
        $item = [
            'quantity' => $sale->quantity,
            'sale_date' => $sale->sales_date,
            'product_name' => ($sale->product_name),
        ];

//            Store array within an array called "file" followed by the product id number
//            Keeps variable names unique and easy to access for js encoding.
        ${"file" . $sale->product_id}[] = $item;


    }

    ?>

    <!--    Encode Php data to js and create datasets to push to chart-->
    <!--    for each array, for each possible product-->
    <?php for ($i = 0; $i <= $maxID; $i++) {
        if (isset(${"file" . $i})) { ?>
            <script>

                //  encode php array as js
                passedArray = <?= json_encode(${"file" . $i}); ?>

                // retrieve all sales_dates to use as x axis co-ordinates
                var labels = passedArray.map(function (e) {
                    return e.sale_date;
                });

                // Retrieve product name to use as the line name
                var lineName = passedArray.map(function (e) {
                    return e.product_name;
                });

                // retrieve data for y axis co-ordinates
                var dataset = passedArray.map(function (e) {
                    return e.quantity;
                });

                // create the js array if it hasn't been created already
                if (!(datasetConfig instanceof Array)) {
                    var datasetConfig = [];
                }

                datasetData = [];

                /* get x and y co-ordinates to form an array of co-ordinates that the
                charts can read */
                for (var i = 0; i < labels.length; i++) {
                    labels[i] = new Date(labels[i]);
                    datasetData.push({
                        x: labels[i], y: dataset[i]
                    });
                }

                // get a random color for that data set's color
                color = '#' + Math.floor(Math.random() * 16777215).toString(16)
                // create the dataset
                datasetConfig.push([{
                    label: lineName[0],
                    data: datasetData,
                    fill: false,
                    borderColor: color,
                    backgroundColor: color
                }]);

            </script>
        <?php }
    } ?>

    <!-- Graph Stylings-->
    <script>
        var timeFormat = 'DD/MM/YY';
        var config = {
            type: 'line',
            data: {},

            options: {
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: "Chart.js Time Scale"
                },
                scales: {
                    xAxes: [{
                        type: "time",
                        time: {
                            format: timeFormat,
                            tooltipFormat: 'll'
                        },
                        ticks: {
                            maxTicksLimit: 24
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,

                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'quantity sold'
                        },

                    }]
                },
                // Display options for card when datapoint is hovered over
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: true,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        };


    </script>

    <!--Push Datasets to Chart-->
    <script>
        window.onload = function () {

            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);

            <!--Adds Datasets for each product in sales-->
            for (var i = 0; i < datasetConfig.length; i++) {
                myLine.data.datasets.push(datasetConfig[i][0]);
                myLine.update();
            }

        };

    </script>

    <?= $this
        ->Html
        ->script('/vendor/chart.js/Chart.js'); ?>

    <!-- Datatables charts JavaScript-->
    <?= $this->Html->script('demo/chart-area-demo.js'); ?>

    <?php } ?>



