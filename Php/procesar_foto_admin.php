<?php
session_start();

if (isset($_POST['Usuario'])) {
    $email = $_POST['Usuario'];
    include "../Php/Conexion.php";

    // Actualizar la foto de perfil si se seleccionó una nueva
    if (!empty($_FILES['nfoto']['name'])) {
        $foto = $_FILES['nfoto'];
        $directorioDestino = "../Foto_Perfil";
        $imgFileName = basename($foto['name']);
        $imgFileType = $foto['type'];
        $imgFileSize = $foto['size'];

        // Verificar si la carpeta de destino existe, si no, créala
        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        // Verificar si el tipo de archivo es una imagen y el tamaño es razonable
        $allowedImageTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        if (in_array($imgFileType, $allowedImageTypes) && $imgFileSize <= $maxFileSize) {
            // Generar un nombre de archivo único
            $imgFileName = uniqid() . '_' . $imgFileName;

            // Mover el archivo a la carpeta de destino
            $rutaImagen = $directorioDestino . '/' . $imgFileName;
            if (move_uploaded_file($foto['tmp_name'], $rutaImagen)) {
                // Actualizar la base de datos con el nombre del archivo sin la carpeta
                $rutaImagen = 'Foto_Perfil/' . $imgFileName;
                mysqli_query($CONEXION, "UPDATE usuario SET Foto_Perfil = '$rutaImagen' WHERE Usuario = '$email';");
            } else {
                echo "Ocurrió un error al subir la imagen.";
            }
        } else {
            echo "El formato de imagen es inválido o el tamaño excede el límite de 5 MB.";
        }
    }

    // Redireccionar después de actualizar
    header("Location: ../Visualizar_Perfil.php");
    exit;
} else {
    echo "Falta el parámetro de Usuario.";
}
?>
