<?php include "php/database_roadmap.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Roadmap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles_roadmap.css">
    <link rel="stylesheet" href="css/scrollbar-styles.css">
</head>
<body>

<?php include "components/header.php"; ?>

    <div class="container">
        <div class="roadmap">
            <?php if (empty($versions)): ?>
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle fa-3x"></i>
                    <h3>No roadmap data available</h3>
                    <p>Check back later for updates on our project development roadmap.</p>
                </div>
            <?php else: ?>
                <?php foreach ($versions as $version): ?>
                    <?php if (isset($featuresGrouped[$version])): ?>
                        <?php $stats = $versionStats[$version]; ?>
                        <div class="version-container">
                            <div class="version-header" data-target="version-<?php echo md5($version); ?>">
                                <div class="version-header-top">
                                    <div class="version-title">
                                        <i class="fas fa-cube"></i>
                                        Version <span class="version-badge"><?php echo htmlspecialchars($version); ?></span>
                                    </div>
                                    <div class="collapse-icon">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                
                                <div class="progress-container">
                                    <?php if ($stats['completedPercentage'] > 0): ?>
                                        <div class="progress-bar progress-completed" style="width:<?php echo $stats['completedPercentage']; ?>%"></div>
                                    <?php endif; ?>
                                    <?php if ($stats['inProgressPercentage'] > 0): ?>
                                        <div class="progress-bar progress-in-progress" style="width:<?php echo $stats['inProgressPercentage']; ?>%; left:<?php echo $stats['completedPercentage']; ?>%"></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="progress-stats">
                                    <div class="stat-item">
                                        <span class="stat-dot dot-completed"></span>
                                        Completed: <?php echo $stats['completed']; ?>/<?php echo $stats['total']; ?> (<?php echo $stats['completedPercentage']; ?>%)
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-dot dot-in-progress"></span>
                                        In Progress: <?php echo $stats['inProgress']; ?>/<?php echo $stats['total']; ?> (<?php echo $stats['inProgressPercentage']; ?>%)
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-dot dot-planned"></span>
                                        Planned: <?php echo $stats['planned']; ?>/<?php echo $stats['total']; ?> (<?php echo $stats['plannedPercentage']; ?>%)
                                    </div>
                                </div>
                            </div>
                            
                            <div class="version-content" id="version-<?php echo md5($version); ?>">
                                <?php foreach ($featuresGrouped[$version] as $category => $features): ?>
                                    <?php 
                                        // Generate a unique icon for each category
                                        $categoryFirstLetter = strtoupper(substr($category, 0, 1));
                                        
                                        // Generate a category icon based on name
                                        $categoryIcon = 'fa-layer-group'; // default
                                        if (stripos($category, 'ui') !== false || stripos($category, 'design') !== false) {
                                            $categoryIcon = 'fa-palette';
                                        } elseif (stripos($category, 'api') !== false) {
                                            $categoryIcon = 'fa-plug';
                                        } elseif (stripos($category, 'data') !== false || stripos($category, 'database') !== false) {
                                            $categoryIcon = 'fa-database';
                                        } elseif (stripos($category, 'auth') !== false) {
                                            $categoryIcon = 'fa-lock';
                                        } elseif (stripos($category, 'user') !== false) {
                                            $categoryIcon = 'fa-user';
                                        } elseif (stripos($category, 'communication') !== false) {
                                            $categoryIcon = 'fa-comments';
                                        } elseif (stripos($category, 'notification') !== false) {
                                            $categoryIcon = 'fa-bell';
                                        } elseif (stripos($category, 'performance') !== false) {
                                            $categoryIcon = 'fa-tachometer-alt';
                                        } elseif (stripos($category, 'security') !== false) {
                                            $categoryIcon = 'fa-shield-alt';
                                        }
                                    ?>
                                    <div class="category-container">
                                        <div class="category-header" data-target="category-<?php echo md5($version . $category); ?>">
                                            <div class="category-title">
                                                <span class="category-icon">
                                                    <i class="fas <?php echo $categoryIcon; ?>"></i>
                                                </span>
                                                <?php echo htmlspecialchars($category); ?>
                                            </div>
                                            <div class="collapse-icon">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <div class="category-content" id="category-<?php echo md5($version . $category); ?>">
                                            <div class="features-grid">
                                                <?php foreach ($features as $feature): ?>
                                                    <?php 
                                                        $status = getItemStatus($feature);
                                                        $statusClass = getStatusClass($status);
                                                        $statusIcon = getStatusIcon($status);
                                                        $tags = parseTags($feature['tags']);
                                                    ?>
                                                    <div class="feature-card <?php echo $statusClass; ?>">
                                                        <div class="feature-header">
                                                            <div class="feature-title-row">
                                                                <h3 class="feature-title"><?php echo htmlspecialchars($feature['titolo']); ?></h3>
                                                                <div class="feature-status <?php echo $statusClass; ?>">
                                                                    <?php echo $statusIcon; ?> 
                                                                    <?php echo ucfirst($status); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="feature-description">
                                                            <?php echo htmlspecialchars($feature['descrizione']); ?>
                                                        </div>
                                                        <div class="feature-meta">
                                                            <span class="feature-type">
                                                                <?php if ($feature['tipo'] == 'server'): ?>
                                                                    <i class="fas fa-server"></i> Server-side
                                                                <?php elseif ($feature['tipo'] == 'client'): ?>
                                                                    <i class="fas fa-desktop"></i> Client-side
                                                                <?php else: ?>
                                                                    <i class="fas fa-code-branch"></i> Full-stack
                                                                <?php endif; ?>
                                                            </span>
                                                            <span class="feature-dates">
                                                                <i class="fas fa-calendar-alt"></i> 
                                                                <?php echo formatDate($feature['data_inizio']); ?> - 
                                                                <?php echo formatDate($feature['data_fine']); ?>
                                                            </span>
                                                        </div>
                                                        <?php if (!empty($tags)): ?>
                                                            <div class="tags-container">
                                                                <?php foreach ($tags as $tag): ?>
                                                                    <span class="tag">
                                                                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars(trim($tag)); ?>
                                                                    </span>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    
    <?php include "components/theme.php"; ?>
    <?php include "components/footer.php"; ?>
    <script src="js/scripts_roadmap.js"></script>
</body>
</html>