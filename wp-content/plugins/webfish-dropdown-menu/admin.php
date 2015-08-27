<?php
/*

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

function wdd_admin_menu() {
	$page=array();
	
  	//Add some submenus
  	//parent, title, link, rights, url, function
  	$page[]=add_submenu_page('themes.php', 'Webfish DropDown', 'Webfish DropDown','manage_options','wdd-options', 'wdd_admin_options');

  	foreach($page as $p){
  		add_action("load-$p", 'wdd_admin_load');
  	}
}
add_action('admin_menu', 'wdd_admin_menu');
add_action('admin_init', 'wdd_admin_init');


function wdd_admin_init(){
	wp_register_style('wddStyleAdmin', WP_CONTENT_URL.'/plugins/webfish-dropdown-menu/admin.css');
}


function wdd_admin_load(){
	//the color pick script
	wp_enqueue_script('custom-background');
	
	//style
	wp_enqueue_style('farbtastic');
	wp_enqueue_style('wddStyleAdmin');

	
}

function wdd_get_defaults(){
	return array(
		"top-text-color"=>"",
		"sub-height"=>"30px",
		"sub-width"=>"300px",
		"sub-line-height"=>"28px",
		"sub-bg-color"=>"",
		"sub-text-color"=>"",
		"sub-border-color"=>"#000000",
		"hov-top-bg-color"=>"",
		"hov-top-text-color"=>"",
		"hov-sub-bg-color"=>"",
		"hov-sub-text-color"=>"",
		"pos-top"=>"",
		"pos-right"=>"",
		"pos-down"=>"",
		"pos-left"=>"-2px",
		"vertical"=>"0",
	);
}

function wdd_admin_options(){
	
	echo "<div id='wdd_admin'><h1>Webfish dropdown menu</h1>";
	
	$defaults=wdd_get_defaults();
	
	//Load settings form database
	$settings=get_option('wdd_menu_settings');	
	
	$settings = wp_parse_args( $settings, $defaults );
	
	/*
	 * handle post
	 */
	if(wdd_post("do")=="update"){
		foreach ($settings as $name => $value)
			$settings[$name]=wdd_post($name);
		update_option('wdd_menu_settings',$settings);
		echo "<div class='success'>Saved!</div>";
	}
	
	
	/*
	 * Print html
	 */
	?>
	<table id="wdd_wrapper"><tr><td class="left">
	<form id="wdd_color_form" action="" method="POST">
	<input type="hidden" name="do" value="update" />
	<table>
		<tr><th colspan="2">Type</th></tr>		
		<tr><td>Type</td><td><select name="vertical">
			<option value="0" <?php echo wdd_getValue($settings,'vertical')!="1"?"selected":"";?>>Horizontal</option>
			<option value="1" <?php echo wdd_getValue($settings,'vertical')=="1"?"selected":"";?>>Vertical</option>
		</select>
		</td></tr>
		
		<tr><th colspan="2">Top menu item</th></tr> 
		<tr><td>Text color</td><td><input name="top-text-color" value="<?php echo wdd_getValue($settings,'top-text-color');?>" type="text" /></td></tr>
		
		<tr><th colspan="2">Submenu item</th></tr>
		<tr><td>Height</td><td><input name="sub-height" value="<?php echo wdd_getValue($settings,'sub-height');?>" type="text" /></td></tr>
		<tr><td>Width</td><td><input name="sub-width" value="<?php echo wdd_getValue($settings,'sub-width');?>" type="text" /></td></tr>
		<tr><td>Line height</td><td><input name="sub-line-height" value="<?php echo wdd_getValue($settings,'sub-line-height');?>" type="text" /></td></tr>
		<tr><td>Background</td><td><input name="sub-bg-color" value="<?php echo wdd_getValue($settings,'sub-bg-color');?>" type="text" /></td></tr>
		<tr><td>Text color</td><td><input name="sub-text-color" value="<?php echo wdd_getValue($settings,'sub-text-color');?>" type="text" /></td></tr>
		<tr><td>Border color</td><td><input name="sub-border-color" value="<?php echo wdd_getValue($settings,'sub-border-color');?>" type="text" /></td></tr>
		
		<tr><th colspan="2">Hovering</th></tr>
		<tr><td>Topmenu, background</td><td><input name="hov-top-bg-color" value="<?php echo wdd_getValue($settings,'hov-top-bg-color');?>" type="text" /></td></tr>
		<tr><td>Topmenu, text color</td><td><input name="hov-top-text-color" value="<?php echo wdd_getValue($settings,'hov-top-text-color');?>" type="text" /></td></tr>
		<tr><td>Submenu, background</td><td><input name="hov-sub-bg-color" value="<?php echo wdd_getValue($settings,'hov-sub-bg-color');?>" type="text" /></td></tr>
		<tr><td>Submenu, text color</td><td><input name="hov-sub-text-color" value="<?php echo wdd_getValue($settings,'hov-sub-text-color');?>" type="text" /></td></tr>
		
		<tr><th colspan="2">Positioning (submenu)</th></tr>		
		<tr><td>Top</td><td><input name="pos-top" value="<?php echo wdd_getValue($settings,'pos-top');?>" type="text" /><small class="small">(Don't use a positive value)</small></td></tr>
		<tr><td>Right</td><td><input name="pos-right" value="<?php echo wdd_getValue($settings,'pos-right');?>" type="text" /></td></tr>
		<tr><td>Down</td><td><input name="pos-down" value="<?php echo wdd_getValue($settings,'pos-down');?>" type="text" /></td></tr>
		<tr><td>Left</td><td><input name="pos-left" value="<?php echo wdd_getValue($settings,'pos-left');?>" type="text" /></td></tr>
				
	</table>
	<input type="submit" value="Save" />
	
	</form>
	</td><td class="right">
<h3><?php _e('Test colors'); ?>:</h3>
<input type="text" name="background-color" id="background-color" value="#ff44ff" />
<a class="hide-if-no-js" href="#" id="pickcolor"><?php _e('Select a Color'); ?></a>
<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
</td></tr>
</table>
	</div><!-- end wdd_admin -->
	<?php 
}



function wdd_getValue(array &$arr,$key){
	if(isset($arr[$key]))
		return esc_attr($arr[$key]);
	return "";
}

/**
 * Use wdd_post() as value in a input-tag. This will return "" instead of the error you get with $_POST
 * @param String $str
 */
function wdd_post($str){
	if(isset($_POST[$str]))
		return $_POST[$str];
	return "";
}

