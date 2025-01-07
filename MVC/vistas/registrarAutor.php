<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=registrarAutor";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();
    $autor = new MAutor($db);
    $res = "";
    if (isset($_POST['nombre']) && isset($_POST['pais'])) {
        if ($autor->registrarAutor($_POST)) {
            $res = "<div class='alert alert-success' role='alert'>El autor se registró correctamente.</div>";
        } else {
            $res = "<div class='alert alert-danger' role='alert'>El autor no se pudo registrar.</div>";
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]).$miga; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del autor" required>
        </div>
        <div class="form-group">
            <label for="pais">País:</label>
            <select name="pais" class="form-control" id="pais" required>
                <option value="">Seleccione un país</option>
                <?php
                $paises = $autor->listaPaises();
                foreach ($paises as $pais) {
                    echo "<option value='" . $pais['idpais'] . "'>" . $pais['pais'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    <?php
    }
    ?>
</div>
