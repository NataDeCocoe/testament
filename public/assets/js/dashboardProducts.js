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


                        nameTag.textContent = product.prod_name;
                        priceTag.textContent = `₱${product.prod_price}`;
                        quickView.setAttribute('data-id', product.prod_id);
                    };
                });
            } else {
                console.error('No products found:', data.message);
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
        });
});

// GET PRODUCTS
document.addEventListener('DOMContentLoaded', () => {
    fetch('/home/all-products')
        .then(res => res.json())
        .then(products => {
            const mainContainer = document.querySelector('.prodBackCon2');
            const productContainers = document.querySelectorAll('.prodBackCon2 .innerProdCon');

            // Hide main container if no products
            if (products.length === 0) {
                mainContainer.style.display = 'none';

                // Optional: Add empty state message
                mainContainer.insertAdjacentHTML('afterend', `
                    <div class="empty-products-message">
                        No products available. <a href="/">About us</a>
                    </div>
                `);
                return;
            }

            // Your existing product rendering logic
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

