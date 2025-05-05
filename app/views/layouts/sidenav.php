

<!--NAVIGATION AND SIDEBAR-->
<nav>
    <div class="searchWrapper">
        <span class="material-symbols-rounded icon material-icons">search</span>
        <input class="search-bar" type="search" placeholder="Search">
    </div>
    <div class="shoppingCartWrapper">
        <span class="material-symbols-rounded" id="sCart">shopping_cart</span>
    </div>
</nav>
<aside class="side">
    <ul class="navCon">
        <li>
            <a href="/home">
                <span class="navIcon material-symbols-rounded">home</span>
                <span>Home</span>
            </a>
        </li>
        <li>
            <a href="/categories">
                <span class="navIcon material-symbols-rounded">category</span>
                <span>Categories</span>
            </a>
        </li>
        <li>
            <a href="/saved">
                <span class="navIcon material-symbols-rounded">bookmark</span>
                <span>Saved</span>
            </a>
        </li>
        <li>
            <a href="/notification">
                <span class="navIcon material-symbols-rounded">notifications</span>
                <span>Notification</span>
            </a>
        </li>
        <div class="invBlock2"></div>
        <li>
            <a href="#">
                <span class="navIcon material-symbols-rounded">account_circle</span>
                <span>Profile</span>
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