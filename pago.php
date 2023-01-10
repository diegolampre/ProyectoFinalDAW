
<?php


require 'administrador/config/config.php';
require 'administrador/config/bd.php';
include 'clases/clienteFunciones.php';


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

    <div class="container">
        <br>
        <div class="row">
        </div>
    </div>

    <main>
        <div class="container">
            <div class="row">

                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <br>
                    <div id="paypal-button-container"></div>
                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <br>
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
                    <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="checkout.php" class="btn btn-primary btn-lg">Volver al carrito</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

<?php 
function quitar($cantidad){
    $sig[] = '.';
    $sig[] = ',';
    return str_replace($sig, '', $cantidad);
    }

$totalPaypal = quitar($total);
?>


    <script>
    paypal.Buttons({
        style:{
            color: 'blue',
                label: 'pay'
        },
        createOrder: function(data, actions){
            return actions.order.create({
                purchase_units: [{
                    amount:{
                        value: <?php  echo $totalPaypal?>
                    }
                }]
            });
        },

        onApprove: function(data, actions){
            let url = 'clases/captura.php'
            actions.order.capture().then(function (detalles){
                console.log(detalles)

                let url = 'clases/captura.php'

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


