<meta property="og:site_name" content="Seven Sundays">
<meta property="og:title" content="Seven Sundays Register" />
<meta property="og:type" content="website" />
<meta property="og:url" content= <?= $this->Html->link(__(''), ['action' => 'add']) ?>
<meta property="og:image" content=  <?php echo $this->Html->image('SevenSundaysDark.png', array('width' => '180px', 'class' => 'img-fluid', 'alt' => 'Home')); ?>

 <?php $this->Html->meta('description', 'Register Page for SevenSundays an Australian company selling washes oils and other skin products for infants and young children, retailer portal registration', ['block' => true]); ?>


<?php
$userRole = $this->Identity->get('role');

if ($userRole === 'admin') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'userProfile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);



$this->Breadcrumbs->add([
    [
        'title' => 'Users',
        'url' => ['controller' => 'users', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item '],
    ]]);
    $this->Breadcrumbs->add([
        [
            'title' => 'Add a New User',

            'options' => ['class' => 'breadcrumb-item '],
        ]]);

    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

    ]);

    echo $this->Breadcrumbs->render();
} ?>


<!--for admin -->
<?php
$userRole = $this->Identity->get('role');
if ($userRole === 'admin') { ?>
    <?= $this->Form->create($user) ?>

    <?php
    echo $this->Html->css('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', ['block' => true]);
    echo $this->Html->script('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['block' => true]);
    ?>

    <div class="container-fluid">

        <div class="column-responsive column-80">
            <div class="manufacturers form content">
                <?= $this->Form->create($user) ?>
               <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Add a New User</h2>

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
                            echo $this->Form->control('phone', ['class' => 'form-control', 'type' => 'tel']); ?>
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
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('password', ['class' => 'form-control']); ?>
                        </div>

                        <div class="col-sm-3">
                            <?php
                            echo $this->Form->control('role', ['class' => 'form-control', 'type' => 'select', 'options' => [
                                'admin' => 'Admin',
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
                        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                        <br>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <!--for outsiders -->
    <title> Register </title>
    <?php $this->layout = 'mylayout'; ?>
    <div class="users form content" style="background-color: #F3F2F0">
        <div class="bg-gradient-primary" style="border-radius: 25px 25px 25px 25px; padding: 10px">

            <div class="container">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
                                    </div>
                                    <?= $this->Form->create($user, ['class' => 'user']) ?>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">

                                            <?php echo $this->Form->control('first_name', ['class' => 'form-control ',
                                                'placeholder' => 'First Name *',
                                                'label' => false, 'aria-label' => "First Name"]); ?>

                                        </div>

                                        <div class="col-sm-6">
                                            <?php echo $this->Form->control('last_name', ['class' => 'form-control ',
                                                'placeholder' => 'Last Name *',
                                                'label' => false, 'aria-label' => "Last Name"]); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">

                                        <?php echo $this->Form->control('email', ['type' => 'email', 'class' => 'form-control',
                                            'placeholder' => 'Email *',
                                            'label' => false, 'aria-label' => "email"]); ?>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <?php echo $this->Form->control('phone', ['class' => 'form-control',
                                                'placeholder' => 'Phone Number *',
                                                'type' => 'tel',
                                                'label' => false, 'aria-label' => "Phone Number"]); ?>


                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <?php echo $this->Form->control('country', ['class' => 'form-control ',
                                                'placeholder' => 'Country *', 'type' => 'select', 'options' => $countries, 'default' => 'Australia', 'empty' => false,
                                                'label' => false, 'aria-label' => "Country"]); ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <?php echo $this->Form->control('password', ['class' => 'form-control ',
                                                'placeholder' => 'Password *',
                                                'id' => 'password',
                                                'name' => 'password',
                                                'label' => false, 'aria-label' => "Password"]); ?>
                                        </div>


  <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="showPassword">
                                    <label class="custom-control-label" for="showPassword">Show Password</label>
                                </div>
                            </div>

                                    </div>
                                    <?php

                                    echo $this->Form->control('role', ['class' => 'form-control', 'default' => 'customer', 'type' => 'hidden']);
                                    ?>
<small id="firstNameHelpBlock" class="form-text " style="color: red;">
 * Indicates a required field
</small>
<br>
                                    <?= $this->Form->submit(__('REGISTER'), ['style' => 'width: 100%', 'padding: 10%', 'class' => 'btn btn-primary btn-user btn-block']) ?>



                                    <?= $this->Form->end() ?>
                                    <hr>
                                    <div class="text-center">
                                        <p style=" font-size: 15px; "> <?= $this->Html->link(__('Login'), ['action' => 'login']) ?> </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>



<?php } ?>



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
