<?php session_start();
    include "../../clases/Usuario.php";

    $usuario = new Usuario();

    $iduser = $_POST["idUser"];
    $estado = $_POST["estado"];
        
    $response = $usuario->state($iduser,$estado);

    if ($response) {
        echo json_encode(["Message" => "Estado Editado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "Error","Code" => 500]);
    }

?>