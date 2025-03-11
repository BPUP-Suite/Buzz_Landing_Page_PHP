document.addEventListener('DOMContentLoaded', function() {
            
    // Creazione delle forme fluttuanti
    const shapes = document.getElementById('shapes');
    for (let i = 0; i < 15; i++) {
        const shape = document.createElement('div');
        shape.classList.add('shape');
        
        const size = Math.random() * 100 + 50;
        shape.style.width = `${size}px`;
        shape.style.height = `${size}px`;
        
        const left = Math.random() * 100;
        const top = Math.random() * 100;
        shape.style.left = `${left}%`;
        shape.style.top = `${top}%`;
        
        shapes.appendChild(shape);
        
        gsap.to(shape, {
            x: Math.random() * 100 - 50,
            y: Math.random() * 100 - 50,
            duration: Math.random() * 10 + 10,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });
    }
    
    // Effetto scroll 3D e parallax
    let scrollY = window.scrollY;
    const cards3d = document.querySelectorAll('.card');
    const hero = document.querySelector('.hero');
    
    window.addEventListener('scroll', function() {
        scrollY = window.scrollY;
        
        // Applica effetto 3D alle card in base allo scroll
        cards3d.forEach((card, index) => {
            const cardTop = card.getBoundingClientRect().top;
            const cardHeight = card.offsetHeight;
            const windowHeight = window.innerHeight;
            
            if (cardTop < windowHeight && cardTop > -cardHeight) {
                const scrollProgress = (windowHeight - cardTop) / (windowHeight + cardHeight);
                const rotateY = (scrollProgress - 0.5) * 20;
                
                gsap.to(card, {
                    rotateY: rotateY,
                    rotateX: (index % 2 === 0 ? 1 : -1) * 5 * (scrollProgress - 0.5),
                    duration: 0.5
                });
            }
        });
    });

    
});