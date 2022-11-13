<?php
    require_once '../../global.php';

    // connect to database
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {      
        exitWithError(500, $map['err']);
    }


    // check if page and limit number is provided
    if (!empty($_REQUEST["page"] && !empty($_REQUEST["limit"]))) {
        $page = intval($_REQUEST["page"]);
        $limit = intval($_REQUEST["limit"]);
        $offset = ($limit * $page) - $limit;

        // count total number of row in song table
        $stmt = $conn->prepare("SELECT COUNT(song_id) as number FROM Song");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $number= $row["number"];
        $total_page = ceil($number / $limit);
        $stmt->close();

        
        $stmt = $conn->prepare("SELECT * FROM (SELECT * FROM Song ORDER BY song_id DESC LIMIT ? OFFSET ?) AS Z ORDER BY song_title ASC");
        $stmt->bind_param("ii", $limit, $offset);
    } else {
        $stmt = $conn->prepare("SELECT * FROM Song ORDER BY song_title");
    }

    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = array();
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
            array_push($data, $song);
        }

        $response = array(
            "data" => $data,
            "total_page" => $total_page
        );
          
        $conn->close();
        
        exitWithDataReturned($response);
    } else {
        $conn->close();
        exitWithError(500, "Error while fetching songs");
    }
?>