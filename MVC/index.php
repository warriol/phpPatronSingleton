<?php
include_once './conn/Configuracion.php';
include_once './conn/DbConexion.php';

session_start();

$views = [
    'registrarLibro' => ['./modelo/MAutor.php', './modelo/MLibro.php'],
    'registrarUsuario' => ['./modelo/MAdmin.php', './modelo/MUsuario.php'],
    'registrarAutor' => ['./modelo/MAutor.php'],
    'registrarAdmin' => ['./modelo/MAdmin.php'],
    'gestionarPrestamo' => ['./modelo/MBLibros.php', './modelo/MPrestamo.php'],
    'gestionarDevolucion' => ['./modelo/MBLibros.php', './modelo/MPrestamo.php'],
    'buscarLibro' => ['./modelo/MBLibros.php'],
    'salir' => []
];

if (isset($_SESSION) && isset($_GET['view'])) {
    $vista = $_GET['view'];
    if (array_key_exists($vista, $views)) {
        foreach ($views[$vista] as $include) {
            include_once $include;
        }
        if ($vista == 'salir') {
            unset($_SESSION);
            session_destroy();
            session_start();
            $vista = "login";
        }
    } else {
        include_once './modelo/MBLibros.php';
        include_once './modelo/MPrestamo.php';
        $vista = "iniciado";
    }
} else {
    $vista = "login";
    if (isset($_POST['usuario']) && isset($_POST['password'])) {
        include_once './modelo/MInicioSesion.php';

        $dbConexion = DbConexion::getInstancia();
        $db = $dbConexion->getConexion();

        $usr = $_POST['usuario'];
        $pas = $_POST['password'];

        $inicioSesion = new MInicioSesion($db, $usr, $pas);

        if (!$inicioSesion->existeUsuario()) {
            $p = $inicioSesion->retornoHash();
            $_GET['error'] = "<div class='alert alert-danger' role='alert'>Usuario incorrecto: ".$p.".</div>";
        } else {
            $res = $inicioSesion->iniciarSesion();
            if (count($res) === 1) {
                $_SESSION['iniciado'] = true;
                $_SESSION['usuario'] = $res;
                $_SESSION['idAdmin'] = $res[0]['id'];
                $_SESSION['idUsr'] = $res[0]['usuarioId'];
                $_SESSION['idUsr'] == null ? $_SESSION['tipo'] = 'admin' : $_SESSION['tipo'] = 'usuario';
                $dbConexion->log("tipo de usuario: ".$_SESSION['tipo']);
                include_once './modelo/MBLibros.php';
                include_once './modelo/MPrestamo.php';
                $vista = "iniciado";
            } else {
                $_GET['error'] = "<div class='alert alert-danger' role='alert'>Password incorrecto.</div>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Biblioteca PHP</title>

    <!-- Custom fonts for this template-->
    <link href="res/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="res/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="res/css/style.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="res/vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">
<?php
if ($vista == "login") {
    include_once ("./vistas/$vista.php");
}else {
    include_once ("./vistas/tpl/header.php");
    include_once ("./vistas/$vista.php");
    include_once ("./vistas/tpl/footer.php");
}
?>
<!-- Bootstrap core JavaScript-->
<script src="res/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="res/vendor/datatables/jquery.dataTables.min.js"></script>

<!-- Incluye el archivo de traducción en español -->
<script src="res/vendor/datatables/esp.json"></script>

<!-- Core plugin JavaScript-->
<script src="res/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="res/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="res/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="res/js/demo/chart-area-demo.js"></script>
<script src="res/js/demo/chart-pie-demo.js"></script>

</body>

</html>