<?php

abstract class Conexion {
    const intentosLogin = 3;
    const config = 1;
    private $DB_Host;
    private $DB_User;
    private $DB_Pass;
    private $DB_Name;
    protected $db;
    private $DOC_Root;
    private $dbConf;
    protected $sessionName;
    protected $autor = "Wilson Denis Arriola";
    protected $depuracion;
    public $respuesta;
    /**
     * @var string
     */
    private $urlBase;

    function __construct() {
        $this->DOC_Root = $_SERVER['DOCUMENT_ROOT']."/backend/";
        $this->sessionName = "API_panaderia";
        $this->dbConf = "SELECT * FROM configuracion WHERE id=".self::config;

        $this->respuesta = new Respuestas();

        $this->inicializar();
        $this->conectar();
        $this->configuracion();
    }

    private function inicializar() {
        $a = [];
        $key = "apiPanadeia2025";

        if ($_SERVER["SERVER_NAME"] == "localhost") {
            // servidor local
            $a['hostname'] = getenv('HOSTNAME_D');
            $a['username'] = getenv('USERNAME_D');
            $a['password'] = getenv('PASSWORD_D');
            $a['database'] = getenv('DATABASE_D');

            $this->urlBase = "https://localhost/backend/";
        } else {
            // servidor externo
            $a['hostname'] = getenv('HOSTNAME_P');
            $a['username'] = getenv('USERNAME_P');
            $a['password'] = getenv('PASSWORD_P');
            $a['database'] = getenv('DATABASE_P');

            $this->urlBase = "https://" . $_SERVER["SERVER_NAME"] . "/backend/";
        }

        // Desencriptar los valores usando la función adecuada
        $this->DB_Host = $this->desencriptarTexto($a['hostname'], $key);
        $this->DB_User = $this->desencriptarTexto($a['username'], $key);
        $this->DB_Pass = $this->desencriptarTexto($a['password'], $key);
        $this->DB_Name = $this->desencriptarTexto($a['database'], $key);
    }

    // Función para desencriptar el texto usando el IV almacenado en el texto encriptado
    private function desencriptarTexto($textoEncriptado, $clave) {
        // Decodificar el texto encriptado y el IV en base64
        $datos = base64_decode($textoEncriptado);

        // Extraer el IV del principio del texto
        $iv = substr($datos, 0, openssl_cipher_iv_length('aes-256-cbc'));

        // Extraer el texto encriptado después del IV
        $textoEncriptado = substr($datos, openssl_cipher_iv_length('aes-256-cbc'));

        // Desencriptar el texto
        return openssl_decrypt($textoEncriptado, 'aes-256-cbc', $clave, 0, $iv);
    }

    private function conectar() {
        try {
            $this->db = new PDO("mysql:host=".$this->DB_Host.";dbname=".$this->DB_Name, $this->DB_User, $this->DB_Pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            $this->respuesta->error_500($e->getMessage());
        }
    }

    private function configuracion() {
        $stmt = $this->db->prepare($this->dbConf);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->depuracion = $row['depuracion'];
    }

    public function __destruct() {
        $this->db = null;
    }

}