<?php include("../template/cabecera.php"); ?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de videojuegos
        </div>
        <div class="card-body">
        <form method="POST">

            <div class = "form-group" enctype="multipart/form-data">
                <label for="txtID">ID:</label>
                <input type="text" class="form-control" name="txtID" id="txtID"  placeholder="ID">
            </div>

            <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre"  placeholder="Nombre del videojuego">
            </div>

            <div class = "form-group">
                <label for="txtCantidad">Cantidad:</label>
                <input type="text" class="form-control" name="txtCantidad" id="txtCantidad"  placeholder="Cantidad del producto">
            </div>

            <div class = "form-group">
                <label for="txtPrecio">Precio:</label>
                <input type="text" class="form-control" name="txtPrecio" id="txtPrecio"  placeholder="Precio del producto">
            </div>

            <div class = "form-group">
                <label for="txtImagen">Imagen;</label>
                <input type="file" class="form-control" name="txtImagen" id="txtImagen">
            </div>

            <div class="btn-group" role="group" aria-label="">
                <button type="button" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-warning">Modificar</button>
                <button type="button" class="btn btn-info">Cancelar</button>
            </div>

        </form>
        </div>

    </div>
    


</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Imagen</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>

            <tr>
                <td>1</td>
                <td>high on life</td>
                <td>40€</td>
                <td>1</td>
                <td>hihgonlife.jpg</td>
                <td>Seleccionar | Borrar</td>
            </tr>

        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?>