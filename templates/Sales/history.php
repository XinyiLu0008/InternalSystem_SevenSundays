<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale[]|\Cake\Collection\CollectionInterface $sales
 */
?>

<?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.css', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]); ?>


<?php
$userRole = $this
    ->Identity
    ->get('role');
if ($userRole === 'customer') {
    $this->layout = 'customerLayout';
}
$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'retailer_profile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);

$this->Breadcrumbs->add([
    [
        'title' => 'History Order',
        'url' => ['controller' => 'sales', 'action' => 'history'],
        'options' => ['class' => 'breadcrumb-item '],
    ]]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render();  ?>

<div class="container-fluid">
    <div class="sales index content">

        <h3><?= __('Order History') ?></h3>


        <div class="card shadow mb-4 ">
            <div class="card-header py-3 d-flex">
                <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0', 'style' => 'width: 50%']) ?>
                <?= $this->Form->input('key', ['label' => 'Search', 'class' => 'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                <?= $this->Form->end() ?>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Reference No.') ?></th>
                    <th><?= $this->Paginator->sort('Product') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('sales_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= h($sale->id) ?></td>
                        <td><?= h($sale->product_name) ?></td>
                        <td>$<?= $this->Number->format($sale->price) ?> AUD </td>
                        <td><?= $this->Number->format($sale->quantity) ?></td>
                        <td><?= h($sale->status) ?></td>
                        <td><?= h($sale->sales_date) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $sale->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sale->id], ['confirm' => __('Are you sure you want to remove your order {0}  {1}  ?', $sale->user->first_name,$sale->user->last_name)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!--        Paging Stylings -->
        <div class="" style="text-align: center; padding: 1%">
            <ul class="pagination justify-content-center">
                <?php $this->Paginator->setTemplates([
                    'first' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                    'prevActive'=>'<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'prevDisabled'=>'<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                    'number'=>'<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'current'=>'<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'nextActive'=>'<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'nextDisabled'=>'<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                    'last' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                ]);?>

                <?= $this->Paginator->prev( __('Previous')) ?>

                <div class="form-group row" style="padding-left: 10px; padding-right: 10px">
                    <?= $this->Paginator->numbers() ?>
                </div>

                <?= $this->Paginator->next(__('Next') ) ?>


            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </div>
