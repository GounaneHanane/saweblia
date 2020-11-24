<?php 

 { $timezone  = +1;
$DateJour = gmdate("Y-m-d H:i:s", time() +3600*($timezone+date("I")));

extract($_POST);
//include 'DBConfig.php';

$connection = new mysqli('www.saweblia.ma', "saweblia_sawebuser", "p@r@d0xait1980", "mobilesw");
$connection->set_charset("utf8");
//$mysqli->query('SET NAMES utf8');
//mysql_query("SET NAMES 'utf8'");

$NomClient = $_POST['fname'];
$TelClient = $_POST['phone'];
$Email = $_POST['email'];
$Code = "COVID19 Formulaire popup - Email : ".$_POST['email']."test";
$Quartier_mail =htmlentities($_POST['Quartier'], ENT_COMPAT, 'UTF-8', true); //Quartier
$Service_mail=htmlentities($_POST['Service'],ENT_COMPAT, 'UTF-8', true); //service
$Quartier = $_POST['Quartier'];
$Service = $_POST['Service'];

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
       
 

/// 
/// add client to hubspot
///
    $fname=$_POST['fname'];
    $lname="";
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$Quartier=$_POST['Quartier'];
	$Service=$_POST['Service'];



	$contact_data = array(
		"fname" => $fname.' '.$Service,
		"lname" => $lname,
		"email" => $email,
		"phone" => $phone,
		"info" => "",
		"code" => "",
		"city" => "",
		"radio1" => "",
		"address" => $Quartier,
		"totalsession" =>"",
    "company" => "",
	);
	
	$ans_hubspot = new ans_hubspot();
	$ans_hubspot->contact_create($contact_data);
	//$ans_hubspot->list_create("Recovery Lead Generation");
	$ans_hubspot->list_assign_contact("2", $contact_data["phone"]);
    




  }
}
 class ans_hubspot{
	private $hapikey = "73c28615-ef80-46a8-be75-98f0d01d8ad1";

	function list_assign_contact($lid, $phone){
		(object)$arr = array(
			"phone" => array($phone)
		);
        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/lists/'.$lid.'/add?hapikey=' . $this->hapikey;
        $this->http($endpoint,$post_json);
        var_dump($endpoint);
	}	
	
	
	function list_create($list_name){
		$arr = array(
		    "name" => $list_name,
		    "dynamic" => false,
		    "filters" => array(
		    	array(
		    		(object)array(
						"operator" => "EQ",
						"value" => "@hubspot",
						"property" => "twitterhandle",
						"type" => "string"
					)
            	)  
		    )
		);
        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/lists?hapikey=' . $this->hapikey;
		$this->http($endpoint,$post_json);
	}

	function contact_create($contact_data){
        $arr = array(
            'properties' => array(
                array(
                    'property' => 'email',
                    'value' => $contact_data["email"]
                ),
                array(
                    'property' => 'firstname',
                    'value' => $contact_data["fname"]
                ),
                array(
                    'property' => 'lastname',
                    'value' => ""
                ),
                array(
                    'property' => 'phone',
                    'value' => $contact_data["phone"]
                ),
                array(
                  'property' => 'address',
                  'value' => $contact_data["address"]
              )
            )
        );
        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $this->hapikey;
        $this->http($endpoint,$post_json);
        
	}
	
	function http($endpoint,$post_json){

        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        echo "curl Errors: " . $curl_errors;
        echo "\nStatus code: " . $status_code;
        echo "\nResponse: " . $response;
       return $response;
  }
 }
 ?>