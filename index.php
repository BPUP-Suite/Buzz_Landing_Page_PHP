<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUZZ - Innovazione Open Source</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link rel="stylesheet" href="css/styles_index.css">
</head>
<body>

    <?php include "components/header.php"; ?>

    <main class="main">
        <section class="hero">
            <div class="floating-shapes" id="shapes"></div>
            <h1>Buzz</h1>
            <p>BUZZ è un gruppo di studenti universitari dedicati allo sviluppo di applicazioni open source, soluzioni di messaggistica sicura e strumenti innovativi per la comunità.</p>
            <a href="#download" class="btn">Scaricala subito</a>
            <div class="scroll-indicator">
                <div class="scroll-dot"></div>
            </div>
        </section>

        <!-- Download Section -->
        <section id="download" class="download-section">
            <h2>Download</h2>
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
                    <div class="linux-download-container">
                        <button class="platform-btn linux-main-btn">
                            <i class="fab fa-github"></i>
                            Options
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="linux-dropdown">
                            <a href="https://github.com/BPUP-Suite/Messanger_Client/releases/download/desktop-windows-linux-v0.0.3-pre-alpha/messanger_desktop_0.0.3_amd64.deb" class="platform-btn linux-option">
                                <i class="fab fa-github"></i>
                                .deb
                            </a>
                            <a href="https://github.com/BPUP-Suite/Messanger_Client/releases/download/desktop-windows-linux-v0.0.3-pre-alpha/Messanger.Desktop-0.0.3.AppImage" class="platform-btn linux-option">
                                <i class="fab fa-github"></i>
                                .AppImage
                            </a>
                        </div>
                    </div>
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
                    <span href="#" class="platform-btn disabled">
                        <i class="fas fa-hourglass-half"></i>
                        In arrivo
                    </span>
                </div>
                <div class="platform-card">
                    <i class="fab fa-google platform-icon"></i>
                    <h3>WearOS</h3>
                    <span href="#" class="platform-btn disabled">
                        <i class="fas fa-hourglass-half "></i>
                        In arrivo
                    </span>
                </div>
                <div class="platform-card">
                    <i class="fab fa-apple platform-icon"></i>
                    <h3>macOS</h3>
                    <span href="#" class="platform-btn disabled ">
                        <i class="fas fa-hourglass-half"></i>
                        In arrivo
                    </span>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section class="repo-section">
            <div class="container">
                <h2>Repositories</h2>
                <div class="repo-grid">
                    <div class="repo-card">
                        <h3>Client in React Native</h3>
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
                        <h3>API/IO Server</h3>
                        <p>Backend del servizio</p>
                        <a href="https://github.com/BPUP-Suite/Messanger_API" class="platform-btn">
                            <i class="fab fa-github"></i>
                            Vedi Codice
                        </a> 
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
