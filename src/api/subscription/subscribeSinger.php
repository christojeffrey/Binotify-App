<?php
require_once '../../global.php';

function createNewSubscription($creator_id,  $subscriber_id) {
    $map = backendConnection();
    $conn = $map['conn'];
    if ($map['err'] != null) {      
        $conn->close();
        exitWithError(500, $map['err']);
    }
    
    // check if subscription exist, if exist, update. if not, insert
    // validate by select
    
    $sql = "INSERT INTO Subscription (subscriber_id, creator_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $subscriber_id, $creator_id);

    $result = $stmt->execute();
    if ($result) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
};

$body = json_decode(file_get_contents('php://input'), true);
var_dump($body);
if (!validateNeededKeys($body, array('creator_id',  'subscriber_id'))) {
    exitWithError(400, 'Singer and subscriber id is needed');
}

$creator_id = intval($body["creator_id"]);
$subscriber_id = intval($body["subscriber_id"]);


$webservice_url = "http://binotify_soap:8080/api/binotify";

$request_body = '
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <newSubscription xmlns="http://services.binotify/">
            <arg0 xmlns="">'. $creator_id .'</arg0>
            <arg1 xmlns="">'. $subscriber_id .'</arg1>
            <arg2 xmlns="">x1NbJ4r1e1FAyFNUColSeLG1DhXL6eUfZfDHp93/TWco1YdmDJ+U31Z1S3lLlvYBtZes1nIMwJCQ0bhTaYXkcvdlY4XJjICbedsY3eGGtWXLnZW6/VTP46kpbDQGI/EnJsTIewV8jUpFkIyR/1YD0g==</arg2>
        </newSubscription>
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

if ($result !== FALSE) {
    if (createNewSubscription($creator_id,  $subscriber_id)) {
        exitWithDataReturned(array("message" => "created"));
    } else {
        exitWithError(500, "Failed to create subscription");
    }
} else {
    exitWithError(500, "Failed to create subscription");
};
