
<?php include ("administrador/config/bd.php"); 
    $sentenciaSQL = $conexion->prepare("SELECT * FROM videojuegos");
    $sentenciaSQL->execute();
    $listaVideojuegos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("administrador/config/config.php")  ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
if ($id == '' || $token == ''){
    echo 'Error al procesar la peticion, vuelve al inicio';
    exit;
}else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){
        $sentenciaSQL = $conexion->prepare("SELECT count(id) FROM videojuegos WHERE id=?");
        $sentenciaSQL->execute([$id]);
        if($sentenciaSQL->fetchColumn() > 0) {
            $sentenciaSQL = $conexion->prepare("SELECT nombre, categoria, descripcion, precio, descuento, imagen FROM videojuegos WHERE id=?");
            $sentenciaSQL->execute([$id]);
            $row = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $categoria = $row['categoria'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $imagen = $row['imagen'];
        }
    }else {
        echo 'Error al procesar la peticion, vuelve al inicio';
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

    <div class="container">
        <br><br>
        <div class="row">



<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">
                <img src="img/<?php echo $imagen;?>" alt="">
            </div>
            <div class="col-md-6 order-md-2">
                <h1><?php echo $nombre; ?></h1>

                <?php if($descuento > 0) { ?>
                    <h2 style="display:inline">
                        <?php echo number_format($precio_desc, 2, '.',','). MONEDA ;?>
                    </h2>
                    <p style="display:inline"><del><?php echo number_format($precio, 2, '.',',') . MONEDA ?></del></p>
                    <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                    <?php } else { ?>    
                            <h2><?php echo number_format($precio, 2, '.',',') . MONEDA ?></h2>
                    <?php } ?>
                    </br>
                    <h3><?php echo $categoria; ?></h3>
                <p class="lead">
                <?php echo $descripcion; ?>
                </p>
                <div class="d-grid gap-3 col-10 mx-auto">
                    <button class="btn btn-primary" type="button">Comprar ahora</button>
                    <button class="btn btn-primary" type="button" onclick="addProducto(<?php echo $id ?>, '<?php echo $token_tmp?>')">Añadir al carrito</button> <!--duda -->
                </div>
            </div>
        </div>
    </div>
</main>
</div>
    </div>

</body>
</html>




<!-- SCRIPTS -->

<script>
    function addProducto(id,token){
        let url= 'clases/carrito.php';
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data => {
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>