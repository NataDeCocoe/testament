document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const menuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu-collapse');

    // Log to debug if elements are found
    console.log('menuButton:', menuButton);
    console.log('mobileMenu:', mobileMenu);

    // Only attach event listeners if both elements exist
    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('show');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
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