<?php
// Inicia la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Asegúrate de que exista la sesión y el rol de usuario
if (isset($_SESSION['Rol_Usuario'])) {
    // Define el directorio de los archivos de menú
    $menuDirectory = "Menus/";

    // Define un array asociativo que mapea roles a archivos de menú
    $menuFiles = [
        'Administrador' => 'Menu_Administrador.php',
        'Cajero' => 'Menu_Cajero.php',
        'Bodeguero' => 'Menu_Bodeguero.php',
    ];

    // Verifica si el rol del usuario está en el array de menú
    if (array_key_exists($_SESSION['Rol_Usuario'], $menuFiles)) {
        // Incluye el archivo de menú correspondiente
        require($menuDirectory . $menuFiles[$_SESSION['Rol_Usuario']]);
        require("Php/Conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Productos</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="Css/Alerts.css" />
    <link rel="stylesheet" href="Css/Registros.css">
    <script src="Js/Alerts.js" defer></script>
     <!-- Iconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="Icons/StarInventory.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
</head>
<body>
<?php
    // Incluir el script de registro de productos
    include("Php/Registrar_Producto.php");
?>
<div class="Contenedor_login">
    <h1>REGISTRO DE PRODUCTOS</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="input_login">
            <input type="text" name="Nombre" placeholder="Nombre">
            <img src="Imagenes/Gato.ico" width="35px" alt="Icono de Nombre">
        </div>
        <div class="input_login">
            <input type="number" name="Precio" placeholder="Precio de Compra">
            <img src="Imagenes/Face.ico" width="35px" alt="Icono de Usuario">
        </div>
        <div class="select">
            <label for="Categoria">Categoría:</label>
            <select name="Categoria" id="Categoria">
                <option selected disabled>Seleccionar</option>
                <?php
                // Recorrer la lista de categorías y generar las opciones
                while ($row = mysqli_fetch_assoc($resultCategorias)) {
                    echo '<option value="' . $row['ID_Categoria'] . '">' . $row['Nombre_Categoria'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="select">
            <label for="Subcategoria">Subcategoría:</label>
            <select name="Subcategoria" id="Subcategoria">
                <option selected disabled>Seleccionar</option> 
                <?php
                // Recorrer la lista de subcategorías y generar las opciones
                while ($row = mysqli_fetch_assoc($resultSubcategorias)) {
                    echo '<option value="' . $row['ID_Subcategoria'] . '" data-categoria="' . $row['ID_Categoria'] . '">' . $row['Nombre_Subcategoria'] . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Incluir el archivo JavaScript para subcategorías -->
        <script src="js/Subcategoria.js"></script>
        <div class="input_container">
            <label for="files" class="btn" name="foto">
                Seleccionar una imagen producto
                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                <lord-icon
                    src="https://cdn.lordicon.com/mxddzdmt.json"
                    trigger="loop"
                    colors="outline:#121331,primary:#3a3347,secondary:#646e78,quaternary:#08a88a,quinary:#ffc738,senary:#ebe6ef"
                    style="width:60px;height:60px">
                </lord-icon>
            </label>
            <input id="files" style="display:none;" type="file" name="foto">
        </div>
        <button class="btn_login" name="Enviar">Enviar</button>
    </form>
</div>
<div class="contenedor">
    <div class="hero">
        <div class="contenedor-botones" id="contenedor-botones"></div>
    </div>
    <div class="contenedor-toast" id="contenedor-toast"></div>
</div>
</body>
</html>
<?php
    } else {
        header("Location: Index.php");
    }
} else {
    header("Location: Index.php");
}
?>
<?php
include("Alerts_Productos.Php")
?>
