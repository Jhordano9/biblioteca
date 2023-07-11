<?php session_start();
    include "../../clases/Subcategoria.php";

    $Subcategoria = new SubCategoria();

    $subcategoria = $_POST["nomSubCategoria"];
    $categoria = $_POST["categoria"];
    //foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
    //{
        //if(is_uploaded_file($_FILES['imagen']['tmp_name'][$key])) { 
        
        
            // creamos las variables para subir a la db
            $ruta = "../../public/images/categorias/"; 

            $nombrefinal= trim ($_FILES['imagen']['name']); //Eliminamos los espacios en blanco
            
            $upload= $ruta . $nombrefinal;  


            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $upload)) { //movemos el archivo a su ubicacion 
                        
                        /*echo "<b>Agregado correctamente!. Datos:</b><br>";  
                        echo "Nombre: <i><a href=\"".$ruta . $nombrefinal."\">".$_FILES['imagen']['name']."</a></i><br>";  
                        echo "Tipo MIME: <i>".$_FILES['imagen']['type']."</i><br>";  
                        echo "Peso: <i>".$_FILES['imagen']['size']." bytes</i><br>"; 
                        echo "<br><hr><br>";  */
            
                $response = $Subcategoria->registrar($subcategoria,$nombrefinal,$categoria);

                if ($response) {
                    echo json_encode(["Message" => "Agregado Exitosamente","Code" => 200]);
                }else{
                    echo json_encode(["Message" => "Error al registrar","Code" => 500]);
                }
        
            }  
        //}  
    //}

?>