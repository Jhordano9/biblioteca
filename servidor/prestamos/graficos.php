<?php session_start();
    include "../../clases/Prestamo.php";

    $prestamo = new Prestamo();

    $tipo = $_POST['tipo'];

    if($tipo == 'donas'){
        $response = $prestamo->donas();
    }else{
        $response = $prestamo->barras();
    }
    
    if ($response) {
        echo $response;
    }

?>