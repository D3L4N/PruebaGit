<?php
session_start(); // Asegúrate de iniciar la sesión si no lo has hecho
if ($_SESSION['Rol_Usuario']) {
    include("../Php/Conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario de edición
        $id = $_POST["ID_Categoria"];
        $name = $_POST['Nombre_Categoria'];

        // Definir la consulta SQL
        $sql = "UPDATE Categoria SET Nombre_Categoria='$name' WHERE ID_Categoria='$id'";
        
        // Ejecutar la consulta SQL
        $query = mysqli_query($CONEXION, $sql);

        if ($query) {
            header("Location: ../Crud_Categorias.php?edicion=exitosa");
            exit();
        } else {
            // Muestra el mensaje de error de MySQL en caso de fallo
            echo "Error en la consulta: " . mysqli_error($CONEXION);
            // Puedes agregar un mensaje específico para la redirección
            // header("Location: ../Crud_Categorias.php?edicion=fallida&error=" . mysqli_error($CONEXION));
            exit();
        }
    } else {
        // Obtener el ID del usuario a editar desde la URL
        if (isset($_GET['ID_Categoria'])) {
            $id = $_GET['ID_Categoria'];

            // Consultar la base de datos para obtener los datos del usuario
            $sql = "SELECT * FROM Categoria WHERE ID_Categoria='$id'";
            $query = mysqli_query($CONEXION, $sql);
            $row = mysqli_fetch_array($query);

            if (!$row) {
                showJavaScriptAlert('error', 'ERROR', 'Categoria no encontrado.');
                exit();
            }
        } else {
            showJavaScriptAlert('error', 'ERROR', 'ID de Categoria no proporcionado.');
            exit();
        }
    }
} else {
    header("Location: ../Index.php");
    exit();
}
?>
