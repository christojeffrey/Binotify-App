<?php
    require_once '../../global.php';
    // Setup needed variables
    // check Auth in header
    $auth = getAuth();
    // if there is no Auth in header
    if ($auth == null) {
        // return error
        exitWithError(401, 'Auth is needed');
    }

    // validate information
    // decode token
    $data = decodeToken($auth);
    // if the token is invalid
    if ($data == null) {
        // return error
        exitWithError(401, 'Auth is invalid');
    }

    // return
    exitWithDataReturned(array('role' => $data['role']));
?>