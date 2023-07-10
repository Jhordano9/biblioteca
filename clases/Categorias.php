<?php 
    include "Conexion.php";

    class Categoria extends Conexion {
        public function registrar($usuario, $password) {
            $conexion = parent::conectar();
            $sql = "INSERT INTO t_usuarios (usuario, password) 
                    VALUES (?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ss', $usuario, $password);
            return $query->execute();
        }

        public function listar() {
            $conexion = parent::conectar();
            $passwordExistente = "";
            $sql = "SELECT * FROM categorias";
            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all();

            if ($respuesta) {
                $data = array("data"=>$respuesta);
                
                return json_encode($data);
            } else {
                return false;
            }
        }   
    }

?>