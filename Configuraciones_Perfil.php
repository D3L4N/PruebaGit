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
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Css/Configuracion.css">
    <title>Configuración de Usuario</title>
     <!-- Estilos -->
     <link rel="stylesheet" href="Css/Alerts.css" /><!--mirar hacer error con el otro codigo-->
    <script src="Js/Alerts.js" defer></script>
     <!-- Iconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="Icons/StarInventory.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
</head>
<body>
<?php
$Usuario = $_SESSION['Usuario'];
// Realiza una consulta para obtener los datos del usuario
$Consulta = mysqli_query($CONEXION, "SELECT * FROM usuario WHERE Usuario = '$Usuario';");
$Valores = mysqli_fetch_array($Consulta);
$Nombre = isset($Valores['Nombre']) ? $Valores['Nombre'] : '';
$Apellido = isset($Valores['Apellido']) ? $Valores['Apellido'] : '';
$Usuario = $Valores['Usuario'];
$FotoPerfil = $Valores['Foto_Perfil'];
?>
<div class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <form action="Php/procesar_foto_admin.php" class="sign-in-form" method="post" enctype="multipart/form-data">
                <h2 class="title">Actualizar Foto de Perfil</h2>
                <img id="VistaPrevia" class="VistaPrevia" src="<?php echo $FotoPerfil; ?>" alt="Vista previa de la imagen" width="150" height="150">
                <input type="hidden" name="Usuario" value="<?php echo $Usuario; ?>">
                <label for="nfoto" class="foto">Selecciona tu nueva foto de perfil</label>
                <input id="nfoto" style="display:none;" type="file" name="nfoto" accept="image/*" required class="nfoto">
                <input type="submit" value="Actualizar Foto" class="btn solid" />
            </form>
            <form action="php/Procesar_Edicion_Perfil.php" class="sign-up-form" method="post">
                <h2 class="title">Actualizar Datos de Usuario</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Usuario" value="<?php echo $Usuario; ?>" name="Usuario"/>
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="Nombre" value="<?php echo $Nombre; ?>" placeholder="Nombre">
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="Apellido" value="<?php echo $Apellido; ?>" placeholder="Apellido">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="Nueva_Contraseña"  placeholder="Nueva Contraseña">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="Repetir_Contraseña" placeholder="Repetir Contraseña">
                </div>
                <input type="submit" class="btn" value="Actualizar Datos" />
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Actualiza tus Datos</h3>
                <p>
                    Presiona el botón para actualizar la información de tu perfil.
                </p>
                <button class="btn transparent" id="sign-up-btn">
                    Datos
                </button>
            </div>
            <img src="icons/StarInventory.ico" class="image" alt="" />
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>Actualiza tu Foto de Perfil</h3>
                <p>
                    Presiona el botón para cambiar tu foto de perfil.
                </p>
                <button class="btn transparent" id="sign-in-btn">
                    Foto de Perfil
                </button>
            </div>
            <img src="icons/StarInventory.ico" class="image" alt="" />
        </div>
    </div>
</div>
<div class="contenedor">
    <div class="hero">
        <div class="contenedor-botones" id="contenedor-botones"></div>
    </div>
    <div class="contenedor-toast" id="contenedor-toast"></div>
</div>
<script src="Js/Confi.js"></script>
<script src="js/Actualizar_Foto.js"></script>
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