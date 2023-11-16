document.addEventListener('DOMContentLoaded', function () {
    var categoriaSelect = document.getElementById('Categoria');
    var subcategoriaSelect = document.getElementById('Subcategoria');
    
    // Función para mostrar u ocultar las opciones de subcategoría según la categoría seleccionada
    function actualizarSubcategorias() {
        var categoriaSeleccionada = categoriaSelect.value;
        
        // Mostrar u ocultar opciones de subcategoría según la categoría seleccionada
        var opcionesSubcategoria = subcategoriaSelect.querySelectorAll('option');
        opcionesSubcategoria.forEach(function (opcion) {
            opcion.style.display = (opcion.dataset.categoria === categoriaSeleccionada || opcion.dataset.categoria === "") ? 'block' : 'none';
        });
        
        // Restablecer el campo de selección de subcategoría
        subcategoriaSelect.value = '';
    }
    
    // Escuchar el cambio en la categoría seleccionada
    categoriaSelect.addEventListener('change', actualizarSubcategorias);
    
    // Inicialmente, ocultar todas las subcategorías excepto "Seleccionar"
    actualizarSubcategorias();
});