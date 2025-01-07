<?php

class MAutor
{
    private $db;
    private $nombre;
    private $pais;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function listaPaises()
    {
        $sql = "SELECT * FROM pais";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaAutores()
    {
        $sql = "SELECT * FROM autor order by nombre asc";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarAutor($POST) : bool
    {
        $retorno = false;
        $this->nombre = $POST['nombre'];
        $this->pais = $POST['pais'];

        try {
            $sql = "INSERT INTO autor (nombre, idpais) VALUES ('$this->nombre', '$this->pais')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $numFilasInsertadas = $stmt->rowCount();

            if ($numFilasInsertadas > 0) {
                $retorno = true;
            }
        } catch (PDOException $e) {
            $this->log('Error al registrar autor', $e->getMessage());
        }
        return $retorno;
    }

    public function log($var, $val = '-') {
        $file = fopen("./log/registros.log", "a") or die("Error creando archivo");
        $texto = '['.date("Y-m-d H:i:s").']::['.$var.']:-> ['.$val.']';
        fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
        fclose($file);
    }
}