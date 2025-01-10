<?php
/**
 * 2025 - [TI] Wilson Denis Arriola
 *
 * Clase para manejar las peticiones relacionadas con la autenticación.
 */

class AuthController extends Conexion
{
    private $conn;
    private $requestMethod;
    private $user;

    public function __construct($requestMethod)
    {
        parent::__construct();
        $this->conn = $this->db;
        $this->requestMethod = $requestMethod;
        $this->user = new User($this->conn);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->login();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        echo json_encode($response);
    }

    private function login()
    {
        $data = (array)json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->unprocessableEntityResponse();
        }

        $email = $data['email'];
        $password = $data['password'];

        $user = $this->user->getUserByEmail($email);

        if (!$user) {
            return $this->notFoundUser();
        }

        if (!password_verify($password, $user['password'])) {
            return $this->unauthorizedResponse();
        }

        $jwt = JWT::encode(['user_id' => $user['id'], 'exp' => time() + 3600]);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['token' => $jwt]);
        return $response;
    }

    private function unprocessableEntityResponse()
    {
        return [
            'status_code' => 422,
            'data' => [
                'error' => 'Unprocessable Entity'
            ]
        ];
    }

    private function notFoundResponse()
    {
        return [
            'status_code' => 404,
            'data' => [
                'error' => 'Not Found'
            ]
        ];
    }

    private function unauthorizedResponse()
    {
        return [
            'status_code' => 401,
            'data' => [
                'error' => 'Unauthorized'
            ]
        ];
    }

    private function notFoundUser()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['message' => 'El usuario no existe']);
        return $response;
    }
}