<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update album</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div>
                <h2><span id="singer-modal"></span>'s Songs</h2>
                <div id="song-list-modal">

                </div>
            </div>
        </div>
    </div>
    <div class="flex">
        <aside id="navbar">
        </aside>
        <section class="main-section">
            <div id="account-info">
    
            </div>
            <div class="song-album-form-container">
                <form onsubmit="updateAlbum()" class="song-album-form" method="POST" and enctype="multipart/form-data">
                    <h1 class="form-header"><b>Update Album</b></h1>
                    <div class="album-info">
                        <img id="album-image" src="" alt="Album image" class="update-add-song-album-image"> 
                        <div>
                            <div class="label-input-form-container">
                                <label for="album-title" class="form-label">Name</label>  
                                <input class="form-input" type="text" name="album-title" id="album-title" placeholder="Add a name" >
                            </div>
    
                            <div class="label-input-form-container">
                                <label for="singer" class="form-label">Singer</label>  
                                <input class="form-input" type="text" name="singer" id="singer" placeholder="Add a name" disabled>
                            </div>
    
                            <div class="label-input-form-container">
                                <label for="genre" class="form-label">Genre</label>
                                <select id="genre"  class="form-input">
                                </select>    
                            </div>       
                            
                            <div class="label-input-form-container">
                                <label for="publish-date" class="form-label">Publish Date</label>
                                <input type="date" name="publish-date" id="publish-date" class="form-input">    
                            </div>
    
                            <div class="label-input-form-container">
                                <label for="image-file" class="form-label">Image File</label>
                                <input onchange="onChange()" accept="image/*" type="file" name="image-file" id="image-file" class="form-input">    
                            </div>
                        </div>
                    </div>
                    <button class="form-submit" type="submit">Submit</button>
                </form>
            </div>
            <div class="album-songs">
                <div class="album-song-heading">
                    <h2>Album's songs</h2>
                    <button class="move-page-button" id="plus-button">
                        <img class="add-button" src="../../assets/icons/plus.svg" alt="Add"/>
                    </button>
                </div>
                <div id="song-list">
                    
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