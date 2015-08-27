<?php
/**
 * Plugin Name: Webfish Dropdown Menu
 * Plugin URI: http://www.webfish.se/wp/plugins/webfish-dropdown-menu
 * Version: 0.9.15
 * Description: Adds a dropdown menu on all the menu objects name like this: wdd-something.
 * Author: Tobias Nyholm
 * Author URI: http://www.tnyholm.se
 * License: GPLv3
 * Copyright: Tobias Nyholm 2010
 */

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

//define a global variable
global $wdd_menu_echo;


include_once dirname(__FILE__)."/admin.php";

/**
 * Check if it should be a dropdown menu or not, then return / echo it. 
 * @param $menuContent
 */
function wdd_menu_wp_nav_menu_action($menuContent){
	$regex="|<ul id=['".'"'."]menu-(.*?)['".'"'."].*?>|ms";
	$match=preg_match($regex,$menuContent,$matches);
	//die("<pre>".print_r($matches,true));//Test code 
	if($match){
		$menu_name=$matches[1];
		if(substr($menu_name,0,3)=="wdd"){

			$menuContent='
				<div id="DropDownMenuNav">
				  	'.$menuContent.'
				</div><!-- DropDownMenu -->
					';
		}
	}
	global $wdd_menu_echo;
	if($wdd_menu_echo)
		echo  $menuContent;
	else
		return $menuContent;
	
}
add_action( 'wp_nav_menu', 'wdd_menu_wp_nav_menu_action' );

/**
 * Modify the args ..
 * @param $args
 */
function wdd_menu_wp_nav_menu_args( $args = '' )
{
	global $wdd_menu_echo;
	$wdd_menu_echo=$args['echo'];
	$args['echo'] = false;
	$args['menu_class'].=" DropDownMenu";
	$args['menu_id']="";
	
	/* It is not seo-friendly nor user-friendly to have it deaper than this. 
	 * Therefore I have not spent time on the css to make a deaper menu look nice. 
	 * You should do the same.. */
	$args['depth'] = 2;
	return $args;
} 
add_filter( 'wp_nav_menu_args', 'wdd_menu_wp_nav_menu_args' );

/**
 * Call this function from your header.php to get the menu. The arguments are the same as for wp_list_pages.  
 * Title_li is disabled. 
 * Check out wp_list_pages for futher information
 * @param $args
 */
function webfish_dropdown_menu($args=''){
	//defalts form wp-includes/post-template.php in wordpress 3.0.1
	$defaults = array(
		'depth' => 0, 'show_date' => '',
		'date_format' => get_option('date_format'),
		'child_of' => 0, 'exclude' => '',
		'title_li' => "", 'echo' => 1,
		'authors' => '', 'sort_column' => 'menu_order, post_title',
		'link_before' => '', 'link_after' => '', 'walker' => '',
		'menu_class'=>'', //This last one is added by webfish
	);
	$r = wp_parse_args( $args, $defaults );
	$r['title_li']="";//or else the menu does not look good. 
	$r=wdd_menu_wp_nav_menu_args($r);
	
	$menuContent=wp_list_pages($r);
	$menuContent='
	<div id="DropDownMenuNav">
		<ul class="'.$r['menu_class'].'">
			'.$menuContent.'
		</ul>
	</div><!-- DropDownMenu -->
	';
	global $wdd_menu_echo;
	if($wdd_menu_echo)
		echo  $menuContent;
	else
		return $menuContent;
}


/**
 * Print the styles to customize the menu, 
 */
function wdd_print_menu_styles(){
	$settings=get_option('wdd_menu_settings');
	
	/* Add some default values if the field is empty*/
	//Add "0" to empty setting values
	foreach(array("pos-top","pos-right","pos-down","pos-left") as $name)
		if($settings[$name]=="")
			$settings[$name]="0";
	
	//Add "transparent" to empty setting values
	foreach(array("sub-border-color") as $name)
		if($settings[$name]=="")
			$settings[$name]="transparent";
	
	//Add "inherit" to empty setting values
	foreach($settings as $name=>$value)
		if($value="")
			$settings[$name]="inherit";
	
	?>
	<style type="text/css">
#DropDownMenuNav ul.sub-menu li,
#DropDownMenuNav ul.children li{
  width: <?php echo $settings['sub-width'];?>;
  background-color: <?php echo $settings['sub-bg-color'];?>;
  height: <?php echo $settings['sub-height'];?>;
}
#DropDownMenuNav ul.sub-menu li a,
#DropDownMenuNav ul.children li a{
	line-height: <?php echo $settings['sub-line-height'];?>; 
}
#DropDownMenuNav ul.DropDownMenu a{
  color: <?php echo $settings['top-text-color'];?>; 
}
#DropDownMenuNav ul.sub-menu a,
#DropDownMenuNav ul.children a{
  color: <?php echo $settings['sub-text-color'];?>; 
}
#DropDownMenuNav ul.sub-menu,
#DropDownMenuNav ul.children{
  border: 1px solid <?php echo $settings['sub-border-color'];?>;
  width: <?php echo $settings['sub-width'];?>;
  margin:<?php echo $settings['pos-top']." ".$settings['pos-right']." ".$settings['pos-down']." ".$settings['pos-left'];?>;
  
}
#DropDownMenuNav ul.DropDownMenu li:hover{
  background-color: <?php echo $settings['hov-top-bg-color'];?>;
}
#DropDownMenuNav ul.DropDownMenu li:hover > a{
  color: <?php echo $settings['hov-top-text-color'];?>; 
}
#DropDownMenuNav ul.sub-menu li:hover,
#DropDownMenuNav ul.children li:hover{
  background-color: <?php echo $settings['hov-sub-bg-color'];?>;
}
#DropDownMenuNav ul.sub-menu li:hover>a,
#DropDownMenuNav ul.children li:hover>a{
  color: <?php echo $settings['hov-sub-text-color'];?>; 
}

	</style>
<?php 
}
add_action('wp_head', 'wdd_print_menu_styles');

/**
 * installation hook 
 */
function wdd_install(){
	add_option("wdd_menu_settings", wdd_get_defaults(),'','yes');
}
register_activation_hook(__FILE__,'wdd_install');

### Function: Enqueue CSS
add_action('wp_enqueue_scripts', 'wdd_css');
function wdd_css() {
	//import css
	if(@file_exists(TEMPLATEPATH.'/menuStyle.css')) {
		wp_enqueue_style('webfish-dropdown-menu', get_stylesheet_directory_uri().'/menuStyle.css.css', false, '0.51', 'all');
	} else {
		wp_enqueue_style('webfish-dropdown-menu', plugins_url('webfish-dropdown-menu/menuStyle.css'), false, '0.51', 'all');
	}
	
	$settings=get_option('wdd_menu_settings');
	if(isset($settings['vertical']) && $settings['vertical']=="1")
		wp_enqueue_style('webfish-dropdown-menu-vertival', plugins_url('webfish-dropdown-menu/menuStyleVertical.css'), false, '0.51', 'all');
	
}