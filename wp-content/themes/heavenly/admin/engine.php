<?php 

define("heavenly_THEME_DIR",dirname(dirname(__FILE__)));
define("heavenly_THEME_URL",get_stylesheet_directory_uri());

global $heavenly_wf_data;

//require(dirname(__FILE__).'/');

### SECTION
// LESS Processing
function enqueue_less_styles($tag, $handle) {
    global $wp_styles;
    $match_pattern = '/\.less$/U';
    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
        $handle = $wp_styles->registered[$handle]->handle;
        $media = $wp_styles->registered[$handle]->args;
        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

        $tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
    }
    return $tag;
}

add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);
// LESS Processing Ends ^^
 
 
### SECTION
//Theme admin css & js
function heavenly_theme_admin_scripts($hook){ 
    if($hook!='appearance_page_heavenly-themeopts') return;
    wp_enqueue_style('bootstrap-ui',get_stylesheet_directory_uri().'/admin/bootstrap/css/bootstrap.css');
    wp_enqueue_style('chosen-ui',get_stylesheet_directory_uri().'/admin/css/chosen.css');
    wp_enqueue_style('admincss',get_stylesheet_directory_uri().'/admin/css/base-admin-style.css');
    wp_enqueue_script('bootstrap-js',get_stylesheet_directory_uri().'/admin/bootstrap/js/bootstrap.min.js',array('jquery'));
    wp_enqueue_script('chosen-js',get_stylesheet_directory_uri().'/admin/js/chosen.jquery.js',array('jquery'));
    wp_enqueue_script('heavenly-js',get_stylesheet_directory_uri().'/admin/js/wpeden.js',array('jquery','chosen-js'));
    wp_enqueue_script('media-upload');
    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
}

add_action( 'admin_enqueue_scripts', 'heavenly_theme_admin_scripts');
//Theme admin css & js ends ^^
 
### SECTION
//Theme option menu function
function heavenly_theme_opt_menu(){                                                                                             /*Theme Option Menu*/
      add_theme_page( "WPEden Theme Options", "Theme Options", 'edit_theme_options', 'heavenly-themeopts', 'heavenly_theme_options');  
}


function heavenly_setting_field($data) {     
    
    switch($data['type']):
            case 'text':
                echo "<div class='controls'><input type='text' id='$data[id]' name='$data[name]' class='input span5' value='$data[value]' /></div></div>";
            break;
            case 'checkbox':
                $checked = $data['value']==$data['sel']?'checked=checked':'';
                echo "<div class='controls'><input type='checkbox' name='$data[name]' class='input' value='$data[value]' {$checked} /></div></div>";
            break;
            case 'textarea':
                echo "<div class='controls'><textarea name='$data[name]' class='input span5'>$data[value]</textarea></div></div>";
            break;
            case 'callback':
                echo "<div class='controls'>".call_user_func($data['dom_callback'], $data['dom_callback_params'])."</div></div>";
            break;
            case 'heading':
                echo "<div class='navbar'><div class='navbar-inner'><a href='#{$data['id']}' class='brand'>".$data['label']."</a></div></div></div>";
            break;
    endswitch;
}
global $wpede_data_fetched;
function heavenly_get_theme_opts($index = null, $default = null){
    global $heavenly_wf_data, $settings_sections, $wpede_data_fetched;
    if(!$wpede_data_fetched){
    $heavenly_wf_data = array();    
    foreach($settings_sections as $section_id => $section_name) {
    $heavenly_wf_data = array_merge($heavenly_wf_data,get_option($section_id,array()));    
    }
    $wpede_data_fetched = 1;}
    
    if(!$index)
    return $heavenly_wf_data;
    else
    return isset($heavenly_wf_data[$index])&&$heavenly_wf_data[$index]!=''?stripcslashes($heavenly_wf_data[$index]):$default;
}

function heavenly_subsection_heading($data){
    return "<h3>{$data}</h3>";
}


/**
 * Site Logo
 *
 * @param mixed $params
 */
function heavenly_site_logo($params){
    extract($params);

    $html = "<div class='input-append'><input class='{$id}' type='text' name='{$name}' id='{$id}_image' value='{$selected}' /><button rel='#{$id}_image' class='btn btn-media-upload' type='button'><i class='icon icon-folder-open'></i></button></div>";
    $html .="<div style='clear:both'></div>";
    return $html;
}

function heavenly_favicon(){
    ?>
    <link rel="icon" type="image/png" href="<?php echo heavenly_get_theme_opts('favicon'); ?>" />
<?php
}


function heavenly_get_site_logo(){
    $logourl = wpeden_get_theme_opts('site_logo');
    if($logourl) echo "<img src='{$logourl}' title='".get_bloginfo('sitename')."' alt='".get_bloginfo('sitename')."' />";
    else echo get_bloginfo('sitename');
}

$section = isset($_GET['section'])?$_GET['section']:'heavenly_general_settings';
$settings_sections = array(
            'heavenly_general_settings' => 'General Settings',
            'heavenly_homepage_settings' => 'Homepage Settings',
            
);
$settings_fields = array(
            'logo_url' => array('id' => 'logo_url',
                                'section'=>'heavenly_general_settings',
                                'label'=>'Logo URL',
                                'description'=>'Size: 140x25 px',
                                'name' => 'heavenly_general_settings[logo_url]',
                                'type' => 'callback',
                                'value' => heavenly_get_theme_opts('logo_url'),
                                'validate' => 'url',
                                'dom_callback' => 'heavenly_site_logo',
                                'dom_callback_params' => array('name'=>'heavenly_general_settings[logo_url]','id'=>'logo_url','selected'=>heavenly_get_theme_opts('logo_url'))
                                ),
            'favicon' => array('id' => 'favicon',
                                'section'=>'heavenly_general_settings',
                                'label'=>'FavIcon URL',
                                'description'=>'Size: 16x16 px',
                                'name' => 'heavenly_general_settings[favicon]',
                                'type' => 'callback',
                                'value' => heavenly_get_theme_opts('favicon'),
                                'validate' => 'url',
                                'dom_callback' => 'heavenly_site_logo',
                                'dom_callback_params' => array('name'=>'heavenly_general_settings[favicon]','id'=>'favicon','selected'=>heavenly_get_theme_opts('favicon'))
                                ),
            'color_scheme' => array('id' => 'color_scheme',
                                'section'=>'heavenly_general_settings',
                                'label'=>'Color Scheme',
                                'name' => 'heavenly_general_settings[color_scheme]',
                                'type' => 'text',
                                'value' => heavenly_get_theme_opts('color_scheme'),
                                'validate' => 'str'                                 
                                ),
            'footer_text' => array('id' => 'footer_text',
                                'section'=>'heavenly_general_settings',
                                'label'=>'Footer Text',
                                'name' => 'heavenly_general_settings[footer_text]',
                                'type' => 'text',
                                'value' => heavenly_get_theme_opts('footer_text'),
                                'validate' => 'str'
                                ),
            'custom_homepage' => array('id' => 'custom_homepage',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Custom Homepage',
                                'name' => 'custom_homepage',
                                'type' => 'heading'                                
                                ),
            'heavenly_home' => array('id' => 'heavenly_home',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Show Custom Homepage',
                                'name' => 'heavenly_homepage_settings[heavenly_home]',
                                'type' => 'checkbox',
                                'value' => 1,
                                'validate' => 'str',
                                'sel' => heavenly_get_theme_opts('heavenly_home')
                                ),
            'featured_slider_heading' => array('id' => 'featured_slider_heading',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Homepage Header Settings',
                                'name' => 'featured_slider_heading',
                                'type' => 'heading'
                                ),
            'home_featured_image' => array('id' => 'home_featured_image',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Image URL',
                                'name' => 'heavenly_homepage_settings[home_featured_image]',
                                'type' => 'callback',
                                'value' => heavenly_get_theme_opts('home_featured_image'),
                                'validate' => 'url',
                                'dom_callback' => 'heavenly_site_logo',
                                'dom_callback_params' => array('name'=>'heavenly_homepage_settings[home_featured_image]','id'=>'home_featured_image','selected'=>heavenly_get_theme_opts('home_featured_image'))
                                ),
             
            'home_featured_title' => array('id' => 'home_featured_title',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Headline',
                                'name' => 'heavenly_homepage_settings[home_featured_title]',
                                'type' => 'text',
                                'value' => heavenly_get_theme_opts('home_featured_title'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_desc' => array('id' => 'home_featured_desc',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Description',
                                'name' => 'heavenly_homepage_settings[home_featured_desc]',
                                'type' => 'textarea',
                                'value' => heavenly_get_theme_opts('home_featured_desc'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_btntxt' => array('id' => 'home_featured_btntxt',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Button Text',
                                'name' => 'heavenly_homepage_settings[home_featured_btntxt]',
                                'type' => 'text',
                                'value' => heavenly_get_theme_opts('home_featured_btntxt'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_btnurl' => array('id' => 'home_featured_btnurl',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Button URL',
                                'name' => 'heavenly_homepage_settings[home_featured_btnurl]',
                                'type' => 'text',
                                'value' => heavenly_get_theme_opts('home_featured_btnurl'),
                                'validate' => 'str'                                
                                ),
             
            'featured_page_heading' => array('id' => 'featured_page_heading',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Pages',
                                'name' => 'featured_page_heading',
                                'type' => 'heading'                                
                                ),
            'home_featured_page_1' => array('id' => 'home_featured_page_1',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 1',
                                'name' => 'heavenly_homepage_settings[home_featured_page_1]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_1]&id=home_featured_page_1&selected='.heavenly_get_theme_opts('home_featured_page_1')
                                ),
            'home_featured_page_2' => array('id' => 'home_featured_page_2',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 2',
                                'name' => 'heavenly_homepage_settings[home_featured_page_2]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_2]&id=home_featured_page_2&selected='.heavenly_get_theme_opts('home_featured_page_2')
                                ),
            'home_featured_page_3' => array('id' => 'home_featured_page_3',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 3',
                                'name' => 'heavenly_homepage_settings[home_featured_page_3]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_3]&id=home_featured_page_3&selected='.heavenly_get_theme_opts('home_featured_page_3')
                                ),
            'home_featured_page_4' => array('id' => 'home_featured_page_4',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 4',
                                'name' => 'heavenly_homepage_settings[home_featured_page_4]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_4]&id=home_featured_page_4&selected='.heavenly_get_theme_opts('home_featured_page_4')
                                ),
            'home_featured_page_5' => array('id' => 'home_featured_page_5',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 5',
                                'name' => 'heavenly_homepage_settings[home_featured_page_5]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_5]&id=home_featured_page_5&selected='.heavenly_get_theme_opts('home_featured_page_5')
                                ),
            'home_featured_page_6' => array('id' => 'home_featured_page_6',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 6',
                                'name' => 'heavenly_homepage_settings[home_featured_page_6]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_6]&id=home_featured_page_6&selected='.heavenly_get_theme_opts('home_featured_page_6')
                                ),
            'home_featured_page_7' => array('id' => 'home_featured_page_7',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 7',
                                'name' => 'heavenly_homepage_settings[home_featured_page_7]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_7]&id=home_featured_page_7&selected='.heavenly_get_theme_opts('home_featured_page_7')
                                ),
            'home_featured_page_8' => array('id' => 'home_featured_page_8',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Featured Page 8',
                                'name' => 'heavenly_homepage_settings[home_featured_page_8]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_featured_page_8]&id=home_featured_page_8&selected='.heavenly_get_theme_opts('home_featured_page_8')
                                ),
            'home_cat_heading' => array('id' => 'home_cat_heading',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Homepage Post Category',
                                'name' => 'home_cat_heading',
                                'type' => 'heading'                                
                                ),
            'home_cat_4' => array('id' => 'home_cat_4',
                                'section'=>'heavenly_homepage_settings',
                                'label'=>'Homepage Post Category',
                                'desc' => '',
                                'name' => 'heavenly_homepage_settings[home_cat_4]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_categories',
                                'dom_callback_params' => 'echo=0&name=heavenly_homepage_settings[home_cat_4]&id=home_cat_4&selected='.heavenly_get_theme_opts('home_cat_4')
                                )

);



function heavenly_setup_theme_options(){
    global $settings_fields, $heavenly_wf_data, $section, $settings_sections;   
    foreach($settings_sections as $section_id=>$section_name){                 
        register_setting($section_id,$section_id,'heavenly_validate_optdata');           
    }
    foreach($settings_fields as $id=>$field){         
        if($field['type']=='heading')
        add_settings_field($id, '<div class="control-group">', 'heavenly_setting_field', 'heavenly-themeopts', $field['section'], $field);    
        else
        add_settings_field($id, '<div class="control-group"><label for="ftrcat" class="control-label">'.$field['label'].'</label>', 'heavenly_setting_field', 'heavenly-themeopts', $field['section'], $field);    
    }
}

add_action('admin_init','heavenly_setup_theme_options');

function heavenly_validate_optdata($data){    
    global $settings_fields;  
    $error = array();
    
    foreach($settings_fields as $id=>$field){
         if(!isset($data[$id])) continue;              
         switch($field['validate']){
             case 'url':
                $data[$id] = esc_url($data[$id]);
             break;
             case 'int':
                $data[$id] = intval($data[$id]);
             break;
             case 'double':
                $data[$id] = doubleval($data[$id]);
             break;
             case 'str':
                $data[$id] = mysql_escape_string(strval($data[$id]));
             break;
             case 'email':
                $data[$id] = is_email($data[$id])?$data[$id]:'';
                $error[$id] = 'Invalid Email Address';
             break;
         }
    }
    if($error) return $data['__error__'] = $error;
    
    return $data;
}

function heavenly_logo(){
    $logo = esc_url(heavenly_get_theme_opts('logo_url'));
    $sitename = get_bloginfo('sitename');
    if($logo!='')
    echo "<img src='{$logo}' title='{$sitename}' alt='{$sitename}' />";
    else 
    echo $sitename;
}
    
//theme option     
function heavenly_theme_options(){
global $settings_sections, $section;                                                                                                  /*Theme Option Function*/      
?>

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" />
    <div class="wrap wpeden-theme-options w3eden">
        <div class="container-fluid">
            <div class="row-fluid theader">
                <div class="span12">

                    <h2 class="thm_heading"><img src="<?php echo get_template_directory_uri(); ?>/admin/images/logo-min.png" /></h2>
                </div>

            </div>
            <div class="row-fluid">
                <div class="span12">

                    <div class=" tabbable tabs-left">
                        <!-- Theme Option Sections -->
                        <ul class="nav nav-tabs smn">
                            <<?php foreach($settings_sections as $section_id=>$section_name){ ?>
                                <li class="<?php echo $section==$section_id?'active':''; ?>"><a href="#<?php echo $section_id; ?>" data-toggle='tab'><?php echo $section_name; ?></a></li>
                            <?php } ?>
                        </ul>
                        <!-- Theme Option Sections Ends -->


                        <!-- Theme Option Fields for section # -->
                        <div class="tab-content">
                            <?php foreach($settings_sections as $section_id=>$section_name){ ?>
                                <div class="tab-pane <?php echo $section_id==$section?'active':''; ?>" id="<?php echo $section_id; ?>">
                                    <div class="btn-group pull-right" id="gopro">
                                        <a class="btn btn-success" href="http:///wpeden.com/product/heavenly-pro-multipurpose-wordpress-theme/" target="_blank"><b>Get Amazing Heavenly Pro!</b></a>
                                        <a class="btn btn-danger" href="http://wpeden.com/wordpress/themes/" target="_blank">More Themes</a>
                                        <a class="btn btn-inverse" href="http://wpeden.com/wordpress/plugins/" target="_blank">Premium Plugins</a>
                                    </div>
                                    <form id="theme-admin-form" class="form-horizontal" action="options.php" method="post" enctype="multipart/form-data">
                                        <?php
                                        settings_fields( $section_id );
                                        do_settings_fields( 'heavenly-themeopts',$section_id );
                                        ?>
                                        <div class="control-group">

                                            <div class="controls">
                                                <?php submit_button(); ?>
                                                <span id="loading" style="display: none;"><img src="images/loading.gif" alt=""> saving...</span>
                                                <a href="plugin-install.php?tab=search&type=term&s=%22Page+Layout+Builder%22&plugin-search-input=Search+Plugins" class="button button-secondary">Get Drag & Drop Page Builder Free</a><br/><br/>
                                                <span id="loading" style="display: none;"><img src="images/loading.gif" alt=""> saving...</span>
                                                <b>If you like this theme please consider:</b><Br/> <Br/>
                                                <a class="button" target="_blank" href="http://wordpress.org/support/view/theme-reviews/heavenly?rate=5#postform">A 5&#9733; rating will inspire us huge</a><br><br>
                                                Please Like this theme in FB:<br/>
                                                <div id="fb-root"></div>
                                                <script>(function(d, s, id) {
                                                        var js, fjs = d.getElementsByTagName(s)[0];
                                                        if (d.getElementById(id)) return;
                                                        js = d.createElement(s); js.id = id;
                                                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=185450134846732";
                                                        fjs.parentNode.insertBefore(js, fjs);
                                                    }(document, 'script', 'facebook-jssdk'));</script>
                                                <div class="fb-like" data-href="http://wpeden.com/" data-send="true" data-width="450" data-show-faces="false"></div>
                                                <br clear="all" />
                                                <br clear="all" />
                                                Please follow in twitter:<br/>
                                                <a href="https://twitter.com/webmaniac" class="twitter-follow-button" data-show-count="true" data-size="large">Follow @webmaniac</a>
                                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                            </div>

                                        </div>
                                        <div class="clear"></div>
                                    </form>
                                    <div class="clear"></div>
                                </div>
                            <?php } ?>


                        </div>
                        <!-- Theme Option Fields for section # Ends -->
                    </div>
                </div>
                <script>jQuery('.ttip').tooltip({placement:'right',animation:false, container:'ul.nav-pills'}); jQuery('.nav-pills a').click(function(e){e.preventDefault(); jQuery('.nav-tabs li').slideUp();jQuery(jQuery(this).attr('rel')).slideDown(); });</script>
            </div>
        </div>

    </div>

<?php
        
}
  
 
add_action('admin_menu', 'heavenly_theme_opt_menu');
add_action('wp_head', 'heavenly_favicon');