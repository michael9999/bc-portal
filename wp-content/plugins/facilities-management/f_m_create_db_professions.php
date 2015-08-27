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
        
        define("FM_PROFESSIONS_TABLE",'fm_professions_table');
        global $wpdb;

    

       $ktr_info_table_name = $wpdb->prefix . FM_PROFESSIONS_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS" . $ktr_info_table_name . "(
  id int(20) NOT NULL AUTO_INCREMENT,
  type varchar(80) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38";
     

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($ktr_info_table_name_sql);

        
    }
    
    function f_m_remove_db(){
        
        // Remove test table
        
         global $wpdb;
         $clientInfoTable = $wpdb->prefix."fm_docs_table";
         //$registerDomainInfoTable = $wpdb->prefix."kiteorder_order";

           // $wpdb->query("DROP TABLE IF EXISTS $registerDomainInfoTable");
         $wpdb->query("DROP TABLE IF EXISTS $clientInfoTable");
        
        
    }


}

?>