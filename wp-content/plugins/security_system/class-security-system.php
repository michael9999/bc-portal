<?php
/**
 * Plugin Name.
 *
 * @package   security_system
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

/**
 * Plugin class.
 *
 * security_system: Rename this class to a proper name for your plugin.
 *
 * @package security_system
 * @author  Your Name <email@example.com>
 */
use ZendService\LiveDocx\MailMerge; 
class security_system {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'security_system';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
//************************ ATTEMPT TO LOAD LIVEDOCX AT INIT 

//******** Set up Docx constants

/*define( 'LIVEDOCX_VERSION', '3.0.0' );
define( 'LIVEDOCX__MINIMUM_WP_VERSION', '3.0' );
define( 'LIVEDOCX__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LIVEDOCX__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LIVEDOCX__PLUGIN_VENDOR_DIR', LIVEDOCX__PLUGIN_DIR.'vendor'.DIRECTORY_SEPARATOR );
define( 'LIVEDOCX__PLUGIN_DEMOS_DIR',
	LIVEDOCX__PLUGIN_VENDOR_DIR.
	'zendframework'.DIRECTORY_SEPARATOR.
	'zendservice-livedocx'.DIRECTORY_SEPARATOR.
	'demos'.DIRECTORY_SEPARATOR*/


//******** Livedocx account details

/*define( 'LIVEDOCX_DELETE_LIMIT', 100000 );

define( 'LIVEDOCX_FREE_USERNAME', 'evgheni' );
define( 'LIVEDOCX_FREE_PASSWORD', '1234567' );
		
require_once( LIVEDOCX__PLUGIN_VENDOR_DIR . 'autoload.php' );	*/	
		
//********************** END LIVEDOCX

	//	add_action( 'init', array( $this, 'init' ) );
		

// Catch CF7 entries
		
		add_action( 'wpcf7_before_send_mail', array( $this, 'send_to_zd' ) );
		
		
       
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
        



        
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
        
        
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}

	}


// **************my change, function to send certain entries to ZD (maintenance issues, "envoyer responsable")*******************
	
public function send_to_zd($cf7){


// send email if 'Type' is 'Anomalie technique'

if ($cf7->posted_data["menu-797"] == "Anomalie technique"){
    
// send email to ZD textarea-374 menu-924

$message = "Le problème suivant a été constaté par " . $cf7->posted_data["menu-924"]
. " : " . $cf7->posted_data["textarea-374"];

$headers = 'From: Agents de securité <michaelsmuts@gmail.com>' . "\r\n";
wp_mail( 'solutions@foris-scientia.com', 'Anomalie technique', $message, $headers );

$test = "<h2>Your request has been received</h2>";
		return $test;
		die();    

// Prepare data for ZD

// end of if    
}

elseif ($cf7->posted_data["menu-797"] == "Arrivée prestataire"){
    
// send email to ZD textarea-374 menu-924

$message = "Le prestataire suivant vient d'arriver :" . $cf7->posted_data["menu-557"]
 . "\r\n\r\n" . "Details : " . $cf7->posted_data["textarea-374"];

$headers = 'From: Agents de securité <michaelsmuts@gmail.com>' . "\r\n";
wp_mail( 'solutions@foris-scientia.com', 'Arrivée prestataire : ' . $cf7->posted_data["menu-557"], $message, $headers );

$test = "<h2>Your request has been received</h2>";
		return $test;
		die();    

// Prepare data for ZD

// end of if    
}


// IF "Envoyer responsable" send to ZD

elseif ($cf7->posted_data["menu-687"] == "Envoyer responsable" && $cf7->posted_data["menu-797"] != "Arrivée prestataire"
&& $cf7->posted_data["menu-797"] != "Colis arrivée" && $cf7->posted_data["menu-797"] != "Anomalie technique"){
    
// send email to ZD textarea-374 menu-924

$message = $cf7->posted_data["menu-924"] . " souhaite signaler le sujet suivant : " . $cf7->posted_data["menu-797"] ."\r\n\r\n"
. "Date: " . $cf7->posted_data["date-424"] . "\r\n\r\n" . "Time: " . $cf7->posted_data["text-957"] . "\r\n\r\n"
. "Details:  " . $cf7->posted_data["textarea-374"] . "\r\n\r\n" . "Site : " . $cf7->posted_data["menu-881"] ;

//text-957
$headers = 'From: Agents de securité <michaelsmuts@gmail.com>' . "\r\n";
wp_mail( 'solutions@foris-scientia.com', 'Notification sécurité : ' . $cf7->posted_data["menu-797"], $message, $headers );

$test = "<h2>Your request has been received</h2>";
		return $test;
		die();    

// Prepare data for ZD

// end of if    
}






	
	    
}
	
	// end my change	
	
}