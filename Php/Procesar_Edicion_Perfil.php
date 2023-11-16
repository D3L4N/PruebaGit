<?php
// Incluye el archivo de conexión a la base de datos
include '../Php/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $Usuario = $_POST['Usuario'];
    $NuevoNombre = $_POST['Nombre'];
    $NuevoApellido = $_POST['Apellido'];
    $NuevaContraseña = $_POST['Nueva_Contraseña'];
    $RepetirContraseña = $_POST['Repetir_Contraseña'];

    // Hash de la nueva contraseña si se proporcionó
    $contraseña_hasheada = '';
    if (!empty($NuevaContraseña)) {
        $contraseña_hasheada = hash('sha256', $NuevaContraseña);
    }

    // Crear la parte SET de la consulta SQL
    $set_clause = "Nombre = '$NuevoNombre', Apellido = '$NuevoApellido'";

    // Añadir la contraseña solo si se proporcionó una nueva
    if (!empty($NuevaContraseña)) {
        $set_clause .= ", Contraseña = '$contraseña_hasheada'";
    }

    // Construir la consulta SQL completa
    $sql = "UPDATE Usuario SET $set_clause WHERE Usuario = '$Usuario'";

    // Ejecutar la consulta
    $resultado = $CONEXION->query($sql);

    if ($resultado) {
        echo "Los datos se actualizaron correctamente.";
    } else {
        echo "Error al actualizar los datos: " . $CONEXION->error;
    }

    // Cerrar la conexión
    $CONEXION->close();
}
?>


