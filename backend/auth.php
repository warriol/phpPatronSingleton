<?php
/**
 * 2025 - [TI] Wilson Denis Arriola
 *
 * Archivo de entrada para las peticiones a la API.
 *
 * Se encarga de procesar las peticiones y redirigirlas al controlador correspondiente.
 *
 * La respuesta se devuelve en formato JSON.
 */

require_once __DIR__ . '/config/cargarEnv.php';
include_once __DIR__ . '/config/autoload.php';

if (getenv('ENVIRONMENT') === false ) {
    echo "Verifique el etorno de ejecución.";
    die();
} else {
    if (getenv('HOSTNAME_D') === false || getenv('HOSTNAME_P') === false) {
        echo "La variable de entorno no se iniciaron correctamente, esto puede afectar el funcionamiento del sitio, comuniquese con un administrador.";
        die();
    }
}


// Establecer las cabeceras necesarias para CORS
//header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // Responder con código 200 OK
    exit;
}
header("Content-Type: application/json; charset=UTF-8");

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new AuthController($requestMethod);
$controller->processRequest();

/**
 * probando JWT
 */
/*
require_once __DIR__ . '/autoload.php';

$rateLimiter = new RateLimiter(100, 3600); // 100 requests per hour
$ip = $_SERVER['REMOTE_ADDR'];

if (!$rateLimiter->isAllowed($ip)) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many requests']);
    exit;
}

$jwt = JWT::encode(['user_id' => 1, 'exp' => time() + 3600]);
$decoded = JWT::decode($jwt);

$email = InputValidator::validateEmail($_POST['email']);
$sanitizedString = InputValidator::sanitizeString($_POST['name']);
 */
