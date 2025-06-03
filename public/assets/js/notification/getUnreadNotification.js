console.log('SCRIPT LOADED');
document.addEventListener('DOMContentLoaded', function () {

    const desktopBadge = document.getElementById('notif-count-desktop');
    const mobileBadge = document.getElementById('notif-count-mobile');


    if (!desktopBadge && !mobileBadge) return;

    fetch('/notifications/unread-count')
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {

                if (desktopBadge) {
                    desktopBadge.textContent = data.count;
                    desktopBadge.style.display = 'inline-block';
                }

                if (mobileBadge) {
                    mobileBadge.textContent = data.count;
                    mobileBadge.style.display = 'inline-block';
                }
            } else {

                if (desktopBadge) desktopBadge.style.display = 'none';
                if (mobileBadge) mobileBadge.style.display = 'none';
            }
        })
        .catch(err => {
            console.error('Error fetching notification count:', err);
        });
});