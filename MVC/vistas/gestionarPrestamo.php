<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=gestionarPrestamo";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();

    $prestamo = new MPrestamo($db);
    $resBusqueda = $prestamo->buscarLibrosSinPrestados();

    $res = "";
    if (isset($_POST['libroId']) && isset($_POST['prestamos'])) {
        //$res = "<div class='alert alert-success' role='alert'>Se prestara el libro: ".$_POST['libroId']." a:".$_SESSION['usuario'][0]['id'] ."</div>";
        if ($prestamo->registrarPrestamo($_POST)) {
            $res = "<div class='alert alert-success' role='alert'>El prestamo se registró correctamente.</div>";
        } else {
            $res = "<div class='alert alert-danger' role='alert'>El prestamo no se pudo registrar.</div>";
        }
    }
}
?>
<div class="container">
    <h5>Busque el libro que desea solicitar en prestamo, y realice la solicitud.</h5>
    <em>Si el libro que desea no aparece en la lista se debe a que no contamos actualmente con disponibilidad del mismo, disculpe las molestias.</em>
    <?php
    if ($res != "") {
        echo $res;
        echo "<br><a href='index.php".$miga."' class='btn btn-primary'>Volver</a>";
    }else{
    ?>
    <hr>
    <table id="tabla-libros" class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Categoria</th>
            <th>Año</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($resBusqueda as $libro) {
            echo "<tr>";
            echo "<td>".$libro['id']."</td>";
            echo "<td>".$libro['titulo']."</td>";
            echo "<td>".$libro['categoria']."</td>";
            echo "<td>".$libro['anio']."</td>";
            echo "<td>".$libro['autor']." [".$libro['pais']."]</td>";
            echo "<td>".$libro['editorial']."</td>";

            echo "<td><button class='btn btn-primary btn-solicitar' data-libro-id='"
                . $libro['id']
                . "' data-libro-titulo='"
                . $libro['titulo']
                . "' data-libro-autor='"
                . $libro['autor']
                . "'>Solicitar</button></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Agrega el modal o popup de confirmación -->
    <div id="modalConfirmacion" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Solicitud de Préstamo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas solicitar este libro?</p>
                    <p><strong>Libro:</strong> <em><span id="libroTitulo"></span></em></p>
                    <p><strong>Autor:</strong> <em><span id="libroAutor"></span></em></p>
                    <!-- Formulario de confirmación -->
                    <form id="formularioConfirmacion" method="POST" action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]).$miga; ?>">
                        <input type="hidden" name="libroId" value="">
                        <button type="submit" name="prestamos" class="btn btn-primary">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<script>
    // Función para mostrar el modal de confirmación
    $(document).ready(function() {
        $('.btn-solicitar').click(function(e) {
            e.preventDefault();
            var libroId = $(this).data('libro-id');
            var libroTitulo = $(this).data('libro-titulo');
            var libroAutor = $(this).data('libro-autor');

            // Mostrar el modal o popup de confirmación
            $('#modalConfirmacion').modal('show');

            // Establecer el ID del libro en el formulario de confirmación
            $('#formularioConfirmacion input[name="libroId"]').val(libroId);
            $('#libroTitulo').text(libroTitulo);
            $('#libroAutor').text(libroAutor);
        });

        // Manejar el envío del formulario de confirmación
        $('#formularioConfirmacion').submit(function(e) {});
    });

    // Inicializar DataTables
    $(document).ready(function() {
        // Configurar DataTables
        $('#tabla-libros').DataTable({
            language: {
                url: 'res/vendor/datatables/esp.json'
            },
        });
    });
</script>
