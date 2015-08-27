<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>
<!-- This file is used to markup the public facing aspect of the plugin. -->
<div class="wrap">

	<?php //screen_icon(); ?>
	<h2><?php //echo esc_html( get_admin_page_title() ); ?></h2>

	
<?php 

// Define all db names

define("FM_SERVICE_TABLE",'fm_service_table');

define("FM_DOC_TABLE",'fm_docs_table');

define("FM_PROFESSIONS_TABLE",'fm_professions_table');


// GET ALL SERVICE PROVIDERS

$fm_show_result_trial2 = self::fm_show_results_service_providers();

// GET ALL PROFESSIONS

//$fm_get_provider_profession = self::f_m_build_user_add();



	
	?>	
<table>
<tr>	
<td>


<select type="text" name="fac_provider_choose" id="fac_provider_choose">
<option>Search by provider88</option>	
<?php
if(isset($_POST['edit']))
 {
	
	 
	//echo "hello this is the selected provider ID " . $_POST['edit'];
	//echo "update" . $_POST['fm_update'];
	//$fm_update_service_provider = self::f_m_update_service_provider($_POST);	
	
	foreach ( $fm_show_result_trial2 as $mylinks ) 
		{
		
		echo "<option value='" . $mylinks->wp_id . "'";
		
				if($mylinks->ID == $_POST['edit']){
					
					echo "selected";
					
				}
		
		      echo ">" . $mylinks->fm_comp_name . "</option>";//echo $mylinks->wp_id;
		}
	
	
	
	 
 }
elseif(isset($_POST['fm_update']))
 {
	
	 
	//echo "hello this is the selected provider ID " . $_POST['edit'];
	//echo "update" . $_POST['fm_update'];
	//$fm_update_service_provider = self::f_m_update_service_provider($_POST);	
	
	foreach ( $fm_show_result_trial2 as $mylinks ) 
		{
		
		echo "<option value='" . $mylinks->wp_id . "'";
		
				if($mylinks->ID == $_POST['fm_update']){
					
					echo "selected";
					
				}
		
		      echo ">" . $mylinks->fm_comp_name . "</option>";//echo $mylinks->wp_id;
		}
	
	
	
	 
 }
else
{
	?>
<!-- <select type="text" name="fac_provider_profession" id="fac_provider_profession"> -->
	
<?php foreach ( $fm_show_result_trial2 as $mylinks ) 
		{
			echo "<option value=" . $mylinks->wp_id . ">". $mylinks->fm_comp_name . "</option>";//echo $mylinks->wp_id;
		}


}	
?>
	
</select>	
</td>
<td>

<!--<option value="" selected>-</option>-->	
<!--</select>
</td>
<td>-->
	
<!-- search by profession TO DO -->
<?php
$fm_get_provider_profession = self::f_m_build_prof_simple();	
?>	
	
<select type="text" name="fac_provider_profession" id="fac_provider_profession">	
<option selected>Search by type</option>
<?php 
	echo $fm_get_provider_profession;
?>
	
</select>


	
</td>
<!--<td>
 search field TO DO 	
<input type="text" name="fac_mobile" id="fac_mobile"  class="regular-text">	
</td>-->
<td>
<!-- new provider field TO DO -->	
<!-- <a href="#" id="fac_new_provider"  class="regular-text">create new provider</a>-->
<input type='submit' id="fac_new_provider" name='New' value='Create new provider' />
	
</td>
</tr>	
</table>	
<!-- TODO: Provide markup for your options page here. data-validate="number"-->
    
<div id="errors"></div>
<div id="f_m_edit_form"></div>
<div id="f_m_resp_data">

<!-- wrap div -->

<!--*************************** file upload logic for service providers *********************** -->

<?php
 global $wpdb;

if(isset($_POST['fm_update']))
 {
	
	 
	//echo "update" . $_POST['fm_update'];
	
	$fm_update_service_provider = self::f_m_update_service_provider($_POST);	
	
	
	 
 }





if(isset($_POST['edit']))
 {
	 //$wpdb->delete( 'vt_userfile', array( 'id' => $_POST['del']));
	//echo "edit MONGO " . $_POST['edit'];
	//$wpdb->delete( 'vt_userfile', array( 'wpid' => $_POST['del']));
	// $wpdb->delete( 'wp_users', array( 'ID' => $_POST['del']));
	// $wpdb->delete( 'new_test', array( 'wp_id' => $_POST['del']));
	
	$fm_edit_provider_trial = self::f_m_edit_provider($_POST['edit']);
	//f_m_edit_provider
	
	 
 }


 if(isset($_POST['del']))
 {
	 //$wpdb->delete( 'vt_userfile', array( 'id' => $_POST['del']));
	 $vt_userfile = $wpdb->prefix . FM_DOC_TABLE;
	 $new_test = $wpdb->prefix . FM_SERVICE_TABLE;
	 
	 echo "delete" . $_POST['del'];
	 $wpdb->delete( $vt_userfile, array( 'wpid' => $_POST['del']));
	 $wpdb->delete( 'wp_users', array( 'ID' => $_POST['del']));
	 $wpdb->delete( $new_test, array( 'wp_id' => $_POST['del']));
	 
	 
 }

// ADD NEW USER

 if(isset($_POST['fm_add']))
 {
	 echo "add new service provider";
	 
	 // ADD NEW USER, DO NOT SEND PASSWORD
	 
	 if( null == username_exists( $_POST['email'] ) ) {

		  // Generate the password and create the user
		  $password = wp_generate_password( 12, false );
		  $user_id2 = wp_create_user( $_POST['email'], $password, $_POST['email'] );
		 

		  // Set the nickname
		  wp_update_user(
			array(
			  'ID'          =>    $user_id2,
			  'nickname'    =>    $email_address,
			  'first_name'  =>    $_POST['first_name'],
			  'last_name'  =>     $_POST['last_name'],
			  'user_email'  =>    $_POST['email'],
			  'user_url'  =>      $_POST['url']
				
			)
  );

  // Set the role
  $user = new WP_User( $user_id2 );
  $user->set_role( 'subscriber' );

  // Email the user
  //wp_mail( $_POST['email'], 'Welcome!', 'Your Password: ' . $password );

// ADD CUSTOM SERVICE PROVIDER DETAILS TO SPECIFIC TABLE	 

$custom_service_provider = $wpdb->prefix . FM_SERVICE_TABLE;
        
		$table_assign_fm=$wpdb->prefix.$custom_service_provider;
        $date='';
      
        $sql = $wpdb->prepare(
                "INSERT INTO $custom_service_provider (
						wp_id,
						fm_comp_name,
                        fm_provider,
                        fm_description,
						fm_type,
						fm_mobile,
						fm_telephone,
						fm_address
                ) VALUES (
                   %d,
				   %s,
				   %s,
                   %s,
				   %s,
				   %s,
				   %s,
				   %s
                   )"
                , $user_id2, $_POST['fac_comp_name'], $_POST['fac_user_type'], $_POST['fac_service_description'], $_POST['fac_provider_profession2'],
			$_POST['fac_mobile'], $_POST['fac_telephone'], $_POST['fac_address']);
         $result = $wpdb->query( $sql );			 
		 
// END, add service provider details		 
		 
} // end if
	 
	 
	 
	 
	 //$wpdb->delete( 'vt_userfile', array( 'id' => $_POST['del']));

	 
// IF FILES WERE UPLOADED ADD THEM TO FOLDER AND DATABASE	 
	 
 }


if(isset($_FILES['files']) ){
	
	if (isset($_POST['fm_update'])){
		//$_POST['fm_update']
		//echo "post ---- update was called";
		
		return;
		
		
	}
		//&& (!isset($_POST['edit']))
	
	else {
	
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
		$filename=$_POST['filename'];
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
		$user_id=1;
// IMPORTANT	
		//$yourtablename='vt_userfile';
		
		//		$wpdb->insert($yourtablename , array('userid' => 1 ,
		// 'filename' => $filename,'filedownload'=>$file_name));
		$new_fm_test = wp_upload_dir();
		
		echo "this is the filename " . $file_name;
		$file_name = ltrim($file_name, '0');
		
		echo "this is the NEW filename " . $file_name;
		
		$desired_dir = $new_fm_test['basedir'];
    
		//$desired_dir="../upload";
		//$desired_dir="http://www.test-sw2.com/wp35/wp-content/uploads";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
            }else{									// rename the file if another one exist
                $new_dir="$desired_dir/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
			
		 
        }
		else{
                print_r($errors);
        }
	} // 230
		
	if(empty($error)){
		
		
		$new_fm_test = wp_upload_dir();
		echo "Success";
		echo $_SERVER['DOCUMENT_ROOT'];
		//$new_fm_test = get_home_path();
		echo " is this working" . $new_fm_test['basedir'];
		
		echo "<a href=" . $new_fm_test['baseurl'] . "/" . $file_name . ">Show file</a>";
		
// ADD TO DATABASE	

		// build file download uri
		$fm_download_link = $new_fm_test['baseurl'] . "/" . $file_name;
		
		$yourtablename = $wpdb->prefix . FM_DOC_TABLE;
		
		$wpdb->insert($yourtablename , array('wpid' => $user_id2,
		'filename' => $file_name,'filedownload'=>$fm_download_link));

// DISPLAY ADDED USER


		// wp user table and extra user info table
		
		
		$user_table = "wp_users";
		$fm_doc_table = $wpdb->prefix . FM_DOC_TABLE;
		
		// get id of service provider
		
		// Show user that has just been added
		
		global $wpdb;
		
		$provider_table = $wpdb->prefix . FM_SERVICE_TABLE;
		
        $table = $provider_table;
			
        $sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID INNER JOIN $fm_doc_table ON wp_id = wpid AND wp_id = $user_id2", '' );
        $results = $wpdb->get_results($sql);
    	
    
		if(is_array($results)):
		$i=0;
		
		$fm_present_results = "<table name='trs_type' class='fm_widefat'> <thead>
    	<tr></tr></thead>";
		 foreach($results as $val):
            $i;
        
            
		$fm_present_results .= "<tbody><tr><td class='fm_title'>Name</td><td value='".$val->fm_comp_name ."'>" .$val->fm_comp_name . "</td></tr>
								<tr><td class='fm_title'>Contact name</td><td value='".$val->display_name ."'>".$val->display_name ."</td></tr>
								<tr><td class='fm_title'>Type</td><td value='".$val->fm_type ."'>".$val->fm_type ."</td></tr>
								<tr><td class='fm_title'>Email</td><td value='".$val->user_email ."'>".$val->user_email ."</td></tr>
								<tr><td class='fm_title'>Telephone</td><td value='".$val->fm_telephone ."'>".$val->fm_telephone ."</td></tr>
								<tr><td class='fm_title'>Mobile</td><td value='".$val->fm_mobile ."'>".$val->fm_mobile ."</td></tr>
								
								<tr><td class='fm_title'>Address</td><td value='".$val->fm_address ."'>".$val->fm_address ."</td></tr>
								<tr><td class='fm_title'>Description of services</td><td value='".$val->fm_description ."'>".$val->fm_description ."</td></tr>
								<tr><td class='fm_title'>Contract</td><td value=''><a href='".$val->filedownload ."' target='_blank'>". $val->filename ."</a></td></tr>
								<tr><td></td><td><form method='post' name='edit'><input type='hidden' name='edit' value='".$val->ID ."'/><input type='submit' name='Edit' value='EDIT' /></form>
								
								<form method='post' name='del'><input type='hidden' name='del' value='".$val->ID ."'/><input type='submit' name='Del' value='DELETE' /></form>
								</td></tr>";
            
		
			$i++;
        endforeach;
        $fm_present_results .= "</tbody></table>";
		echo $fm_present_results;
    	endif;

		
		// uploaded docs table

		
		
	} //274
		
	}
}
	
	
?>

	</div>
	
<div id="fm_profession">

<!-- Add professions -->	
<h3>
Add profession type	
</h3>

<form method="post" name="form_profession">

<input type='text' name='fm_prof_type' id='fm_prof_type' value=''/>
<input type='submit'  id='fm_prof_add' value='ADD' />
<input type='submit'  id='fm_prof_show_all' value='SHOW ALL' />

	
</form>

<div id="fm_profession_results">

	
</div>	

	
</div>	
	
</div>
	
	
  <!-- <div id="simpleform">
    <form class="cmxform" method="post" action="" enctype="multipart/form-data">
	
		<p>
			<label for="cname">Name (required)</label>
			<input id="cname" name="filename" minlength="2" type="text" required />
            </p>
            <p>
		<label for="cemail">File</label>
			<input type="file" name="files[]" multiple />
		<p>
			<input type="submit" value="Submit" />
		</p>
	
</form>
</p>
	<!-- TODO: Provide markup for your options page here. -->



<?php 
/*$i=0;
$res = $wpdb->get_results("SELECT * FROM vt_userfile WHERE userid=1");
?>
<table><tr><th>sno</th><th>File Name</th><th>File Download</th><th>Delete</th></tr>
<?php 
foreach ($res as $rs) {
	$i++;
	?>
    <tr><td><?php echo $i; ?></td><td><?php echo $rs->filename; ?><td><a href="http://localhost/valid/wp-content/upload/<?php echo $rs->filedownload; ?>" target="_blank"><?php echo $rs->filedownload; ?></a></td><td><form method="post" name="del"><input type="hidden" name="del" value="<?php echo $rs->id; ?>" /><input type="submit" name="Del" value="DELETE"  /></form></td></tr>

<?php 
} */
?>
<!--</table>-->


<!-- end - file upload logic for service providers -->