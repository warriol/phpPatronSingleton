<?php

class MUsuario extends MAdmin
{

    private $db;
    private $idAdministrador;
    private $direccion;
    private $email;
    private $estado;

    public function __construct($conn, $usuario = null)
    {
        parent::__construct($conn);
        $this->db = $conn;

        if ($usuario != null) {
            $this->idAdministrador = $usuario['idAdministrador'];
            $this->direccion = $usuario['direccion'];
            $this->email = $usuario['email'];
            $this->estado = $usuario['estado'];
        }
    }

    public function registrarUsuario($POST) : bool
    {
        $retorno = false;
        $this->idAdministrador = $POST['idadmin'];
        $this->direccion = $POST['direccion'];
        $this->email = $POST['email'];
        $this->estado = $POST['estado'];

        try {
            $sql = "INSERT INTO usuarios (idAdministrador, direccion, email, estado) 
                VALUES 
                    ('$this->idAdministrador', '$this->direccion', '$this->email', '$this->estado')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $numFilasInsertadas = $stmt->rowCount();

            if ($numFilasInsertadas > 0) {
                $retorno = true;
            }
        } catch (PDOException $e) {
            $this->log('Error al registrar usuario', $e->getMessage());
        }
        return $retorno;
    }

    public function buscarUsuariosCant() {
        $sql = "SELECT COUNT(*) AS cantidad FROM usuarios";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();;
    }
}