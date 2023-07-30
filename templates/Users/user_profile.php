<?php
/**
 * @var AppView $this
 * @var Inventory[]|CollectionInterface $inventories
 */

use App\Model\Entity\Inventory;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

?>
<?php
$userRole = $this->Identity->get('role');


$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'userProfile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);


$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render(); ?>

<!-- Charts JavaScript-->
<?= $this
    ->Html
    ->script('linechart.js'); ?>

<title>
        Dashboard
    </title>

<!--Cards-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-counter info">
                <i class="fas fa-warehouse fa-2x"></i>
                <span
                     class="count-numbers"><?= $this->Html->link(__('Inventory'), ['controller' => 'Inventories', 'action' => 'index'],
                        ['class' => '', 'style' => 'color: white']) ?> </span>
                <span
                    class="count-name"><?= h($inventoriesTotal) ?> Expiring</span>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-counter warning">
                <i class="fa fa-box-open fa-2x"></i>
                <span
                    class="count-numbers"><?= $this->Html->link(__('Packaging'), ['controller' => 'Packagings', 'action' => 'index'],
                        ['class' => '', 'style' => 'color: white']) ?></span>
                                <span
                                    class="count-name"> <?= h($packagingsTotal) ?> Understocked</span>
            </div>
         </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-counter success">
                <i class="fa fa-pump-soap fa-2x"></i>
                <span
                    class="count-numbers"> <?= $this->Html->link(__('Products'), ['controller' => 'Products', 'action' => 'index'],
                        ['class' => '', 'style' => 'color: white']) ?></span>
                                <span
                                    class="count-name"><?=  h($productsTotal) ?> Understocked</span>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-counter primary">
                <i class="fa fa-cash-register fa-2x"></i>

                <span
                    class="count-numbers"><?= $this->Html->link(__('Sales'), ['controller' => 'Sales', 'action' => 'index'],
                        ['class' => '', 'style' => 'color: white']) ?></span>
                <span
                    class="count-name"><?= h($salesTotal) ?> Pending Sales</span>
            </div>
        </div>
    </div>
</div>

<!--Charts-->
<div class="container-fluid">

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

<!--disable popups-->
    <script>

        if (window.self !== window.top && window.name != "view1") {
            window.alert = function () {
                /*disable alert*/
            };
            window.confirm = function () {
                /*disable confirm*/
            };
            window.prompt = function () {
                /*disable prompt*/
            };
            window.open = function () {
                /*disable open*/
            };
        }
        // prevent href=# click jump
        document.addEventListener(
            "DOMContentLoaded",
            function () {
                var links = document.getElementsByTagName("A");
                for (var i = 0; i < links.length; i++) {
                    if (links[i].href.indexOf("#") != -1) {
                        links[i].addEventListener("click", function (e) {
                            console.debug("prevent href=# click");
                            if (this.hash) {
                                if (this.hash == "#") {
                                    e.preventDefault();
                                    return false;
                                } else {
                                    /*
                                        var el = document.getElementById(this.hash.replace(/#/, ""));
                                        if (el) {
                                          el.scrollIntoView(true);
                                        }
                                        */
                                }
                            }
                            return false;
                        });
                    }
                }
            },
            false
        );
    </script>

    <!--scripts loaded here-->
    <script>
        $(document).ready(function () {
            $("[data-toggle=offcanvas]").click(function () {
                $(".row-offcanvas").toggleClass("active");
            });
        });
    </script>





