<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=registrarUsuario";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();

    $usuario = new MUsuario($db);

    $res = "";
    if (isset($_POST['idadmin']) && isset($_POST['direccion']) && isset($_POST['email']) && isset($_POST['estado'])) {
        if ($usuario->registrarUsuario($_POST)) {
            $res = "<div class='alert alert-success' role='alert'>El usuario se registró correctamente.</div>";
        } else {
            $res = "<div class='alert alert-danger' role='alert'>El usuario no se pudo registrar.</div>";
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
                <label for="idadmin">Seleccione un Administrador:</label>
                <select class="form-control" name="idadmin" id="idadmin" required>
                    <option value="">Seleccione un Admin</option>
                    <?php
                    $admines = $usuario->listaAdminNoUsuario();
                    foreach ($admines as $admin) {
                        echo "<option value='" . $admin['id'] . "'>"
                            . $admin['nombre'] . " " . $admin['apellido'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" id="direccion" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select class="form-control" name="estado" id="estado" required>
                    <option value="">Seleccione</option>
                    <option value="activo">Activo</option>
                    <option value="bloqueado">Bloqueado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    <?php
    }
    ?>
</div>