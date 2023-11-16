<?php
include("../Php/Conexion.php");

$id = $_GET["ID_Categoria"];

// Obtén los IDs de productos asociados a la categoría
$sqlObtenerProductos = "SELECT ID_Producto FROM Producto WHERE Categoria='$id' OR Subcategoria IN (SELECT ID_Subcategoria FROM Subcategoria WHERE ID_Categoria='$id')";
$queryObtenerProductos = mysqli_query($CONEXION, $sqlObtenerProductos);

// Elimina las relaciones de productos con la categoría y subcategorías
if ($queryObtenerProductos) {
    while ($row = mysqli_fetch_assoc($queryObtenerProductos)) {
        $productoID = $row['ID_Producto'];
        $sqlActualizarProductos = "UPDATE Producto SET Categoria=NULL, Subcategoria=NULL WHERE ID_Producto='$productoID'";
        $queryActualizarProductos = mysqli_query($CONEXION, $sqlActualizarProductos);

        if (!$queryActualizarProductos) {
            // Manejar el error si la actualización falla
            header("Location: ../Crud_Categorias.php?eliminacion=fallida");
            exit();
        }
    }
} else {
    // Manejar el error si la consulta falla
    header("Location: ../Crud_Categorias.php?eliminacion=fallida");
    exit();
}

// Eliminar las subcategorías
$sqlEliminarSubcategorias = "DELETE FROM Subcategoria WHERE ID_Categoria='$id'";
$queryEliminarSubcategorias = mysqli_query($CONEXION, $sqlEliminarSubcategorias);

// Eliminar la categoría principal
$sqlEliminarCategoria = "DELETE FROM Categoria WHERE ID_Categoria='$id'";
$queryEliminarCategoria = mysqli_query($CONEXION, $sqlEliminarCategoria);

if ($queryEliminarCategoria && $queryEliminarSubcategorias) {
    header("Location: ../Crud_Categorias.php?eliminacion=exitosa");
} else {
    // Manejar el error si la eliminación falla
    header("Location: ../Crud_Categorias.php?eliminacion=fallida");
}
?>
