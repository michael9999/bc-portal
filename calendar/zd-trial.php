<?php
// ZENDESK ADD TICKET

define("ZDAPIKEY", "iDsieF7dSR8jWyApvcK2A0sBncUcmNO38Ropwfby");

define("ZDUSER", "michaelsmuts@gmail.com");
//$email_user = $_POST["email_user"];
//define("ZDUSER", "$email_user");


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

/* $name_user = $_POST["name_user"];
$date_event = $_POST["date_event"];
$room_event = $_POST["room_event"];
$description_event = $_POST["description_event"];
$time_event = $_POST["time_event"];
$type_action = $_POST["type_action"];
$email_user = $_POST["email_user"];*/ 

$name_user = "infos";
$date_event = "2013-01-27";
$room_event = "Turner";
$description_event = "Nice time";
$time_event = "13:00";
$type_action = "room booking";
$email_user = "infos@foris-scientia.com";



// create ticket

$arr = array();
$arr['z_subject'] = "Room set-up: " . $room_event;
$arr['z_description'] = $description_event;
$arr['z_name'] = $name_user;
$arr['z_requester'] = $email_user;

// add data to custom field

$ticketTest = array('ticket' => array('type' => 'task', 'subject' => $arr['z_subject'], 'description' => $arr['z_description'], 'due_at' => $date_event, 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester'])));

$ticketTest['ticket']['fields'][] = array('id' => '23059381', 'value' => $room_event);

// date
/*$ticketTest['ticket']['fields'][] = array('id' => '22169101', 'value' => $date_event);*/

$ticketTest['ticket']['fields'][] = array('id' => '22175783', 'value' => $editLink);


// time
//$ticketTest['ticket']['fields'][] = array('id' => '22170977', 'value' => $time_event);
$ticketTest['ticket']['fields'][] = array('id' => '23188653', 'value' => $time_event);



// add "room set-up" to "type of work" field

$ticketTest['ticket']['fields'][] = array('id' => '22196978', 'value' => 'Room set-up');


//$ticketTest['ticket']['fields'][] = array('id' => '22170977', 'value' => $time_event);
//tags : ["tag-1"];

//$ticketTest['ticket']['tags'][] = array('room_set_up');



// put data in variables

/*$gDate = "2013-01-30";
$gTime = "14.30";
$gSubject = "Room set-up";
$gDecription = "This is all the required info";
$gRequester = "infos@foris-scientia.com";*/

// json encode

$create = json_encode($ticketTest); 

$data = curlWrap("/tickets.json", $create, "POST");
var_dump($data);

// get ticket id
print $data->ticket->id;
print "\n";


/*$create = json_encode(array('ticket' => array('subject' => $arr['z_subject'], 'description' => $arr['z_description'], 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester'])))); //JSON_FORCE_OBJECT);

$data = curlWrap("/tickets.json", $create, "POST");*/

//$data = curlWrap("/tickets/recent.json", null, "GET");
//var_dump($data);
?>