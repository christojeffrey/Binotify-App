<?php
    require_once '../../global.php';

    // Setup needed variables
    $body = json_decode(file_get_contents('php://input'), true);
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {    
        $conn->close();
        exitWithError(500, $map['err']);
    }
    
    
    // validate information. check if body has 'username'
    if (!validateNeededKeys($body, array('username'))) {
        $conn->close();
        exitWithError(400, 'username is needed');
    }

    // do query
    // use prepare
    $username = $body['username'];
    $sql = "SELECT * FROM User WHERE username = ?";
    $stmt = $map['conn']->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // return
    $conn->close();
    exitWithDataReturned(array('is_unique' =>  $result->num_rows == 0));
?>