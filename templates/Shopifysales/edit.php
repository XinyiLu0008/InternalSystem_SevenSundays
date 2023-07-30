<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shopifysale $shopifysale
 */
?>
<?php

$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'user_profile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);


$this->Breadcrumbs->add([
    [
        'title' => 'Shopify Sales',
        'url' => ['controller' => 'Shopifysales', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Update a Shopify Record',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);


echo $this->Breadcrumbs->render(); ?>

<?php
echo $this->Html->css('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', ['block' => true]);
echo $this->Html->script('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['block' => true]);
?>

<div class="container-fluid">

    <div class="column-responsive column-80">
        <div class="manufacturers form content">
            <?= $this->Form->create($shopifysale) ?>
            <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Update a Shopify Sale</h2>

            <fieldset class="text-primary" style="width:90%; margin:auto ">

                Basic Information
                <hr>
                <div class="form-group row">
                    <div class="col-sm-6 mb-6 mb-sm-0">
                        <?php
                        echo $this->Form->control('Name' , [ 'required'=> true, 'class'=> 'form-control']); ?>
                    </div>

                    <div class="col-sm-6 mb-6 mb-sm-0">
                        <?php
                        echo $this->Form->control('Email' , [  'required'=> true, 'class'=> 'form-control', 'type' => 'email']); ?>
                    </div>
                </div>

                Sale Details
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php
                        echo $this->Form->control('status', ['class' => 'form-control', 'type' => 'select', 'options' => [
                            'paid' => 'Paid',

                        ]]); ?>
                    </div>

                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <?php
                        echo $this->Form->control('Paid at', ['class' => 'form-control', 'required' => false,
                            'allowEmpty' => true]); ?>
                    </div>
                </div>

                Price Details
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('Subtotal' , ['min' => '1', 'max' => '1000000','class'=> 'form-control']); ?>
                    </div>

                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('Shipping' , ['min' => '1', 'max' => '1000000','class'=> 'form-control']); ?>
                    </div>

                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('Taxes' , ['min' => '1', 'max' => '1000000','class'=> 'form-control']); ?>
                    </div>

                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('Total' , ['min' => '1', 'max' => '1000000','class'=> 'form-control']); ?>
                    </div>
                </div>

                Product Details
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('LineItem_name' , [  'required'=> true, 'class'=> 'form-control']); ?>
                    </div>
                       <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('LineItem_quantity' , [ 'min' => '1', 'max' => '1000000', 'required'=> true, 'class'=> 'form-control']); ?>
                    </div>
                    <div class="col-sm-4 mb-6 mb-sm-0">
                        <?php echo $this->Form->control('LineItem_price' , ['min' => '1', 'max' => '1000000', 'class'=> 'form-control']); ?>
                    </div>
                </div>
            </fieldset>
            <div class="row" style="width: 60%; margin: auto">
                <div class="col-lg-6  mx-auto ">
                    <?= $this->Form->button(__('Submit'), ['style'=>'width: 90%', 'padding: 10%' , 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                    <?= $this->Form->end() ?>
                </div>

                <div class="col-lg-6 mx-auto ">
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style'=>'width: 90%','confirm' => __('Are you sure you want to cancel?'),
                        'class' => ' button float-left  btn btn-danger']) ?>
                    <br>
                    <br>
                </div>

            </div>
        </div>
    </div>
</div>
