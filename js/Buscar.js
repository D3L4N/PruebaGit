// Obtén el formulario de búsqueda y la burbuja emergente
const searchForm = document.getElementById('search-form');
const searchResults = document.getElementById('search-results');

// Agrega un evento de envío al formulario de búsqueda
searchForm.addEventListener('submit', function (e) {
  e.preventDefault(); // Evita el envío del formulario por defecto

  // Realiza la solicitud AJAX al archivo de búsqueda y obtén los resultados
  const searchTerm = document.getElementById('search-text').value;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', `Php/buscar.php?q=${searchTerm}`, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Muestra los resultados en la burbuja emergente
      searchResults.innerHTML = xhr.responseText;
      searchResults.style.display = 'block';
    }
  };
  xhr.send();
});

// Cierra la burbuja emergente cuando se haga clic en cualquier otro lugar de la página
document.addEventListener('click', function (e) {
  if (!searchResults.contains(e.target)) {
    searchResults.style.display = 'none';
  }
});
