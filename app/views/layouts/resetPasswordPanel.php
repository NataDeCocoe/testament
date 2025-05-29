<!--RESET-PASSWORD-->
<div class="container">
    <div class="icon">
        <span class="material-symbols-rounded" style="color: #61120C">lock_reset</span>
    </div>
    <h2>Reset Password</h2>
    <p>Enter your new password below.</p>

    <form id="resetPasswordForm">

        <input name="new_password" type="password" id="newPassword" placeholder="New Password" required />
        <input name="confirm_password" type="password" id="confirmPassword" placeholder="Confirm Password" required />
        <input type="hidden" id="token" value="<?= $_GET['token'] ?>">
        <p class="error-message" id="errorMessage"></p>
        <p class="success-message" id="successMessage"></p>
        <button class="resetPBTN" type="submit">Submit</button>
    </form>
</div>

<div class="shape circle1"></div>
<div class="shape circle2"></div>
<div class="shape rectangle1"></div>