<?php 
    include "Conexion.php";

    class Auth extends Conexion {
        public function registrar($usuario, $password) {
            $conexion = parent::conectar();
            $sql = "INSERT INTO t_usuarios (usuario, password) 
                    VALUES (?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ss', $usuario, $password);
            return $query->execute();
        }

        public function logear($usuario, $password) {
            $conexion = parent::conectar();
            $passwordExistente = "";
            $sql = "SELECT * FROM usuarios 
                    WHERE email = '$usuario'";
            $respuesta = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($respuesta) > 0) {
                $user = mysqli_fetch_array($respuesta);
                $passwordExistente = $user['passwor'];

                if($user['estado'] == 1){
                    if (password_verify($password, $passwordExistente)) {
                        $_SESSION['usuario'] = $user['nombre'];
                        $_SESSION['rol'] = $user['perfil'];
                        $_SESSION['id'] = $user['id'];
                        
                        echo json_encode(["Message" => "Logueo Exitoso","Code" => 200]);

                    } else {
                        echo json_encode(["Message" => "Contraseña incorrecta","Code" => 500]);
                    }
                }else{
                    echo json_encode(["Message" => "Usuario inactivo, comuníquese con una autoridad","Code" => 500]);
                }
                
            } else {
                echo json_encode(["Message" => "Usuario incorrecto","Code" => 500]);
            }
        }   
    }

?>