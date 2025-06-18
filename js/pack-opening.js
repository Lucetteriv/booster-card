document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.pokemon-card');
  let currentCardIndex = 9;
  let isCardAnimating = false;

  const showFinalForm = () => {
    const addToCollectionForm = document.querySelector('#add-to-collection-form');
    if (addToCollectionForm) {
      addToCollectionForm.style.display = 'flex';
    } else {
      console.error('Formulaire "Ajouter à la collection" introuvable dans le DOM.');
    }
  };

  cards.forEach(card => {
    card.addEventListener('click', () => {
      if (cards[currentCardIndex] === card && !isCardAnimating) {
        isCardAnimating = true;

        const tl1 = gsap.timeline({
          onComplete: () => {
            // Attente minuscule pour autoriser l'écoute du 2e clic
            setTimeout(() => {
              const onSecondClick = (e) => {
                // Plus souple : accepter le clic sur card ou un enfant
                if (!card.contains(e.target)) return;

                const tl2 = gsap.timeline({
                  onComplete: () => {
                    card.style.display = 'none';
                    currentCardIndex--;
                    isCardAnimating = false;

                    if (currentCardIndex < 0) {
                      showFinalForm();
                    }
                  }
                });

                tl2.to(card, {
                  x: window.innerWidth,
                  rotationY: '+=360',
                  duration: 0.8,
                  ease: 'power2.inOut',
                });

                card.removeEventListener('click', onSecondClick);
              };

              card.addEventListener('click', onSecondClick, { once: true });
            }, 0);
          }
        });

        tl1.to(card, { scale: 1.05, duration: 0.25, ease: 'power2.inOut' })
           .to(card, { rotationY: 360, duration: 0.4, ease: 'power2.inOut' })
           .to(card, { scale: 1.25, duration: 0.25 });
      }
    });
  });
});
