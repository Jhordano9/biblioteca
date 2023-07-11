<?php session_start();
    include "../../clases/Subcategoria.php";

    $Subcategoria = new SubCategoria();

    $response = $Subcategoria->listar();
    if ($response) {
        echo $response;
    }else{
        echo json_encode([]);
    }

?>