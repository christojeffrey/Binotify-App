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
    if (!validateNeededKeys($body, array('username', 'password'))) {
        $conn->close();
        exitWithError(400, 'username and password is needed');
    }

    // do query
    // use prepare
    $username = $body['username'];
    $password = $body['password'];
  
    $stmt = $conn->prepare("
        SELECT * FROM User WHERE username = ? AND password = ?");
    // check if stmt is valid
    if ($stmt == false) {
        echo $mysqli->error;
        $conn->close();
        exitWithError(500, 'error when preparing query' . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // return
    if ($result->num_rows == 0) {
        $conn->close();
        echo $mysqli->error;
        exitWithError(400, 'username or password is wrong');
    } else {
        $row = $result->fetch_assoc();
        $data = array(
            'id' => $row['user_id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'role' => $row['is_admin'] == 1 ? 'admin' : 'user'
        ); 
        $token = encodeToken($data);
        // if role is user, return user_token. if role is admin, return admin_token

        if ($data['role'] == 'user') {
            $conn->close();
            exitWithDataReturned(array('user_token' => $token, 'user_id' => $data['id']));
        } else  { //($data['role'] == 'admin')
            $conn->close();
            exitWithDataReturned(array('admin_token' => $token, 'user_id' => $data['id']));
        }
    }
?>