<?php
$request = file_get_contents('php://input');

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

$json_a=json_decode($request,true);
//$json_a=json_decode($string,true);

if($json_a[event] == "create"){

echo "this is object received from supersaas<br><br>";

//var_dump($json_a);
// the message
//$msg = "First line of text\nSecond line of text";

//$msg = $json_a[form][content][3][0];

// use wordwrap() if lines are longer than 70 characters
//$msg = wordwrap($msg,70);

$input = json_decode($request, true);

$obj = $input;

// send email

//mail("michaelsmuts@gmail.com","My contents", $msg);


/* SEND DATA TO ZD, CREATE TICKET ETC.... */


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


// works @ 27/01/15

$name_user = "infos";
//$date_event = "2013-01-27";
//$room_event = "Turner";
$description_event = "New form11";
$time_event = "13:00";
$type_action = "room booking";
$email_user = "infos@foris-scientia.com";

// END

// convert DATES for ZD

//$test ="2014-11-10T17:00";

$test=$json_a[start];

$time = strtotime($test);
$date_event = date("Y-m-d", $time);

// end

// convert TIMES for ZD


$start_time = date("H:i",strtotime($json_a[start]));
$end_time = date("H:i",strtotime($json_a[finish]));


// end


// create ticket

$arr = array();
$arr['z_subject'] = "Room reservation: " . $json_a[res_name];
$arr['z_requester'] = $json_a[created_by];
$ticket_form = 38201;

$description2 = "Room reservation request" . " \n\n" .

"Event name: " . $json_a[form][content][9] . " \n\n" .
"Date: " . $date_event . " \n\n" .
"Room: " . $json_a[res_name] . " \n\n" .
"Start: " . $start_time . " \n\n" .
"End: " . $end_time . " \n\n" .
"Internal/External: " . $json_a[form][content][4] . " \n\n" .
"Nb of participants: " . $json_a[field_1_r] . " \n\n" .
"Names of participants: " . $json_a[form][content][7] . " \n\n" .
"Disabled participants: " . $json_a[form][content][12] . " \n\n" .
"Disabled access info: " . $json_a[form][content][13] . " \n\n" .

"Set-up required: " . $json_a[form][content][5] . " \n\n" .
"Set-up details: " . $json_a[form][content][6] . " \n\n" .
"Silence required in neighbouring rooms: " . $json_a[form][content][10] . " \n\n" .
"Catering: " . $json_a[form][content][3] . " \n\n" .
"Maitre D: " . $json_a[form][content][8] . " \n\n";


// add data to custom field

$ticketTest = array('ticket' => array('type' => 'task', 'subject' => $arr['z_subject'], 'description' => $description2, 
'due_at' => $date_event, 'ticket_form_id' => $ticket_form, 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester'])));

// Room
//$ticketTest['ticket']['fields'][] = array('id' => '23059381', 'value' => $room_event);
$ticketTest['ticket']['fields'][] = array('id' => '23059381', 'value' => $json_a[res_name]);


// urgency level 

//$ticketTest['ticket']['fields'][] = array('id' => '22001027', 'value' => $urgency_level);

// floor

//$ticketTest['ticket']['fields'][] = array('id' => '23059791', 'value' => $floor);

//$ticketTest['ticket']['fields'][] = array('id' => '22175783', 'value' => $editLink);


// Start time

$ticketTest['ticket']['fields'][] = array('id' => '25646541', 'value' => $start_time);

//$ticketTest['ticket']['fields'][] = array('id' => '23188653', 'value' => $time_event);


// End time

$ticketTest['ticket']['fields'][] = array('id' => '25663832', 'value' => $end_time);

//$ticketTest['ticket']['fields'][] = array('id' => '23188653', 'value' => $time_event);


// Set-up details 

$ticketTest['ticket']['fields'][] = array('id' => '25624601', 'value' => $json_a[form][content][6]);

// Nb of attendees 

$ticketTest['ticket']['fields'][] = array('id' => '25625411', 'value' => $json_a[field_1_r]);

// Event name 

$ticketTest['ticket']['fields'][] = array('id' => '25625421', 'value' => $json_a[form][content][9]);

// Internal or external event 

$ticketTest['ticket']['fields'][] = array('id' => '25625501', 'value' => $json_a[form][content][4]);

// Participants handicappés 

$ticketTest['ticket']['fields'][] = array('id' => '25646512', 'value' => $json_a[form][content][12]);

// Disabled access details  

$ticketTest['ticket']['fields'][] = array('id' => '25646522', 'value' => $json_a[form][content][13]);


// Noms des participants 

$ticketTest['ticket']['fields'][] = array('id' => '25625511', 'value' => $json_a[form][content][7]);

// Food and drink 

$ticketTest['ticket']['fields'][] = array('id' => '25625591', 'value' => $json_a[form][content][3]);

// Maitre d'hotel

$ticketTest['ticket']['fields'][] = array('id' => '25646602', 'value' => $json_a[form][content][8]);

// Set up required? 

$ticketTest['ticket']['fields'][] = array('id' => '25646612', 'value' => $json_a[form][content][5]);

// Silence aneighbouring rooms 

$ticketTest['ticket']['fields'][] = array('id' => '25625671', 'value' => $json_a[form][content][10]);

// Equipment requested  

$ticketTest['ticket']['fields'][] = array('id' => '25625681', 'value' => $json_a[form][content][11]);


// json encode

$create = json_encode($ticketTest); 

$data = curlWrap("/tickets.json", $create, "POST");

$response = json_decode($data, true);

$zdID = $data->ticket->id;

// -------------- UPDATE SUPERSAAS ----------------

// set credentials

$username = "britishcouncilfrance";
$password = "appletree";
$scheduleID = 201396;


$msg = "variables " . "event ID : " . $json_a[id] . "ZD ID : " . $zdID;    
            mail("michaelsmuts@gmail.com","update variables", $msg); 


// ------------- UPDATE SUPERSAAS ------------------

// decode according to tutorial 

$json = json_decode($request, true);

//

if(isset($json["id"]))
	{
		$id = $json["id"];
		
		$postFields = array(
		    "schedule_id" => $scheduleID,
			"password" => $password,
			"booking[field_1]" => $zdID,
			"booking[email]" => $json["email"],
		);
		
		$post = "";
		foreach($postFields as $key=>$value)
			$post .= urlencode($key) .'='. urlencode($value) .'&';

		echo "Post: $post\n";
		//open connection
		$ch = curl_init();

        // ok to here
        
        $msg = "test";    
        mail("michaelsmuts@gmail.com","OK 1", $msg); 

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, "http://www.supersaas.com/api/bookings/$id.xml");
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		
		//execute post
		$result = curl_exec($ch);
		
		 $msg = "test";    
        mail("michaelsmuts@gmail.com","OK 2", $msg); 
		
		echo curl_getinfo ($ch,CURLINFO_HTTP_CODE) . "\n";
		if(curl_getinfo ($ch,CURLINFO_HTTP_CODE) == 200)
		{
			echo "Succesfully updated appointment<br>\r\n";
			  mail("michaelsmuts@gmail.com","OK END", $msg); 
		} else {
			echo "Error updating appointment<br>\r\n";
			echo "Error: $result\n";
			//$xml = simplexml_load_string($result);
			//echo "Reason: " . $xml->xpath("/errors/error[1]")[0]->__toString() . "<br>\r\n";
			echo "<br>\r\n";
			  mail("michaelsmuts@gmail.com","error 1", $msg); 
		}
		
		curl_close($ch); 
		
	}






}

// check if reservation has been deleted 

/*
"event":"edit"
"event":"destroy"
"event":"approve"
"id":14866671
*/

        elseif($json_a[event] == "destroy"){
            
            $msg = "reservation destroyed";    
            mail("michaelsmuts@gmail.com","reservation destroyed", $msg);   
          
         // update ZD
         
         
         // end update
            
            
        }
        
// ----------------- EVENT APPROVED -------------------        
        

    elseif($json_a[event] == "approve"){
            
            $msg = "reservation created: " . $data->ticket->id;    
            mail("michaelsmuts@gmail.com","reservation approved", $msg);   
          
         // update ZD
         
         
         
         
         // end update
            
            
        }



else {
    
$msg = "did not run";    
mail("michaelsmuts@gmail.com","api script did not run", $msg);   
    
}
//var_dump($data);

// get ticket id
//print $data->ticket->id;
//print "\n";



?>