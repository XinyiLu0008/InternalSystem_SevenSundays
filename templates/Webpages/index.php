<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Webpage[]|\Cake\Collection\CollectionInterface $webpages
 */
?>

<?php
    $userRole = $this->Identity->get('role');

    if (($userRole === 'admin')) {
    $this->Breadcrumbs->add([
    [
    'title' => 'Dashboard',
    'url' => ['controller' => 'users', 'action' => 'user_profile'],
    'options' => ['class' => 'breadcrumb-item']
    ]]);

    $this->Breadcrumbs->add([
    [
    'title' => 'Users',
    'url' => ['controller' => 'webpages', 'action' => 'index'],
    'options' => ['class' => 'breadcrumb-item'],
    ]]);

    $this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

    ]);

    echo $this->Breadcrumbs->render(); ?>

    <div class="container-fluid">
        <div class="webpages index content">
            <h3><?= __('Web Pages') ?></h3>

            <div class="card shadow mb-4 ">
                <div class="card-header py-3 d-flex">
                    <?php echo $this->Form->create(null, ['type'=>'get','class'=>'form-inline my-2 my-lg-0']) ?>
                    <?= $this->Form->input('key', ['label' => 'Search', 'class'=>'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                    <?= $this->Form->end() ?>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('image') ?></th>
                        <th><?= $this->Paginator->sort('location') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($webpages as $webpage): ?>
                        <tr>

                            <td><?= h($webpage->title) ?></td>
                            <td><?= @$this->Html->image($webpage->image, ['style' => 'background-position: center;
    background-size: cover; max-width:50px;border-radius:50%;']) ?></td>
                            <td><?= h($webpage->location) ?></td>

                            <td class="actions">
                                <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $webpage->id],
                                    ['escape' => false,'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

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
