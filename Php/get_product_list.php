<?php
// Debes incluir la conexión a la base de datos aquí si aún no está incluida.
include("/xampp1/htdocs/inventorio/Php/Conexion.php");

// Consulta para obtener la lista de productos
$queryProductos = "SELECT ID_Producto, Nombre_Producto FROM Producto";
$resultProductos = mysqli_query($CONEXION, $queryProductos);

if ($resultProductos) {
    echo '<option selected disabled>Seleccionar</option>';
    while ($rowProducto = mysqli_fetch_assoc($resultProductos)) {
        echo '<option value="' . $rowProducto['ID_Producto'] . '">' . $rowProducto['Nombre_Producto'] . '</option>';
    }
} else {
    echo '<option value="">No se encontraron productos</option>';
}

// Cierra la conexión a la base de datos al final del archivo.
$CONEXION->close();
?>
