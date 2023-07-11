<?php 
    include "Conexion.php";

    class SubCategoria extends Conexion {
        public function registrar($nombre, $imagen, $categoria) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "INSERT INTO subcategorias (nombre, imagen, categoria_id) 
                    VALUES (?,?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('ssi',$nombre, $imagen, $categoria);
            return $query->execute();
        }

        public function listar() {
            $conexion = parent::conectar();
            $passwordExistente = "";
            $sql = "SELECT * FROM subcategorias";
            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all();

            if ($respuesta) {
                $data = array("data"=>$respuesta);

                foreach($data["data"] as $key => $dat){
                    $data["data"][$key][] = '<ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <button type="button" id="editsubcat" data-id="'.$data["data"][$key][0].'" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i> Editar</button>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" id="deletesubcat" data-id="'.$data["data"][$key][0].'" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i> Eliminar</button>
                    </li>
                </ul>';
                }
                
                return json_encode($data);
            } else {
                return false;
            }
        }
        
        public function editar($idsubcat, $categoria, $nombre, $imagen) {
            
            $conexion = parent::conectar();
            $sql = "UPDATE subcategorias SET nombre = ?, imagen = ?, categoria_id = ? WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('ssii', $nombre, $imagen, $categoria, $idsubcat);
            return $query->execute();
        }

        public function delete($idcat) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "DELETE FROM subcategorias WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idcat);
            return $query->execute();
        }
        
    }

?>