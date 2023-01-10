
<?php
//Conexion base de datos
require 'administrador/config/config.php';
require 'administrador/config/bd.php';


$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();
//Muestra productos
if($productos != null){
    foreach($productos as $clave => $cantidad)  {

        $sentenciaSQL = $conexion->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad  FROM videojuegos WHERE id=?  AND activo=1 "); // AND activo=1
        $sentenciaSQL->execute([$clave]);
        $lista_carrito[]=$sentenciaSQL->fetch(PDO::FETCH_ASSOC);
    }
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
        <div class="row">
    <div class="jumbotron">
        <h1 class="display-3">Carrito</h1>
        <br>
    </div>

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
                            <td><?php echo number_format($precio_desc, 2, ',',',') . MONEDA  ?></td>
                            <td>
                                <input type="number" min="1" max="10" step="1"   value="<?php  echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo number_format($subtotal, 2, ',',',') . MONEDA   ?></div>
                            </td>
                            <td>
                                <a  id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id;?>" data-bs-toggle="modal" data-bs-target="#eliminaModal" >Eliminar</a>
                            </td>
                        </tr>
                        <?php  } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3" id="total"> <?php echo number_format($total, 2, ',',',') . MONEDA  ?>  </p>
                            </td>
                        </tr>
                    </tbody>
                    <?php  } ?>
                </table>
            </div>
            <?php if ($lista_carrito != null){ ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="pago.php" class="btn btn-primary btn-lg">Realizar Pago</a>
                </div>
            </div>
            <?php } ?>

        </div>
    </main>

        <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ¿Desea eliminar el producto de la lista?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
        </div>
        </div>
    </div>
    </div>

    <div class="container">
        <br><br>
        <div class="row">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</body>
</html>


<script>
    buttonElimina = "";

    let eliminaModal = document.getElementById('eliminaModal')
    eliminaModal.addEventListener('show.bs.modal', function(event){
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        let buttonElimina = eliminaModal.querySelector('.modal-footer #btn.elimina')
        buttonElimina.value = id;
    })

 //Actualizar cantidad del producto, mostrando sumatorios
    function actualizaCantidad(cantidad,id){
        let url= 'clases/actualizar_carrito.php';
        let formData = new FormData()
        formData.append('action', 'agregar')  
        formData.append('id', id)  
        formData.append('cantidad', cantidad)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data => {
            if(data.ok){

                let divsubtotal = document.getElementById('subtotal_' + id)
                divsubtotal.innerHTML = data.sub

                let total = 0.00
                let list = document.getElementsByName('subtotal[]')

                for(let i = 0; i < list.length; i++){
                    total += parseFloat(list[i].innerHTML.replace(/[$,]/g,  ''))
                }

                total = new Intl.NumberFormat('es', {
                    minimumFractionDigits: 2
                }).format(total)
                document.getElementById('total').innerHTML =  '< ?php echo MONEDA;?>' + total

            }
        })
    }


    //Eliminar productos del carrito
    function eliminar(){
        let botonElimina = document.getElementById('btn-elimina')
        let id = botonElimina.value

        let url= 'clases/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('action', 'eliminar')    

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data => {
            if(data.ok){
                location.reload()

            }
        })
    }
</script>