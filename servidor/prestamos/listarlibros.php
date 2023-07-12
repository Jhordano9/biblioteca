<?php session_start();
    include "../../clases/Libro.php";

    $idcat = $_POST['id_cat'];

    $libro = new Libro();

    $response = $libro->listar($idcat);

    if ($response) {
        echo json_encode(["data" => $response,"Code" => 200]);
    }else{
        echo json_encode(["Message" => "La categoría seleccionada no tiene libros","Code" => 500]);
    }

?>