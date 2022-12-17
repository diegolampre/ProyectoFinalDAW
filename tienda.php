
<?php include ("administrador/config/bd.php"); 
    $sentenciaSQL = $conexion->prepare("SELECT * FROM videojuegos");
    $sentenciaSQL->execute();
    $listaVideojuegos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("administrador/config/config.php")  ?>
<?php


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

    <div class="container">
        <br><br>
        <div class="row">
<?php foreach($listaVideojuegos as $videojuego) { ?>

    
<div class="col-md-3">

    <div class="card">

    <img style="width: 307px; height: 400px; " class="card-img-top" src="./img/<?php echo $videojuego['imagen'];?>" alt="">
    <div class="card-body">
        <h4 style="font-size:" class="card-title"> <?php echo $videojuego['nombre'];?> </h4>
        <h5><?php echo $videojuego['precio'];?>€</h5>
        <!-- Cifrado de la informacion -->
        <a name="" id="" class="btn btn-primary" href="detalles.php?id=<?php echo $videojuego['id']; ?>&token=<?php echo hash_hmac('sha1', $videojuego['id'], KEY_TOKEN); ?>" role="button">Detalles</a>
        
    </div>
    </div>
</div>

<?php } ?>


<?php include("template/pie.php") ?>