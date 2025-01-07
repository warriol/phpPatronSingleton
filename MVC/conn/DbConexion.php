<?php

class DbConexion extends  Configuracion {

    protected  $DbConn;
    private static  $instancia = null;

    private function __construct() {
        // conectar a la bd
        try {
            $this->DbConn = new PDO("mysql:host=".self::$DB_HOST.";dbname=".self::$DB_NAME."", self::$DB_USER, self::$DB_PASS);
            $this->DbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->DbConn->exec("SET CHARACTER SET utf8");
            //$this->log("DbConexion", "Conectado a la base de datos.");
        }catch (PDOException $e) {
            $msj = $e->getMessage();
            echo 'Error al conectar: ' . $msj;
        }
    }
    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new DbConexion();
        }
        return self::$instancia;
    }

    public function getConexion() {
        return $this->DbConn;
    }

    public function log($var, $val = '-') {
        $file = fopen("./log/conectar.log", "a") or die("Error creando archivo");
        $texto = '['.date("Y-m-d H:i:s").']::['.$var.']:-> ['.$val.']';
        fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
        fclose($file);
    }
}