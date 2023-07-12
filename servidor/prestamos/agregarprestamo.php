<?php session_start();
    include "../../clases/Prestamo.php";

    $prestamo = new Prestamo();

    $categoria = $_POST["idCategoria"];
    $libro = $_POST["idLibro"];
    $estudiante = $_POST["idEstudiante"];
    $fechainicio = $_POST['fechaInicio'];
    $fechafin = $_POST['fechaFin'];
        
    $response = $prestamo->registrar($categoria,$libro,$estudiante,$fechainicio,$fechafin);

    if ($response) {
        echo json_encode(["Message" => "Préstamo Registrado Exitosamente","Code" => 200]);
    }else{
        echo json_encode(["Message" => "Error al registrar","Code" => 500]);
    }

?>