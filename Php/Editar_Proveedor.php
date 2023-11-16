<?php
session_start();
function updateImage($id, $CONEXION) {
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $imgFileName = $foto['name'];
        $imgFileType = $foto['type'];

        // Verificar si el tipo de archivo es una imagen
        $allowedImageTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($imgFileType, $allowedImageTypes)) {
            // Ruta de destino absoluta
            $directorioDestino = "../Imegen";
            $destino = 'Foto_Perfil/' . basename($imgFileName);

            // Verificar si la carpeta de destino existe, si no, créala
            if (!file_exists($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }

            // Mover la imagen cargada a la carpeta de destino
            if (move_uploaded_file($foto['tmp_name'], $directorioDestino . '/' . basename($imgFileName))) {
                // Actualizar la ruta de la imagen en la base de datos
                $sql = "UPDATE Usuario SET Foto_Perfil='$destino' WHERE ID_Usuario='$id'";
                $query = mysqli_query($CONEXION, $sql);

                if (!$query) {
                    showJavaScriptAlert('error', 'ERROR', 'Error al actualizar la foto de perfil. Por favor, inténtalo de nuevo.');
                }
            } else {
                showJavaScriptAlert('error', 'ERROR', 'Error al cargar la nueva foto de perfil. Asegúrate de que sea una imagen válida.');
            }
        } else {
            showJavaScriptAlert('error', 'ERROR', 'Tipo de archivo no permitido. Selecciona una imagen válida.');
        }
    }
}

if ($_SESSION['Rol_Usuario'] == 'Administrador') {
    include("../Php/Conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario de edición
        $id = $_POST["ID"];
        $name = $_POST['Nombre'];
        $lastname = $_POST['Apellido'];
        $username = $_POST['Usuario'];
        $email = $_POST['Rol_Usuario'];

        // Actualizar la contraseña solo si se proporciona una nueva
        $password = $_POST['Contraseña'];
        if (!empty($password)) {
            $password = hash('sha256', $password); // Aplicar el hash SHA-256 a la contraseña
            $sql = "UPDATE Usuario SET Nombre='$name', Apellido='$lastname', Usuario='$username', Contraseña='$password', Rol_Usuario='$email' WHERE ID_Usuario='$id'";
        } else {
            $sql = "UPDATE Usuario SET Nombre='$name', Apellido='$lastname', Usuario='$username', Rol_Usuario='$email' WHERE ID_Usuario='$id'";
        }

        $query = mysqli_query($CONEXION, $sql);

        if ($query) {
            updateImage($id, $CONEXION);
            header("Location: ../Crud_Usuarios.php?edicion=exitosa");
            exit();
        } else {
            header("Location: ../Crud_Usuarios.php?edicion=fallida");
        }
    } else {
        // Obtener el ID del usuario a editar desde la URL
        if (isset($_GET['ID_Usuario'])) {
            $id = $_GET['ID_Usuario'];

            // Consultar la base de datos para obtener los datos del usuario
            $sql = "SELECT * FROM Usuario WHERE ID_Usuario='$id'";
            $query = mysqli_query($CONEXION, $sql);
            $row = mysqli_fetch_array($query);

            if (!$row) {
                showJavaScriptAlert('error', 'ERROR', 'Usuario no encontrado.');
                exit();
            }
        } else {
            showJavaScriptAlert('error', 'ERROR', 'ID de usuario no proporcionado.');
            exit();
        }
    }
} else {
    header("Location: ../Index.php");
    exit();
}
?>
