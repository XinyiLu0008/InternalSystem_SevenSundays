<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Webpage $webpage
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
            'title' => 'WebPages',
            'url' => ['controller' => 'webpages', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Edit Web Page',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
    ]);

    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
    ]);

    echo $this->Breadcrumbs->render(); ?>

    <div class="container-fluid">
        <aside class="column">
            <div class="side-nav">

            </div>
        </aside>
        <div class="column-responsive column-80" style="width:80%; margin:auto">
            <div class="webpages form content">
                <?= $this->Form->create($webpage,['type'=>'file'])?>
                <fieldset style="width:90%; margin:auto">
                    <legend><?= __('Edit Image') ?></legend>
                    <?php
                    echo $this->Form->control('title', [ 'class' => 'form-control', 'type' => 'hidden']);?>  <?php
                    echo $this->Form->control('location',[ 'class' => 'form-control', 'type' => 'hidden']);?>  <?php
                    echo $this->Form->control('image_file',['type'=>'file', 'class' => 'form-control-file', 'required' => true]);
                    ?> <br>
                </fieldset>
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Form->button(__('Submit'), ['style'=>'width: 90%', 'padding: 10%' , 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>

                        <?= $this->Form->end() ?>
                    </div>

                    <div class="col-lg-6 mx-auto ">
                        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style'=>'width: 90%','confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                        <br>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>
