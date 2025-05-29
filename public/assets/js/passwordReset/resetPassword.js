//SENDS RESET LINK TO EMAIL ADDRESS
document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('fpassemail').value.trim();
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


//RESET LINK
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('resetPasswordForm');

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Safely get elements with optional chaining
        const newPassword = document.getElementById('newPassword')?.value;
        const confirmPassword = document.getElementById('confirmPassword')?.value;
        const token = document.getElementById('token')?.value;
        const errorMessage = document.getElementById('errorMessage');

        // Validate inputs
        if (!newPassword || !confirmPassword || !token) {
            errorMessage.textContent = 'All fields are required!';
            return;
        }

        if (newPassword !== confirmPassword) {
            errorMessage.textContent = 'Passwords do not match!';
            return;
        }

        try {
            const response = await fetch('/reset-password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    new_password: newPassword,
                    confirm_password: confirmPassword,
                    token: token,
                    email: new URLSearchParams(window.location.search).get('email')
                })
            });

            const result = await response.json();

            if (response.ok) {
                alert('Password reset successful!');
                window.location.href = '/login?reset=success';
            } else {
                errorMessage.textContent = result.message;
            }
        } catch (error) {
            errorMessage.textContent = 'Network error. Please try again.';
        }
    });
});
