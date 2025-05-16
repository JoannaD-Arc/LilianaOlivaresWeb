let currentIndex = 0;

const testimonials = [
    {
      text: `Quedé encantado, no sé mucho de interiorismo por lo que dejé a la Lic. Liliana Olivares al cargo y entendió mejor lo que pedí que yo mismo. Excelente servicio.`,
      avatar: 'IMG/CarlosFoto.jpg',
      name: 'Carlos Luna',
      role: 'Nadador Profesional'
    },
    {
      text: `La Lic. Liliana superó nuestras expectativas. Diseño innovador y atención al detalle en cada fase del proyecto. 
¡Altamente recomendado!`,
      avatar: 'IMG/RobertoyYo.jpg',
      name: 'Roberto Medina',
      role: 'Diseñador Digital'
    },
    {
      text: `Nuestra oficina cobra vida gracias al diseño funcional y estético que me propusieron. 
Trabajo impecable, siempre en tiempo y forma.`,
      avatar: 'IMG/LourdesContreras.jpg',
      name: 'María Contreras',
      role: 'Administradora de Empresas'
    }
  ];

  const txtEl   = document.getElementById('testimonial-text');
  const imgEl   = document.getElementById('testimonial-avatar');
  const nameEl  = document.getElementById('client-name');
  const roleEl  = document.getElementById('client-role');
  const prevBtn = document.querySelector('.testimonial-nav .prev');
  const nextBtn = document.querySelector('.testimonial-nav .next');
  const card    = document.querySelector('.testimonial-card');

  function showTestimonial(i) {
    const t = testimonials[i];
    txtEl.textContent  = t.text;
    imgEl.src          = t.avatar;
    imgEl.alt          = `Avatar de ${t.name}`;
    nameEl.textContent = t.name;
    roleEl.textContent = t.role;
  }

  function changeTestimonial(dir) {
    const outClass = dir === 'next' ? 'slide-out-left' : 'slide-out-right';
    const inClass  = dir === 'next' ? 'slide-in-right' : 'slide-in-left';

    card.classList.add(outClass);
    card.addEventListener('animationend', () => {
      card.classList.remove(outClass);
      // actualizar índice
      currentIndex = dir === 'next'
        ? (currentIndex + 1) % testimonials.length
        : (currentIndex - 1 + testimonials.length) % testimonials.length;
      showTestimonial(currentIndex);
      card.classList.add(inClass);
      card.addEventListener('animationend', () => {
        card.classList.remove(inClass);
      }, { once: true });
    }, { once: true });
  }

  // Conecta los botones
  prevBtn.addEventListener('click', () => changeTestimonial('prev'));
  nextBtn.addEventListener('click', () => changeTestimonial('next'));

  // Mostramos la primera al cargar
  showTestimonial(currentIndex);