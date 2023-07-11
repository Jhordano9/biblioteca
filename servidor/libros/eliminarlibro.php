<?php session_start();
    include "../../clases/Libro.php";

    $libro = new Libro();

    $idcat = $_POST['idLibro'];

    $response = $libro->delete($idcat);

    if ($response) {
        echo json_encode(["Message" => "Eliminado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
    }

?>