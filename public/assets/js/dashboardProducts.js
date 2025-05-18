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
