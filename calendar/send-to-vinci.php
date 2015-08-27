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

// access json string

$json_a=json_decode($request,true);
//$json_a=json_decode($string,true);


// if new event send email to Vinci

if($json_a[event] == "new"){



// send email
$msg = "new opening hour requested";
mail("michaelsmuts@gmail.com","new event created", $msg);



$test=$json_a[start];




}

// check if reservation has been deleted 

/*
"event":"edit"
"event":"destroy"
"event":"approve"
"id":14866671
revert
destroy
*/

        elseif($json_a[event] == "destroy"){
            
            $msg = "reservation destroyed";    
            //mail("michaelsmuts@gmail.com","reservation destroyed", $msg);   
          
// update ZD

             $id2 = $json_a[field_1];
          
         // update ZD
         
        // convert DATES for ZD



            $test=$json_a[start];
            
            $time = strtotime($test);
            $date_event = date("Y-m-d", $time);
            
            // end
            
            // convert TIMES for ZD
            
            
            $start_time = date("H:i",strtotime($json_a[start]));
            $end_time = date("H:i",strtotime($json_a[finish]));
                        
            
            $subject = "Room reservation Cancelled: " . $json_a[res_name];
            
            $description2 = "Your room reservation has been CANCELLED: " . " \n\n" .
            
            "Event name: " . $json_a[description] . " \n\n" .
            "Date: " . $date_event . " \n\n" .
            "Room: " . $json_a[res_name] . " \n\n" .
            "Start: " . $start_time . " \n\n" .
            "End: " . $end_time . " \n\n";

// ADD to description field

            $ticketTest2 = array('ticket' => array('subject' => $subject,
            'comment' => array('body' => $description2, 'public' => 'true')));
            
            


            $ticketTest2['ticket']['fields'][] = array('id' => '25823732', 'value' => 'deleted');
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25871542', 'value' => 'res_deleted');
            

// DO ZD UPDATE
           
            $create = json_encode($ticketTest2); 
            
            //PUT /api/v2/tickets/{id}.json
            
            $data = curlWrap("/tickets/$id2.json", $create, "PUT");


         
         
// end update
            
            
        }
        
// ---------------- EVENT UPDATED ---------------------

elseif($json_a[event] == "edit"){
            
            $msg = "event edited" . $json_a[field_1];    
            mail("michaelsmuts@gmail.com","Check SS id", $msg);   
          
         // update ZD
         
          $id2 = $json_a[field_1];
          
         // update ZD
         
        // convert DATES for ZD



            $test=$json_a[start];
            
            $time = strtotime($test);
            $date_event = date("Y-m-d", $time);
            
            // end
            
            // convert TIMES for ZD
            
            
            $start_time = date("H:i",strtotime($json_a[start]));
            $end_time = date("H:i",strtotime($json_a[finish]));
            
            // check that variables are set 
                        
            
            $subject = "Room reservation UPDATED: " . $json_a[res_name];
            
            $description2 = "Your room reservation has been updated as follows: " . " \n\n" .
            
            "Event name: " . $json_a[description] . " \n\n" .
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

// ADD to description field

            $ticketTest2 = array('ticket' => array('subject' => $subject,
            'comment' => array('body' => $description2, 'public' => 'true')));
            
            /*$ticketTest2 = array('ticket' => array('subject' => $subject));*/
            
            
// UPDATE OTHER FIELDS

            // Room
            //$ticketTest['ticket']['fields'][] = array('id' => '23059381', 'value' => $room_event);
            $ticketTest2['ticket']['fields'][] = array('id' => '23059381', 'value' => $json_a[res_name]);
            
            
            // Start time
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646541', 'value' => $start_time);
            
            //$ticketTest['ticket']['fields'][] = array('id' => '23188653', 'value' => $time_event);
            
            
            // End time
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25663832', 'value' => $end_time);
            
            
            
            // Set-up details 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25624601', 'value' => $json_a[form][content][6]);
            
            // Nb of attendees 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625411', 'value' => $json_a[field_1_r]);
            
            // Event name 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625421', 'value' => $json_a[description]);
            
            // Internal or external event 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625501', 'value' => $json_a[form][content][4]);
            
            // Participants handicappés 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646512', 'value' => $json_a[form][content][12]);
            
            // Disabled access details  
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646522', 'value' => $json_a[form][content][13]);
            
            
            // Noms des participants 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625511', 'value' => $json_a[form][content][7]);
            
            // Food and drink 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625591', 'value' => $json_a[form][content][3]);
            
            // Maitre d'hotel
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646602', 'value' => $json_a[form][content][8]);
            
            // Set up required? 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646612', 'value' => $json_a[form][content][5]);
            
            // Silence aneighbouring rooms 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625671', 'value' => $json_a[form][content][10][0] . " " . $json_a[form][content][10][1] . " " 
            . $json_a[form][content][10][2]);

            // Equipment requested  
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625681', 'value' => $json_a[form][content][11][0] . " " . $json_a[form][content][11][1] 
            . " " . $json_a[form][content][11][2] . " " . $json_a[form][content][11][3] . " " . $json_a[form][content][11][4]);


            $ticketTest2['ticket']['fields'][] = array('id' => '25823732', 'value' => 'pending');
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25871542', 'value' => 'res_update');
            

// DO ZD UPDATE
           
            $create = json_encode($ticketTest2); 
            
            //PUT /api/v2/tickets/{id}.json
            
            //$data = curlWrap("/tickets/$id2.json", $create, "PUT");

         
         
         // end update
         
         // end update
            
            
        }



        
// ----------------- EVENT APPROVED -------------------        
        

    elseif($json_a[event] == "approve"){
            
            $msg = "reservation approved: " . $data->ticket->id;    
           // mail("michaelsmuts@gmail.com","reservation approved", $msg);   
          
            $id2 = $json_a[field_1];
          
         // update ZD
         
        // convert DATES for ZD



            $test=$json_a[start];
            
            $time = strtotime($test);
            $date_event = date("Y-m-d", $time);
            
            // end
            
            // convert TIMES for ZD
            
            
            $start_time = date("H:i",strtotime($json_a[start]));
            $end_time = date("H:i",strtotime($json_a[finish]));
                        
            
            $subject = "Room reservation APPROVED: " . $json_a[res_name];
            
            $description2 = "Your room reservation has been approved, pleasee check the details
            listed below: " . " \n\n" .
            
            "Event name: " . $json_a[description] . " \n\n" .
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

// ADD to description field

            $ticketTest2 = array('ticket' => array('subject' => $subject,
            'comment' => array('body' => $description2, 'public' => 'true')));
            
            /*$ticketTest2 = array('ticket' => array('subject' => $subject));*/
            
            
// UPDATE OTHER FIELDS

            // Room
            //$ticketTest['ticket']['fields'][] = array('id' => '23059381', 'value' => $room_event);
            $ticketTest2['ticket']['fields'][] = array('id' => '23059381', 'value' => $json_a[res_name]);
            
            
            // Start time
            
            $ticketTest22['ticket']['fields'][] = array('id' => '25663832', 'value' => $end_time);
            
            //$ticketTest['ticket']['fields'][] = array('id' => '23188653', 'value' => $time_event);
            
            
            // Set-up details 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25624601', 'value' => $json_a[form][content][6]);
            
            // Nb of attendees 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625411', 'value' => $json_a[field_1_r]);
            
            // Event name 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625421', 'value' => $json_a[form][content][9]);
            
            // Internal or external event 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625501', 'value' => $json_a[form][content][4]);
            
            // Participants handicappés 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646512', 'value' => $json_a[form][content][12]);
            
            // Disabled access details  
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646522', 'value' => $json_a[form][content][13]);
            
            
            // Noms des participants 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625511', 'value' => $json_a[form][content][7]);
            
            // Food and drink 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625591', 'value' => $json_a[form][content][3]);
            
            // Maitre d'hotel
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646602', 'value' => $json_a[form][content][8]);
            
            // Set up required? 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25646612', 'value' => $json_a[form][content][5]);
            
            // Silence aneighbouring rooms 
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625671', 'value' => $json_a[form][content][10][0]);
            
            // Equipment requested  
            
            $ticketTest2['ticket']['fields'][] = array('id' => '25625681', 'value' => $json_a[form][content][11][0] . " " . $json_a[form][content][11][1] . " " . $json_a[form][content][11][2] . " " . $json_a[form][content][11][3] . " " . $json_a[form][content][11][4]);

// update booking status

            $ticketTest2['ticket']['fields'][] = array('id' => '25823732', 'value' => 'approved');
            
// update email status 

           // $ticketTest2['ticket']['fields'][] = array('id' => '25871542', 'value' => 'already_approved');

// DO ZD UPDATE
           
            $create = json_encode($ticketTest2); 
            
            //PUT /api/v2/tickets/{id}.json
            
            $data = curlWrap("/tickets/$id2.json", $create, "PUT");

         
         
         // end update
            
            
        }



else {
    
$msg = "did not run";    
//mail("michaelsmuts@gmail.com","api script did not run", $msg);   
    
}
//var_dump($data);

// get ticket id
//print $data->ticket->id;
//print "\n";



?>