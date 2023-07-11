<?php session_start();
    include "../../clases/Libro.php";

    $libro = new Libro();

    $categoria = $_POST["idCategoria"];
    $autor = $_POST["autor"];
    $tipo = $_POST["tipo"];
    $nomlibro = $_POST["nomLibro"];

    //foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
    //{
        //if(is_uploaded_file($_FILES['imagen']['tmp_name'][$key])) { 
        
        
            // creamos las variables para subir a la db
            $ruta1 = "../../public/images/libros/"; 
            $ruta2 = "../../public/pdfs/"; 

            $nombrefinal1 = trim ($_FILES['imagen']['name']); //Eliminamos los espacios en blanco
            $nombrefinal2 = trim ($_FILES['pdf']['name']); //Eliminamos los espacios en blanco
            
            $upload1 = $ruta1 . $nombrefinal1; 
            $upload2 = $ruta2 . $nombrefinal2;  


            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $upload1) && move_uploaded_file($_FILES['pdf']['tmp_name'], $upload2)) { //movemos el archivo a su ubicacion 
                        
                        /*echo "<b>Agregado correctamente!. Datos:</b><br>";  
                        echo "Nombre: <i><a href=\"".$ruta . $nombrefinal."\">".$_FILES['imagen']['name']."</a></i><br>";  
                        echo "Tipo MIME: <i>".$_FILES['imagen']['type']."</i><br>";  
                        echo "Peso: <i>".$_FILES['imagen']['size']." bytes</i><br>"; 
                        echo "<br><hr><br>";  */
            
                $response = $libro->registrar($categoria,$autor,$tipo,$nomlibro,$nombrefinal1,$nombrefinal2);

                if ($response) {
                    echo json_encode(["Message" => "Agregado Exitosamente","Code" => 200]);
                }else{
                    echo json_encode(["Message" => "Error al registrar","Code" => 500]);
                }
        
            }  
        //}  
    //}

?>