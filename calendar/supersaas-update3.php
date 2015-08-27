<?php

$username = "britishcouncilfrance";
$password = "appletree";
//$scheduleID = 208651;
$scheduleID = 201396;

$_REQUEST["json"] = '{"id":15011513,"start":"2015-02-26T13:00"
,"finish":"2015-02-27T14:00","resource_id":310545,
"created_on":"2014-11-21T14:53:47Z","user_id":2277309,
"res_name":"Orange (16)","created_by":"project@foris-scientia.com",
"price":null,"deleted":false,"status":2,
"status_message":"Pending approval", "field_2":"field 2",
"full_name":"project","phone":"09887654467"
,"field_1_r":"1","form_id":1999829,
"email":"project@foris-scientia.com"}';

if(isset($_REQUEST["json"]))
{
	$json = json_decode($_REQUEST["json"], true);
	
	if(isset($json["id"]))
	{
		$id = $json["id"];
		
		$postFields = array(
			"password" => $password,
			"schedule_id" => $scheduleID,
			"booking[start]" => $json["start"],
			"booking[finish]" => $json["finish"],
			"booking[full_name]" => $json["full_name"],
			"booking[field_1_r]" => $json["field_1_r"],
			"booking[email]" => $json["email"],
			"booking[phone]" => $json["phone"],
			"booking[field_1]" => $json["field_2"],
		);
		
		$post = "";
		foreach($postFields as $key=>$value)
			$post .= urlencode($key) .'='. urlencode($value) .'&';

		echo "Post: $post\n";
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, "http://www.supersaas.com/api/bookings/$id.xml");
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		
		//execute post
		$result = curl_exec($ch);
		
		echo curl_getinfo ($ch,CURLINFO_HTTP_CODE) . "\n";
		if(curl_getinfo ($ch,CURLINFO_HTTP_CODE) == 200)
		{
			echo "Succesfully updated appointment<br>\r\n";
		} else {
			echo "Error updating appointment<br>\r\n";
			echo "Error: $result\n";
			//$xml = simplexml_load_string($result);
			//echo "Reason: " . $xml->xpath("/errors/error[1]")[0]->__toString() . "<br>\r\n";
			echo "<br>\r\n";
		}
		
		curl_close($ch); 
		
	}
}

?>