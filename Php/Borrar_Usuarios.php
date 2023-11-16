<?php
include("../Php/Conexion.php");

$id = $_GET["ID_Usuario"];

$sql = "DELETE FROM usuario WHERE ID_Usuario='$id'";
$query = mysqli_query($CONEXION, $sql);

if ($query) {
    header("Location: ../Crud_Usuarios.php?eliminacion=exitosa");
} else {
    header("Location: ../Crud_Usuarios.php?eliminacion=fallida");
}
?>
