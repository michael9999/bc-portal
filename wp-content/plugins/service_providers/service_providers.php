<?php
/*
Plugin Name: Service provider tutorial
Plugin URI: http://www.pro-questions.com
Description: Wordpress plugin tutorial
Author: Pro Question
Version: 1.0.1
Author URI: http://pro-questions.com
*/

$siteurl = get_option('siteurl');
define('PRO_FOLDER', dirname(plugin_basename(__FILE__)));
define('PRO_URL', $siteurl.'/wp-content/plugins/' . PRO_FOLDER);
define('PRO_FILE_PATH', dirname(__FILE__));
define('PRO_DIR_NAME', basename(PRO_FILE_PATH));
// this is the table prefix
global $wpdb;
$pro_table_prefix=$wpdb->prefix.'pro_';
define('PRO_TABLE_PREFIX', $pro_table_prefix);

register_activation_hook(__FILE__,'pro_install');
register_deactivation_hook(__FILE__ , 'pro_uninstall' );

function pro_install()
{
    global $wpdb;
    $table = PRO_TABLE_PREFIX."tutorial";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(80) NOT NULL,
        website VARCHAR(20) NOT NULL,
        description text,
    UNIQUE KEY id (id)
    );";
    $wpdb->query($structure);
	  // Populate table
    $wpdb->query("INSERT INTO $table(name, website, description)
        VALUES('Pro Questions', 'pro-questions.com','This Is A Programming Questions Site')");
}
function pro_uninstall()
{
    global $wpdb;
    $table = PRO_TABLE_PREFIX."tutorial";
    $structure = "drop table if exists $table";
    $wpdb->query($structure);  
}

add_action('admin_menu','pro_admin_menu');

function pro_admin_menu() { 
    add_menu_page(
		"Plugin tutorial",
		"Plugin tutorial",
		8,
		__FILE__,
		"pro_admin_menu_list",
		PRO_URL."/images/menu.gif"
	); 
	add_submenu_page(__FILE__,'Site list','Site list','8','list-site','pro_admin_list_site');
}

function pro_admin_menu_list()
{
    echo "Now i know how to create a plugin in wordpress!";
}
// function for the site listing
function pro_admin_list_site()
{
	 include 'admin-list-site.php';
}



?>