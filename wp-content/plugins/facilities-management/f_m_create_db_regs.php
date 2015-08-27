<?php
/**
     * Fired when the plugin is activated.
	 * Check if db exists, build if necessary
     *
	 * @since    1.0.0 1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */

class f_m_create_db_regs{


    function check_db(){
        
        
        // CREATE TEST TABLE - works!
        
        define("FM_TEST_TABLE_REGS",'test_table2');
        global $wpdb;

    //CREATE TABLE IF NOT EXISTS `test6` 
/*(
 `fm_id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_date` date NOT NULL,
 fm_title(255) VARCHAR,  PRIMARY KEY (`fm_id`)
)
ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;*/

       $fm_info_table_name = $wpdb->prefix . FM_TEST_TABLE_REGS;
      $fm_info_table_name_sql="CREATE TABLE IF NOT EXISTS " . $fm_info_table_name . " (
                                fm_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                fm_date DATE NOT NULL ,
                                fm_title VARCHAR( 200 ) NOT NULL ,
                                fm_time_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                ) ENGINE = MYISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($fm_info_table_name_sql);

        
    }
    
    function f_m_remove_db(){
        
        // Remove test table
        
         global $wpdb;
         $clientInfoTable = $wpdb->prefix . FM_TEST_TABLE_REGS;
         //$registerDomainInfoTable = $wpdb->prefix."kiteorder_order";

           // $wpdb->query("DROP TABLE IF EXISTS $registerDomainInfoTable");
         $wpdb->query("DROP TABLE IF EXISTS $clientInfoTable");
        
        
    }


}

?>