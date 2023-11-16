<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Entrada de Productos</title>
</head>
<body>
    <?php include("Menu_Administrador.php"); ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <h2>Formulario de Entrada de Productos</h2>
    <form method="post" action="Php/insertar_entrada.php">
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
        <input type="number" name="cantidad" max="50" required><br><br>

        <div class="select">
            <label for="fecha_caducidad">Fecha de Caducidad:</label>
            <input type="date" name="fecha_caducidad" required>
        </div><br><br>

        <div class="select">
            <label for="proveedor">Proveedor:</label>
            <select name="proveedor" required>
                <option selected disabled>Seleccionar</option>
                <?php
                // Lógica para obtener y mostrar la lista de proveedores
                include("Php/get_supplier_list.php");
                ?>
            </select>
        </div><br><br>

        <input type="submit" value="Registrar Entrada">
    </form>
</body>
</html>
