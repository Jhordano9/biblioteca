<?php session_start();
    include "../../clases/Usuario.php";

    $usuario = new Usuario();

    $iduser = $_POST["iduser"];
    $nombre = $_POST["editnombre"];
    $email = $_POST["editemail"];

    if($_POST["editpassword"] != ''){
        $password = password_hash($_POST["editpassword"], PASSWORD_DEFAULT);
    }else{
        $password = '';
    }
    
    $rol = $_POST['editrol'];
        
    $response = $usuario->editar($iduser,$nombre,$email,$password,$rol);

    if ($response) {
        echo json_encode(["Message" => "Usuario Editado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => $response,"Code" => 500]);
    }

?>