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

    // validate information
    if (!validateNeededKeys($body, array('name', 'username', 'password', 'email'))) {
        $conn->close();
        exitWithError(400, 'name, username, password and email is needed');
    }
    // do query
    // use prepare
    $name = $body['name'];
    $username = $body['username'];
    $password = $body['password'];
    $email = $body['email'];
    $sql = "INSERT INTO User (name, username, password, email, is_admin) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $name, $username, $password, $email);
    // try catch
    try {
        $stmt->execute();
    } catch (Exception $e) {
        $conn->close();
        exitWithError(500, $e->getMessage());
    }
   

    $result = $stmt->get_result();
 
    
    // return user_token
    // encode
    $data = array(
        'id' => $conn->insert_id,
        'username' => $username,
        'email' => $email,
        'role' => 'user'
    );
    $token = encodeToken($data);
    $conn->close();
    exitWithDataReturned(array('token' => $token));
?>