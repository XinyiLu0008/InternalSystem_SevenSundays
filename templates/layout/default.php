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
use App\View\AppView;
$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<?php
$userRole = $this
    ->Identity
    ->get('role');


?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta property="og:site_name" content="Seven Sundays">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="keywords" content="sevensundays, baby products, washes, oils">
    <meta name="author" content="SevenSundays"/>
    <meta name="HandheldFriendly" content="True">
    <meta name="theme-color" content="#8085A2">

    <?= $this
        ->Html
        ->meta('icon') ?>

    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex nofollow" />

    <?= $this
        ->Html
        ->css('sb-admin-2.css') ?>

    <?= $this
        ->Html
        ->css('/vendor/fontawesome-free/css/all.min.css') ?>

    <?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.css', ['block' => true]); ?>

    <?= $this
        ->Html
        ->charset() ?>

    <?= $this
        ->Html
        ->script('/vendor/jquery/jquery.min.js'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

</head>

<?php if ($userRole === 'admin') { ?>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <div class="container" style="margin: 10px; margin-left: 0px">
                <!-- Sidebar - Brand -->
                <a href="<?= $this->Url->build('/') ?>"> <?php echo $this->Html->image('SevenSundaysLight.png', array('width' => '180px', 'class' => 'img-fluid', 'alt' => 'sevensundayslogo')); ?>
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
                       ->build(['controller' => 'Users', 'action' => 'user_profile']) ?> ">

                    <i class="fas fa-columns"></i>
                    <span>DASHBOARD</span></a>
            </li>

            <hr class="sidebar-divider my-0">



            <li class="nav-item">
                <a <?php if (isset($controller) && $controller == 'Inventories') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                    <?php } else {  ?> class=" nav-link " <?php } ?>
                    href="<?php echo $this
                        ->Url
                        ->build(['controller' => 'Inventories', 'action' => 'Index']) ?>">

                    <i class="fas fa-warehouse"></i>
                    <span>Inventories</span></a>


                <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Packagings') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>

                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Packagings', 'action' => 'Index']) ?>">
                    <i class="fas fa-box-open"></i>
                    <span>Packaging</span></a>

                <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item ">

            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a <?php if (isset($controller) && $controller == 'Products') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                    href="<?php echo $this
                        ->Url
                        ->build(['controller' => 'Products', 'action' => 'Index']) ?>">
                    <i class="fas fa-pump-soap"></i>
                    <span>Products</span></a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

                </div>
            </li>

            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Manufacturers') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Manufacturers', 'action' => 'Index']) ?>">
                    <i class="fas fa-wrench"></i>
                    <span>Manufacturers</span></a>

            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Sales') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Sales', 'action' => 'Index']) ?>">
                    <i class="fas fa-cash-register"></i>
                    <span>Sales</span></a>

            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Shopifysales') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                    href="<?php echo $this
                        ->Url
                        ->build(['controller' => 'Shopifysales', 'action' => 'Index']) ?>">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Shopify Sales</span></a>


            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Users') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                   href="<?php echo $this
                       ->Url
                       ->build(['controller' => 'Users', 'action' => 'Index']) ?>">
                    <i class="fas fa-users"></i>
                    <span>Users</span></a>

            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Webpages') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                    href="<?php echo $this
                        ->Url
                        ->build(['controller' => 'Webpages', 'action' => 'Index']) ?>">
                    <i class="fa fa-file"></i>
                    <span>Web Pages</span></a>

            </li>
            <li class="nav-item ">
                <a <?php if (isset($controller) && $controller == 'Categories') { ?>
                    style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px; width: 98%; margin: auto" class=" nav-link selected"
                <?php } else {  ?> class=" nav-link " <?php } ?>
                    href="<?php echo $this
                        ->Url
                        ->build(['controller' => 'CategoriesProducts', 'action' => 'Index']) ?>">
                    <i class="fa fa-list-alt"></i>
                    <span>Products Categories</span></a>
            </li>
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
                <nav class="navbar border-bottom-warning navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars fa-2x"></i>
                    </button>

                    <?php
                    if ($userRole === 'admin') {
                        ?>
                        <!-- Topbar Search -->


                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle  small" href="<?= $this->Url->build('/notifications') ?>"
                                 >

                                    <i class="fas fa-bell fa-fw"></i>
                                    Notifications
                                    <!-- Counter - Alerts -->

                                </a>
                            </li>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" aria-describedby="To Top Button" role="button"
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
                                    <a class="dropdown-item" <?php if ($userRole === 'admin') { ?>
                                       href=" <?= $this->Url->build(
                                           ['controller' => 'Users','action' => 'edit', $this->Identity->get('id')], ['class' => 'side-nav-item']) ?> ">
                                        <?php }
                                        if ($userRole === 'customer') { ?>
                                            href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'customer_profile']) ?> ">
                                        <?php } ?>


                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Update Profile
                                    </a>

                                    <a class="dropdown-item" <?php if ($userRole === 'admin') { ?>
                                       href=" <?= $this->Url->build(
                                           ['controller' => 'Users','action' => 'user_profile', $this->Identity->get('id')], ['class' => 'side-nav-item']) ?> ">
                                        <?php }
                                        if ($userRole === 'customer') { ?>
                                            href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'retailer_profile']) ?> ">
                                        <?php } ?>


                                        <i class="fa fa-bookmark fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Dashboard
                                    </a>


                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>"
                                       data-toggle="modal" data-target="#logoutModal">


                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>

                                </div>

                            </li>

                        </ul>

                        <?php
                    } ?>
                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <?= $this
                        ->Flash
                        ->render() ?>

                </div>

                <main class="main">

                    <?= $this->fetch('content') ?>

                </main>
                <!-- End of Main Content -->


            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->


    </body>

    <a class="scroll-to-top rounded" href="#page-top" aria-label="Page Top Button">
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

<?php }
?>

<!-- Bootstrap core JavaScript-->
<?= $this
    ->Html
    ->script('/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>

<!-- Mobile Responsive data tables-->
<?= $this
    ->Html
    ->script('datatables.min.js'); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js' , ['block' => true]); ?>


<!-- Core plugin JavaScript-->
<?= $this
    ->Html
    ->script('/vendor/jquery-easing/jquery.easing.min.js'); ?>

<!-- Custom scripts for all pages-->
<?= $this
    ->Html
    ->script('sb-admin-2.min.js'); ?>

<!-- Page level plugins -->
<?= $this->fetch('script') ?>

<?= $this->Html->script('/demo/datatables-demo.js', ['block' => true]); ?>

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
    <?= $this->fetch('title') ?>
</title>
</html>

