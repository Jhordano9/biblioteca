<?php 
    include "Conexion.php";

    class Prestamo extends Conexion {
        public function registrar($nombre, $imagen) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "INSERT INTO prestamos (nombre, imagen) 
                    VALUES (?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ss', $nombre, $imagen);
            return $query->execute();
        }

        public function listar() {
            $conexion = parent::conectar();
            $passwordExistente = "";
            $sql = "SELECT * FROM prestamos";
            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all();

            if ($respuesta) {
                $data = array("data"=>$respuesta);
                
                return json_encode($data);
            } else {
                return false;
            }
        } 
        
        public function editar($idcat, $nombre, $imagen) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "UPDATE prestamos SET nombre = ?, imagen = ? WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('ssi', $nombre, $imagen, $idcat);
            return $query->execute();
        }

        public function delete($idcat) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "DELETE FROM prestamos WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idcat);
            return $query->execute();
        }
        
    }

?>