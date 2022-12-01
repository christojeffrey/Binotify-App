<?php
    require_once '../../global.php';

    // connect to database
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {      
        exitWithError(500, $map['err']);
    }

    // get subscribed id from params
    if (!empty($_REQUEST["subscriber_id"])) {
        $subscriber_id = intval($_REQUEST["subscriber_id"]);


        // count total number of row in song table
        $stmt = $conn->prepare("SELECT creator_id FROM Subscription WHERE subscriber_id = ? AND status = ?");

    
        $status = "accepted";
        $stmt->bind_param("is", $subscriber_id, $status);
    } else {
        exitWithError(500, "subscriber_id is not provided");
    }

    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $creator_id = $row['creator_id'];
            array_push($data, $creator_id);
        }

        $response = array(
            "data" => $data,
        );
          
        $conn->close();
        
        exitWithDataReturned($response);
    } else {
        $conn->close();
        exitWithError(500, "Error while fetching subscribed singers");
    }
?>