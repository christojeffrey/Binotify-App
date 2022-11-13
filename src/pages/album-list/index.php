<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>album list</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="flex">
        <div id="navbar">

        </div>
        <section class="main-section">

            <div id="account-info">

            </div>
            <div>
                <div class="album-list-content">
                    <div class="list-header-container">
                        <h1 class="list-title">
                            <b>Albums</b>
                        </h1>
                        <div class="move-page-button-container">
                            <button onclick="movePage(true)" class="move-page-button flex justify-center items-center"
                                id="back-button">
                                <!-- prev icon from asset icon prev.svg-->
                                <img class="prevnexticon" src="../../assets/icons/prev.svg" alt="prev" />
                            </button>
                            <button onclick="movePage(false)"
                                class="move-page-button flex justify-center items-center  " id="next-button"> <img
                                    class="prevnexticon" src="../../assets/icons/next.svg" alt="next" />
                            </button>
                        </div>
                    </div>
                    <div id="albums" class="albums">
                    </div>
                </div>
            </div>

        </section>


</body>
<?php
    // add global js and styles
    require '../../global.php';
    echoGlobal();
?>
<!-- script -->
<script src="script.js"></script>

</html>