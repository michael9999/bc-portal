<?php

// ZENDESK ADD TICKET



define("ZDUSER", "michaelsmuts@gmail.com");
//$email_user = $_POST["email_user"];
//define("ZDUSER", "$email_user");


define("ZDURL","https://britishcouncilfrance.zendesk.com/api/v2");

// http://www.supersaas.com/api/bookings?schedule_id=123&
//password=secret&booking[start]=2015-10-10 12:00&booking[finish]=2015-10-10 12:00&booking[full_name]=Test 

/* Note: do not put a trailing slash at the end of v2 */

 

function curlWrap($url, $json, $action)

{

$ch = curl_init();

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );

curl_setopt($ch, CURLOPT_URL, ZDURL.$url);

curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);

switch($action){

case "POST":

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

break;

case "GET":

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

break;

case "PUT":

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

break;

case "DELETE":

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

break;

default:

break;

}

 

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$output = curl_exec($ch);

curl_close($ch);

$decoded = json_decode($output);

return $decoded;

}


// json encode

$create = json_encode($ticketTest); 

$data = curlWrap("/tickets.json", $create, "POST");
var_dump($data);

// get ticket id
print $data->ticket->id;
print "\n";



?>