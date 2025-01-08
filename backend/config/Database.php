<?php
/**
 *
 * 2025 - [TI] Wilson Denis Arriola
 *
 * Clase para manejar la conexión a la base de datos.
 *
 * Patrón de diseño Singleton.
 *
 * El constructor es privado para evitar la creación directa de objetos.
 *
 * getInstance() es el método que se encarga de crear una instancia de la clase si no existe.
 *
 * getConnection() es el método que se encarga de devolver la conexión a la base de datos.
 *
 */

class Database
{
    private static $instance = null;
    private $conn;

    /**
     * @var string $host Nombre del servidor de la base de datos.
     * @var string $user Nombre de usuario de la base de datos.
     * @var string $pass Contraseña de la base de datos.
     * @var string $name Nombre de la base de datos.
     *
     * Estos valores se pueden cambiar según la configuración de la base de datos.
     *
     * Vulnerabilidad conocida: Hardcoded credentials.
     * En ambiente de producción, se recomienda guardar estos valores en un archivo .env.
     */
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'api_database';

    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->name}", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
