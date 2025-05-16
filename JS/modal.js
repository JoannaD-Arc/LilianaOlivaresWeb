const modal    = document.getElementById('img-modal');
const modalImg = document.getElementById('modal-img');

// 1) Forzar cerrado al cargar la página
window.addEventListener('DOMContentLoaded', () => {
  modal.classList.remove('open');
  document.body.classList.remove('modal-open');
});

// 2) Apertura al click en miniatura
document.querySelectorAll('.render-thumb').forEach(img => {
  img.addEventListener('click', () => {
    modalImg.src = img.src;
    modal.classList.add('open');
    document.body.classList.add('modal-open');
  });
});

// 3) Cierre al click fuera de la imagen
modal.addEventListener('click', e => {
  if (e.target === modal) {
    modal.classList.remove('open');
    document.body.classList.remove('modal-open');
  }
});
