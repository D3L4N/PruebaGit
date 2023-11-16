<?php
// Establece la conexión a la base de datos (debes configurar las credenciales)
include("/xampp1/htdocs/inventorio/Php/Conexion.php");

// Obtiene los datos del formulario
$id_producto = $_POST['producto'];
$cantidad = $_POST['cantidad'];
$motivo = $_POST['motivo'];
date_default_timezone_set('America/Bogota');

// Utiliza la clase DateTime para obtener la fecha y hora actual en el formato correcto
$fecha_devolucion = (new DateTime())->format('Y-m-d H:i:s');

$id_usuario = $_POST['usuario'];

// Consulta para obtener el nombre del producto
$queryNombreProducto = "SELECT Nombre_Producto FROM Producto WHERE ID_Producto = ?";
$stmtNombreProducto = $CONEXION->prepare($queryNombreProducto);
$stmtNombreProducto->bind_param("i", $id_producto);
$stmtNombreProducto->execute();
$stmtNombreProducto->bind_result($nombre_producto);
$stmtNombreProducto->fetch();
$stmtNombreProducto->close();

if (isset($nombre_producto)) {
    // Consulta para obtener la cantidad actual del producto
    $queryCantidadActual = "SELECT Stock FROM Producto WHERE ID_Producto = ?";
    $stmtCantidadActual = $CONEXION->prepare($queryCantidadActual);
    $stmtCantidadActual->bind_param("i", $id_producto);
    $stmtCantidadActual->execute();
    $stmtCantidadActual->bind_result($cantidad_actual);
    $stmtCantidadActual->fetch();
    $stmtCantidadActual->close();

    if (isset($cantidad_actual)) {
        if ($cantidad_actual >= $cantidad) {
            // Actualiza la cantidad en la base de datos
            $nueva_cantidad = $cantidad_actual - $cantidad;
            $updateCantidad = "UPDATE Producto SET Stock = ? WHERE ID_Producto = ?";
            $stmtUpdateCantidad = $CONEXION->prepare($updateCantidad);
            $stmtUpdateCantidad->bind_param("ii", $nueva_cantidad, $id_producto);

            if ($stmtUpdateCantidad->execute()) {
                $stmtUpdateCantidad->close();
                // Consulta preparada para insertar los datos en la tabla Devolucion
                $sql = "INSERT INTO Devolucion (Nombre_Producto, Stock, Fecha_Devolucion, Nombre_Usuario, Motivo)
                        VALUES (?, ?, ?, ?, ?)";

                $stmt = $CONEXION->prepare($sql);

                // Cambia el tipo de parámetro para la fecha
                $stmt->bind_param("sssss", $nombre_producto, $cantidad, $fecha_devolucion, $id_usuario, $motivo);

                if ($stmt->execute()) {
                    echo "Devolución de producto registrada con éxito.";
                } else {
                    echo "Error al registrar la devolución: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error al actualizar la cantidad: " . $stmtUpdateCantidad->error;
            }
        } else {
            echo "No hay suficiente cantidad del producto para realizar la devolución.";
        }
    } else {
        echo "Error al obtener la cantidad actual del producto.";
    }
} else {
    echo "Error al obtener el nombre del producto.";
}

$CONEXION->close();
?>
