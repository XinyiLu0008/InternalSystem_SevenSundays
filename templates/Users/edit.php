<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php

$userRole = $this->Identity->get('role');


if ($userRole === 'admin') {

    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user-profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);


    $this->Breadcrumbs->add([
        [
            'title' => 'User',
            'url' => ['controller' => 'users', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item'],
        ],
        [
            'title' => 'Update user profile',
            'options' => ['class' => 'breadcrumb-item active',
            ],
        ],
    ]);

    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
    ]);

    echo $this->Breadcrumbs->render(); ?>

    <div class="container-fluid">

        <div class="column-responsive column-80" style="width:80%; margin:auto">
            <div class="users form content">
                <?= $this->Form->create($user) ?>
                <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Update user profile</h2>

                <fieldset class="text-primary" style="width:90%; margin:auto ">


                    Name
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('first_name', ['class' => 'form-control']); ?>
                        </div>


                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <?php echo $this->Form->control('last_name', ['class' => 'form-control']); ?>
                        </div>
                    </div>
                    Contact
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('phone', ['placeholder' => '0412345678','class' => 'form-control','type' => 'tel']); ?>
                        </div>


                        <div class="col-sm-6">
                            <?php
                            echo $this->Form->control('email', ['class' => 'form-control', 'type' => 'email']); ?>
                        </div>

                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('country', [
                                'class' => 'form-control form-control-user', 'type' => 'select', 'options' => $countries, 'default' => 'Australia', 'empty' => false
                            ]); ?>
                        </div>

                    </div>
                    Security
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('password', ['class' => 'form-control']); ?>
                        </div>


                        <div class="col-sm-3">
                            <?php
                            echo $this->Form->control('role', ['class' => 'form-control', 'type' => 'select', 'options' => ['admin' => 'Admin',
                                'customer' => 'Customer']]);
                            ?>

</div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="showPassword">
                            <label class="custom-control-label" for="showPassword">Show
                                Password</label>
                        </div>
                    </div>
                        <br>

                </fieldset>
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Form->button(__('Submit'), ['style' => 'width: 90%', 'padding: 10%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="col-lg-6 mx-auto ">
                        <?= $this->Html->link(__('Cancel'), ['action' => 'index'],
                            ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to abandon the changes?'), 'class' => ' button float-left  btn btn-danger']) ?>
                        <br>
                        <br>
                    </div>

                </div>


            </div>
        </div>
    </div>


<?php }
else if ($userRole === 'customer') {
    $this->Breadcrumbs->add([
    [
    'title' => 'Dashboard',
    'url' => ['controller' => 'users', 'action' => 'retailer-profile'],
    'options' => ['class' => 'breadcrumb-item']
    ]]);


    $this->Breadcrumbs->add([
    [
    'title' => 'Update my profile',
    'options' => ['class' => 'breadcrumb-item active',
    ],
    ],
    ]);

    $this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
    ]);

    echo $this->Breadcrumbs->render(); ?>

    <div class="container-fluid">

        <div class="column-responsive column-80" style="width:80%; margin:auto">
            <div class="users form content">
                <?= $this->Form->create($user) ?>

                    <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Update My Profile</h2>
                <fieldset class="text-primary" style="width:90%; margin:auto ">


                    Name
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('first_name', ['class' => 'form-control']); ?>
                        </div>


                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <?php echo $this->Form->control('last_name', ['class' => 'form-control']); ?>
                        </div>
                    </div>
                    Contact
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('phone', ['placeholder' => '0412345678','class' => 'form-control','type' => 'tel']); ?>
                        </div>


                        <div class="col-sm-6">
                            <?php
                            echo $this->Form->control('email', ['class' => 'form-control', 'type' => 'email']); ?>
                        </div>

                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('country', [
                                'class' => 'form-control form-control-user', 'type' => 'select', 'options' => $countries, 'default' => 'Australia', 'empty' => false
                            ]); ?>
                        </div>

                    </div>
                    Security
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('password', ['class' => 'form-control']); ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="showPassword">
                            <label class="custom-control-label" for="showPassword">Show
                                Password</label>
                        </div>
                    </div>
                    <br>

                </fieldset>
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Form->button(__('Submit'), ['style' => 'width: 90%', 'padding: 10%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="col-lg-6 mx-auto ">
                        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                        <br>
                        <br>
                    </div>

                </div>


            </div>
        </div>
    </div>

<?php } ?>

<script>
    $(document).ready(function () {
        $('#country').select2();
    });
</script>
<script type="text/javascript">

    var password = document.querySelector("#password");
    var toggle = document.querySelector("#showPassword");

    toggle.addEventListener("click", handleToggleClick, false);

    function handleToggleClick(event) {

        if (this.checked) {
            console.warn("Change input 'type' to: text");
            password.type = "text";
        } else {
            console.warn("Change input 'type' to: password");
            password.type = "password";
        }
    }

</script>
