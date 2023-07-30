<?php


/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */

use App\Model\Entity\Product;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\ORM\TableRegistry;

?>



<?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.css' , ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js' , ['block' => true]); ?>

<?php
$userRole = $this
    ->Identity
    ->get('role');

if ($userRole === 'customer') {
    $this->layout = 'customerLayout';

    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'retailer_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

} else {

    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

}
$this->Breadcrumbs->add([
    [
        'title' => 'Products',
        'url' => ['controller' => 'products', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item '],
    ]]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render(); ?>

<?php
if ($userRole === 'admin') { ?>
    <div class="container-fluid">
        <div class="products index content">
            <?= $this->Html->link(__('Add a Product'), ['action' => 'add'], ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
            <h3><?= __('Products') ?></h3>


            <div class="card shadow mb-4 ">
                <div class="card-header py-3 d-flex">
                    <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0']) ?>
                    <?= $this->Form->input('key', ['label' => 'Search', 'class' => 'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                    <?= $this->Form->end() ?>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('product') ?></th>

                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('stock') ?></th>
                        <th><?= $this->Paginator->sort('price') ?></th>


                        <th><?= $this->Paginator->sort('sku') ?></th>

                        <th><?= $this->Paginator->sort('Reorder Point') ?></th>
                        <th><?= $this->Paginator->sort('packaging_id') ?></th>
                        <th><?= $this->Paginator->sort('Manufacturer') ?></th>
                        <th><?= $this->Paginator->sort('Availability') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= @$this->Html->image($product->image, ['style' => 'max-width:50px;height:50px;border-radius:50%;']) ?></td>

                            <td><?= h($product->title) ?></td>
                            <?php if ($product->total_quantity < $product->rop) { ?>
                                <td style="color: red "><?= $this->Number->format($product->total_quantity) ?></td>
                            <?php } else { ?>
                                <td><?= $this->Number->format($product->total_quantity) ?></td>
                            <?php } ?>
                            <td>$ <?= $this->Number->format($product->price) ?> AUD</td>



                            <td><?= h($product->sku) ?></td>

                            <td><?= $this->Number->format($product->rop) ?></td>

                            <td><?= $product->has('packaging') ? $this->Html->link($product->packaging->title, ['controller' => 'Packagings', 'action' => 'view', $product->packaging->id]) : '' ?></td>
                            <td><?=$this->Text->truncate($product->manufacturer->name,15,[
                                    'ellipsis'=>'...',
                                    'exact'=>'false']); ?>   </td>
                            <td><?= h($product->availability) ?></td>

                            <td class="actions">
                                <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['action' => 'view', $product->id],
                                    ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>

                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $product->id],
                                    ['escape' => false,'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                                <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['action' => 'delete', $product->id],
                                    ['confirm' => __('Are you sure you want to delete # {0}?', $product->title), 'escape' => false,'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>
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
    <?php
}

if ($userRole === 'customer') {?>

    <div class="container-fluid">
    <h3><?= __('Products') ?></h3>

    <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex">
            <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0']) ?>
            <?= $this->Form->input('key', ['label' => 'Search', 'class' => 'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">
                <i class="fas fa-search"></i>
            </button>
            <?= $this->Form->end() ?>
        </div>
    </div>


    <div class="row " style=" margin: auto">

        <?php $k=0; ?>

        <?php foreach ($products as $product): ?>
            <?php $k++; ?>
            <div class="row">
                <div class="col-6 col-sm-3">
                <div class="card" style="width:310px">
                    <?= @$this->Html->image($product->image, ['class' => ' card-img-top' ,'style' => 'max-width:310px;height:300px;']) ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title"><strong><?= h($product->title) ?></strong></h4>
                            </div>


                        </div>

                        <h5><label style="font-weight:bold;">$ <?= $this->Number->format($product->price) ?> AUD</label></h5>
                        <i class="fa fa-leaf" aria-hidden="true"></i>
                            Category : <?= $product->has('categories_product') ? h($product->categories_product->name) : '' ?>
                        <br> <i class="fas fa-box-open"></i>
                        Stock : <?= h($product->total_quantity)?>


                        <div class="row">

                            <div class="col-md-6">
                                <br>
                                <?= $this->Html->link(__('Details'), ['action' => 'view', $product->id],
                                    ['class' => ' nav-link btn btn-primary btn-user btn-block']) ?>

                            </div>
                            <div class="col-md-6">
                                <br>
                                <?= $this->Html->link("<span class=\"fas fa-shopping-cart pr-2\"></span>" . __('Order'),['controller' => 'Sales', 'action' => 'add', $product->id],
                                    ['escape' => false, 'class' => 'nav-link btn btn-light btn-user btn-block', 'style' => 'color: #5d51af']) ?>

                               </div>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>


                        <div class="clearfix">
                        </div>
                    </div>

                </div>

            </div>

    </div>
        <?php endforeach; ?>



    </div>










    <div class="" style="text-align: center; padding: 1%">
    <?php if(!empty($k)){ ?>
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
            <?= $this->Paginator->first('<< ' . __('First')) ?>
            <?= $this->Paginator->prev('< ' . __('Previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Next') . ' >') ?>
            <?= $this->Paginator->last(__('Last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Showing {{current}} products  out of {{count}}')) ?></p>
    <?php } else {?>
        <p><?= $this->Paginator->counter(__('No products Found')) ?></p>

        </div>

        </div>
        <?php
    }
}
?>
