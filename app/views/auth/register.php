<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TESTAMENT</title>
    <!--Plugins-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="/assets/js/validator.js" defer></script>
    <script src="/assets/js/regvalid.js" defer></script>
    <!--Plugins-->
    <link rel="icon" href="/assets/images/Testament_Logo.png" sizes="any">
</head>

<body>
<!--Navbar-->
<?php include __DIR__ . '/../layouts/navbar.php' ?>
<!--Form-->
<section>
    <div class="d-flex justify-content-start">
        <div id="d-line"></div>
        <div id="d-line2"></div>
    </div>
    <div class="d-flex justify-content-center mt-5 pt-5">
        <h2>Create your account
            <div id="b-line"></div>
        </h2>
    </div>

    <form id="r-form">
        <div class="d-flex justify-content-center pt-4 i-gap w-1 r-input">
            <div class="form-floating2">
                <input type="text" name="firstname" class="form-control" id="fname" placeholder="" >
                <label for="fname">First name</label>
                <div class="invalid-feedback" id="fnameError"></div>
            </div>
            <div class="form-floating2">
                <input type="text" name="lastname" class="form-control" id="lname" placeholder="" >
                <label for="lname">Last name</label>
                <div class="invalid-feedback" id="lnameError"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-5 i-gap w-1 r-input c-height">
            <div class="form-floating2">
                <input type="email" name="email" class="form-control" id="email" placeholder="" >
                <label for="email">Email address</label>
                <div class="invalid-feedback" id="remailError"></div>
            </div>
            <div class="form-floating2">
                <input type="tel" name="phone" class="form-control" id="phone" placeholder="" >
                <label for="phone">Phone</label>
                <div class="invalid-feedback" id="pError"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2 pt-5 i-gap w-1 r-input c-height fixed-w">
            <div class="form-floating2 mb-1">
                <input type="text" name="address" class="form-control c-width" id="address" placeholder="">
                <label for="address">Address</label>
                <div class="invalid-feedback" id="addError"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2 pt-5 i-gap w-1 r-input c-height fixed-w">
            <div class="form-floating2 mb-1">
                <input type="password" name="password" class="form-control c-width" id="password" placeholder="" >
                <label for="password">Enter your password</label>
                <div class="invalid-feedback" id="rPass"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-5 i-gap w-1 r-input c-height ">
            <div class="form-floating2">
                <input type="password" name="confirm_password" class="form-control c-width" id="confirmPass" placeholder="" >
                <label for="confirmPass">Confirm your password</label>
                <div class="invalid-feedback" id="conPass"><small><?php echo htmlspecialchars($error ?? '') ?></small></div>
            </div>
        </div>
        <div class="terms-condition d-flex justify-content-center pt-3">
            <div>
                <input type="checkbox" id="chk-box" required><small class="ml-1 t-size">I agree to the Terms and Condition</small>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-2 mt-2">
            <button type="submit" class="btn btn-primary bg-custom" id="r-button" disabled>Register</button>
        </div>
        <div>
        </div>
    </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
        crossorigin="anonymous"></script>
</body>
</html>