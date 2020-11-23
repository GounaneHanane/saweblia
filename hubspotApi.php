<?php

if( isset($_POST['submit']) )
{$Quartier = $_POST['ville'];
    $Service = $_POST['service'];
    $fname=$_POST['your-name'];
    $lname="";
	$phone=$_POST['your-phone'];
	$email=$_POST['your-email'];
	$address=$_POST['ville'];
	$service=$_POST['service'];
	


	$contact_data = array(
		"fname" => $fname,
		"lname" => $lname,
		"email" => $email,
		"phone" => $phone,
		"info" => "",
		"code" => "",
		"city" => "",
		"radio1" => "",
		"address" => $address,
		"totalsession" =>"",
		"company" => ""
	);
	
	$ans_hubspot = new ans_hubspot();
	$ans_hubspot->contact_create($contact_data);
	//$ans_hubspot->list_create("Recovery Lead Generation");
	$ans_hubspot->list_assign_contact("2", $contact_data["phone"]);
    

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
                    'value' => 'apitest@hubspot.com'
                ),
                array(
                    'property' => 'firstname',
                    'value' => 'hubspot'
                ),
                array(
                    'property' => 'lastname',
                    'value' => 'user'
                ),
                array(
                    'property' => 'phone',
                    'value' => '555-1212'
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
       
	}
}




?> 