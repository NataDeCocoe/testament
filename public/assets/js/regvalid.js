document.addEventListener("DOMContentLoaded", function () {
    const rform = document.getElementById("r-form");
    const firstName = document.getElementById("fname");
    const lastName = document.getElementById("lname");
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    const address = document.getElementById("address");
    const password = document.getElementById("password");
    const confirmPass = document.getElementById("confirmPass");

    const firstNameError = document.getElementById("fnameError");
    const lastNameError = document.getElementById("lnameError");
    const remailError = document.getElementById("remailError");
    const phoneError = document.getElementById("pError");
    const addError = document.getElementById("addError");
    const passError = document.getElementById("rPass");
    const conPass = document.getElementById("conPass");

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function isValidPhone(phone) {
        const re = /^[\d\s\-+()]{11,}$/;
        return re.test(phone);
    }

    rform.addEventListener("submit", async function (event) {
        event.preventDefault();
        let isValid = true;


        [firstName, lastName, email, phone, address, password, confirmPass].forEach(field => {
            field.classList.remove("is-invalid", "is-valid");
        });
        [firstNameError, lastNameError, remailError, phoneError, addError, passError, conPass].forEach(error => {
            error.style.display = "none";
        });


        if (firstName.value.trim() === "") {
            firstName.classList.add("is-invalid");
            firstNameError.textContent = "First name is required";
            firstNameError.style.display = "block";
            isValid = false;
        } else {
            firstName.classList.add("is-valid");
        }

        if (lastName.value.trim() === "") {
            lastName.classList.add("is-invalid");
            lastNameError.textContent = "Last name is required";
            lastNameError.style.display = "block";
            isValid = false;
        } else {
            lastName.classList.add("is-valid");
        }

        if (email.value.trim() === "") {
            email.classList.add("is-invalid");
            remailError.textContent = "Email is required";
            remailError.style.display = "block";
            isValid = false;
        } else if (!isValidEmail(email.value.trim())) {
            email.classList.add("is-invalid");
            remailError.textContent = "Please enter a valid email address";
            remailError.style.display = "block";
            isValid = false;
        } else {
            email.classList.add("is-valid");
        }

        if (phone.value.trim() === "") {
            phone.classList.add("is-invalid");
            phoneError.textContent = "Phone number is required";
            phoneError.style.display = "block";
            isValid = false;
        }else if(phone.value.trim().length !== 11){
            phone.classList.add("is-invalid");
            phoneError.textContent = "Please enter a valid phone number";
            phoneError.style.display = "block"
            isValid = false;
        } else {
            phone.classList.add("is-valid");
        }

        if (address.value.trim() === "") {
            address.classList.add("is-invalid");
            addError.textContent = "Address is required";
            addError.style.display = "block";
            isValid = false;
        } else {
            address.classList.add("is-valid");
        }

        if (password.value.trim() === "") {
            password.classList.add("is-invalid");
            passError.textContent = "Password is required";
            passError.style.display = "block";
            isValid = false;
        } else if (password.value.trim().length < 6) {
            password.classList.add("is-invalid");
            passError.textContent = "Password must be at least 6 characters";
            passError.style.display = "block";
            isValid = false;
        } else {
            password.classList.add("is-valid");
        }

        if (confirmPass.value.trim() === "") {
            confirmPass.classList.add("is-invalid");
            conPass.textContent = "Please confirm your password";
            conPass.style.display = "block";
            isValid = false;
        } else if (confirmPass.value !== password.value) {
            confirmPass.classList.add("is-invalid");
            conPass.textContent = "Passwords do not match";
            conPass.style.display = "block";
            isValid = false;
        } else {
            confirmPass.classList.add("is-valid");
        }

        if (isValid) {
            try {
                const formData = new FormData(rform);
                const response = await fetch('/register', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {

                    Swal.fire({
                        title: 'Registered!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Continue to Login'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        }
                    });
                } else {

                    Swal.fire({
                        title: 'Registration Failed',
                        text: data.message,
                        icon: 'error'
                    });


                    if (data.message.includes('Email')) {
                        email.classList.add("is-invalid");
                        remailError.textContent = data.message;
                    }

                }
            } catch (error) {
                Swal.fire('Error', 'Could not connect to server', 'error');
            }
        }
    });


    email.addEventListener('input', function() {
        if (email.value.trim() && !isValidEmail(email.value.trim())) {
            email.classList.add("is-invalid");
            remailError.textContent = "Please enter a valid email address";
            remailError.style.display = "block";
        } else {
            email.classList.remove("is-invalid");
            remailError.style.display = "none";
        }
    });

    confirmPass.addEventListener('input', function() {
        if (password.value && confirmPass.value !== password.value) {
            confirmPass.classList.add("is-invalid");
            conPass.textContent = "Passwords do not match";
            conPass.style.display = "block";
        } else if (confirmPass.value) {
            confirmPass.classList.remove("is-invalid");
            conPass.style.display = "none";
        }
    });




    // emailInput.addEventListener("input", function () {
    //     if (emailInput.value.trim() !== "") {
    //         emailInput.classList.remove("is-invalid");
    //         emailInput.classList.add("is-valid");
    //         emailError.style.display = "none";
    //     }
    // });


    // password.addEventListener("input", function () {
    //     if (password.value.trim().length >= 6) {
    //         password.classList.remove("is-invalid");
    //         passError.classList.add("is-valid");
    //         passError.style.display = "none";
    //     }
    // });
});






document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const toggleBtn = document.getElementById("menu");


    if (toggleBtn) {

        const isCollapsed = localStorage.getItem("sidebar-collapsed") === "true";
        if (isCollapsed) {
            body.classList.add("sb-collapse");
        } else {
            body.classList.remove("sb-collapse");
        }

        toggleBtn.addEventListener("click", () => {
            body.classList.toggle("sb-collapse");
            const collapsed = body.classList.contains("sb-collapse");
            localStorage.setItem("sidebar-collapsed", collapsed);
        });
    } else {
        console.warn("Sidebar toggle button not found.");
    }
});

