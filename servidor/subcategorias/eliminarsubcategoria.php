<?php session_start();
    include "../../clases/Subcategoria.php";

    $Subcategoria = new SubCategoria();

    $idsubcat = $_POST['idSubCategoria'];

    $response = $Subcategoria->delete($idsubcat);

    if ($response) {
        echo json_encode(["Message" => "Eliminado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
    }

?>