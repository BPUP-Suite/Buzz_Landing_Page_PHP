<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Pagina non trovata | BPUP</title>
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
        .error-container {
            text-align: center;
            padding: 50px 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            margin: 0;
            line-height: 1;
        }
        .home-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            background-color: var(--primary);;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <?php include "components/header.php"; ?>

    <div class="main-content">
        <div class="error-container">
            <p class="error-code">404</p>
            <h1>Pagina non trovata</h1>
            <div style="margin: 40px 0;">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 16s-1.5-2-4-2-4 2-4 2"></path>
                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                </svg>
            </div>
            <p>La pagina che stai cercando non esiste o è stata spostata.</p>
            <a href="index.php" class="home-button">Torna alla Home</a>
        </div>
    </div>

    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
    
    <script src="js/scripts_index.js" defer></script>
    
</body>
</html>