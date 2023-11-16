<?php
function updateImage($id, $CONEXION) {
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $imgFileName = $foto['name'];
        $imgFileType = $foto['type'];

        // Verificar si el tipo de archivo es una imagen
        $allowedImageTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($imgFileType, $allowedImageTypes)) {
            // Ruta de destino absoluta
            $directorioDestino = "../Imagen_Producto";
            $destino = 'Imagen_Producto/' . basename($imgFileName);

            // Verificar si la carpeta de destino existe, si no, créala
            if (!file_exists($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }

            // Mover la imagen cargada a la carpeta de destino
            if (move_uploaded_file($foto['tmp_name'], $directorioDestino . '/' . basename($imgFileName))) {
                // Actualizar la ruta de la imagen en la base de datos
                $sql = "UPDATE Producto SET Imagen_Producto='$destino' WHERE ID_Producto=?";
                $stmt = mysqli_prepare($CONEXION, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id);
                $query = mysqli_stmt_execute($stmt);

                if (!$query) {
                    // Muestra un mensaje de error adecuado
                    // Puedes implementar tu lógica de manejo de errores aquí
                    // showJavaScriptAlert('error', 'ERROR', 'Error al actualizar la foto de perfil. Por favor, inténtalo de nuevo.');
                }
            } else {
                // Muestra un mensaje de error adecuado
                // showJavaScriptAlert('error', 'ERROR', 'Error al cargar la nueva foto de perfil. Asegúrate de que sea una imagen válida.');
            }
        } else {
            // Muestra un mensaje de error adecuado
            // showJavaScriptAlert('error', 'ERROR', 'Tipo de archivo no permitido. Selecciona una imagen válida.');
        }
    }
}

session_start();
if (isset($_SESSION['Rol_Usuario']) && $_SESSION['Rol_Usuario'] == 'Administrador') {
    include("../Php/Conexion.php");

    // Obtener el ID del producto de la URL
    if (isset($_GET['ID_Producto'])) {
        $id = mysqli_real_escape_string($CONEXION, $_GET['ID_Producto']);

        // Consulta para obtener los datos del producto
        $sql = "SELECT * FROM Producto WHERE ID_Producto=?";
        $stmt = mysqli_prepare($CONEXION, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $query = mysqli_stmt_execute($stmt);

        if ($query) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
        } else {
            header("Location: ../Crud_Productos.php?error=consulta");
            exit();
        }
    } else {
        header("Location: ../Crud_Productos.php?error=id_producto");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recuperar los datos del formulario y escaparlos
        $name = mysqli_real_escape_string($CONEXION, $_POST['Nombre_Producto']);
        $caducidad = mysqli_real_escape_string($CONEXION, $_POST['Fecha_Caducidad']);
        $precioCompra = mysqli_real_escape_string($CONEXION, $_POST['Precio']);
        $stockActual = mysqli_real_escape_string($CONEXION, $_POST['Stock']);
        $proveedor = mysqli_real_escape_string($CONEXION, $_POST['Proveedor']);
        $categoria = mysqli_real_escape_string($CONEXION, $_POST['Categoria']);
        $subcategoria = mysqli_real_escape_string($CONEXION, $_POST['Subcategoria']);

        // Crear una sentencia preparada para actualizar los datos en la base de datos
        $sql = "UPDATE Producto SET Nombre_Producto=?, Fecha_Caducidad=?, Precio=?, Stock=?, Proveedor=?, Categoria=?, Subcategoria=? WHERE ID_Producto=?";
        $stmt = mysqli_prepare($CONEXION, $sql);
        mysqli_stmt_bind_param($stmt, "ssddiissi", $name, $caducidad, $precioCompra, $stockActual, $proveedor, $categoria, $subcategoria, $id);

        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../Crud_Productos.php?actualizacion=exitosa");
            exit();
        } else {
            header("Location: ../Crud_Productos.php?actualizacion=fallida");
            exit();
        }
    }

    // Consulta y generación de opciones para categorías
    $queryCategorias = "SELECT ID_Categoria, Nombre_Categoria FROM Categoria";
    $resultCategorias = mysqli_query($CONEXION, $queryCategorias);

    // Consulta y generación de opciones para subcategorías
    $querySubcategorias = "SELECT ID_Subcategoria, Nombre_Subcategoria, ID_Categoria FROM Subcategoria";
    $resultSubcategorias = mysqli_query($CONEXION, $querySubcategorias);

    // Consulta y generación de opciones para proveedores
    $queryProveedores = "SELECT ID_Proveedor, Nombre_Proveedor FROM Proveedor";
    $resultProveedores = mysqli_query($CONEXION, $queryProveedores);
} else {
    header("Location: ../Index.php");
    exit();
}
?>
