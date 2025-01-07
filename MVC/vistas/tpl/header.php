<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}
?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav <?php $_SESSION['tipo'] == 'admin' ? $color = 'bg-gradient-primary' : $color = 'bg-gradient-success'; echo $color; ?> sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index.php?view=iniciado">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Biblio<sup>teca</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <?php
        if ($_SESSION['tipo'] == 'admin') {
            include_once ("./vistas/tpl/menuAdmin.php");
        }else {
            include_once ("./vistas/tpl/menuUsuario.php");
        }
        ?>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <p class="text-center mb-2">Fabio <strong>CEDRES</strong></p>
            <p class="text-center mb-2">Wilson <strong>ARRIOLA</strong></p>
        </div>

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
                    <i class="fa fa-bars"></i>
                </button>

                <div id="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    ROL: <span><?php echo $_SESSION['tipo']; ?></span>
                </div>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo  $_SESSION['usuario'][0]['nombre'] . ' ' . $_SESSION['usuario'][0]['apellido']; ?></span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="../../index.php?view=salir" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Salir
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard <?php if (isset($_GET['view'])) echo '| ' . $_GET['view']; ?></h1>
                </div>

                <!-- Content Row -->
                <div class="row">