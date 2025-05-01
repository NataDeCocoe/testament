document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("l-form");
    const emailInput = document.getElementById("floatingInput");
    const passwordInput = document.getElementById("floatingPassword");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passError");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        let isValid = true;


        if (emailInput.value.trim() === "") {
            emailInput.classList.add("is-invalid");
            emailError.textContent = "Email is required";
            emailError.style.display = "block";
            isValid = false;
        } else {
            emailInput.classList.remove("is-invalid");
            emailInput.classList.add("is-valid");
            emailError.style.display = "none";
        }


        if (passwordInput.value.trim() === "") {
            passwordInput.classList.add("is-invalid");
            passwordError.textContent = "Password is required";
            passwordError.style.display = "block";
            isValid = false;
        } else if (passwordInput.value.trim().length < 6) {
            passwordInput.classList.add("is-invalid");
            passwordError.textContent = "Password must be at least 6 characters";
            passwordError.style.display = "block";
            isValid = false;
        } else {
            passwordInput.classList.remove("is-invalid");
            passwordInput.classList.add("is-valid");
            passwordError.style.display = "none";
        }

        if (isValid) {
            window.location.href = "homepage.html";
        }
    });


    emailInput.addEventListener("input", function () {
        if (emailInput.value.trim() !== "") {
            emailInput.classList.remove("is-invalid");
            emailInput.classList.add("is-valid");
            emailError.style.display = "none";
        }
    });


    passwordInput.addEventListener("input", function () {
        if (passwordInput.value.trim().length >= 6) {
            passwordInput.classList.remove("is-invalid");
            passwordInput.classList.add("is-valid");
            passwordError.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-link");
    const currentPage = window.location.pathname.split("/").pop(); // Get current page file name


    links.forEach(link => link.classList.remove("active"));


    links.forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();

        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById('chk-box');
    const button = document.getElementById('r-button');

    checkbox.addEventListener("change", function () {
        if (this.checked) {
            button.classList.remove("disabled-button");
            button.classList.add("enabled-button");
            button.disabled = false; // Enable button
        } else {
            button.classList.remove("enabled-button");
            button.classList.add("disabled-button");
            button.disabled = true; // Disable button
        }
    });
});


// shortcut to admin
document.addEventListener("keydown", function(event) {
    if (event.altKey && event.shiftKey && event.key.toLowerCase() === "l") {
        let aPanel = document.getElementById('admin');
        aPanel.classList.remove('hidden');
        aPanel.classList.add('show')

    }
});

document.addEventListener("click");
function adminDashboard(){
    window.location.href = 'adminDashboard.html'
}
