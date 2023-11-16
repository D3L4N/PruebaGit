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
    <title>Crud Usuarios</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="Css/Alerts.css">
    <link rel="stylesheet" href="Css/Cruds.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="js/Crud.js" defer></script>
    <script src="Js/Alerts.js" defer></script>
     <!-- Iconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="Icons/StarInventory.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
</head>
</head>
<body>
<section>
    <div class="row">
        <?php
        // Leer el parámetro de URL "eliminacion"
        $eliminacion = $_GET["eliminacion"] ?? "";

        // Mensajes de éxito y error para eliminación
        $successMessageEliminacion = "Usuario eliminado exitosamente.";
        $errorMessageEliminacion = "Error al eliminar el usuario.";
        
        // Función para mostrar una alerta basada en JavaScript
        function showJavaScriptAlertEliminacion($tipo, $titulo, $descripcion) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", () => {
                        agregarToast({
                            tipo: "' . $tipo . '",
                            titulo: "' . $titulo . '",
                            descripcion: "' . $descripcion . '",
                            autoCierre: true
                        });
                    });
                  </script>';
        }
        
        if ($eliminacion === "exitosa") {
            showJavaScriptAlertEliminacion('exito', 'Éxito', $successMessageEliminacion);
        } elseif ($eliminacion === "fallida") {
            showJavaScriptAlertEliminacion('error', 'ERROR', $errorMessageEliminacion);
        }
        
        $edicion = $_GET["edicion"] ?? "";
        
        // Mensajes de éxito y error para edición
        $successMessageEdicion = "Usuario editado exitosamente.";
        $errorMessageEdicion = "Error al editar el usuario.";
        
        // Función para mostrar una alerta basada en JavaScript
        function showJavaScriptAlertEdicion($tipo, $titulo, $descripcion) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", () => {
                        agregarToast({
                            tipo: "' . $tipo . '",
                            titulo: "' . $titulo . '",
                            descripcion: "' . $descripcion . '",
                            autoCierre: true
                        });
                    });
                  </script>';
        }
        
        if ($edicion === "exitosa") {
            showJavaScriptAlertEdicion('exito', 'Éxito', $successMessageEdicion);
        } elseif ($edicion === "fallida") {
            showJavaScriptAlertEdicion('error', 'ERROR', $errorMessageEdicion);
        }
        
        function showJavaScriptAlert($tipo, $titulo, $descripcion) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", () => {
                        agregarToast({
                            tipo: "' . $tipo . '",
                            titulo: "' . $titulo . '",
                            descripcion: "' . $descripcion . '",
                            autoCierre: true
                        });
                    });
                  </script>';
        }        
        $sql = "SELECT * FROM usuario";
        $query = mysqli_query($CONEXION, $sql);
        ?>
        <div class="wrapper">
            <i id="left" class="fa-solid fa-angle-left"></i>
            <ul class="carousel">
            <?php while ($row = mysqli_fetch_array($query)): ?>
                <li class="card">
                <div class="img"><img src="<?= $row['Foto_Perfil'] ?>" alt="Foto Perfil" draggable="false"></div>
                    <h2><?= $row['Rol_Usuario'] ?></h2>
                    <span><?= $row['Nombre'] ?></span>
                    <span><?= $row['Apellido'] ?></span>
                    <span>👨<?= $row['Usuario'] ?></span>
                <h2>
                    <a href="Actualizar_Usuarios.php?ID_Usuario=<?= $row['ID_Usuario'] ?>"><button class="Editar">Editar</button></a>
                    <a href="Php/Borrar_Usuarios.php?ID_Usuario=<?= $row['ID_Usuario'] ?>"><button class="Eliminar">Eliminar</button></a>
                </h2>
                </li>
                <?php endwhile; ?>
            </ul>
            <i id="right" class="fa-solid fa-angle-right"></i>
        </div>
    </div>  
</section>
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
