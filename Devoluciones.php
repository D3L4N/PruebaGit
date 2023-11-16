<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Devolución de Productos</title>
    <style>
        /* Agrega estilos CSS aquí */
    </style>
</head>
<body>
    <?php include("Menu_Administrador.php"); ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <h2>Formulario de Devolución de Productos</h2>

    <form method="post" action="Php/insertar_devolucion.php">
        <?php    
        if (isset($_SESSION['Usuario'])) {
            $nombreUsuario = $_SESSION['Usuario'];
            echo '<p>Bienvenido, ' . $nombreUsuario . '</p>';
            // Incluye el campo oculto "usuario" en el formulario
            echo '<input type="hidden" name="usuario" value="' . $nombreUsuario . '">';
        }
        ?>
        <div class="select">
            <label for="producto">Producto:</label>
            <select name="producto" id="producto" required>
    <option selected disabled>Seleccionar</option>
    <?php
    // Lógica para obtener y mostrar la lista de productos
    include("Php/get_product_list.php");
    ?>
</select>
        </div>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required><br><br>

        <div class="select">
            <label for="motivo">Motivo:</label>
            <input type="text" name="motivo" required>
        </div><br><br>

        <input type="submit" value="Registrar Devolución">
    </form>
</body>
</html>
