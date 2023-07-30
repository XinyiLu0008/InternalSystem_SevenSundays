<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Packaging $packaging
 * @var \Cake\Collection\CollectionInterface|string[] $manufacturers
 */
?>
<?php
$key = isset($key) ? $key : '<%= key %>';

$userRole = $this->Identity->get('role');

if ($userRole === 'admin') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

    $this->Breadcrumbs->add([
        [
            'title' => 'Packagings',
            'url' => ['controller' => 'packagings', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Update Many Packaging Items',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
    ]);

    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
    ]);

    echo $this->Breadcrumbs->render(); ?>

    <div class="container-fluid">


        <?= $this->Form->create();?>


        <div class="row">
            <div class="col-lg-9" style="margin: auto;">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">

                        <legend style="color: #5D51AF;"><?= __('Update Packagings Quantities') ?></legend>
                    </div>

                    <div class="card-body" style="">
                        <div id="contact-container">
                            <div class="row contact-row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <?php echo $this->Form->control("0.id",['options' => $packagings,'label'=>'Packaging','required'=> true,'class'=>'form-control']);?>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <?php echo $this->Form->control("0.total_quantity",['min' => '1','max' => '1000000', 'type' => 'number','class'=>'form-control' ,'label'=>'Quantity']);?>
                                    </div>
                                </div>

                                <div class="col-1 d-flex">
                                    <a class="contact-delete" href="#"><i class="fa fa-fw fa-trash"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary btn btn-md" id="add-contact-button" >Add Packaging</button>
                            </div>
                        </div>

                        <script id="contact-template" type="text/x-underscore-template">
                            <div class="row contact-row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <?php echo $this->Form->control("{$key}.id", ['options' => $packagings,'label'=>'Packaging','required'=> true, 'class'=>'form-control']);?>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <?php echo $this->Form->control("{$key}.total_quantity",['min' => '1','max' => '1000000', 'type' => 'number', 'class'=>'form-control'  ,'label'=>'Quantity' ]);?>
                                    </div>
                                </div>

                                <div class="col-1 d-flex">
                                    <a class="contact-delete" href="#"><i class="fa fa-fw fa-trash"></i></a>
                                </div>
                            </div>
                        </script>
                    </div>
                </div>
            </div>
        </div>

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

<?php } ?>
</div>
<?php echo $this->Html->script(['bootstrap-select.min','underscore-min.js','company'],['block'=>true]) ?>

