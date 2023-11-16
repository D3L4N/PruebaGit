// Función para mostrar la imagen seleccionada
function MostrarImagenSeleccionada(input) {
    var VistaPrevia = document.getElementById('VistaPrevia');
    if (input.files && input.files[0]) {
        var Lector = new FileReader();
        Lector.onload = function(e) {
            VistaPrevia.src = e.target.result;
        };
        Lector.readAsDataURL(input.files[0]);
    } else {
        VistaPrevia.src = '<?php echo $FotoPerfil; ?>'; // Vuelve a mostrar la imagen actual si no se selecciona ninguna
    }
}

// Agrega un evento onchange al campo de entrada de archivos
var CampoFoto = document.getElementById('nfoto');
CampoFoto.addEventListener('change', function() {
    MostrarImagenSeleccionada(this);
});