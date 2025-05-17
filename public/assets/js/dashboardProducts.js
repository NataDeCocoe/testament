document.addEventListener('DOMContentLoaded', function () {
    fetch('/home/products')
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                const productBoxes = document.querySelectorAll('.innerProdCon');


                data.data.slice(0, 4).forEach((product, index) => {
                    const container = productBoxes[index];
                    if (!container) return;

                    const quickView = container.querySelector('.innerA');
                    const nameTag = container.querySelector('.nTag');
                    const priceTag = container.querySelector('.pTag');

                    quickView.setAttribute('data-id', product.prod_id); // for later quick view use
                    nameTag.textContent = product.prod_name;
                    priceTag.textContent = `₱${product.prod_price}`;
                });
            } else {
                console.error('No products found:', data.message);
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
        });
});
