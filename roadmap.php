<?php
include 'config.php';

// Query to get all versions
$stmt = $conn->prepare("
    SELECT versione 
    FROM roadmap 
    GROUP BY versione
    ORDER BY 
        CASE 
            WHEN versione LIKE '%-pre-alpha%' THEN 1
            WHEN versione LIKE '%-alpha%' THEN 2
            WHEN versione LIKE '%-beta%' THEN 3
            ELSE 4
        END,
        versione ASC;
");
$stmt->execute();
$versions = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch features for all versions
$stmtFeatures = $conn->prepare("
    SELECT 
        r.id, 
        r.versione, 
        r.titolo, 
        r.descrizione, 
        r.tags, 
        r.tipo, 
        r.data_inizio, 
        r.data_fine, 
        r.stato,
        r.categoria
    FROM 
        roadmap r
    ORDER BY 
        r.data_inizio ASC
");
$stmtFeatures->execute();
$allFeatures = $stmtFeatures->fetchAll(PDO::FETCH_ASSOC);

// Group features by version and category
$featuresGrouped = [];
foreach ($allFeatures as $feature) {
    $version = $feature['versione'];
    $category = empty($feature['categoria']) ? 'General' : $feature['categoria'];
    
    if (!isset($featuresGrouped[$version])) {
        $featuresGrouped[$version] = [];
    }
    
    if (!isset($featuresGrouped[$version][$category])) {
        $featuresGrouped[$version][$category] = [];
    }
    
    $featuresGrouped[$version][$category][] = $feature;
}

// Count features by status for progress bars
$versionStats = [];
foreach ($versions as $version) {
    if (isset($featuresGrouped[$version])) {
        $completed = 0;
        $inProgress = 0;
        $planned = 0;
        $total = 0;
        
        foreach ($featuresGrouped[$version] as $category => $features) {
            foreach ($features as $feature) {
                $status = getItemStatus($feature);
                $total++;
                
                if ($status === 'completato') {
                    $completed++;
                } elseif ($status === 'in-corso') {
                    $inProgress++;
                } else {
                    $planned++;
                }
            }
        }
        
        $versionStats[$version] = [
            'completed' => $completed,
            'inProgress' => $inProgress,
            'planned' => $planned,
            'total' => $total,
            'completedPercentage' => $total > 0 ? round(($completed / $total) * 100) : 0,
            'inProgressPercentage' => $total > 0 ? round(($inProgress / $total) * 100) : 0,
            'plannedPercentage' => $total > 0 ? round(($planned / $total) * 100) : 0
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Roadmap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles_roadmap.css">
    <link rel="stylesheet" href="css/styles_header.css">
    <link rel="stylesheet" href="css/styles_footer.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary-color: #10b981;
            --completed-color: #10b981;
            --in-progress-color: #f59e0b;
            --planned-color: #64748b;
            --text-color: #1e293b;
            --text-light: #64748b;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --header-gradient-start: #6366f1;
            --header-gradient-end: #8b5cf6;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --rounded-sm: 0.25rem;
            --rounded-md: 0.375rem;
            --rounded-lg: 0.5rem;
            --rounded-xl: 0.75rem;
            --rounded-2xl: 1rem;
            --transition-normal: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            font-size: 16px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: linear-gradient(135deg, var(--header-gradient-start), var(--header-gradient-end));
            color: white;
            padding: 60px 0 30px;
            margin-bottom: 40px;
            text-align: center;
            border-radius: 0 0 var(--rounded-2xl) var(--rounded-2xl);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 80%);
            opacity: 0.4;
            pointer-events: none;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 800;
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .roadmap {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 50px;
            margin-top: 125px;
        }

        .version-container {
            border-radius: var(--rounded-xl);
            overflow: hidden;
            background-color: var(--card-bg);
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            border: 1px solid var(--border-color);
        }

        .version-container:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .version-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 15px;
            position: relative;
        }

        .version-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .version-title {
            font-size: 1.3rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .version-badge {
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }

        .collapse-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            transition: var(--transition-normal);
        }

        .collapse-icon.rotate {
            transform: rotate(180deg);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .progress-container {
            height: 8px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            transition: width 0.5s ease;
        }

        .progress-completed {
            background-color: var(--completed-color);
        }

        .progress-in-progress {
            background-color: var(--in-progress-color);
        }

        .progress-planned {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .progress-stats {
            display: flex;
            gap: 20px;
            font-size: 0.85rem;
            margin-top: 10px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot-completed {
            background-color: var(--completed-color);
        }

        .dot-in-progress {
            background-color: var(--in-progress-color);
        }

        .dot-planned {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .version-content {
            padding: 25px;
            display: none;
        }

        .version-content.active {
            display: block;
        }

        .category-container {
            margin-bottom: 25px;
            border-radius: var(--rounded-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
        }

        .category-header {
            background-color: #f1f5f9;
            padding: 15px 20px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition-normal);
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }

        .category-header:hover {
            background-color: #e2e8f0;
        }

        .category-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .category-content {
            padding: 0;
            display: none;
        }

        .category-content.active {
            display: block;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .feature-card {
            border-radius: var(--rounded-lg);
            padding: 20px;
            background-color: white;
            transition: var(--transition-normal);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            transition: var(--transition-normal);
        }

        .feature-card.completed::before {
            background-color: var(--completed-color);
        }

        .feature-card.in-progress::before {
            background-color: var(--in-progress-color);
        }

        .feature-card.planned::before {
            background-color: var(--planned-color);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .feature-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }

        .feature-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-color);
            line-height: 1.4;
        }

        .feature-status {
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 20px;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            white-space: nowrap;
            margin-left: 10px;
        }

        .feature-status.completed {
            background-color: var(--completed-color);
        }

        .feature-status.in-progress {
            background-color: var(--in-progress-color);
        }

        .feature-status.planned {
            background-color: var(--planned-color);
        }

        .feature-description {
            color: var(--text-light);
            margin-bottom: 20px;
            line-height: 1.6;
            flex: 1;
        }

        .feature-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: auto;
            font-size: 0.85rem;
        }

        .feature-type {
            padding: 5px 10px;
            border-radius: 20px;
            background-color: #f1f5f9;
            color: var(--text-color);
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .feature-dates {
            color: var(--text-light);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }

        .tag {
            background-color: #e0e7ff;
            color: var(--primary-dark);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .loader {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid var(--primary-color);
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-light);
        }

        /* Simplified timeline for mobile */
        .mobile-timeline {
            display: none;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            header {
                padding: 40px 0 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .version-header {
                padding: 15px 20px;
            }

            .version-title {
                font-size: 1.1rem;
            }

            .progress-stats {
                flex-wrap: wrap;
            }

            .feature-title-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .feature-status {
                margin-left: 0;
                margin-top: 5px;
            }

            .feature-meta {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .version-header-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .collapse-icon {
                position: absolute;
                right: 15px;
                top: 15px;
            }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader initially
            document.body.insertAdjacentHTML('afterbegin', '<div id="page-loader" class="loader-container"><div class="loader"></div></div>');
            
            setTimeout(() => {
                document.getElementById('page-loader').style.display = 'none';
            }, 500);

            // Handle version container clicks
            const versionHeaders = document.querySelectorAll('.version-header');
            versionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetContent = document.getElementById(targetId);
                    const icon = this.querySelector('.collapse-icon .fas');
                    
                    targetContent.classList.toggle('active');
                    this.querySelector('.collapse-icon').classList.toggle('rotate');
                });
            });

            // Handle category container clicks
            const categoryHeaders = document.querySelectorAll('.category-header');
            categoryHeaders.forEach(header => {
                header.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const targetId = this.getAttribute('data-target');
                    const targetContent = document.getElementById(targetId);
                    const icon = this.querySelector('.collapse-icon .fas');
                    
                    targetContent.classList.toggle('active');
                    this.querySelector('.collapse-icon').classList.toggle('rotate');
                });
            });

            // Add animation to feature cards
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + (index * 50));
            });

            // Open first version by default (optional)
            if (versionHeaders.length > 0) {
                setTimeout(() => {
                    versionHeaders[0].click();
                    
                    // Open first category in the first version
                    const firstVersionId = versionHeaders[0].getAttribute('data-target');
                    const firstVersionCategories = document.querySelectorAll(`#${firstVersionId} .category-header`);
                    if (firstVersionCategories.length > 0) {
                        firstVersionCategories[0].click();
                    }
                }, 700);
            }
        });
    </script>
</body>
</html>