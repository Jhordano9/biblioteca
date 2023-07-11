<?php include_once 'includes/header.php' ?>

<?php
//Conectamos a la base de datos
require('conexion.php');

//Evitamos que salgan errores por variables vacías
error_reporting(E_ALL ^ E_NOTICE);

//Cantidad de resultados por página (debe ser INT, no string/varchar)
$cantidad_resultados_por_pagina = 10;

//Comprueba si está seteado el GET de HTTP
if (isset($_GET["pagina"])) {

    //Si el GET de HTTP SÍ es una string / cadena, procede
    if (is_string($_GET["pagina"])) {

        //Si la string es numérica, define la variable 'pagina'
         if (is_numeric($_GET["pagina"])) {

             //Si la petición desde la paginación es la página uno
             //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
             if ($_GET["pagina"] == 1) {
                 header("Location: libros.php");
                 die();
             } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
                 $pagina = $_GET["pagina"];
            };

         } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
             header("Location: libros.php");
            die();
         };
    };

} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
    $pagina = 1;
};

//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
$empezar_desde = ($pagina-1) * $cantidad_resultados_por_pagina;

?>
<?php
//Obtiene TODO de la tabla
$obtener_todo_BD = "SELECT * FROM libros";

//Realiza la consulta
$consulta_todo = Conexion::conectar()->query($obtener_todo_BD);

//Cuenta el número total de registros
$total_registros = $consulta_todo->rowCount();

//Obtiene el total de páginas existentes
//Obtiene el total de páginas existentes
if ($total_registros>$cantidad_resultados_por_pagina) {
    $total_paginas = ceil($total_registros / $cantidad_resultados_por_pagina); 
}
else{
    $total_paginas=1;
}

//Realiza la consulta en el orden de ID ascendente (cambiar "id" por, por ejemplo, "nombre" o "edad", alfabéticamente, etc.)
//Limitada por la cantidad de cantidad por página
$consulta_resultados = Conexion::conectar()->query("
SELECT * FROM `libros` 
ORDER BY `libros`.`id` ASC 
LIMIT $empezar_desde, $cantidad_resultados_por_pagina");
?>

<div class="container">
    <div style="display:flex;">
        <div style="width: 50%;">
            <h1 class="mt-4">Libros</h1>
        </div>
        <div style="width: 50%;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarLibro" style="float: right;margin-top:40px;">Agregar Libro</button>
        </div> 
    </div>
    <div class="py-5">
        <div class="container">
        <div class="row">
        <?php $ruta = "public/images/libros/"; 
              $ruta2 = "public/pdfs/";
                        
            foreach($consulta_resultados as $row){?>
            <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-block" style="display: flex;">
                <img class="card-img-top" src="<?php echo $ruta.$row['imagen']?>" alt="Card image cap" style="width:150px;">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $row['nombre']; ?></h4>
                    <h6 class="card-subtitle text-muted"><?php echo $row['autor']; ?></h6>
                    <p class="card-text p-y-1">Some quick example text to build on the card title .</p>
                    <a type="button" href="<?php echo $ruta2.$row['pdf']?>"  target="_blank" class="btn btn-outline-warning"><i class="fa-solid fa-arrow-down"></i> Descargar</a>
                    <a type="button" data-id="<?php echo $row['id']; ?>" target="_blank" class="btn btn-outline-success editar"><i class="fa-regular fa-pen-to-square"></i> Editar</a>
                    <a type="button" data-id="<?php echo $row['id']; ?>" target="_blank" class="btn btn-outline-danger eliminar"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
                </div>
                
                </div>
            </div>
            </div>
            <?php } ?>

        </div>
        </div>
    </div>
</div>

<div class="container pagination mb-4" id="pagination">
    
    <?php
    $bobo='?pagina=';

    $cer='libros.php';
    //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
    //Nota: X = $total_paginas
    for ($i=1; $i<=$total_paginas; $i++) {
   

        if($i==1){echo "<li class='page-numbers'><a class='page-numbers' id='previus' href='#'>Anterior</a></li><li class='page-item'><a id='libros' class='page-numbers activado' href='$cer'>Página 1</a></li>";}
                                
                                else if ($i>1) {
                                    echo "<li class='page-numbers'><a id='page".$i."' class='page-numbers' href='$bobo".$i."'>Página ".$i."</a></li><li class='page-item'><a id='$i' class='page-numbers' href='#'>...</a></li>";}
                                }?>
    <li class='page-item'><a class='page-numbers' id='next' href='#'>Siguiente</a></li> 

</div>

<div class="modal fade" id="modalAgregarLibro" tabindex="-1" aria-labelledby="modalAgregarLibro" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Categoría</label>
            <select name="categoria" class="form-select" aria-label="Default select example" id="categoria">
                <option value="">Seleccione Categoría</option>
                <?php
                    $sql=Conexion::conectar()->prepare("SELECT * FROM categorias ORDER BY id DESC");
                    $sql->execute();
                    foreach ($sql as $row) {
                        echo "<option value='".$row['id']."'>";
                        echo $row['nombre'];
                        echo "</option>";
                    }
                ?>
            </select> 
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Autor</label>
            <input type="text" class="form-control" id="autor" name="autor" placeholder="Autor">
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="text" class="form-control" id="libro" name="libro" placeholder="libro">
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Tipo</label>
            <select name="tipo" class="form-select" aria-label="Default select example" id="tipo">
                <option value="">Seleccione el tipo de libro</option>
                <option value="1">Digital</option>
                <option value="2">Físico</option>
            </select>
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputPassword1">Imagen</label><br>
            <input name="fichero[]" id="fichero" type="file" size="150" maxlength="150" multiple=""> 
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputPassword1">Pdf</label><br>
            <input name="pdf[]" id="pdf" type="file" size="150" maxlength="150" multiple=""> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="gou" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>

  <?php include_once 'includes/footer.php' ?>

<script>

$("#gou").click(function(){

    var formData = new FormData();
    formData.append('idCategoria',$("#categoria").val());
    formData.append('autor',$("#autor").val());
    formData.append('tipo',$("#tipo").val());
    formData.append('nomLibro',$("#libro").val());
    formData.append('imagen',$('#fichero')[0].files[0]);
    formData.append('pdf',$('#pdf')[0].files[0]);

    $.ajax({
            url: 'servidor/libros/agregarlibro.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                if(response.Code == 200){
                  swal({
                    icon: "success",
                    title: response.Message,
                    button: "Cerrar",
                    closeModal: false
                    }).then((value) => {
                      if(value){
                        window.location = "libros.php";
                      }
                    })
                }else{
                  swal({
                    icon: "error",
                    title: response.Message,
                    button: "Cerrar",
                    closeModal: false
                    }).then((value) => {
                      if(value){
                        window.location = "libros.php";
                      }
                    })
                }
            }
        });
  });

  $('.eliminar').click(function(e){

    var formData = new FormData();
    formData.append('idLibro',$(this).data('id'));

    swal({
      title: "Estás seguro de eliminar el libro?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $.ajax({
              url: 'servidor/libros/eliminarlibro.php',
              type: 'post',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {
                  response = JSON.parse(response);
                  console.log(response);
                  if(response.Code == 200){
                    swal({
                      icon: "success",
                      title: response.Message,
                      button: "Cerrar",
                      closeModal: false
                      }).then((value) => {
                        if(value){
                          window.location = "libros.php";
                        }
                      })
                  }else{
                    swal({
                      icon: "error",
                      title: response.Message,
                      button: "Cerrar",
                      closeModal: false
                      }).then((value) => {
                        if(value){
                          window.location = "libros.php";
                        }
                      })
                  }
              }
        });
      } else {
        
      }
    });

  });

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    
    var pagina = getParameterByName('pagina');
    var siguiente = (pagina*1)+1;
    var a = document.getElementById('previus'); 
    var b = document.getElementById('next');
    var elemento = document.getElementById("page"+pagina);
    var libros = document.getElementById("libros");
    var totalp = <?php echo $total_paginas ?>;
    
    if (pagina == 2 && pagina!=totalp) {
        a.href = "libros.php"
        b.href = "?pagina=" + (siguiente);
        elemento.className += " activado";
        libros.classList.remove('activado');
    }
    else if (pagina == 2 && pagina==totalp) {
        a.href = "libros.php"
        b.href = "#";
        elemento.className += " activado";
        libros.classList.remove('activado');
    }
    else if (pagina>2 && pagina<totalp) {
    a.href = "?pagina=" + (pagina-1);
    b.href = "?pagina=" + (siguiente);
    elemento.className += " active";
    var remplazo = document.getElementById("page2");
    remplazo.innerHTML="Página "+pagina;
    remplazo.className += " activado";
    libros.classList.remove('activado');
    }
    else if (pagina==totalp) {
        a.href = "?pagina=" + (pagina-1);
        b.href = "#";
        elemento.className += " activado";
        libros.classList.remove('activado');
    }
    else if (totalp==1) {
        b.href = "#";
    }
    else{
        b.href = "?pagina=2";
    }


    

    if (totalp > 3) {
        for (var i = 3; i <= totalp; i++) {
        if (i<totalp) {
            var elemento = document.getElementById("page"+i);
            elemento.style.display="none";
        }
        
        var medio = document.getElementById(i);
        medio.style.display="none";
        
        }
    } else if (totalp>1 && totalp <=3) {
        var punto2 = document.getElementById('2');
        punto2.style.display="none";
        var punto3 = document.getElementById('3');
        punto3.style.display="none";
    }

</script>