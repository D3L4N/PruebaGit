<?php
include("./Php/Conexion.php");

if (isset($_POST['Enviar'])) {
    $nombre = $_POST['Nombre_Categoria'];

    if (strlen($nombre) >= 1) {
        // Verificar si la categoría ya existe
        $stmtVerificacion = mysqli_prepare($CONEXION, "SELECT ID_Categoria FROM categoria WHERE Nombre_Categoria = ?");
        mysqli_stmt_bind_param($stmtVerificacion, "s", $nombre);
        mysqli_stmt_execute($stmtVerificacion);
        mysqli_stmt_store_result($stmtVerificacion);

        if (mysqli_stmt_num_rows($stmtVerificacion) > 0) {
            // La categoría ya existe, manejar el caso si es necesario
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    agregarToast({
                        tipo: 'error',
                        titulo: 'ERROR',
                        descripcion: 'La categoría ya existe.',
                        autoCierre: true
                    });
                });
            </script>
            <?php
        } else {
            // Insertar el nuevo usuario en la base de datos
            $stmt = mysqli_prepare($CONEXION, "INSERT INTO categoria (Nombre_Categoria) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $nombre);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    agregarToast({
                        tipo: 'exito',
                        titulo: 'EXITO',
                        descripcion: 'Categoría registrada exitosamente.',
                        autoCierre: true
                    });
                });
            </script>
            <?php
        }
        mysqli_stmt_close($stmtVerificacion);
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
?>
