<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div>
        <div class="login-register-container" >
            <a href="../../pages/home/index.php"  class="brand-logo-login-register-container">
                <img src="../../assets/logo/brand-logo.png" class="brand-logo-login-register"/>
            </a>
            <form onsubmit="formSubmit()" class="login-register-form" onchange="onFormChange()">
                <div class="label-input-form-container">
                    <label for="username" class="form-label"><b>Username</b></label>
                    <input id="username" type="text" placeholder="Enter Username" name="username" required
                        class="form-input">
                </div>

                <div class="label-input-form-container">
                    <label for="password" class="form-label"><b>Password</b></label>
                    <input id="password" type="password" placeholder="Enter Password" name="password" required
                        class="form-input">
                </div>

                <div class="form-button-container">
                    <button type="submit" class="form-submit">Login</button>
                </div>

                <div id="status" class="h-6"></div>
                <div class="ref-to-login-register-page">don't have an account? click <a href="/pages/register/index.php">here</a></div>
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
<script src=" script.js"></script>

</html>