<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPUP - Innovazione Open Source</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css/styles_header.css">
    <link rel="stylesheet" href="css/styles_footer.css">
</head>
<body>

    <?php include "header.php"; ?>

    

    <main class="main">
        <section class="hero">
            <div class="floating-shapes" id="shapes"></div>
            <h1>Sesso con bersanella</h1>
            <p>BPUP è un gruppo di studenti universitari dedicati allo sviluppo di applicazioni open source, soluzioni di messaggistica sicura e strumenti innovativi per la comunità.</p>
            <a href="#projects" class="btn">Scopri i Progetti</a>
            <div class="scroll-indicator">
                <div class="scroll-dot"></div>
            </div>
        </section>

        <section class="projects" id="projects">
            <h2 class="section-title">I Nostri Progetti</h2>
            <div class="cards-container">
                <div class="card">
                    <div class="card-icon">💬</div>
                    <h3>BPUP Messenger</h3>
                    <p>Un'applicazione di messaggistica sicura e privata, progettata da studenti per studenti. Crittografia end-to-end e interfaccia intuitiva.</p>
                    <a href="#" class="card-link">Esplora il progetto <span>→</span></a>
                </div>
                <div class="card">
                    <div class="card-icon">📚</div>
                    <h3>Study Hub</h3>
                    <p>Piattaforma collaborativa per la condivisione di appunti, risorse didattiche e organizzazione di gruppi di studio.</p>
                    <a href="#" class="card-link">Esplora il progetto <span>→</span></a>
                </div>
                <div class="card">
                    <div class="card-icon">🔧</div>
                    <h3>Dev Tools</h3>
                    <p>Suite di strumenti per sviluppatori creati per semplificare il flusso di lavoro e migliorare la produttività.</p>
                    <a href="#" class="card-link">Esplora il progetto <span>→</span></a>
                </div>
                <div class="card">
                    <div class="card-icon">🌐</div>
                    <h3>Open API</h3>
                    <p>Un'insieme di API pubbliche per integrare i servizi BPUP nelle tue applicazioni e contribuire all'ecosistema.</p>
                    <a href="#" class="card-link">Esplora il progetto <span>→</span></a>
                </div>
            </div>
        </section>

        <section class="features">
            <h2 class="section-title">Perché Scegliere BPUP</h2>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <div class="feature-text">
                        <h4>Privacy e Sicurezza</h4>
                        <p>Sviluppiamo ogni applicazione con la sicurezza come priorità assoluta, proteggendo i tuoi dati.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">👥</div>
                    <div class="feature-text">
                        <h4>Sviluppo Guidato dalla Comunità</h4>
                        <p>Ascoltiamo attivamente i feedback e integriamo le richieste della nostra comunità.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📱</div>
                    <div class="feature-text">
                        <h4>Compatibile con Tutti i Dispositivi</h4>
                        <p>Le nostre applicazioni funzionano perfettamente su desktop, tablet e smartphone.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💻</div>
                    <div class="feature-text">
                        <h4>100% Open Source</h4>
                        <p>Tutto il nostro codice è disponibile su GitHub, pronto per essere esplorato e migliorato.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🚀</div>
                    <div class="feature-text">
                        <h4>Innovazione Continua</h4>
                        <p>Aggiornamenti frequenti con nuove funzionalità e miglioramenti basati sul feedback.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🎓</div>
                    <div class="feature-text">
                        <h4>Creato da Studenti</h4>
                        <p>Comprendiamo le esigenze degli studenti perché lo siamo anche noi.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "footer.php"; ?>

    <div class="theme-toggle" id="theme-toggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 20V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M4.93 4.93L6.34 6.34" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17.66 17.66L19.07 19.07" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 12H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 12H22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6.34 17.66L4.93 19.07" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M19.07 4.93L17.66 6.34" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <script>
        
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
                
                // parallaxScroll();
                
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
            
            // function parallaxScroll() {
            //     const translateY = scrollY * 0.3;
            //     gsap.to(hero, {
            //         y: translateY,
            //         ease: "power1.out",
            //         duration: 0.5
            //     });
            // }
            
            // Tema dark/light toggle
            const themeToggle = document.getElementById('theme-toggle');
            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
            });
            
            // Hamburger menu toggle
            const hamburger = document.querySelector('.hamburger');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                mobileMenu.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
