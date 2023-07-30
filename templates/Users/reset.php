<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<title> Reset Password </title>
<meta name="robots" content="noindex nofollow" />

<?php $this->layout = 'mylayout'; ?>
<div class="container-fluid" style="background-color:  #F6F6F6">

    <div class="users form content" style="border-radius: 25px;">
        <div class="bg-gradient-primary" style="border-radius: 25px;">

            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card border-0 shadow rounded-3 my-5">
                            <div class="card-body p-4 p-sm-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Reset Password</h1>
                                    <div class="row">
                                        <?= $this->Flash->render() ?>
                                    </div>
                                </div>
                                <?= $this->Form->create($user, ['class' => 'user']) ?>


                                <?php
                                echo $this->Form->control('first_name', ['type' => 'hidden']);
                                echo $this->Form->control('last_name', ['type' => 'hidden']);
                                echo $this->Form->control('phone', ['type' => 'hidden']);
                                echo $this->Form->control('email', ['type' => 'hidden']); ?>

                                <div class="form-group">
                                    <br>
                                    <?php echo $this->Form->control('password', ['value' => '', 'type' => 'password', 'class' => 'form-control form-control-user',
                                        'placeholder' => 'Enter your Password here',
                                        'label' => false, 'aria-label' => "password"]); ?>
                                    <br>
                                    <?php echo $this->Form->control('retype_password', ['value' => '', 'type' => 'password', 'class' => 'form-control form-control-user',
                                        'placeholder' => 'Re-type Password',
                                        'label' => false, 'aria-label' => "re-type password"]); ?>
                                </div>
                                <?= $this->Form->submit(__('Reset My Password'), ['style'=>'width: 100%', 'padding: 10%', 'margin: auto' ,'class' => 'btn btn-primary btn-user btn-block']) ?>


                                <?= $this->Form->end() ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

