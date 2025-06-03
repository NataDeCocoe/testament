<div class="prodBackCon2">
    <div class="innerProdCon">
        <div class="innerProdItems skeleton">
            <a class="innerA">Quick view</a>
        </div>
        <span class="nTag skeleton-text"></span>
        <span class="pTag skeleton-text"></span>
    </div>
</div>

<div id="quickViewModal" class="modal">
    <div class="modal-content">

        <span class="close-modal" onclick="closeModalC()">&times;</span>

        <div class="modal-body">
   <span class="save-icon" onclick="toggleSave(this)">
    <svg class="save-svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#a0a0a0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 21s-6.5-4.5-9-9c-1.5-3 0-7 4.5-7 2.5 0 4 1.5 4.5 2 0.5-0.5 2-2 4.5-2 4.5 0 6 4 4.5 7-2.5 4.5-9 9-9 9z"></path>
    </svg>
</span>


            <div class="modal-left">
                <img src="" alt="Product Image" class="product-img">
            </div>

            <div class="modal-right">
                <h2 class="product-title"></h2>
                <div class="rating">★★★★☆ <span>(4.5 - 120 reviews)</span></div>
                <h3 class="price"></h3>
                <p class="description"></p>

                <div class="quantity-wrap">
                    <label>Quantity:</label>
                    <input type="number" value="1" min="1">
                </div>

                <h3 class="total-price"></h3>
                <button class="add-to-cart-btn">Add to cart</button>
            </div>
        </div>
    </div>
</div>