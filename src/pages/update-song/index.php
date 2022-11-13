<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Song</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="flex">
        <aside id="navbar">

        </aside>
        <section class="main-section">
            <div id="account-info">

            </div>
            <div class="song-album-form-container">
                <form onsubmit="updateSong()" class="song-album-form" method="POST" and enctype="multipart/form-data">
                    <h1 class="form-header">Update Song</h1>
                    <img id="song-image" alt="Song image" class="update-add-song-album-image"> 
                    <div class="label-input-form-container">
                        <label for="song-title" class="form-label">Song Title</label>
                        <input type="text" name="song-title" id="song-title" required class="form-input">
                    </div>


                    <div class="label-input-form-container">          
                        <label for="singer" class="form-label">Singer</label>
                        <input type="text" name="singer" id="singer" class="form-input" disabled>
                    </div>


                    <div class="label-input-form-container">
                        <label for="publish-date" class="form-label">Publish Date</label>
                        <input type="date" name="publish-date" id="publish-date" required class="form-input">
                    </div>

                    <div class="label-input-form-container">
                        <label for="genre" class="form-label">Genre</label>
                        <select id="genre" class="form-input" required>
                        </select>
                    </div>

                    <div class="label-input-form-container">
                        <label for="audio-file" class="form-label">Audio File</label>
                        <input type="file" name="audio-file" id="audio-file" class="form-input">
                    </div>

                    <div class="label-input-form-container">
                        <label for="image-file" class="form-label">Image File</label>
                        <input onchange="onChange()" type="file" accept="image/*" name="image-file" id="image-file" class="form-input">
                    </div>
                    <div class="label-input-form-container">
                        <label for="album-id" class="form-label">Album</label>
                        <select class="form-input" id="album-id">
                        </select>
                    </div>

                    <div class="form-button-container">
                        <input type="submit" value="Update Song" class="form-submit">
                    </div>
                </form>
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