<?php
    require_once '../../global.php';
    $map = backendConnection();
    if($map['err'] != null){
        exitWithError(500, $map['err']);
    }
    $conn = $map['conn'];
    
    
    $page = empty($_REQUEST["page"])? 1: intval($_REQUEST["page"]);
    $limit = empty($_REQUEST["limit"])? 10: intval($_REQUEST["limit"]);
    $song_detailed = !empty($_REQUEST["song_detailed"])? $_REQUEST["song_detailed"] == "true": false;
    $with_song = !empty($_REQUEST["with_song"])? $_REQUEST["with_song"] == "true": false;
    $get_all = !empty($_REQUEST["get_all"])? $_REQUEST["get_all"] == "true": false;

    $album_count = 0;

    if($get_all){
        $stmt = $conn->prepare("
        SELECT * 
        FROM Album
        ORDER BY album_title ASC");
    } else {
        $offset = ($limit * $page) - $limit;
        $stmt = $conn->prepare("SELECT * 
            FROM (SELECT * 
                FROM Album 
                ORDER BY album_id 
                DESC LIMIT ? OFFSET ?) pa
                ORDER BY pa.album_title ASC");
        $stmt->bind_param("ii", $limit, $offset);
    }
    if (!$stmt->execute()) {
        $conn->close();
        exitWithError(500, "Internal Server Error");
    }

    $result = $stmt->get_result();
    $albums = array();
    while($row_album = $result->fetch_assoc()){
        if($with_song){
            require_once './albumHelper.php';
            $album = getAlbumByID($row_album["album_id"], $song_detailed);
        }
        else {
            $album = array(
                "album_id" => $row_album["album_id"],
                "album_title" => $row_album["album_title"],
                "singer" => $row_album["singer"],
                "total_duration" => $row_album["total_duration"],
                "publish_date" => $row_album["publish_date"],
                "genre" => $row_album["genre"],
                "image_path" => $row_album["image_path"]);
        }
        $album_count++;
        array_push($albums, $album);
    }


    $res = array(
        "album_count" => $album_count,
        "albums" => $albums
    );
    if(!$get_all){
        $res['page'] = $page;
    }
    exitWithDataReturned($res);

    


function getSongsByAlbumID($conn, $album_id, $song_detailed){
    
}



    



?>