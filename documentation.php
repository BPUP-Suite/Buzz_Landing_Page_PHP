<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPUP - Innovazione Open Source</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css/styles_scrollbar-styles.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

    <?php include "components/header.php"; ?>

    <div class="main-content">
        <div class="under-construction-container" style="text-align: center; padding: 50px 20px; max-width: 800px; margin: 0 auto;">
            <h1>Documentazione</h1>
            <div style="margin: 40px 0;">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
            </div>
            <h2>Pagina in costruzione</h2>
            <p style="font-size: 18px; margin-top: 20px;">La documentazione completa di BPUP sarà disponibile nei prossimi mesi.</p>
            <p style="margin-top: 30px;">Grazie per la pazienza mentre lavoriamo per migliorare la piattaforma.</p>
            <p style="margin-top: 40px;">Attualmente è comunque disponibile parte della documentazione dell'api sulla repo del server. Clicca <a href="https://github.com/BPUP-Suite/MessangerAPI">qui</a></p>
        </div>
    </div>


    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
    

    <script src="js/scripts_index.js" defer></script>
    
</body>
</html>
