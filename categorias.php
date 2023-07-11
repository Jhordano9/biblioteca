<?php include_once 'includes/header.php'?>

<!-- Page Content -->
<div class="container">
    <div style="display:flex;">
        <div style="width: 50%;">
            <h1 class="mt-4 mb-4">Categorías</h1>
        </div>
        <div style="width: 50%;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria" style="float: right;margin-top:40px;">Agregar Categoría</button>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
    <!-- CREAR UNA TABLA PARA MOSTRAR LOS DATOS -->
            <table class="table table-responsive table-bordered" id="mytable">
                <thead>
                    <td>Id</td>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </thead>
                <tr>
                    <td>0</td>
                    <td>Agustin</td>
                    <td>123</td>
                    <td><button>Eliminar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAgregarCategoria" tabindex="-1" aria-labelledby="modalAgregarCategoria" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Categoría">
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputPassword1">Imagen</label><br>
            <input name="fichero[]" id="fichero" type="file" size="150" maxlength="150" multiple=""> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="go" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoria" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
            <input type="hidden" name="idcat" id="idcat">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="text" class="form-control" id="editcategoria" name="editcategoria" placeholder="Categoría">
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputPassword1">Imagen</label><br>
            <input name="editarfichero[]" id="editarfichero" type="file" size="150" maxlength="150" multiple=""> 
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


  var table = $("#mytable").DataTable({
    ajax: "servidor/categorias/listarcategorias.php"
  });

  $("#go").click(function(){

    var formData = new FormData();
    formData.append('nomCategoria',$("#categoria").val());
    formData.append('imagen',$('#fichero')[0].files[0]);

    $.ajax({
            url: 'servidor/categorias/agregarcategoria.php',
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
                      if(value){
                        window.location = "categorias.php";
                      }
                    })
                }
            }
        });
  });

  table.on('click', '#editcat', function (e) {
    let data = table.row(e.target.closest('tr')).data();

    $('#modalEditarCategoria').modal('show');
    $('#editcategoria').val(data[1]);
    $('#idcat').val(data[0]);
  });

  table.on('click', '#deletecat', function (e) {

    let data = table.row(e.target.closest('tr')).data();

    var formData = new FormData();
    formData.append('idCategoria',data[0]);

    swal({
      title: "Estás seguro de eliminar la categoría?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $.ajax({
              url: 'servidor/categorias/eliminarcategoria.php',
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
                      if(value){
                        window.location = "categorias.php";
                      }
                    })
                }
            }
        });
  });

</script>
 