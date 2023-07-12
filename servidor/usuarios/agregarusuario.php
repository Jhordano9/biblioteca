<?php session_start();
    include "../../clases/Usuario.php";

    $usuario = new Usuario();

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);;
    $rol = $_POST['rol'];
    $estado = 1;
    $fecha = date('Y-m-d H:i:s');
        
    $response = $usuario->registrar($nombre,$email,$password,$rol,$estado,$fecha);

    if ($response) {
        echo json_encode(["Message" => "Usuario Registrado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => $response,"Code" => 500]);
    }

?>