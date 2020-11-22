<?php
//require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
require_once './../primotexto-api/primotexto-api-php/baseManager.class.php';
$json = file_get_contents('php://input');
$message='';
 // decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

$PhoneNumber = $obj['PhoneNumber'];
$CodeUser = $obj['CodeUser'];


//SMS primotexto
// authenticationManager::setApiKey('6d9488ab89a94abe99dcd56bfa1be2f1');
//  $sms = new Sms;
//     $sms->type = 'notification';
//     $sms->number = $PhoneNumber;
//     $sms->message = 'Votre code de confirmation : '.$CodeUser;
//     $sms->sender = 'SAWEBLIA';
//     $sms->campaignName = 'Code de confirmation';
//     $sms->category = 'codeConfirmation';
//     messagesManager::messagesSend($sms);


    $curl = curl_init();

        $PhoneNumber=str_replace("+","",$PhoneNumber);

        $Message='INFO : Votre code de confirmation : '.$CodeUser;
        $authorization = base64_encode('ParadoxCom:S@webli@2018'); 

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://8pz39.api.infobip.com/number/1/query",
        CURLOPT_URL => "http://8pz39.api.infobip.com/sms/2/text/single",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{ \"from\":\"SAWEBLIA\",
        \"to\":\"$PhoneNumber\", 
        \"text\":\"$Message\" }",
       CURLOPT_HTTPHEADER => array(
       "accept: application/json",
        "authorization: Basic $authorization",
        "content-type: application/json"
                  ),
                ));

        $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

     if ($err) {
       echo "cURL Error #:" . $err;
     } else {
       echo $response;
            }


    
?>
