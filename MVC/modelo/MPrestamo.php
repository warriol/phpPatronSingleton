<?php

class MPrestamo extends MBLibros
{

    private $db;
    private $id;
    private $idlibro;
    private $idusuario;
    private $fecha_prestamo;
    private $fecha_devolucion;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->db = $conn;
    }

    public function registrarPrestamo($POST): bool
    {
        $retorno = false;
        $this->idlibro = $POST['libroId'];
        $this->idusuario = $_SESSION['idUsr'];

        $this->log("insertar registro de prestamos", $this->idlibro." - ".$this->idusuario." - ".date("Y-m-d H:i:s"));
        try {
            parent::log("insertar registro de prestamos", $this->idlibro." - ".$this->idusuario." - ".date("Y-m-d H:i:s"));
            $sql = "INSERT INTO prestamos (libro_id, usuario_id, fecha_prestamo) 
                VALUES 
                    ('$this->idlibro', '$this->idusuario', now())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $numFilasInsertadas = $stmt->rowCount();

            if ($numFilasInsertadas > 0) {
                $this->restarCopias($this->idlibro);
                $this->actualizarDisponibilidad($this->idlibro);
                $retorno = true;
            }
        } catch (PDOException $e) {
            parent::log('Error al registrar prestamo', $e->getMessage());
        }
        return $retorno;
    }

    public function buscarPrestamos () {

        $this->idusuario = $_SESSION['idUsr'];

        $sql = "SELECT 
                    p.id, p.fecha_prestamo, p.fecha_devolucion, l.id as libroid, l.titulo, l.categoria, l.anio_publicacion AS anio,
                    a.nombre AS autor,
                    pa.pais,
                    e.nombre AS editorial
                FROM 
                    prestamos AS p
                    JOIN libros AS l ON p.libro_id = l.id
                    JOIN autor AS a ON l.idautor = a.id 
                    JOIN pais AS pa ON a.idPais = pa.idpais
                    JOIN editoriales AS e ON l.ideditorial = e.id
                WHERE
                    p.usuario_id = $this->idusuario
                    AND p.fecha_devolucion IS NULL;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPrestamosCant() {
        $sql = "SELECT 
                    COUNT(p.id) AS cantidad
                FROM 
                    prestamos AS p
                WHERE
                    p.fecha_devolucion IS NULL;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function buscarPrestamosCantXId() {
        $this->idusuario = $_SESSION['idUsr'];
        $sql = "SELECT 
                    COUNT(p.id) AS cantidad
                FROM 
                    prestamos AS p
                WHERE
                    p.usuario_id = $this->idusuario
                    AND p.fecha_devolucion IS NULL;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function buscarPrestamosNoDevueltosCant() {
        $this->idusuario = $_SESSION['idUsr'];

        $sql = "SELECT 
                    COUNT(p.id) AS cantidad
                FROM 
                    prestamos AS p
                WHERE
                    p.fecha_devolucion IS NULL;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function buscarLibrosSinPrestados() {
        $stmt = $this->db->prepare('Select 
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
                    l.disponibilidad = 1
                    and l.id not in 
                    (SELECT libro_id from prestamos where usuario_id = ? AND fecha_devolucion IS NULL)
                order by l.titulo');
        $stmt->bindParam(1, $_SESSION['idUsr']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarDevolucion ($POST) : bool {
        $retorno = false;
        $this->id = $POST['prestamoId'];
        $this->idlibro = $POST['libroId'];
        $this->idusuario = $_SESSION['idUsr'];

        try {
            $sql = "UPDATE prestamos
                SET fecha_devolucion = now()
                WHERE id = $this->id AND usuario_id = $this->idusuario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $numFilasInsertadas = $stmt->rowCount();

            if ($numFilasInsertadas > 0) {
                $this->sumarCopias($this->idlibro);
                $retorno = true;
            }
        } catch (PDOException $e) {
            parent::log('Error al registrar devolucion', $e->getMessage());
        }
        return $retorno;
    }

    public function listarLibros()
    {
        $sql = "SELECT * FROM libros";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function restarCopias ($id) {
        try {
            $sql = "UPDATE libros
                SET copias = copias - 1
                WHERE id = $id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            parent::log('Error al restar copia: ', $e->getMessage());
        }
    }

    private function sumarCopias ($id) {
        try {
            $sql = "UPDATE libros
                SET copias = copias + 1, disponibilidad = true
                WHERE id = $id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            parent::log('Error al sumar copia: ', $e->getMessage());
        }
    }
    private function actualizarDisponibilidad ($id) {
        try {
            $sql = "UPDATE libros
                SET disponibilidad = false
                WHERE id = $id AND copias = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            parent::log('Error al actualizar disponibilidad: ', $e->getMessage());
        }
    }
    private function totalCopias ($id) : int{
        $sql = "SELECT copias FROM libros WHERE id = $id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}