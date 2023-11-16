<?php
include("/xampp1/htdocs/inventorio/Php/Conexion.php");

// Verificar si se envió un término de búsqueda
if (isset($_GET['q'])) {
    $term = $_GET['q'];

    // Inicializar un array para almacenar los resultados
    $resultados = array();

    // Solo realizar búsquedas si el término de búsqueda no está vacío
    if (!empty($term)) {
        // Consulta SQL para buscar en la tabla Usuarios
        $sqlUsuarios = "SELECT * FROM Usuario WHERE (Nombre LIKE '%$term%' OR Apellido LIKE '%$term%' OR Usuario LIKE '%$term%') AND (Nombre IS NOT NULL AND Apellido IS NOT NULL AND Usuario IS NOT NULL)";
        $resultUsuarios = $CONEXION->query($sqlUsuarios);

        // Consulta SQL para buscar en la tabla Proveedores
        $sqlProveedores = "SELECT * FROM Proveedor WHERE (Nombre_Proveedor LIKE '%$term%') AND (Nombre_Proveedor IS NOT NULL)";
        $resultProveedores = $CONEXION->query($sqlProveedores);

        // Consulta SQL para buscar en la tabla Productos
        $sqlProductos = "SELECT * FROM Producto WHERE (Nombre_Producto LIKE '%$term%') AND (Nombre_Producto IS NOT NULL)";
        $resultProductos = $CONEXION->query($sqlProductos);

        // Consulta SQL para buscar en la tabla Categorias
        $sqlCategorias = "SELECT * FROM Categoria WHERE (Nombre_Categoria LIKE '%$term%') AND (Nombre_Categoria IS NOT NULL)";
        $resultCategorias = $CONEXION->query($sqlCategorias);

        // Consulta SQL para buscar en la tabla Subcategorias
        $sqlSubcategorias = "SELECT * FROM Subcategoria WHERE (Nombre_Subcategoria LIKE '%$term%') AND (Nombre_Subcategoria IS NOT NULL)";
        $resultSubcategorias = $CONEXION->query($sqlSubcategorias);

        // Almacenar los resultados en el array
        while ($row = $resultUsuarios->fetch_assoc()) {
            $resultados[] = "<b>Usuario:</b> " . $row["Usuario"];
        }

        while ($row = $resultProveedores->fetch_assoc()) {
            $resultados[] = "<b>Proveedor:</b> " . $row["Nombre_Proveedor"];
        }

        while ($row = $resultProductos->fetch_assoc()) {
            $resultados[] = "<b>Producto:</b> " . $row["Nombre_Producto"];
        }

        while ($row = $resultCategorias->fetch_assoc()) {
            $resultados[] = "<b>Categoría:</b> " . $row["Nombre_Categoria"];
        }

        while ($row = $resultSubcategorias->fetch_assoc()) {
            $resultados[] = "<b>Subcategoría:</b> " . $row["Nombre_Subcategoria"];
        }
    }

    // Mostrar los resultados en un solo mensaje
    if (!empty($resultados)) {
        $mensaje = "" . implode("<br>", $resultados);
        echo $mensaje;
    } else {
        echo "<b>No se encontraron resultados.</b>";
    }
}
?>
