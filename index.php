<?php include ("administrador/config/bd.php"); 
    $sentenciaSQL = $conexion->prepare("SELECT id, nombre, precio, imagen FROM videojuegos WHERE activo=1");
    $sentenciaSQL->execute();
    $listaVideojuegos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("administrador/config/config.php")  ?>

<?php 

$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtDescuento=(isset($_POST['txtDescuento']))?$_POST['txtDescuento']:"";



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

    <div class="container">
<br>
        <div class="row">


<img src="" alt="">

            <div class="jumbotron">
                <h1 class="display-3">Novedades</h1>

            </div>

            </div>
    </div>


    
    <main>
        <div class="container">
            <br>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4  g-4">
            <?php foreach($listaVideojuegos as $videojuego) { ?> 
                <div class="col"> <!-- col -->
                    <div class="card ">
                        <a href="detalles.php?id=<?php echo $videojuego['id']; ?>&token=<?php echo hash_hmac('sha1', $videojuego['id'], KEY_TOKEN); ?>">
                        <img  class="card-img-top" src="./img/<?php echo $videojuego['imagen'];?>" alt=""> <!-- imagen --> 
                        </a>
                        <div class="card-body">
                            <h4 style="font-size:" class="card-title"> <?php echo $videojuego['nombre'];?> </h4>

                        </div>
                    </div>
                </div>


        <?php } ?>

    </main>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>


</body>
</html>