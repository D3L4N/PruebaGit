<?php
// Establece la conexión a la base de datos (debes configurar las credenciales)
include("/xampp1/htdocs/inventorio/Php/Conexion.php");

// Obtiene los datos del formulario
$id_producto = $_POST['producto'];
$cantidad = $_POST['cantidad'];
$fecha_caducidad = $_POST['fecha_caducidad'];
date_default_timezone_set('America/Bogota');
$fecha_entrada = date('Y-m-d H:i:s');
$id_proveedor = $_POST['proveedor'];
$id_usuario = $_POST['usuario'];

// Consulta para obtener el nombre del producto basado en el ID
$queryNombreProducto = "SELECT Nombre_Producto FROM Producto WHERE ID_Producto = ?";
$stmtNombreProducto = $CONEXION->prepare($queryNombreProducto);
$stmtNombreProducto->bind_param("i", $id_producto);
$stmtNombreProducto->execute();
$stmtNombreProducto->bind_result($nombre_producto);
$stmtNombreProducto->fetch();
$stmtNombreProducto->close();

// Consulta para obtener el nombre del proveedor basado en el ID
$queryNombreProveedor = "SELECT Nombre_Proveedor FROM Proveedor WHERE ID_Proveedor = ?";
$stmtNombreProveedor = $CONEXION->prepare($queryNombreProveedor);
$stmtNombreProveedor->bind_param("i", $id_proveedor);
$stmtNombreProveedor->execute();
$stmtNombreProveedor->bind_result($nombre_proveedor);
$stmtNombreProveedor->fetch();
$stmtNombreProveedor->close();

// Verifica si se pudieron obtener los nombres
if (isset($nombre_producto) && isset($nombre_proveedor)) {
    // Consulta para obtener el precio, stock, fecha_caducidad y proveedor del producto
    $queryInfoProducto = "SELECT Precio, Stock, Fecha_Caducidad, Proveedor FROM Producto WHERE ID_Producto = ?";
    $stmtInfoProducto = $CONEXION->prepare($queryInfoProducto);
    $stmtInfoProducto->bind_param("i", $id_producto);
    $stmtInfoProducto->execute();
    $stmtInfoProducto->bind_result($precio_producto, $stock_producto, $fecha_caducidad_actual, $id_proveedor_actual);
    $stmtInfoProducto->fetch();
    $stmtInfoProducto->close();

    // Verifica si se pudo obtener la información del producto
    if (isset($precio_producto) && isset($stock_producto) && isset($fecha_caducidad_actual) && isset($id_proveedor_actual)) {
        // Calcula el Precio_Total multiplicando el precio del producto por la cantidad
        $precio_total = $precio_producto * $cantidad;

        // Actualiza el stock del producto sumando la cantidad recibida
        $nuevo_stock = $stock_producto + $cantidad;

        // Actualiza la fecha de caducidad y el proveedor del producto
        $nueva_fecha_caducidad = $fecha_caducidad; // Asigna la nueva fecha recibida del formulario
        $nuevo_id_proveedor = $id_proveedor; // Asigna el nuevo proveedor recibido del formulario

        // Consulta preparada para actualizar la información en la tabla Producto
        $queryActualizarProducto = "UPDATE Producto SET Stock = ?, Fecha_Caducidad = ?, Proveedor = ? WHERE ID_Producto = ?";
        $stmtActualizarProducto = $CONEXION->prepare($queryActualizarProducto);
        $stmtActualizarProducto->bind_param("issi", $nuevo_stock, $nueva_fecha_caducidad, $nuevo_id_proveedor, $id_producto);

        if ($stmtActualizarProducto->execute()) {
            // Continúa con la inserción en la tabla Compra
            $sql = "INSERT INTO Compra (Nombre_Producto, Stock, Fecha_Compra, Nombre_Proveedor, Nombre_Usuario, Precio_Total)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $CONEXION->prepare($sql);
            $stmt->bind_param("sisssd", $nombre_producto, $cantidad, $fecha_entrada, $nombre_proveedor, $id_usuario, $precio_total);

            if ($stmt->execute()) {
                header("Location: ../Entrada.php");
            } else {
                echo "Error al registrar la entrada: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al actualizar la información del producto: " . $stmtActualizarProducto->error;
        }

        $stmtActualizarProducto->close();
    } else {
        echo "Error al obtener la información del producto.";
    }
} else {
    echo "Error al obtener los nombres del producto o del proveedor.";
}

$CONEXION->close();
?>
