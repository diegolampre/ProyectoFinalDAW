
<?php include("administrador/config/config.php")  ?>
<?php include("administrador/config/bd.php");



$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad)  {

        $sentenciaSQL = $conexion->prepare("SELECT id, nombre, precio, $cantidad AS cantidad  FROM videojuegos WHERE id=? " );
        $sentenciaSQL->execute([$clave]);
        $lista_carrito[]=$sentenciaSQL->fetch(PDO::FETCH_ASSOC);
    }
}


?>

<?php
print_r($_SESSION);

//print_r($_SESSION);
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($lista_carrito == null){
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia <b/></td></tr>';
                        } else{
                            $total = 0;
                            foreach($lista_carrito as $producto){
                                $_id = $producto['id'];
                                $nombre = $producto['nombre'];
                                $precio = $producto['precio'];
                                $cantidad = $producto['cantidad'];
                                $subtotal = $cantidad * $precio;
                                $total += $subtotal;
                        ?>

                        <tr>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $precio ?>€</td>
                            <td>
                                <input type="number" min="1" max="10" step="1" value="<?php $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $precio ?>€</div>
                            </td>
                            <td>
                                <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id;?>" data-ds-toogle="modal" data-bs-target="eliminaModal">Eliminar</a>
                            </td>
                        </tr>
                        <?php  } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3" id="total"><?php $total?> </p>
                            </td>
                        </tr>
                    </tbody>
                    <?php  } ?>
                </table>
            </div>
        
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <button class="btn btn-primary btn-lg">Realizar Pago </button>
                </div>
            </div>
        </div>
    </main>
    <div class="container">
        <br><br>
        <div class="row">
        </div>
    </div>
</body>
</html>