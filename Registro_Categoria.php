<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['Rol_Usuario'])) {
    $menuDirectory = "Menus/";

    $menuFiles = [
        'Administrador' => 'Menu_Administrador.php',
        'Cajero' => 'Menu_Cajero.php',
        'Bodeguero' => 'Menu_Bodeguero.php',
    ];

    if (array_key_exists($_SESSION['Rol_Usuario'], $menuFiles)) {
        require($menuDirectory . $menuFiles[$_SESSION['Rol_Usuario']]);
        require("Php/Conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Categoria</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="Css/Alerts.css" />
    <link rel="stylesheet" href="Css/Registros.css">
    <script src="Js/Alerts.js" defer></script>
     <!-- Iconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="Icons/StarInventory.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
</head>
<body>
<div class="Contenedor_login">
    <h1>REGISTRO DE categoria</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="input_login">
            <input type="text" name="Nombre_Categoria" placeholder="Nombre">
            <span class="material-symbols-outlined">person</span>
        </div>
        <button class="btn_login" name="Enviar">Enviar</button>
    </form>
</div>
<div class="contenedor">
    <div class="hero">
        <div class="contenedor-botones" id="contenedor-botones"></div>
    </div>
    <div class="contenedor-toast" id="contenedor-toast"></div>
</div>
</body>
</html>
<?php
    // Incluir el archivo de registro de usuarios
    include("Php/Registrar_Categoria.php");
?>
<?php
    } else {
        header("Location: Index.php");
    }
} else {
    header("Location: Index.php");
}
?>

<?php
include("Alerts_Productos.Php")
?>




