<?php
    require_once '../../global.php';

    $auth = checkIsAuthTokenValid();
    if (!$auth['is_admin']) {
        exitWithError(401, 'Unauthorized');
    };

    $body = json_decode(file_get_contents('php://input'), true);

    if (isset($_REQUEST["delete-album"]) && $_REQUEST["delete-album"] == "1") {
        if (!validateNeededKeys($body, array('song_id', 'song_title', 'singer', 'publish_date', 'genre', 'duration'))) {
            exitWithError(400, 'All song detail is needed');
        }
    } else{
        if (!validateNeededKeys($body, array('song_id', 'song_title', 'singer', 'publish_date', 'genre', 'duration', 'album_id'))) {
            exitWithError(400, 'All song detail is needed');
        }
    }

    if (isset($_REQUEST["delete-album"]) && $_REQUEST["delete-album"] == "1") {
        if (!validateKeyValueIsNotNull($body, array('song_id', 'song_title', 'singer', 'publish_date', 'genre', 'duration'))) {
            exitWithError(400, 'All song detail must be filled');
        }
    } else {
        if (!validateKeyValueIsNotNull($body, array('song_id', 'song_title', 'singer', 'publish_date', 'genre', 'duration', 'album_id'))) {
            exitWithError(400, 'All song detail must be filled');
        }
    }
   

    if (preg_match('/\//', $body['audio_path']) || preg_match('/\//', $body['image_path'])) {
        exitWithError(400, 'File path must be a valid URL');
    }

    // connect to database
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {      
        exitWithError(500, $map['err']);
    }

    if (!validateRowExist($conn, 'Song', $body['song_id'])) {
        $conn->close();
        exitWithError(400, "No song found");
    }

    // precondition: album_id is int or null
    if (is_int($body['album_id'])) {
        if (!validateRowExist($conn, 'Album', $body['album_id'])) {
            $conn->close();
            exitWithError(400, 'Album with given id is not exist');
        }
    
        if (!validateSongAndAlbumHaveSameSinger($conn, 'Album', $body['album_id'], $body['singer'])) {
            $conn->close();
            exitWithError(400, 'Song and album must have the same singer');
        }
    }

    $song_id = $body['song_id'];
    $song_title = $body['song_title'];
    $singer = $body['singer'];
    $publish_date = $body['publish_date'];
    $genre = $body['genre'];
    $audio_path = $body['audio_path'];
    $image_path = $body['image_path'];
    $duration = $body['duration'];
    
    if (isset($_REQUEST["delete-album"]) && $_REQUEST["delete-album"] == "1") {
        $album_id = null;
    } else {
        $album_id = $body['album_id'];

    }
     
    
    if ($body['image_path'] == null) {
        $sql = "SELECT image_path FROM Song WHERE song_id = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $body['song_id']);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $image_path = $row['image_path'];
        }
        $stmt->close();
    } else {
        $image_path = $body['image_path'];
    }

    if ($body['audio_path'] == null) {
        $sql = "SELECT audio_path FROM Song WHERE song_id = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $body['song_id']);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $audio_path = $row['audio_path'];
        }
        $stmt->close();
    } else {
        $audio_path = $body['audio_path'];
    }

    // echo $image_path;
    // echo $audio_path;
    $sql = "UPDATE Song SET song_title = ?, singer = ?, publish_date = ?, genre = ?, audio_path = ?, image_path = ?, duration = ?, album_id = ? WHERE song_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssiii", $song_title, $singer, $publish_date, $genre, $audio_path, $image_path, $duration, $album_id, $song_id);
    if ($stmt->execute()) {
       
       $data = array(
            "song_id" => $song_id,
            "song_title" => $song_title,
            "singer" => $singer,
            "publish_date" => $publish_date,
            "genre" => $genre,
            "audio_path" => $audio_path,
            "image_path" => $image_path,
            "duration" => $duration,
            "album_id" => $album_id
        );
        exitWithDataReturned($data);
    } else {
        $conn->close();
        exitWithError(500, "Error while adding new song");
    }
?>