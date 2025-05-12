
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
                <div class="col"><?= htmlspecialchars($product['prod_code']) ?></div>
                <div class="col"><?= htmlspecialchars($product['prod_name']) ?></div>
                <div class="col"><?= htmlspecialchars($product['prod_desc']) ?></div>
                <div class="col"><?= htmlspecialchars($product['prod_quan']) ?></div>
                <div class="col"><span>₱</span><?= htmlspecialchars($product['prod_price']) ?></div>
                <div class="col"><?= htmlspecialchars(date('F j, Y', strtotime($product['created_at']))) ?></div>
                <div class="col actions">
                    <button class="edit-btn">
                        <i class="fa-solid fa-edit"></i> Edit
                    </button>
                    <button class="delete-btn">
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