document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value.trim();
    const errorMessage = document.querySelector('.error-message');
    const submitBtn = document.getElementById('submitBtn');

    if (!email) {
        errorMessage.textContent = 'Required! Please enter your email.';
        return;
    }

    submitBtn.disabled = true;
    errorMessage.style.color = 'orange';
    errorMessage.textContent = 'Sending please be patient...';

    try {
        const response = await fetch('/forgot-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email }),
        });

        const result = await response.json();

        if (result.success) {
            errorMessage.style.color = 'green';
            errorMessage.textContent = 'Reset link sent! Check your email.';
        } else {
            errorMessage.style.color = 'red';
            errorMessage.textContent = result.message || 'Failed to send reset link.';
        }
    } catch {
        errorMessage.style.color = 'red';
        errorMessage.textContent = 'Network error. Please try again.';
    } finally {
        submitBtn.disabled = false;
    }
});
