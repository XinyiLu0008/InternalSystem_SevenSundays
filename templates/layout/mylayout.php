<!DOCTYPE html>
<html lang="en">
<?php $userRole = $this->Identity->get('role'); ?>
<head>

    <!-- Custom styles for this template-->
    <?= $this->Html->css('sb-admin-2.css') ?>
    <?= $this->Html->css('/vendor/fontawesome-free/css/all.min.css') ?>

    <?= $this->Html->meta('icon') ?>


    <?= $this->fetch('css') ?>

    <meta property="og:site_name" content="Seven Sundays">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="keywords" content="sevensundays, baby products, washes, oils">
    <meta name="author" content="SevenSundays"/>
    <meta name="HandheldFriendly" content="True">
    <meta name="theme-color" content="#8085A2">

    <?= $this->fetch('meta') ?>

    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
          type="text/css"/>
    <!-- Core theme CSS (includes Bootstrap)-->
</head>


<header id="page-top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-primary border-bottom-warning text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a href="<?= $this->Url->build('/') ?>"> <?php echo $this->Html->image('SevenSundaysLight.png', array('width' => '180px', 'class' => 'img-fluid', 'alt' => 'Seven Sundays White Logo')); ?>
            </a>
            <button
                class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-info text-white rounded"
                type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>


            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">


                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                           href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'login']) ?>">
                            <i class="fas fa-user"></i>
                            <span>LogIn</span></a></li>
                </ul>
            </div>
        </div>
    </nav>


    <div style="padding-top: 5%; background-color: #F3F2F0">
        <div class="header-b">

        </div>
    </div> <!-- header-b ends -->


</header>


<div class="container-fluid">
    <?= $this->Flash->render() ?>
</div>

<main class="main">


    <?= $this->fetch('content') ?>

</main>


<!-- Footer-->


</div><!-- #page -->

<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
<div class="scroll-to-top d-lg-none position-fixed">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"> Top <i
            class="fa fa-chevron-up"  aria-label="Page Top Button" ></i></a>
</div>

<!-- Bootstrap core JS-->

<?= $this
    ->Html
    ->script('/vendor/jquery/jquery.min.js'); ?>

<!-- Bootstrap core JavaScript-->
<?= $this
    ->Html
    ->script('/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>

<!-- Core plugin JavaScript-->
<?= $this
    ->Html
    ->script('/vendor/jquery-easing/jquery.easing.min.js'); ?>

<?= $this->fetch('script') ?>


</html>

