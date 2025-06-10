function toggleSave(el) {
    const productId = el.getAttribute('data-product-id');

    if (!productId || isNaN(productId)) {
        console.error('Invalid productId:', productId);
        return;
    }

    // Toggle the visual state first
    el.classList.toggle('saved');
    const isSaved = el.classList.contains('saved');

    fetch('/saved/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + encodeURIComponent(productId)
    })
        .then(res => res.json())
        .then(data => {
            console.log('Server response:', data);
            // Show alert based on action
            if (isSaved) {
                showToast('Saved to your favorites.');
            } else {
                showToast('Removed from your favorites.');
            }
        })
        .catch(err => {
            console.error('Toggle save error:', err);
            // Revert the toggle if there was an error
            el.classList.toggle('saved');
            alert('There was a problem saving the item. Please try again.');
        });
}
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}
function showToastError(message, type = 'error') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}






function loadSavedItems() {
    fetch('/saved/get')
        .then(res => res.json())
        .then(items => {
            const container = document.querySelector('.savedItemsContainer');
            container.innerHTML = '';

            if (!items || items.length === 0) {
                container.innerHTML = '<p>No saved items yet.</p>';
                return;
            }

            items.forEach(item => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('innerProdCon');

                const safeName = decodeHtml(item.prod_name);

                wrapper.innerHTML = `
                    <div class="profileItemHistory">
                        <img class="img" src="${item.prod_img}" alt="${safeName}" width="90" height="100" onerror="this.src='/default.jpg';">
                        <div class="notifContent">
                            <h4 class="notifHeader">${safeName}</h4>
                            <p class="historyText">Saved item</p>
                        </div>
                        <div class="notifTimestamp">
                            <p class="historyStatus"><small>Saved</small></p>
                        </div>
                    </div>
                `;

                container.appendChild(wrapper);
            });
        })
        .catch(err => {
            console.error('Failed to load saved items:', err);
        });
}

function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

document.addEventListener("DOMContentLoaded", loadSavedItems);


