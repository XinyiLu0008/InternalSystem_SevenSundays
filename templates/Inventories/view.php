<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inventory $inventory
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
        'title' => 'Inventory',
        'url' => ['controller' => 'inventories', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Inventory Record',
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






        <div class="container search-table">
            <div class="inventories view content">

                <div class="search-list">
                    <div class="userData ml-3">
                        <h2 class="d-block" style="font-size: 1.5rem;  color: #5D51AF; font-weight: bold">
                            Inventory Record</h2>


                    </div>


                    <table class="table" id="myTable">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>


                        <tr>
                            <td><h6 style="font-weight:bold;"><?= $inventory->has('product') ? $this->Html->link(__('Product'),
                                        ['controller' => 'Products', 'action' => 'view', $inventory->product->id]) : '' ?></h6></td>
                            <td>  <h6><?= $inventory->has('product') ? $this->Html->link($inventory->product->title,
                                        ['controller' => 'Products', 'action' => 'view', $inventory->product->id]) : '' ?></h6>

                            </td>
                        </tr>

                        <tr>
                            <td><h6 style="font-weight:bold;"><?= $inventory->has('product') ? $this->Html->link(__('Packaging'),
                                        ['controller' => 'Packagings', 'action' => 'view', $inventory->product->packaging_id]) : '' ?></h6></td>
                            <td>

                                <input type="checkbox" <?php if($inventory->checkbox):?> checked="checked" <?php endif;?> />

                            </td>
                        </tr>

                        <tr>
                            <td><h6 style="font-weight:bold;">SKU</h6></td>
                            <td>  <h6><?= $inventory->has('product') ? $inventory->product->sku: ''?></h6>

                            </td>
                        </tr>
                        <tr>
                            <td><h6 style="font-weight:bold;">Batch no.</h6></td>
                            <td><h6><?= $this->Number->format($inventory->id) ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 style="font-weight:bold;">Quantity</h6></td>
                            <td><h6><?= $this->Number->format($inventory->quantity) ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 style="font-weight:bold;">Shelf Life</h6></td>
                            <td><h6><?= $inventory->has('product') ? $inventory->product->shelf_life : '' ?>  years</h6></td>
                        </tr>
                        <tr>
                            <td><h6 style="font-weight:bold;">Received Date</h6></td>
                            <td><h6><?= h($inventory->received_date) ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 style="font-weight:bold;">Expiry Date</h6></td>
                            <td><h6><?= h($inventory->expiry_date) ?></h6></td>
                        </tr>
                        <tr>
                        <tr >
                            <td colspan="1"></td>
                            <td>


                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inventory->id],
                                    ['confirm' => __('Are you sure you want to delete the Inventory record of Batch no# {0}?', $inventory->id),
                                        'class' => ' button float-left  btn btn-danger']) ?>
                            </td>

                            </form>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>
</div>
</div>
