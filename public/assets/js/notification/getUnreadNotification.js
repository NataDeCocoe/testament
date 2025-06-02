console.log('SCRIPT LOADED');
document.addEventListener('DOMContentLoaded', function () {
    const badge = document.getElementById('notif-count');
    if (!badge) return;

    fetch('/notifications/unread-count')
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(err => {
            console.error('Error fetching notification count:', err);
        });
});