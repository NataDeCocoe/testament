

<!--NAVIGATION AND SIDEBAR-->
<nav>
    <div class="searchWrapper">
        <span class="material-symbols-rounded icon material-icons">search</span>
        <input class="search-bar" type="search" placeholder="Search">
    </div>
    <div class="shoppingCartWrapper">
        <span class="material-symbols-rounded" id="sCart">shopping_cart</span>
        <span id="cartBadge" class="cart-badge">0</span>

        <div id="cartDropdown" class="cart-dropdown" style="display: none;">
            <div class="cart-items" id="cartItems"></div>
            <div class="cart-subtotal">
                <span id="subTotalLabel">SUB TOTAL</span>
                <strong id="cartSubtotal">₱0.00</strong>
            </div>
            <div class="cart-actions">
<!--                <button id="checkOutBTN" onclick="location.href='/checkout'">PROCEED TO CHECKOUT</button>-->
                <button id="viewCartBTN" onclick="location.href='/cart'">VIEW CART</button>
            </div>
        </div>
    </div>
</nav>
<aside class="side">
    <ul class="navCon">
        <li>
            <a href="/home">
                <span class="navIcon material-symbols-rounded <?= $_SERVER['REQUEST_URI'] === '/home' ? 'active' : '' ?>">home</span>
                <span class="<?= $_SERVER['REQUEST_URI'] === '/home' ? 'active' : '' ?>">Home</span>
            </a>
        </li>
        <li>
            <a href="/categories">
                <span class="navIcon material-symbols-rounded <?= $_SERVER['REQUEST_URI'] === '/categories' ? 'active' : '' ?>">category</span>
                <span class="<?= $_SERVER['REQUEST_URI'] === '/categories' ? 'active' : '' ?>">Categories</span>
            </a>
        </li>
        <li>
            <a href="/saved">
                <span class="navIcon material-symbols-rounded <?= $_SERVER['REQUEST_URI'] === '/saved' ? 'active' : '' ?>">bookmark</span>
                <span class="<?= $_SERVER['REQUEST_URI'] === '/saved' ? 'active' : '' ?>">Saved</span>
            </a>
        </li>
        <li>
            <a href="/notification">
                <span class="navIcon material-symbols-rounded <?= $_SERVER['REQUEST_URI'] === '/notification' ? 'active' : '' ?>">notifications</span>
                <span class="<?= $_SERVER['REQUEST_URI'] === '/notification' ? 'active' : '' ?>">Notification</span>
            </a>
        </li>
        <div class="invBlock2"></div>
        <li>
            <a href="/profile">
                <span class="navIcon material-symbols-rounded <?= $_SERVER['REQUEST_URI'] === '/profile' ? 'active' : '' ?>">account_circle</span>
                <span class="<?= $_SERVER['REQUEST_URI'] === '/profile' ? 'active' : '' ?>">Profile</span>
            </a>
        </li>
        <li>
            <a href="/logout">
                <span class="navIcon material-symbols-rounded">logout</span>
                <span>Logout</span>
            </a>
        </li>

        <div class="invBlock"></div>
        <li>
            <button class="material-symbols-rounded bDisplay" onclick="this.classList.toggle('chevLeft')" type="button" id="chevron">
                chevron_right

            </button>
        </li>
    </ul>
</aside>