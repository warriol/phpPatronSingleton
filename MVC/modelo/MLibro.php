<?php
class MLibro {

    private $db;
    private $id;
    private $titulo;
    private $idautor;
    private $categoria;
    private $ideditorial;
    private $anio_publicacion;
    private $disponibilidad;
    private $copias;

    public function __construct($conn) {
        $this->db = $conn;
        /*
        $this->titulo = $POST['titulo'];
        $this->idautor = $POST['autor'];
        $this->categoria = $POST['categoria'];
        $this->ideditorial = $POST['editorial'];
        $this->anio_publicacion = $POST['anio_publicacion'];
        $this->disponibilidad = $POST['disponibilidad'];
        $this->copias = $POST['copias'];
        */
    }

    public function registrarLibro($POST) : bool {
        $retorno = false;
        $this->titulo = $POST['titulo'];
        $this->idautor = $POST['autor'];
        $this->categoria = $POST['categoria'];
        $this->ideditorial = $POST['editorial'];
        $this->anio_publicacion = $POST['anio_publicacion'];
        $this->disponibilidad = $POST['disponibilidad'];
        $this->copias = $POST['copias'];

        try {
            $sql = "INSERT INTO libros (titulo, idautor, categoria, ideditorial, anio_publicacion, disponibilidad, copias) 
                VALUES 
                    ('$this->titulo', '$this->idautor', '$this->categoria', '$this->ideditorial', '$this->anio_publicacion', '$this->disponibilidad', '$this->copias')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $numFilasInsertadas = $stmt->rowCount();

            if ($numFilasInsertadas > 0) {
                $retorno = true;
            }
        } catch (PDOException $e) {
            $this->log('Error al registrar libro', $e->getMessage());
        }
        return $retorno;
    }

    public function listarEditoriales() {
        $sql = "SELECT * FROM editoriales";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarLibrosCant() {
        $sql = "SELECT COUNT(*) AS cantidad FROM libros";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function log($var, $val = '-') {
        $file = fopen("./log/registros.log", "a") or die("Error creando archivo");
        $texto = '['.date("Y-m-d H:i:s").']::['.$var.']:-> ['.$val.']';
        fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
        fclose($file);
    }

}