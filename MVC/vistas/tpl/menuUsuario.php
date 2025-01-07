<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}
?>

<!--<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=registrarLibro">
        <i class="fas fa-fw fa-book"></i>
        <span>Registrar Libro</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=registrarAutor">
        <i class="fas fa-fw fa-user"></i>
        <span>Registrar Autor</span></a>
</li>
<hr class="sidebar-divider">-->

<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=gestionarPrestamo">
        <i class="fas fa-fw fa-arrow-alt-circle-up"></i>
        <span>Gestionar Prestamo</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=gestionarDevolucion">
        <i class="fas fa-fw fa-arrow-alt-circle-down"></i>
        <span>Gestionar Devolucion</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=buscarLibro">
        <i class="fas fa-fw fa-search"></i>
        <span>Buscar Libro</span></a>
</li>
<!-- Divider -->
<!--<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=registrarUsuario">
        <i class="fas fa-fw fa-user"></i>
        <span>Registrar Usuario</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../../index.php?view=registrarAdmin">
        <i class="fas fa-fw fa-user-secret"></i>
        <span>Registrar Admin</span></a>
</li>-->
