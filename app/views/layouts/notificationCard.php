<?php if (!empty($notifications)): ?>
    <?php foreach ($notifications as $notif): ?>
        <div class="notifCard">
            <img src="<?= htmlspecialchars($notif['img'] ?? '/assets/images/promotion.png') ?>" alt="Notification">
            <div class="notifContent">
                <div class="notifHeader">
                    <h4><?= htmlspecialchars($notif['title']) ?></h4>
                    <div class="notifTimestamp"><?= date('H:i', strtotime($notif['created_at'])) ?></div>
                </div>
                <p class="notifText"><?= nl2br(htmlspecialchars($notif['message'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="notifCard" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 300px; text-align: center; padding: 40px; background: transparent; border-radius: 8px; margin: 0 auto; max-width: 100%;">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#a0a0a0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.7; margin-bottom: 20px;">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        <div class="notifContent" style="width: 100%;">
            <div class="notifHeader" style="justify-content: center; margin-bottom: 10px;">
                <h4 style="color: #555; font-size: 1.2rem; font-weight: 500;">No notifications yet</h4>
            </div>
            <p class="notifText" style="color: #777; font-size: 0.9rem; line-height: 1.5; max-width: 400px; margin: 0 auto;">
                You'll see notifications here when you receive them
            </p>
        </div>
    </div>
<?php endif; ?>


