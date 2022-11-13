<?php
    require_once './albumHelper.php';
    if (empty($_REQUEST["album_id"])) {
        $conn->close();
        exitWithError(400, "Album id unspecified");
    }
    
    $album_id = intval($_REQUEST["album_id"]);
    
    // check url params for song_detailed 1 or 0. 1 for true, 0 for false
    $song_detailed = false;
   
    if (isset($_REQUEST["song_detailed"])) {
        $song_detailed = $_REQUEST["song_detailed"] == "1";
    }

    $res = getAlbumByID($album_id, $song_detailed);

    exitWithDataReturned($res);
?>