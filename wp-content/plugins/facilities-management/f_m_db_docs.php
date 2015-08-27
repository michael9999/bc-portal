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
        
        define("FM_DOC_TABLE",'fm_docs_table');
        global $wpdb;

    

       $ktr_info_table_name = $wpdb->prefix . FM_DOC_TABLE;
      $ktr_info_table_name_sql="CREATE TABLE IF NOT EXISTS" . $ktr_info_table_name . "(
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  wpid int(11) DEFAULT NULL,
  filename varchar(255) DEFAULT NULL,
  filedownload varchar(255) DEFAULT NULL,
  UNIQUE KEY id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ";
     

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