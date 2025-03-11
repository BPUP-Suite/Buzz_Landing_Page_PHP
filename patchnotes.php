<?php include "php/database_patchnotes.php"; ?>

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

    <div class="view-controls">
        <button class="tab-button active" data-view="timeline-view">Timeline</button>
        <button class="tab-button" data-view="release-view">Release</button>
    </div>

    <!-- Timeline View -->
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

    <!-- Release View -->
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
    
    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
    
    <script src="js/scripts_patchnotes.js" defer></script>
</body>
</html>