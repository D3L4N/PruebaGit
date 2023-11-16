<?php
session_start();

if ($_SESSION['Rol_Usuario'] == 'Administrador') {
    include('Php/Conexion.php');
    
    // Función para obtener el conteo de registros en una tabla
    function getCount($table) {
        global $CONEXION;
        $sql = "SELECT COUNT(*) AS total FROM `$table`";
        $result = $CONEXION->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["total"];
        }
        return 0;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="Icons/StarInventory.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
    <script src="Js/Alerts.js" defer></script>
    <link rel="stylesheet" href="Css/Alerts.css" />
    <link rel="stylesheet" href="Css/Panel_Administrador.css">
</head>
<body>
<!-- ===== MENÚ ADMINISTRADOR ===== -->
<?php include("Menus/Menu_Administrador.php")?>

<!-- ===== Cards ===== -->
<section>
    <div class="row_T">
        <?php echo "<center><h1> Bienvenido Usuario " . $_SESSION['Usuario'] . " <img src='Icons/verificado.png' width='18px' alt='Verificado'></h1></center>"; ?>
    </div>
    <div class="row">
        <div class="column">
            <a href="Crud_Usuarios.php"><div class="card">
                <div class="icon-wrapper">
                    icon
                </div>
                <h3><?php echo getCount('usuario'); ?></h3>
                <h3>Usuarios</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud_Productos.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('producto'); ?></h3>
                <h3>Productos</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud_Proveedores.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('proveedor'); ?></h3>
                <h3>Proveedores</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud_Categorias.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('categoria'); ?></h3>
                <h3>Categorias</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud_Subcategorias.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('subcategoria'); ?></h3>
                <h3>Subcategorias</h3>
            </div></a>
        </div>
        
    </div>
</section>
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
?>

<?php
include("Alerts_Productos.Php")
?>