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
                </thead>
                <tr>
                    <td>0</td>
                    <td>Agustin</td>
                    <td>123</td>
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
        <div class="form-group">
            <label for="exampleInputEmail1">Nombre</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Imagen</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>

<?php include_once 'includes/footer.php'?>
 