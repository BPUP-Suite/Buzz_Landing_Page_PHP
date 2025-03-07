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
    
} catch(PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

// Funzione per formattare le date
function formatDate($date) {
    return date("d/m/Y", strtotime($date));
}

// Funzione per determinare lo stato di un elemento
function getItemStatus($item) {
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
function getStatusClass($status) {
    switch($status) {
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
function getStatusIcon($status) {
    switch($status) {
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
function parseTags($tagsString) {
    if (empty($tagsString)) return [];
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
    <style>
        :root {
            --primary-color: #4a6cf7;
            --completed-color: #28a745;
            --in-progress-color: #fd7e14;
            --planned-color: #6c757d;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            padding: 20px;
        }
        
        .container {
            max-width: 2000px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #212529;
            margin-bottom: 10px;
        }
        
        .view-controls {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .tab-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #f0f0f0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .view {
            display: none;
        }
        
        .view.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Timeline View Styles (unchanged) */
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: #ddd;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
        }
        
        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            margin-bottom: 30px;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: white;
            border: 4px solid var(--primary-color);
            border-radius: 50%;
            top: 15px;
            z-index: 1;
        }
        
        .left {
            left: 0;
        }
        
        .right {
            left: 50%;
        }
        
        .left::after {
            right: -10px;
        }
        
        .right::after {
            left: -10px;
        }
        
        .timeline-content {
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: all 0.3s ease;
            max-height: 500px;   
            overflow-y: auto;   
        }
        
        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        /* Add scrollbar styling for timeline items to match patch cards */
        .timeline-content::-webkit-scrollbar {
            width: 8px;
        }

        .timeline-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .timeline-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .timeline-content::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .timeline-title {
            font-size: 18px;
            font-weight: bold;
            color: #212529;
        }
        
        .timeline-status {
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
        }
        
        .timeline-status i {
            margin-right: 5px;
        }
        
        .timeline-dates {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .timeline-tags {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        
        .tag {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
            background-color: rgba(74, 108, 247, 0.1);
            color: var(--primary-color);
            border-radius: 4px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .timeline-description {
            margin-top: 10px;
            font-size: 14px;
            color: #495057;
        }
        
        /* Improved Release Carousel Styles */
        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin: 30px 0 40px;
        }

        .carousel-wrapper {
            display: flex;
            transition: transform 0.3s ease;
            cursor: grab;
            min-height: 900px; 
            user-select: none;
        }

        .patch-content {
            font-size: 17px; /* Increased from 16px */
            line-height: 1.7; /* Increased from 1.6 */
            color: #333;
        }

        /* Navigation buttons - position them better with the larger cards */
        .carousel-nav {
            display: none;
        }


        /* Adjust responsive styles for mobile */
        @media screen and (max-width: 768px) {
            .patch-card {
                min-width: 95%; 
                max-width: 95%; 
                padding: 30px; 
            }
        }
        
        .carousel-wrapper.dragging {
            cursor: grabbing;
            transition: none;
        }
        
        .patch-card {
            min-width: 30%;
            max-width: 30%;
            flex: 0 0 auto;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 10px;
            background-color: white;
            overflow-y: auto;
            max-height: 900px;
            transition: all 0.3s ease;
            scroll-behavior: smooth;
        }
        
        .patch-card:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }
        
        .patch-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: var(--primary-color);
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .tag-toggle {
            font-size: 16px;
            cursor: pointer;
            background-color: rgba(74, 108, 247, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .tag-toggle:hover {
            background-color: rgba(74, 108, 247, 0.2);
        }
        
        .tag-container {
            display: none;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #eee;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .tag-container.show {
            display: flex;
            animation: fadeIn 0.3s;
        }
        
        .patch-tag {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 500;
            background-color: rgba(74, 108, 247, 0.1);
            color: var(--primary-color);
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .patch-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .patch-content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
    
        
        /* Scrollbar styling */
        .patch-card::-webkit-scrollbar {
            width: 8px;
        }
        
        .patch-card::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .patch-card::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .patch-card::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }
        
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        
        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-item::after {
                left: 20px;
            }
            
            .left::after, .right::after {
                left: 20px;
            }
            
            .right {
                left: 0;
            }
            
            .patch-card {
                min-width: 90%;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Roadmap di Progetto</h1>
            <p>Visualizza il piano di sviluppo e le prossime release</p>
        </header>
        
        <div class="view-controls">
            <button class="tab-button active" data-view="timeline-view">Timeline</button>
            <button class="tab-button" data-view="release-view">Release</button>
        </div>
        
        <!-- Timeline View (unchanged) -->
        <div id="timeline-view" class="view active">
            <div class="timeline">
                <?php 
                $counter = 0;
                foreach($roadmapItems as $item): 
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
                            <?php foreach($tags as $tag): ?>
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
                    <?php foreach($roadmapItems as $index => $item): 
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
                            <?php foreach($tags as $tag): ?>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const views = document.querySelectorAll('.view');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const viewId = this.getAttribute('data-view');
                    
                    // Remove active class from all buttons and views
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    views.forEach(view => view.classList.remove('active'));
                    
                    // Add active class to current button and view
                    this.classList.add('active');
                    document.getElementById(viewId).classList.add('active');
                });
            });
            
            // Make timeline items appear on scroll
            const timelineItems = document.querySelectorAll('.timeline-item');
            
            function checkScroll() {
                timelineItems.forEach(item => {
                    const itemPosition = item.getBoundingClientRect();
                    
                    if(itemPosition.top < window.innerHeight - 100) {
                        item.classList.add('show');
                    }
                });
            }
            
            // Initial check
            checkScroll();
            
            // Check on scroll
            window.addEventListener('scroll', checkScroll);
            
            // Toggle tags containers
            const tagToggles = document.querySelectorAll('.tag-toggle');
            
            tagToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const index = this.getAttribute('data-index');
                    const tagContainer = document.getElementById(`tags-${index}`);
                    tagContainer.classList.toggle('show');
                });
            });
            
            // Improved Carousel functionality
            const carousel = document.querySelector('.carousel-wrapper');
            const patchCards = document.querySelectorAll('.patch-card');
            const prevButton = document.querySelector('.prev-button');
            const nextButton = document.querySelector('.next-button');
            
            let currentIndex = 0;
            let startX = 0;
            let startTranslateX = 0;
            let isDragging = false;
            
            // Get the current translate X value
            function getTranslateX() {
                const style = window.getComputedStyle(carousel);
                const matrix = new WebKitCSSMatrix(style.transform);
                return matrix.m41;
            }
            
            // Set the carousel position with consistent limits
            function setCarouselPosition(position) {
                carousel.style.transform = `translateX(${position}px)`;
                
                // Calculate the visible card based on position
                const cardWidth = patchCards[0].offsetWidth;
                currentIndex = Math.round(Math.abs(position) / cardWidth);
                
                // Ensure currentIndex is within bounds
                currentIndex = Math.max(0, Math.min(currentIndex, patchCards.length - 1));
                
                // Update button states with consistent limits
                const visibleCards = getVisibleCardCount();
                prevButton.disabled = currentIndex === 0;
                nextButton.disabled = currentIndex >= patchCards.length - visibleCards;
            }
            
            // Go to specific slide with responsive limits
            function goToSlide(index) {
                const visibleCards = getVisibleCardCount();
                
                // Ensure index stays within boundaries
                index = Math.max(0, Math.min(index, patchCards.length - visibleCards));
                
                const cardWidth = patchCards[0].offsetWidth;
                const position = -index * cardWidth;
                carousel.style.transition = 'transform 0.3s ease';
                setCarouselPosition(position);
                
                // Update button states
                prevButton.disabled = index === 0;
                nextButton.disabled = index >= patchCards.length - visibleCards;
                
                // Reset transition after animation completes
                setTimeout(() => {
                    carousel.style.transition = '';
                }, 300);
            }
            
            // Initialize
            goToSlide(0);
            
            // Event listeners for navigation buttons
            prevButton.addEventListener('click', () => {
                goToSlide(currentIndex - 1);
            });
            
            nextButton.addEventListener('click', () => {
                goToSlide(currentIndex + 1);
            });
        
            
            // Touch and mouse events for dragging
            function dragStart(e) {
                if (carousel.style.transition) {
                    carousel.style.transition = '';
                }
                
                isDragging = true;
                carousel.classList.add('dragging');
                
                // Record the initial pointer position and the carousel's current position
                startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                startTranslateX = getTranslateX();
                
                // Prevent text selection during drag
                document.body.style.userSelect = 'none';
                
                if (e.type === 'touchstart') {
                    window.addEventListener('touchmove', drag, { passive: false });
                    window.addEventListener('touchend', dragEnd);
                } else {
                    window.addEventListener('mousemove', drag);
                    window.addEventListener('mouseup', dragEnd);
                }
            }
            
            function drag(e) {
                if (!isDragging) return;
                
                // Calculate how far the pointer has moved
                const x = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                const deltaX = x - startX;
                
                // Calculate max scroll position with responsive limits
                const cardWidth = patchCards[0].offsetWidth;
                const visibleCards = getVisibleCardCount();
                const maxScroll = -(patchCards.length - visibleCards) * cardWidth;
                
                // Add resistance when trying to drag beyond the bounds
                let newPosition = startTranslateX + deltaX;
                
                // Apply resistance when going beyond boundaries
                if (newPosition > 0) { 
                    // Resistance when dragging past first slide
                    newPosition = newPosition / 3;
                } else if (newPosition < maxScroll) {
                    // Resistance when dragging past last slide
                    newPosition = maxScroll + (newPosition - maxScroll) / 3;
                }
                
                // Move the carousel with resistance applied
                setCarouselPosition(newPosition);
                
                // Prevent default scrolling behavior when dragging
                e.preventDefault();
            }

            // Calculate visible cards based on viewport width
            function getVisibleCardCount() {
                // For mobile (width < 768px), show one card at a time
                if (window.innerWidth <= 768) {
                    return 1;
                } 
                // For desktop, show multiple cards
                return 3;
            }

            function dragEnd(e) {
                if (!isDragging) return;
                
                isDragging = false;
                carousel.classList.remove('dragging');
                
                // Calculate the card width and boundaries with responsive limits
                const cardWidth = patchCards[0].offsetWidth;
                const currentPosition = getTranslateX();
                const visibleCards = getVisibleCardCount();
                const maxScroll = -(patchCards.length - visibleCards) * cardWidth;
                
                // Apply smooth bounce animation
                carousel.style.transition = 'transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                
                // Determine where to snap
                if (currentPosition > 0) {
                    // Bounce back to first slide if pulled beyond start
                    goToSlide(0);
                } else if (currentPosition < maxScroll) {
                    // Bounce back to last slide if pulled beyond end
                    goToSlide(patchCards.length - visibleCards);
                } else {
                    // Normal snap to nearest
                    const nearestCardIndex = Math.round(Math.abs(currentPosition) / cardWidth);
                    goToSlide(nearestCardIndex);
                }
                
                // Re-enable text selection
                document.body.style.userSelect = '';
                
                // Remove event listeners
                window.removeEventListener('mousemove', drag);
                window.removeEventListener('mouseup', dragEnd);
                window.removeEventListener('touchmove', drag);
                window.removeEventListener('touchend', dragEnd);
            }
            
            // Attach drag events to carousel
            carousel.addEventListener('mousedown', dragStart);
            carousel.addEventListener('touchstart', dragStart, { passive: true });
            
            // Prevent default drag behavior on the carousel
            carousel.addEventListener('dragstart', e => e.preventDefault());
            
            // Handle window resize
            window.addEventListener('resize', () => {
                goToSlide(currentIndex);
            });
            
            // Allow keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (document.getElementById('release-view').classList.contains('active')) {
                    if (e.key === 'ArrowLeft' && currentIndex > 0) {
                        goToSlide(currentIndex - 1);
                    } else if (e.key === 'ArrowRight' && currentIndex < patchCards.length - 1) {
                        goToSlide(currentIndex + 1);
                    }
                }
            });
        });
    </script>
</body>
</html>