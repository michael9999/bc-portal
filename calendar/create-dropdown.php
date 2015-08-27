<?php

// Trial JSON object


/*$string='{"id":13850932,"start":"2014-11-25T13:17","finish":"2014-11-25T14:19",
"resource_id":302823,"created_on":"2014-11-21T14:53:17Z","user_id":2277309,
"res_name":"Purple (18)","created_by":"project@foris-scientia.com","price":null,
"deleted":true,"updated_on":"2014-11-21T14:54:57Z","updated_by":"project@foris-scientia.com",
"status":42,"status_message":"User cancelled","description":"","full_name":"project",
"phone":"09887654467","field_1_r":"1","form_id":1999825,"email":"project@foris-scientia.com",
"form":{"id":1999825,"content":{"4":["Internal"],"7":["michael, john, richard"],"10":["Silence please"],
"17":["handicaped, michael, john, richard"], "11":["Truck"], "12":["Yes"], "13":["disabled access info"],"9":["crazy event name"],"3":["No"],"8":["Dell"],"5":["No"],"6":["set up details"]},
"created_on":"2014-11-21T14:53:17Z","created_by":"project@foris-scientia.com","user_id":2277309,
"deleted":true,"updated_on":"2014-11-21T14:54:57Z","updated_by":"project@foris-scientia.com"},
"role":3,"event":"new"}';*/


// END


// ZENDESK ADD TICKET

define("ZDAPIKEY", "iDsieF7dSR8jWyApvcK2A0sBncUcmNO38Ropwfby");

define("ZDUSER", "michaelsmuts@gmail.com");

define("ZDURL","https://britishcouncilfrance.zendesk.com/api/v2");

 

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



// create ticket

$arr = array();
$arr['z_subject'] = "Room reservation: " . $json_a[res_name];

//$arr['z_name'] = $name_user; created_by

// Set requester 

$arr['z_requester'] = $json_a[created_by];

// BUILD TEST ARRAY 

/*

 -d '{"ticket_field": {"custom_field_options": [{"id": 12345678, "name": "Option 1", "value": "option_1"}, {"id": 13345688, "name": "Option 2","value": "option_2"}]}}' \

 -d '{"ticket_field": {"type": "text", "title": "Age"}}' \
 
 POST /api/v2/ticket_fields.json
 
 object(stdClass)#1 (1) { ["error"]=> object(stdClass)#2 (2) { ["title"]=> string(17) "Invalid attribute" ["message"]=> string(76) "You passed an invalid value for the ticket_field attribute. must be an array" } }

$payload = array('ticket' => array('subject' => $subject, 'comment' => array('body' => $body)));

{"type":"tagger","0":{"title":"michael"},"custom_field_options":{"name":"new1","value":"value1"}}}

{"ticket_field":{"type":"tagger","title":"michael"},"custom_field_options":{"name":"new1","value":"value1"}}

{"ticket_field":{"type":"tagger","title":"michael"},"custom_field_options":{"id":"","name":"new1","value":"value1"}}

*/

//$ticketTest = array('ticket_field' => array('type' => 'tagger', 'title' => 'michael', 'custom_field_options' => array('name' => 'new1', 'value' => 'value1')));

$ticketTest = array('ticket_field' => array('type' => 'tagger',  'title' => 'michael'), 'custom_field_options' => array('id' => null, 'name' => 'new1', 'value' => 'value1'
, 'id' => null, 'name' => 'new2', 'value' => 'value2'));

// add data to custom field

/*$ticketTest = array('ticket' => array('type' => 'task', 'subject' => $arr['z_subject'], 'description' => $description2, 
'due_at' => $date_event, 'ticket_form_id' => $ticket_form, 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester'])));*/

var_dump($ticketTest);


// json encode

$create = json_encode($ticketTest); 

var_dump($create);

$data = curlWrap("/ticket_fields.json", $create, "POST");

var_dump($data);

// get ticket id
//print $data->ticket->id;
//print "\n";



?>