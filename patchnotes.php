<?php include "php/database_patchnotes.php"; ?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patch Notes</title>
    <link rel="stylesheet" href="css/styles_patchnotes.css">
    <link rel="stylesheet" href="css/styles_scrollbar-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            foreach ($patchnotesItems as $item):
                $position = ($counter % 2 == 0) ? 'left' : 'right';
                $tags = parseTags($item['tags']);
            ?>
                <div class="timeline-item <?php echo $position; ?>">
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <h3 class="timeline-title"><?php echo htmlspecialchars($item['titolo']); ?></h3>
                        </div>
                        <div class="timeline-dates">
                            <div>Inizio: <?php echo formatDate($item['data_inizio']); ?></div>
                            <div>Fine: <?php echo formatDate($item['data_fine']); ?></div>
                        </div>
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
                <?php foreach ($patchnotesItems as $index => $item):
                    $tags = parseTags($item['tags']);
                    $features = splitTextByDelimiter($item['features']);
                    $bugFixes = splitTextByDelimiter($item['bug_fixes']);
                    $improvements = splitTextByDelimiter($item['improvements']);
                    $knownIssues = splitTextByDelimiter($item['known_issues']);
                    ?>
                    <div class="patch-card" data-index="<?php echo $index; ?>">
                        <h3 class="patch-title">
                            <?php echo htmlspecialchars($item['titolo']); ?>
                        </h3>
                        
                        <div class="patch-dates">
                            <span>Da <?php echo formatDate($item['data_inizio']); ?> a <?php echo formatDate($item['data_fine']); ?></span>
                        </div>
                        
                        <?php if (!empty($tags)): ?>
                            <div class="patch-tags">
                                <?php foreach ($tags as $tag): ?>
                                    <span class="patch-tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="patch-content">
                            <!-- Sezione Features (sempre visibile) -->
                            <div class="feature-section">
                                <h4 class="section-title">Features</h4>
                                <?php if (!empty($features)): ?>
                                    <ul class="feature-list">
                                        <?php foreach ($features as $feature): ?>
                                            <li><?php echo htmlspecialchars($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Nessuna feature disponibile.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Container per le sezioni collassabili allineate -->
                            <div class="collapsible-container">
                                <!-- Sezione Bug Fixes (collassabile) -->
                                <div class="collapsible-section">
                                    <button class="collapsible-button" data-target="bugfixes-<?php echo $index; ?>">
                                        <span>Bug Fixes</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="collapsible-content" id="bugfixes-<?php echo $index; ?>">
                                        <?php if (!empty($bugFixes)): ?>
                                            <ul class="bug-list">
                                                <?php foreach ($bugFixes as $bug): ?>
                                                    <li><?php echo htmlspecialchars($bug); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>Nessun bug fix disponibile.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Sezione Improvements (collassabile) -->
                                <div class="collapsible-section">
                                    <button class="collapsible-button" data-target="improvements-<?php echo $index; ?>">
                                        <span>Improvements</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="collapsible-content" id="improvements-<?php echo $index; ?>">
                                        <?php if (!empty($improvements)): ?>
                                            <ul class="improvement-list">
                                                <?php foreach ($improvements as $improvement): ?>
                                                    <li><?php echo htmlspecialchars($improvement); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>Nessun miglioramento disponibile.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Sezione Known Issues (collassabile) -->
                                <div class="collapsible-section">
                                    <button class="collapsible-button" data-target="issues-<?php echo $index; ?>">
                                        <span>Known Issues</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="collapsible-content" id="issues-<?php echo $index; ?>">
                                        <?php if (!empty($knownIssues)): ?>
                                            <ul class="issues-list">
                                                <?php foreach ($knownIssues as $issue): ?>
                                                    <li><?php echo htmlspecialchars($issue); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>Nessun problema noto disponibile.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
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