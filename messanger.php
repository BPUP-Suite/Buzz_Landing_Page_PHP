<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_messanger.css">
    <title>Messanger by BPUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "components/header.php"; ?>
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Messanger</h1>
                <p>La nuova generazione di messaggistica istantanea universale, sviluppata da BPUP per connettere il mondo.</p>
                <ul>
                    <li>✓ Crittografia end-to-end avanzata</li>
                    <li>✓ Sincronizzazione in tempo reale</li>
                    <li>✓ Supporto multi-piattaforma</li>
                </ul>
                <a href="#download" class="cta-button">Inizia Ora Gratis ▶</a>
            </div>
            <div class="phone-mockup">
                <div class="phone-frame">
                    <iframe src="components/proxy.php"></iframe>    
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <h2>Perché Scegliere Messanger?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h3>Sicurezza Totale</h3>
                        <p>Critografia militare e protezione dati 24/7 per le tue conversazioni private</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-comments-dollar feature-icon"></i>
                        <h3>Completamente Gratuito</h3>
                        <p>Nessun costo nascosto, nessun abbonamento. Per sempre.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-sync-alt feature-icon"></i>
                        <h3>Sincronizzazione Istantanea</h3>
                        <p>Continua da dove hai lasciato su qualsiasi dispositivo</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-headset feature-icon"></i>
                        <h3>Supporto 24/7</h3>
                        <p>Assistenza tecnica sempre disponibile in 12 lingue</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Download Section -->
        <section id="download" class="download-section">
            <h2>Scarica Ora</h2>
            <div class="platform-grid">
                <div class="platform-card">
                    <i class="fab fa-android platform-icon"></i>
                    <h3>Android</h3>
                    <a href="#" class="platform-btn">
                        <i class="fab fa-google-play"></i>
                        Google Play
                    </a>
                </div>
                <div class="platform-card">
                    <i class="fab fa-apple platform-icon"></i>
                    <h3>iOS</h3>
                    <span href="#" class="platform-btn disabled">
                        <i class="fas fa-hourglass-half"></i>
                        In arrivo
                    </span>
                </div>
                <div class="platform-card">
                    <i class="fab fa-windows platform-icon"></i>
                    <h3>Windows</h3>
                    <a href="https://github.com/BPUP-Suite/Messanger_Client/releases/download/desktop-windows-linux-v0.0.3-pre-alpha/Messanger.Desktop.Setup.0.0.3.exe" class="platform-btn">
                        <i class="fab fa-github"></i>
                        .exe
                    </a>
                </div>
                <div class="platform-card">
                    <i class="fab fa-linux platform-icon"></i>
                    <h3>Linux</h3>
                    <a href="https://github.com/BPUP-Suite/Messanger_Client/releases/download/desktop-windows-linux-v0.0.3-pre-alpha/messanger_desktop_0.0.3_amd64.deb" class="platform-btn">
                        <i class="fab fa-github"></i>
                        .deb
                    </a>
                    <a href="https://github.com/BPUP-Suite/Messanger_Client/releases/download/desktop-windows-linux-v0.0.3-pre-alpha/Messanger.Desktop-0.0.3.AppImage" class="platform-btn">
                        <i class="fab fa-github"></i>
                        .AppImage
                    </a>
                </div>
                <div class="platform-card">
                    <i class="fab fa-firefox platform-icon"></i>
                    <h3>Firefox</h3>
                    <a href="https://addons.mozilla.org/en-US/firefox/addon/bpup-messanger/" class="platform-btn">
                        <i class="fas fa-puzzle-piece"></i>
                        Estensione
                    </a>
                </div>
                <div class="platform-card">
                    <i class="fab fa-chrome platform-icon"></i>
                    <h3>Chrome</h3>
                    <span href="#" class="platform-btn">
                        <i class="fas fa-hourglass-half"></i>
                        In arrivo
                    </span>
                </div>
                <div class="platform-card">
                    <i class="fab fa-google platform-icon" style="color: #5c6bc0;"></i>
                    <h3>WearOS</h3>
                    <span href="#" class="platform-btn disabled">
                        <i class="fas fa-hourglass-half"></i>
                        In arrivo
                    </span>
                </div>
                <div class="platform-card">
                    <i class="fab fa-apple platform-icon"></i>
                    <h3>macOS</h3>
                    <span href="#" class="platform-btn">
                        <i class="fas fa-hourglass-half"></i>
                        In arrivo
                    </span>
                </div>
            </div>
        </section>

        <section class="repo-section">
            <div class="container">
                <h2>Open Source Ecosystem</h2>
                <div class="repo-grid">
                    <div class="repo-card">
                        <h3>Core Framework in React</h3>
                        <p>Architettura principale del sistema di messaggistica</p>
                        <a href="https://github.com/BPUP-Suite/Messanger_Client" class="platform-btn">
                            <i class="fab fa-github"></i>
                            Vedi Codice
                        </a>
                    </div>
                    <div class="repo-card">
                        <h3>Client Desktop</h3>
                        <p>Implementazione Desktop per dispositivi Windows e Linux</p>
                        <a href="https://github.com/BPUP-Suite/Messanger_Client/tree/desktop" class="platform-btn">
                            <i class="fab fa-github"></i>
                            Vedi Codice
                        </a>
                    </div>
                    <div class="repo-card">
                        <h3>Estensioni Browser</h3>
                        <p>Codice sorgente per tutte le estensioni</p>
                        <a href="https://github.com/BPUP-Suite/Messanger_Browser_Extension" class="platform-btn">
                            <i class="fab fa-github"></i>
                            Vedi Codice
                        </a>
                    </div>
                    <div class="repo-card">
                        <h3>API Server</h3>
                        <p>Backend principale del servizio</p>
                        <a href="https://github.com/BPUP-Suite/Messanger_API" class="platform-btn">
                            <i class="fab fa-github"></i>
                            Vedi Codice
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
</body>
</html>