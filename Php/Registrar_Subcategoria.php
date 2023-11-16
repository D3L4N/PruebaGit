<?php

if (!$CONEXION) {
    die("Connection failed: " . mysqli_connect_error());
}

$NOMBRE = "";
$CATEGORIA = "";

if (isset($_POST['Enviar'])) {
    // Sanitizar y validar las entradas
    $NOMBRE = mysqli_real_escape_string($CONEXION, $_POST['Nombre']);
    $CATEGORIA = mysqli_real_escape_string($CONEXION, $_POST['Categoria']);

    if (strlen($NOMBRE) >= 1 && strlen($CATEGORIA) >= 1) {
        // Preparar la consulta SQL usando una declaración preparada
        $stmt = mysqli_prepare($CONEXION, "INSERT INTO subcategoria (Nombre_Subcategoria, ID_Categoria) VALUES (?, ?)");

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ss", $NOMBRE, $CATEGORIA);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);

        // No cierres la conexión aquí, hazlo después de todas las operaciones necesarias

        ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Asegúrate de que la función agregarToast esté definida
                agregarToast({
                    tipo: 'exito',
                    titulo: 'ÉXITO',
                    descripcion: 'Subcategoría registrada exitosamente.',
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

// Consulta para obtener las categorías
$queryCategorias = "SELECT ID_Categoria, Nombre_Categoria FROM Categoria";
$resultCategorias = mysqli_query($CONEXION, $queryCategorias);

?>
