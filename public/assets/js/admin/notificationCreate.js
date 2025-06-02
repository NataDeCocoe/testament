document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="/notifications/send"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        // Disable the button during upload
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerText = 'Sending...';

        fetch('/create-notification/send', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(text => {
                console.log('Response:', text);
                let data;
                try {
                    data = JSON.parse(text);
                } catch (err) {
                    console.error('Invalid JSON:', text);
                    alert('Server returned invalid response. Check console.');
                    button.disabled = false;
                    button.innerText = 'Send Notification';
                    return;
                }

                // Re-enable button
                button.disabled = false;
                button.innerText = 'Send Notification';

                // Handle success or error
                if (data.status === 'success') {
                    showToast('Notification sent successfully!');
                    form.reset();
                } else {
                    showToastError('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                button.disabled = false;
                button.innerText = 'Send Notification';
                showToastError('Network or server error occurred.');
            });
    });
});


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