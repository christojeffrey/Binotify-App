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
                <form onsubmit="addSong()" class="song-album-form" method="POST" and enctype="multipart/form-data">
                    <h1 class="form-header">Add New Song</h1>
                    <img id="song-image" src="../../assets/placeholder.jpg" alt="Album image" class="update-add-song-album-image">

                    <div class="label-input-form-container">
                        <label for="song-title" class="form-label">Song Title</label>
                        <input type="text" name="song-title" id="song-title" required class="form-input">
                    </div>

                    <div class="label-input-form-container">
                        <label for="singer class="form-label">Singer</label>
                        <input type="text" name="singer" id="singer" class="form-input" required>    
                    </div>

                    <div class="label-input-form-container">
                        <label for="publish-date" class="form-label">Publish Date</label>
                        <input type="date" name="publish-date" id="publish-date" required class="form-input">    
                    </div>

                    <div class="label-input-form-container">
                        <label for="genre" class="form-label">Genre</label>
                        <select id="genre" required class="form-input">
                        </select>    
                    </div>


                    <div class="label-input-form-container">
                        <label for="audio-file" class="form-label">Audio File</label>
                        <input type="file" accept=".mp3" name="audio-file" id="audio-file" required class="form-input">
                    </div>

                    <div class="label-input-form-container">
                        <label  for="image-file" class="form-label">Image File</label>
                        <input onchange="onChange()" accept="image/*" type="file" name="image-file" id="image-file" required class="form-input">    
                    </div>


                    <div class="label-input-form-container">
                        <label for="album-id" class="form-label">Album</label>
                        <select id="album-id" class="form-input">
                        </select>
                    </div>

                    <input type="submit" value="Add Song" class="form-submit">
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
<script src="./script.js"></script>

</html>