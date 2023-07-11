<?php include_once 'includes/header.php'?>
<?php require_once 'conexion.php' ?>
<!-- Page Content -->
<div class="container">
    <div style="display:flex;">
        <div style="width: 50%;">
            <h1 class="mt-4 mb-4">Sub Categorías</h1>
        </div>
        <div style="width: 50%;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarSubCategoria" style="float: right;margin-top:40px;">Agregar SubCategoría</button>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
    <!-- CREAR UNA TABLA PARA MOSTRAR LOS DATOS -->
            <table class="table table-responsive table-bordered" id="mytable2">
                <thead>
                    <td>Id</td>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </thead>
                <tr>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAgregarSubCategoria" tabindex="-1" aria-labelledby="modalAgregarSubCategoria" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Sub Categoría</h5>
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
            <label for="exampleInputEmail1">Nombre</label>
            <input type="text" class="form-control" id="subcategoria" name="subcategoria" placeholder="SubCategoria">
        </div>
        <div class="form-group mb-4">
            <label for="exampleInputPassword1">Imagen</label><br>
            <input name="fichero[]" id="fichero" type="file" size="150" maxlength="150" multiple=""> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="go2" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditarSubCategoria" tabindex="-1" aria-labelledby="modalEditarSubCategoria" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar SubCategoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="form-group mb-4">
            <label for="exampleInputEmail1">Categoría</label>
            <select name="editcategoria" class="form-select" aria-label="Default select example" id="editcategoria">
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
            <input type="hidden" name="idsubcat" id="idsubcat">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="text" class="form-control" id="editsubcategoria" name="editsubcategoria" placeholder="Categoría">
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

var table2 = $("#mytable2").DataTable({
    ajax: "servidor/subcategorias/listarsubcategoria.php"
  });

  $("#go2").click(function(){

    var formData = new FormData();
    formData.append('categoria',$("#categoria").val());
    formData.append('nomSubCategoria',$("#subcategoria").val());
    formData.append('imagen',$('#fichero')[0].files[0]);

    $.ajax({
            url: 'servidor/subcategorias/agregarsubcategoria.php',
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
                        window.location = "subcategorias.php";
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
                        window.location = "subcategorias.php";
                      }
                    })
                }
            }
        });
  });

  table2.on('click', '#editsubcat', function (e) {
    let data = table2.row(e.target.closest('tr')).data();

    $('#modalEditarSubCategoria').modal('show');
    $('#editsubcategoria').val(data[1]);
    $('#editcategoria').val(data[3]);
    $('#idsubcat').val(data[0]);
  });

  table2.on('click', '#deletesubcat', function (e) {

    let data = table2.row(e.target.closest('tr')).data();

    var formData = new FormData();
    formData.append('idSubCategoria',data[0]);

    swal({
      title: "Estás seguro de eliminar la subcategoría?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $.ajax({
              url: 'servidor/subcategorias/eliminarsubcategoria.php',
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
                          window.location = "subcategorias.php";
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
                          window.location = "subcategorias.php";
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
    formData.append('idSubCategoria',$("#idsubcat").val());
    formData.append('categoria',$("#editcategoria").val());
    formData.append('nomSubCategoria',$("#editsubcategoria").val());
    formData.append('imagen',$('#editarfichero')[0].files[0]);

    $.ajax({
            url: 'servidor/subcategorias/editarsubcategoria.php',
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
                        window.location = "subcategorias.php";
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
                        window.location = "subcategorias.php";
                      }
                    })
                }
            }
        });
  });

</script>
 