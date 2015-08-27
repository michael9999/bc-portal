<?php
/**
 * Plugin Name.
 *
 * @package   facilities_management
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

/**
 * Plugin class.
 *
 * facilities_management: Rename this class to a proper name for your plugin.
 *
 * @package facilities_management
 * @author  Your Name <email@example.com>
 */
class facilities_management {

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
	protected $plugin_slug = 'contacts_providers';

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

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
        add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu2' ) );
        add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu3' ) );
		add_action( 'admin_menu', array( $this, 'add_plugin_contact_base' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action( 'TODO', array( $this, 'action_method_name' ) );
		
		// Display in frontend 
		add_action( 'the_content', array( $this, 'fm_display_front' ) );
		
		add_filter( 'TODO', array( $this, 'filter_method_name' ) );
        
         // Define constant for database nam
        
        define("FM_TEST_TABLE_USER",'users');
        
        define("FM_SERVICE_TABLE",'fm_service_table');
        
        define("FM_DOC_TABLE",'fm_docs_table');
        
        define("FM_PROFESSIONS_TABLE",'fm_professions_table');
        
        
        // AJAX CALL BACKS 
		
		// Get service provider data based on user choice
		
		//add_action('wp_ajax_fm_get_provider', array( $this, 'f_m_get_provider' ));
        
		add_action('wp_ajax_fm_get_provider', array( $this, 'fm_display_provider_improved_ajax' ));
		
        // ENTER name and link, form update in backend
        
        add_action('wp_ajax_fm_update_form', array( $this, 'f_m_update_form' ));

        // EDIT entry form (name and link)
        
        add_action('wp_ajax_f_m_get_edit_form', array( $this, 'f_m_edit_form_show' ));
        
        // UPDATES form (name and link)
        
        add_action('wp_ajax_fm_send_update', array( $this, 'f_m_update_name_form' ));
        
        // DELETE entries
        
        add_action('wp_ajax_fm_send_delete', array( $this, 'f_m_delete_name_form' ));

        // INSERT DATE
        
        add_action('wp_ajax_fm_insert_date', array( $this, 'f_m_insert_date_form' ));
		
		 // DELETE DOC
        
        add_action('wp_ajax_fm_delete_doc', array( $this, 'f_m_delete_doc' ));
		
		 // ADD PROFESSION
        
        add_action('wp_ajax_fm_add_prof', array( $this, 'f_m_add_prof' ));
		
		// DELETE PROFESSION
        
        add_action('wp_ajax_fm_prof_delete', array( $this, 'f_m_prof_delete' ));
		
		// BUILD USER FORM 
        
        add_action('wp_ajax_fm_build_user_add', array( $this, 'f_m_build_user_add' ));
		
		// DISPLAY ALL PROFESSIONS, f_m_show_all_prof
		
		add_action('wp_ajax_fm_show_all_prof', array( $this, 'f_m_show_all_prof' ));
		
		// GET PROVIDERS BY PROFESSION
		
		add_action('wp_ajax_fm_get_provider_profession', array( $this, 'f_m_get_provider_profession' ));
		
       
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
        
        /*$f_m_db = new f_m_create_db ();
        $f_m_db->check_db();*/
        
        // Create database for date test  
       
        /*$f_m_db2 = new f_m_create_db_regs ();
        $f_m_db2->check_db();*/
        
        // Create service provider table
        
        /*$fm_service = new f_m_db_service_providers();
        $fm_service->check_db();*/

// *** ADD SERVICE PROVIDER TABLE 
        
define("FM_SERVICE_TABLE",'fm_service_table');

       global $wpdb;

       $ktr_info_table_name = $wpdb->prefix . FM_SERVICE_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS " . $ktr_info_table_name . " (
                                fm_id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                wp_id BIGINT( 100 ) NOT NULL ,
                                fm_comp_name VARCHAR( 200 ) NOT NULL ,
                                fm_provider VARCHAR( 200 ) NOT NULL ,
                                fm_description VARCHAR( 255 ) NOT NULL ,
                                fm_type VARCHAR( 100 ) NOT NULL ,
                                fm_mobile VARCHAR( 30 ) NOT NULL ,
                                fm_telephone VARCHAR( 30 ) NOT NULL ,
                                fm_address VARCHAR( 30 ) NOT NULL ,
                                fm_vendor_nb VARCHAR( 30 ) NOT NULL ,
                                fm_time_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                ) ENGINE = MYISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);

//***** END SERVICE PROVIDER TABLE

// *** ADD DOCS TABLE TABLE 
        
define("FM_DOC_TABLE",'fm_docs_table');

       //global $wpdb;


       $ktr_info_table_name = $wpdb->prefix . FM_DOC_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS " . $ktr_info_table_name . " (
                                id MEDIUMINT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                wpid INT( 100 ) NOT NULL ,
                                filename VARCHAR( 255 ) NOT NULL ,
                                filedownload VARCHAR( 255 ) NOT NULL ,
                                doc_time_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                ) ENGINE = MYISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);

//***** END ADD DOCS TABLE

     
//***** PROFESSIONS TABLE

define("FM_PROFESSIONS_TABLE",'fm_professions_table');

       //global $wpdb;

/*CREATE TABLE IF NOT EXISTS" . $ktr_info_table_name . "(
  id int(20) NOT NULL AUTO_INCREMENT,
  type varchar(80) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38";*/

       $ktr_info_table_name = $wpdb->prefix . FM_PROFESSIONS_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS " . $ktr_info_table_name . " (
                                id INT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                type VARCHAR( 80 ) NOT NULL
                                ) ENGINE = MYISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);





//***** END PROFESSIONS TABLE

        
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
        
        // remove db on deactivation of plugin
        //$f_m_db_delete = new f_m_create_db ();
        //$f_m_db_delete->f_m_remove_db();
        
        
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

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

//wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		//echo($screen->id . " " . $this->plugin_screen_hook_suffix);
		echo $screen->id . "<br><br>" . $this->plugin_screen_hook_suffix;
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			
        // show form    
        wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
        // edit form
        wp_enqueue_script( $this->plugin_slug . '-form-edit', plugins_url( 'js/edit-form1.js', __FILE__ ), array( 'jquery' ), $this->version );   
        // calendar    
        wp_enqueue_script( $this->plugin_slug . '-fm-calendar', plugins_url( 'js/calendar.js', __FILE__ ), array( 'jquery' ), $this->version );
        // upload trial  
        wp_enqueue_script( $this->plugin_slug . '-fm-upload', plugins_url( 'js/upload.js', __FILE__ ), array( 'jquery' ), $this->version );
    
		}
        
        // add admin-ajax url for use in javascript file
        
        wp_localize_script( $this->plugin_slug . '-admin-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

        

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
		
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		// check that is the right page	
		if ( is_page('Service providers') ) {
			
			wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
		
		
		 // add admin-ajax url for use in javascript file
        
       		wp_localize_script( $this->plugin_slug . '-plugin-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
			
			// add html for this page
			
			//$fm_show_frontend = self::fm_display_front();
			
			//fm_display_front
			
    	}
		
		
	
	
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */
		$this->plugin_screen_hook_suffix = add_plugins_page(
			__( 'Search by service provider', $this->plugin_slug ),
			__( 'Menu Text22', $this->plugin_slug ),
			'read',
			'facilities_management',
			//'facilities_management',
			array( $this, 'display_plugin_admin_page' )
		);

	}
    
    /**
     * Register a second admin page.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu2() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */
		

        $this->plugin_screen_hook_suffix = add_plugins_page(
    		__( 'Calendar trial', 'test' ),
			__( 'Calendar', 'test' ),
			'read',
			'new',
			array( $this, 'display_plugin_admin_page2' )
		);


	}
    
    /**
     * Register a third admin page.
     *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu3() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */	
        
        $this->plugin_screen_hook_suffix = add_plugins_page(
    		__( 'Upload trial', 'test2' ),
			__( 'File upload', 'test2' ),
			'read',
			'facilities_management',
			array( $this, 'display_plugin_admin_page3' )
		);


	}
	
	    /**
     * Register contact database.
     *
	 * @since    1.0.0
	 */
	public function add_plugin_contact_base() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */	
        
        $this->plugin_screen_hook_suffix = add_plugins_page(
    		__( 'Service providers', 'test2' ),
			__( 'Contacts (providers)', 'test2' ),
			'read',
			'contacts_providers',
			array( $this, 'display_plugin_admin_page4' )
		);


	}



	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}
    
    /**
	 * ADD 2ND ADMIN MENU PAGE
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page2() {
		include_once( 'views/admin2.php' );
	}
    
     /**
     * ADD 3rd ADMIN MENU PAGE
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page3() {
		include_once( 'views/admin3.php' );
	}
	
	
	public function display_plugin_admin_page4() {
		include_once( 'views/fm_contacts.php' );
	}
	
    
    

	/**
	 * NOTE:  Actions are points in the execution of a page or process 
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	
	// Display data in frontend
	
	public function fm_display_front() {
		
		
			if ( is_page('Service providers') ) {
		
			include_once( 'views/public.php' );
			//$toppic = 'page1.png';
			
			} else{
return $content;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}
    
    /**
     * FORM: INSERTS NEW ENTRY, this is an example
	 *
	 * @since     1.0.0
	 *
	 * @return    .
	 */
    
    public function f_m_update_form(){
        
        //include ("f_m_update_form.php");
        
        
        // Example unseriallise data

        $unserializedData = $_POST;

        //parse_str($serializedData,$unserializedData);

        //print_r($unserializedData);
        
        //echo "<br>";
        
        //echo "echo individual values" . $unserializedData["name"] . " " . $unserializedData["email"]; 
        
        //echo "<br>";
        
        //TO DO: sanitize


        // put values into array
        
        $fm_input = array($unserializedData["name"], $unserializedData["email"]);

        // add to database
      
        global $wpdb;
        //$translator_id = $lang->default_translator;
        
		$table_assign_fm=$wpdb->prefix.FM_TEST_TABLE;
        $date='';
      
        $sql = $wpdb->prepare(
                "INSERT INTO $table_assign_fm (
                        fm_name,
                        fm_email
                ) VALUES (
                   %s,
                   %s
                   )"
                , $unserializedData['name'], $unserializedData['email']);
         $result = $wpdb->query( $sql );
         
         
         // Show results
        
        //$fm_show_result_trial = fm_show_results();
        
        $fm_show_result_trial = self::fm_show_results();
        echo "here are the results " . $fm_show_result_trial; 
        
    
    }
	
	
	/**
     * GET SERVICE PROVIDERS
	 *
	 * @since     1.0.0
	 *
	 * @return    .
	 */
    
    public function f_m_get_provider(){
        
        
        // Example unseriallise data

        $unserializedData = $_POST;

		// set table name 
	
		
		// get id of service provider
		
		$user_var = $unserializedData["fm_id"];
		
		global $wpdb;
		
		$provider_table = $wpdb->prefix . FM_SERVICE_TABLE;
		
		$user_table = "wp_users";
		
		
        $table = $provider_table;
			
        $sql = $wpdb->prepare( "SELECT * FROM $table INNER JOIN $user_table ON wp_id = ID AND `wp_id` = $user_var", '' );
        $results = $wpdb->get_results($sql);
    
    
		if(is_array($results)):
		$i=0;
		
		$fm_present_results = "<table name='trs_type' class='widefat'> <thead>
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
								<tr><td></td><td value=''><form method='post' action='michael' name='edit'><input type='hidden' name='edit' value='". $val->ID  ."'/><input type='submit' id='Edit' name='Edit' value='EDIT' /></form>
								
								<form method='post' name='del'><input type='hidden' name='del' value='".$val->ID  ."'/><input type='submit' name='Del' value='DELETE' /></form></td></tr>";
            
		
			$i++;
        endforeach;
        $fm_present_results .= "</tbody></table>";
		echo $fm_present_results;
    	endif;
      
		// start

		// end 
		

    
    }
	
	
	/**
     * GET SERVICE PROVIDERS
	 *
	 * @since     1.0.0
	 *
	 * @return    .
	 */
    
    public function f_m_edit_provider($fm_wp_unique){
        
		// GET ALL PROFESSION TYPES FROM DB	
		
		// Get options for profession type	
		
		global $wpdb;
		
        $table = $wpdb->prefix . FM_PROFESSIONS_TABLE;
        $sql1 = $wpdb->prepare( "SELECT * FROM $table  ORDER BY type asc", '' );
        $results1 = $wpdb->get_results($sql1);
    
   
    
		if(is_array($results1)){
        $i=0;
        $fm_present_results1 = "<option value=''></option>";
        foreach($results1 as $val1):
            $i;
        
		// remove edit button 
		
		// $fm_present_results .= "<tr><td value=''>" .$val->type . "</td><td><a href='".$val->id ."' id='f_m_prof_edit'>edit</a></td><td><a href='".$val->id ."' id='f_m_prof_delete'>delete</a></td></tr>";
          
		$fm_present_results1 .= "<option value='" .$val1->type . "'>" .$val1->type . "</option>";
          
		
		$i++;
        endforeach;
		
		}
		
		
		
		
		
		// END, GET ALL PROFESSION TYPES
        
		
		
		
		
        // GET PROVIDER ID

        $unserializedData = $_POST;

		// set table name 
		
		
		
		// get id of service provider
		
		$this->user_var = $fm_wp_unique;
		
		//echo "is this the right number " . $this->user_var;
		
		
		global $wpdb;
		
		$provider_table = $wpdb->prefix . FM_SERVICE_TABLE;
		$user_table = "wp_users";
		
		
        $table = $provider_table;
			
		$sql = $wpdb->prepare( "SELECT * FROM $user_table INNER JOIN $provider_table ON ID = wp_id  AND ID = $this->user_var", '' );
        
        
		$results = $wpdb->get_results($sql);
    
    
		if(is_array($results)):
		$i=0;
		
		$fm_present_results = "<table name='trs_type' class='widefat'> <thead>
    	<tr></tr></thead>";
		 foreach($results as $val):
            $i;
        
            
		$fm_present_results .= "<form class='validate' id='fm_createuser' name='fm_createuser' method='post' enctype='multipart/form-data' action=''>
<table class='form-table'>

	<tbody><tr class='form-field form-required'>
		<th scope='row'><label for='user_login'>Username <span class='description'>(required)</span></label></th>
		<td><input type='text' aria-required='true' value='".$val->user_login ."' id='user_login' name='user_login'>
		<input type='hidden' value='".$val->ID ."' class='code' id='fm_update' name='fm_update'></td>
	</tr>
	
	
	<tr class='form-field form-required'>
		<th scope='row'><label for='email'>E-mail <span class='description'>(required)</span></label></th>
		<td><input type='text' value='".$val->user_email ."' id='email' name='email' required></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='nicename'>Contact name </label></th>
		<td><input type='text' value='".$val->user_nicename ."' id='nicename' name='nicename' ></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='url'>Website</label></th>
		<td><input type='text' value='".$val->user_url ."' class='code' id='url' name='url'></td>
	</tr>
					

<tr>
<th>
<label for='fac_comp_name'>Company name</label></th>
<td>
<input type='text' value='".$val->fm_comp_name ."' class='regular-text' id='fac_comp_name' name='fac_comp_name'>	 					
<br>
	<span class='description'>Name of provider</span>
</td>
</tr>		
		
<!-- end -->

		<tr>
			<th>
				<label for='fac_user_type'>
				Service provider?				</label>
			</th>
			<td>
				
				
				<select id='fac_user_type' name='fac_user_type' type='text'>
				<option class='regular-text' value='" .$val->fm_provider ."'>
				" .$val->fm_provider ."</option>
				<option value='yes'>Yes</option>
  				<option value='no'>No</option>	
					
				</select> 
					
			
			
			</td>
		</tr>

<!-- Type of provider -->
		
	<tr>
			<th>
				<label for='fac_provider_profession'>
				Profession			</label>
			</th>
			<td>
				
				
				<select id='fac_provider_profession3' name='fac_provider_profession3' type='text'>
				<option class='regular-text' value='" . $val->fm_type ."'>
				" . $val->fm_type ."</option>" .  $fm_present_results1 . " 	
				</select> 
			
			
			
			
			
			</td>
		</tr>	
		
		
		
		<tr>
<th>
<label for='fac_service_description'>Description of services</label></th>
<td>
<textarea class='regular-text' id='fac_service_description' name='fac_service_description'>" .$val->fm_description ."</textarea><br>
<span class='description'>Please enter a description of the services provided by this company</span>
</td>
</tr><!-- field ends here -->
		
<!-- telephone -->			

<tr>
<th>
<label for='fac_telephone'>Telephone number</label></th>
<td>
<input type='text' value='" . $val->fm_telephone ."' class='regular-text' id='fac_telephone' name='fac_telephone'>
<br>
<span class='description'>Please add a telephone number</span>
</td>
</tr>		
		
<!-- mobile nb -->			

<tr>
<th>
<label for='fac_mobile'>Mobile number</label></th>
<td>
<input type='text' value='" . $val->fm_mobile ."' class='regular-text' id='fac_mobile' name='fac_mobile'>
<br>
<span class='description'>mobile telephone number</span>
</td>
</tr>		

<!-- address -->		
		
		<tr>
<th>
<label for='fac_address'>Address</label></th>
<td>
<textarea class='regular-text' id='fac_address' name='fac_address'>" . $val->fm_address . "</textarea><br>
	<span class='description'>Please enter an address</span>
</td>
</tr>
	
		
		<tr>

<th><label for='file'>Filename</label></th>
<td>					
<input id='filename' name='filename' minlength='2' type='text' />	
</td>		
		
</tr>
<tr>		
<th><label for='fac_contract'>Contract</label></th>
<td>
<input type='file' name='files[]' multiple  />
<!--<input type='file' required='' multiple='' name='uploadedfile'>	-->
<br>
	<span class='fac_contract'>Upload scan of contract</span>
</td>
</tr>		
		
		
	</tbody></table>

<p class='submit'><input type='submit' value='Update' class='button button-primary' id='sub' name='createuser'></p>
</form>
";
            
		
			$i++;
        endforeach;
        $fm_present_results .= "</tbody></table>";
		echo $fm_present_results;
    	endif;
      
		// start

		// end 
		

    
    }
	
    
    // GETS ALL ENTRIES FROM TEST TABLE AND DISPLAYS IN TABLE
    
    public function fm_show_results(){
        
        global $wpdb;
        $table = $wpdb->prefix . FM_TEST_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY fm_id asc", '' );
        $results = $wpdb->get_results($sql);
    
    //print_r ($results);
    
    if(is_array($results)):
        $i=0;
        $fm_present_results = "<table name='trs_type' id='trs_type'><tr><td></td></tr>";
        foreach($results as $val):
            $i;
        
            $fm_present_results .= "<tr><td value='".$val->fm_name ."'>" .$val->fm_name . "</td><td value='".$val->fm_email ."'>".$val->fm_email ."</td>
            <td value='".$val->fm_id ."'><td><a href='".$val->fm_id ."' id='f_m_edit'>edit</a></td><td><a href='".$val->fm_id ."' id='delete'>delete</a></td></tr>";
            $i++;
        endforeach;
        $fm_present_results .= "</table>";
        return $fm_present_results;
    endif;
        
        
    }
	
	
	/**
	* GET ALL USERS TAGGED AS SERVICE PROVIDERS
	
	*/
	
	public function fm_show_results_service_providers(){
        
        global $wpdb;
        
		$new_test = $wpdb->prefix . FM_SERVICE_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $new_test INNER JOIN wp_users ON wp_id = ID AND fm_provider = 'yes'", '' );
        $results = $wpdb->get_results($sql);
		
		return $results;
    
        
        
    }
	
	
    
    /**
     * SHOW EDIT FORM FOR NAME AND EMAIL
     *
	 * @since     1.0.0
	 *
	 * @return    .
	 */
    
    public function f_m_edit_form_show(){
        
        //include ("f_m_update_form.php");
        
        
        // Example unseriallise data

        $unserializedData = $_POST;

        
        //TO DO: sanitize


        // put values into array fm_edit_id
        
        //$fm_input = array($unserializedData["name"], $unserializedData["email"]);

        $f_m_name_form_id = $_POST['fm_edit_id'];
        
        $to="michaelsmuts@gmail.com";
        $subject="TEST from inside PHP";
        $message="hello, here is my variable " . $f_m_name_form_id;
        
        
        //wp_mail( $to, $subject, $message);

        // add to database
        //SELECT ktr_order_id FROM $table WHERE ktr_id='".$insert_id ."' ORDER BY ktr_id desc", '' 
        //SELECT * FROM $table  WHERE ktr_laguage_id  = %d", $_REQUEST['language_drp']
        
        global $wpdb;
        $table = $wpdb->prefix . FM_TEST_TABLE;
        //$sql = $wpdb->prepare( "SELECT * FROM $table WHERE fm_id='". $f_m_name_form_id ."'", '' );
        
        $sql = $wpdb->prepare( "SELECT * FROM $table WHERE fm_id = %s", $_POST['fm_edit_id']);
        $results = $wpdb->get_results($sql);
        //$wpdb->print_error();
        
        //print_r($results); 
        //echo $results[0]->fm_id . $results[0]->fm_name . $results[0]->fm_email; 
      
      
        $fm_present_results = "<form id='f_m_name_edit' class='michael1'>";
        
        $fm_present_results .= "<input id='f_m_name_email_edit' name='f_m_name_email_edit' type='text' value='".$results[0]->fm_name ."' required>";
        $fm_present_results .= "<input id='f_m_email_edit' name='f_m_email_edit' type='email' value='".$results[0]->fm_email."' required>";
        $fm_present_results .= "<input class='submit' height='".$results[0]->fm_id."' type='submit' value='Submit' id='editupdatename'/>";
        
        $fm_present_results .= "</form>";
        
        echo $fm_present_results;
        
        
        
    
    }
    
    /**
     * UPDATE NAME AND EMAIL 
     *
     * @since     1.0.0
	 *
	 * @return    .
	 */
    
    public function f_m_update_name_form(){
        
        //print_r($_POST);
        //$_POST 
        $name_form_rec = $_POST;
        $to="michaelsmuts@gmail.com";
        $subject="TEST from inside PHP";
        $message="hello, here is my variable " . $name_form_rec['f_m_name_email_edit'] . $name_form_rec['f_m_email_edit'] . " " . $name_form_rec['update_id_fm'];
        //update_id_fm, update_id_fm
        wp_mail( $to, $subject, $message);
        
        global $wpdb;
        
        
        $table = $wpdb->prefix . FM_TEST_TABLE;
        $wpdb->update( $table, array( 'fm_name' => $name_form_rec['f_m_name_email_edit'], 'fm_email' => $name_form_rec['f_m_email_edit']), array( "fm_id" => $name_form_rec['update_id_fm']));

          
        //exit( var_dump( $wpdb->last_query ) );  
          
        //$wpdb->show_errors();
        $fm_show_result_trial = self::fm_show_results();
        echo "here are the results " . $fm_show_result_trial;

    }
	
	 /**
     * UPDATE SERVICE PROVIDER
     *
     * @since     1.0.0
	 *
	 * @return   
	 
	 Update Service provider in WP user and service provider databases
	 
	 .
	 */
    
    public function f_m_update_service_provider($fm_post_array){

		
// UPDATE WP USER DATABASE	

global $wpdb;
        
        
$table = $wpdb->prefix . FM_TEST_TABLE_USER;
$wpdb->update( $table, array( 'user_login' => $fm_post_array['user_login'], 'user_email' => $fm_post_array['email'], 'user_nicename' => $fm_post_array['nicename'], 'user_url' => $fm_post_array['url']), array( "ID" => $fm_post_array['fm_update']));

		
// END UPDATE WP USERS

// UPDATE SERVICE PROVIDER FIELDS

$table = $wpdb->prefix . FM_SERVICE_TABLE;
$wpdb->update( $table, array( 'fm_comp_name' => $fm_post_array['fac_comp_name'], 'fm_provider' => $fm_post_array['fac_user_type'], 'fm_type' => $fm_post_array['fac_provider_profession3'], 'fm_description' => $fm_post_array['fac_service_description'], 'fm_telephone' => $fm_post_array['fac_telephone'], 'fm_mobile' => $fm_post_array['fac_mobile'], 'fm_address' => $fm_post_array['fac_address']), array( "wp_id" => $fm_post_array['fm_update']));
		
		
// END UPDATE SERVICE PROVIDER FIELDS		
		
	
	// IF NEW FILE WAS ADDED, UPLOAD IT	
		
		//if(isset($_FILES['files']) ){
		if(!empty($fm_post_array['filename']) ){	
				// START UPLOADED FILES
			
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
								
						  
				// END UPLOADED FILES 	
				
				
			
				
				// GET CORRECT NAME FOR DIRECTORY
			
				$yourtablename = $wpdb->prefix . FM_DOC_TABLE;
		
				
				$new_fm_test = wp_upload_dir();
				
					//echo "this is the filename " . $file_name;
			
				$file_name = ltrim($file_name, '0');
				
					//echo "this is the NEW filename " . $file_name;
				
				$desired_dir = $new_fm_test['basedir'];
			
			
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
		
       
			}
			
			// CHECK FOR ERRORS
			
			if(empty($error)){
		
					
					global $wpdb;			
					$new_fm_test = wp_upload_dir();
				//echo "Success";
				//echo $_SERVER['DOCUMENT_ROOT'];
					//$new_fm_test = get_home_path();
				//echo " is this working" . $new_fm_test['basedir'];
					
				//echo "<a href=" . $new_fm_test['baseurl'] . "/" . $file_name . ">Show file</a>";
					
					// ADD TO DATABASE	
			
					// build file download uri
					$fm_download_link = $new_fm_test['baseurl'] . "/" . $file_name;
					
					$yourtablename = $wpdb->prefix . FM_DOC_TABLE;
					
					$wpdb->insert($yourtablename , array('wpid' => $fm_post_array['fm_update'],
					'filename' => $file_name,'filedownload'=>$fm_download_link));
				
				
				
				//f_m_get_provider
				// fm_display_provider_improved
				
			
			}
			

		} // END FILE EDIT

		// DISPLAY UDATED SERVICE PROVIDER	
					
				$this->get_provider_details = self::fm_display_provider_improved($fm_post_array['fm_update']);
				
				echo $this->get_provider_details;
			
		
	
	}
	
	
	
    
     /**
     * DELETE NAME AND EMAIL
     *
     * @since     1.0.0
     *
	 * @return    .
	 */
    
    public function f_m_delete_name_form(){
        
        //print_r($_POST);
        
        $name_form_rec = $_POST;
        
        global $wpdb;
        
        
        $table = $wpdb->prefix . FM_TEST_TABLE;
        //$wpdb->update( $table, array( 'fm_name' => $name_form_rec['f_m_name_email_edit'], 'fm_email' => $name_form_rec['f_m_email_edit']), array( "fm_id" => $name_form_rec['update_id_fm']));
        $wpdb->delete( $table, array( "fm_id" => $name_form_rec['delete_id_fm'] ) );
          
        //exit( var_dump( $wpdb->last_query ) );  
          
        //$wpdb->show_errors();
        
        $fm_show_result_trial = self::fm_show_results();
        echo "here are the results " . $fm_show_result_trial;

    }
    
     /**
     * INSERT DATE AND TITLE INTO DATABASE
     *
     * @since     1.0.0
     *
     * @return    .
	 */
    
    public function f_m_insert_date_form(){
        
        //print_r($_POST);
        //$_POST 
        $name_form_rec = $_POST;
        $to="michaelsmuts@gmail.com";
        $subject="TEST from inside PHP";
        $message="hello, here is my variable " . $name_form_rec['datepicker'] . $name_form_rec['fm_title'] . " " . $name_form_rec['update_id_fm'];
        //update_id_fm, update_id_fm
        wp_mail( $to, $subject, $message);
        
        $unserializedData = $_POST;

        // put values into array
        
        $fm_input = array($unserializedData["datepicker"], $unserializedData["fm_title"]);

        // add to database
      
        global $wpdb;
        //$translator_id = $lang->default_translator;
        
    	$table_assign_fm=$wpdb->prefix.FM_TEST_TABLE_REGS;
        //$date='';
        
        // $current_date = date("Y-m-d H:i:s");
      
        //$current_date = date("Y-m-d H:i:s");  
        // echo date('Y m d',strtotime($mysqldate));
        //$date = DateTime::createFromFormat('Y-m-d', '2009-08-12');
        //$output = $date->format('F j, Y');
        //Y-m-d
        
        //$date = DateTime::createFromFormat('Y-m-d', $unserializedData['datepicker']);
        //$date = "2012-08-06";
        $date = date("Y-m-d",strtotime($unserializedData['datepicker']));
        
        //$date = $unserializedData['datepicker'];
        
        //$output = $date->format('Y-m-d');
        
        $name_form_rec = $_POST;
        $to="michaelsmuts@gmail.com";
        $subject="TEST from inside PHP";
        $message="hello, reformatted date: " . $date;
        //update_id_fm, update_id_fm
        wp_mail( $to, $subject, $message);
               
      
        $sql = $wpdb->prepare(
                "INSERT INTO $table_assign_fm (
                        fm_date,
                        fm_title
                ) VALUES (
                   %s,
                   %s
                   )"
                , $date, $unserializedData['fm_title']);
         $result = $wpdb->query( $sql );
         
        // display all entries
        
        $fm_show_result_calendar = self::fm_show_results_calendar();
        echo "here are the results " . $fm_show_result_calendar;
        
        //exit( var_dump( $wpdb->last_query ) );  

    }
    
    // DISPLAY ALL DATA FROM DATE/CALENDAR TEST TABLE
    
    public function fm_show_results_calendar(){
        
        global $wpdb;
        $table = $wpdb->prefix . FM_TEST_TABLE_REGS;
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY fm_id asc", '' );
        $results = $wpdb->get_results($sql);
    
    //print_r ($results);
    
    if(is_array($results)):
        $i=0;
        $fm_present_results = "<table name='trs_type' id='trs_type'><tr><td></td></tr>";
        foreach($results as $val):
            $i;
            
            // reformat date
            $date = date("d/m/Y",strtotime($val->fm_date));
            $fm_present_results .= "<tr><td value='".$val->fm_title ."'>" .$val->fm_title . "</td><td value='".$val->fm_date ."'>" . $date . "</td>
            <td value='".$val->fm_id ."'><td><a href='".$val->fm_id ."' id='f_m_edit'>edit</a></td><td><a href='".$val->fm_id ."' id='delete'>delete</a></td></tr>";
            $i++;
        endforeach;
        $fm_present_results .= "</table>";
        return $fm_present_results;
    endif;
        
        
    }
	
	/**
	*
	
	-------------------------------------------------EVERYTHING BELOW HERE IS NEW ---------------------------------------
	
	
	
	*
	**/

	
	// GET ALL SERVICE PROVIDER INFO AND DISPLAY IT (contact + docs)
	
	// NON AJAX VERSION
	
	public function fm_display_provider_improved($wp_id_new){
		
		$this->wp_id_new = $wp_id_new;
		
		//echo "this is WP id from inside fm_display_provider_improved " . $this->wp_id_new; 
		
		
		
		$user_table = "wp_users";
		
		
		// get id of service provider
		
		// Show user that has just been added
		
		global $wpdb;
		
		
		$fm_doc_table = $wpdb->prefix . FM_DOC_TABLE;
		
		$provider_table = $wpdb->prefix . FM_SERVICE_TABLE;
		
        $table = $provider_table;
			
		//$sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID INNER JOIN $fm_doc_table ON wp_id = wpid AND wp_id = $this->wp_id_new", '' );
        
		$sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID AND wp_id = $this->wp_id_new", '' );
        
		
		$results = $wpdb->get_results($sql);
    	
    
		if(is_array($results)){
		$i=0;
		
		$fm_present_results = "<table name='trs_type' class='widefat'> <thead>
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
								<tr><td class='fm_title'>ACTIONS</td><td><form method='post' name='edit' action=''><input type='hidden' name='edit' value='".$val->ID ."'/><input type='submit' id='Edit' name='Edit' value='EDIT' /></form>
								
								<form method='post' name='del'><input type='hidden' name='del' value='".$val->ID ."'/><input type='submit' name='Del' value='DELETE' /></form></td></tr>
								<tr><td class='fm_title'>Contract documents</td><td></td></tr>
								";
            
		
			$i++;	
        endforeach;
		
		}
		
		
		// last
		
		
		// get docs
		
		
		$sql2 = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $fm_doc_table ON wp_id = wpid AND wp_id = $this->wp_id_new", '' );
        $results2 = $wpdb->get_results($sql2);
    	
    
		if(is_array($results2)){
		$i=0;
		
		
		 foreach($results2 as $val2):
            $i;
        
            
		$fm_present_results .= "<tr><td value=''><a href='".$val2->filedownload ."' target='_blank'>". $val2->filename ."</a></td><td><form method='post' name='del'><input type='submit' class='". $val2->id ."' name='del' value='Delete' id='fm_delete_doc'/></form>
								</td></tr>";
            
		
			$i++;	
        endforeach;
		
		
		
		
        $fm_present_results .= "</tbody></table>";
		echo $fm_present_results;
		
		}
		

		
		
		
		
			
				
		// end last
		
	
	}
	
	
	
// GET ALL SERVICE PROVIDER INFO AND DISPLAY IT (contact + docs)
	
// AJAX VERSION	
	
	
	
public function fm_display_provider_improved_ajax(){
	
	
		$unserializedData = $_POST;
		
		$this->wp_id_new = $unserializedData["fm_id"];
		
		//echo "this is WP id from inside fm_display_provider_improved " . $this->wp_id_new; 
		
		
		
		$user_table = "wp_users";
		
		
		// get id of service provider
		
		// Show user that has just been added
		
		global $wpdb;
		
		$provider_table = $wpdb->prefix . FM_SERVICE_TABLE;
		
	//echo FM_SERVICE_TABLE;
		
	//	echo FM_TEST_TABLE_USER;
		
		$fm_doc_table = $wpdb->prefix . FM_DOC_TABLE;
		
        $table = $provider_table;
			
		//$sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID INNER JOIN $fm_doc_table ON wp_id = wpid AND wp_id = $this->wp_id_new", '' );
        
		$sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID AND wp_id = $this->wp_id_new", '' );
        
		
		$results = $wpdb->get_results($sql);
    	
    
		if(is_array($results)){
		$i=0;
		
		$fm_present_results = "<table name='trs_type' class='widefat'> <thead>
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
								<tr><td></td><td><form method='post' name='edit'><input type='hidden' id='edit_prov_id' name='edit' value='".$val->ID ."'/><input type='submit' id='Edit' name='Edit' value='EDIT' /></form>
								
								<form method='post' name='del'><input type='hidden' name='del' value='".$val->ID ."'/><input type='submit' name='Del' value='DELETE' /></form></td></tr>
								<tr><td class='fm_title'>Contract documents</td><td></td></tr>
								";
            
		
			$i++;	
        endforeach;
		
		}
		
		
		// last
		
		
		// get docs
		
		
		$sql2 = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $fm_doc_table ON wp_id = wpid AND wp_id = $this->wp_id_new", '' );
        $results2 = $wpdb->get_results($sql2);
    	
    
		if(is_array($results2)){
		$i=0;
		
		
		 foreach($results2 as $val2):
            $i;
        
            
		$fm_present_results .= "<tr><td value=''><a href='".$val2->filedownload ."' target='_blank'>". $val2->filename ."</a></td><td><form method='post' name='del'><input type='submit' class='". $val2->id ."' name='del' value='Delete' id='fm_delete_doc'/></form>
								</td></tr>";
            
		
			$i++;	
        endforeach;
		
		
		
		
        $fm_present_results .= "</tbody></table>";
		echo $fm_present_results;
		
		}
		

		
		
		
		
			
				
		// end last
		
	
	}	
	
	// DELETE DOC FROM CONTRACTS DB
	
	public function f_m_delete_doc(){
	
	global $wpdb;
	
	$table_delete = $wpdb->prefix . FM_DOC_TABLE;
	
	$wpdb->delete( $table_delete, array( 'id' => $_POST['doc_id']));	
		
		//self::fm_show_results_calendar(); fm_current_id
	
	$this->get_provider_details = self::fm_display_provider_improved($_POST['prov_id']);
	
	echo $this->get_provider_details;	
	
	
	}
	
	
	// ADD PROFESSION
	
	
	public function f_m_add_prof(){
	
	 $unserializedData = $_POST;

     
      
        global $wpdb;
        
        
		$table_assign_fm = $wpdb->prefix . FM_PROFESSIONS_TABLE;
		//$date='';
      
        $sql = $wpdb->prepare(
                "INSERT INTO $table_assign_fm (
                        type
                ) VALUES (
                   %s
                   )"
                , $unserializedData['prof_name']);
         $result = $wpdb->query( $sql );
         //$error = var_dump($result);
        //echo $error;
			$this->fm_show_prof = self::f_m_get_profession();
		
	
			echo $this->fm_show_prof;	
	
	
	}
	
	
	// SHOW ALL PROFESSIONS
	
	
	public function f_m_show_all_prof(){
	
	 $unserializedData = $_POST;

     

         
        
			$this->fm_show_all_prof = self::f_m_get_profession();
		
	
			echo $this->fm_show_all_prof;	
	
	
	}
	
	
	
	// SHOW ALL AVAILABLE PROFESSIONS
	
	
	public function f_m_get_profession(){
	
	 
		global $wpdb;
        $table = $wpdb->prefix . FM_PROFESSIONS_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY type asc", '' );
        $results = $wpdb->get_results($sql);
    
    //print_r ($results);
    
    if(is_array($results)):
        $i=0;
        $fm_present_results = "<table name='fm_prof_table' id='fm_prof_table'>";
        foreach($results as $val):
            $i;
        
		// remove edit button 
		
		// $fm_present_results .= "<tr><td value=''>" .$val->type . "</td><td><a href='".$val->id ."' id='f_m_prof_edit'>edit</a></td><td><a href='".$val->id ."' id='f_m_prof_delete'>delete</a></td></tr>";
          
		$fm_present_results .= "<tr><td value=''>" .$val->type . "</td><td><a href='".$val->id ."' id='f_m_prof_delete'>Delete</a></td></tr>";
          
		
		$i++;
        endforeach;
        $fm_present_results .= "</table>";
        return $fm_present_results;
    endif;
	
	
	}
	
	
	
	// DELETE PROFESSION
	
	
	public function f_m_prof_delete(){
	
	 
		// $wpdb->delete( $table, array( "fm_id" => $name_form_rec['delete_id_fm'] ) );
		
		//$unserializedData = $_POST;
		
		$this->unserializedData = $_POST;
		
		//echo "this is the variable " . $this->unserializedData['prof_del_id'];
		
		global $wpdb;
		
        $table = $wpdb->prefix . FM_PROFESSIONS_TABLE;
		
		$wpdb->delete( $table, array( "id" => $this->unserializedData['prof_del_id'] ) );
		
    	$this->get_fm_profession = self::f_m_get_profession();
    
		echo $this->get_fm_profession;
	
	}
	
	
	// END DELETE PROFESSION
	

	// BUILD HTML FORM FOR USER ADD
	
	
	public function f_m_build_user_add(){
	
	
	// Get options for profession type	
		
		global $wpdb;
        $table = $wpdb->prefix . FM_PROFESSIONS_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $table  ORDER BY type asc", '' );
        $results = $wpdb->get_results($sql);
    
   
    
		if(is_array($results)){
        $i=0;
        $fm_present_results = "<option value=''></option>";
        foreach($results as $val):
            $i;
        
		// remove edit button 
		
		// $fm_present_results .= "<tr><td value=''>" .$val->type . "</td><td><a href='".$val->id ."' id='f_m_prof_edit'>edit</a></td><td><a href='".$val->id ."' id='f_m_prof_delete'>delete</a></td></tr>";
          
		$fm_present_results .= "<option value='" .$val->type . "'>" .$val->type . "</option>";
          
		
		$i++;
        endforeach;
		//$fm_present_results .= "</table>";
		//echo $fm_present_results;
		}
		
		
// BUILD FORM
		
		
	$this->fm_prov_user_form ="<form class='validate' id='fm_createuser' name='fm_createuser' method='post' enctype='multipart/form-data' action=''>
<table class='form-table'>
	<tbody><tr class='form-field form-required'>
		<th scope='row'><label for='user_login'>Username <span class='description'>(required)</span></label></th>
		<td><input type='text' aria-required='true' value='' id='user_login' name='user_login'>
		<input type='hidden' value='fm_add' class='code' id='fm_add' name='fm_add'></td>
	</tr>
	<!--<tr class='form-field'>
		
		
	</tr>-->	
	<tr class='form-field form-required'>
		<th scope='row'><label for='email'>E-mail <span class='description'>(required)</span></label></th>
		<td><input type='text' value='' id='email' name='email' required></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='first_name'>First Name </label></th>
		<td><input type='text' value='' id='first_name' name='first_name' ></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='last_name'>Last Name </label></th>
		<td><input type='text' value='' id='last_name' name='last_name' ></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='url'>Website</label></th>
		<td><input type='text' value='' class='code' id='url' name='url'></td>
	</tr>
<tr>
<th>
<label for='fac_comp_name'>Company name</label></th>
<td>
<input type='text' value='' class='regular-text' id='fac_comp_name' name='fac_comp_name'>	 					
<br>
	<span class='description'>Name of provider</span>
</td>
</tr>		
		
<!-- end -->

		<tr>
			<th>
				<label for='fac_user_type'>
				Service provider?				</label>
			</th>
			<td>
				
				
				<select id='fac_user_type' name='fac_user_type' type='text'>
				<option class='regular-text' value=''>
				</option>
				<option value='yes'>Yes</option>
  				<option value='no'>No</option>	
					
				</select> 
					
			
			
			</td>
		</tr>

<!-- Type of provider -->
		
	<tr>
			<th>
				<label for='fac_provider_profession'>
				Profession			</label>
			</th>
			<td>
				
				
				<select id='fac_provider_profession2' name='fac_provider_profession2' type='text'>" . $fm_present_results . "</select> 
			
			
			
			
			
			</td>
		</tr>	
		
<!-- company description -->		
		
		<tr>
<th>
<label for='fac_service_description'>Description of services</label></th>
<td>
<textarea class='regular-text' id='fac_service_description' name='fac_service_description'></textarea><br>
<span class='description'>Please enter a description of the services provided by this company</span>
</td>
</tr><!-- field ends here -->
		
<!-- telephone -->			

<tr>
<th>
<label for='fac_telephone'>Telephone number</label></th>
<td>
<input type='text' value='' class='regular-text' id='fac_telephone' name='fac_telephone'>
<br>
<span class='description'>Please add a telephone number</span>
</td>
</tr>		
		
<!-- mobile nb -->			

<tr>
<th>
<label for='fac_mobile'>Mobile number</label></th>
<td>
<input type='text' value='' class='regular-text' id='fac_mobile' name='fac_mobile'>
<br>
<span class='description'>mobile telephone number</span>
</td>
</tr>		

<!-- address -->		
		
		<tr>
<th>
<label for='fac_address'>Address</label></th>
<td>
<textarea class='regular-text' id='fac_address' name='fac_address'></textarea><br>
	<span class='description'>Please enter an address</span>
</td>
</tr>

	<!-- contract -->		
		
		<tr>

<th><label for='file'>Filename</label></th>
<td>					
<input id='cname' name='filename' minlength='2' type='text' required />	
</td>		
		
</tr>
<tr>		
<th><label for='fac_contract'>Contract</label></th>
<td>
<input type='file' name='files[]' multiple required />
<!--<input type='file' required='' multiple='' name='uploadedfile'>	-->
<br>
	<span class='fac_contract'>Upload scan of contract</span>
</td>
</tr>		
		
		
	</tbody></table>

<p class='submit'><input type='submit' value='Add New User ' class='button button-primary' id='sub' name='createuser'></p>
</form>";	
		
		
	echo $this->fm_prov_user_form;	
		
	
	}
	
	
	// END, BUILD HTML FORM FOR USER ADD
	

public function f_m_get_provider_profession(){
	
	
		$unserializedData = $_POST;
		
		$this->prof_id = $unserializedData["prof_id_gen"];
		
		//echo "this is WP id from inside fm_display_provider_improved " . $this->wp_id_new; 
		
		
		
		$user_table = "wp_users";
		
		
		// get id of service provider
		
		// Show user that has just been added
		
		global $wpdb;
		
		$provider_table = $wpdb->prefix . FM_SERVICE_TABLE;
		
		$fm_doc_table = $wpdb->prefix . FM_DOC_TABLE;
		
        $table = $provider_table;
			
		//$sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID INNER JOIN $fm_doc_table ON wp_id = wpid AND wp_id = $this->wp_id_new", '' );
        
		$sql = $wpdb->prepare( "SELECT * FROM $provider_table INNER JOIN $user_table ON wp_id = ID WHERE fm_type = %s", $this->prof_id);
        
		
		$results = $wpdb->get_results($sql);
    	
    
		if(is_array($results)){
		$i=0;
		
		$fm_present_results = "<table name='trs_type' class='widefat'> <thead>
    	<tr><td class='fm_title'>Name</td><td class='fm_title'>Contact</td><td class='fm_title'>Type</td><td class='fm_title'>Email</td><td class='fm_title'>Tel</td><td class='fm_title'>Mob</td><td class='fm_title'>Address</td><td class='fm_title'>Description</td><td class='fm_title'>Action</td></tr></thead>";
		
		
		foreach($results as $val):
            $i;
        
            
		$fm_present_results .= "<tbody><tr><td value='".$val->fm_comp_name ."'>" .$val->fm_comp_name . "</td>
								<td value='".$val->display_name ."'>".$val->display_name ."</td>
								<td value='".$val->fm_type ."'>".$val->fm_type ."</td>
								<td value='".$val->user_email ."'>".$val->user_email ."</td>
								<td value='".$val->fm_telephone ."'>".$val->fm_telephone ."</td>
								<td value='".$val->fm_mobile ."'>".$val->fm_mobile ."</td>
								
								<td value='".$val->fm_address ."'>".$val->fm_address ."</td>
								<td value='".$val->fm_description ."'>".$val->fm_description ."</td>
								<td><form method='post' name='edit'><input type='hidden' name='view'/><input type='submit' id='view_prov_id' name='view' value='VIEW' class='".$val->ID ."'/></form>
								
								</td>
								
								";
            
		
			$i++;	
        endforeach;
		
		}
		
		
		// last

		
        $fm_present_results .= "</tbody></table>";
		echo $fm_present_results;

				
		// end last
		
	
	}
	
	
	// GET LIST OF PROFESSIONS IN SIMPLE SELECT LIST
	
	
	public function f_m_build_prof_simple(){
	
	
		global $wpdb;
        $table = $wpdb->prefix . FM_PROFESSIONS_TABLE;
        $sql = $wpdb->prepare( "SELECT * FROM $table ORDER BY type asc", '' );
        $results = $wpdb->get_results($sql);
    
   
    
		if(is_array($results)){
        $i=0;
        $this->fm_present_results = "<option value=''></option>";
        foreach($results as $val):
            $i;
        
		// remove edit button 
		
		// $fm_present_results .= "<tr><td value=''>" .$val->type . "</td><td><a href='".$val->id ."' id='f_m_prof_edit'>edit</a></td><td><a href='".$val->id ."' id='f_m_prof_delete'>delete</a></td></tr>";
          
		$this->fm_present_results .= "<option value='" .$val->type . "'>" .$val->type . "</option>";
          
		
		$i++;
        endforeach;
			
		//$fm_present_results .= "</table>";
		return $this->fm_present_results;
		
		}
	
	
	}
	
	
	// END, GET LIST OF PROFESSIONS
	
}