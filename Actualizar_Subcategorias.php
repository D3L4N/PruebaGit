<?php 
    include("./Php/Conexion.php");

    $id = $_GET['ID_Subcategoria'];

    $sql = "SELECT * FROM subcategoria WHERE ID_Subcategoria='$id'";
    $query = mysqli_query($CONEXION, $sql);

    $row = mysqli_fetch_array($query);

    // Consulta y generación de opciones para categorías
    $queryCategorias = "SELECT ID_Categoria, Nombre_Categoria FROM Categoria";
    $resultCategorias = mysqli_query($CONEXION, $queryCategorias);

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>StarInventory - Editar sub </title>
        <!-- ======Estilos======= -->
        <link href="Css/Edits.css" rel="stylesheet">
        <link rel="icon" href="Imagenes/StarInventory.ico">
    </head>
    <body>

        
    </body>
</html>
<?php
include("Php/Conexion.php");

// Inicia la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si se proporciona un ID de usuario a través de la URL
if (isset($_GET['ID_Subcategoria'])) {
    $id = $_GET['ID_Subcategoria'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT * FROM subcategoria WHERE ID_Subcategoria='$id'";
    $query = mysqli_query($CONEXION, $sql);
    $row = mysqli_fetch_array($query);

    if ($row) { // Verifica si se encontraron datos del usuario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StarInventory - Editar usuarios</title>
    <!-- Estilos -->
    <link href="Css/Edits.css" rel="stylesheet">
    <link rel="stylesheet" href="Css/Alerts.css">
    <link rel="icon" href="Icons/StarInventory.ico">
</head>
<body>
    <?php
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
?>
<div class="Contenedor_login">
        <h1>ACTUALIZAR DATOS</h1>
        <form action="Php/Editar_Subcategorias.php" method="POST" enctype="multipart/form-data">
            <div class="input_login">
                <input type="hidden" name="ID" value="<?= $row['ID_Subcategoria']?>">
            </div>
            <div class="input_login">
                <input type="text" name="Nombre" value="<?= $row['Nombre_Subcategoria']?>">
            </div>
            <div class="select">
                <label for="Categoria">Categoría:</label>
                <select name="Categoria" id="Categoria">
                    <option selected disabled>Seleccionar</option>
                    <?php
                    // Recorrer la lista de categorías y generar las opciones
                    while ($categoriaRow = mysqli_fetch_assoc($resultCategorias)) {
                        $selected = ($categoriaRow['ID_Categoria'] == $row['Categoria']) ? 'selected' : '';
                        echo '<option value="' . $categoriaRow['ID_Categoria'] . '" ' . $selected . '>' . $categoriaRow['Nombre_Categoria'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button class="btn_login" name="Enviar">Enviar</button>
        </form>
    </div>
<?php
            require("Php/Conexion.php");
        } else {
            header("Location: Index.php");
        }
    } else {
        header("Location: Index.php");
    }
?>
</body>
</html>

<?php
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
<body>
</body>
</html>




