<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesProduct[]|\Cake\Collection\CollectionInterface $categoriesProducts
 */
?>

<?php

$userRole = $this->Identity->get('role');





$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'user_profile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);


$this->Breadcrumbs->add([
    [
        'title' => 'Product Category',
        'url' => ['controller' => 'categoriesProducts', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],

]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);

echo $this->Breadcrumbs->render(); ?>
<div class="container-fluid">
    <div class="inventories index content">
        <?= $this->Html->link(__('Add a Category Item'), ['action' => 'add'],
            ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
        <h3><?= __('Product Categories') ?></h3>
    <div class="table-responsive">
        <div class="table-responsive">
            <table class="table  table-hover table-bordered compact " id="example" width="100%" cellspacing="0">
                <tr>
                    <th><?= $this->Paginator->sort('Category No.') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriesProducts as $categoriesProduct): ?>
                <tr>
                    <td> <?= $this->Number->format($categoriesProduct->id) ?></td>
                    <td><?= h($categoriesProduct->name) ?></td>

                    <td class="actions">
                        <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['action' => 'view', $categoriesProduct->id],
                            ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>
                        <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $categoriesProduct->id],
                            ['escape' => false,'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>
                        <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['action' => 'delete', $categoriesProduct->id],
                            ['confirm' => __('Are you sure you want to delete the category of {0}?', $categoriesProduct->name), 'escape' => false,'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>
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
