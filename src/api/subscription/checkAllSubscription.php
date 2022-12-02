<?php

require_once '../../global.php';

function hitSoap($creator_id, $subscriber_id){
    // hit soap
    $webservice_url = "http://binotify_soap:8080/api/binotify";

    $request_body = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <checkSubscription xmlns="http://services.binotify/">
            <arg0 xmlns="">'.$creator_id.'</arg0>
            <arg1 xmlns="">'.$subscriber_id.'</arg1>
            <arg2 xmlns="">x1NbJ4r1e1FAyFNUColSeLG1DhXL6eUfZfDHp93/TWco1YdmDJ+U31Z1S3lLlvYBtZes1nIMwJCQ0bhTaYXkcvdlY4XJjICbedsY3eGGtWXLnZW6/VTP46kpbDQGI/EnJsTIewV8jUpFkIyR/1YD0g==</arg2>
        </checkSubscription>
    </Body>
    </Envelope>';


    $headers = array(
    'Content-Type: text/xml; charset=utf-8');

    $ch = curl_init($webservice_url);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close ($ch);
    //    get what's inside <status> tag using regex
    return preg_match('/<status>(.*)<\/status>/', $result, $matches) ? $matches[1] : false;


    
}
function updateSubscription($creator_id, $subscriber_id, $status){
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {    
        $conn->close();
        exitWithError(500, $map['err']);
    }

    $sql = "UPDATE Subscription SET status = ? WHERE creator_id = ? AND subscriber_id = ?";
    $stmt = $map['conn']->prepare($sql);
    $stmt->bind_param('sss', $status, $creator_id, $subscriber_id);
    $stmt->execute();
    $conn->close();
}
// for all row in subscription table, check if the subscription is valid
function checkAllSubscription(){
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {    
        $conn->close();
        exitWithError(500, $map['err']);
    }

    $sql = "SELECT * FROM Subscription";
    $stmt = $map['conn']->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    // for all row, get column creator_id and subscriber_id
    $isAnyUpdated = false;
    while($row = $result->fetch_assoc()){
        $creator_id = $row['creator_id'];
        $subscriber_id = $row['subscriber_id'];
        $status = $row['status'];
        // change status to upper case
        $status = strtoupper($status);
        $soap_status = hitSoap($creator_id, $subscriber_id);
        // check if the subscription status is the same with soap
        if($status != $soap_status){
            // if not, update the status
            // app_status is lowercase
            $new_app_status = strtolower($soap_status);
            updateSubscription($creator_id, $subscriber_id, $new_app_status);
            $isAnyUpdated = true;
        } 
    }
    return $isAnyUpdated;

    
}
// return true if any subscription is updated
echo checkAllSubscription() ? "true" : "false";
?>