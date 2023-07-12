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

        public function listar($idcat) {
            $conexion = parent::conectar();
            $passwordExistente = "";
            $sql = "SELECT * FROM libros WHERE categoria_id = $idcat";
            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all(MYSQLI_ASSOC);

            if (count($respuesta)>0) {
                $i = 0;
                $data = [];

                foreach($respuesta as $res){
                    $data[$i]['idLib'] = $res['id'];
                    $data[$i]['nombre'] = $res['nombre'];
                    $i++;
                }
                
                return json_encode($data);
            } else {
                return false;
            }
        } 
        
        public function editar($idlibro, $categoria,$autor,$tipo,$nomlibro,$imagen,$pdf) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();

            if($imagen != '' && $pdf != ''){
                $sql = "UPDATE libros SET categoria_id = ?, autor = ?, nombre = ?, tipo = ?, imagen = ?, pdf = ? WHERE id = ?"; 
                $query = $conexion->prepare($sql);
                $query->bind_param('ississi', $categoria, $autor, $nomlibro, $tipo, $imagen, $pdf, $idlibro);
            }else if($imagen != ''){
                $sql = "UPDATE libros SET categoria_id = ?, autor = ?, nombre = ?, tipo = ?, imagen = ? WHERE id = ?"; 
                $query = $conexion->prepare($sql);
                $query->bind_param('issisi', $categoria, $autor, $nomlibro, $tipo, $imagen, $idlibro);
            }else if($pdf != ''){
                $sql = "UPDATE libros SET categoria_id = ?, autor = ?, nombre = ?, tipo = ?, pdf = ? WHERE id = ?"; 
                $query = $conexion->prepare($sql);
                $query->bind_param('issisi', $categoria, $autor, $nomlibro, $tipo, $pdf, $idlibro);
            }else{
                $sql = "UPDATE libros SET categoria_id = ?, autor = ?, nombre = ?, tipo = ? WHERE id = ?"; 
                $query = $conexion->prepare($sql);
                $query->bind_param('issii', $categoria, $autor, $nomlibro, $tipo, $idlibro);
            }
            
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