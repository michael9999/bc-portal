<?php
# set ZD applicable parameters - please adjust to your ZD account
$subdomain = "mayacontrol";
$username = 'importer@maya-control.ro';
$password = "importer1";
$custom1_id = "25485712"; #the numerical id of custom field 1 (the numeric one)
$custom2_id = "25463221"; #the numerical id of custom field 2 (the text one)
# / end of user adjustable area

#include the SDK from ZD
include("vendor/autoload.php");
use Zendesk\API\Client as ZendeskAPI;

#some initialization 
set_time_limit(0); #browser keep alive
ob_implicit_flush(TRUE); #browser keep alive
putenv('LANG=en_US.UTF-8'); #let's make it utf
ini_set('auto_detect_line_endings', true);
date_default_timezone_set ('Europe/Paris');

#instantiate the needed objects
$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('password', $password);
?>

<html>
<head>
<meta charset="UTF-8">
<title>Test app ZD</title>
<link href="/css/general.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if (isset($_POST["send"])) { # something was send to processing
?>
<div class="bootstrap-div">
	<h1>Bulk import results:</h1>
	<p>
<?php
	#move upload
	$err_msg = ''; #accumulator for the error messages
	$err_cnt = 0; #count error lines
	$cnt = 0; #count csv lines 

	#open csv
	if (($csv = fopen($_FILES["csv_file"]["tmp_name"],'r')) !== FALSE) {
		while (($dirty_line = fgetcsv($csv, 0, ',','"')) !== FALSE) {
			$line = array_map('trim',$dirty_line);#clean spaces at beginning/end of fields

			#sanity checks
			if (!preg_match('/@/',$line[0])) { #first field is not an email
				continue; #skip line
			}
			if (count($line) != 6) { #number of fields is not correct
				$err_msg .= implode("|",$line)."\n";
                                $err_cnt++;
				continue; #skip line
			}

			#some defaults for the 2 custom fields, if they're not given
			if (!array_key_exists(4,$line) or empty($line[4])) {
				$line[4]=100;
			}
			if (!array_key_exists(5,$line) or empty($line[5])) {
				$line[5]='default text for custom field 2';
			}
			
			#solve the date format problem
			if (preg_match('/\//',$line[3])) { #it has a slash, it is probably the French format
				$line[3] = str_replace( '/', '-', $line[3]); #we convert it manually as PHP fails !!!
			}

			#print "$line[0] | $line[1] | $line[2] | $line[3] | $line[4] | $line[5] <br>";
			#create ticket
			try {
			$newTicket = $client->tickets()->create(array(
				'subject' => $line[1],
				'requester' => array (
					'email' => $line[0]
				),
				'comment' => array (
					'body' => $line[2] 
				),
				'type' => 'task',
				'due_at' => date('Y-m-d',strtotime($line[3])),
				'custom_fields' => array (
				array ('id'=>$custom1_id, 'value'=>$line[4]),
				array ('id'=>$custom2_id, 'value'=>$line[5])
				)
		       	));
			} catch (Exception $e) {#error creating ticket
				$err_msg .= implode("|",$line)."\n";
				$err_cnt++;
			}
			$cnt++; #count csv lines
			echo '.'; #progress dots on screen
			ob_flush();
		}
	}
?>
    	</p>
	<p><?=$cnt?> records found in .csv</p>
	<p><?=$err_cnt?> records are malformed</p>
	<p><?=$cnt - $err_cnt?> records where imported into ZenDesk</p>
	<p><?php if ($err_cnt) { ?>Erroneous csv lines:<br/><?php print nl2br($err_msg); } ?></p>


<?php	
} else { #initial upload form
?>

<form method="post" class="bootstrap-frm" enctype="multipart/form-data">
    <h1>Test bulk upload tickets into ZD</h1>
    <label>
        <span>.csv file:</span>
       <input type="file" name="csv_file"> 
    </label>
    <label>
	<br/>CSV lines format: <br/>requester_email, ticket_subject, ticket_description, due_date, custom1_num, custom2_txt<br/>
	ex:<br/>
	john@maya-control.ro,Subject 1,First ticket for John,2015-01-20,150,gasoline
    </label>
   
     <label>
        <span>&nbsp;</span>
        <input name="send" type="submit" class="button" value="Send" />
    </label>    
</form>

<?php } ?>
