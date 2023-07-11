<?php session_start();
    include "../../clases/Categorias.php";

    $Categoria = new Categoria();

    $idcat = $_POST['idCategoria'];

    $response = $Categoria->delete($idcat);

    if ($response) {
        echo json_encode(["Message" => "Eliminado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
    }

?>