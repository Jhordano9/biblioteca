<?php session_start();
    include "../../clases/Usuario.php";

    $usuario = new Usuario();

    $response = $usuario->listar();
    if ($response) {
        echo $response;
    }

?>