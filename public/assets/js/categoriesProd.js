document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".prodBackCon2");

    // Create skeleton loaders (unchanged)
    for (let i = 0; i < 8; i++) {
        container.innerHTML += `
            <div class="innerProdCon">
                <div class="innerProdItems skeleton">
                    <a class="innerA">Quick view</a>
                </div>
                <span class="nTag skeleton-text"></span>
                <span class="pTag skeleton-text"></span>
            </div>
        `;
    }

    fetch("/categories/products")
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                if (data.products.length === 0) {
                    container.style.display = "none";
                    container.insertAdjacentHTML("afterend", `
                        <div class="empty-products-message2">
                            No products available in this category.
                        </div>
                    `);
                    return;
                }

                container.innerHTML = "";

                data.products.forEach(product => {
                    const card = document.createElement("div");
                    card.classList.add("innerProdCon");

                    card.innerHTML = `
                        <div class="innerProdItems">
                            <a class="innerA">Quick view</a>
                        </div>
                        <span class="nTag">${product.prod_name}</span>
                        <span class="pTag">₱${product.prod_price}</span>
                    `;

                    const imageBox = card.querySelector(".innerProdItems");
                    const img = new Image();
                    img.src = `/${product.prod_img}`;
                    img.onload = () => {
                        imageBox.style.backgroundImage = `url('${img.src}')`;
                        imageBox.style.backgroundSize = 'cover';
                        imageBox.style.backgroundPosition = 'center';
                    };

                    container.appendChild(card);
                });
            }
        })
        .catch(err => {
            container.innerHTML = "<p>Error loading products.</p>";
            console.error("Fetch error:", err);
        });
});