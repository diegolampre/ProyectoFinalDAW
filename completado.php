    <?php
    require 'administrador/config/config.php';
    require 'administrador/config/bd.php';

    $id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';

    $error = '';
    if($id_transaccion == '') {
        $error = 'Error al procesar la peticion';
    } else{
        $sentenciaSQL = $conexion->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
        $sentenciaSQL->execute([$id_transaccion, 'COMPLETED']);
        if($sentenciaSQL->fetchColumn() > 0) {

            $sentenciaSQL = $conexion->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND status=? LIMIT 1");
            $sentenciaSQL->execute([$id_transaccion, 'COMPLETED']);
            $row = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

            $idCompra = $row['id'];
            $total = $row['total'];
            $fecha = $row['fecha'];

            $sqlDet = $conexion->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
            $sqlDet->execute([$idCompra]);
        } else {
            $error = 'Error al comprobar la compra';
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

            <a href="registro.php" class="btn btn-primary ">
                Registro 
            </a>
        </nav>
        <main>
            <div class="container">
                <?php if(strlen($error) > 0) { ?>
                    <div class="row">
                        <div class="col">
                            <h3><?php echo $error; ?></h3>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="row">
                        <div class="col">
                            <b>Folio de la compra: </b><?php echo $id_transaccion; ?><br>
                            <b>Fecha de compra: </b><?php echo $fecha; ?><br>
                            <b>Total: </b><?php echo number_format($precio, 2, '.',',') . MONEDA; ?><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Producto</th>
                                        <th>Importe</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) { $importe = $row_det['precio'] * $row_det['cantidad']; ?>
                                        <tr>
                                            <td><?php echo $row_det['cantidad']; ?></td>
                                            <td><?php echo $row_det['nombre']; ?></td>
                                            <td><?php echo $importe; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
            </div>
        </main>
    </body>
</html>