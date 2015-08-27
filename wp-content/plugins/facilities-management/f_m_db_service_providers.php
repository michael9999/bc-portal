<?php
/**
     * Fired when the plugin is activated.
	 * Check if db exists, build if necessary
     *
	 * @since    1.0.0 1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */

class f_m_db_service_providers{


    function check_db(){
        
        
        // CREATE TEST TABLE - works!
        
        define("FM_SERVICE_TABLE",'fm_service_table');
        global $wpdb;

    

       $ktr_info_table_name = $wpdb->prefix . FM_SERVICE_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS" . $ktr_info_table_name . "(
  fm_id int(11) NOT NULL AUTO_INCREMENT ,
  wp_id bigint(100) NOT NULL ,
  fm_comp_name varchar(50) NOT NULL ,
  fm_provider varchar(200) NOT NULL ,
  fm_description varchar(255) NOT NULL ,
  fm_type varchar(60) NOT NULL ,
  fm_mobile varchar(30) NOT NULL ,
  fm_telephone varchar(30) NOT NULL ,
  fm_address varchar(255) NOT NULL ,
  fm_vendor_nb varchar(255) NOT NULL ,
  fm_time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (fm_id)
) ENGINE=MyISAM ";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);

        
    }
    
    function f_m_remove_db(){
        
        // Remove test table
        
         global $wpdb;
         $clientInfoTable = $wpdb->prefix."fm_service_table";
         //$registerDomainInfoTable = $wpdb->prefix."kiteorder_order";

           // $wpdb->query("DROP TABLE IF EXISTS $registerDomainInfoTable");
         $wpdb->query("DROP TABLE IF EXISTS $clientInfoTable");
        
        
    }


}

?>