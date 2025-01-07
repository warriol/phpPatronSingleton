<?php
/**
 * 2025 - [TI] Wilson Denis Arriola
 *
 * Clase para manejar las peticiones relacionadas con los usuarios.
 *
 * Se encarga de procesar las peticiones GET, POST, PUT y DELETE.
 *
 * GET: Devuelve un usuario o todos los usuarios.
 * POST: Crea un usuario.
 * PUT: Actualiza un usuario.
 * DELETE: Elimina un usuario.
 *
 * Las peticiones se realizan a través de la URL.
 *
 * Ejemplo de petición GET:
 *
 * http://localhost/api/users
 *
 * Ejemplo de petición GET con ID:
 *
 * http://localhost/api/users/1
 *
 * Ejemplo de petición POST:
 *
 * http://localhost/api/users
 *
 * Ejemplo de petición PUT:
 *
 * http://localhost/api/users/1
 *
 * Ejemplo de petición DELETE:
 *
 * http://localhost/api/users/1
 *
 * La respuesta se devuelve en formato JSON.
 *
 * Vulnerabilidad conocida: SQL Injection.
 * Para evitar esta vulnerabilidad, se recomienda utilizar consultas preparadas.
 *
 */

require_once '../config/Database.php';
require_once '../models/User.php';

class UserController
{
    private $db;
    private $requestMethod;
    private $userId;

    public function __construct($requestMethod, $userId = null)
    {
        $this->db = Database::getInstance()->getConnection();
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                }
                break;
            case 'POST':
                $response = $this->createUser();
                break;
            case 'PUT':
                $response = $this->updateUser($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllUsers()
    {
        $query = 'SELECT * FROM users';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser($id)
    {
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createUser()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        $query = 'INSERT INTO users (name, email) VALUES (:name, :email)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $input['name']);
        $stmt->bindParam(':email', $input['email']);

        if ($stmt->execute()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['message' => 'User created successfully']);
        } else {
            $response = $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function updateUser($id)
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        $query = 'UPDATE users SET name = :name, email = :email WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $input['name']);
        $stmt->bindParam(':email', $input['email']);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'User updated successfully']);
        } else {
            $response = $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function deleteUser($id)
    {
        $query = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'User deleted successfully']);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['message' => 'Not Found']);
        return $response;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['message' => 'Invalid input']);
        return $response;
    }
}