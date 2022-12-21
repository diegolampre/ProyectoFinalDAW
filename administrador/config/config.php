<?php

define("CLIENT_ID", "AR3G6-tksWzumU2Pc78cXioplVjb9pSpaA_YfnwK0T4Hyf1ZZ8UD3Hu_DOFzRABqLhcRySRIlHN6ufCh");
define("CURRENCY", "EUR");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "€");

define("MAIL_HOST", "mail.propagames.com");
define("MAIL_USER", "ventas@propagames.com");
define("MAIL_PASS", "tu_password");
define("MAIL_PORT", "465");

session_start();


$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>