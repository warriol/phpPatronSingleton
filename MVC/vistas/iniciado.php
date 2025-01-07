<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
} else {
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();

    $prestamo = new MPrestamo($db);
}
?>
<div class="container">
    <h3>Hola <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo  $_SESSION['usuario'][0]['nombre'] . ' ' . $_SESSION['usuario'][0]['apellido']; ?>.</span></h3>
    <h5>Bienvenido a la autogestion de su Biblioteca.</h5>
    <hr>
    <div class="row">
<?php
if ($_SESSION['tipo'] != 'admin') {
    $prestamoTotal = $prestamo->buscarPrestamosCantXId();
?>
        <div class="col-lg-6">
            <div class="card mb-4 py-3 border-left-primary">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Usted tiene <strong><?php echo $prestamoTotal; ?></strong> libros prestados.
                    </div>
                    <a class="card-link" href='index.php?view=gestionarDevolucion' class='btn btn-primary'>Ir a: Gestionar Devolucion.</a>
                </div>
            </div>
        </div>
<?php
}else {
    include_once './modelo/MAdmin.php';
    include_once './modelo/MUsuario.php';
    include_once './modelo/MLibro.php';

    $usr = new MUsuario($db);
    $admin = new MAdmin($db);
    $libro = new MLibro($db);

    $prestamoTotal = $prestamo->buscarPrestamosCant();
    $usuarioTotal = $usr->buscarUsuariosCant();
    $adminTotal = $admin->buscarAdminsCant();
    $libroTotal = $libro->buscarLibrosCant();
    $noDevueltos = $prestamo->buscarPrestamosNoDevueltosCant();
?>
        <lu>
            <li><h3>Total de libros prestados: <span class="badge bg-info"><?php echo $prestamoTotal; ?></span></h3></li>
            <li><h3>Total de libro no devueltos: <span class="badge bg-info"><?php echo $noDevueltos; ?></span></h3></li>
            <li><h3>Total de usuarios registrados: <span class="badge bg-info"><?php echo $usuarioTotal; ?></span></h3></li>
            <li><h3>Total de administradores registrados: <span class="badge bg-info"><?php echo $adminTotal; ?></span></h3></li>
            <li><h3>Total de libros ingresados: <span class="badge bg-info"><?php echo $libroTotal; ?></span></h3></li>
        </lu>
    <?php
}
?>
    </div>
</div>

