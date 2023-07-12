<?php session_start();
    include "../../clases/Prestamo.php";

    $prestamo = new Prestamo();

    $response = $prestamo->listar();
    if ($response) {
        echo $response;
    }

?>