
<?php include("administrador/config/config.php")  ?>
<?php include ("administrador/config/bd.php"); ?>

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

    <div class="container">
        <br><br>
        <div class="row">


<img src="" alt="">

            <div class="jumbotron">
                <h1 class="display-3">Jumbo heading</h1>
                <p class="lead">Jumbo helper text</p>
                <hr class="my-2">
                <p>More info</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
                </p>
            </div>

            </div>
    </div>

</body>
</html>