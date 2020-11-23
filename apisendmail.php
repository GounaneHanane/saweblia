<?php 

$timezone  = +1;
$DateJour = gmdate("Y-m-d H:i:s", time() +3600*($timezone+date("I")));

extract($_POST);
//include 'DBConfig.php';

$connection = new mysqli('www.saweblia.ma', "saweblia_sawebuser", "p@r@d0xait1980", "mobilesw");
$connection->set_charset("utf8");
//$mysqli->query('SET NAMES utf8');
//mysql_query("SET NAMES 'utf8'");

$NomClient = $_POST['your-name'];
$TelClient = $_POST['your-phone'];
$Email = $_POST['your-email'];
$Code = "COVID19 Formulaire popup - Email : ".$_POST['your-email']."test";
$Quartier_mail =htmlentities($_POST['ville'], ENT_COMPAT, 'UTF-8', true); //Quartier
$Service_mail=htmlentities($_POST['service'],ENT_COMPAT, 'UTF-8', true); //service
$Quartier = $_POST['ville'];
$Service = $_POST['service'];

$Subject='Nouvelle inscription via le site Web';        

///
/// Add to database
///
  $query = "INSERT INTO WebsiteUser(user_name, user_tel,user_email, user_quartier, user_service, user_description) 
  values('$NomClient', '$TelClient','$Email', '$Quartier', '$Service', '$Code')";
  
  $query_result = $connection->query($query);

  if($Quartier=="Casablanca" || $Quartier == "Mohammédia") {
    
    /// 
    /// send sms
    ///

    $curl = curl_init();
    $PhoneNumber="+212".substr($TelClient,1);
    $Message='Votre demande est prise en compte, un chargé de clientèle va prendre contact avec vous dans les plus brefs délais. \nMerci de télécharger notre application depuis le site : www.saweblia.ma';
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
        }

// Generate curl request
$session = curl_init($request);
// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);
// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
// Tell PHP not to use SSLv3 (instead opting for TLS)
curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true); 
 
// obtain response
 $response = curl_exec($session);
Scurl_close($session); 
  $query = "INSERT INTO WebsiteUser(user_name, user_tel,user_email, user_quartier, user_service, user_description) 
  values('$NomClient', '$TelClient','$Email', '$Quartier', '$Service', '$Code')";
  
  $query_result = $connection->query($query);


 ?>