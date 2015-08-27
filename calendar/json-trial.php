<?php

$string='{"id":13850932,"start":"2014-11-25T13:17","finish":"2014-11-25T14:19",
"resource_id":302823,"created_on":"2014-11-21T14:53:17Z","user_id":2277309,
"res_name":"Purple (18)","created_by":"project@foris-scientia.com","price":null,
"deleted":true,"updated_on":"2014-11-21T14:54:57Z","updated_by":"project@foris-scientia.com",
"status":42,"status_message":"User cancelled","description":"","full_name":"project",
"phone":"09887654467","field_1_r":"1","form_id":1999825,"email":"project@foris-scientia.com",
"form":{"id":1999825,"content":{"4":["Internal"],"7":["michael, john, richard"],"10":["Silence please"],
"17":["handicaped, michael, john, richard"],"13":["disabled access info"],"3":["No"],"8":"","5":["No"],"6":""},
"created_on":"2014-11-21T14:53:17Z","created_by":"project@foris-scientia.com","user_id":2277309,
"deleted":true,"updated_on":"2014-11-21T14:54:57Z","updated_by":"project@foris-scientia.com"},
"role":3,"event":"new"}';

echo" trial print outs (handicapped access info)<br><br>";

$json_a=json_decode($string,true);

echo $json_a[form][content][13][0];

echo"<br><br>";

//$json_a[start] $json_a[finish] $json_a[res_name] $json_a[form][content][6][0] $json_a[phone] $json_a[field_1_r] $json_a[form][content][9][0] $json_a[form][content][4][0] $json_a[form][content][12][0] $json_a[form][content][13][0] $json_a[form][content][7][0] $json_a[form][content][3][0] $json_a[form][content][8][0] $json_a[form][content][5][0] $json_a[form][content][10][0] $json_a[form][content][11][0]




// ROOM NAME

echo $json_a[res_name];

echo "<br>";

// END TIME - OK

// extracts time
echo $time = date("H:i",strtotime($json_a[finish]));
echo "<br>";
echo "<br>";


//echo $json_a[form][0][name][last];

echo $json_a[form][content][3][0];
echo "<br>";
echo $json_a[start];
echo "<br>";


// DATE - OK

$time = strtotime($json_a[start]);
$my_format = date("Y-m-d", $time);

echo $my_format;

echo "<br><br>";

// START TIME - OK

// extracts time
echo $time = date("H:i",strtotime($json_a[start]));





echo"<br><br>";

var_dump($json_a);

?>