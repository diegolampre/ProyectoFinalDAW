<?php include("administrador/config/config.php")  ?>
<?php include ("administrador/config/bd.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropaGames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estilos.css">
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
                        <li class="nav-item " style="margin-right: 147px; ">
                            <a class="nav-link text-light" style="font-size: 30px; " href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item" style="margin-right: 147px">
                            <a class="nav-link text-light" style="font-size: 30px;" href="tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item" style="margin-right: 147px">
                            <a class="nav-link active text-light" style="font-size: 30px;" href="nosotros.php">Nosotros</a>
                        </li>
                        <li class="nav-item" style="margin-right: 147px">
                            <a class="nav-link text-light" style="font-size: 30px;" href="contacto.php">Contacto</a>
                        </li>
                    </ul>

                    <a href="checkout.php" class="btn btn-primary" style="margin: 2px">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>

                    <a href="registro.php" class="btn btn-primary " style="margin: 2px 0px 2px 4px">
                        Registro 
                    </a>
                </div>
            </div>
        </div>
    </header>


    <div class="container">
        <br>
        <div class="row">
            <div class="jumbotron">
                <h1 class="display-3">Contacto</h1>
                <p class="lead">A traves de este apartado podras contactar con el servicio al cliente.</p>
            </div>
        </div>
    </div>

    <main class="container">
    <form class="formulario" >

        <h3 class=" mb-3 fw-normal item">Formulario de contacto</h3>

        <div class="form-group">
            <h5 for="floatingInput">Nombre <span>*</span></h5>
            <input type="text" class="form-control " id="floatingInput" placeholder="Nombre" required> 
            <br>

            <h5 for="floatingInput">Correo Electronico <span>*</span></h5>
            <input type="email" class="form-control" id="floatingInput" placeholder="Correo electronico" required> 
            <br>

            <h5 for="floatingInput">Mensaje <span>*</span></h5>
            <textarea class="form-control" name="" id="" rows="3"></textarea>
            <br>

            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
            <label class="form-check-label" for="flexCheckDefault">Aceptar Politica de Privacidad</label>
        </div>

        <div class="">

        </div>
        <br>



        <button class=" btn btn-lg btn-primary item" type="submit">Enviar</button>
</form>


    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>


</body>
</html>