<?php
//Configuracion de Paypal
define("CLIENT_ID", "Abh2mFAoZA1ceS4G6YRnxHupw0ODVqeEFSLyw3QFE0EtAAbnVwTP2o4GBk-rEibqzF2Pi5seUr0ThrRM");
define("CURRENCY", "EUR");

//Configuracion del sistema
define("SITE_URL", "http://localhost/sitioweb");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "€");

//Datos para envio de correo electronico
define("MAIL_HOST", "mail.gmail.com");
define("MAIL_USER", "propagames1@gmail.com");
define("MAIL_PASS", "PropaGames21.");
define("MAIL_PORT", "465");

session_start();


$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>