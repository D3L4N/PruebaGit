<?php
session_start();
include("Php/Login.php");

if (isset($_SESSION['Usuario'])) {
    // =========== Redirigir rol ============
    switch ($_SESSION['Rol_Usuario']) {
        case 'Administrador':
            header("location: Panel_Administrador.php");
            break;
        case 'Cajero':
            header("location: Panel_Cajero.php");
            break;
        case 'Bodeguero':
            header("location: Panel_Bodeguero.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- ======= Estilos ========-->
    <link rel="stylesheet" href="Css/Login.css">
    <link rel="stylesheet" href="Css/Alert.css">
    <link rel="icon" href="Icons/StarInventory.ico"> 
</head>
<body>
    <div class="Contenedor_login">
        <h1>BIENVENIDO</h1>
        <form method="post">
            <div class="input_login">
                <input type="text" name="Usuario" placeholder="Usuario">
                <!-- ========== Ícono de usuario =========== -->
                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                <lord-icon
                    src="https://cdn.lordicon.com/cjyxqyly.json"
                    trigger="loop"
                    colors="primary:#b26836,secondary:#4bb3fd,tertiary:#f9c9c0"
                    style="width:40px;height:40px">
                </lord-icon>
            </div>
            <div class="input_login">
                <input type="password" name="Contraseña" placeholder="Contraseña">
                <!-- ========== Ícono de contraseña =========== -->
                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                <lord-icon
                    src="https://cdn.lordicon.com/nrzqxhfu.json"
                    trigger="loop"
                    colors="primary:#121331,secondary:#646e78"
                    style="width:50px;height:50px">
                </lord-icon>
            </div>
            <button class="btn_login" name="Enviar"> 
                Enviar 
                <!-- =========== Ícono de envío ========== -->
                <script src="https://cdn.lordicon.com/clcopglh.json"></script>
                <lord-icon
                    src="https://cdn.lordicon.com/clcopglh.json"
                    trigger="loop"
                    colors="primary:#121331,secondary:#ffc738"
                    style="width:40px;height:40px">
                </lord-icon>
            </button>
        </form>
    </div>
</body>
</html>

