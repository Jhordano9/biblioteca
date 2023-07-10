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
                $passwordExistente = $user['password'];
                
                if (password_verify($password, $passwordExistente)) {
                    $_SESSION['usuario'] = $user['nombre'];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }   
    }

?>