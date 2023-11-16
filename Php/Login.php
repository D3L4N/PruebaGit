<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/Css/Alert_Login.css">
    <link rel="icon" href="Icons/StarInventory.ico">
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluye el archivo de conexión
include('Php/Conexion.php');

$alertaMostrada = false; // Variable para controlar si se muestra la alerta

if (isset($_POST['Enviar'])) {
    $usuario = mysqli_real_escape_string($CONEXION, $_POST['Usuario']);
    $contrasena = $_POST['Contraseña'];

    if (strlen($usuario) >= 1 && strlen($contrasena) >= 1) {
        // Hash de contraseña (usar la función hash adecuada, como password_hash)
        $hashed_password = hash('sha256', $contrasena);

        // Consulta SQL segura
        $stmt = mysqli_prepare($CONEXION, "SELECT Usuario, Rol_Usuario FROM usuario WHERE Usuario=? AND Contraseña=?");
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $hashed_password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['Usuario'] = $row['Usuario'];
            $_SESSION['Rol_Usuario'] = $row['Rol_Usuario'];

            // Redireccionar al usuario según su rol
            switch ($_SESSION['Rol_Usuario']) {
                case 'Administrador':
                    header("Location: Panel_Administrador.php");
                    exit();
                case 'Cajero':
                    header("Location: Panel_Cajero.php");
                    exit();
                case 'Bodeguero':
                    header("Location: Panel_Bodeguero.php");
                    exit();
            }
        } else {
            mostrarAlerta("inexistente", "¡Usuario o Contraseña Incorrecta!");
            $alertaMostrada = true;
        }
    } else {
        if (empty($usuario)) {
            mostrarAlerta("usuario", "¡Falta el nombre de usuario!");
            $alertaMostrada = true;
        } elseif (empty($contrasena)) {
            mostrarAlerta("contrasena", "¡Falta la contraseña!");
            $alertaMostrada = true;
        } else {
            mostrarAlerta("general", "¡Llena Todos Los Campos!");
            $alertaMostrada = true;
        }
    }
}

function mostrarAlerta($tipo, $mensaje) {
    ?>
    <div class="popup_Error">
        <button class="close-btn" onclick="closePopup()">&times;</button>
        <h3><?php echo $mensaje; ?></h3>
        <div class="Error_Img">
            <lord-icon
                src="https://cdn.lordicon.com/vyukcgvf.json"
                trigger="loop"
                colors="outline:#121331,primary:#ffc738,secondary:#92140c"
                style="width:250px;height:250px">
            </lord-icon>
        </div>
    </div>
    <?php
}
?>
<script>
    // Función para mostrar la alerta y cerrarla después de 5 segundos
    function mostrarAlerta() {
        var alerta = document.querySelector('.popup_Error');
        alerta.style.display = 'block';

        // Cierra la alerta automáticamente después de 5 segundos (5000 ms)
        setTimeout(function() {
            alerta.style.display = 'none';
        }, 2000); // Cambia este valor según la cantidad de tiempo deseada en milisegundos
    }
    
    // Función para cerrar la alerta
    function closePopup() {
        var alerta = document.querySelector('.popup_Error');
        alerta.style.display = 'none';
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
<script src="../js/Alert_Login.js"></script>
</body>
</html>
