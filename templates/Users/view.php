<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
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
        'title' => 'Users',
        'url' => ['controller' => 'users', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'User Detail',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);
echo $this->Breadcrumbs->render(); ?>


<div class="container-fluid">


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-title mb-4">

                            <div class="d-flex justify-content-start">

                                <div class="image-container">
                                    <?= $this->Html->image('user2.png', ['style' => 'max-width:140px;height:120px;']); ?>

                                    <div class="middle">

                                        <input type="file" style="display: none;" id="profilePicture" name="file" />
                                    </div>
                                </div>

                                <div class="userData ml-3">
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);"><?= h( $user->first_name) ?> <?= h($user->last_name) ?></a></h2>
                                    <p><span class="mr-1"><i class="fa fa-map-pin" aria-hidden="true"></i> <?=  h($user->country) ?></span></p>


                                    <button type="button" class="btn btn-light btn-md mr-1 mb-2"><i
                                            class="fa fa-plus-square"> </i>
                                       <?= $this->Html->link(__('   Update'),
                                            ['action' => 'edit', $user->id]) ?></button>


                                </div>

                                <div class="ml-auto">
                                    <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                                    <span class="badge badge-secondary"> <?= h($user->role) ?></span> Created: <?= h($user->created) ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">User Info</a>
                                    </li>

                                </ul>
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">


                                        <div class="row">
                                            <div class="col">  <label style="font-weight:bold;">First Name</label></div>
                                            <div class="col"><?= h($user->first_name) ?></div>
                                            <div class="col"><label style="font-weight:bold;">Last Name</label></div>
                                            <div class="col"><?= h($user->last_name) ?></div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col">  <label style="font-weight:bold;">Email</label></div>
                                            <div class="col"><a href="mailto:<?= h($user->email) ?>"><?= h($user->email) ?></a></div>
                                            <div class="col"><label style="font-weight:bold;">Phone</label></div>
                                            <div class="col"><?= h($user->phone) ?></div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col">  <label style="font-weight:bold;">Role</label></div>
                                            <div class="col"><?= h($user->role) ?></div>
                                            <div class="col"><label style="font-weight:bold;">Country</label></div>
                                            <div class="col"><?= h($user->country) ?></div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col">  <label style="font-weight:bold;">Account Created</label></div>
                                            <div class="col"><?= h($user->created) ?></div>
                                            <div class="col"><label style="font-weight:bold;">Last Modified</label></div>
                                            <div class="col"><?= h($user->modified) ?></div>
                                        </div>
                                        <hr />


                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>




        </div>
        &nbsp;



    </div>
</div>
</div>
