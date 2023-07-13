<?php include_once 'includes/header.php'?>
<?php require_once 'conexion.php' ?>
<!-- Page Content -->
<div class="container">
    <div style="display:flex;">
        <div style="width: 50%;">
            <h1 class="mt-4 mb-4">Usuarios</h1>
        </div>
        <div style="width: 50%;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario" style="float: right;margin-top:40px;">Agregar Usuario</button>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
    <!-- CREAR UNA TABLA PARA MOSTRAR LOS DATOS -->
            <table class="table table-responsive table-bordered" id="mytable4">
                <thead>
                    <td>Id</td>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Perfil</th>
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
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoPrestamo" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group mb-4" >
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group mb-4" >
            <label for="exampleInputEmail1">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group mb-4" >
            <label for="exampleInputEmail1">Perfil</label>
            <select name="rol" class="form-select" id="rol">
                <option value="administrador">Administrador</option>
                <option value="estudiante">Estudiante</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="go5" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuario" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="hidden" name="iduser" id="iduser">
            <input type="text" class="form-control" id="editnombre" name="editnombre">
        </div>
        <div class="form-group mb-4" >
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" id="editemail" name="editemail">
        </div>
        <div class="form-group mb-4" >
            <label for="exampleInputEmail1">Contraseña</label>
            <input type="password" class="form-control" id="editpassword" name="editpassword">
        </div>
        <div class="form-group mb-4" >
            <label for="exampleInputEmail1">Perfil</label>
            <select name="editrol" class="form-select" id="editrol">
                <option value="administrador">Administrador</option>
                <option value="estudiante">Estudiante</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="edit" class="btn btn-primary">Editar</button>
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

  var table = $("#mytable4").DataTable({
    ajax: "servidor/usuarios/listarusuarios.php"
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

  $("#go5").click(function(){

    var formData = new FormData();
    formData.append('nombre',$("#nombre").val());
    formData.append('email',$("#email").val());
    formData.append('password',$("#password").val());
    formData.append('rol',$('#rol').val());

    $.ajax({
            url: 'servidor/usuarios/agregarusuario.php',
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
                        window.location = "usuarios.php";
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

  table.on('click', '#editcat', function (e) {
    let data = table.row(e.target.closest('tr')).data();

    $('#modalEditarUsuario').modal('show');
    $('#iduser').val(data[0]);
    $('#editnombre').val(data[1]);
    $('#editemail').val(data[2]);
    $('#editperfil').val(data[3]);
    
  });

  table.on('click', '#deletecat', function (e) {

    let data = table.row(e.target.closest('tr')).data();

    var formData = new FormData();
    formData.append('idUsuario',data[0]);

    swal({
      title: "Estás seguro de eliminar el usuario?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $.ajax({
              url: 'servidor/usuarios/eliminarusuario.php',
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
                          window.location = "usuarios.php";
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
                          window.location = "categorias.php";
                        }
                      })
                  }
              }
        });
      } else {
        
      }
    });

});

  table.on('click', '#suspender', function (e) {
    let data = table.row(e.target.closest('tr')).data();
    let estado = 0;
    
    var formData = new FormData();
    formData.append('idUser',data[0]);
    formData.append('estado',estado);

    $.ajax({
              url: 'servidor/usuarios/editarestado.php',
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
                          window.location = "usuarios.php";
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
                          window.location = "usuarios.php";
                        }
                      })
                  }
              }
        });

  });

  table.on('click', '#activar', function (e) {
    let data = table.row(e.target.closest('tr')).data();
    let estado = 1;
    
    var formData = new FormData();
    formData.append('idUser',data[0]);
    formData.append('estado',estado);

    $.ajax({
              url: 'servidor/usuarios/editarestado.php',
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
                          window.location = "usuarios.php";
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
                          window.location = "usuarios.php";
                        }
                      })
                  }
              }
        });

  });


  $("#edit").click(function(){

    var formData = new FormData();
    formData.append('iduser',$("#iduser").val());
    formData.append('editnombre',$("#editnombre").val());
    formData.append('editemail',$('#editemail').val());
    formData.append('editpassword',$('#editpassword').val());
    formData.append('editrol',$('#editrol').val());

    $.ajax({
            url: 'servidor/usuarios/editarusuario.php',
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
                        window.location = "usuarios.php";
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
 