
<?php


require 'administrador/config/config.php';
require 'administrador/config/bd.php';


$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad)  {

        $sentenciaSQL = $conexion->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad  FROM videojuegos WHERE id=? "); // AND activo=1
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
                                $_id = $producto['id'] ;
                                $nombre = $producto['nombre'] ;
                                $precio = $producto['precio'] ;
                                $descuento = $producto['descuento'] ;
                                $precio_desc = $precio - (($precio * $descuento)/100) ;
                                $cantidad = $producto['cantidad'] ;
                                $subtotal = $cantidad * $precio_desc ;
                                $total += $subtotal ;
                        ?>

                        <tr>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $precio_desc ?>€</td>
                            <td>
                                <input type="number" min="1" max="10" step="1" value="<?php  echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $subtotal ?>€</div>
                            </td>
                            <td>
                                <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id;?>" data-ds-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>
                            </td>
                        </tr>
                        <?php  } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3" id="total"> <?php echo $total?>  €</p>
                            </td>
                        </tr>
                    </tbody>
                    <?php  } ?>
                </table>
            </div>
        
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <button class="btn btn-primary btn-lg">Realizar Pago</button>
                </div>
            </div>

        </div>
    </main>

        <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
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
</body>
</html>


<script>

    let eliminaModal = document.getElementById('eliminaModal')
    eliminaModal.addEventListener('show.bs.modal', function(event){
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        let buttonElimina = eliminaModal.querySelector('.modal-footer #btn.elimina')
        buttonElimina.value = id
    })


    function actualizaCantidad(cantidad,id){
        let url= '/clases/actualizar_carrito.php';
        let formData = new FormData()
        formData.append('id', id)
        formData.append('action', 'agregar')    
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
                let list = document.getElementByName('subtotal')

                for(let i = 0; i < list.length; i++){
                    total += parseFloat(list[i].innerHTML.replace(/[$,]/g,  ''))
                }

                total = new Intl.NumberFormat('es', {
                    minimumFractionDigits: 2
                }).format(total)
                document.getElementById('total').innerHTML = /* '< ?php echo MONEDA;?>' */ total
            }
        })
    }



    function eliminar(){
        let botonElimina = document.getElementById('btn-elimina')
        let id = botonElimina.value

        let url= '/clases/actualizar_carrito.php';
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
</script>