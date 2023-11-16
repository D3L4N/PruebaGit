<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['Rol_Usuario']) && $_SESSION['Rol_Usuario'] === 'Cajero') {
    include 'Php/Conexion.php';
    $id = mysqli_real_escape_string($CONEXION, $_SESSION['Usuario']);
    $consulta = mysqli_query($CONEXION, "SELECT * FROM usuario WHERE Usuario = '$id';");

    if ($consulta) {
        $valores = mysqli_fetch_array($consulta);
        $foto = $valores['Foto_Perfil'];
    } else {
        echo "Error en la consulta: " . mysqli_error($CONEXION);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Css/Menu_Cajero.css">
    <link rel="icon" href="Icons/StarInventory.ico">
</head>
<body>
    <header>
        <div class="container__menu">
            <div class="menu">
                <input type="checkbox" id="check__menu">
                <label for="check__menu" id="label__check">
                    <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                    <lord-icon
                        src="https://cdn.lordicon.com/dfjljsxr.json"
                        trigger="click"
                        colors="outline:#121331,primary:#ebe6ef"
                        style="width:60px;height:70px">
                    </lord-icon>
                </label>
                <nav class="nav">
                    <ul>
                        <li><a href="Panel_Cajero.php" id="selected"></a></li>
                        <li><a href="#">Productos</a>
                            <ul>
                                <li><a href="Venta_Producto.php">Vender</a></li>
                                <li><a href="Registro_Producto.php">Registrar</a></li>
                                <li><a href="Crud_Productos.php">Administrar</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Proveedores</a>
                            <ul>
                                <li><a href="Registro_Proveedor.php">Registrar</a></li>
                                <li><a href="Crud_Proveedores.php">Administrar</a></li>
                                <li><a href="Entrada.php">Pedidos</a></li>
                                <li><a href="Devoluciones.php">Devoluciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Categorías</a>
                            <ul>
                                <li><a href="Registro_Categoria.php">Registrar</a></li>
                                <li><a href="Crud_Categorias.php">Administrar</a></li>
                            </ul>
                        </li>
                        <li><a href="#">SubCategorías</a>
                            <ul>
                                <li><a href="Registro_Subcategoria.php">Registrar</a></li>
                                <li><a href="Crud_Subcategorias.php">Administrar</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="header__superior">
            <div id='search-box'>
                <form action='Php/buscar.php' id='search-form' method='get' target='_top'>
                <input id='search-text' name='q' placeholder='Buscar' type='text'/>
                <button id='search-button' type='submit'><span>Buscar</span></button>
                </form>
            </div>
            <div id="search-results" class="popover">
                <script src="Js/Buscar.js"></script>
            </div>
            <nav class="nav1">
                <ul>
                    <li>
                        <a href="#">
                            <img class="perfil_foto" src="<?php echo $foto; ?>" width="50px" height="50px" alt="Foto Perfil">
                        </a>
                        <ul>
                            <li><a href="Visualizar_Perfil.php">Pefil</a></li>
                            <li><a href="Php/Cerrar.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>

<?php
} else {
    header("Location: Index.php");
    exit;
}
?>




