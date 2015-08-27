<?php

$username = "britishcouncilfrance";
$password = "appletree";
$scheduleID = 201393;

// perform request $json_a[event]

// set reservation id

$id = 14867044;
$zd = 1111111;
$resource = 302825;

$ch = curl_init();

		
		
		$postFields = array(
			"schedule_id" => $scheduleID,
			"password" => $password,
			"booking[field_1]" => $zd,
			"booking[resource_id]" => $resource,
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
		
		if(curl_getinfo ($ch,CURLINFO_HTTP_CODE) == 201)
		{
			echo "Succesfully added appointment<br>\r\n";
		} else {
			echo "Error adding appointment<br>\r\n";
			$xml = simplexml_load_string($result);
			//echo "Reason: " . $xml->xpath("/errors/error[1]")[0]->__toString() . "<br>\r\n";
			echo "<br>\r\n";
			var_dump($xml);
		}
		
		curl_close($ch);
		
		
		
		
?>		