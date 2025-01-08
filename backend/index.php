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

require_once './controllers/UserController.php';
require_once './config/Database.php';
require_once './models/User.php';

header("Content-Type: application/json; charset=UTF-8");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$userId = isset($_GET['id']) ? $_GET['id'] : null;

$controller = new UserController($requestMethod, $userId);
$controller->processRequest();