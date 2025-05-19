document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".prodBackCon2");

    for (let i = 0; i < 3; i++) {
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
                            <a class="innerA" data-id="${product.prod_id}">Quick view</a>
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


                document.querySelectorAll('.innerA').forEach(qv => {
                    qv.addEventListener('click', function (e) {
                        e.preventDefault();
                        const prodId = this.getAttribute('data-id');
                        if (prodId) {
                            console.log("Clicked")
                            openQuickView2(prodId);
                        }
                    });
                });
            }
        })
        .catch(err => {
            container.innerHTML = "<p>Error loading products.</p>";
            console.error("Fetch error:", err);
        });
});

//Quickview
function openQuickView2(prodId) {
    fetch(`/home/product/${prodId}`)
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                const product = data.data;

                const modal = document.getElementById('quickViewModal');
                const price = parseFloat(product.prod_price);

                modal.querySelector('.product-img').src = `/${product.prod_img}`;
                modal.querySelector('.product-title').textContent = product.prod_name;
                modal.querySelector('.price').textContent = `₱${price.toFixed(2)}`;
                modal.querySelector('.description').textContent = product.prod_desc;

                const quantityInput = modal.querySelector(".quantity-wrap input");
                const totalPriceElem = modal.querySelector(".total-price");

                quantityInput.value = 1;
                totalPriceElem.textContent = `₱${price.toFixed(2)}`;


                quantityInput.replaceWith(quantityInput.cloneNode(true));
                const newQuantityInput = modal.querySelector(".quantity-wrap input");


                newQuantityInput.addEventListener("input", () => {
                    let qty = parseInt(newQuantityInput.value) || 1;
                    if (qty < 1) qty = 1;
                    newQuantityInput.value = qty;
                    const total = qty * price;
                    totalPriceElem.textContent = `₱${total.toFixed(2)}`;
                });

                modal.classList.add('show');
            } else {
                alert('Product not found.');
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
        });
}


function closeModalC() {
    document.getElementById('quickViewModal').classList.remove('show');
}