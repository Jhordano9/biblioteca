<?php session_start(); 
  if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
  }
?>

<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Biblioteca</title>
  </head>
  <body>
    
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
  <div class="container">
    <a class="navbar-brand" href="inicio.php">
      <img src="public/images/logo500.png" alt="..." height="80">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">
      <li class="nav-item">
          <a class="nav-link" aria-current="page" href="inicio.php">Inicio</a>
        </li>
        <?php if($_SESSION['rol'] == 'administrador'){?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="categorias.php">Categorias</a>
        </li>
        <!--<li class="nav-item">
          <a class="nav-link" href="subcategorias.php">Subcategorias</a>
        </li>-->
        <?php }?>
        <?php if($_SESSION['rol'] == 'administrador' || $_SESSION['rol'] == 'estudiante'){?>
        <li class="nav-item">
          <a class="nav-link" href="libros.php">Libros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="prestamos.php">Préstamos</a>
        </li>
        <?php } ?>
        <li class="nav-item dropdown">
          <a style="color:red" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['usuario']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <?php if($_SESSION['rol'] == 'administrador'){?>
          <li><a class="dropdown-item" href="usuarios.php">Usuarios</a></li>
          <?php }?>
            <li><a class="dropdown-item" href="servidor/login/logout.php">Salir del sistema</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>