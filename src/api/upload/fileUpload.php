<?php
    require_once '../../global.php';

    if (!empty($_REQUEST["type"]) && !empty($_REQUEST["name"])) {
        $type = $_REQUEST["type"];
        $name = $_REQUEST["name"];
    } else {
        exitWithError(400, "Type is required");
    }

    if (!($type == "song-audio" || $type == "song-image" || $type == "album-image")) {
        exitWithError(400, "Invalid type");   
    }

    if (isset($_FILES['file']['name'])) {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $location = "../../assets/" . $type . "/";
        move_uploaded_file($file_tmp, $location . $name);
        exitWithDataReturned(array("file_name"=> $name));
    } else {
        exitWithError(400, 'Audio file is needed');
    }
?>