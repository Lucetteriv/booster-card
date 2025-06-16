document.addEventListener('DOMContentLoaded', () => { // Ensure the DOM is fully loaded
    // Select all elements with the class 'card' and extract their data attributes
    const cards = document.querySelectorAll ('.card')
    let currentIndex = 9;           
    let animation = false;
    console.log (cards);

    const showFinalForm = () => {
        const form = document.querySelector('.AddToCol');
        if (form) {
            form.style.visibility = 'visible'; // Show the form
            form.style.display = 'block'; // Ensure the form is displayed
        }
     }

        cards.forEach((card, index) => {
            card.addEventListener('click', () => {
                if (cards[currentIndex] === card && !animation) {
            // Première animation
             animation = true;
            const tl1 = gsap.timeline({
                onComplete: () => {
                    setTimeout(() => {
                        const oneSecondeClick = (e) => {
                            const tl2 = gsap.timeline({
                                onComplete: () => {
                                    currentIndex--;
                                    animation = false;
                                    if (currentIndex < 0) {
                                        showFinalForm(); // Show the form when all cards are clicked
                                    }
                                }
                            });
                            tl2.to(card, {
                                rotationY: "+=360",
                                duration: 0.6,
                                ease: "power1.inOut"
                            })
                            .to(card, {
                                x: window.innerWidth, // vers le haut
                                opacity: 0,
                                duration: 0.5,
                                ease: "power2.in"
                            });
                            card.removeEventListener('click', oneSecondeClick);
                        };
                        card.addEventListener('click', oneSecondeClick, {once: true});
                    }, 0);
                }
            })
                tl1.to(card, {
                scale: 1.2,
                rotationY: 360,
                duration: 0.8,
                ease: "power2.out"
                })
                .to(card, {
                scale: 1.4,
                duration: 0.3,
                ease: "back.out(1.7)"
                });

               
            
            }});
            
        });   
});


