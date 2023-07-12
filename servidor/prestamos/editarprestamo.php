<?php session_start();
    include "../../clases/Prestamo.php";

    $idcat = $_POST['idPrestamo'];
    $estado = $_POST['estado'];

    $prestamo = new Prestamo();

    $response = $prestamo->editar($idcat,$estado);

    if ($response) {
        echo json_encode(["Message" => "Estado cambiado correctamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "La categoría seleccionada no tiene libros","Code" => 500]);
    }

?>