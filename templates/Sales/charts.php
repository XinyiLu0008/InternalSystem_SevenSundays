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
        'title' => 'Sales Charts',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);

echo $this->Breadcrumbs->render(); ?>


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
        ${"file" . $sale->product_id}[] = $item;

        $productNames[] = $sale->product_name;

    }
}
?>

<!--Sum Pie Chart Data-->
<?php
// for all the possible products listed in the sales table
for ($i = 0; $i <= $maxID; $i++) {
    // check if the file for that product list is set
    if (isset(${"file" . $i})) {
//        Reset Quantity Total for the product
        $productQuantityTotal = 0;
        // for the length of that array
        for ($x = 0; $x < count(${"file" . $i}); $x++) {
            // if the graph is filtered to quantity, tally total quantity
            if ($graphType == 'Quantity') {
                $productQuantityTotal = $productQuantityTotal + ${"file" . $i}[$x]['quantity'];
            } else {
                // update products total revenue for that month
                $productQuantityTotal = $productQuantityTotal + ${"file" . $i}[$x]['price'];
            }

        }
        $pieChartData[] = $productQuantityTotal;
    }
}

?>
<!--Sum Bar Chart Data-->
<?php
// for all the possible products listed in the sales table
for ($i = 0; $i <= $maxID; $i++) {
    // check if the file for that product list is set
    if (isset(${"file" . $i})) {

//        Get initial data to load into bar chart
        $item = array_fill(0, $months, 0);

        // for the length of that array
        for ($x = 0; $x < count(${"file" . $i}); $x++) {

            $time = new FrozenTime('last day of 0 month', 'Australia/Melbourne');

            $endDate = $time->hour(23)->minute(59)->second(59);
            $startDate = $endDate->modify('-1 month');
            $startDate = $startDate->hour(0)->minute(0)->second(0);

//          using months as the index position on the chart, hence minus one as arrays use indexs from 0
            $index = $months - 1;
            // check what month the date falls in
            for ($y = $index; $y >= 0; $y--) {

                if (${"file" . $i}[$x]['sale_date'] < $endDate and ${"file" . $i}[$x]['sale_date'] > $startDate) {
                    // if the graph is filterd to quantity, tally total quantity
                    if ($graphType == 'Quantity') {
                        $item[$y] = $item[$y] + ${"file" . $i}[$x]['quantity'];
                    } else {
                        // update products total revenue for that month
                        $item[$y] = $item[$y] + ${"file" . $i}[$x]['price'];
                    }

                    break;

                }

                // move backwards in months from the end of the current month.
                $startDate = $startDate->modify('-1 month');
                $endDate = $endDate->modify('-1 month');

            }

        }

        ${"data" . $i}[] = $item;
        ${"data" . $i} = array_reverse(${"data" . $i});
    }
}
?>

<?php for ($i = 0; $i <= $maxID; $i++) {
    if (isset(${"file" . $i})) { ?>

        <!-- Load Line Names-->
        <script>
            passedArray = <?= json_encode(${"file" . $i}); ?>
        </script>

        <!--Load Bar chart Data-->
        <script>
            dataArray = <?= json_encode(${"data" . $i}); ?>

            var lineName = passedArray.map(function (e) {
                return e.product_name;
            });

            // instantiate arrays for chart data if they have not been instantiated
            if (!(datasetConfig instanceof Array)) {
                var datasetConfig = [];
                var productNames = [];
                var pieChartColors = [];
            }

            productNames.push([lineName[0]])

            // get a random color for that data set
            color = '#' + Math.floor(Math.random() * 16777215).toString(16)
            pieChartColors.push([color])

            datasetConfig.push([{
                label: lineName[0],
                data: dataArray[0],
                borderWidth: 1,
                borderColor: color,
                backgroundColor: color
            }]);
        </script>
    <?php }
} ?>

<div class="container-fluid">
    <div style="margin:auto">

        <div class="card shadow mb-4" id="accordion">
            <div class="card">
                <!--            Header For outer accordion-->
                <div class="card-header py-3" id="headingOne">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?php if ($graphType == 'Quantity') { ?>
                            <button class=" m-0 font-weight-bold text-primary btn btn-link" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Monthly Quantity Sold
                            </button>
                        <?php } else { ?>
                            <button class=" m-0 font-weight-bold text-primary btn btn-link" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Monthly Revenue
                            </button>
                        <?php } ?>
                    </h6>
                </div>
                <!--            Outer Accordion Body-->
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

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
                                        <label for="type" style="color: dimgrey">Tally Revenue or Quantity</label>
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
                                        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Filter</button>
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

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <button class=" m-0 font-weight-bold text-primary btn btn-link" data-toggle="collapse"
                                data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <!--                            Display Title of Chart based on months query-->
                            <?php if ($months == 1) { ?>
                                Breakdown of Product Sales Over The Last Month
                            <?php } else { ?>
                                Breakdown of Product Sales Over The Last <?php echo h($months) ?> Months
                            <?php } ?>
                        </button>
                    </h6>
                </div>
                <!-- Card Body -->
                <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordion" class="collapse show">
                    <div class="card-body" style="
  height: 60vh;
  width: 100%;">
                        <canvas id="myPieChart"></canvas>
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
<?php }
// use $ on labels
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


</script>

<!-- Pie Chart JavaScript-->
<?= $this
    ->Html
    ->script('jquery.min.js'); ?>

<?= $this
    ->Html
    ->script('chartjs-2.7.min.js'); ?>

<?= $this
    ->Html
    ->script('chartjs-plugin-datalabels.min.js'); ?>


<!--If there is data to present in the pie chart, load the pie chart-->

<?php if ($maxID != 0) { ?>
<!--Data and Stylings for Pie Chart-->
<script>

    pieChartDataSet = <?= json_encode($pieChartData); ?>

    const pieChartData = {
        labels: productNames,
        datasets: [{
            label: 'My First Dataset',
            data: pieChartDataSet,
            backgroundColor: pieChartColors,
            hoverBackgroundColor: pieChartColors,
            hoverOffset: 4
        }]
    };


    const pieChartConfig = {
        type: 'pie',
        data: pieChartData,
        options: {
            tooltips: {
                displayColors: false
            },
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let datasets = ctx.chart.data.datasets;
                        if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                            let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((value / sum) * 100) + '%';
                            return percentage;
                        } else {
                            return percentage;
                        }
                    },
                    color: '#fff',
                },

            }

        },
    };

    var pieChart = document.getElementById("myPieChart");
    var myPieChart = new Chart(pieChart, pieChartConfig);

</script>
<?php } ?>
