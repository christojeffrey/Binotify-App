<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add album</title>
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
            <div class="song-album-form-container ">
                <form onsubmit="addAlbum()" class="margin-bawah song-album-form" method="POST" and enctype="multipart/form-data">
                    <h1 class="form-header">Add Album</h1>

                    <div class="album-info">
                        <img id="album-image" src="../../assets/placeholder.jpg" alt="Album image" class="update-add-song-album-image">
                        <div>
                            <div class="label-input-form-container">
                                <label for="album-title" class="form-label">Album Title</label>
                                <input type="text" name="album-title" id="album-title" required class="form-input">
                            </div>
        
                            <div class="label-input-form-container">
                                <label for="singer" class="form-label">Singer</label>
                                <input type="text" name="singer" id="singer" required class="form-input">
                                
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
                                <label for="image-file"  class="form-label">Image File</label>
                                <input onchange="onChange()" type="file" name="image-file" id="image-file" accept="image/*" required class="form-input">
        
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Add Album" class="form-submit">
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