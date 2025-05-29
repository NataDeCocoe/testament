
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TESTAMENT</title>
    <!--Plugins-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="/assets/js/validator.js" defer></script>
    <!--Plugins-->

    <link rel="icon" href="/assets/images/Testament_Logo.png" sizes="any">

</head>

<body class="h-100">

<!--Navbar-->
<?php include __DIR__ . '/../layouts/navbar.php' ?>
<!--Section-->
<section>
    <form id="l-form" method="POST">
        <div class="d-flex align-items-center flex-column py-5 bg-body-tertiary">
            <img class="mt-5" src="/assets/images/Testament_Logo.png" alt="testament logo" width="129px" height="91px">
            <h2>Sign in to your account</h2>
            <div class="center-form mt-4">
                <div class="login-form">
                    <div class="form-floating mb-4">
                        <input type="email" name="floatingInput" class="form-control" id="floatingInput" placeholder="Email@example.com">
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="lpassword" class="form-control" id="lpassword" placeholder="Password">
                        <div class="invalid-feedback" id="passError"></div>
                    </div>
                    <div class="d-flex justify-content-end"><small><a id="fpaswword" class="custom-color" href="/view/forgot-password">Forgot
                                password?</a></small></div>
                    <button type="submit" class="btn btn-primary mt-3 w-100 bg-custom">Sign In</button>
                </div>
            </div>
        </div>
    </form>
    <div class="d-flex justify-content-center mt-4">
        <hr class="border border-dark border-w">
        <span class="mx-3 ">or</span>
        <hr class="border border-dark border-w">
    </div>
    <div class="d-flex justify-content-center mt-4"><a class="custom-color" href="/register">Create an
            account</a></div>
</section>

<div id="overlay">
    <form method="POST">
        <div id="admin" class="adminLoginCard hidden">
            <div>
                <input name="adminEmail" class="form-control" placeholder="Email" type="email">
            </div>
            <div>
                <input name="adminPass" class="form-control" placeholder="Password" type="password">
            </div>
            <div>
                <button  class="btn btn-primary bg-custom" type="submit" id="adLogin">Login</button>
            </div>
            <small>© 2025 Testament. All rights reserved</small>
        </div>
    </form>
</div>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
        crossorigin="anonymous"></script>
</body>

</html>
