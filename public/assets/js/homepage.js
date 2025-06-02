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



document.addEventListener('DOMContentLoaded', function() {

    const menuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu-collapse');


    console.log('menuButton:', menuButton);
    console.log('mobileMenu:', mobileMenu);


    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('show');
            document.body.classList.toggle('menu-open');
        });


        document.addEventListener('click', function(event) {
            if (mobileMenu.classList.contains('show')) {
                if (!event.target.closest('.mobile-side') && !event.target.closest('.mobile-menu-button')) {
                    mobileMenu.classList.remove('show');
                    document.body.classList.remove('menu-open');
                }
            }
        });
    } else {
        console.warn('Warning: One or more elements (.mobile-menu-button or .mobile-menu-collapse) not found in the DOM.');
    }
});

