<?php include("../template/cabecera.php"); ?>
<?php
//print_r($_POST);
//print_r($_FILES);
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtUsuario=(isset($_POST['txtUsuario']))?$_POST['txtUsuario']:"";
$txtCorreoelectronico=(isset($_POST['txtcorreoelectronico']))?$_POST['txtcorreoelectronico']:"";
$txtPassword=(isset($_POST['txtPassword']))?$_POST['txtPassword']:"";
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
        $sentenciaSQL= $conexion->prepare("INSERT INTO usuarios (usuario, password) VALUES (:usuario,:password);");
        $sentenciaSQL->bindParam(':usuario',$txtUsuario);
        $sentenciaSQL->bindParam(':password',$txtPassword);
        $sentenciaSQL->execute();
        //echo "Presionado boton agregar";
        break;
    case "Modificar";
        //usuario

        $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET usuario=:usuario WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->bindParam(':usuario',$txtUsuario);
        $sentenciaSQL->execute();


        //password
        $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET password=:password WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->bindParam(':password',$txtPassword);
        $sentenciaSQL->execute();

        //echo "Presionado boton modificar";
        break;

    case "Cancelar";
        //echo "Presionado boton cancelar";
        header("Location:usuarios.php");
        break;

    case "Seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $usuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        //$txtID = $videojuego['id'];
        $txtUsuario = $usuario['usuario'];
        $txtPassword = $usuario['password'];

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
                <label for="txtPassword">password:</label>
                <input type="text" class="form-control" value="<?php echo $txtPassword;?>" name="txtPassword" id="txPassword"  placeholder="Contraseña">
            </div>

            <div class="btn-group" role="group" aria-label="">
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
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($listaUsuarios as $usuario) { ?>
            <tr>
                <td><?php echo $usuario['id'];?></td>
                <td><?php echo $usuario['usuario'];?></td>
                <td><?php echo $usuario['password'];?></td>
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