<?php

class MAdmin
{

    private $db;
    private $nombre;
    private $apellido;
    private $pass;
    private $nick;

    private static $clave = "clavePhp2023";
    private static $rnd = "1234567890123456";

    public function __construct($conn, $admin = null)
    {
        $this->db = $conn;

        if ($admin != null) {
            $this->nombre = $admin['nombre'];
            $this->apellido = $admin['apellido'];
            $this->pass = $this->encriptar($admin['pass']);
            $this->nick = $admin['nick'];
        }
    }

    public function registrarAdmin($PST) : bool
    {
        $retorno = false;
        $this->nombre = $PST['nombre'];
        $this->apellido = $PST['apellido'];
        $this->pass = $this->encriptar($PST['pass']);
        $this->nick = $PST['nick'];

        try {
            $sql = "INSERT INTO administradores (nombre, apellido, pass, nick) 
                VALUES 
                    ('$this->nombre', '$this->apellido', '$this->pass', '$this->nick')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $numFilasInsertadas = $stmt->rowCount();

            if ($numFilasInsertadas > 0) {
                $retorno = true;
            }
        } catch (PDOException $e) {
            $this->log('Error al registrar administrador', $e->getMessage());
        }
        return $retorno;
    }

    public function listaAdminNoUsuario()
    {
        $sql = "SELECT id, nombre, apellido FROM administradores WHERE id NOT IN (SELECT idAdministrador FROM usuarios);";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAdminsCant() {
        $sql = "SELECT COUNT(*) AS cantidad FROM administradores";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    private function encriptar($p)
    {
        return openssl_encrypt($p, 'AES-256-CBC', self::$clave, 0, self::$rnd);
    }

    private function desencriptar($p)
    {
        return openssl_decrypt($p, 'AES-256-CBC', self::$clave, 0, self::$rnd);
    }
    public function log($var, $val = '-') {
        $file = fopen("./log/registros.log", "a") or die("Error creando archivo");
        $texto = '['.date("Y-m-d H:i:s").']::['.$var.']:-> ['.$val.']';
        fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
        fclose($file);
    }
}