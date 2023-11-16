<?php
session_start();

if ($_SESSION['Rol_Usuario']) {
    include("../Php/Conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario de edición
        $id = $_POST["ID_Subcategoria"];
        $name = $_POST['Nombre'];
        $categoria = $_POST['Categoria'];

        // Actualizar los datos en la base de datos
        $sqlUpdateSubcategoria = "UPDATE subcategoria SET Nombre_Subcategoria='$name', ID_Categoria='$categoria' WHERE ID_Subcategoria='$id'";
        $queryUpdateSubcategoria = mysqli_query($CONEXION, $sqlUpdateSubcategoria);

        // Actualizar la columna Subcategoria en la tabla Producto
        $sqlUpdateProducto = "UPDATE Producto SET Subcategoria=NULL WHERE Subcategoria='$id'";
        $queryUpdateProducto = mysqli_query($CONEXION, $sqlUpdateProducto);

        if ($queryUpdateSubcategoria && $queryUpdateProducto) {
            header("Location: ../Crud_Subcategorias.php?actualizacion=exitosa");
            exit();
        } else {
            showJavaScriptAlert('error', 'ERROR', 'Error al actualizar la subcategoría.');
            exit();
        }
    } else {
        // Obtener el ID de la subcategoría a editar desde la URL
        if (isset($_GET['ID_Subcategoria'])) {
            $id = $_GET['ID_Subcategoria'];

            // Consultar la base de datos para obtener los datos de la subcategoría
            $sql = "SELECT * FROM subcategoria WHERE ID_Subcategoria='$id'";
            $query = mysqli_query($CONEXION, $sql);
            $row = mysqli_fetch_array($query);

            if (!$row) {
                showJavaScriptAlert('error', 'ERROR', 'Subcategoría no encontrada.');
                exit();
            }
        } else {
            showJavaScriptAlert('error', 'ERROR', 'ID de subcategoría no proporcionado.');
            exit();
        }
    }
} else {
    header("Location: ../Index.php");
    exit();
}

// Función para mostrar una alerta JavaScript
function showJavaScriptAlert($type, $title, $message) {
    echo "<script>alert('$message');</script>";
    echo "<script>window.location.replace('../Crud_Subcategorias.php?$type=$title');</script>";
    exit();
}
?>
