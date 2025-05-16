let currentSlide = 0;
    const slider = document.getElementById("slider");
    const totalSlides = slider.children.length;
    let interval = setInterval(nextSlide, 4000); // cada 4 segundos

    function showSlide(index) {
      slider.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      showSlide(currentSlide);
    }

    function manualMove(direction) {
      clearInterval(interval); // detiene el auto-play temporalmente
      currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
      showSlide(currentSlide);
      interval = setInterval(nextSlide, 4000); // reinicia auto-play
}