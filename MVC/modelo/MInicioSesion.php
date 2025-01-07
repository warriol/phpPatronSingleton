<?php
class MInicioSesion
{
    private $db;
    private $usuarios;
    private $pass;

    private static $clave = "clavePhp2023";
    private static $rnd = "1234567890123456";

    public function __construct($conexion, $usuarios, $pass) {
        $this->db = $conexion;
        $this->usuarios = $this->limpiarInput($usuarios);
        $this->pass = $this->encriptar($pass);
    }

    private function limpiarInput($data) {
        //$data = trim($data);
        // $data = stripslashes(trim($data));
        return htmlspecialchars(stripslashes(trim($data)));
    }
    public function existeUsuario() : bool {
        $retorno = false;
        $query = "SELECT nick FROM administradores WHERE nick = '$this->usuarios'";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) $retorno = true;
        return $retorno;
    }

    public function iniciarSesion() : array {
        $retorno = [];
        $query = "SELECT 
                    a.id,
                    u.id as usuarioId,
                    nombre,
                    apellido,
                    nick
                    FROM administradores as a
                    LEFT JOIN usuarios as u on a.id = u.idAdministrador
                    WHERE nick = '$this->usuarios' 
                    AND pass = '$this->pass'";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) === 1)
            $retorno = $result;
        return $retorno;
    }
    public function retornoHash() : string {
        return $this->pass;
    }
    private function encriptar($p)
    {
        return openssl_encrypt($p, 'AES-256-CBC', self::$clave, 0, self::$rnd);
    }

    private function desencriptar($p)
    {
        return openssl_decrypt($p, 'AES-256-CBC', self::$clave, 0, self::$rnd);
    }
}