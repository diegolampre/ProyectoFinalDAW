<?php
require '../administrador/config/bd.php';
require '../administrador/config/config.php';
require '../administrador/config/database.php';
$db = new Database();
$conexion = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

echo '<pre>';
print_r($datos);
echo '<pre>';

if(is_array($datos)){

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $sentenciaSQL = $conexion->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?,?,?,?,?,?)");

    $sentenciaSQL->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
    $id = $conexion->lastInsertId();

    if($id > 0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if($productos != null){
            foreach($productos as $clave => $cantidad)  {
        
                $sentenciaSQL = $conexion->prepare("SELECT id, nombre, precio, descuento FROM videojuegos WHERE id=?  AND activo=1 "); // AND activo=1
                $sentenciaSQL->execute([$clave]);
                $row_prod = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'] ;
                $descuento = $row_prod['descuento'] ;
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql_insert = $conexion->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);
            }
            include 'enviar_email.php';
        }
        unset($_SESSION['carrito']);
    }
}