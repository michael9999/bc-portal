<?php

$today = date("Y-m-d H:i:s");     

$test ="2014-11-10T17:00";

//$date_event = "2013-01-27";

// $datetime is something like: 2014-01-31 13:05:59
//$time = strtotime($datetime);
//$my_format = date("m/d/y g:i A", $time);
// $my_format is something like: 01/31/14 1:05 PM

$time = strtotime($test);
$my_format = date("Y-m-d", $time);

// extracts date
echo $my_format;

echo "<br><br>";

//echo $time = date("H:i:s",strtotime($test));

// extracts time
echo $time = date("H:i",strtotime($test));

?>