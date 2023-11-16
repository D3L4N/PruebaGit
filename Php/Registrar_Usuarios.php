<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
</head>
<body>
<?php
include("./Php/Conexion.php");
function hashPassword($password) {
    return hash('sha256', $password);
}

if (isset($_POST['Enviar'])) {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $usuario = $_POST['Usuario'];
    $rolUsuario = $_POST['Rol_Usuario'];
    $contraseña = hashPassword($_POST['Contraseña']);
    date_default_timezone_set('America/Bogota');
    $fecha = date("Y-m-d H:i:s");

    if (
        strlen($nombre) >= 1 &&
        strlen($apellido) >= 1 &&
        strlen($usuario) >= 1 &&
        strlen($rolUsuario) >= 1 &&
        strlen($contraseña) >= 1
    ) {
        $foto = $_FILES['foto'];
        $imgFileName = $foto['name'];
        $imgFileType = $foto['type'];

        // Ruta de destino absoluta
        $directorioDestino = "Foto_Perfil";
        $destino = 'Foto_Perfil/' . basename($imgFileName); // Solo el nombre de la carpeta

        // Verificar si la carpeta de destino existe, si no, créala
        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        // Verificar si el tipo de archivo es una imagen
        $allowedImageTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($imgFileType, $allowedImageTypes) && move_uploaded_file($foto['tmp_name'], $directorioDestino . '/' . basename($imgFileName))) {
            // El usuario proporcionó una imagen
        } else {
            // El usuario no proporcionó una imagen, usa una imagen predeterminada
            $destino = 'Foto_Perfil/Predeterminada.jpg'; // Cambia 'Predeterminada.gif' al nombre de tu imagen predeterminada
        }

        // Verificar si el usuario ya existe
        $stmtVerificacion = mysqli_prepare($CONEXION, "SELECT * FROM usuario WHERE Usuario = ?");
        mysqli_stmt_bind_param($stmtVerificacion, "s", $usuario);
        mysqli_stmt_execute($stmtVerificacion);
        mysqli_stmt_store_result($stmtVerificacion);

        if (mysqli_stmt_num_rows($stmtVerificacion) > 0) {
            ?>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        agregarToast({
                            tipo: 'error',
                            titulo: 'ERROR',
                            descripcion: 'Este Usuario ya Existe.',
                            autoCierre: true
                        });
                    });
                </script>
            <?php
        } else {
            // Insertar el nuevo usuario en la base de datos
            $stmt = mysqli_prepare($CONEXION, "INSERT INTO usuario (Nombre, Apellido, Usuario, Rol_Usuario, Contraseña, Fecha_Registro, Foto_Perfil) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssssss", $nombre, $apellido, $usuario, $rolUsuario, $contraseña, $fecha, $destino);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            ?>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        agregarToast({
                            tipo: 'exito',
                            titulo: 'EXITO',
                            descripcion: 'Usuario Registrado Exitosamente.',
                            autoCierre: true
                        });
                    });
                </script>
            <?php
        }
        mysqli_stmt_close($stmtVerificacion);
    } else {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                agregarToast({
                    tipo: 'error',
                    titulo: 'ERROR',
                    descripcion: 'Llene todos los campos.',
                    autoCierre: true
                });
            });
        </script>
        <?php
    }
}
?>
</body>
</html>
