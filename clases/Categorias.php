<?php 
    include "Conexion.php";

    class Categoria extends Conexion {
        public function registrar($nombre, $imagen) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "INSERT INTO categorias (nombre, imagen) 
                    VALUES (?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ss', $nombre, $imagen);
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

                foreach($data["data"] as $key => $dat){
                    $data["data"][$key][] = '<ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <button type="button" id="editcat" data-id="'.$data["data"][$key][0].'" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i> Editar</button>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" id="deletecat" data-id="'.$data["data"][$key][0].'" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i> Eliminar</button>
                    </li>
                </ul>';
                }

                return json_encode($data);
            } else {
                return false;
            }
        }
        
        public function editar($idcat, $nombre, $imagen) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();

            if($imagen !=''){
                $sql = "UPDATE categorias SET nombre = ?, imagen = ? WHERE id = ?"; 
                $query = $conexion->prepare($sql);
                $query->bind_param('ssi', $nombre, $imagen, $idcat);
            }else{
                $sql = "UPDATE categorias SET nombre = ? WHERE id = ?"; 
                $query = $conexion->prepare($sql);
                $query->bind_param('si', $nombre, $idcat);
            }
            
            return $query->execute();
        }

        public function delete($idcat) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "DELETE FROM categorias WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idcat);
            return $query->execute();
        }
        
    }

?>