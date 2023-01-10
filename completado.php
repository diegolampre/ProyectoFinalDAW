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
                            <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="index.php" class="btn btn-primary btn-lg">Volver al Inicio</a>
                    </div>
                        </div>
                    </div>
                    <?php } ?>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    </body>
</html>