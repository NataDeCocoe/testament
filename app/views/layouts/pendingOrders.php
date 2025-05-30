<div class="orders-container">
    <div class="orders-header">
        <div class="col">Name</div>
        <div class="col">Lastname</div>
        <div class="col">Date</div>
        <div class="col">Total Amount</div>
        <div class="col">Method of Payment</div>
        <div class="col">Action</div>
    </div>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="orders-row" data-id="<?= $order['order_id'] ?>">
                <div class="col"><small><?= htmlspecialchars($order['ord_fname']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars($order['ord_lname']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars(date('F j, Y', strtotime($order['ordered_at']))) ?></small></div>
                <div class="col"><span><small>₱</small></span><small><?= htmlspecialchars($order['total_amount']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars($order['payment_method']) ?></small></div>
                <div class="col actions">
                    <button class="edit-btn" data-id="<?= $order['order_id'] ?>">
                        <i class="fa-solid fa-check"></i> Approved
                    </button>
                    <button class="delete-btn" data-id="<?= $order['order_id'] ?>">
                        <i class="fa-solid fa-close"></i> Reject
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="orders-row defaultDisplay">
            <div class="col">No pending orders found.</div>
        </div>
    <?php endif; ?>

</div>