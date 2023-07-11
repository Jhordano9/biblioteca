<?php 
    include "Conexion.php";

    class Libro extends Conexion {
        public function registrar($categoria,$autor,$tipo,$nomlibro,$imagen,$pdf) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "INSERT INTO libros (categoria_id, autor, nombre, tipo, imagen, pdf) 
                    VALUES (?,?,?,?,?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ississ', $categoria, $autor, $nomlibro, $tipo, $imagen, $pdf);
            return $query->execute();
        }

        public function listar() {
            $conexion = parent::conectar();
            $passwordExistente = "";
            $sql = "SELECT * FROM libros";
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
            $sql = "UPDATE libros SET nombre = ?, imagen = ? WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('ssi', $nombre, $imagen, $idcat);
            return $query->execute();
        }

        public function delete($idcat) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "DELETE FROM libros WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idcat);
            return $query->execute();
        }
        
    }

?>