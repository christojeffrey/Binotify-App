<?php
require_once '../../global.php';


// connect to database
$map = backendConnection();
$conn = $map['conn'];
if ($map['err'] != null) {      
    $conn->close();
    exitWithError(500, $map['err']);
}

// parse body
$body = json_decode(file_get_contents('php://input'), true);
if (!validateNeededKeys($body, array('subscriber_id', 'creator_id', 'status'))) {
    exitWithError(400, 'All song detail is needed');
}

$subscriber_id = $body['subscriber_id'];
$creator_id = $body['creator_id'];
$status = $body['status'];

// check if subscription exist, if exist, update. if not, insert
// validate by select
$sql = "SELECT * FROM Subscription WHERE subscriber_id = ? AND creator_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $subscriber_id, $creator_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // update
        $sql = "UPDATE Subscription SET status = ? WHERE subscriber_id = ? AND creator_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $status, $subscriber_id, $creator_id);
        if ($stmt->execute()) {
            $conn->close();
            exitWithDataReturned("Subscription updated");            
        } else {
            $conn->close();
            exitWithError(500, 'Failed to update subscription');
        }
    } else {
        // insert
        $sql = "INSERT INTO Subscription (subscriber_id, creator_id, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $subscriber_id, $creator_id, $status);
        if ($stmt->execute()) {
            $conn->close();
            exitWithDataReturned('Subscription created');
        } else {
            $conn->close();
            exitWithError(500, 'Failed to create subscription');
        }
    }
} else {
    $conn->close();
    exitWithError(500, 'Failed to check subscription');
}