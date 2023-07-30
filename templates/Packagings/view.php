<?php
/**
 * @var AppView $this
 * @var Packaging $packaging
 */

use App\Model\Entity\Packaging;
use App\View\AppView;

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
            'title' => 'Packaging',
            'url' => ['controller' => 'packagings', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Packaging Info',
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
                                    <?= @$this->Html->image($packaging->image,
                                        ['style' => 'max-width:240; max-height:240px; border-radius: 15px;']) ?>
                                    <div class="middle">

                                        <input type="file" style="display: none;" id="profilePicture" name="file"/>
                                    </div>
                                </div>
                                <div class="userData ml-3">
                                    <h2 class="d-block"
                                        style="font-size: 1.5rem; color: #5D51AF; font-weight: bold"><?= h($packaging->title) ?></h2>
                                    <p class="mb-2 text-muted text-uppercase ">SKU: <?= h($packaging->sku) ?></p>
                                    <p><span class="mr-1"><strong>$ <?= $this->Number->format($packaging->price) ?> AUD per unit </strong></span>
                                    </p>
                                    <button type="button" class="btn btn-light btn-md mr-1 mb-2"><i
                                            class="fa fa-plus-square"> </i>
                                        <?= $this->Html->link(__('   Update Packaging Info'),
                                            ['action' => 'edit', $packaging->id]) ?></button>


                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab"
                                           href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Packaging
                                            Info</a>
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
                                                <label style="font-weight:bold;">Packaging Type</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= h($packaging->type) ?>
                                            </div>
                                        </div>
                                        <hr/>


                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Total quantity</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= h($packaging->total_quantity) ?> unit(s)
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Reorder Point</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= h($packaging->rop) ?> unit(s)
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Manufacturer</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $packaging->has('manufacturer') ?
                                                    $this->Html->link($packaging->manufacturer->primary_contact_name,
                                                        ['controller' => 'Manufacturers', 'action' => 'view',
                                                            $packaging->manufacturer->id]) : '' ?>
                                            </div>
                                        </div>
                                        <hr/>


                                    </div>
                                    <div class="tab-pane fade" id="connectedServices" role="tabpanel"
                                         aria-labelledby="ConnectedServices-tab">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Weight</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($packaging->weight) ?> g
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Length</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($packaging->length) ?> cm
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Width</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($packaging->width) ?> cm
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Height</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $this->Number->format($packaging->height) ?> cm
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
        &nbsp;

        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h1 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1"
                                aria-expanded="true" aria-controls="collapse1">
                            Related Products
                        </button>
                    </h1>
                </div>

                <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <?php if (!empty($packaging->products)) : ?>
                            <div class="table-responsive" id="t1">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <tr>
                                        <th><?= __('Sku') ?></th>
                                        <th><?= __('Product') ?></th>
                                        <th><?= __('Shelf Life') ?></th>
                                        <th><?= __('Price') ?></th>

                                        <th><?= __('Total Quantity') ?></th>


                                        <th class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                    <?php foreach ($packaging->products as $product) : ?>
                                        <tr>
                                            <td><?= h($product->sku) ?></td>
                                            <td><?= $this->Html->link($product->title,
                                                    ['controller' => 'Products', 'action' => 'view', $product->id]) ?></td>
                                            <td><?= h($product->shelf_life) ?> years</td>
                                            <td>$ <?= h($product->price) ?> AUD</td>
                                            <td><?= h($product->total_quantity) ?> units</td>


                                            <td class="actions">
                                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['controller' => 'Products', 'action' => 'view', $product->id],
                                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>
                                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['controller' => 'Products', 'action' => 'edit', $product->id],
                                                    ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['controller' => 'Products', 'action' => 'delete', $product->id],
                                                    ['confirm' => __('Are you sure you want to delete Product # {0}?', $product->title), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            &nbsp;


            &nbsp;

        </div>
    </div>


<?php } ?>
