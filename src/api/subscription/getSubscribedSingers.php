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

        $sql = "SELECT creator_id, status FROM Subscription WHERE subscriber_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $subscriber_id);

    } else {
        exitWithError(500, "subscriber_id is not provided");
    }

    $accepted = array();
    $pending = array();
    $rejected = array();

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $creator_id = $row['creator_id'];
            if ($row['status'] == "accepted") {
                array_push($accepted, $creator_id);
            } else if ($row['status'] == "pending") {
                array_push($pending, $creator_id);
            } else if ($row['status'] == "rejected") {
                array_push($rejected, $creator_id);
            }
        }
          
    } else {
        $conn->close();
        exitWithError(500, "Error while fetching subscribed singers");
    }

    

    $data = array(
        "accepted" => $accepted,
        "pending" => $pending,
        "rejected" => $rejected
    );

    $conn->close();
    exitWithDataReturned($data);
?>