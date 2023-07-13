<?php include_once 'includes/header.php'?>

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
                 header("Location: inicio.php");
                 die();
             } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
                 $pagina = $_GET["pagina"];
            };

         } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
             header("Location: inicio.php");
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
$obtener_todo_BD = "SELECT * FROM categorias";

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
SELECT * FROM `categorias` 
ORDER BY `categorias`.`id` ASC 
LIMIT $empezar_desde, $cantidad_resultados_por_pagina");
?>

<!-- Page Content -->
<div class="container mb-4">
    <div>
        <h1 class="mt-4">Catálogo</h1>
        <div class="pt-3" style="display: flex;width:80%;">
            <select class="form-select" name="tipob" id="tipob">
                <option value="categoria">Categoría</option>
                <option value="autor">Autor</option>
                <option value="libro">Libro</option>
            </select>
            <input type="text" class="form-control" placeholder="Buscar" name="search" id="search">
            <i class="fa-solid fa-magnifying-glass" id="searc"></i>
        </div>
        
    </div>
    <div class="py-5">
        <div class="container">
        <div class="row">
  <?php $ruta = "public/images/categorias/"; 
                        
                foreach($consulta_resultados as $row){?>
            <div class="col-md-3 mb-4">
                <div class="card">
                <img class="card-img-top" height="300" src="<?php echo $ruta.$row['imagen']?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nombre']?></h5>
                    <a data-id="<?php echo $row['nombre']?>" class="btn btn-primary ir">Ver</a>
                </div>
                </div>
            </div>
  <?php }?>
        </div>
        </div>
    </div>
</div>
<div class="container pagination mb-4" id="pagination">
    
    <?php
    $bobo='?pagina=';

    $cer='inicio.php';
    //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
    //Nota: X = $total_paginas
    for ($i=1; $i<=$total_paginas; $i++) {
   

        if($i==1){echo "<li class='page-numbers'><a class='page-numbers' id='previus' href='#'>Anterior</a></li><li class='page-item'><a id='inicio' class='page-numbers activado' href='$cer'>Página 1</a></li>";}
                                
                                else if ($i>1) {
                                    echo "<li class='page-numbers'><a id='page".$i."' class='page-numbers' href='$bobo".$i."'>Página ".$i."</a></li><li class='page-item'><a id='$i' class='page-numbers' href='#'>...</a></li>";}
                                }?>
    <li class='page-item'><a class='page-numbers' id='next' href='#'>Siguiente</a></li> 

</div>
    
<?php include_once 'includes/footer.php'?>

<script type="text/javascript">
    
    /**
 * @param String name
 * @return String
 */

 $('.ir').click(function(e){
    e.preventDefault();

    let tipo = 'categoria';
    let search = $(this).data('id');
    window.location.href = 'libros.php?tipo='+tipo+'&search='+search;

 });

 $('#search').keypress(function(event){
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    let tipo = $('#tipob').val();
    let search = $('#search').val();
    window.location.href = 'libros.php?tipo='+tipo+'&search='+search;
  }
});

 $('#searc').click(function(e){
    e.preventDefault();
    let tipo = $('#tipob').val();
    let search = $('#search').val();
    window.location.href = 'libros.php?tipo='+tipo+'&search='+search;
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
    var inicio = document.getElementById("inicio");
    var totalp = <?php echo $total_paginas ?>;
    
    if (pagina == 2 && pagina!=totalp) {
        a.href = "inicio.php"
        b.href = "?pagina=" + (siguiente);
        elemento.className += " activado";
        inicio.classList.remove('activado');
    }
    else if (pagina == 2 && pagina==totalp) {
        a.href = "inicio.php"
        b.href = "#";
        elemento.className += " activado";
        inicio.classList.remove('activado');
    }
    else if (pagina>2 && pagina<totalp) {
    a.href = "?pagina=" + (pagina-1);
    b.href = "?pagina=" + (siguiente);
    elemento.className += " active";
    var remplazo = document.getElementById("page2");
    remplazo.innerHTML="Página "+pagina;
    remplazo.className += " activado";
    inicio.classList.remove('activado');
    }
    else if (pagina==totalp) {
        a.href = "?pagina=" + (pagina-1);
        b.href = "#";
        elemento.className += " activado";
        inicio.classList.remove('activado');
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
    
    jQuery(".ver-productos").click(function(){
            var categoria = jQuery(this).data('id');
            
          /*$.post("categoria.php", {categoria: categoria},function(result){
            window.location.href='categoria.php';
          });*/
          window.location.href = 'categorias.php?id='+categoria
        });
    
    jQuery("#buscaa").click(function(){
            var nombre = jQuery('.buscar').val();
            
          /*$.post("categoria.php", {categoria: categoria},function(result){
            window.location.href='categoria.php';
          });*/
          window.location.href = 'estudiante.php?nombre='+nombre
        });
    
    jQuery("#buscar").keypress(function(event) {
        if (event.keyCode === 13) {
            var nombre = jQuery('.buscar').val();
            
            window.location.href = 'estudiante.php?nombre='+nombre
        }
    });

</script>