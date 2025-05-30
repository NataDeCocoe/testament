<div class="orders-container">
    <div class="orders-header">

        <div class="col">Name</div>
        <div class="col">Courier</div>
        <div class="col">Date</div>
        <div class="col">Total Amount</div>
        <div class="col">Method of Payment</div>
        <div class="col">Order Status</div>
        <div class="col">Payment Status</div>
    </div>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="orders-row" data-id="<?= $order['order_id'] ?>">
                <div class="col"><small><?= htmlspecialchars($order['ord_fname'] . ' ' . $order['ord_lname']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars($order['courier']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars(date('F j, Y', strtotime($order['ordered_at']))) ?></small></div>
                <div class="col"><span><small>₱</small></span> <small><?= htmlspecialchars($order['total_amount']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars($order['payment_method']) ?></small></div>

                <!-- Order Status -->
                <select class="col status order-status" data-id="<?= $order['order_id'] ?>">
                    <option value="approved" <?= $order['order_status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="processing" <?= $order['order_status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                    <option value="shipped" <?= $order['order_status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="completed" <?= $order['order_status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="canceled" <?= $order['order_status'] === 'canceled' ? 'selected' : '' ?>>Canceled</option>
                </select>

                <!-- Payment Status -->
                <select class="col status payment-status" data-id="<?= $order['order_id'] ?>" required>
                    <option value="Unpaid" <?= $order['payment_status'] == 'Unpaid' ? 'selected' : '' ?>>Unpaid</option>
                    <option value="Paid" <?= $order['payment_status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="Failed" <?= $order['payment_status'] == 'Failed' ? 'selected' : '' ?>>Failed</option>
                </select>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="orders-row defaultDisplay">
            <div class="col">No orders found.</div>
        </div>
    <?php endif; ?>
</div>