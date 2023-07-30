<?php
/**
 * @var AppView $this
 * @var Product $product
 */

use App\Model\Entity\Product;
use App\View\AppView;
use Cake\I18n\FrozenTime;

?>
<?php

$userRole = $this->Identity->get('role');
if ($userRole === 'customer') {
    $this->layout = 'customerLayout';
}

if ($userRole === 'admin') {

    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);


    $this->Breadcrumbs->add([
        [
            'title' => 'Products',
            'url' => ['controller' => 'products', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Product Details',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
    ]);

    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
    ]);

    echo $this->Breadcrumbs->render(); ?>


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                                <div class="image-container">
                                    <?= @$this->Html->image($product->image,
                                        ['style' => 'max-width:240px; max-height:240px; border-radius: 15px;']) ?>
                                    <div class="middle">

                                        <input type="file" style="display: none;" id="profilePicture" name="file"/>
                                    </div>
                                </div>
                                <div class="userData ml-3">
                                    <h2 class="d-block"
                                        style="font-size: 1.5rem;  color: #5D51AF;font-weight: bold"><?= h($product->title) ?></h2>

                                    <p class="mb-2 text-muted text-uppercase ">SKU: <?= h($product->sku) ?></p>
                                    <p><span class="mr-1"><strong>$ <?= $this->Number->format($product->price) ?> AUD per unit </strong></span>
                                    </p>
                                    <button type="button" class="btn btn-light btn-md mr-1 mb-2"><i
                                            class="fa fa-plus-square"> </i><?= $this->Html->link(__('   Update Product Detail'),
                                            ['action' => 'edit', $product->id]) ?></button>

                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab"
                                           href="#basicInfo"
                                           role="tab" aria-controls="basicInfo" aria-selected="true">Product Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="connectedServices-tab" data-toggle="tab"
                                           href="#connectedServices" role="tab" aria-controls="connectedServices"
                                           aria-selected="false">Size Info</a>
                                    </li>
                                </ul>
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel"
                                         aria-labelledby="basicInfo-tab">

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Packaging</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $product->has('packaging') ? $this->Html->link($product->packaging->title,
                                                    ['controller' => 'Packagings', 'action' => 'view', $product->packaging->id]) : '' ?>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Total Quantity </label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= h($product->total_quantity) ?> unit(s)
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Reorder Point</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= h($product->rop) ?> unit(s)
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Order Time</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->order_time) ?> days
                                            </div>
                                        </div>
                                        <hr/>


                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Shelf Life</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->shelf_life) ?> years
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Category</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $product->has('categories_product') ? $this->Html->link($product->categories_product->name,
                                                    ['controller' => 'CategoriesProducts', 'action' => 'view', $product->categories_product->id]) : '' ?>


                                            </div>
                                        </div>
                                        <hr/>


                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Manufacturer</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $product->has('manufacturer') ? $this->Html->link($product->manufacturer->primary_contact_name,
                                                    ['controller' => 'Manufacturers', 'action' => 'view', $product->manufacturer->id]) : '' ?>
                                            </div>
                                        </div>
                                        <hr/>

                                    </div>
                                    <div class="tab-pane fade" id="connectedServices" role="tabpanel"
                                         aria-labelledby="ConnectedServices-tab">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Capacity</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->capacity) ?> ml
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Weight</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->weight) ?> g
                                            </div>
                                        </div>
                                        <hr/>


                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Length</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->length) ?> cm
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Width</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->width) ?> cm
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Height</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($product->height) ?> cm
                                            </div>
                                        </div>
                                        <hr/>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <br>
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h1 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1"
                                aria-expanded="true" aria-controls="collapse1">
                            Related Inventories
                        </button>
                    </h1>
                </div>

                <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <?php if (!empty($product->inventories)) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <tr>
                                        <th><?= __('Batch No.') ?></th>
                                        <th><?= __('Product') ?></th>
                                        <th><?= __('Quantity') ?></th>
                                        <th><?= __('Received Date') ?></th>
                                        <th><?= __('Expiry Date') ?></th>
                                        <th><?= __('Packaging Check') ?></th>
                                        <th class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                    <?php foreach ($product->inventories as $inventories) : ?>
                                        <tr>
                                            <td><?= h($inventories->id) ?></td>
                                            <td><?= h($product->title) ?></td>
                                            <td><?= h($inventories->quantity) ?></td>
                                            <td><?= h($inventories->received_date) ?></td>
                                            <td><?= h($inventories->expiry_date) ?></td>
                                            <td><input
                                                    type="checkbox" <?php if ($inventories->checkbox): ?> checked="checked" <?php endif; ?> />
                                            </td>
                                            <td class="actions">
                                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['controller' => 'Inventories', 'action' => 'view', $inventories->id],
                                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>
                                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['controller' => 'Inventories', 'action' => 'edit', $inventories->id],
                                                    ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['controller' => 'Inventories', 'action' => 'delete', $inventories->id],
                                                    ['confirm' => __('Are you sure you want to delete # {0}?', $inventories->id), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!--Encode X axis Labels from Controller to js-->
    <script>
        LabelsArray = <?= json_encode($labels); ?>
    </script>

    <!--Create Array for Datasets: Add up total product total for each month current month-->
    <?php
    foreach ($sales as $sale) {

        // if the sale is in the last 30 days and is not cancelled or pending
        if (($sale->status != "canceled" && $sale->status != "pending")) {

            // store sale data in array
            $item = [
                'quantity' => $sale->quantity,
                'price' => intval($sale->price),
                'sale_date' => $sale->sales_date,
                'product_name' => $sale->product_name,
            ];

            // store array at the end of array named after the product id.
            $productSales[] = $item;

            $productNames[] = $sale->product_name;

        }
    }
    ?>

    <!--Sum Bar Chart Data-->
    <?php


    //        Get initial data to load into bar chart
    $item = array_fill(0, $months, 0);


        // for the length of that array
        for ($x = 0; $x < count($productSales); $x++) {

            $time = new FrozenTime('last day of 0 month', 'Australia/Melbourne');

            $endDate = $time->hour(23)->minute(59)->second(59);
            $startDate = $endDate->modify('-1 month');
            $startDate = $startDate->hour(0)->minute(0)->second(0);

//          using months as the index position on the chart, hence minus one as arrays use indexs from 0
            $index = $months - 1;

            // check what month the date falls in
            for ($y = $index; $y >= 0; $y--) {

                if ($productSales[$x]['sale_date'] < $endDate and $productSales[$x]['sale_date'] > $startDate) {
                    // if the graph is filterd to quantity, tally total quantity
                    if ($graphType == 'Quantity') {
                        $item[$y] = $item[$y] + $productSales[$x]['quantity'];
                    } else {
                        // update products total revenue for that month
                        $item[$y] = $item[$y] + $productSales[$x]['price'];
                    }

                    break;

                }

                // move backwards in months from the end of the current month.
                $startDate = $startDate->modify('-1 month');
                $endDate = $endDate->modify('-1 month');

            }

        }

    $salesData[] = $item;
    $salesData = array_reverse($salesData);


    ?>


    <!-- Load Line Names-->
    <script>
        productName = <?= json_encode($productNames); ?>
    </script>

    <!--Load Bar chart Data-->
    <script>
        dataArray = <?= json_encode($salesData); ?>

        // instantiate arrays for chart data if they have not been instantiated
        if (!(datasetConfig instanceof Array)) {
            var datasetConfig = [];
        }

        datasetConfig.push([{
            label: productName[0],
            data: dataArray[0],
            borderWidth: 1,
            borderColor: "rgba(93,81,175)",
            backgroundColor: "rgba(93,81,175)"
        }]);
    </script>

    <div class="container-fluid">
        <div style="margin:auto">

            <div class="card shadow mb-4" id="accordion">
                <div class="card">
                    <!--            Header For outer accordion-->
                    <div class="card-header py-3" id="headingOne">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php if ($graphType == 'Quantity') { ?>
                                <button class=" m-0 font-weight-bold text-primary btn btn-link"
                                        data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                    Monthly Quantity Sold
                                </button>
                            <?php } else { ?>
                                <button class=" m-0 font-weight-bold text-primary btn btn-link"
                                        data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                    Monthly Revenue
                                </button>
                            <?php } ?>
                        </h6>
                    </div>
                    <!--            Outer Accordion Body-->
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                         data-parent="#accordion">

                        <div class="card-body" id="child1">

                            <div class="card">
                                <!--                        Inner Accordion Header-->
                                <div class="card-header py-3">
                                    <a href="#" class="m-0 font-weight-bold text-primary btn btn-link"
                                       data-toggle="collapse"
                                       data-target="#collapseOneA">Filters</a>
                                </div>
                                <!--                        Inner Accordion Body-->
                                <div class="card-body collapse" data-parent="#child1" id="collapseOneA">

                                    <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0']) ?>
                                    <div class="form-group row">

                                        <div class="col-sm-9 mb-3 mb-sm-0">
                                            <label for="type" style="color: dimgrey">Tally Revenue or
                                                Quantity</label>
                                            <?php echo $this->Form->radio('type', [['value' => 'Revenue', 'text' => 'Revenue', 'checked', 'class' => 'form-control', 'label' => ['style' => '  white-space: normal;

    margin-left: 30px !important;

    text-indent: 0px !important;']],
                                                ['value' => 'Quantity', 'text' => 'Quantity', 'class' => 'form-control', 'label' => ['style' => '  white-space: normal;

    margin-left: 30px !important;

    text-indent: 0px !important;']]]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <span> Last Number of Months &nbsp </span>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <?= $this->Form->input('Months', ['label' => 'Last Number of Months', 'class' => 'form-control mr-sm-2 ', 'value' => $this->request->getQuery('Months'), 'type' => 'number', 'min' => '1', 'max' => '24']) ?>
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">
                                                Filter
                                            </button>
                                        </div>
                                    </div>


                                    <?= $this->Form->end() ?> </div>
                            </div>
                        </div>


                        <div class="card-body" style="
  height: 60vh;
  width: 100%;">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Charts JavaScript-->
    <?= $this
        ->Html
        ->script('chartjs-min.js'); ?>

    <?php if ($graphType == 'Quantity') { ?>
        <script>
            const data = {
                labels: LabelsArray,
                datasets: []
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: 'Date',
                            display: true,
                            title: {
                                display: true,
                                text: 'Quantity'
                            }
                        }
                    },
                    maintainAspectRatio: false,
                },
            };

        </script>
    <?php } // use $ on labels
    else { ?>
        <script>
            const data = {
                labels: LabelsArray,
                datasets: []
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Revenue'
                            },

                            beginAtZero: true,
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return '$' + value;
                                }
                            },

                        }
                    },
                    maintainAspectRatio: false,
                },
            };

        </script>
    <?php } ?>

    <!--Insert Datasets to Bar Chart-->
    <script>
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, config);


        <!--Push Datasets to Chart-->

        <!--Adds Datasets for each user in sales-->
        for (var i = 0; i < datasetConfig.length; i++) {
            myBarChart.data.datasets.push(datasetConfig[i][0]);
            myBarChart.update();
        }


    </script> &nbsp;


    </div>
    &nbsp;
<?php } else if ($userRole === 'customer') {
    $this->Breadcrumbs->add([['title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'retailer_profile'],
        'options' => ['class' => 'breadcrumb-item']]]);


    $this->Breadcrumbs->add([['title' => 'Products',
        'url' => ['controller' => 'products', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],],
        ['title' => 'Product Details',
            'options' => ['class' => 'breadcrumb-item active',],],]);

    $this->Breadcrumbs->setTemplates(['wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',]);

    echo $this->Breadcrumbs->render();
    ?>

    <div class="container">
        <!--Section: Block Content-->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="card-title mb-4">
                                <div class="d-flex justify-content-start">
                                    <div class="image-container">
                                        <?= @$this->Html->image($product->image,
                                            ['style' => 'max-width:auto; max-height:240px; border-radius: 15px;']) ?>

                                    </div>
                                    <div class="userData ml-3">
                                        <h2 class="d-block"
                                            style="font-size: 1.5rem; color: #5D51AF; font-weight: bold"><?= h($product->title) ?></h2>
                                        <i class="fas fa-box-open"></i> Stock : <?= h($product->total_quantity) ?>
                                        <p class="mb-2 text-muted text-uppercase">SKU: <?= h($product->sku) ?></p>

                                        <p><span class="mr-1"><strong> $ <?= $this->Number->format($product->price) ?> AUD per unit </strong></span>
                                        </p>

                                        <br>
                                        <button type="button" class="btn btn-light btn-md mr-1 mb-2"><i
                                                class="fas fa-shopping-cart pr-2"></i><?= $this->Html->link(__('Place an order'),
                                                ['controller' => 'Sales', 'action' => 'add', $product->id]) ?></button>
                                    </div>
                                    <div class="ml-auto">
                                        <input type="button" class="btn btn-primary d-none" id="btnDiscard"
                                               value="Discard Changes"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="basicInfo-tab" data-toggle="tab"
                                               href="#basicInfo" role="tab" aria-controls="basicInfo"
                                               aria-selected="true">Size
                                                Info</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content ml-1" id="myTabContent">
                                        <div class="tab-pane fade show active" id="basicInfo" role="tabpanel"
                                             aria-labelledby="basicInfo-tab">
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Capacity</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    <?= $this->Number->format($product->capacity) ?> ml
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Weight</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    <?= $this->Number->format($product->weight) ?> g
                                                </div>
                                            </div>
                                            <hr/>


                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Length</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    <?= $this->Number->format($product->length) ?> cm
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Width</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    <?= $this->Number->format($product->width) ?> cm
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Height</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    <?= $this->Number->format($product->height) ?> cm
                                                </div>
                                            </div>
                                            <hr/>


                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Section: Block Content-->
    </div>

    </div>
    </div>
    </div>
<?php } ?>
