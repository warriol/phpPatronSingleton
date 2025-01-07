<?php

class MBLibros
{
    private $db;
    private $id;
    private $titulo;
    private $idautor;
    private $categoria;
    private $ideditorial;
    private $anio_publicacion;
    private $disponibilidad;
    private $copias;

    public function __construct($conn)
    {
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

    public function buscarLibros() {
        $sql = "Select 
                    l.id, l.titulo, l.categoria, l.anio_publicacion as anio,
                    a.nombre as autor,
                    p.pais,
                    e.nombre as editorial
                from 
                    libros as l
                    join autor as a on l.idautor = a.id 
                    join pais as p on a.idPais = p.idpais
                    join editoriales as e on l.ideditorial = e.id
                where
                    l.disponibilidad = 1; ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarLibrosCant() {
        $sql = "Select 
                    count(*) as cantidad
                from 
                    libros as l
                where
                    l.disponibilidad = 1; ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function log($var, $val = '-') {
        $file = fopen("./log/registros.log", "a") or die("Error creando archivo");
        $texto = '['.date("Y-m-d H:i:s").']::['.$var.']:-> ['.$val.']';
        fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
        fclose($file);
    }

}