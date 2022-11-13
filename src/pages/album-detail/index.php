<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Detail</title>
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
            <div class="album-detail-container">
                <div class="album-image-container">
                    <img id="album-image" src="" alt="" class="album-detail-image">
                </div>
                <div id="album-detail" class="album-detail-info">
                    <h3>Album</h3>
                    <div id="album-title" class="album-info-title"></div>
                    <div class="info-edit-container">
                        <p><b><span id="singer"></span></b> • <span id="publish-year"></span> • <span id="song-count"></span> songs, <span id="total-duration"></span></p>

                        <div id="button-container" class="button-container">
                            <a href= "" id="edit-hyperlink">
                                <img class="update-album-song-edit-button" src="../../assets/icons/edit.svg" alt="Edit"/>
                            </a>
                            <button onclick="deleteAlbum()" class="update-album-song-erase-button">
                                <img class="" src="../../assets/icons/trash.svg" alt="Edit"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- image -->
            <div class="album-songs">
                <div class="album-song-heading">
                    <h2>Album's songs</h2>
                </div>
                <div id="song-list">
                    
                </div>
            </div>
        </section>
    </div>
    <div id="player">
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