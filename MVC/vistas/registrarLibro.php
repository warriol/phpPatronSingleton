<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=registrarLibro";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();

    $libro = new MLibro($db);
    $autor = new MAutor($db);

    $res = "";
    if (isset($_POST['titulo']) && isset($_POST['autor']) && isset($_POST['categoria'])) {
        $dbConexion->log("recibo post agregar libro: ", $_POST['titulo']);
        if ($libro->registrarLibro($_POST)) {
            $res = "<div class='alert alert-success' role='alert'>El libro se registró correctamente.</div>";
        } else {
            $res = "<div class='alert alert-danger' role='alert'>El libro no se pudo registrar.</div>";
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
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese el título del libro" required>
        </div>
        <div class="form-group">
            <label for="autor">Autor:</label>
            <select class="form-control" id="autor" name="autor" required>
                <option value="">Seleccione un autor</option>
                <?php
                $dbConexion->log("listado de autores");
                $autores = $autor->listaAutores();
                foreach ($autores as $autor) {
                    echo "<option value='" . $autor['id'] . "'>" . $autor['nombre'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select class="form-control" id="categoria" name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <option value="Libros de literatura">Libros de literatura</option>
                <option value="Realismo mágico">Realismo mágico</option>
                <option value="Novela">Novela</option>
                <option value="Romance">Romance</option>
                <option value="Cuentos">Cuentos</option>
                <option value="Drama">Drama</option>
                <option value="Poesía">Poesía</option>
                <option value="Ensayo">Ensayo</option>
                <option value="Libros infantiles">Libros infantiles</option>
            </select>
        </div>
        <div class="form-group">
            <label for="editorial">Editorial:</label>
                <select class="form-control" id="editorial" name="editorial" required>
                <option value="">Seleccione una editorial</option>
                <?php
                $dbConexion->log("listado de editoriales");
                $editoriales = $libro->listarEditoriales();
                foreach ($editoriales as $editorial) {
                    echo "<option value='" . $editorial['id'] . "'>" . $editorial['nombre'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="anio_publicacion">Año de Publicación:</label>
            <input type="number" class="form-control" id="anio_publicacion" name="anio_publicacion" placeholder="Ingrese el año de publicación" required>
        </div>
        <div class="form-group">
            <label for="disponibilidad">Disponibilidad:</label>
            <select class="form-control" id="disponibilidad" name="disponibilidad" required>
                <option value="">Seleccione una opción</option>
                <option value="1">Disponible</option>
                <option value="0">No Disponible</option>
            </select>
        </div>
        <div class="form-group">
            <label for="copias">Copias disponibles:</label>
            <input type="number" class="form-control" id="copias" name="copias" placeholder="Ingrese cantidad de copias" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    <?php
    }
    ?>
</div>

