<?php
include("../Php/Conexion.php");

$id = $_GET["ID_Producto"];

$sql = "DELETE FROM productos WHERE ID_Producto='$id'";
$query = mysqli_query($CONEXION, $sql);

if ($query) {
    header("Location: Crud copy.php?eliminacion=exitosa");
} else {
    header("Location: Crud copy.php?eliminacion=fallida");
}
?>
