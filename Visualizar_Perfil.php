<?php
session_start();

if (!isset($_SESSION['Usuario'])) {
    header("Location: login.php"); 
    exit();
}

// ============= Conexión a la base de datos =============
include 'Php/Conexion.php';
$Usuario = $_SESSION['Usuario'];

// ============== Obtener los datos del usuario =============
$stmt = mysqli_prepare($CONEXION, "SELECT Nombre, Apellido, Foto_Perfil, Rol_Usuario, Fecha_Registro FROM usuario WHERE Usuario = ?");
mysqli_stmt_bind_param($stmt, "s", $Usuario);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Nombre, $Apellido, $FotoPerfil, $Rol_Usuario, $Fecha_Registro);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<?php
// Inicia la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Asegúrate de que exista la sesión y el rol de usuario
if (isset($_SESSION['Rol_Usuario'])) {
    // Define el directorio de los archivos de menú
    $menuDirectory = "Menus/";

    // Define un array asociativo que mapea roles a archivos de menú
    $menuFiles = [
        'Administrador' => 'Menu_Administrador.php',
        'Cajero' => 'Menu_Cajero.php',
        'Bodeguero' => 'Menu_Bodeguero.php',
    ];

    // Verifica si el rol del usuario está en el array de menú
    if (array_key_exists($_SESSION['Rol_Usuario'], $menuFiles)) {
        // Incluye el archivo de menú correspondiente
        require($menuDirectory . $menuFiles[$_SESSION['Rol_Usuario']]);
        require("Php/Conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Perfil</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="Css/Visualizar_Pefil.Css">
    <link rel="stylesheet" href="Css/Alerts.css" />
    <script src="Js/Alerts.js" defer></script>
     <!-- Iconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="Icons/StarInventory.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="Contenedor">
        <div class="Caja_Perfil">
            <a href="Configuraciones_Perfil.php">
            <span class="material-symbols-outlined">
                settings
            </span>
            </a>
            <img class="Perfil_Icon" src="<?php echo $FotoPerfil; ?>" alt="Foto Perfil">
            <h3><?php echo $Nombre; ?></h3>
            <p><?php echo $Apellido; ?></p>
            <button><?php echo $Usuario; ?></button>
            <div class="Boton_Perfil">
                <p><?php echo $Rol_Usuario; ?></p>
                <p><?php echo $Fecha_Registro; ?></p>
                <img src="icons/StarInventory.ico" alt="">
            </div>
        </div>   
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



