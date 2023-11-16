document.addEventListener('DOMContentLoaded', function() {
    // Agrega un evento de clic a todos los botones "Agregar al Carrito"
    var agregarCarritoButtons = document.querySelectorAll('.agregar-carrito');
    agregarCarritoButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var productoId = event.target.getAttribute('data-productid');
            
            // Envía una solicitud al servidor para agregar el producto al carrito
            // Puedes usar JavaScript para enviar una solicitud POST al servidor con el productoId
            // y luego actualizar la vista del carrito en el navegador
            // Puedes usar Fetch API o XMLHttpRequest para hacer la solicitud al servidor.

            // Ejemplo usando Fetch API (debes adaptar tu servidor para manejar esta solicitud):
            fetch('/ruta_al_servidor/agregar_al_carrito.php', {
                method: 'POST',
                body: JSON.stringify({ productoId: productoId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(function(response) {
                if (response.ok) {
                    return response.json();
                }
            })
            .then(function(data) {
                // Maneja la respuesta del servidor, actualiza la vista del carrito si es necesario
                // Puedes mostrar un mensaje al usuario para confirmar que el producto se ha agregado al carrito
                console.log('Producto agregado al carrito:', data);
            })
            .catch(function(error) {
                console.error('Error al agregar al carrito:', error);
            });
        });
    });
});

document.querySelectorAll('.agregar-carrito').forEach(button => {
    button.addEventListener('click', function() {
        const productoId = this.getAttribute('data-productid');
        // Realiza una solicitud AJAX para agregar el producto al carrito
        // Puedes usar Fetch API o jQuery.ajax para hacer esto.
        // Recuerda manejar la respuesta del servidor para actualizar el carrito en el lado del cliente.
    });
});

// Manejar el clic en el botón "Pagar"
document.getElementById('pagar-button').addEventListener('click', function() {
    // Ocultar la lista de productos y mostrar la página de orden
    document.querySelector('.product-list').style.display = 'none';
    document.getElementById('pagina-orden').style.display = 'block';

    // Realiza una solicitud AJAX para obtener los detalles de la compra y la información del usuario
    // Puedes enviar una solicitud al servidor para obtener esta información.
});
