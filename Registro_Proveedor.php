<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Provedor</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="Css/Registro_Usuarios.css">
    <link rel="stylesheet" href="Css/Alert.css">
    <link rel="icon" href="Icons/StarInventory.ico">
</head>
<body>
<?php
    // Incluir el menú del administrador
    include("./Menu_Administrador.php");
?>

<?php
    // Incluir el archivo de registro de usuarios
    include("./Php/Registrar_Usuarios.php");
?>

<div class="Contenedor_login">
    <h1>REGISTRO DE proveedor</h1>
    <form method="post" enctype="multipart/form-data">
        <!-- Campos de entrada para el registro -->
        <div class="input_login">
            <input type="text" name="Nombre" placeholder="Nombre">
            <img src="Imagenes/Gato.ico" width="35px" alt="Icono de Nombre">
        </div>
        <div class="input_login">
            <input type="number" name="Apellido" placeholder="Apellido">
            <img src="Imagenes/Perro.ico" width="35px" alt="Icono de Apellido">
        </div>
        <!-- Botón de enviar -->
        <button class="btn_login" name="Enviar">
            Enviar 
            <img src="Imagenes/Nave.ico" width="20px" alt="Icono de Enviar">
        </button>
    </form>
    <!-- Script para el manejo de archivos -->
    <script src="js/File.js"></script>
    <script src="js/Alert.js"></script>
</div>
</body>
</html>
