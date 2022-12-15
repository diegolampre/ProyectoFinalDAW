<?php include("../template/cabecera.php"); ?>
<?php
//print_r($_POST);
//print_r($_FILES);
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtCantidad=(isset($_POST['txtCantidad']))?$_POST['txtCantidad']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

echo $txtID. "<br/>";
echo $txtNombre. "<br/>";
echo $txtCantidad. "<br/>";
echo $txtPrecio. "<br/>";
echo $txtImagen. "<br/>";
echo $accion. "<br/>";
?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de videojuegos
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">

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
                <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
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