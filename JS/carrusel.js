document.addEventListener('DOMContentLoaded', () => {
  const slidesContainer = document.querySelector('.hero-carousel .slides');
  const total = document.querySelectorAll('.slide').length;
  const nextBtn = document.querySelector('.next');
  const prevBtn = document.querySelector('.prev');
  let current = 0;

  function goToSlide(idx) {
    // limita idx
    current = (idx + total) % total;
    const offset = -current * 100;
    slidesContainer.style.transform = `translateX(${offset}%)`;
  }

  nextBtn.addEventListener('click', () => goToSlide(current + 1));
  prevBtn.addEventListener('click', () => goToSlide(current - 1));
  setInterval(() => goToSlide(current + 1), 5000);
});
