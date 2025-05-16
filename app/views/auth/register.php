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
    <style>

        .form-floating2 {
            position: relative;
            margin-bottom: 20px;
        }

        .form-floating2 input {

            height: 50px;
            padding: 1rem;
            font-family: 'Poppins', sans-serif;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }

        .form-floating2 input:focus {
            border-color: #61120C;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(97, 18, 12, 0.25);
        }

        .form-floating2 label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #6c757d;
            transition: all 0.2s ease;
            pointer-events: none;
            font-family: 'Poppins', sans-serif;
            background-color: white;
            padding: 0 5px;
        }

        .form-floating2 input:focus + label,
        .form-floating2 input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #61120C;
            background-color: white;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body {
            font-family: Poppins;
            height: auto;
            background-color: white;
            overflow-x: hidden;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        h2 {
            font-size: 2vw;
            font-weight: 550;
        }

        h3 {
            font-size: 1.5vw;
            font-weight: 520;
        }

        h4 {
            font-size: 1.3vw;
        }

        #overlay{
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .sticky-nav {
            top: 0;
            z-index: 1;
            position: sticky;
        }

        .cus-text {
            margin-left: 18%;
            margin-right: 18%;
        }

        .bg-image {
            position: absolute;
            width: 50vw;
            height: 50vh;
            top: 430px;
            left: 750px;
        }

        .underlineA {
            width: 10rem;
            height: 6px;
            border-radius: 5px;
            border: none;
            background-color: #61120C;
        }

        .underlineC {
            width: 12rem;
            height: 6px;
            border-radius: 5px;
            border: none;
            background-color: #61120C;
        }

        .gap {
            gap: 15rem;
        }

        .i-gap {
            gap: 2rem;
        }

        .terms-condition {
            position: relative;
            margin-right: 15em;
        }

        #r-button {
            background-color: #61120C;
            width: 19em;
        }
        #r-button:hover{
            background-color: #F6AB0F;
        }

        .disabled-button {
            background-color: gray;
            color: white;
            cursor: not-allowed;
        }

        .enabled-button {
            background-color: blue;
            color: white;
            cursor: pointer;
        }


        .custom-color {
            color: #61120C;
        }

        .c-height {
            margin-top: -5vh;
        }

        .c-width {
            width: 36vw;
        }

        .bg-custom {
            background-color: #61120C;
        }

        .navbar-light .navbar-nav .nav-link {
            padding: 0 30px;
            color: black;
            transition: 0.3s ease;
        }

        .nav-link {
            display: inline-block;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .navbar-light .navbar-nav .nav-link:hover,
        .navbar-light .navbar-nav .nav-link.active {
            color: #F6AB0F;
        }

        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25vh;
        }

        .login-form {
            margin-top: 20px;
            width: 100%;
            padding: 20px;
        }

        form {
            width: 100%;
        }

        .btn {
            outline: none;
            border: none;
        }

        .btn:hover {
            background-color: #F6AB0F;
        }

        .border-w {
            width: 10.5%;
            padding: 0;
        }


        #b-line {
            width: 4rem;
            height: 6px;
            border-radius: 5px;
            border: none;
            background-color: #F8CC50;
        }

        #d-line {
            position: relative;
            width: 32rem;
            height: 6vh;
            border-radius: 0;
            border: none;
            top: 9rem;
            left: -15rem;
            z-index: -1;
            transform: rotate(-30deg);
            background-color: #61120C;
        }

        #d-line2 {
            position: relative;
            width: 32rem;
            height: 4vh;
            border-radius: 0;
            border: none;
            top: -1rem;
            left: -22rem;
            transform: rotate(-30deg);
            z-index: -1;
            background-color: #F8CC50;
        }


        .invalid-feedback {
            position: absolute;
            bottom: -20px;
            left: 0;
            font-size: 12px;
            color: red;
            display: none;
        }

        @media only screen and (min-width: 2560px) {
            .c-width {
                width: 34vw;
            }

            .c-height {
                height: 9vh;
            }
        }

        @media only screen and (max-width: 415px) {
            h2 {
                font-size: 6vw;
            }

            h3 {
                font-size: 4vw;
            }

            h4 {
                font-size: 3vw;
            }

            small {
                font-size: 2vw;
            }

            #fpaswword {
                font-size: 3vw;
            }

            .terms-condition {
                margin-right: 4rem;
            }

            .t-size {
                font-size: 12px;
            }

            .border-w {
                width: 33%;
            }

            .form-floating input {
                width: 80vw;
            }

            .r-input {
                margin-left: 10%;
                margin-right: 10%;
                justify-content: center;
                gap: 10px;
                flex-direction: column;
            }

            .c-width {
                width: 80vw;
            }

            .responsive {
                gap: 30px;
                flex-direction: column;
            }
        }
    </style>
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

    <form id="r-form" action="" method="post">
        <div class="d-flex justify-content-center pt-4 i-gap w-1 r-input">
            <div class="form-floating2">
                <input type="text" name="firstname" class="form-control" id="fname" placeholder=" " required>
                <label for="fname">First name</label>
                <div class="invalid-feedback" id="fnameError"></div>
            </div>
            <div class="form-floating2">
                <input type="text" name="lastname" class="form-control" id="lname" placeholder=" " required>
                <label for="lname">Last name</label>
                <div class="invalid-feedback" id="lnameError"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-5 i-gap w-1 r-input c-height">
            <div class="form-floating2">
                <input type="email" name="email" class="form-control" id="email" placeholder=" " required>
                <label for="email">Email</label>
                <div class="invalid-feedback" id="remailError"></div>
            </div>
            <div class="form-floating2">
                <input type="tel" name="phone" class="form-control" id="phone" placeholder=" " required>
                <label for="phone">Phone</label>
                <div class="invalid-feedback" id="pError"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2 pt-5 i-gap w-1 r-input c-height fixed-w">
            <div class="form-floating2 mb-1">
                <input type="text" name="address" class="form-control c-width" id="address" placeholder=" " required>
                <label for="address">Address</label>
                <div class="invalid-feedback" id="addError"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2 pt-5 i-gap w-1 r-input c-height fixed-w">
            <div class="form-floating2 mb-1">
                <input type="password" name="password" class="form-control c-width" id="password" placeholder=" " required>
                <label for="password">Enter your password</label>
                <div class="invalid-feedback" id="rPass"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-5 i-gap w-1 r-input c-height">
            <div class="form-floating2">
                <input type="password" name="confirm_password" class="form-control c-width" id="confirmPass" placeholder=" " required>
                <label for="confirmPass">Confirm your password</label>
                <div class="invalid-feedback" id="conPass"><small><?php echo htmlspecialchars($error ?? '') ?></small></div>
            </div>
        </div>
        <div class="terms-condition d-flex justify-content-center pt-3">
            <div>
                <input type="checkbox" id="chk-box" required>
                <label for="chk-box" class="ml-1 t-size">I agree to the Terms and Condition</label>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-2 mt-2">
            <button type="submit" class="btn btn-primary bg-custom" id="r-button" disabled>Register</button>
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