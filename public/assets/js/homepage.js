document.addEventListener('DOMContentLoaded', function() {
    // Carousel code
    const images = [
        '/assets/images/book.jpg',
        '/assets/images/book2.jpg',
        '/assets/images/book3.jpg'
    ];

    let currentIndex = 0;
    const container = document.getElementById('caro');

    if (container) {
        container.style.backgroundImage = `url(${images[currentIndex]})`;

        function transitionToNextImage() {
            container.classList.add('fade-out');
            setTimeout(() => {
                currentIndex = (currentIndex + 1) % images.length;
                container.style.backgroundImage = `url(${images[currentIndex]})`;
                container.classList.remove('fade-out');
            }, 1000);
        }
        setInterval(transitionToNextImage, 4000);
    }

    // Profile picture upload
    const fileInput = document.getElementById('fileInput');
    const profilePic = document.getElementById('profilePic');

    if (fileInput && profilePic) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Mobile menu toggle - Simplified version
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-side');
    const body = document.body;

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('mobile-show');
            body.classList.toggle('sidebar-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (body.classList.contains('sidebar-open') &&
                !mobileMenu.contains(e.target) &&
                e.target !== mobileMenuButton) {
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('mobile-show');
                body.classList.remove('sidebar-open');
            }
        });
    }
});



