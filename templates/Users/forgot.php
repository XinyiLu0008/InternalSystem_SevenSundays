<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<title> Forgot Password </title>
<meta name="robots" content="noindex nofollow" />
<?php $this->layout = 'mylayout'; ?>
<div class="users form content" style="background-color: #F3F2F0">
    <div class="bg-gradient-primary" style="border-radius: 25px 25px 25px 25px;">
        <body>

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>

                                        </div>
                                        <div class="row">
                                            <?= $this->Flash->render() ?>
                                        </div>

                                        <?= $this->Form->create(null,  ['class'=> 'user']) ?>
                                        <div class="form-group">
                                            <br>
                                            <?php echo $this->Form->control('email', ['type' => 'email', 'required' => true, 'class' => 'form-control form-control-user',
                                                'placeholder' => 'Enter your Email here',
                                                'label' => false, 'aria-label' => "Email"]); ?>
                                        </div>
                                        <?= $this->Form->submit(__('Send Reset Email'), ['style'=>'width: 100%', 'padding: 10%', 'margin: auto' ,'class' => 'btn btn-primary btn-user btn-block']) ?>


                                        <?= $this->Form->end() ?>

                                        <hr>
                                        <div class="text-center">
                                            <p style=" font-size: 15px; "> <?= $this->Html->link(__('Register Here'), ['action' => 'add']) ?> </p>
                                        </div>
                                        <div class="text-center">
                                            <p style=" font-size: 15px; "> <?= $this->Html->link(__('Login'), ['action' => 'login']) ?> </p>                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

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
        </body>

    </div>

<br>
