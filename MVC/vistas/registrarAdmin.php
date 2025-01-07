<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=registrarAdmin";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();

    $admin = new MAdmin($db);

    $res = "";
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['pass']) && isset($_POST['nick'])) {
        if ($admin->registrarAdmin($_POST)) {
            $res = "<div class='alert alert-success' role='alert'>El administrador se registró correctamente.</div>";
        } else {
            $res = "<div class='alert alert-danger' role='alert'>El administrador no se pudo registrar.</div>";
        }
    }
}
?>
<div class="container">
    <?php
    if ($res != "") {
        echo $res;
        echo "<br><a href='index.php".$miga."' class='btn btn-primary'>Volver</a>";
    }else{
    ?>
        <form action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]).$miga; ?>" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" id="apellido" required>
            </div>

            <div class="form-group">
                <label for="pass">Contraseña:</label>
                <input type="password" class="form-control" name="pass" id="pass" required>
            </div>

            <div class="form-group">
                <label for="nick">Nick:</label>
                <input type="text" class="form-control" name="nick" id="nick" required>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    <?php
    }
    ?>
</div>
