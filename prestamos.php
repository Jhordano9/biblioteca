<?php include_once 'includes/header.php'?>
<?php require_once 'conexion.php' ?>
<!-- Page Content -->
<div class="container">
    <div style="display:flex;">
        <div style="width: 50%;">
            <h1 class="mt-4 mb-4">Préstamos</h1>
        </div>
        <div style="width: 50%;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoPrestamo" style="float: right;margin-top:40px;">Generar Préstamo</button>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
    <!-- CREAR UNA TABLA PARA MOSTRAR LOS DATOS -->
            <table class="table table-responsive table-bordered" id="mytable">
                <thead>
                    <td>CodPrestamo</td>
                    <th>Categoría</th>
                    <th>Libro</th>
                    <th>Estudiante</th>
                    <th>Fecha de solicitud</th>
                    <th>Fecha de devolución</th>
                    <th>Estado</th>
                    <?php if($_SESSION['rol'] == 'administrador'){ ?>
                    <th>Acciones</th>
                    <?php }?>
                </thead>
                <tr>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevoPrestamo" tabindex="-1" aria-labelledby="modalNuevoPrestamo" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Préstamo</h5>
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
            <label for="exampleInputEmail1">Libro</label>
            <select name="libro" class="form-select" aria-label="Default select example" id="libro">
                <option value="">Seleccione Libro</option>
            </select> 
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Estudiante</label>
            <select name="estudiante"  id="estudiante">
                <option value="">Seleccione Estudiante</option>
                <?php
                    $sql=Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE perfil='estudiante' ORDER BY id DESC");
                    $sql->execute();
                    foreach ($sql as $row) {
                        echo "<option value='".$row['id']."'>";
                        echo $row['nombre'];
                        echo "</option>";
                    }
                ?>
            </select> 
        </div>
        <div class="form-group mb-4" style="display: flex;">
            <div style="width: 50%;">
                <label for="exampleInputPassword1">Fecha Inicio</label><br>
                <input name="fechai" id="fechai" type="date" min="<?php echo date('Y-m-d'); ?>" > 
            </div>
            <div style="width: 50%;">
                <label for="exampleInputPassword1">Fecha Devolución</label><br>
                <input name="fechaf" id="fechaf" type="date" min="<?php echo date('Y-m-d'); ?>" > 
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="go3" class="btn btn-primary">Generar</button>
      </div>
    </div>
  </div>
</div>

<?php include_once 'includes/footer.php'?>

<script>


    $('#estudiante').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $("#modalNuevoPrestamo")
    });

  var table = $("#mytable").DataTable({
    ajax: "servidor/prestamos/listarprestamos.php"
  });

  $('#categoria').change(function(e){
           e.preventDefault();
           $("#libro").html('');
           $("#libro").append('<option value="">Seleccione Categoría</option>');
           id_cat = $('#categoria').val();
           listLibros(id_cat);
    });

    function listLibros(id_cat){

        $.post("servidor/prestamos/listarlibros.php", {id_cat:id_cat}, function(data){
	 		    var datos = JSON.parse(data);
                 console.log(datos.Code);
                if(datos.Code == 200){
                    var datx = JSON.parse(datos.data);
                    
                    $.each(datx, function(index){
                        $("#libro").append('<option value="'+datx[index].idLib+'">'+datx[index].nombre+'</option>');
                    });

                }else{
                    swal({
                    icon: "error",
                    title: datos.Message,
                    button: "Cerrar",
                    closeModal: false
                    }).then((value) => {

                    })
                }
		    
		});

    }

  $("#go3").click(function(){

    var formData = new FormData();
    formData.append('idCategoria',$("#categoria").val());
    formData.append('idLibro',$("#libro").val());
    formData.append('idEstudiante',$("#estudiante").val());
    formData.append('fechaInicio',$('#fechai').val());
    formData.append('fechaFin',$('#fechaf').val());

    $.ajax({
            url: 'servidor/prestamos/agregarprestamo.php',
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
                        window.location = "prestamos.php";
                      }
                    })
                }else{
                  swal({
                    icon: "error",
                    title: response.Message,
                    button: "Cerrar",
                    closeModal: false
                    }).then((value) => {

                    })
                }
            }
        });
  });

  table.on('click', '#prestar', function (e) {
    let data = table.row(e.target.closest('tr')).data();
    let estado = 'En curso';
    
    var formData = new FormData();
    formData.append('idPrestamo',data[0]);
    formData.append('estado',estado);

    $.ajax({
              url: 'servidor/prestamos/editarprestamo.php',
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
                          window.location = "prestamos.php";
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
                          window.location = "prestamos.php";
                        }
                      })
                  }
              }
        });

  });

  table.on('click', '#entregar', function (e) {
    let data = table.row(e.target.closest('tr')).data();
    let estado = 'Entregado';
    
    var formData = new FormData();
    formData.append('idPrestamo',data[0]);
    formData.append('estado',estado);

    $.ajax({
              url: 'servidor/prestamos/editarprestamo.php',
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
                          window.location = "prestamos.php";
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
                          window.location = "prestamos.php";
                        }
                      })
                  }
              }
        });

  });

  $("#edit").click(function(){

    var formData = new FormData();
    formData.append('idCategoria',$("#idcat").val());
    formData.append('nomCategoria',$("#editcategoria").val());
    formData.append('imagen',$('#editarfichero')[0].files[0]);

    $.ajax({
            url: 'servidor/categorias/editarcategoria.php',
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
                        window.location = "categorias.php";
                      }
                    })
                }else{
                  swal({
                    icon: "error",
                    title: response.Message,
                    button: "Cerrar",
                    closeModal: false
                    }).then((value) => {
                     
                    })
                }
            }
        });
  });

</script>
 