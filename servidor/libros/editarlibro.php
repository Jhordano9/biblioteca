<?php session_start();
    include "../../clases/Libro.php";

    $libro = new Libro();

    $idLibro = $_POST['idLibro'];
    $categoria = $_POST["idCategoria"];
    $autor = $_POST["autor"];
    $tipo = $_POST["tipo"];
    $nomlibro = $_POST["nomLibro"];

    //foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
    //{
        //if(is_uploaded_file($_FILES['imagen']['tmp_name'][$key])) { 

    $ruta1 = "../../public/images/libros/"; 
    $ruta2 = "../../public/pdfs/"; 
        
        if(isset($_FILES['imagen'])) { 
            // creamos las variables para subir a la db

            $nombrefinal1 = trim ($_FILES['imagen']['name']); //Eliminamos los espacios en blanc
            $upload1 = $ruta1 . $nombrefinal1; 

            if(isset($_FILES['pdf'])){

                $nombrefinal2 = trim ($_FILES['pdf']['name']); //Eliminamos los espacios en blanco
                $upload2 = $ruta2 . $nombrefinal2;  

                if(move_uploaded_file($_FILES['imagen']['tmp_name'], $upload1) && move_uploaded_file($_FILES['pdf']['tmp_name'], $upload2)) { //movemos el archivo a su ubicacion 
            
                    $response = $libro->editar($idLibro,$categoria,$autor,$tipo,$nomlibro,$nombrefinal1,$nombrefinal2);
    
                    if ($response) {
                        echo json_encode(["Message" => "Editado Exitosamente","Code" => 200]);
                    }else{
                        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
                    }
            
                }

            }else{

                if(move_uploaded_file($_FILES['imagen']['tmp_name'], $upload1)) { //movemos el archivo a su ubicacion 
            
                    $response = $libro->editar($idLibro,$categoria,$autor,$tipo,$nomlibro,$nombrefinal1,'');
    
                    if ($response) {
                        echo json_encode(["Message" => "Editado Exitosamente","Code" => 200]);
                    }else{
                        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
                    }
            
                }

            }
              
        }else{

            if(isset($_FILES['pdf'])){

                $nombrefinal2 = trim ($_FILES['pdf']['name']); //Eliminamos los espacios en blanco
                $upload2 = $ruta2 . $nombrefinal2; 

                if(move_uploaded_file($_FILES['pdf']['tmp_name'], $upload2)) { //movemos el archivo a su ubicacion 
            
                    $response = $libro->editar($idLibro,$categoria,$autor,$tipo,$nomlibro,'',$nombrefinal2);

                    if ($response) {
                        echo json_encode(["Message" => "Editado Exitosamente","Code" => 200]);
                    }else{
                        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
                    }
        
                }  
            }else{

                $response = $libro->editar($idLibro,$categoria,$autor,$tipo,$nomlibro,'','');

                if ($response) {
                    echo json_encode(["Message" => "Editado Exitosamente","Code" => 200]);
                }else{
                    echo json_encode(["Message" => "Error al registrar","Code" => 500]);
                }

            }

        }
        //}  
    //}

?>