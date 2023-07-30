<title> Login </title>


<?php $this->Html->meta('description', 'Login Page for SevenSundays an Australian company selling washes oils and other skin products for ind, retailer portal link', ['block' => true]); ?>
<meta property="og:title" content="Seven Sundays Login"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content= <?= $this->Html->link(__(''), ['action' => 'login']) ?>
<meta property="og:image"
      content=  <?php echo $this->Html->image('SevenSundaysDark.png', array('width' => '180px', 'class' => 'img-fluid', 'alt' => 'Home')); ?>


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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h5>
                                            <?php echo $this->Html->image('SevenSundaysDark.png', array('width' => '180px', 'class' => 'img-fluid', 'alt' => 'Home')); ?>

                                        </h5> <br>
                                    </div>
                                    <div class="row">
                                        <?= $this->Flash->render() ?>
                                    </div>

                                    <?= $this->Form->create() ?>
                                    <div class="form-group">
                                        <?= $this->Form->control('email', [
                                            'type' => 'email', 'class' => 'form-control form-control-user',
                                            'required' => 'true',
                                            'aria-label' => 'Email',
                                            'aria-describedby' => 'email',
                                            'placeholder' => 'Enter Email Address...',
                                            'label' => false
                                        ]) ?>

                                    </div>
                                    <div class="form-group">

                                        <?= $this->Form->control('password', [
                                            'type' => 'password', 'class' => 'form-control form-control-user',
                                            'required' => 'true',
                                            'aria-label' => 'Password',
                                            'aria-describedby' => 'Password',
                                            'placeholder' => 'Password',
                                            'label' => false,
                                            'value' => ''
                                        ]) ?>

                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="showPassword">
                                            <label class="custom-control-label" for="showPassword">Show
                                                Password</label>
                                        </div>
                                    </div>
                                    <?= $this->Form->submit(__('Login'), ['style' => 'width: 100%', 'padding: 10%', 'name' => 'login-button', 'class' => 'btn btn-primary btn-user btn-block']) ?>


                                    <?= $this->Form->end() ?>

                                    <hr>
                                    <div class="text-center">
                                        <p style=" font-size: 15px; "> <?= $this->Html->link(__('Register Here'), ['action' => 'add']) ?> </p>
                                    </div>
                                    <div class="text-center">
                                        <p style=" font-size: 15px; ">  <?= $this->Html->link(__('Forgot Password?'), ['action' => 'forgot']) ?>
                                        </p>

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
