
<?php 
include ("administrador/config/bd.php");
include("administrador/config/config.php");
include("clases/clienteFunciones.php");




$errors = [];

if(!empty($_POST)){

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']); 
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword])){
        $errors = "Debe completar todos los campos que contengan * ";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es valida";
    }

    if(!validaPassword($password, $repassword)){
        $errors[] = "Las contraseña no coinciden";
    }

    if(usuarioExiste($usuario, $conexion)){
        $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if(emailExiste($email, $conexion)){
        $errors[] = "El correo electronico $email ya esta vinculado a otro usuario";
    }

    if (count($errors) == 0) {

        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $conexion);

        if ($id > 0) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $token = generaToken();
            if (!registraUsuario([$usuario, $pass_hash, $token, $id], $conexion)) {
                $errors[] = "Error al registrar cliente";
            }
        } else {
            $errors[] = "Error al registrar cliente";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropaGames</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        @font-face {
            font-family:letra; 
            src: url(../fuentes/Oswald/Oswald.ttf)
        }

        a{
            font-size: 30px;
        } 
    </style>
</head>
<body>


    <h1 style="text-align: center; font-size: 70px;" class="titulo">PropaGames</h3>


    <nav class=" navbar-expand-lg   justify-content-center background-color: transparent">
        <!--background-color: transparent !important -->
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link text-light" style="font-size: 30px; " href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" style="font-size: 30px;" href="tienda.php">Tienda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" style="font-size: 30px;" href="nosotros.php">Nosotros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" style="font-size: 30px;" href="contacto.php">Contacto</a>
            </li>
        </ul>
    
        <a href="checkout.php" class="btn btn-primary">
            Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
    </nav>


    <main>
        <div class="container">
            <h2>Datos del cliente</h2>

            <?php mostrarMensajes($errors); ?>

            <form class="row g-3" action="registro.php" method= "post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger">*</span> Nombre</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span> Correo Electronico</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger">*</span> Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="dni"><span class="text-danger">*</span> DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span> Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="repassword"><span class="text-danger">*</span> Repetir contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>
                <i><b>Nota:</b> Los campos con asterisco (*) son obligatorios</i>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </main>



<?php include("template/pie.php") ?>