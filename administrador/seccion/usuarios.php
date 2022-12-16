<?php include("../template/cabecera.php"); ?>
<?php
//print_r($_POST);
//print_r($_FILES);
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtUsuario=(isset($_POST['txtUsuario']))?$_POST['txtUsuario']:"";
$txtCorreoelectronico=(isset($_POST['txtcorreoelectronico']))?$_POST['txtcorreoelectronico']:"";
$txtContraseña=(isset($_POST['txtContraseña']))?$_POST['txtContraseña']:"";
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
        //INSERT INTO `usuarios` (`id`, `usuario`, `correoelectronico`, `contraseña`) VALUES (NULL, 'juan2412', 'juan@gmail.com', 'juan12');
        $sentenciaSQL= $conexion->prepare("INSERT INTO usuarios (usuario, correoelectronico, contraseña) VALUES (:usuario,:correoelectronico,:contraseña);");
        $sentenciaSQL->bindParam(':usuario',$txtUsuario);
        $sentenciaSQL->bindParam(':correoelectronico',$txtCorreoelectronico);
        $sentenciaSQL->bindParam(':contraseña',$txtContraseña);
        $sentenciaSQL->execute();
        //echo "Presionado boton agregar";
        break;
    case "Modificar";
        //usuario
        $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET usuario=:usuario WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->bindParam(':usuario',$txtUsuario);
        $sentenciaSQL->execute();

        //correo electronico
        $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET correoelectronico=:correoelectronico WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->bindParam(':correoelectronico',$txtCorreoelectronico);
        $sentenciaSQL->execute();

        //contraseña
        $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET contraseña=:contraseña WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->bindParam(':contraseña',$txtContraseña);
        $sentenciaSQL->execute();

        //echo "Presionado boton modificar";
        break;

    case "Cancelar";
        //echo "Presionado boton cancelar";
        break;

    case "Seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $usuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        //$txtID = $videojuego['id'];
        $txtUsuario = $usuario['usuario'];
        $txtCorreoelectronico = $usuario['correoelectronico'];
        $txtContraseña = $usuario['contraseña'];

        //echo "Presionado boton Seleccionar";
        break;

    case "Borrar";
        $sentenciaSQL = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        //echo "Presionado boton Borrar";
        break;
    
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios");
$sentenciaSQL->execute();
$listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de usuarios
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">

            <div class = "form-group" enctype="multipart/form-data">
                <label for="txtID">ID:</label>
                <input type="text" class="form-control" <?php echo $txtID;?> name="txtID" id="txtID"  placeholder="ID">
            </div>

            <div class = "form-group">
                <label for="txtUsuario">Usuario:</label>
                <input type="text" class="form-control" value="<?php echo $txtUsuario;?>" name="txtUsuario" id="txtUsuario"  placeholder="Usuario">
            </div>

            <div class = "form-group">
                <label for="txtCorreoelectronico">Correo Electronico:</label>
                <input type="text" class="form-control" value="<?php echo $txtCorreoelectronico;?>" name="txtCorreoelectronico" id="txtCorreoelectronico"  placeholder="Correo electronico">
            </div>

            <div class = "form-group">
                <label for="txtContraseña">Contraseña:</label>
                <input type="text" class="form-control" value="<?php echo $txtContraseña;?>" name="txtContraseña" id="txtContraseña"  placeholder="Contraseña">
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
                <th>Correo electronico</th>
                <th>Contraseña</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($listaUsuarios as $usuario) { ?>
            <tr>
                <td><?php echo $usuario['id'];?></td>
                <td><?php echo $usuario['usuario'];?></td>
                <td><?php echo $usuario['correoelectronico'];?></td>
                <td><?php echo $usuario['contraseña'];?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $usuario['id']; ?>"/>

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