window.addEventListener('DOMContentLoaded', () => {
    loadAllSectionsInSync();
});

function loadAllSectionsInSync() {
    Promise.all([loadNewArrivals(), loadAllProducts()])
        .then(() => {
            console.log('All product sections loaded and skeletons removed');
        })
        .catch(err => {
            console.error('Error loading sections:', err);
        });
}


// ========== LOAD NEW ARRIVALS ==========
function loadNewArrivals() {
    fetch('/home/products')
        .then(res => res.json())
        .then(data => {
            if (!data.status || !Array.isArray(data.data)) {
                console.error('No products found:', data.message);
                return;
            }

            const productBoxes = document.querySelectorAll('.innerProdCon');
            const products = data.data.slice(0, 4);
            const loadPromises = [];

            products.forEach((product, index) => {
                const container = productBoxes[index];
                if (!container) return;


                const img = new Image();
                img.src = `/${product.prod_img}`;
                const loadPromise = new Promise((resolve) => {
                    img.onload = () => {
                        resolve({ container, product, img });
                    };
                });

                loadPromises.push(loadPromise);
            });

            Promise.all(loadPromises).then(loadedProducts => {
                loadedProducts.forEach(({ container, product, img }) => {
                    const imageBox = container.querySelector('.innerProdItems');
                    const nameTag = container.querySelector('.nTag');
                    const priceTag = container.querySelector('.pTag');
                    const quickView = container.querySelector('.innerA');

                    imageBox.style.backgroundImage = `url('${img.src}')`;
                    imageBox.style.backgroundSize = 'cover';
                    imageBox.style.objectFit = 'cover'
                    imageBox.style.backgroundPosition = 'center';

                    imageBox.classList.remove('skeleton');
                    nameTag.classList.remove('skeleton-text');
                    priceTag.classList.remove('skeleton-text');

                    nameTag.textContent = decodeHtml(product.prod_name);
                    priceTag.textContent = `₱${product.prod_price}`;
                    quickView.setAttribute('data-id', product.prod_id);
                });

                setTimeout(() => {
                    document.querySelectorAll('.innerA').forEach(qv => {
                        qv.addEventListener('click', function (e) {
                            e.preventDefault();
                            const prodId = this.getAttribute('data-id');
                            if (prodId) openQuickView(prodId);
                        });
                    });
                }, 100);
            });

        })
        .catch(err => {
            console.error('Fetch error:', err);
        });
}


// ========== LOAD ALL PRODUCTS ==========
function loadAllProducts() {
    const mainContainer = document.querySelector('.prodBackCon2');
    const productContainers = document.querySelectorAll('.prodBackCon2 .innerProdCon');

    // 1. Show skeletons for all
    productContainers.forEach(container => {
        const imageBox = container.querySelector('.innerProdItems');
        const nameSpan = container.querySelector('.nTag');
        const priceSpan = container.querySelector('.pTag');

        imageBox.classList.add('skeleton');
        nameSpan.classList.add('skeleton-text');
        priceSpan.classList.add('skeleton-text');

        nameSpan.textContent = '';
        priceSpan.textContent = '';
        imageBox.style.backgroundImage = '';
    });

    // 2. Fetch product data
    fetch('/home/all-products')
        .then(res => res.json())
        .then(products => {
            if (!products || products.length === 0) {
                mainContainer.style.display = 'none';
                mainContainer.insertAdjacentHTML('afterend', `
                    <div class="empty-products-message">
                        No products available. <a href="/">About us</a>
                    </div>
                `);
                return;
            }

            const loadPromises = [];

            productContainers.forEach((container, index) => {
                if (products[index]) {
                    const product = products[index];

                    const img = new Image();
                    img.src = `/${product.prod_img}`;

                    // Only resolve when image is fully loaded
                    const loadPromise = new Promise(resolve => {
                        img.onload = () => {
                            resolve({ container, product, img });
                        };
                        img.onerror = () => {
                            console.warn(`Image failed to load for: ${product.prod_name}`);
                            resolve({ container, product, img: null });
                        };
                    });

                    loadPromises.push(loadPromise);
                } else {
                    container.style.display = 'none';
                }
            });

            // 3. Once ALL images are ready, then populate data
            Promise.all(loadPromises).then(loadedItems => {
                loadedItems.forEach(({ container, product, img }) => {
                    const imageBox = container.querySelector('.innerProdItems');
                    const nameSpan = container.querySelector('.nTag');
                    const priceSpan = container.querySelector('.pTag');
                    const quickView = container.querySelector('.innerA');

                    if (img) {
                        imageBox.style.backgroundImage = `url('${img.src}')`;
                        imageBox.style.backgroundSize = 'cover';
                        imageBox.style.backgroundPosition = 'center';
                    }

                    // Remove skeletons and apply data
                    imageBox.classList.remove('skeleton');
                    nameSpan.classList.remove('skeleton-text');
                    priceSpan.classList.remove('skeleton-text');

                    nameSpan.textContent = product.prod_name;
                    priceSpan.textContent = `₱${product.prod_price}`;
                    quickView.setAttribute('data-id', product.prod_id);
                });
            });
        })
        .catch(err => {
            console.error('Error loading all products:', err);
        });
}






// ========== QUICK VIEW MODAL ==========
function openQuickView(prodId) {
    fetch(`/home/product/${prodId}`)
        .then(res => res.json())
        .then(data => {
            if (!data.status) return alert('Product not found.');

            const product = data.data;
            const modal = document.getElementById('quickViewModal');
            const price = parseFloat(product.prod_price);

            modal.querySelector('.product-img').src = `/${product.prod_img}`;
            modal.querySelector('.product-title').textContent = decodeHtml(product.prod_name);
            modal.querySelector('.price').textContent = `₱${price.toFixed(2)}`;
            modal.querySelector('.description').textContent = decodeHtml(product.prod_desc);
            modal.querySelector('.save-icon').setAttribute('data-product-id', product.prod_id);

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
                totalPriceElem.textContent = `₱${(qty * price).toFixed(2)}`;
            });

            modal.classList.add('show');

            const addToCartBtn = document.querySelector(".add-to-cart-btn");
            addToCartBtn.setAttribute("data-id", product.prod_id);
            addToCartBtn.onclick = () => addToCart(product.prod_id);
        })
        .catch(err => console.error('Fetch error:', err));
}


// ========== HELPERS ==========
function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

function closeModal() {
    document.getElementById('quickViewModal').classList.remove('show');
}








