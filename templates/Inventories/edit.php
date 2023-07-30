<?php
/**
 * @var AppView $this
 * @var Inventory $inventory
 * @var string[]|CollectionInterface $products
 */

use App\Model\Entity\Inventory;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

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
        'title' => 'Inventory',
        'url' => ['controller' => 'inventories', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Update Inventory Record',
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
        <div class="enquiries form content">
            <?= $this->Form->create($inventory) ?>
            <fieldset  class="text-primary" style="width:90%;  margin:auto">
                <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">
                    Update Inventory Record</h2>


                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <?php
                        echo $this->Form->control('product_id', ['required' => 'required', 'options' => $products, 'class' => 'form-control']); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php

                        echo $this->Form->control('quantity', ['min' => '0', 'max' => '1000000', 'class' => 'form-control']); ?>

                    </div>
                </div>
                <hr>
                Expiration
                <br>
                <br>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <?php
                        echo $this->Form->control('received_date', ['class' => 'form-control', 'required' => false,
                            'allowEmpty' => true]); ?>
                    </div>



                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <?php
                        echo $this->Form->control('expiry_date', ['empty' => true, 'class' => 'form-control']); ?>

                    </div>

                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <?php
                        echo $this->Form->control('lifetime', ['type' => 'hidden', 'min' => '1', 'max' => '20', 'label' => 'Shelf-life (years)', 'class' => 'form-control']); ?>

                    </div>

                </div>

                </div>
                <hr>

            </fieldset>
            <div class="row" style="width: 60%; margin: auto">
                <div class="col-lg-6  mx-auto ">
                    <?= $this->Form->button(__('Submit'), ['style' => 'width: 90%', 'padding: 10%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                    <?= $this->Form->end() ?>
                </div>

                <div class="col-lg-6 mx-auto ">
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                    <br>
                    <br>
                </div>

            </div>
        </div>
    </div>
</div>
