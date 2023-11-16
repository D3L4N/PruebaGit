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
<html>
<head>
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="Css/Carrito.css">
</head>
<body>

<?php

// Inicializa la variable de sesión "carrito" si no existe
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para ejecutar consultas SQL preparadas de forma segura
function ejecutarConsulta($sql, $tipos = "", $parametros = []) {
    global $CONEXION;

    $stmt = $CONEXION->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $CONEXION->error);
    }

    if (!empty($parametros)) {
        $stmt->bind_param($tipos, ...$parametros);
    }

    if ($stmt->execute() === false) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    return $stmt;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar_al_carrito'])) {
        // Obtén el productoId del botón "Agregar al Carrito" que se hizo clic
        $productoId = $_POST['agregar_al_carrito'];

        // Realizar consulta para obtener el stock actual
        $sqlObtenerStock = "SELECT Stock FROM Producto WHERE ID_Producto = ?";
        $stmtObtenerStock = ejecutarConsulta($sqlObtenerStock, "i", [$productoId]);
        $stmtObtenerStock->bind_result($stockActual);
        $stmtObtenerStock->fetch();
        $stmtObtenerStock->close();

        // Verifica si hay suficiente stock y agrega el producto al carrito
        if ($stockActual > 0) {
            if (array_key_exists($productoId, $_SESSION['carrito'])) {
                $_SESSION['carrito'][$productoId]++;
            } else {
                $_SESSION['carrito'][$productoId] = 1;
            }
        }
    } elseif (isset($_POST['eliminar_del_carrito'])) {
        $productoIdAEliminar = $_POST['eliminar_del_carrito'];
        if (array_key_exists($productoIdAEliminar, $_SESSION['carrito'])) {
            unset($_SESSION['carrito'][$productoIdAEliminar]);
        }
    } elseif (isset($_POST['actualizar_carrito'])) {
        if (!empty($_POST['nueva_cantidad_carrito'])) {
            foreach ($_POST['nueva_cantidad_carrito'] as $productoId => $nuevaCantidad) {
                $nuevaCantidad = intval($nuevaCantidad);

                $sqlObtenerStock = "SELECT Stock FROM Producto WHERE ID_Producto = ?";
                $stmtObtenerStock = ejecutarConsulta($sqlObtenerStock, "i", [$productoId]);
                $stmtObtenerStock->bind_result($stockActual);
                $stmtObtenerStock->fetch();
                $stmtObtenerStock->close();

                if ($nuevaCantidad >= 0 && $nuevaCantidad <= $stockActual) {
                    $_SESSION['carrito'][$productoId] = $nuevaCantidad;
                }
            }
        }
    } elseif (isset($_POST['cancelar'])) {
        $_SESSION['carrito'] = [];
        echo "Venta cancelada. El carrito se ha vaciado.";
    } elseif (isset($_POST['pagar'])) {
        if (!empty($_SESSION['carrito'])) {
            // Array para almacenar los detalles de la venta
            $detallesVenta = [];
    
            foreach ($_SESSION['carrito'] as $productoId => $cantidad) {
                $sqlObtenerProducto = "SELECT Nombre_Producto, Precio, Stock FROM Producto WHERE ID_Producto = ?";
                $stmtObtenerProducto = ejecutarConsulta($sqlObtenerProducto, "i", [$productoId]);
                $stmtObtenerProducto->bind_result($nombreProducto, $precioProducto, $stockProducto);
                $stmtObtenerProducto->fetch();
                $stmtObtenerProducto->close();
    
                // Verificar si hay suficiente stock
                if ($cantidad <= $stockProducto) {
                    // Actualizar el stock en la base de datos
                    $nuevoStock = $stockProducto - $cantidad;
                    $sqlActualizarStock = "UPDATE Producto SET Stock = ? WHERE ID_Producto = ?";
                    ejecutarConsulta($sqlActualizarStock, "ii", [$nuevoStock, $productoId]);
    
                    // Agregar detalles de la venta al array
                    $detallesVenta[] = [
                        'nombre_producto' => $nombreProducto,
                        'cantidad' => $cantidad,
                        'precio' => $precioProducto
                    ];
                } else {
                    echo "Error: No hay suficiente stock para el producto '{$nombreProducto}'.";
                }
            }
    
            // Insertar un registro en la tabla Venta
            $fechaVenta = new DateTime('now', new DateTimeZone('America/Bogota'));
            $fechaVentaString = $fechaVenta->format('Y-m-d H:i:s');
            $nombreUsuario = $_SESSION['Usuario'];

            foreach ($detallesVenta as $detalle) {
                $precioTotal = $detalle['cantidad'] * $detalle['precio'];  // Calcular precio total por producto

                $sqlInsertarVenta = "INSERT INTO Venta (Nombre_Producto, Stock, Fecha_Venta, Nombre_Usuario, Precio)
                                    VALUES (?, ?, ?, ?, ?)";
                ejecutarConsulta($sqlInsertarVenta, "ssssd", [
                    $detalle['nombre_producto'],  // Nombre del producto
                    $detalle['cantidad'],          // Cantidad (Stock)
                    $fechaVentaString,             // Fecha de la venta en Bogotá
                    $nombreUsuario,                // Nombre del usuario
                    $precioTotal                   // Precio total por producto
                ]);
                
            }
    
            // Vaciar el carrito después de completar la venta
            $_SESSION['carrito'] = [];
    
            echo "Pago procesado. El carrito se ha vaciado y el stock se ha actualizado.";
        } else {
            echo "El carrito está vacío. No se puede procesar el pago.";
        }
    }
    
}

$sqlProductos = "SELECT * FROM Producto";
$resultProductos = $CONEXION->query($sqlProductos);

if ($resultProductos->num_rows > 0) {
    ?>
    <div class="product-list">
        <h2>Lista de Productos</h2>
        <form method="post">
            <?php while ($rowProducto = $resultProductos->fetch_assoc()) {
                $productoId = $rowProducto['ID_Producto'];
                $productoNombre = $rowProducto['Nombre_Producto'];
                ?>
                <div class="product-card">
                    <img src="<?= $rowProducto['Imagen_Producto'] ?>" class="product-image" width="60px">
                    <div class="product-name"><?= $productoNombre ?></div>
                    <div class="product-info">
                        <p><strong>Precio de Venta:</strong> $<?= number_format($rowProducto['Precio'], 0) ?> COP</p>
                        <p><strong>Stock Actual:</strong> <?= $rowProducto['Stock'] ?></p>
                        <p><strong>Fecha de Caducidad:</strong> <?= $rowProducto['Fecha_Caducidad'] ?></p>
                        <form method="post">
                            <input type="hidden" name="agregar_al_carrito" value="<?= $productoId ?>">
                            <button type="submit">Agregar al Carrito</button>
                        </form>
                    </div>
                    
                </div>
            <?php } ?>
        </form>
        <h1>Fin lista</h1>
    </div>
<?php } else {
    echo 'No se encontraron productos.';
}
?>

<div id="carrito">
    <h3>Carrito de Compras</h3>
    <form method="post">
        <ul id="lista-carrito">
            <?php
            $total = 0;
            // Verifica si "carrito" está definido y es un array antes de usarlo en un bucle foreach
            if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $productoId => $cantidad) {
                    $sqlObtenerProducto = "SELECT Nombre_Producto, Precio, Stock FROM Producto WHERE ID_Producto = ?";
                    $stmtObtenerProducto = ejecutarConsulta($sqlObtenerProducto, "i", [$productoId]);
                    $stmtObtenerProducto->bind_result($nombreProducto, $precioProducto, $stockProducto);
                    $stmtObtenerProducto->fetch();
                    $stmtObtenerProducto->close();
                    ?>
                    <li>
                        <table border="1">
                                <tr>
                                    <td><?= $nombreProducto ?></td>
                                    <td> Cantidad:<input type="number" name="nueva_cantidad_carrito[<?= $productoId ?>]" value="<?= $cantidad ?>" min="1" max="<?= $stockProducto ?>"></td>
                                    <td>$<?= number_format($precioProducto * $cantidad, 0) ?> COP</td>
                                    <td> <button type="submit" name="eliminar_del_carrito" value="<?= $productoId ?>">Eliminar</button></td>
                                </tr>
                        </table>
                    </li>
                    <?php
                    $subtotal = $precioProducto * $cantidad;
                    $total += $subtotal;
                }
            } else {
                echo "El carrito está vacío.";
            }
            ?>
        </ul>
        <p>Total: $<span id="total"><?= number_format($total, 0) ?> COP</span></p>
        <input type="submit" name="actualizar_carrito" value="Actualizar Carrito">
        <input type="submit" name="cancelar" value="Cancelar Venta">
        <!-- Botón de "Pagar" -->
        <input type="submit" name="Relizar_Orden" value="Realizar orden" id="orden-button">

        <?php
        // Obtener la información del usuario de la sesión (esto es un ejemplo, asegúrate de tener la información real del usuario)
        $nombreUsuario = $_SESSION['Usuario'];

        // Obtener los detalles de la compra (asumiendo que tienes una función para obtenerlos)
        $detallesCompra = obtenerDetallesCompra();

        // Mostrar la página de orden
        if (isset($_POST['Relizar_Orden'])) {
            ?>
            <!-- Página de Orden -->
            <div id="pagina-orden">
                <h2>Resumen de la Orden</h2>
                <h3>Información del Usuario</h3>
                <p><strong>USUARIO:</strong> <?= $nombreUsuario ?></p>
                <h3>Detalles de la Compra</h3>
                <ul>
                <?php
                foreach ($detallesCompra as $detalle) {
                    $precioTotalProducto = $detalle['cantidad'] * $detalle['precio'];
                    echo "<li>{$detalle['nombre_producto']} - Stock: {$detalle['cantidad']} - Precio total: {$precioTotalProducto} COP</li>";
                }
                ?>
                </ul>
                <h3>Total de la Compra</h3>
                <p>$<?= calcularTotalCompra($detallesCompra) ?> COP</p>
                <h3>Fecha de la Compra</h3>
                <?php
                $fechaHoraBogota = new DateTime("now", new DateTimeZone("America/Bogota"));
                echo "<p>" . $fechaHoraBogota->format("Y-m-d H:i:s") . "</p>";
                ?>
                <button type="submit" name="pagar" id="pagar-button">Pagar</button>
            </div>
            <?php
        } else {
            echo "";
        }

        function obtenerDetallesCompra() {
            $detalles = [];

            // Verifica si "carrito" está definido y es un array antes de usarlo en un bucle foreach
            if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $productoId => $cantidad) {
                    $sqlObtenerProducto = "SELECT Nombre_Producto, Precio FROM Producto WHERE ID_Producto = ?";
                    $stmtObtenerProducto = ejecutarConsulta($sqlObtenerProducto, "i", [$productoId]);
                    $stmtObtenerProducto->bind_result($nombreProducto, $precioProducto);
                    $stmtObtenerProducto->fetch();
                    $stmtObtenerProducto->close();

                    $detalles[] = [
                        'nombre_producto' => $nombreProducto,
                        'cantidad' => $cantidad,
                        'precio' => $precioProducto
                    ];
                }
            }

            return $detalles;
        }

        function calcularTotalCompra($detalles) {
            $total = 0;

            foreach ($detalles as $detalle) {
                $total += $detalle['cantidad'] * $detalle['precio'];
            }

            return $total;
        }

        ?>
    </form>
</div>

<?php
$CONEXION->close();
?>

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




