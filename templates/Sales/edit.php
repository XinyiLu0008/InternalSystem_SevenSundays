<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
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
        'title' => 'Update Order Detail',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);

echo $this->Breadcrumbs->render(); ?>

<div class="container-fluid">
    <div class="column-responsive column-80" style="width:80%; margin:auto">
        <div class="sales form content">
            <?= $this->Form->create($sale) ?>
            <h2 class="d-block" style="font-size: 1.5rem;  color: #5D51AF; font-weight: bold">Update Order Detail</h2>

            <fieldset class="text-primary" style="width:90%; margin:auto ">

                Purchase
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php
                        echo $this->Form->control('product_id', ['options' => $products, 'class' => 'form-control']); ?>
                    </div>


                    <div class="col-sm-4 mb-4 mb-sm-0">
                        <?php  echo $this->Form->control('quantity', ['min' => '1', 'max' => '1000000', 'class' => 'form-control']); ?>
                    </div>

                    <div class="col-sm-4 mb-4 mb-sm-0">
                        <?php echo $this->Form->control('price', ['min' => '1', 'max' => '1000000', 'class' => 'form-control']); ?>
                    </div>
                </div>

                Sale Details
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php
                        echo $this->Form->control('status', ['class' => 'form-control', 'type' => 'select', 'options' => [
                            'pending' => 'Pending',
                            'shipped' => 'Shipped',
                            'cancelled' => 'Canceled',
                            'requested' => 'Requested',
                            'rejected' => 'Rejected',
                            'returned' => 'Returned',
                        ]]); ?>
                    </div>

                    <div class="col-sm-4 mb-4 mb-sm-0">
                        <?php  echo $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control', 'label' => 'Retailer']); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-4 mb-sm-0">
                        <?php   echo $this->Form->control('sales_date', ['class' => 'form-control']); ?>
                    </div>


                </div>

            </fieldset>
            <div class="row" style="width: 60%; margin: auto">
                <div class="col-lg-6  mx-auto ">
                    <?= $this->Form->button(__('Submit'), ['style' => 'width: 90%', 'padding: 10%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>

                    <?= $this->Form->end() ?>
                </div>

                <div class="col-lg-6 mx-auto ">
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'],
                        ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to cancel'),
                            'class' => ' button float-left  btn btn-danger']) ?>
                    <br>
                    <br>
                </div>

            </div>
            <div id="showMsg" style="display: none; width: 300px; height: 100px;">
                <label id="errorMsg"></label>
            </div>
        </div>
    </div>
</div>
