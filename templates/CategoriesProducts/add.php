<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesProduct $categoriesProduct
 */
?>
<?php

$userRole = $this->Identity->get('role');





$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'customer_profile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);


$this->Breadcrumbs->add([
    [
        'title' => 'Product Category',
        'url' => ['controller' => 'categoriesProducts', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Add a New Category',
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
            <?= $this->Form->create($categoriesProduct) ?>
            <fieldset style="width:90%; margin:auto">


                <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">
                Add a New Category
                </h2>
                <?php
                    echo $this->Form->control('name', ['class'=> 'form-control']);
                ?>
            </fieldset>
            <br>
            <div class="row" style="width: 60%; margin: auto">
                           <div class="col-lg-6  mx-auto ">
                               <?= $this->Form->button(__('Submit'), ['style'=>'width: 90%', 'padding: 10%' ,
                                   'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                               <?= $this->Form->end() ?>
                           </div>

                           <div class="col-lg-6 mx-auto ">
                               <?= $this->Html->link(__('Cancel'), ['action' => 'index'],
                                   ['style'=>'width: 90%','confirm' => __('Are you sure you want to cancel adding the category of products?'), 'class' => ' button float-left  btn btn-danger']) ?>
                               <br>
                               <br>
                           </div>

                       </div>

                   </div>
        </div>
    </div>
</div>
