<?php
/**
     * Fired when the plugin is activated.
	 * Check if db exists, build if necessary
     *
	 * @since    1.0.0 1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */

class f_m_create_db{


    function check_db(){
        
        
        // CREATE TEST TABLE - works!
        
        define("FM_TEST_TABLE",'test_table');
        global $wpdb;

    

       $ktr_info_table_name = $wpdb->prefix . FM_TEST_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS " . $ktr_info_table_name . " (
                                fm_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                fm_name VARCHAR( 200 ) NOT NULL ,
                                fm_email VARCHAR( 100 ) NOT NULL ,
                                fm_time_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                ) ENGINE = MYISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);

        
    }
    
    function f_m_remove_db(){
        
        // Remove test table
        
         global $wpdb;
         $clientInfoTable = $wpdb->prefix."test_table";
         //$registerDomainInfoTable = $wpdb->prefix."kiteorder_order";

           // $wpdb->query("DROP TABLE IF EXISTS $registerDomainInfoTable");
         $wpdb->query("DROP TABLE IF EXISTS $clientInfoTable");
        
        
    }


}

?>