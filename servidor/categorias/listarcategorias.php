<?php session_start();
    include "../../clases/Categorias.php";

    $Categoria = new Categoria();

    $response = $Categoria->listar();
    if ($response) {
        echo $response;
    }

?>