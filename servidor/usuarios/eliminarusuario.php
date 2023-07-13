<?php session_start();
    include "../../clases/Usuario.php";

    $usuario = new Usuario();

    $iduser = $_POST['idUsuario'];

    $response = $usuario->delete($iduser);

    if ($response) {
        echo json_encode(["Message" => "Eliminado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
    }

?>