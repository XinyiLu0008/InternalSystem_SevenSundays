<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Packaging[]|\Cake\Collection\CollectionInterface $packagings
 */
?>

<?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.css' , ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js' , ['block' => true]); ?>


<?php
$userRole = $this->Identity->get('role');

if ($userRole === 'admin') {

    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);
}


$this->Breadcrumbs->add([
    [
        'title' => 'Packagings',
        'url' => ['controller' => 'packagings', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ]]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render(); ?>

<?php
if ($userRole === 'admin') { ?>
    <div class="container-fluid">
        <div class="packagings index content">
            <?= $this->Html->link(__('Add a Packaging'), ['action' => 'add'], ['style' => 'margin: 15px', 'class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
            <?= $this->Html->link(__('Update Quantity'), ['action' => 'bulkUpdate'], [ 'style' => 'margin: 15px' ,'class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>

            <br>
            <h3><?= __('Packagings') ?></h3>


            <div class="card shadow mb-4 ">
                <div class="card-header py-3 d-flex">
                    <?php echo $this->Form->create(null, ['type'=>'get','class'=>'form-inline my-2 my-lg-0']) ?>
                    <?= $this->Form->input('key', ['label' => 'Search', 'class'=>'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                    <?= $this->Form->end() ?>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('packaging') ?></th>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('price') ?></th>
                        <th><?= $this->Paginator->sort('type') ?></th>
                        <th><?= $this->Paginator->sort('sku') ?></th>
                        <th><?= $this->Paginator->sort('total_quantity') ?></th>

                        <th><?= $this->Paginator->sort('Reorder Point') ?></th>
                        <th><?= $this->Paginator->sort('manufacturer_id') ?></th>

                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($packagings as $packaging): ?>
                        <tr>
                            <td><?= @$this->Html->image($packaging->image, ['style' => 'max-width:50px;height:50px;border-radius:50%;']) ?></td>

                            <td><?= h($packaging->title) ?></td>
                            <td>$ <?= $this->Number->format($packaging->price) ?> AUD</td>
                            <td><?= h($packaging->type) ?></td>
                            <td><?= h($packaging->sku) ?></td>
                            <?php if ($packaging->total_quantity < $packaging->rop) { ?>
                                <td style="color: red "><?= $this->Number->format($packaging->total_quantity) ?></td>
                            <?php } else { ?>
                                <td><?= $this->Number->format($packaging->total_quantity) ?></td>
                            <?php } ?>

                            <td><?= $this->Number->format($packaging->rop) ?></td>


                            <td><?=$this->Text->truncate($packaging->manufacturer->name,15,[
                                            'ellipsis'=>'...',
                                    'exact'=>'false']); ?>   </td>
                            <td class="actions">
                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['action' => 'view', $packaging->id],
                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>

                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $packaging->id],
                                    ['escape' => false,'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['action' => 'delete', $packaging->id],
                                    ['confirm' => __('Are you sure you want to delete the packaging item # {0}?', $packaging->title), 'escape' => false,'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>
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
    </div>



<?php } ?>
