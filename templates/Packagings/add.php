<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Packaging $packaging
 * @var \Cake\Collection\CollectionInterface|string[] $manufacturers
 */
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
        'title' => 'Packagings',
        'url' => ['controller' => 'packagings', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Add an Packaging item',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);


echo $this->Breadcrumbs->render(); ?>

<div class="container-fluid">

    <div class="column-responsive column-80">
        <div class="packagings form content">
            <?= $this->Form->create($packaging, ['type'=> 'file']) ?>

                <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">
                   Add an Packaging</h2>
              <fieldset class="text-primary" style="width:90%; margin:auto ">


                                 Identification
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('title', ['class' => 'form-control']); ?>
                                     </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php echo $this->Form->control('sku', ['class' => 'form-control', 'label' => 'SKU']); ?>
                                     </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php echo $this->Form->control('type', ['class' => 'form-control', 'type' => 'select', 'options' => [
                                             'packaging' => 'packaging',
                                             'shipping' => 'shipping',
                                         ]]); ?>
                                     </div>

                                 </div>

                                 Costs
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('price', ['min' => '0', 'max' => '1000000', 'label' => 'Price (AUD)', 'class' => 'form-control']); ?>                                </div>


                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php echo $this->Form->control('manufacturer_id', ['options' => $manufacturers, 'class' => 'form-control']); ?>
                                     </div>
                                 </div>

                                 Dimensions
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                                                    <?php
                                                                    echo $this->Form->control('length', ['min' => '1', 'max' => '1000000', 'label' => 'Length (cm)', 'class' => 'form-control']); ?>
 </div>


                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php echo $this->Form->control('width', ['min' => '1', 'max' => '1000000', 'label' => 'Width (cm)', 'class' => 'form-control']); ?>
                                     </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php echo $this->Form->control('height', ['min' => '1', 'max' => '1000000', 'label' => 'Height (cm)', 'class' => 'form-control']); ?>
                                     </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('weight', ['min' => '1', 'max' => '1000000', 'label' => 'Weight (g)', 'class' => 'form-control']); ?>
                                     </div>
                                 </div>

                                 Quantity
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('total_quantity', ['min' => '1', 'max' => '1000000', 'class' => 'form-control']); ?>
                                     </div>


                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php echo $this->Form->control('rop', ['min' => '1', 'max' => '1000000', 'class' => 'form-control', 'label' => 'Reorder Point']); ?>
                                     </div>
                                 </div>


                                 <br>
                                 <label> Packaging Image </label> <?php
                                 echo $this->Form->control('image_file', ['label' => false, 'type' => 'file']); ?> <br> <?php
                                 ?> <br>

                             </fieldset>
                 <div class="row" style="width: 60%; margin: auto">
                             <div class="col-lg-6  mx-auto ">
                                 <?= $this->Form->button(__('Submit'), ['style'=>'width: 90%', 'padding: 10%' , 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                                 <?= $this->Form->end() ?>
                             </div>

                             <div class="col-lg-6 mx-auto ">
                                 <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style'=>'width: 90%','confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                                 <br>
                                 <br>
                             </div>

                         </div>

        </div>
    </div>
    <?php } ?>
</div>


