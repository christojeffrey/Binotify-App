<?php
    function getAlbumByID($album_id, $song_detailed) {
        require_once '../../global.php';
        $map = backendConnection();
        if($map['err'] != null){
            exitWithError(500, $map['err']);
        }
        $conn = $map['conn'];
        $stmt = $conn->prepare("
            SELECT *
            FROM Album
            WHERE album_id = ?");
        $stmt->bind_param("i", $album_id);
        if(!$stmt->execute()){
            $conn->close();
            exitWithError(500, "Internal Server Error");
        }   
        /* bind variables to prepared statement */
        $result = $stmt->get_result();
        $album = $result->fetch_assoc();
        $stmt->close();

        if ($song_detailed){
            $stmt = $conn->prepare("
                SELECT *
                FROM Song
                WHERE album_id = ?");
        } else{
            $stmt = $conn->prepare("
                SELECT song_id, song_title, singer
                FROM Song
                WHERE album_id = ?");
        }

        $stmt->bind_param("i", $album_id);
        if(!$stmt->execute()){
            $conn->close();
            exitWithError(500, "Internal Server Error");
        }

        $result = $stmt->get_result();
        $songs = array();
        $song_count = 0;
        if ($song_detailed) {
            while ($row = $result->fetch_assoc()) {
                $song = array(
                    "song_id" => $row["song_id"],
                    "song_title" => $row["song_title"],
                    "singer" => $row["singer"],
                    "publish_date" => $row["publish_date"],
                    "genre" => $row["genre"],
                    "audio_path" => $row["audio_path"],
                    "image_path" => $row["image_path"],
                    "duration" => $row["duration"],
                );
                array_push($songs, $song);
                $song_count++;
            }
        } else{
            while ($row = $result->fetch_assoc()) {
                $song = array(
                    "song_id" => $row["song_id"],
                    "song_title" => $row["song_title"],
                    "singer" => $row["singer"],
                );
                array_push($songs, $song);
                $song_count++;
            }
        }
        $respond = array(
            "album_id" => $album["album_id"],
            "album_title" => $album["album_title"],
            "singer" => $album["singer"],
            "total_duration" => $album["total_duration"],
            "publish_date" => $album["publish_date"],
            "genre" => $album["genre"],
            "image_path" => $album["image_path"],
            "song_count" => $song_count,
            "songs" => $songs,
        );
        $conn->close();
        return $respond;
    }
?>