<?php
/**
 * @var AppView $this
 * @var Sale[]|CollectionInterface $sales
 */

use App\Model\Entity\Sale;
use Cake\ORM\TableRegistry;


/**
 * @var AppView $this
 * @var Inventory[]|CollectionInterface $inventories
 */

use App\Model\Entity\Inventory;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\I18n\FrozenTime;


?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shopifysale[]|\Cake\Collection\CollectionInterface $shopifysales
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
} ?>

<?php
if ($userRole === 'admin') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

    $this->Breadcrumbs->add([
        [
            'title' => 'Shopify Sales',
            'url' => ['controller' => 'shopifysales', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item '],
        ]]);


}



$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render(); ?>

<div class="container-fluid">
        <div class="shopifysales index content">
            <?= $this->Html->link(__('Add a Shopify Sale'), ['action' => 'add'], ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
            <h3><?= __('Shopify Sales') ?></h3>

            <div class="" id="accordion">

                    <h6 class="m-0 font-weight-bold text-primary">
                        <button class=" accordion-button m-0 font-weight-bold text-primary btn btn-link" data-toggle="collapse"
                                data-target="#collapse2"
                                aria-expanded="false    " aria-controls="collapse2">
                            Import Sales
                            <div style=" float: right; " class="col-auto">
                                <i class="fa fa-angle-down fa-2x"></i>
                            </div>
                        </button>
                    </h6>
                </div>
                <div id="collapse2" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="import excel file" style="padding: 15px">

                            <?= $this->Form->create($model = null, ['type' => 'file', 'url' => ['action' => 'importsexcel']]) ?>

                            <?php
                            echo $this->Form->control('excel', ['type' => 'file', 'label' => false, 'required' => true, 'class' => '']);
                            ?> <br>


                            <?= $this->Form->button(__('Import'), ['class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                            <?= $this->Form->end() ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <br>
            <div class="card shadow mb-4 ">
                <div class="card-header py-3 d-flex">
                    <?php echo $this->Form->create(null, ['type'=>'get','class'=>'form-inline my-2 my-lg-0']) ?>
                    <?= $this->Form->input('key', ['label' => 'Search', 'class'=>'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <?php
            $userRole = $this->Identity->get('role');
            if ($userRole === 'admin') { ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">

            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Reference No.') ?></th>
                    <th><?= $this->Paginator->sort('Name') ?></th>
                    <th><?= $this->Paginator->sort('Email') ?></th>

                    <th><?= $this->Paginator->sort('LineItem_name') ?></th>
                    <th><?= $this->Paginator->sort('LineItem_quantity') ?></th>

                    <th><?= $this->Paginator->sort('Total') ?></th>
                    <th><?= $this->Paginator->sort('Financial_Status') ?></th>


                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shopifysales as $shopifysale): ?>
                <tr>
                    <td><?= h($shopifysale->id) ?></td>
                    <td><?= h($shopifysale->Name) ?></td>
                    <td> <?= $this->Text->truncate(
                            $shopifysale->Email,
                            18,
                            [
                                'ellipsis'=> '...',
                                'exact' =>true
                            ]
                        ); ?></td>
                    <td><?= h($shopifysale->LineItem_name) ?></td>
                    <td><?= $this->Number->format($shopifysale->LineItem_quantity) ?></td>
                    <td>$ <?= $this->Number->format($shopifysale->Total) ?> AUD</td>
                    <td><?= h($shopifysale->Financial_Status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['action' => 'view', $shopifysale->id],
                            ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>

                        <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $shopifysale->id],
                            ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                        <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['action' => 'delete', $shopifysale->id],
                            ['confirm' => __('Are you sure you want to delete the order of {0} {1} to {2}', $shopifysale->LineItem_quantity, $shopifysale->LineItem_name, $shopifysale->Name), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>

                        <?php if ($shopifysale->is_ship == 1) { ?>
                        <?= $this->Form->postLink("<span class=\"fas fa-shipping-fast\"></span>" . __(' Ship'), ['action' => 'ship', $shopifysale->id],
                                        ['confirm' => __('Are you sure you want to ship this order?'), 'escape' => false, 'title' => __('Ship'), 'class' => 'btn btn-secondary btn-sm']);
                        ?>

                        <?php }?>
                        <?php if ($shopifysale->is_ship == 0) { ?>
                            <?= $this->Form->postLink("<span class=\"fas fa-exchange-alt\"></span>" . __(' Return'), ['action' => 'return', $shopifysale->id],
                                ['confirm' => __('Are you sure that you want to confirm the  return for customer {0}?', $shopifysale->Name), 'escape' => false, 'title' => __('Return'), 'class' => 'btn btn-primary btn-sm']);
                            ?>
                        <?php } ?>
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
<?php } ?>
