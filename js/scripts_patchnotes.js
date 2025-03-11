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
    
    // Skip carousel setup if no cards exist
    if (!carousel || patchCards.length === 0) return;

    let currentIndex = 0;
    let startX = 0;
    let startTime = 0;
    let isDragging = false;
    let initialScrollTop = 0;
    let isScrolling = false;
    
    // Calculate proper card width including margins
    function getCardWidth() {
        if (patchCards.length === 0) return 0;
        const card = patchCards[0];
        const style = window.getComputedStyle(card);
        
        // Get actual width including margins
        const width = card.offsetWidth + 
                     parseInt(style.marginLeft) + 
                     parseInt(style.marginRight);
        return width;
    }

    // Get the current translate X value
    function getTranslateX() {
        const style = window.getComputedStyle(carousel);
        const matrix = new WebKitCSSMatrix(style.transform);
        return matrix.m41;
    }

    // Set the carousel position with improved limits
    function setCarouselPosition(position) {
        const cardWidth = getCardWidth();
        const visibleCards = getVisibleCardCount();
        
        // Calculate maximum scroll with improved end margin handling
        const totalCardsWidth = patchCards.length * cardWidth;
        const viewportWidth = carousel.parentElement.offsetWidth;
        
        // THIS IS THE KEY CHANGE: Add extra space at the end to make sure 
        // the last card is fully visible when scrolled to the end
        const maxScroll = viewportWidth - totalCardsWidth - 40; // Add extra 40px padding
        
        // Apply position with improved bounds checking
        const boundedPosition = Math.max(maxScroll, Math.min(0, position));
        carousel.style.transform = `translateX(${boundedPosition}px)`;
        
        // Update current index based on position
        currentIndex = Math.min(Math.round(Math.abs(boundedPosition) / cardWidth), patchCards.length - 1);
        
        // Update button states if they exist
        if (prevButton) prevButton.disabled = currentIndex === 0;
        if (nextButton) nextButton.disabled = currentIndex >= patchCards.length - visibleCards;
    }

    // Go to specific slide with improved animation
    function goToSlide(index) {
        const cardWidth = getCardWidth();
        const visibleCards = getVisibleCardCount();
        
        // Make sure the last cards are fully visible
        const maxIndex = Math.max(0, patchCards.length - visibleCards);
        index = Math.max(0, Math.min(index, maxIndex));
        
        // Calculate position
        let position = -index * cardWidth;
        
        // If we're at the last possible index, make sure we scroll all the way to the end
        if (index >= maxIndex && patchCards.length > visibleCards) {
            // Get total width and viewport width
            const totalCardsWidth = patchCards.length * cardWidth;
            const viewportWidth = carousel.parentElement.offsetWidth;
            // Calculate exact position to see last card(s) fully
            position = viewportWidth - totalCardsWidth - 40; // 40px extra padding
        }
        
        carousel.style.transition = 'transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        setCarouselPosition(position);
        
        // Reset transition after animation completes
        setTimeout(() => {
            carousel.style.transition = '';
        }, 300);
    }

    // Calculate visible cards based on viewport width with better precision
    function getVisibleCardCount() {
        if (window.innerWidth < 768) {
            return 1; // Mobile: one card at a time
        } else if (window.innerWidth < 1200) {
            return 2; // Tablet: two cards
        } else {
            return 3; // Desktop: three cards
        }
    }

    // Improved drag handling
    function dragStart(e) {
        // Don't initiate drag if user is scrolling the content
        if (e.target.closest('.patch-content')) {
            const content = e.target.closest('.patch-content');
            initialScrollTop = content.scrollTop;
            
            // Allow scrolling if the content is scrollable
            if (content.scrollHeight > content.clientHeight) {
                if (e.type === 'touchstart') {
                    content.addEventListener('touchmove', checkIfScrolling, { passive: true });
                }
                return; // Don't start dragging if clicking inside scrollable content
            }
        }

        // Cancel any current transition
        carousel.style.transition = '';
        isDragging = true;
        carousel.classList.add('dragging');
        
        // Record start position and time
        startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        startTime = new Date().getTime();
        
        // Current carousel position
        const currentTranslateX = getTranslateX();
        
        // Prevent text selection
        document.body.style.userSelect = 'none';
        
        // Add event listeners based on event type
        if (e.type === 'touchstart') {
            window.addEventListener('touchmove', drag, { passive: false });
            window.addEventListener('touchend', dragEnd);
        } else {
            window.addEventListener('mousemove', drag);
            window.addEventListener('mouseup', dragEnd);
        }
    }
    
    // Helper to check if user is trying to scroll content
    function checkIfScrolling(e) {
        const content = e.target.closest('.patch-content');
        const currentScrollTop = content.scrollTop;
        
        // If scroll position changed, mark as scrolling
        if (Math.abs(currentScrollTop - initialScrollTop) > 5) {
            isScrolling = true;
            
            // Remove this event listener once we've determined scrolling
            content.removeEventListener('touchmove', checkIfScrolling);
        }
    }

    // Improved drag function
    function drag(e) {
        // Skip if not dragging or if scrolling content
        if (!isDragging || isScrolling) return;
        
        // Get current pointer position
        const x = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        const deltaX = x - startX;
        
        // Skip if the movement is too small (helps distinguish between taps and drags)
        if (Math.abs(deltaX) < 5) return;
        
        // Get current position and calculate new position
        const currentPosition = getTranslateX();
        const newPosition = currentPosition + deltaX;
        
        // Apply position
        setCarouselPosition(newPosition);
        
        // Update start position for next drag event
        startX = x;
        
        // Prevent default (page scrolling)
        e.preventDefault();
    }

    // Improved drag end function
    function dragEnd(e) {
        // Reset scrolling flag
        isScrolling = false;
        
        if (!isDragging) return;
        isDragging = false;
        carousel.classList.remove('dragging');
        
        // Calculate velocity for momentum scrolling
        const endTime = new Date().getTime();
        const timeElapsed = endTime - startTime;
        
        // Apply smooth animation for the snap
        carousel.style.transition = 'transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        
        // Snap to nearest card
        const cardWidth = getCardWidth();
        goToSlide(currentIndex);
        
        // Re-enable text selection
        document.body.style.userSelect = '';
        
        // Remove event listeners
        window.removeEventListener('mousemove', drag);
        window.removeEventListener('mouseup', dragEnd);
        window.removeEventListener('touchmove', drag);
        window.removeEventListener('touchend', dragEnd);
    }

    // Initialize carousel
    function initCarousel() {
        // Add CSS to improve card appearance
        const style = document.createElement('style');
        style.textContent = `
            .patch-card.active {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0, 85, 255, 0.15);
            }
            
            .patch-card {
                scroll-snap-align: center;
            }
            
            .carousel-wrapper {
                scroll-snap-type: x mandatory;
            }
        `;
        document.head.appendChild(style);
        
        // Set initial position
        goToSlide(0);
        
        // Attach event handlers
        carousel.addEventListener('mousedown', dragStart);
        carousel.addEventListener('touchstart', dragStart, { passive: true });
        carousel.addEventListener('dragstart', e => e.preventDefault());
        
        // Navigation buttons
        if (prevButton && nextButton) {
            prevButton.addEventListener('click', () => goToSlide(currentIndex - 1));
            nextButton.addEventListener('click', () => goToSlide(currentIndex + 1));
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            // Recalculate and reposition with short delay
            setTimeout(() => goToSlide(currentIndex), 100);
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('release-view').classList.contains('active')) {
                if (e.key === 'ArrowLeft' && currentIndex > 0) {
                    goToSlide(currentIndex - 1);
                } else if (e.key === 'ArrowRight') {
                    goToSlide(currentIndex + 1);
                }
            }
        });
    }
    
    // Initialize the carousel
    initCarousel();
});