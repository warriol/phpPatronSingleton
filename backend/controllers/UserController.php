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

class UserController
{
    private $db;
    private $requestMethod;
    private $userId;
    private $user;

    public function __construct($requestMethod, $userId = null)
    {
        $this->db = Database::getInstance()->getConnection();
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->user = new User($this->db);
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
        $result = $this->user->getAll();
        $users = $result->fetchAll(PDO::FETCH_ASSOC);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($users);
        return $response;
    }

    private function getUser($id)
    {
        $result = $this->user->getById($id);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($user);
        return $response;
    }

    private function createUser()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->user->first_name = $input['first_name'];
        $this->user->last_name = $input['last_name'];
        $this->user->email = $input['email'];
        $this->user->phone = $input['phone'];
        $this->user->password = password_hash($input['password'], PASSWORD_BCRYPT);

        if ($this->user->create()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['message' => 'User created successfully']);
        } else {
            $response = $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function updateUser($id)
    {
        $result = $this->user->getById($id);
        if ($result->rowCount() == 0) {
            return $this->notFoundResponse();
        }

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->user->first_name = $input['first_name'];
        $this->user->last_name = $input['last_name'];
        $this->user->email = $input['email'];
        $this->user->phone = $input['phone'];
        $this->user->password = password_hash($input['password'], PASSWORD_BCRYPT);

        if ($this->user->update($id)) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'User updated successfully']);
        } else {
            $response = $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->user->getById($id);
        if ($result->rowCount() == 0) {
            return $this->notFoundResponse();
        }

        if ($this->user->delete($id)) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'User deleted successfully']);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function validateUser($input)
    {
        if (!isset($input['first_name']) || !isset($input['last_name']) || !isset($input['email']) || !isset($input['phone']) || !isset($input['password'])) {
            return false;
        }

        return true;
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