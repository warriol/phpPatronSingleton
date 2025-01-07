<?php
if (!$_SESSION['iniciado']) {
    header("Location: ../index.php");
}else {
    $miga = "?view=buscarLibro";
    $dbConexion = DbConexion::getInstancia();
    $db = $dbConexion->getConexion();
    $libros = new MBLibros($db);
    $res = $libros->buscarLibros();
}
?>
<div class="container">
    <table id="tabla-libros" class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Categoria</th>
            <th>Año</th>
            <th>Autor</th>
            <th>Editorial</th>
            <!--<th>Acciones</th>-->
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($res as $libro) {
                echo "<tr>";
                echo "<td>".$libro['id']."</td>";
                echo "<td>".$libro['titulo']."</td>";
                echo "<td>".$libro['categoria']."</td>";
                echo "<td>".$libro['anio']."</td>";
                echo "<td>".$libro['autor']." [".$libro['pais']."]</td>";
                echo "<td>".$libro['editorial']."</td>";
                //echo "<td><a href='index.php?view=registrarLibro&id=".$libro['id']."' class='btn btn-primary'>Editar</a></td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Configurar DataTables
            $('#tabla-libros').DataTable({
                language: {
                    url: 'res/vendor/datatables/esp.json'
                },
            });
        });
    </script>
</div>