<?php

require_once '../administrador/config/bd.php';
require_once 'clienteFunciones.php';

$datos = [];

if(isset($_POST['action'])){
    $action = $_POST['action'];

    if($action == 'existeUsuario'){
        $datos['ok'] = usuarioExiste($_POST['usuario'], $conexion);
    }elseif($action = 'existeEmail'){
        $datos['ok'] = emailExiste($_POST['email'], $conexion);
    }
}

echo json_encode($datos);