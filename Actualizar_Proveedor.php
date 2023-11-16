<?php 
    include("/xampp1/htdocs/inventorio/Php/Conexion.php");

    $id=$_GET['ID_Usuario'];

    $sql="SELECT * FROM usuarios WHERE ID_Usuario='$id'";
    $query=mysqli_query($CONEXION, $sql);

    $row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>StarInventory - Editar usuarios </title>
        <!-- ======Estilos======= -->
        <link href="Css/Editar.css" rel="stylesheet">
        <link rel="icon" href="Imagenes/StarInventory.ico">
        
    </head>
    <body>
    <?php include("Menu_Administrador.php")?>
        <div class="Contenedor_login">
        <H1>ACTUALIZAR DATOS</H1>
        <form action="./Php/Editar_Usuarios.php" method="POST">
            <div class="input_login">
                <input type="hidden" name="ID" value="<?= $row['ID_Usuario']?>">
            </div>
            <div class="input_login">
                <input type="text" name="Nombre" placeholder="Nombre" value="<?= $row['Nombre']?>">
                <img src="Imagenes/Gato.ico" width="35px">
            </div>
            <div class="input_login">
                <input type="text" name="Apellido" placeholder="Apellido" value="<?= $row['Apellido']?>">
                <img src="Imagenes/Perro.ico" width="35px">
            </div>
            <button class="btn_login" name="Enviar" value="Actualizar"> Enviar <img src="Imagenes/Nave.ico" width="20px"></button>
        </form>
    </div>
    </body>
</html>