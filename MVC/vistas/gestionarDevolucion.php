<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=gestionarDevolucion";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();

    $prestamo = new MPrestamo($db);
    $resBusqueda = $prestamo->buscarPrestamos();

    $res = "";
    if (isset($_POST['prestamoId']) && isset($_POST['devolver'])) {
        //$res = "<div class='alert alert-success' role='alert'>Se prestara el libro: ".$_POST['libroId']." a:".$_SESSION['usuario'][0]['id'] ."</div>";
        if ($prestamo->registrarDevolucion($_POST)) {
            $res = "<div class='alert alert-success' role='alert'>La devolucion se registró correctamente.</div>";
        } else {
            $res = "<div class='alert alert-danger' role='alert'>La devolucion no se pudo registrar.</div>";
        }
    }
}
?>
<div class="container">
    <h5>Busque el libro que desea devolver, y realice la devolucion.</h5>
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
                <th>Fecha de Prestamo</th>
                <th>Categoria</th>
                <th>Año</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $fechaActual = date("Y-m-d"); // Fecha actual en formato "Año-Mes-Día"

            foreach ($resBusqueda as $libro) {
                $segundosTranscurridos = strtotime($fechaActual) - strtotime($libro['fecha_prestamo']);
                $diasTranscurridos = floor($segundosTranscurridos / (60 * 60 * 24));
                echo "<tr>";
                echo "<td>".$libro['libroid']."</td>";
                echo "<td>".$libro['titulo']."</td>";
                echo "<td>".$libro['fecha_prestamo']." [".$diasTranscurridos."]</td>";
                echo "<td>".$libro['categoria']."</td>";
                echo "<td>".$libro['anio']."</td>";
                echo "<td>".$libro['autor']." [".$libro['pais']."]</td>";
                echo "<td>".$libro['editorial']."</td>";

                echo "<td><button class='btn btn-primary btn-solicitar' data-libro-id='"
                    . $libro['id']
                    . "' data-libro-libroid='"
                    . $libro['libroid']
                    . "' data-libro-titulo='"
                    . $libro['titulo']
                    . "' data-libro-autor='"
                    . $libro['autor']
                    . "'>Devolver</button></td>";
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
                        <h5 class="modal-title">Confirmar Devolución</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas devolver este libro?</p>
                        <p><strong>Libro:</strong> <em><span id="libroTitulo"></span></em></p>
                        <p><strong>Autor:</strong> <em><span id="libroAutor"></span></em></p>
                        <!-- Formulario de confirmación -->
                        <form id="formularioConfirmacion" method="POST" action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]).$miga; ?>">
                            <input type="hidden" name="prestamoId" value="">
                            <input type="hidden" name="libroId" value="">
                            <button type="submit" name="devolver" class="btn btn-primary">Confirmar</button>
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
            var prestamoId = $(this).data('libro-id');
            var libroId = $(this).data('libro-libroid');
            var libroTitulo = $(this).data('libro-titulo');
            var libroAutor = $(this).data('libro-autor');

            // Mostrar el modal o popup de confirmación
            $('#modalConfirmacion').modal('show');

            // Establecer el ID del libro en el formulario de confirmación
            $('#formularioConfirmacion input[name="prestamoId"]').val(prestamoId);
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
