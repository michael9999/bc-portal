<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Plugin_Nameg
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<!-- TODO: Provide markup for your options page here. data-validate="number"-->
    
<form id="f_m_input_calendar" method="post" action="">
    
        <input id="datepicker" type="text" name="datepicker">
        <input id="fm_title" type="text" name="fm_title">
        <input class="submit" type="submit" value="Submit" id="calendarsend"/>
		<!--<p>
			<label for="name">Name (required)</label>
			<input id="name" name="name" minlength="2" type="text" required />
            </p>
            <p>
		<label for="email">E-Mail (required)</label>
			<input id="email" type="email" name="email" required />
		<p>
			<input class="submit" type="submit" value="Submit" id="adminformsend"/>
		</p>-->
	
</form>
<div id="errors"></div>
<div id="f_m_edit_form"></div>
<div id="f_m_resp_data"></div>

</div>