<?php
// Debes incluir la conexión a la base de datos aquí si aún no está incluida.
include("/xampp1/htdocs/inventorio/Php/Conexion.php");

// Consulta para obtener la lista de proveedores
$queryProveedores = "SELECT ID_Proveedor, Nombre_Proveedor FROM proveedor";
$resultProveedores = mysqli_query($CONEXION, $queryProveedores);

if ($resultProveedores->num_rows > 0) {
    while ($rowProveedor = $resultProveedores->fetch_assoc()) {
        echo '<option value="' . $rowProveedor['ID_Proveedor'] . '">' . $rowProveedor['Nombre_Proveedor'] . '</option>';
    }
} else {
    echo '<option value="">No se encontraron proveedores</option>';
}
?>
