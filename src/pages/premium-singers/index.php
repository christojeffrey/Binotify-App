<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
    <!-- styles -->
    <link rel="stylesheet" href="./styles.css">

</head>

<body>
    <div class="">
        <div class="flex">
            <aside id="navbar">

            </aside>
            <section class="main-section">
                <div id="account-info">
                </div>
                <div class="list-header-container">
                    <h1 class="list-title">
                        <b>Premium Singers</b>
                    </h1>
                </div>
                <div class="premium-singer-list-content">

                    <div id="cards">

                    </div>
                </div>
            </section>
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