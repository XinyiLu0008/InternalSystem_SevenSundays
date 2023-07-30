<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var AppView $this
 */

use App\View\AppView;$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<?php
$userRole = $this
    ->Identity
    ->get('role');

?>

<!DOCTYPE html>
<html>
<head>

    <?=$this
        ->Html
        ->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:site_name" content="Seven Sundays">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="keywords" content="sevensundays, baby products, washes, oils">
    <meta name="author" content="SevenSundays"/>
    <meta name="HandheldFriendly" content="True">
    <meta name="theme-color" content="#8085A2">

    <?=$this
        ->Html
        ->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">



</head>

<head>
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <!-- Custom styles for this template-->

    <?=$this
        ->Html
        ->css('sb-admin-2.css') ?>

    <?=$this
        ->Html
        ->css('/vendor/fontawesome-free/css/all.min.css') ?>

    <?=$this
        ->Html
        ->charset() ?>


    <?=$this->fetch('meta') ?>
    <?=$this->fetch('css') ?>

    <?=$this
        ->Html
        ->script('/vendor/jquery/jquery.min.js'); ?>

</head>
<?php if ($userRole === 'customer') { ?>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <div class="container" style="margin: 10px; margin-left: 0px">
                <!-- Sidebar - Brand -->
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'retailer_profile']) ?>"> <?php echo $this->Html->image('SevenSundaysLight.png', array('width' => '180px', 'class' => 'img-fluid','alt'=>'sevensundayslogo'));?>
                </a>

            </div>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">


            <!-- Nav Item - Dashboard -->

            <li class="nav-item">
                <a <?php if (isset($controller) && $controller == "Dashboard") { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>


                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Users', 'action' => 'retailer_profile']) ?> ">

                    <i class="fas fa-columns"></i>
                    <span><b>DASH-BOARD</b></span></a>
            </li>

            <hr class="sidebar-divider my-0">




                <!-- Nav Item - Pages Collapse Menu -->


                <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Products') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Products', 'action' => 'Index']) ?>">
                    <i class="fas fa-pump-soap"></i>
                    <span>Products</span></a>

            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Sales') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Sales', 'action' => 'Index']) ?>">
                    <i class="fas fa-box-open"></i>
                    <span>My Orders</span></a>



                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-arrow-left"></i>
                    <span>Log Out </span></a>
            </li

                <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-md-inline">
                <button class="rounded-pill border-0" id="sidebarToggle"></button>
            </div>


            <!-- Sidebar Message -->


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars fa-2x"></i>
                    </button>

                    <?php
                    if ($userRole === 'customer')
                    {
                        ?>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">


                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                         <span class="badge badge-secondary">  <?= $this->Identity->get('role') ?></span>
                                        <?php echo $this
                                            ->Identity
                                            ->get('first_name');
                                        echo " ";
                                        echo $this
                                            ->Identity
                                            ->get('last_name') ?></span>

                                </a>

                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                     aria-labelledby="userDropdown">

   <div class="col-lg-8">
                                    <a class="dropdown-item" <?php if ($userRole === 'customer') { ?>
                                       href=" <?= $this->Url->build(
                                           ['controller' => 'Users','action' => 'edit', $this->Identity->get('id')], ['class' => 'side-nav-item']) ?> ">
                                        <?php } ?>


                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Update Profile
                                    </a>
</div>

                                    <div class="col-lg-8">
                                        <a class="dropdown-item"
                                           href="<?php echo $this
                                               ->Url
                                               ->build(['controller' => 'Users', 'action' => 'logout']) ?>" data-toggle="modal" data-target="#logoutModal">

                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </a>
                                    </div>


                                </div>

                            </li>

                        </ul>

                        <?php
                    } ?>
                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <?=$this
                        ->Flash
                        ->render() ?>

                </div>

                <main class="main">

                    <?=$this->fetch('content') ?>

                </main>
                <!-- End of Main Content -->


            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->


    </body>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</a>
                    <a class="btn btn-primary" type="button"
                       href="<?php echo $this
                           ->Url
                           ->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="404">Site under Maintenance </div>

            <p class="text-gray-500 mb-0">This site will be available for your use soon </p>
            <a href="<?php echo $this
                ->Url
                ->build(['controller' => 'Users', 'action' => 'logout']) ?>">&larr; Back to Login</a>
        </div>

    </div>
    <!-- /.container-fluid -->
    <?php
} ?>

<!-- Mobile Responsive data tables-->
<?php

echo $this->Html->script('//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js');
echo $this->Html->script('//cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js');
echo $this->Html->script('//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js');

?>

<!-- Bootstrap core JavaScript-->

<?=$this
    ->Html
    ->script('/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>

<!-- Mobile Responsive data tables-->
<?= $this
    ->Html
    ->script('datatables.min.js'); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js' , ['block' => true]); ?>


<!-- Core plugin JavaScript-->
<?=$this
    ->Html
    ->script('/vendor/jquery-easing/jquery.easing.min.js'); ?>

<!-- Custom scripts for all pages-->
<?=$this
    ->Html
    ->script('sb-admin-2.min.js'); ?>

<?= $this->Html->script('/demo/datatables-demo.js', ['block' => true]); ?>

<!-- Page level plugins -->
<?=$this->fetch('script') ?>

<!-- Script for Data Tables -->
<script>

    // Call the dataTables jQuery plugin
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": false,
            "autoFill": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },

        });
    });
</script>


<title>
    <?=$this->fetch('title') ?>
</title>
</html>
