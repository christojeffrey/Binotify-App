<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div>
        <div class="flex">
            <!-- navbar -->
            <div id="navbar"></div>
            <section class="main-section">
                <!-- account info -->
                <div id="account-info"></div>
                <!-- content -->
                <h1 class="list-title">User List</h1>
                <div id="user-list"></div>
            </section>
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