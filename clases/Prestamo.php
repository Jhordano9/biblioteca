<?php 
    include "Conexion.php";

    class Prestamo extends Conexion {
        public function registrar($categoria,$libro,$estudiante,$fechainicio,$fechafin) {
            $estado = 'Pendiente';
            $conexion = parent::conectar();
            $sql = "INSERT INTO prestamos (categoria_id, libro_id, estudiante_id, fecha_inicio, fecha_fin, estado) 
                    VALUES (?,?,?,?,?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param('iiisss', $categoria,$libro,$estudiante,$fechainicio,$fechafin,$estado);
            return $query->execute();
        }

        public function listar() {
            $conexion = parent::conectar();
            $passwordExistente = "";

            if($_SESSION['rol'] == 'administrador'){
                $sql = "SELECT p.id, c.nombre, l.nombre, e.nombre, p.fecha_inicio, p.fecha_fin, p.estado FROM prestamos as p 
                LEFT JOIN categorias as c ON c.id = p.categoria_id
                LEFT JOIN libros as l ON l.id = p.libro_id
                LEFT JOIN estudiantes as e ON e.id = p.estudiante_id";
            }else{

                $user = $_SESSION['id'];

                $sql = "SELECT p.id, c.nombre, l.nombre, e.nombre, p.fecha_inicio, p.fecha_fin, p.estado FROM prestamos as p 
                LEFT JOIN categorias as c ON c.id = p.categoria_id
                LEFT JOIN libros as l ON l.id = p.libro_id
                LEFT JOIN estudiantes as e ON e.id = p.estudiante_id
                WHERE p.estudiante_id = $user";
            }
            
            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all();

            if (count($respuesta)>0) {

                foreach($respuesta as $keyval => $res){
                    if($res[6] == 'Pendiente'){
                        $respuesta[$keyval][6] = '<button type="button" class="btn btn-warning btn-sm">'.$res[6].'</button>';
                        if($_SESSION['rol'] == 'administrador'){
                            $respuesta[$keyval][7] = '<button type="button" data-id="'.$res[0].'" id="prestar" style="width: 200px;" class="btn btn-outline-success btn-sm">Marcar como prestado</button>';
                        }
                    }else if($res[6] == 'En curso'){
                        $respuesta[$keyval][6] = '<button type="button" class="btn btn-success btn-sm">'.$res[6].'</button>';
                        if($_SESSION['rol'] == 'administrador'){
                            $respuesta[$keyval][7] = '<button type="button" data-id="'.$res[0].'" id="entregar" style="width: 200px;" class="btn btn-outline-primary btn-sm">Marcar como devuelto</button>';
                        }
                    }else if($res[6] == 'Entregado'){
                        $respuesta[$keyval][6] = '<button type="button" class="btn btn-primary btn-sm">'.$res[6].'</button>';
                        if($_SESSION['rol'] == 'administrador'){
                            $respuesta[$keyval][7] = '';
                        }
                    }
                }

                $data = array("data"=>$respuesta);
                
                return json_encode($data);
            } else {
                return json_encode([]);
            }
        }
        
        public function barras($fechai = null, $fechaf = null){

            $conexion = parent::conectar();
            $sql = "SELECT l.nombre AS libro, COUNT(l.id) AS cantidad FROM prestamos as p 
            LEFT JOIN categorias as c ON c.id = p.categoria_id
            LEFT JOIN libros as l ON l.id = p.libro_id
            GROUP BY l.nombre
            ORDER BY cantidad DESC LIMIT 5";

            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all(MYSQLI_ASSOC);

            if(count($respuesta)>0){
                
                //$data = array("data"=>$respuesta);
                $data = [];
                $etiquetas = [];
                $colores = ['green','blue'];
                $i = 0;
                foreach($respuesta as $res){
                    $etiquetas[$i] = $res['libro'];
                    $data[$i] = $res['cantidad'];
                    $i++;
                }
                
                return json_encode(["data" => $data, "etiquetas" => $etiquetas, "colores" => $colores,"Code" => 200]);

            }else{
                return false;
            }

        }

        public function donas($fechai = null, $fechaf = null){

            $conexion = parent::conectar();
            $sql = "SELECT c.nombre AS categoria, COUNT(c.id) AS cantidad FROM prestamos as p 
            LEFT JOIN categorias as c ON c.id = p.categoria_id
            GROUP BY c.nombre";

            $query = $conexion->query($sql);
            $respuesta = $query->fetch_all(MYSQLI_ASSOC);

            if(count($respuesta)>0){
                
                //$data = array("data"=>$respuesta);
                $data = [];
                $etiquetas = [];
                $colores = ['green','blue'];
                $i = 0;
                foreach($respuesta as $res){
                    $etiquetas[$i] = $res['categoria'];
                    $data[$i] = $res['cantidad'];
                    $i++;
                }
                
                return json_encode(["data" => $data, "etiquetas" => $etiquetas, "colores" => $colores,"Code" => 200]);

            }else{
                return false;
            }

        }
        
        public function editar($id, $estado) {
            //var_dump($nombre, $imagen);
            $conexion = parent::conectar();
            $sql = "UPDATE prestamos SET estado = ? WHERE id = ?"; 
            $query = $conexion->prepare($sql);
            $query->bind_param('si', $estado, $id);
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