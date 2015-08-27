<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	
<?php 

//$meta_key = 'fac_user_type';
//$meta_value = 'yes';

//$user_query = new WP_User_Query( array( 'meta_key' => 'fac_user_type', 'meta_value' => 'yes', 'fields' => 'all_with_meta' ) );

//var_dump($user_query);

/*echo "hello mr taxi driver";
$test22 = get_users( array('meta_key' => 'fac_user_type', 'meta_value' => 'yes', 'fields' => 'all_with_meta') ); 
	
var_dump($test22);*/

// LEFT JOIN TRIAL


$fm_show_result_trial2 = self::fm_show_results_service_providers();
//        echo "here are the results " . $fm_show_result_trial2; 

//var_dump($fm_show_result_trial2);


	
	?>	
	
<!-- Dropdown list to choose a provider -->

<!-- put results in dropdown -->	
<select type="text" name="fac_provider_profession" id="fac_provider_profession">	
<?php foreach ( $fm_show_result_trial2 as $mylinks ) 
		{
			echo "<option value=" . $mylinks->wp_id . ">". $mylinks->fm_comp_name . "</option>";//echo $mylinks->wp_id;
		}
?>


	
</select> 	
	
<!-- TODO: Provide markup for your options page here. data-validate="number"-->
    
<form id="f_m_input" method="post" action="">
    
		<p>
			<label for="name">Name (required)</label>
			<input id="name" name="name" minlength="2" type="text" required />
            </p>
            <p>
		<label for="email">E-Mail (required)</label>
			<input id="email" type="email" name="email" required />
		<p>
			<input class="submit" type="submit" value="Submit" id="adminformsend"/>
		</p>
	
</form>
<div id="errors"></div>
<div id="f_m_edit_form"></div>
<div id="f_m_resp_data"></div>

</div>