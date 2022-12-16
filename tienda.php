<?php include("template/cabecera.php")  ?>
<?php include ("administrador/config/bd.php"); 
    $sentenciaSQL = $conexion->prepare("SELECT * FROM videojuegos");
    $sentenciaSQL->execute();
    $listaVideojuegos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaVideojuegos as $videojuego) { ?>
<div class="col-md-3">

    <div class="card">

    <img class="card-img-top" src="./img/<?php echo $videojuego['imagen'];?>" alt="">
    <div class="card-body">
        <h4 class="card-title"> <?php echo $videojuego['nombre'];?> </h4>
        <a name="" id="" class="btn btn-primary" href="#" role="button">Ver mas</a>
    </div>
    </div>
</div>

<?php } ?>


<?php include("template/pie.php") ?>