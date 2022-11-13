<?php
    require_once '../../global.php';
    $map = backendConnection();
    $conn = $map['conn'];
    
    if ($map['err'] != null) {
        $conn->close();
        exitWithError(500, $map['err']);
    }
        
    $auth = checkIsAuthTokenValid();
    if (!$auth['is_admin']){
        $conn->close();
        exitWithError(401, "You are not authorized to access this");
    }

    $input = file_get_contents('php://input');
    $body = json_decode($input,true);

    if (!validateNeededKeys($body, array('album_id','album_title','singer','image_path','publish_date','genre'))) {
        $conn->close();
        exitWithError(400, 'Bad Request');
    }

    $album_id = $body['album_id'];
    $album_title = $body['album_title'];
    $singer = $body['singer'];
    $image_path = $body['image_path'];
    $publish_date = $body['publish_date'];
    $genre = $body['genre'];

    $stmt = $conn->prepare("
            SELECT * 
            FROM Album 
            WHERE album_id = ?
            ");
    $stmt->bind_param('i', $album_id);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows == 0) {
        $conn->close();
        exitWithError(400, "Bad request: Album does not exist");
    }

    $stmt->close();

    $stmt = $conn->prepare("UPDATE Album SET album_title = ?, singer = ?, image_path = ?, publish_date = ?, genre = ? WHERE album_id = ?");
    $stmt->bind_param("sssssi", $album_title,$singer,$image_path,$publish_date,$genre,$album_id);

    if (!$stmt->execute()){
        $conn->close();
        exitWithError(500, "Internal Server Error");
    }

    $stmt->close();

    $stmt = $conn->prepare("
            SELECT * 
            FROM Album 
            WHERE album_id = ?
            ");
    $stmt->bind_param('i', $album_id);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $result = $stmt->get_result();
    $album = $result->fetch_assoc();

    $res = array(
            'album_id' => $album['album_id'],
            'album_title' => $album['album_title'],
            'singer' => $album['singer'],
            'total_duration' => $album['total_duration'],
            'image_path' => $album['image_path'],
            'publish_date' => $album['publish_date'],
            'genre' => $album['genre']
        );
    
    
    $conn->close();
    exitWithDataReturned($res);

?>