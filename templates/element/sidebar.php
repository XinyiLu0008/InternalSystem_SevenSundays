<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <div class="container" style="margin: 10px; margin-left: 0px">
        <!-- Sidebar - Brand -->
        <a href="<?= $this->Url->build('/') ?>"> <?php echo $this->Html->image('sevensundayslogo_white.png', array('width' => '180px', 'class' => 'img-fluid', 'alt' => 'sevensundayslogo')); ?>
        </a>

    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <!-- Nav Item - Dashboard -->

    <li class="nav-item">
        <a class="nav-link"


           href="<?php echo $this
               ->Url
               ->build(['controller' => 'Users', 'action' => 'user_profile']) ?> ">

            <i class="fas fa-columns"></i>
            <span><b>DASH-BOARD</b></span></a>
    </li>

    <hr class="sidebar-divider my-0">



    <li class="nav-item">
        <a  <?php if (isset($controller) == 'Sales') { ?>
            style="background-color: ghostwhite; color: #8085AC; border-radius: 1000px;"
        <?php } ?> class="nav-link"
            href="<?php echo $this
                ->Url
                ->build(['controller' => 'Inventories', 'action' => 'Index']) ?>">

            <i class="fas fa-warehouse"></i>
            <span>Inventories</span></a>


        <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item ">
        <a class="nav-link"
           href="<?php echo $this
               ->Url
               ->build(['controller' => 'Packagings', 'action' => 'Index']) ?>">
            <i class="fas fa-box-open"></i>
            <span>Packaging</span></a>

        <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item ">
        <a class="nav-link"
           href="<?php echo $this
               ->Url
               ->build(['controller' => 'Products', 'action' => 'Index']) ?>">
            <i class="fas fa-pump-soap"></i>
            <span>Product</span></a>

    <li class="nav-item ">
        <a class="nav-link"
           href="<?php echo $this
               ->Url
               ->build(['controller' => 'Manufacturers', 'action' => 'Index']) ?>">
            <i class="fas fa-wrench"></i>
            <span>Manufacturer</span></a>

    <li class="nav-item ">
        <a class="nav-link"
           href="<?php echo $this
               ->Url
               ->build(['controller' => 'Sales', 'action' => 'Index']) ?>">
            <i class="fas fa-cash-register"></i>
            <span>Sales</span></a>


    <li class="nav-item ">
        <a class="nav-link"
           href="<?php echo $this
               ->Url
               ->build(['controller' => 'Users', 'action' => 'Index']) ?>">
            <i class="fas fa-users"></i>
            <span>User</span></a>


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
