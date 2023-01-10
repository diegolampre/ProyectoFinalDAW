
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

        $token = generaToken();
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $id = registraUsuario([$usuario, $pass_hash, $token, $id], $conexion);
        $errors[] = "Usuario registrado";

        //No me funciona la validacion del usuario a traves de correo 
        /*
        if ($id > 0) {

            require 'clases/mailer.php';
            $mailer = new Mailer();
            $token = generaToken();
            $url = SITE_URL . 'activa_cliente.php?id=' . $id . '&token=' . $token;
            $asunto = "Activar cuenta - PropaGames";
            $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro es indispensable de click en el siguiente link <a href='$url'>Activar cuenta</a>";

            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            if (!registraUsuario([$usuario, $pass_hash, $token, $id], $conexion)) {

                if($mailer->enviarEmail($email, $asunto, $cuerpo)){
                    echo "Para terminar el proceso de registro siga la sinstrucciones que le hemos enviado a la direccion de correo electronico $email";

                    exit;
                } 
            } else {
                $errors[] = "Error al registrar cliente";
            }
        } else {
            $errors[] = "Error al registrar cliente";
        }
        */
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
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

<header>
        <h1 style="text-align: center; font-size: 70px;" class="titulo">PropaGames</h3>

        <div class="navbar navbar-expand-lg  background-color: transparent ">
            <div class="container"> <!-- puedo borrar container y se pondra mas grande -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader"> <!-- collapse navbar-collapse-->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"> <!-- nav-pills nav-fill navbar-nav me-auto mb-2 mb-lg-0 -->
                        <li class="nav-item " style="margin-right: 100px; ">
                            <a class="nav-link text-light" style="font-size: 30px; " href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item" style="margin-right: 100px">
                            <a class="nav-link text-light" style="font-size: 30px;" href="tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item" style="margin-right: 100px">
                            <a class="nav-link active text-light" style="font-size: 30px;" href="nosotros.php">Nosotros</a>
                        </li>
                        <li class="nav-item" style="margin-right: 100px">
                            <a class="nav-link text-light" style="font-size: 30px;" href="contacto.php">Contacto</a>
                        </li>
                    </ul>

                    <a href="registro.php" class="btn btn-primary " style="margin: 2px ; ">
                        Registro 
                    </a>
                    <?php if(isset($_SESSION['user_id'])){ ?>
                        <a href="" class="btn btn-primary " style="margin: 2px ;">
                            <?php echo $_SESSION['user_name']; ?>
                        </a>
                    <?php } else {?>
                        <a href="login.php" class="btn btn-primary " style="margin: 2px ;">
                            Ingresar
                        </a>
                    <?php } ?>

                    <a href="checkout.php" class="btn btn-primary" style="margin: 2px; ">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>


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
                    <span id="validaEmail" class="text-danger"></span>
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
                    <span id="validaUsuario" class="text-danger"></span>
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


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <script>
        let txtUsuario = document.getElementById('usuario')
        txtUsuario.addEventListener("blur", function(){
            existeUsuario(txtUsuario.value)
        }, false)

        let txtEmail = document.getElementById('email')
        txtEmail.addEventListener("blur", function(){
            existeEmail(txtEmail.value)
        }, false)
        
        function existeUsuario(usuario){

            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeUsuario")
            formData.append("usuario", usuario)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    document.getElementById('usuario').value = ''
                    document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
                } else {

                    document.getElementById('validaUsuario').innerHTML = ''
                }
            })
        }


        function existeEmail(email){

            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeEmail")
            formData.append("email", email)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    document.getElementById('email').value = ''
                    document.getElementById('validaEmail').innerHTML = 'Correo no disponible'
                } else {

                    document.getElementById('validaEmail').innerHTML = ''
                }
            })
        }
    </script>


<?php include("template/pie.php") ?>