<?php
    require_once '../../global.php';

    $map = backendConnection();
    $conn = $map['conn'];
    
    if ($map['err'] != null) {
        $conn->close();
        exitWithError(500, $map['err']);
    }

    // check if user is admin
    $auth = checkIsAuthTokenValid();
    if (!$auth['is_admin']){
        $conn->close();
        exitWithError(401, "You are not authorized to delete song");
    }

    if (empty($_REQUEST["song_id"])) {
        exitWithError(400, "Song id unspecified");
    }

    if (!validateRowExist($conn, "Song", $_REQUEST["song_id"])) {
        $conn->close();
        exitWithError(404, "Song not found");
    }
    
    $song_id = intval($_REQUEST["song_id"]);

    // connect to database
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {
        $conn->close();
        exitWithError(500, $map['err']);
    }

    $stmt = $conn->prepare("DELETE FROM Song WHERE song_id = ?");
    $stmt->bind_param("i", $song_id);

    if($stmt->execute()){
        $data = array(
            "song_id" => $song_id
        );
        $conn->close();
        exitWithDataReturned($data);
    } else {
        $conn->close();
        exitWithError(500, "Error while deleting song");
    }
?>