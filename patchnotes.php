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
    <link rel="stylesheet" href="css/styles_header.css">
    <link rel="stylesheet" href="css/styles_footer.css">
</head>

<body>

    <?php include "header.php"; ?>

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

    <?php include "footer.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const views = document.querySelectorAll('.view');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
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

                    if (itemPosition.top < window.innerHeight - 100) {
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
                toggle.addEventListener('click', function (e) {
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

            // Hamburger menu toggle
            const hamburger = document.querySelector('.hamburger');
            const mobileMenu = document.querySelector('.mobile-menu');

            hamburger.addEventListener('click', function () {
                hamburger.classList.toggle('active');
                mobileMenu.classList.toggle('active');
            });
        });
    </script>
</body>

</html>