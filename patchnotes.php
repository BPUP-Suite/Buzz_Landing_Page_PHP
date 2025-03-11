<?php
// Configurazione connessione al database PostgreSQL
$host = 'postgresql'; // Il nome del servizio nel docker-compose
$dbname = 'progetto_db';
$user = 'root';
$pass = 'root';

try {
    // Connessione al database PostgreSQL
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query per recuperare tutti gli elementi della roadmap
    $stmt = $conn->prepare("SELECT * FROM roadmap ORDER BY data_inizio ASC");
    $stmt->execute();
    $roadmapItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

// Funzione per formattare le date
function formatDate($date)
{
    return date("d/m/Y", strtotime($date));
}

// Funzione per determinare lo stato di un elemento
function getItemStatus($item)
{
    $today = date('Y-m-d');

    if (isset($item['stato']) && !empty($item['stato'])) {
        return $item['stato'];
    } else if ($today > $item['data_fine']) {
        return 'completato';
    } else if ($today >= $item['data_inizio'] && $today <= $item['data_fine']) {
        return 'in-corso';
    } else {
        return 'pianificato';
    }
}

// Funzione per ottenere la classe CSS in base allo stato
function getStatusClass($status)
{
    switch ($status) {
        case 'completato':
            return 'completed';
        case 'in-corso':
            return 'in-progress';
        case 'pianificato':
            return 'planned';
        default:
            return '';
    }
}

// Funzione per ottenere l'icona in base allo stato
function getStatusIcon($status)
{
    switch ($status) {
        case 'completato':
            return '<i class="fas fa-check-circle"></i>';
        case 'in-corso':
            return '<i class="fas fa-spinner fa-spin"></i>';
        case 'pianificato':
            return '<i class="fas fa-calendar-alt"></i>';
        default:
            return '';
    }
}

// Funzione per convertire i tag da stringa a array
function parseTags($tagsString)
{
    if (empty($tagsString))
        return [];
    return explode(',', $tagsString);
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roadmap di Progetto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/styles_patchnotes.css">
</head>

<body>

    <?php include "components/header.php"; ?>

    <div class="container">
        <container-header>
            <h1>Roadmap di Progetto</h1>
            <p>Visualizza il piano di sviluppo e le prossime release</p>
        </container-header>

        <div class="view-controls">
            <button class="tab-button active" data-view="timeline-view">Timeline</button>
            <button class="tab-button" data-view="release-view">Release</button>
        </div>

        <!-- Timeline View (unchanged) -->
        <div id="timeline-view" class="view active">
            <div class="timeline">
                <?php
                $counter = 0;
                foreach ($roadmapItems as $item):
                    $status = getItemStatus($item);
                    $statusClass = getStatusClass($status);
                    $statusIcon = getStatusIcon($status);
                    $position = ($counter % 2 == 0) ? 'left' : 'right';
                    $tags = parseTags($item['tags']);
                    ?>
                    <div class="timeline-item <?php echo $position; ?>">
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h3 class="timeline-title"><?php echo htmlspecialchars($item['titolo']); ?></h3>
                                <div class="timeline-status <?php echo $statusClass; ?>">
                                    <?php echo $statusIcon; ?>
                                    <?php echo ucfirst($status); ?>
                                </div>
                            </div>
                            <div class="timeline-dates">
                                <div>Inizio: <?php echo formatDate($item['data_inizio']); ?></div>
                                <div>Fine: <?php echo formatDate($item['data_fine']); ?></div>
                            </div>
                            <?php if (isset($item['descrizione']) && !empty($item['descrizione'])): ?>
                                <div class="timeline-description">
                                    <?php echo htmlspecialchars($item['descrizione']); ?>
                                </div>
                            <?php endif; ?>
                            <div class="timeline-tags">
                                <?php foreach ($tags as $tag): ?>
                                    <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $counter++;
                endforeach;
                ?>
            </div>
        </div>

        <!-- Improved Release View with Carousel -->
        <div id="release-view" class="view">
            <div class="carousel-container">
                <div class="carousel-wrapper">
                    <?php foreach ($roadmapItems as $index => $item):
                        $tags = parseTags($item['tags']);
                        ?>
                        <div class="patch-card" data-index="<?php echo $index; ?>">
                            <h3 class="patch-title">
                                <?php echo htmlspecialchars($item['titolo']); ?>
                                <?php if (!empty($tags)): ?>
                                    <span class="tag-toggle" data-index="<?php echo $index; ?>">
                                        <i class="fas fa-tags"></i> Tag
                                    </span>
                                <?php endif; ?>
                            </h3>

                            <?php if (!empty($tags)): ?>
                                <div class="tag-container" id="tags-<?php echo $index; ?>">
                                    <?php foreach ($tags as $tag): ?>
                                        <span class="patch-tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="patch-content">
                                <?php if (isset($item['descrizione']) && !empty($item['descrizione'])): ?>
                                    <?php echo nl2br(htmlspecialchars($item['descrizione'])); ?>
                                <?php else: ?>
                                    <p>Nessuna descrizione disponibile per questa release.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-nav">
                    <button class="carousel-nav-button prev-button">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-nav-button next-button">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
    
    <script src="js/scripts_patchnotes.js" defer></script>
</body>

</html>