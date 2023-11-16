<?php
include("Php/Conexion.php");
// Consulta para productos con bajo stock
$stock_query = "SELECT * FROM Producto WHERE Stock < 10";
$stock_result = $CONEXION->query($stock_query);

if ($stock_result->num_rows > 0) {
    echo "<script>";
    echo "document.addEventListener('DOMContentLoaded', () => {";

    while ($row = $stock_result->fetch_assoc()) {
        echo "agregarToast({";
        echo "tipo: 'warning',";
        echo "titulo: 'Alerta de Stock',";
        echo "descripcion: '<b>Producto:</b> " . $row["Nombre_Producto"] . "<br><b>Stock:</b> " . $row["Stock"] . "',";
        echo "autoCierre: false";
        echo "});";
    }

    echo "});";
    echo "</script>";
}

// Consulta para productos próximos a la fecha de caducidad (en los próximos 7 días)
$caducity_query = "SELECT * FROM Producto WHERE Fecha_Caducidad BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY";
$caducity_result = $CONEXION->query($caducity_query);

if ($caducity_result->num_rows > 0) {
    echo "<script>";
    echo "document.addEventListener('DOMContentLoaded', () => {";

    while ($row = $caducity_result->fetch_assoc()) {
        echo "agregarToast({";
        echo "tipo: 'info',";
        echo "titulo: 'Alerta de Caducidad',";
        echo "descripcion: '<b>Producto:</b> " . $row["Nombre_Producto"] . "<br><b>Fecha de Caducidad:</b> " . $row["Fecha_Caducidad"] . "',";
        echo "autoCierre: false";
        echo "});";
    }

    echo "});";
    echo "</script>";
}
// Cerrar la conexión a la base de datos
$CONEXION->close();
?>
<br><b></b>