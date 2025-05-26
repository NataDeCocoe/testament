
 <!--PRODUCT LIST-->
<div class="orders-container" >
    <div class="orders-header">
        <div class="col">Product Code</div>
        <div class="col">Product Name</div>
        <div class="col">Description</div>
        <div class="col">Quantity</div>
        <div class="col">Price</div>
        <div class="col">Date Created</div>
        <div class="col">Action</div>
    </div>

    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="orders-row">
                <div class="col"><small><?= htmlspecialchars($product['prod_code']) ?></small></div>
                <div class="col"><small><?= html_entity_decode($product['prod_name']) ?></small></div>
                <div class="col"><small><?= html_entity_decode($product['prod_desc']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars($product['prod_quan']) ?></small></div>
                <div class="col"><span><small>₱</small></span><small><?= htmlspecialchars($product['prod_price']) ?></small></div>
                <div class="col"><small><?= htmlspecialchars(date('F j, Y', strtotime($product['created_at']))) ?></small></div>
                <div class="col actions">
                    <button class="edit-btn" data-id="<?= $product['prod_id'] ?>">
                        <i  class="fa-solid fa-edit"></i> Edit
                    </button>
                    <button class="delete-btn" data-id="<?= $product['prod_id'] ?>">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="orders-row defaultDisplay">
            <div class="col">No products found.</div>
        </div>
    <?php endif; ?>
</div>