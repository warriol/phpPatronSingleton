<?php

class Respuestas
{

    public $response = [
        "status" => "ok",
        "result" => array()
    ];

    public function error_500($string = "Error interno del servidor")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $string
        );
        return $this->response;
    }
}