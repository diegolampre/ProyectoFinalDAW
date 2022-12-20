
<?php


require 'administrador/config/config.php';
require 'administrador/config/bd.php';


$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad)  {

        $sentenciaSQL = $conexion->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad  FROM videojuegos WHERE id=?  AND activo=1 "); // AND activo=1
        $sentenciaSQL->execute([$clave]);
        $lista_carrito[]=$sentenciaSQL->fetch(PDO::FETCH_ASSOC);
    }
}else {
    header("Location: index.php ");
    exit;
}
?>

<?php


//print_r($_SESSION);

//session_destroy();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropaGames</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
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
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
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
                                        $_id = $producto['id'] ;
                                        $nombre = $producto['nombre'] ;
                                        $precio = $producto['precio'] ;
                                        $descuento = $producto['descuento'] ;
                                        $cantidad = $producto['cantidad'] ;
                                        $precio_desc = $precio - (($precio * $descuento)/100) ;
                                        $subtotal = $cantidad * $precio_desc ;
                                        $total += $subtotal ;
                                ?>

                                <tr>
                                    <td><?php echo $nombre ?></td>

                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo number_format($subtotal, 2, ',',',') . MONEDA   ?></div>
                                    </td>

                                </tr>
                                <?php  } ?>
                                <tr>

                                    <td colspan="2">
                                        <p class="h3 text-end" id="total"> <?php echo number_format($total, 2, ',',',') . MONEDA  ?>  </p>
                                    </td>
                                </tr>
                            </tbody>
                            <?php  } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </main>



    <div class="container">
        <br><br>
        <div class="row">
        </div>
    </div>


    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

    <script>
    paypal.Buttons({
        style:{
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions){
            return actions.order.create({
                purchase_units: [{
                    amount:{
                        value: <?php echo $total; ?>
                    }
                }]
            });
        },

        onApprove: function(data, actions){
            let URL = 'clases/captura.php'
            actions.order.capture().then(function (detalles){
                console.log(detalles)
                let URL = 'clases/captura.php'
                return fetch(url,{
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        detalles: detalles
                    })
                })
                
            });
        },

        onCancel: function(data){
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
</script>

</body>
</html>


