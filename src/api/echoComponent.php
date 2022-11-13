<?php
    // the body accept 2 parameter, first the name of the compnent, second an array of arguments
    // from POST


    $body = json_decode(file_get_contents('php://input'), true);
    $name = $body['name'];
    $args = $body['args'];

    // the path to the component
    $path = "../components/$name/$name.php";
    // check if the component exist
    if(file_exists($path)){
        // include the component
        include $path;
        // call the function with the name of the component
        // and pass the arguments
        // destructure args
        echo $name($args);
    }else{
        echo $path;
        // if the component does not exist
        // echo an error message
        echo "component does not exist";
    }
?>