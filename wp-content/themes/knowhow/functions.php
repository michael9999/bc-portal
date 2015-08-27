<?php
/**
* KnowHow functions and definitions
* by Hero Themes (http://herothemes.com)
*/

/**
* Set the content width based on the theme's design and stylesheet.
*/
if ( ! isset( $content_width ) ) $content_width = 980;


/**
* Sets up theme defaults and registers support for various WordPress features.
*/
if ( ! function_exists( 'st_theme_setup' ) ):
function st_theme_setup() {
	
	/**
	* Make theme available for translation
	* Translations can be filed in the /languages/ directory
	*/
	load_theme_textdomain( 'framework', get_template_directory() . '/languages' );
	

	/**
	* Add default posts and comments RSS feed links to head
	*/
	add_theme_support( 'automatic-feed-links' );
	
	/**
	* Enable support for Post Thumbnails
	*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 60, 60 );
	add_image_size( 'post', 150, 150, false ); // Post thumbnail	
	
	/**
	* Register menu locations
	*/
	register_nav_menus( array(
			'primary-nav' => __( 'Primary Menu', 'framework' ),
			'footer-nav' => __( 'Footer Menu', 'framework' )
	));
	
	/**
	* Add Support for post formarts
	*/
	add_theme_support( 'post-formats', array( 'video' ) );
	
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );	
	
}
endif; // st_theme_setup
add_action( 'after_setup_theme', 'st_theme_setup' );


/**
* Custom Theme Options
*/
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/admin/' );
	require_once dirname( __FILE__ ) . '/framework/admin/options-framework.php';
}


/**
* Cleanup Functions
*/
 
require("framework/cleanup.php");


/**
 * Enqueues scripts and styles for front-end.
 */
require("framework/scripts.php");
require("framework/styles.php");


/**
 * Theme Functions
 */
require("framework/theme-functions.php");


/**
 * Adds theme shortcodes
 * (will be mvoed to plugin soon)
 */
 
require("framework/shortcodes/shortcodes.php");

// Add shortcode manager
require("framework/wysiwyg/wysiwyg.php");


/**
 * Comment Functions
 */
require("framework/comment-functions.php");


/**
 * Post Types
 */
require("framework/post-types.php");


/**
 * Post Meta Boxes
 */
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/framework/meta-box-library' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/framework/meta-box-library' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
// Include the meta box definition
include 'framework/post-meta.php';

/**
 * Post Meta (Legacy)
 */
//require("framework/post-meta-legacy.php");


/**
 * Post Format Functions
 */

require("framework/post-formats.php");


/**
 * Comment Functions
 */

require("framework/template-navigation.php");


/**
 * Register widgetized area and update sidebar with default widgets
 */

require("framework/register-sidebars.php");


/**
 * Add Widget Functions
 */ 
require("framework/widgets/widget-functions.php");



/**
 * Change Posts to Articles
 */
 
function st_change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = __("Articles", "framework");
    $submenu['edit.php'][5][0] = __("Articles", "framework");
    $submenu['edit.php'][10][0] = __("Add Article", "framework");

    echo '';
}
function st_change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = __("Articles", "framework");
        $labels->singular_name = __("Article", "framework");
        $labels->add_new = __("Add Article", "framework");
        $labels->add_new_item = __("Add Article", "framework");
        $labels->edit_item = __("Edit Article", "framework");
        $labels->new_item = __("Article", "framework");
        $labels->view_item = __("View Article", "framework");
        $labels->search_items = __("Search Articles", "framework");
        $labels->not_found = __("No Article Found", "framework");
        $labels->not_found_in_trash = __("No Articles found in Trash", "framework");
    }
add_action( 'init', 'st_change_post_object_label' );
add_action( 'admin_menu', 'st_change_post_menu_label' );


/**
 * Add post views
 */
 
function st_set_post_views($postID) {
    $count_key = '_st_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function st_get_post_views($postID){
    $count_key = '_st_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
        return "1 View";
    }
    return $count.' Views';
}



/**
* WordPress Gallery Function
*/
 
require("framework/wordpress-gallery.php");


/**
 * TGM Plugin Activated
 */
if ( $wp_version < 3.6 ) {
require("framework/tgm-plugin-activation/plugin-requirements.php");
}

/**
 * To allow us to query if a plugin is active
 * http://codex.wordpress.org/Function_Reference/is_plugin_active
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


/**
 * Fix articles in parent/child category display
 */
function ht_justonecat_posts($qobj) {
    if ( $qobj->is_archive && $qobj->is_category) {
        $thiscat=$qobj->query_vars['category_name']; // gets category slug
        if ($thiscat) {
            $thiscatobj=get_category_by_slug($thiscat);
            $thiscatid = (array) $thiscatobj->term_id;
            $notcats = ht_justonecat_subcats($thiscatobj->term_id);
            if (count($notcats>0))  {
                $qobj->query_vars['category__in']=$thiscatid;
                $qobj->query_vars['category__not_in']=$notcats;
            }
        }
    }
}
//add_action('pre_get_posts','ht_justonecat_posts',10,1);

function ht_justonecat_subcats($parent=0,$categories=NULL) {
    if ($categories == NULL) $categories = get_categories("child_of=0&hide_empty=0&hierarchical=1");
    $ret = array();
    foreach ($categories as $cat) {
        if ($cat->parent == $parent) {
            $ret[]= $cat->term_id;
            $more = ht_justonecat_subcats($cat->term_id,$categories);
            $ret=array_merge($more,$ret);
        }
    }
    return $ret;
}