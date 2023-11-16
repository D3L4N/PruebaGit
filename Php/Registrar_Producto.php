<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Productos</title>
</head>
<body>

<?php
error_reporting(0);
$NOMBRE = "";
$CADUCIDAD = NULL;
$PRECIO = "";
$PROVEEDOR = NULL;
$CATEGORIA = "";
$SUBCATEGORIA = "";
$STOCK_ACTUAL = NULL;
$IMAGEN_PRODUCTO = "";

if (isset($_POST['Enviar'])) {
    $NOMBRE = $_POST['Nombre'];
    $PRECIO = $_POST['Precio'];
    $CATEGORIA = $_POST['Categoria'];
    $SUBCATEGORIA = $_POST['Subcategoria'];

    if (
        strlen($NOMBRE) >= 1 &&
        strlen($PRECIO) >= 1 &&
        strlen($CATEGORIA) >= 1 &&
        strlen($SUBCATEGORIA) >= 1
    ) {
        
        $FOTO = $_FILES['foto'];
        $img_file = $FOTO['name'];
        $img_type = $FOTO['type'];

        $directorio_destino = "Imagen_Producto";  // Ruta relativa al directorio actual (Php)
        $destino = $directorio_destino . '/' . basename($img_file);

        $allowed_image_types = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($img_type, $allowed_image_types) && move_uploaded_file($FOTO['tmp_name'], $destino)) {
            $IMAGEN_PRODUCTO = 'Imagen_Producto/' . basename($img_file);
        } else {
            // Manejar el error de carga de archivos
        }
        $stmt = mysqli_prepare($CONEXION, "INSERT INTO producto (Nombre_Producto, Precio, Categoria, Subcategoria, Imagen_Producto) 
                                          VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $NOMBRE, $PRECIO, $CATEGORIA, $SUBCATEGORIA, $IMAGEN_PRODUCTO);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_close($CONEXION);

        ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                agregarToast({
                    tipo: 'exito',
                    titulo: 'EXITO',
                    descripcion: 'Producto Registrado Exitosamente.',
                    autoCierre: true
                });
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                agregarToast({
                    tipo: 'error',
                    titulo: 'ERROR',
                    descripcion: 'Llene todos los campos.',
                    autoCierre: true
                });
            });
        </script>
        <?php
    }
}
?>
<?php
$queryCategorias = "SELECT ID_Categoria, Nombre_Categoria FROM Categoria";
$resultCategorias = mysqli_query($CONEXION, $queryCategorias);

$querySubcategorias = "SELECT ID_Subcategoria, Nombre_Subcategoria, ID_Categoria FROM Subcategoria";
$resultSubcategorias = mysqli_query($CONEXION, $querySubcategorias);
?>
</body>
</html>
