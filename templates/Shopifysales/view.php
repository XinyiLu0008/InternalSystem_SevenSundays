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
        'title' => 'Sales Detail',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);

echo $this->Breadcrumbs->render(); ?>
<div class="row" style="display: unset">
    <aside class="column">
        <div class="side-nav">

        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="shopifysales view content">
            <h3>Sales Details</h3>
            <table class="table table-bordered">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($shopifysale->Name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($shopifysale->Email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Financial Status') ?></th>
                    <td><?= h($shopifysale->Financial_Status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($shopifysale->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtotal') ?></th>
                    <td><?= $this->Number->format($shopifysale->Subtotal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Shipping') ?></th>
                    <td><?= $this->Number->format($shopifysale->Shipping) ?></td>
                </tr>
                <tr>
                    <th><?= __('Taxes') ?></th>
                    <td><?= $this->Number->format($shopifysale->Taxes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($shopifysale->Total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid At') ?></th>
                    <td><?= h($shopifysale->Paid_at) ?></td>
                </tr>
            </table>
            <table class="table table-bordered">
                <tr>
                    <td colspan="3" style="font-size: 20px;font-weight: bold">Product</td>
                </tr>
                <tr>
                    <th>LineItem_name</th>
                    <th>LineItem_quantity</th>
                    <th>LineItem_price</th>
                    <th>Paid At</th>
                </tr>
                <?php foreach ($productsData as $v): ?>
                    <tr>
                        <td><?= $v['LineItem_name']?></td>
                        <td><?= $v['LineItem_quantity']?></td>
                        <td>$ <?= h($shopifysale->	LineItem_price) ?> AUD</td>
                        <td><?= $v['Paid_at']?></td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>
</div>
