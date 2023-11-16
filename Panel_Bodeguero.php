<?php
session_start();

if ($_SESSION['Rol_Usuario'] == 'Bodeguero') {
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
    <title>Panel Bodeguero</title>
    <link rel="stylesheet" href="Css/Panel_Administrador.css">
    <link rel="icon" href="Icons/StarInventory.ico"> 
</head>
<body>
<!-- ===== MENÚ ADMINISTRADOR ===== -->
<?php include("Menus/Menu_Bodeguero.php")?>

<!-- ===== Cards ===== -->
<section>
    <div class="row_T">
        <?php echo "<center><h1> Bienvenido Usuario " . $_SESSION['Usuario'] . " <img src='Icons/verificado.png' width='18px' alt='Verificado'></h1></center>"; ?>
    </div>
    <div class="row">
        
        <div class="column">
            <a href="Crud.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('producto'); ?></h3>
                <h3>Productos</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('proveedor'); ?></h3>
                <h3>Proveedores</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('categoria'); ?></h3>
                <h3>Categorias</h3>
            </div></a>
        </div>
        <div class="column">
            <a href="Crud.php"><div class="card">
                <div class="icon-wrapper">
                icon
                </div>
                <h3><?php echo getCount('subcategoria'); ?></h3>
                <h3>Subcategorias</h3>
            </div></a>
        </div>
        
    </div>
</section>
</body>
</html>
<?php
} else {
    header("Location: ../Index.php");
}
?>
