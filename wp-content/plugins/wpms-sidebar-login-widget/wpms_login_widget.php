<?php
/*
Plugin Name: WPMS Sidebar Login Widget
Plugin URI: http://www.7mediaws.org/blog/wpms_sidebar_login_widget.html
Description: A sidebar login widget for all the blogs in a multisite network as well as for a standalone WordPress install.
Author: Joshua Parker
Version: 1.9.4
Author URI: http://www.joshparker.us/
*/

add_action( 'admin_init', 'register_wpms_network_sidebar_login_settings' );
add_action( 'admin_menu', 'wpms_network_sidebar_login_menu' );

function register_wpms_network_sidebar_login_settings() {
	//register our settings
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_rememberme' );
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_subscribe_main_site' );
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_subscribe_other_blog' );
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_forum_installed' );
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_forum_url' );
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_css' );
	register_setting( 'wpms-network-sidebar-login-settings-group', 'network_sidebar_login_custom_url' );
}

function wpms_network_sidebar_login_menu() {

	//create options menu
	add_options_page('WPMS Network Sidebar Login Plugin Settings', 'WPMS Sidebar Login', 'manage_options', 'wpms-network-sidebar-login-settings', 'wpms_network_sidebar_login_settings_page');

}

function set_wpms_sidebar_login_options() {
	add_option('network_sidebar_login_rememberme','no','Remember Me');
	add_option('network_sidebar_login_subscribe_main_site','no','Subscribe to Main Site');
	add_option('network_sidebar_login_subscribe_other_blog','','Subscribe to Other Blog');
	add_option('network_sidebar_login_forum_installed','no','Login Sidebar Forum Install');
	add_option('network_sidebar_login_forum_url','','URL of forum installed');
	add_option('network_sidebar_login_css','','Custom CSS');
	add_option('network_sidebar_login_custom_url','','Custom URL');
}

function unset_wpms_sidebar_login_options() {
	delete_option('network_sidebar_login_rememberme');
	delete_option('network_sidebar_login_subscribe_main_site');
	delete_option('network_sidebar_login_subscribe_other_blog');
	delete_option('network_sidebar_login_forum_installed');
	delete_option('network_sidebar_login_forum_url');
	delete_option('network_sidebar_login_css');
	delete_option('network_sidebar_login_custom_url');
}

if(get_option('network_sidebar_login_subscribe_main_site') == 'yes') {
function u2s_add_new_user($user_id) {
	$user_caps = get_usermeta($user_id,'wp_capabilities');
	if( ! is_array($user_caps)){
	update_usermeta($user_id,'wp_capabilities',array('subscriber'=>1));
	}
}

function u2s_add_new_blog($blog_id, $user_id) {
	$user_caps = get_usermeta($user_id,'wp_capabilities');
	if( ! is_array($user_caps)){
	update_usermeta($user_id,'wp_capabilities',array('subscriber'=>1));
	}
}

function update_main_blog_subs(){
	//this snippet imports all user data from db into blog 1 as subscriber
	global $wpdb;
	$userinfos = $wpdb->get_results("SELECT ID from $wpdb->users",ARRAY_A);
	foreach($userinfos as $userinfo){
	u2s_add_new_user($userinfo['ID']);
	}
}

add_action( 'wpmu_new_user', 'u2s_add_new_user', 10, 1);
add_action( 'user_register', 'u2s_add_new_user', 10, 1);
add_action( 'wpmu_new_blog', 'u2s_add_new_blog', 10, 2 );

add_action('admin_head', 'update_main_blog_subs', 10 );
add_action('wp_login', 'update_main_blog_subs', 10 );

} else {

function new_u2s_add_new_user($user_id) {
	$user_caps = get_usermeta($user_id,'wp_'.get_option('network_sidebar_login_subscribe_other_blog').'_capabilities');
	if( ! is_array($user_caps)){
	update_usermeta($user_id,'wp_'.get_option('network_sidebar_login_subscribe_other_blog').'_capabilities',array('subscriber'=>1));
	}
}

function new_u2s_add_new_blog($blog_id, $user_id) {
	$user_caps = get_usermeta($user_id,'wp_'.get_option('network_sidebar_login_subscribe_other_blog').'_capabilities');
	if( ! is_array($user_caps)){
	update_usermeta($user_id,'wp_'.get_option('network_sidebar_login_subscribe_other_blog').'_capabilities',array('subscriber'=>1));
	}
}

function update_other_blog_subs(){
	//this snippet imports all user data from db into blog 1 as subscriber
	global $wpdb;
	$userinfos = $wpdb->get_results("SELECT ID from $wpdb->users",ARRAY_A);
	foreach($userinfos as $userinfo){
	new_u2s_add_new_user($userinfo['ID']);
	}
}

add_action( 'wpmu_new_user', 'new_u2s_add_new_user', 10, 1);
add_action( 'user_register', 'new_u2s_add_new_user', 10, 1);
add_action( 'wpmu_new_blog', 'new_u2s_add_new_blog', 10, 2 );

add_action('admin_head', 'update_other_blog_subs', 10 );
add_action('wp_login', 'update_other_blog_subs', 10 );
}

function wpms_network_sidebar_login_stylesheet() {
$custom_sidebar_login_css = get_option('network_sidebar_login_css');
	if($custom_sidebar_login_css) {
	echo "\n <!-- Custom Sidebar Login CSS : http://www.7mediaws.org/ --> \n";
?>
	<style type="text/css" media="screen">
	<?php echo $custom_sidebar_login_css."\n"; ?>
	</style>
<?php
	}
}

function wpms_network_sidebar_login_settings_page() {
global $wpdb;
$network_sidebar_login_subblog =  get_site_option('network_sidebar_login_subblog');

$defaultmsg="/* If you are good at CSS, you can style the login widget. */

/* This is a comment. Comments begin with /* and end with */

/* Below is example css; uncomment to see how the avatar is affected. */

/* #wp_sidebarlogin-4 img.avatar {
	background: #FFF;
	margin-top:2px;
	padding: 4px;
	border: 1px solid #DDD;
/* Round Corners (native in Safari, Firefox and Chrome) */
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
} */

/*
Things we strip out include:
 * HTML code
 * @import rules
 * expressions
 * invalid and unsafe code
 * URLs not using the http: protocol

Things we encourage include:
 * @media blocks!
 * sharing your CSS!
 * testing in several browsers!
*/";
	$stylecontent=get_option('network_sidebar_login_css');
	if (!$stylecontent)
		$stylecontent=$defaultmsg;
	
	// Update
	if ( (isset($_POST['action']))&&($_POST['action']=='update')) {
	
		if (isset($_POST['restore'])) {
			update_option('network_sidebar_login_css','');
			$stylecontent=$defaultmsg;
		}elseif (isset($_POST['network_sidebar_login_css'])) {
			
			$stylecontent = stripslashes($_POST['network_sidebar_login_css']);
			
			//remove scripts and PHP
			$stylecontent = stripslashes(wp_filter_post_kses( $stylecontent ));
			
			//remove HTML
			$stylecontent=strip_tags($stylecontent);
			
			//remove comments
			$pattern2="/\/\*.*?\\*\//is";
			$stylecontent=preg_replace($pattern2,'',$stylecontent);
			
			
			//remove import and expressions with ()
			$stylecontent=preg_replace('/@import\\(.*?\\)/is','',$stylecontent);
			$stylecontent=preg_replace('/import\\(.*?\\)/is','',$stylecontent);
			$stylecontent=preg_replace('/expression\\(.*?\\)/is','',$stylecontent);
			
			$stylecontent=str_replace('important','replaceim',$stylecontent);
			
			//remove import and expressions
			$stylecontent=preg_replace('/@import/is','',$stylecontent);
			$stylecontent=preg_replace('/import/is','',$stylecontent);
			$stylecontent=preg_replace('/expression/is','',$stylecontent);
			
			$stylecontent=str_replace('replaceim','important',$stylecontent);
			
			//check urls
			$pattern="/\\(.*?\\)/is";	
			preg_match_all($pattern,$stylecontent,$matches);

					$rub=array(')','(','\'','"');
					
					foreach($matches[0] as $match) {
						$match=str_replace($rub,'',$match); //remove (' ("
						strtolower($match);
						
						
						//strRpos
						$pos[0]=strrpos($match,'.jpg');
						$pos[1]=strrpos($match,'.jpeg');
						$pos[2]=strrpos($match,'.gif');
						$pos[3]=strrpos($match,'.png');
						
						//.jpeg?w=1000... 25
						$acceptablepo=strlen($match)-25;
						$error=true;
						
						foreach($pos as $po) {
							if($po>$acceptablepo) {
								$error=false;
								continue;
							}
						}
						if($error)
							$msg.='Invalid URL: '.$match.'<br/>';
						
						if (substr(trim($match),0,7)!=='http://') {
							$error=true;
							$msg.='URL should start with http:// '.$match.'<br/>';
						}
						
					} //endforeach
		
		
			if(!$msg) {
				update_option('network_sidebar_login_css',$stylecontent);
				$msg='Stylesheet updated successfully.';
			}
		}//endelseif
	}//endif
?>
<div class="wrap">
<h2><?php _e('Network Sidebar Login Widget','wpms-network-sidebar-login'); ?></h2>

<form method="post" action="options.php">
    <?php settings_fields( 'wpms-network-sidebar-login-settings-group' ); ?>
    <table class="form-table">
    	<tr valign="top">
        <th scope="row"><?php _e('Remember me automatically checked?','wpms-network-sidebar-login'); ?></th>
        <td><input type="checkbox" name="network_sidebar_login_rememberme" value="yes" <?php if(get_option('network_sidebar_login_rememberme') == yes) echo "CHECKED"; ?> /></td>
        </tr>
<?php if(is_multisite() && current_user_can('manage_network_options')) { ?>       
        <tr valign="top">
        <th scope="row"><?php _e('Subscribe users to main site?','wpms-network-sidebar-login'); ?></th>
        <td><input type="checkbox" name="network_sidebar_login_subscribe_main_site" value="yes" <?php if(get_option('network_sidebar_login_subscribe_main_site') == yes) echo "CHECKED"; ?> />
        <p>(<?php _e('Note: If you rather subscribe users to a different blog instead of the main site, use the next setting instead.','wpms-network-sidebar-login'); ?>)</p>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row"><?php _e('Rather subscribe users to a different blog? Enter blog ID.','wpms-network-sidebar-login'); ?></th>
        <td><input type="text" name="network_sidebar_login_subscribe_other_blog" value="<?php echo get_option('network_sidebar_login_subscribe_other_blog'); ?>" /></td>
        </tr>
<?php } ?>        
        <tr valign="top">
        <th scope="row"><?php _e('Do you have a forum installed?','wpms-network-sidebar-login'); ?></th>
        <td><input type="checkbox" name="network_sidebar_login_forum_installed" value="yes" <?php if(get_option('network_sidebar_login_forum_installed') == yes) echo "CHECKED"; ?> /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row"><?php _e('What is the url of your forum?','wpms-network-sidebar-login'); ?></th>
        <td><input type="text" name="network_sidebar_login_forum_url" value="<?php echo get_option('network_sidebar_login_forum_url'); ?>" /> <br />
        <p><?php _e('Example:','wpms-network-sidebar-login'); ?> <b><?php echo get_option('siteurl'); ?>/<?php _e('forum_path','wpms-network-sidebar-login'); ?></b></p>
        </td>
        </tr>
<?php if(!is_multisite()) { ?>        
        <tr valign="top">
        <th scope="row"><?php _e('Custom URL','wpms-network-sidebar-login'); ?></th>
        <td><input type="text" name="network_sidebar_login_custom_url" value="<?php echo get_option('network_sidebar_login_custom_url'); ?>" />
        <p><?php _e('If you have a custom registration page, enter the relative path to that page. Example: http://'.get_option('siteurl').'/<b>register</b>','wpms-network-sidebar-login'); ?></p>
        </td>
        </tr>
<?php } ?>        
        <tr valign="top">
        <th scope="row"><?php _e('Custom CSS','wpms-network-sidebar-login'); ?></th>
        <td><textarea name="network_sidebar_login_css" id="network_sidebar_login_css" cols="50" rows="30" class="large-text code"><?php echo $stylecontent; ?></textarea></td>
        </tr>

    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes','wpms-network-sidebar-login') ?>" />
    </p>

</form>
</div>
<?php 
}

function widget_wpms_network_login_init() {
	if ( !function_exists('wp_register_sidebar_widget') )
		return;

function widget_wpms_network_login() {

  global $wpdb, $user_ID, $user_identity;
  get_currentuserinfo();
  if (!$user_ID):

if(is_multisite()) {
?>
<div id="wp_sidebarlogin-4" class="widget widget_wp_sidebarlogin"><h3 class="widget-title"><span><?php _e('Login','wpms-network-sidebar-login'); ?></span></h3>
<form name="loginform" action="<?php echo get_option('siteurl'); ?>/wp-login.php" method="post">

      <label><?php _e('Username','wpms-network-sidebar-login'); ?>:</label>
      <p><input name="log" id="user_login" class="inbox" value=""/></p>

      <label><?php _e('Password','wpms-network-sidebar-login'); ?>:</label>
      <p><input name="pwd" id="user_pass" type="password" value="" class="inbox"/></p>
      
      <p class="rememberme"><input name="rememberme" id="rememberme" value="forever" type="checkbox" <?php if(get_option('network_sidebar_login_rememberme') == yes) echo "CHECKED"; ?> />&nbsp;<?php _e('Remember me','wpms-network-sidebar-login'); ?></p>

      <p class="submit"><input name="submit" type="submit" value="<?php _e('Login &raquo;','wpms-network-sidebar-login'); ?>" class="submit-button"/>
      <input type="hidden" name="redirect_to" value="<?php echo get_option('siteurl'); ?>"/>
      </p>

<ul class="sidebarlogin_otherlinks">
<?php if(!function_exists(mp_br_new_blog)) { ?>
<li><a href="<?php bloginfo('url'); ?>/wp-signup.php" title="<?php _e('Sign up for a new account','wpms-network-sidebar-login'); ?>"><?php _e('Create a new account','wpms-network-sidebar-login'); ?></a></li>
<?php } else { ?>
<li><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=register" title="<?php _e('Sign up for a new account','wpms-network-sidebar-login'); ?>"><?php _e('Create a new account','wpms-network-sidebar-login'); ?></a></li>
<?php } ?>
<li><a href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword" title="<?php _e('Get a new password sent to you','wpms-network-sidebar-login'); ?>"><?php _e('Lost your password?','wpms-network-sidebar-login'); ?></a></li>
</ul>
      </form>
</div>

<?php } else { ?>

<div id="wp_sidebarlogin-4" class="widget widget_wp_sidebarlogin"><h3 class="widget-title"><span><?php _e('Login','wpms-network-sidebar-login'); ?></span></h3>
<form name="loginform" action="<?php echo get_option('siteurl'); ?>/wp-login.php" method="post">

      <label><?php _e('Username','wpms-network-sidebar-login'); ?>:</label>
      <p><input name="log" id="user_login" class="inbox" value=""/></p>

      <label><?php _e('Password','wpms-network-sidebar-login'); ?>:</label>
      <p><input name="pwd" id="user_pass" type="password" value="" class="inbox"/></p>
      
      <p class="rememberme"><input name="rememberme" id="rememberme" value="forever" type="checkbox" <?php if(get_option('network_sidebar_login_rememberme') == yes) echo "CHECKED"; ?> />&nbsp;<?php _e('Remember me','wpms-network-sidebar-login'); ?></p>

      <p class="submit"><input name="submit" type="submit" value="<?php _e('Login &raquo;','wpms-network-sidebar-login'); ?>" class="submit-button"/>
      <input type="hidden" name="redirect_to" value="<?php echo get_option('siteurl'); ?>"/>
      </p>

<ul class="sidebarlogin_otherlinks">
<?php if(get_option('network_sidebar_login_custom_url') == '') { ?>
<li><a href="<?php bloginfo('url'); ?>/wp-login.php?action=register" title="<?php _e('Sign up for a new account','wpms-network-sidebar-login'); ?>"><?php _e('Create a new account','wpms-network-sidebar-login'); ?></a></li>
<?php } else { ?>
<li><a href="<?php bloginfo('url'); ?>/<?php echo get_option('network_sidebar_login_custom_url'); ?>" title="<?php _e('Sign up for a new account','wpms-network-sidebar-login'); ?>"><?php _e('Create a new account','wpms-network-sidebar-login'); ?></a></li>
<?php } ?>
<li><a href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword" title="<?php _e('Get a new password sent to you','wpms-network-sidebar-login'); ?>"><?php _e('Lost your password?','wpms-network-sidebar-login'); ?></a></li>
</ul>
      </form>
</div>

<?php } ?>

<?php else: ?>

<div id="wp_sidebarlogin-4" class="widget widget_wp_sidebarlogin"><h3 class="widget-title"><span><?php _e('Welcome','wpms-network-sidebar-login'); ?> <?php echo $user_identity ?></span></h3>

<?php
$wpms_blog_id = $wpdb->get_var("SELECT meta_value FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'primary_blog' AND user_id = '" . $user_ID . "'");
$wpms_blog_domain = $wpdb->get_var("SELECT domain FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $wpms_blog_id . "'");
$wpms_blog_path = $wpdb->get_var("SELECT path FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $wpms_blog_id . "'");

if ($wpms_blog_domain == ''){
	$wpms_blog_domain = $current_site->domain;
}

if ($wpms_blog_path == ''){
	$wpms_blog_path = $current_site->path;

}

$wpms_user_url =  'http://' . $wpms_blog_domain . $wpms_blog_path;

if(is_multisite()) {
?>

<div class="avatar_container" style="float:left;"><a href="<?php echo $wpms_user_url; ?>" title="<?php _e('Go to your blog homepage','wpms-network-sidebar-login'); ?>"><?php echo get_avatar($user_ID,'48',get_option('avatar_default')); ?></a></div>
<?php if(is_super_admin()) { ?>
&nbsp;<a href="<?php echo $wpms_user_url; ?>wp-admin/network/" title="<?php _e('Network Admin','wpms-network-sidebar-login'); ?>"><strong><?php _e('Network Admin','wpms-network-sidebar-login'); ?></a></strong>
<br />
<?php } ?>
&nbsp;<a href="<?php echo $wpms_user_url; ?>wp-admin/" title="<?php _e('Dashboard','wpms-network-sidebar-login'); ?>"><strong><?php _e('Your dashboard','wpms-network-sidebar-login'); ?></a></strong>
<?php if(current_user_can('publish_posts')) { ?>
<br />
&nbsp;<a href="<?php echo $wpms_user_url; ?>wp-admin/post-new.php" title="<?php _e('Posting Area','wpms-network-sidebar-login'); ?>"><?php _e('Write a post','wpms-network-sidebar-login'); ?></a>
<?php } ?>
<br />
&nbsp;<a href="<?php echo $wpms_user_url; ?>wp-admin/profile.php" title="<?php _e('Edit your profile','wpms-network-sidebar-login'); ?>"><?php _e('Edit your profile','wpms-network-sidebar-login'); ?></a>
<br /><br />
<?php _e('Welcome back','wpms-network-sidebar-login'); ?> <?php echo $user_identity; ?>, <?php _e('use the links above to get started or you can','wpms-network-sidebar-login'); ?> <?php $wpms_version = get_bloginfo('version'); if ($wpms_version >= '2.7') { ?> <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>"><?php _e('Log out &raquo;','wpms-network-sidebar-login'); ?></a> <?php } else { ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','wpms-network-sidebar-login'); ?>"><?php _e('Log out &raquo;','wpms-network-sidebar-login'); ?></a> <?php } ?>.

<?php if(get_option('network_sidebar_login_forum_installed') == 'yes') { ?>
<br /><br />
<?php _e('You can get help and support and chat with other users at the','wpms-network-sidebar-login'); ?> <a href="<?php echo get_option('network_sidebar_login_forum_url'); ?>" title="<?php _e('Search, post at and enjoy our discussion space','wpms-network-sidebar-login'); ?>"><?php _e('Forums','wpms-network-sidebar-login'); ?></a>.
<?php } ?>
</div>

<?php } else { ?>

<div class="avatar_container" style="float:left;"><a href="<?php bloginfo('url'); ?>" title="<?php _e('Go to homepage','wpms-network-sidebar-login'); ?>"><?php echo get_avatar($user_ID,'48',get_option('avatar_default')); ?></a></div>
&nbsp;<a href="<?php bloginfo('url'); ?>/wp-admin/" title="<?php _e('Dashboard','wpms-network-sidebar-login'); ?>"><strong><?php _e('Your dashboard','wpms-network-sidebar-login'); ?></a></strong>
<br />
<?php if(current_user_can('publish_posts')) { ?>
&nbsp;<a href="<?php bloginfo('url'); ?>/wp-admin/post-new.php" title="<?php _e('Posting Area','wpms-network-sidebar-login'); ?>"><?php _e('Write a post','wpms-network-sidebar-login'); ?></a>
<br />
<?php } ?>
&nbsp;<a href="<?php bloginfo('url'); ?>/wp-admin/profile.php" title="<?php _e('Edit your profile','wpms-network-sidebar-login'); ?>"><?php _e('Edit your profile','wpms-network-sidebar-login'); ?></a>
<br /><br /><br />
<?php _e('Welcome back','wpms-network-sidebar-login'); ?> <?php echo $user_identity; ?>, <?php _e('use the links above to get started or you can','wpms-network-sidebar-login'); ?> <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>"><?php _e('Log out &raquo;','wpms-network-sidebar-login'); ?></a>.

<?php if(get_option('network_sidebar_login_forum_installed') == 'yes') { ?>
<br /><br />
<?php _e('You can get help and support and chat with other users at the','wpms-network-sidebar-login'); ?> <a href="<?php echo get_option('network_sidebar_login_forum_url'); ?>" title="<?php _e('Search, post at and enjoy our discussion space','wpms-network-sidebar-login'); ?>"><?php _e('Forums','wpms-network-sidebar-login'); ?></a>.
<?php } ?>
</div>

<?php } ?>

<?php endif; ?>

<?php
	}	
	wp_register_sidebar_widget('wpms_network_sidebar_login_2011', 'WPMS Network Sidebar Login', 'widget_wpms_network_login', array('description' => 'Adds a sidebar login widget to the main site of a WPMU/WPMS install.'));
}
add_action('plugins_loaded', 'widget_wpms_network_login_init');
add_action('wp_head', 'wpms_network_sidebar_login_stylesheet');

// i18n
$plugin_dir = basename(dirname(__FILE__)). '/languages';
load_plugin_textdomain( 'wpms-network-sidebar-login', WP_PLUGIN_DIR.'/'.$plugin_dir, $plugin_dir );
?>