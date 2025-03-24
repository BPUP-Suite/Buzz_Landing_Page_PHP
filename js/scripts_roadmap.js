document.addEventListener('DOMContentLoaded', function() {

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