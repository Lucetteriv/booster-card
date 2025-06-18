// Create a card tilt effect on hover
// Adapte the angle of the skew based on the mouse position on the card
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.pokemon-card');

  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left; // x position within the element
      const y = e.clientY - rect.top; // y position within the element

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const deltaX = (x - centerX) / centerX;
      const deltaY = (y - centerY) / centerY;

      const tiltX = -deltaY * 2; // Adjust the tilt factor as needed
      const tiltY = deltaX * 2; // Adjust the tilt factor as needed

      card.style.transform = `skew(${tiltY}deg, ${tiltX}deg)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'skew(0deg, 0deg)';
    });
  });
});
