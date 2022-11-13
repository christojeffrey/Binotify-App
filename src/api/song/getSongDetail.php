<?php
    require_once '../../global.php';
    
    // connect to database
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {      
        $conn->close();
        exitWithError(500, $map['err']);
    }
    // get the song id parameter from URL
    if (!empty($_REQUEST["song_id"])) {
        $song_id = intval($_REQUEST["song_id"]);
    } else {
        $conn->close();
        exitWithError(400, "No song specified");
    }

    $sql = "SELECT Song.song_id, Song.song_title, Song.singer, Song.publish_date,
            Song.genre, Song.audio_path, Song.image_path, Song.duration, Song.album_id, Album.album_title
            FROM Song LEFT JOIN Album ON Song.album_id = Album.album_id WHERE song_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $song_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // check if the song exists
        if ($result->num_rows == 0) {
            $conn->close();
            exitWithError(404, "Song not found");
        }

        $song = $result->fetch_assoc();
        $data = array(
            "song_id" => $song["song_id"],
            "song_title" => $song["song_title"],
            "singer" => $song["singer"],
            "publish_date" => $song["publish_date"],
            "genre" => $song["genre"],
            "audio_path" => $song["audio_path"],
            "image_path" => $song["image_path"],
            "duration" => $song["duration"],
            "album_id" => $song["album_id"],
            "album_title" => $song["album_title"]
        );
        $conn->close();
        exitWithDataReturned($data);
    } else {
        $conn->close();
        exitWithError(500, "Error while fetching songs");
    } 
?>