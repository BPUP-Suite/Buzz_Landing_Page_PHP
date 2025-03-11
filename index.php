<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPUP - Innovazione Open Source</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link rel="stylesheet" href="css/styles_index.css">
</head>
<body>

    <?php include "components/header.php"; ?>

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
                    <a href="messanger.php" class="card-link">Esplora il progetto <span>→</span></a>
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

    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
    

    <script src="js/scripts_index.js" defer></script>
    
</body>
</html>
