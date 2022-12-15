<?php include("../template/cabecera.php"); ?>
<?php
//print_r($_POST);
//print_r($_FILES);
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtCategoria=(isset($_POST['txtCategoria']))?$_POST['txtCategoria']:"";
$txtDescripcion=(isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

//echo $txtID. "<br/>";
//echo $txtNombre. "<br/>";
//echo $txtDescripcion. "<br/>";
//echo $txtCategoria. "<br/>";
//echo $txtPrecio. "<br/>";
//echo $txtImagen. "<br/>";
//echo $accion. "<br/>";

include("../config/bd.php"); 

switch($accion){
    case "Agregar";
        //$sentenciaSQL= $conexion->prepare("INSERT INTO `videojuegos` (`id`, `nombre`, `categoria`, `descripcion`, `precio`, `imagen`) VALUES (NULL, 'Cyberpunk 2077', 'Accion', 'ompra Cyberpunk 2077 key y sumérgete en un mundo abierto donde serás capaz de explorar Night City: una enorme, distópica metrópolis, donde todos están obsesionados con tecnología sci-fi y modificación corporales. Esta experiencia RPG de CD Project RED te dará los controles de V, una absoluta bestia humana, quién (como muchos otros) está obsesionado con adquirir un implante en especial, uno que otorga inmortalidad.', '34.99', 'imagen.jpg');");
        $sentenciaSQL= $conexion->prepare("INSERT INTO videojuegos (nombre, categoria, descripcion, precio, imagen) VALUES (:nombre,:categoria,:descripcion,:precio,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':categoria',$txtCategoria);
        $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':imagen',$txtImagen);
        $sentenciaSQL->execute();
        //echo "Presionado boton agregar";
        break;
    case "Modificar";
        echo "Presionado boton modificar";
        break;

    case "Cancelar";
        echo "Presionado boton cancelar";
        break;

    case "Seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT * FROM videojuegos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $videojuego=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $videojuego['nombre'];
        $txtCategoria = $videojuego['categoria'];
        $txtDescripcion = $videojuego['descripcion'];
        $txtPrecio = $videojuego['precio'];
        $txtImagen = $videojuego['imagen'];

        //echo "Presionado boton Seleccionar";
        break;

    case "Borrar";
        $sentenciaSQL = $conexion->prepare("DELETE FROM videojuegos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        //echo "Presionado boton Borrar";
        break;
    
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM videojuegos");
$sentenciaSQL->execute();
$listaVideojuegos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

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
                <input type="text" class="form-control" <?php echo $txtID;?> name="txtID" id="txtID"  placeholder="ID">
            </div>

            <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre"  placeholder="Nombre del videojuego">
            </div>

            <div class = "form-group">
                <label for="txtCategoria">Categoria:</label>
                <input type="text" class="form-control" value="<?php echo $txtCategoria;?>" name="txtCategoria" id="txtCategoria"  placeholder="Categoria del producto">
            </div>

            <div class = "form-group">
                <label for="txtDescripcion">Descripcion:</label>
                <input type="text" class="form-control" value="<?php echo $txtDescripcion;?>" name="txtDescripcion" id="txtDescripcion"  placeholder="Descripcion del producto">
            </div>

            <div class = "form-group">
                <label for="txtPrecio">Precio:</label>
                <input type="text" class="form-control" value="<?php echo $txtPrecio;?>" name="txtPrecio" id="txtPrecio"  placeholder="Precio del producto">
            </div>

            <div class = "form-group">
                <label for="txtImagen">Imagen;</label>

                <?php echo $txtImagen;?>
                
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
                <th>Categoria</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($listaVideojuegos as $videojuego) { ?>
            <tr>
                <td><?php echo $videojuego['id'];?></td>
                <td><?php echo $videojuego['nombre'];?></td>
                <td><?php echo $videojuego['categoria'];?></td>
                <td><?php echo $videojuego['descripcion'];?></td>
                <td><?php echo $videojuego['precio'];?></td>
                <td><?php echo $videojuego['imagen'];?></td>


                <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $videojuego['id']; ?>"/>

                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                    </form>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?>