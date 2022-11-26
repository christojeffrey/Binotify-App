<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div>
        <div class="login-register-container">
            <a href="../../pages/home/index.php"  class="brand-logo-login-register-container">
                <img src="../../assets/logo/brand-logo.png" class="brand-logo-login-register"/>
            </a>
            <form onsubmit="formSubmit()" class="login-register-form">
                <!-- name -->
                <div class="label-input-form-container">
                    <label for="name"><b>Name</b></label>
                    <input id="name" type="text" placeholder="Enter Name" name="name" required class="form-input">
                    <span class="status-span"></span>
                </div>

                <div class="label-input-form-container">
                    <label for="username"><b>Username</b></label>
                    <input id="username" type="text" placeholder="Enter Username" name="username" required
                        class="form-input" oninput="updateUsername(this.value)">
                    <span class="status-span" id="usernameStatus"></span>
                </div>

                <div class="label-input-form-container">
                    <label for="email"><b>email</b></label>
                    <input id="email" type="email" placeholder="Enter Email" name="email" required class="form-input"
                        oninput="updateEmail(this.value)">
                    <span class="form-input" id="emailStatus"></span>
                </div>

                <div class="label-input-form-container">
                    <label for="password"><b>Password</b></label>
                    <input id="password" type="password" placeholder="Enter Password" name="password" required
                        class="form-input">
                    <span class="status-span"></span>
                </div>

                <div class="label-input-form-container">
                    <label for="password2"><b>Confirm Password</b></label>
                    <input id="password2" type="password" placeholder="Confirm Password" name="password2" required
                        class="form-input">
                    <span class="h-6"></span>
                </div>

                <div class="form-button-container">
                    <button type="submit" class="form-submit">Register</button>
                </div>

                <span id="status" class="h-6 mb-1"></span>
                <div>already have an account? click <a href="/pages/login/index.php">here</a></div>

            </form>

        </div>
    </div>
</body>
<?php
    // add global js and styles
    require '../../global.php';
    echoGlobal();
?>
<!-- script -->
<script src="script.js"></script>

</html>