<?php
/**
 * @var AppView $this
 * @var Manufacturer $manufacturer
 */

use App\Model\Entity\Manufacturer;
use App\View\AppView;

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
        'title' => 'Manufacturers',
        'url' => ['controller' => 'manufacturers', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Manufacturer Detail',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);
echo $this->Breadcrumbs->render(); ?>


<div class="container-fluid">


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                                <div class="image-container">
                                    <?= $this->Html->image('man.png', ['style' => 'max-width:140px;height:120px;']); ?>
                                    <div class="middle">

                                        <input type="file" style="display: none;" id="profilePicture" name="file"/>
                                    </div>
                                </div>
                                <div class="userData ml-3">
                                    <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold"><i
                                            class="fa fa-globe"></i> <?= h($manufacturer->name) ?></h2>
                                    <p><span class="mr-1">   <i class="fa fa-map-pin"
                                                                aria-hidden="true"></i> <?= h($manufacturer->country) ?></span>
                                    </p>
                                    <button type="button" class="btn btn-light btn-md mr-1 mb-2"><i
                                            class="fa fa-plus-square"> </i>
                                        <?= $this->Html->link(__('   Update'),
                                            ['action' => 'edit', $manufacturer->id]) ?></button>
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
                                           href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Business
                                            Info</a>
                                    </li>

                                </ul>
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel"
                                         aria-labelledby="basicInfo-tab">


                                        <div class="row">
                                            <div class="col">
                                                <label style="font-weight:bold;">Primary Contact Name</label>
                                            </div>
                                            <div class="col-5">
                                                <?= h($manufacturer->primary_contact_name) ?>
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col">
                                                <label style="font-weight:bold;">Product Type</label>
                                            </div>
                                            <div class="col-5">
                                                <?= h($manufacturer->products_type) ?>
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col">
                                                <label style="font-weight:bold;">Country</label>
                                            </div>
                                            <div class="col-5">
                                                <?= h($manufacturer->country) ?>
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row">
                                            <div class="col">
                                                <label style="font-weight:bold;">Email</label>
                                            </div>
                                            <div class="col-5">
                                                <?= h($manufacturer->email) ?>
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>

                                        <hr/>
                                        <div class="row">
                                            <div class="col">
                                                <label style="font-weight:bold;">Phone</label>
                                            </div>
                                            <div class="col-5">
                                                <?= h($manufacturer->phone) ?>
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>


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
                            Related Packagings
                        </button>
                    </h1>
                </div>


                <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <?php if (!empty($manufacturer->packagings)) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <tr>
                                        <th><?= __('Sku') ?></th>
                                        <th><?= __('Packaging') ?></th>


                                        <th><?= __('Type') ?></th>
                                        <th><?= __('Price') ?></th>
                                        <th><?= __('Total Quantity') ?></th>


                                        <th class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                    <?php foreach ($manufacturer->packagings as $packagings) : ?>
                                        <tr>
                                            <td><?= h($packagings->sku) ?></td>
                                            <td><?= $this->Html->link($packagings->title,
                                                    ['controller' => 'Packagings', 'action' => 'view', $packagings->id]) ?></td>


                                            <td><?= h($packagings->type) ?></td>
                                            <td>$ <?= h($packagings->price) ?> AUD</td>
                                            <td><?= h($packagings->total_quantity) ?> units</td>


                                            <td class="actions">
                                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['controller' => 'Packagings', 'action' => 'view', $packagings->id],
                                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>
                                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['controller' => 'Packagings', 'action' => 'edit', $packagings->id],
                                                    ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['controller' => 'Packagings', 'action' => 'delete', $packagings->id],
                                                    ['confirm' => __('Are you sure you want to delete # {0}?', $packagings->id), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>

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
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h1 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2"
                                aria-expanded="false" aria-controls="collapse2">
                            Related Products
                        </button>
                    </h1>
                </div>

                <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <?php if (!empty($manufacturer->products)) : ?>
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
                                    <?php foreach ($manufacturer->products as $products) : ?>
                                        <tr>
                                            <td><?= h($products->sku) ?></td>
                                            <td><?= $this->Html->link($products->title,
                                                    ['controller' => 'Products', 'action' => 'view', $products->id]) ?></td>


                                            <td><?= h($products->shelf_life) ?> years</td>

                                            <td>$<?= h($products->price) ?> AUD</td>
                                            <td><?= h($products->total_quantity) ?> units</td>

                                            <td class="actions">
                                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['controller' => 'Products', 'action' => 'view', $products->id],
                                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>
                                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['controller' => 'Products', 'action' => 'edit', $products->id],
                                                    ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['controller' => 'Products', 'action' => 'delete', $products->id],
                                                    ['confirm' => __('Are you sure you want to delete # {0}?', $products->id), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>
</div>
</div>

