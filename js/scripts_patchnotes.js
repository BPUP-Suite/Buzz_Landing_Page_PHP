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
        // Per mobile (< 768px), mostra una card alla volta
        if (window.innerWidth < 768) {
            return 1;
        }
        // Per tablet (< 1200px), mostra due card alla volta 
        else if (window.innerWidth < 1200) {
            return 2;
        }
        // Per desktop, mostra tre card
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