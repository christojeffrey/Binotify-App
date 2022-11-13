<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Detail</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="flex">
        <!-- navbar -->
        <aside id="navbar">

        </aside>
        <section class="main-section">
            <div id="account-info">

            </div>
            <div class="song-detail-container">
                <img id="song-image" class="song-image-detail"/>
                <div class = "song-information-detail">
                    <div class="song-title-and-edit-delete-button-container">
                        <div id="song-title" class="song-title-detail"></div>
                        <div id="button-container" class="button-container">
                            <a href= "" id="edit-hyperlink">
                                <img class="update-album-song-edit-button" src="../../assets/icons/edit.svg" alt="Edit"/>
                            </a>
                            <button onclick="deleteSong()" class="update-album-song-erase-button">
                                <img class="" src="../../assets/icons/trash.svg" alt="Edit"/>
                            </button>
                        </div>
                    </div>
                    <div id="singer" class="song-detail-fields"></div>
                    <div id="date-genre" class="song-detail-fields"></div>
                    <div id="duration" class="song-duration-detail"></div>
                    <button id="ref-to-album-detail-page-button"><a id="ref-to-album-detail-page"></a></button>

                </div>
            </div>

       </section>
       <footer id="player" class="player-container">

        </footer>
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