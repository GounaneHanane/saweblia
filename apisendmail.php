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
$TelClientFormatted=str_replace("06","2126",$TelClient);


    //  $my_apikey = "9Q8P09AF8MR9YATFY3HK"; 
    //             $destination =$TelClientFormatted; 
    //             $message = "Bonjour ".$NomClient.", Saweblia vous remercie pour votre demande. Conformément aux restrictions sanitaires, les réparations urgentes sont prioritaires. Aussi, les délais d'intervention peuvent être ralentis par la disponibilité de nos équipes."; 
    //             $api_url = "http://panel.apiwha.com/send_message.php"; 
    //             $api_url .= "?apikey=". urlencode ($my_apikey); 
    //             $api_url .= "&number=". urlencode ($destination); 
    //             $api_url .= "&text=". urlencode ($message); 
    //             $my_result_object = json_decode(file_get_contents($api_url, false)); 

    //             var_dump($my_result_object);
              
 // $my_apikey = "9Q8P09AF8MR9YATFY3HK"; 
 //                $destination =$TelClientFormatted; 
 //                $message = "Bonjour ".$NomClient.", Saweblia vous remercie pour votre demande. En quoi puis-je vous aider ?"; 
 //                $api_url = "http://panel.apiwha.com/send_message.php"; 
 //                $api_url .= "?apikey=". urlencode ($my_apikey); 
 //                $api_url .= "&number=". urlencode ($destination); 
 //                $api_url .= "&text=". urlencode ($message); 
 //                $my_result_object = json_decode(file_get_contents($api_url, false)); 
 
$url = 'https://api.sendgrid.com/';
$user = 'azure_7f5b2a5cb6cfae8c1feda8d742c3f914@azure.com';
$pass = 'p@r@d0xait1980';
$template_id = '0b70faa0-b132-4f73-912b-2c8aa1b2b186';

$js = array(
  'sub' => array('-NomClient-' => array(strtoupper($NomClient)), 
    '-Code-' => array($Code),
    '-Quartier-' => array($Quartier_mail),
    '-Service-' => array($Service_mail),
    '-DateJour-' => array($DateJour),
    '-TelClient-' => array($TelClient),
  
    //'-FormButton-' => array($FormButton),
  ),
  'filters' => array('templates' => array('settings' => array('enable' => 1, 'template_id' => $template_id)))
);
$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'to'        => 'hanane.gounane@gmail.com',
    'subject'   => $Subject,
    'html'      => 'e teste',
    'text'      => 'testing body',
    'from'      => 'saweblia@saweblia.ma',
    'x-smtpapi' => json_encode($js),
  );


$request =  $url.'api/mail.send.json';

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