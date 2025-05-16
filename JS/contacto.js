
document.querySelector("form").addEventListener("submit", function (e) {
  e.preventDefault(); // Evita recarga de página

  const form = e.target;
  const formData = new FormData(form);

  fetch(form.action, {
    method: form.method,
    body: formData
  })
  .then(response => response.text())
  .then(responseText => {
    // Limpia el formulario
    form.reset();

    // Muestra mensaje de éxito
    const message = document.createElement("div");
    message.textContent = "¡Gracias por tu mensaje! Me pondré en contacto pronto.";
    message.style.backgroundColor = "#d4edda";
    message.style.color = "#155724";
    message.style.padding = "15px";
    message.style.marginTop = "20px";
    message.style.border = "1px solid #c3e6cb";
    message.style.borderRadius = "8px";

    form.parentElement.appendChild(message);

    // Elimina el mensaje después de unos segundos
    setTimeout(() => {
      message.remove();
    }, 6000);
  })
  .catch(error => {
    alert("Hubo un error al enviar tu mensaje. Intenta más tarde.");
    console.error("Error:", error);
  });
});


function toggleMenu() {
  const menuSlide = document.getElementById('menuSlide');
  menuSlide.classList.toggle('show');
  
  // Opcional: deshabilitar scroll cuando el menú está abierto
  document.body.style.overflow = menuSlide.classList.contains('show') ? 'hidden' : 'auto';
}

// Solo cerrar si el menú está abierto y el clic NO fue dentro del menú ni sobre el botón hamburguesa
document.addEventListener('click', function(event) {
  const menuSlide = document.getElementById('menuSlide');
  if (!menuSlide.classList.contains('show')) return;
  
  // si el clic ocurre dentro del propio menú, o sobre el ícono (cualquiera), no hacemos nada
  if (menuSlide.contains(event.target) || event.target.closest('.menu-icon')) return;
  
  // de lo contrario, cerramos
  menuSlide.classList.remove('show');
  document.body.style.overflow = 'auto';
});

const form = document.querySelector('form');
const notificacion = document.getElementById('notificacion');

form.addEventListener('submit', function (e) {
  e.preventDefault(); // evita envío inmediato

  const datos = new FormData(form);

  fetch(form.action, {
    method: form.method,
    body: datos
  })
  .then(response => response.text())
  .then(() => {
    notificacion.style.display = 'block';
    setTimeout(() => {
      notificacion.style.display = 'none';
      form.reset(); // limpia el formulario
    }, 3000);
  })
  .catch(error => {
    alert("Hubo un error al enviar el formulario.");
    console.error(error);
  });
});