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

     if (empty($_REQUEST["album_id"])) {
        $conn->close();
        exitWithError(400, "Album id unspecified");
    }
    $album_id = intval($_REQUEST["album_id"]);

    $stmt = $conn->prepare("
        DELETE FROM Album
        WHERE album_id = ?");
    $stmt->bind_param("i", $album_id);
    if(!$stmt->execute()){
        $conn->close();
        exitWithError(500, "Internal Server Error");
    }

    $conn->close();
    $res = array(
        "album_id" => $album_id
    );
    exitWithDataReturned($res);
?>