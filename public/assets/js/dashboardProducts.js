// FOR NEW ARRIVALS
document.addEventListener('DOMContentLoaded', function () {
    fetch('/home/products')
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                const productBoxes = document.querySelectorAll('.innerProdCon');

                data.data.slice(0, 4).forEach((product, index) => {
                    const container = productBoxes[index];
                    if (!container) return;

                    const imageBox = container.querySelector('.innerProdItems');
                    const nameTag = container.querySelector('.nTag');
                    const priceTag = container.querySelector('.pTag');
                    const quickView = container.querySelector('.innerA');

                    const img = new Image();
                    img.src = `/${product.prod_img}`;
                    img.onload = () => {
                        imageBox.style.backgroundImage = `url('${img.src}')`;
                        imageBox.style.backgroundSize = 'cover';
                        imageBox.style.backgroundPosition = 'center';

                        imageBox.classList.remove('skeleton');
                        nameTag.classList.remove('skeleton-text');
                        priceTag.classList.remove('skeleton-text');

                        nameTag.textContent = decodeHtml(product.prod_name);
                        priceTag.textContent = `₱${product.prod_price}`;
                        quickView.setAttribute('data-id', product.prod_id);
                    };
                });


                setTimeout(() => {
                    document.querySelectorAll('.innerA').forEach(qv => {
                        qv.addEventListener('click', function (e) {
                            e.preventDefault();
                            const prodId = this.getAttribute('data-id');
                            if (prodId) {
                                openQuickView(prodId);
                            }
                        });
                    });
                }, 100);

            } else {
                console.error('No products found:', data.message);
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
        });
});

//QUICK VIEW MODAL
function openQuickView(prodId) {
    fetch(`/home/product/${prodId}`)
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                const product = data.data;

                const modal = document.getElementById('quickViewModal');
                const price = parseFloat(product.prod_price);

                modal.querySelector('.product-img').src = `/${product.prod_img}`;
                modal.querySelector('.product-title').textContent = decodeHtml(product.prod_name);
                modal.querySelector('.price').textContent = `₱${price.toFixed(2)}`;
                modal.querySelector('.description').textContent = decodeHtml(product.prod_desc);

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

                const addToCartBtn = document.querySelector(".add-to-cart-btn");
                addToCartBtn.setAttribute("data-id", product.prod_id);


                addToCartBtn.onclick = () => {

                    addToCart(product.prod_id);
                };

            } else {
                alert('Product not found.');
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
        });
}
function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}
function closeModal() {
    document.getElementById('quickViewModal').classList.remove('show');
}





// GET PRODUCTS
document.addEventListener('DOMContentLoaded', () => {
    fetch('/home/all-products')
        .then(res => res.json())
        .then(products => {
            const mainContainer = document.querySelector('.prodBackCon2');
            const productContainers = document.querySelectorAll('.prodBackCon2 .innerProdCon');


            if (products.length === 0) {
                mainContainer.style.display = 'none';


                mainContainer.insertAdjacentHTML('afterend', `
                    <div class="empty-products-message">
                        No products available. <a href="/">About us</a>
                    </div>
                `);
                return;
            }


            productContainers.forEach((container, index) => {
                if (products[index]) {
                    const product = products[index];
                    const imageBox = container.querySelector('.innerProdItems');
                    const nameSpan = container.querySelector('.nTag');
                    const priceSpan = container.querySelector('.pTag');
                    const quickView = container.querySelector('.innerA');

                    imageBox.classList.remove('skeleton');
                    nameSpan.classList.remove('skeleton-text');
                    priceSpan.classList.remove('skeleton-text');

                    const img = new Image();
                    img.src = `/${product.prod_img}`;
                    img.onload = () => {
                        imageBox.style.backgroundImage = `url('${img.src}')`;
                        imageBox.style.backgroundSize = 'cover';
                        imageBox.style.backgroundPosition = 'center';
                    };

                    nameSpan.textContent = product.prod_name;
                    priceSpan.textContent = `₱${product.prod_price}`;
                    quickView.setAttribute('data-id', product.prod_id);
                } else {
                    container.style.display = 'none';
                }
            });
        })
        .catch(err => {
            console.error('Error loading all products:', err);
        });
});

