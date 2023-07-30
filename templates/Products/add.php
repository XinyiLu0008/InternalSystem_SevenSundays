<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var \Cake\Collection\CollectionInterface|string[] $packagings
 * @var \Cake\Collection\CollectionInterface|string[] $manufacturers
 * @var \Cake\Collection\CollectionInterface|string[] $categoriesProducts
 * @var \Cake\Collection\CollectionInterface|string[] $sales
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
        'title' => 'Products',
        'url' => ['controller' => 'products', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Add a New Product',
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
            <div class="products form content">
 <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold"><?= __('Add a New Product ') ?></h2>
            <?= $this->Form->create($product, ['type'=> 'file']) ?>
                 <fieldset class="text-primary" style="width:90%; margin:auto ">
                                 <br>
                                 <?= $this->Html->link(__('Add a Category'), ['controller' => 'CategoriesProducts', 'action' => 'add'],
                                     ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>

                                 <br>
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
                                         <?php echo $this->Form->control('categories_products_id', ['options' => $categoriesProducts, 'class' => 'form-control', 'required' => true, 'label' => 'Product Category']); ?>
                                     </div>

                                 </div>

                                 <?= $this->Html->link(__('Add a Packaging'), ['controller' => 'Packagings', 'action' => 'add'],
                                     ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
                                 Costs
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('price', ['min' => '1', 'max' => '1000000', 'label' => 'Price (AUD)', 'class' => 'form-control']);
                                         ?>  </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('packaging_id', ['options' => $packagings, 'required' => true, 'class' => 'form-control']);
                                         ?></div>

                                 </div>
                                 Measurements
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('weight', ['min' => '1', 'max' => '1000000', 'label' => 'Weight (g)', 'class' => 'form-control']);
                                         ?> </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('capacity', ['min' => '1', 'max' => '1000000', 'label' => 'Capacity (ml)', 'class' => 'form-control']);
                                         ?> </div>
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                     </div>


                                     <br>
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('width', ['min' => '1', 'max' => '1000000', 'label' => 'Width (cm)', 'class' => 'form-control']);
                                         ?> </div>
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('length', ['min' => '1', 'max' => '1000000', 'label' => 'Length (cm)', 'class' => 'form-control']);
                                         ?> </div>
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('height', ['min' => '1', 'max' => '1000000', 'label' => 'Height (cm)', 'class' => 'form-control']);
                                         ?></div>
                                 </div>

                                 Stock
                                 <hr>
                                 <div class="form-group row">
                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('total_quantity', ['min' => '0', 'max' => '1000000', 'class' => 'form-control']);
                                         ?>  </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('rop', ['min' => '1', 'max' => '1000000', 'class' => 'form-control', 'label' => 'Reorder Point']);
                                         ?>  </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('shelf_life', ['min' => '1', 'max' => '10', 'label' => 'Shelf-life (years)', 'class' => 'form-control']);
                                         ?>
                                     </div>

                                 </div>
                                 <div class="form-group row">

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('availability', ['class' => 'form-control', 'type' => 'select', 'options' => [
                                             'Manufacturing' => 'Manufacturing',
                                             'Available' => 'Available',
                                         ]]); ?>
                                     </div>
                                 </div>

                                 <?= $this->Html->link(__('Add a Manufacturer'), ['controller' => 'Manufacturers', 'action' => 'add'],
                                     ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
                                 Ordering
                                 <hr>
                                 <div class="form-group row">

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('order_time', ['label' => 'Order time in days', 'min' => '1', 'max' => '365', 'class' => 'form-control']);
                                         ?>
                                     </div>

                                     <div class="col-sm-4 mb-3 mb-sm-0">
                                         <?php
                                         echo $this->Form->control('manufacturer_id', ['options' => $manufacturers, 'required' => true, 'class' => 'form-control']);
                                         ?>
                                     </div>


                                 </div>

                                 <label> Product Image </label> <?php
                                 echo $this->Form->control('image_file', ['label' => false, 'type' => 'file']); ?> <br> <?php
                                 ?> <br>
                             </fieldset>
                 <div class="row" style="width: 60%; margin: auto">
                                <div class="col-lg-6  mx-auto ">
                                    <?= $this->Form->button(__('Submit'), ['style'=>'width: 90%', 'padding: 10%' , 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                                    <?= $this->Form->end() ?>
                                </div>

                                <div class="col-lg-6 mx-auto ">
                                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'],
                                        ['style'=>'width: 90%','confirm' => __('Are you sure you want to cancel adding a new product?'),
                                            'class' => ' button float-left  btn btn-danger']) ?>
                                    <br>
                                    <br>
                                </div>

                            </div>
    </div>
</div>

<?php } ?>
