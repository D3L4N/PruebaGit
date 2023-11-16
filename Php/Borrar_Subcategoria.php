<?php
include("../Php/Conexion.php");

$id = $_GET["ID_Subcategoria"];

// Deshabilitar temporalmente las restricciones de clave externa
mysqli_query($CONEXION, "SET foreign_key_checks = 0");

// Eliminar la subcategoría
$sqlDeleteSubcategoria = "DELETE FROM subcategoria WHERE ID_Subcategoria='$id'";
$queryDeleteSubcategoria = mysqli_query($CONEXION, $sqlDeleteSubcategoria);

// Actualizar la columna Subcategoria a NULL en la tabla Producto
$sqlUpdateProducto = "UPDATE producto SET Subcategoria=NULL WHERE Subcategoria='$id'";
$queryUpdateProducto = mysqli_query($CONEXION, $sqlUpdateProducto);

// Volver a habilitar las restricciones de clave externa
mysqli_query($CONEXION, "SET foreign_key_checks = 1");

if ($queryDeleteSubcategoria && $queryUpdateProducto) {
    header("Location: ../Crud_Subcategorias.php?eliminacion=exitosa");
} else {
    header("Location: ../Crud_Subcategorias.php?eliminacion=fallida");
}
?>
