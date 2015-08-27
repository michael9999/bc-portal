<?php
 
if ( ! isset( $content_width ) ) $content_width = 960;


require_once(dirname(__FILE__)."/admin/engine.php"); 
require_once(dirname(__FILE__)."/libs/nav-menu-walker.class.php"); 
 

 
//generate thumbnail 
function heavenly_thumb($post, $size='', $extra = array(), $echo = true){    
    $size = $size?$size:'large';   
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size); 
    $large_image_url = $large_image_url[0];    
    $large_image_url = $large_image_url?$large_image_url:'';        
    $class = isset($extra['class'])?$extra['class']:'';
    if($echo&&has_post_thumbnail($post->ID ))
    echo get_the_post_thumbnail($post->ID, $size, $extra );
    else if(!$echo&&has_post_thumbnail($post->ID ))
    return get_the_post_thumbnail($post->ID, $size, $extra );  
    else if($echo)
    echo "";
    else
    return "";
    
}
    

//post thumbnail function
function heavenly_post_thumb($size='', $echo = true, $extra = null){
    global $post;
    $size = $size?$size:'thumbnail';
    /*
    if(function_exists('jetpack_photon_url')&&is_array($size)){
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
    $large_image_url = $large_image_url[0];
        if($large_image_url!=''){
            $alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
            $img = "<img src='".jetpack_photon_url($large_image_url,"resize=".implode(",",$size))."' alt='{$alt}' />";
            if($echo) { echo $img; return; }
            else
            return $img;
        }
    }
    */

    if(is_array($size))
    {
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
        $large_image_url = $large_image_url[0];
        if($large_image_url!=''){
            $path = str_replace(site_url('/'), ABSPATH, $large_image_url);
            $thumb = heavenly_dynamic_thumb($path, $size);
            $thumb = str_replace(ABSPATH, site_url('/'), $thumb);
            $alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
            $img = "<img src='".$thumb."' alt='{$alt}' />";
            if($echo) { echo $img; return; }
            else
                return $img;
        }
    }
    if($echo&&has_post_thumbnail($post->ID ))
        echo get_the_post_thumbnail($post->ID, $size, $extra );
    else if(!$echo&&has_post_thumbnail($post->ID ))
        return get_the_post_thumbnail($post->ID, $size, $extra );
    else if($echo)
        echo "";
    else
        return "";
}

function heavenly_dynamic_thumb($path, $size){
    $name_p = explode(".",$path);
    $ext = ".".end($name_p);
    $thumbpath = str_replace($ext, "-".implode("x", $size).$ext, $path);
    if(file_exists($thumbpath)) return $thumbpath;
    $image = wp_get_image_editor( $path );
    if ( ! is_wp_error( $image ) ) {
        $image->resize( $size[0], $size[1], true );
        $image->save( $thumbpath );
    }
    return $thumbpath;
}

//post thumbnail url
function heavenly_post_thumb_url($size='', $echo = true, $extra = null){
    global $post;
    $size = $size?$size:'thumbnail';   
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); 
    $large_image_url = $large_image_url[0];
    return $large_image_url;
}

//generate cutom excerpt
function heavenly_post_excerpt($length){
    global $post;
    $uexcerpt = $post->post_excerpt?$post->post_excerpt:preg_replace("/\[([^\]]*)\]/","",$post->post_content);
    $uexcerpt = strip_tags($uexcerpt);
    $uexcerpt = esc_html($uexcerpt);
    $excerpt = substr($uexcerpt,0,$length);
    $eexcerpt = substr($uexcerpt,$length);
    $excerpt .= array_shift(explode(" ",$eexcerpt));
    echo $excerpt?$excerpt.'...':$excerpt;
}


function heavenly_meta_boxes(){ 
                                       
    $meta_boxes = array(
                        'heavenly-icons'=>array('title'=>'Featured Icon','callback'=>'heavenly_meta_box_icons','position'=>'side','priority'=>'core','post_type'=>'page'),
                        'heavenly-page-excerpt'=>array('title'=>'Excerpt','callback'=>'heavenly_meta_box_page_excerpt','position'=>'normal','priority'=>'core','post_type'=>'page'),
                   );
                       
                     
                       
    $meta_boxes = apply_filters("wpmp_meta_box", $meta_boxes);
    foreach($meta_boxes as $id=>$meta_box){
        extract($meta_box);
        add_meta_box($id, $title, $callback,$post_type, $position, $priority);
    }    
}



function heavenly_meta_box_page_excerpt($post){
        $data = maybe_unserialize(get_post_meta($post->ID,'heavenly_post_meta', true));
        if(!$data) $data['excerpt']  = '';
         
        ?>
        <textarea style="width: 100%" id="whyus" name="heavenly_post_meta[excerpt]" type="text"><?php echo $data['excerpt']; ?></textarea>        
        <?php     
}

function heavenly_meta_box_icons(){
        global $post;
        /*
        $icons['icon-cloud-download'] = 'Cloud Download';
        $icons['icon-cloud-upload'] = 'Cloud Upload';
        $icons['icon-lightbulb'] = 'Lightbulb';
        $icons['icon-exchange'] = 'Exchange';
        $icons['icon-bell-alt'] = 'Bell Alt';
        $icons['icon-file-alt'] = 'File Alt';
        $icons['icon-beer'] = 'Beer';
        $icons['icon-coffee'] = 'Coffee';
        $icons['icon-food'] = 'Food';
        $icons['icon-fighter-jet'] = 'Fighter Jet';
        $icons['icon-user-md'] = 'User Md';
        $icons['icon-stethoscope'] = 'Stethoscope';
        $icons['icon-suitcase'] = 'Suitcase';
        $icons['icon-building'] = 'Building';
        $icons['icon-hospital'] = 'Hospital';
        $icons['icon-ambulance'] = 'Ambulance';
        $icons['icon-medkit'] = 'Medkit';
        $icons['icon-h-sign'] = 'H Sign';
        $icons['icon-plus-sign-alt'] = 'Plus Sign Alt';
        $icons['icon-spinner'] = 'Spinner';
        $icons['icon-angle-left'] = 'Angle Left';
        $icons['icon-angle-right'] = 'Angle Right';
        $icons['icon-angle-up'] = 'Angle Up';
        $icons['icon-angle-down'] = 'Angle Down';
        $icons['icon-double-angle-left'] = 'Double Angle Left';
        $icons['icon-double-angle-right'] = 'Double Angle Right';
        $icons['icon-double-angle-up'] = 'Double Angle Up';
        $icons['icon-double-angle-down'] = 'Double Angle Down';
        $icons['icon-circle-blank'] = 'Circle Blank';
        $icons['icon-circle'] = 'Circle';
        $icons['icon-desktop'] = 'Desktop';
        $icons['icon-laptop'] = 'Laptop';
        $icons['icon-tablet'] = 'Tablet';
        $icons['icon-mobile-phone'] = 'Mobile Phone';
        $icons['icon-quote-left'] = 'Quote Left';
        $icons['icon-quote-right'] = 'Quote Right';
        $icons['icon-reply'] = 'Reply';
        $icons['icon-github-alt'] = 'Github Alt';
        $icons['icon-folder-close-alt'] = 'Folder Close Alt';
        $icons['icon-folder-open-alt'] = 'Folder Open Alt';
        $icons['icon-adjust'] = 'Adjust';
        $icons['icon-asterisk'] = 'Asterisk';
        $icons['icon-ban-circle'] = 'Ban Circle';
        $icons['icon-bar-chart'] = 'Bar Chart';
        $icons['icon-barcode'] = 'Barcode';
        $icons['icon-beaker'] = 'Beaker';
        $icons['icon-beer'] = 'Beer';
        $icons['icon-bell'] = 'Bell';
        $icons['icon-bell-alt'] = 'Bell Alt';
        $icons['icon-bolt'] = 'Bolt';
        $icons['icon-book'] = 'Book';
        $icons['icon-bookmark'] = 'Bookmark';
        $icons['icon-bookmark-empty'] = 'Bookmark Empty';
        $icons['icon-briefcase'] = 'Briefcase';
        $icons['icon-bullhorn'] = 'Bullhorn';
        $icons['icon-calendar'] = 'Calendar';
        $icons['icon-camera'] = 'Camera';
        $icons['icon-camera-retro'] = 'Camera Retro';
        $icons['icon-certificate'] = 'Certificate';
        $icons['icon-check'] = 'Check';
        $icons['icon-check-empty'] = 'Check Empty';
        $icons['icon-circle'] = 'Circle';
        $icons['icon-circle-blank'] = 'Circle Blank';
        $icons['icon-cloud'] = 'Cloud';
        $icons['icon-cloud-download'] = 'Cloud Download';
        $icons['icon-cloud-upload'] = 'Cloud Upload';
        $icons['icon-coffee'] = 'Coffee';
        $icons['icon-cog'] = 'Cog';
        $icons['icon-cogs'] = 'Cogs';
        $icons['icon-comment'] = 'Comment';
        $icons['icon-comment-alt'] = 'Comment Alt';
        $icons['icon-comments'] = 'Comments';
        $icons['icon-comments-alt'] = 'Comments Alt';
        $icons['icon-credit-card'] = 'Credit Card';
        $icons['icon-dashboard'] = 'Dashboard';
        $icons['icon-desktop'] = 'Desktop';
        $icons['icon-download'] = 'Download';
        $icons['icon-download-alt'] = 'Download Alt';
        $icons['icon-edit'] = 'Edit';
        $icons['icon-envelope'] = 'Envelope';
        $icons['icon-envelope-alt'] = 'Envelope Alt';
        $icons['icon-exchange'] = 'Exchange';
        $icons['icon-exclamation-sign'] = 'Exclamation Sign';
        $icons['icon-external-link'] = 'External Link';
        $icons['icon-eye-close'] = 'Eye Close';
        $icons['icon-eye-open'] = 'Eye Open';
        $icons['icon-facetime-video'] = 'Facetime Video';
        $icons['icon-fighter-jet'] = 'Fighter Jet';
        $icons['icon-film'] = 'Film';
        $icons['icon-filter'] = 'Filter';
        $icons['icon-fire'] = 'Fire';
        $icons['icon-flag'] = 'Flag';
        $icons['icon-folder-close'] = 'Folder Close';
        $icons['icon-folder-open'] = 'Folder Open';
        $icons['icon-folder-close-alt'] = 'Folder Close Alt';
        $icons['icon-folder-open-alt'] = 'Folder Open Alt';
        $icons['icon-food'] = 'Food';
        $icons['icon-gift'] = 'Gift';
        $icons['icon-glass'] = 'Glass';
        $icons['icon-globe'] = 'Globe';
        $icons['icon-group'] = 'Group';
        $icons['icon-hdd'] = 'Hdd';
        $icons['icon-headphones'] = 'Headphones';
        $icons['icon-heart'] = 'Heart';
        $icons['icon-heart-empty'] = 'Heart Empty';
        $icons['icon-home'] = 'Home';
        $icons['icon-inbox'] = 'Inbox';
        $icons['icon-info-sign'] = 'Info Sign';
        $icons['icon-key'] = 'Key';
        $icons['icon-leaf'] = 'Leaf';
        $icons['icon-laptop'] = 'Laptop';
        $icons['icon-legal'] = 'Legal';
        $icons['icon-lemon'] = 'Lemon';
        $icons['icon-lightbulb'] = 'Lightbulb';
        $icons['icon-lock'] = 'Lock';
        $icons['icon-unlock'] = 'Unlock';
        $icons['icon-magic'] = 'Magic';
        $icons['icon-magnet'] = 'Magnet';
        $icons['icon-map-marker'] = 'Map Marker';
        $icons['icon-minus'] = 'Minus';
        $icons['icon-minus-sign'] = 'Minus Sign';
        $icons['icon-mobile-phone'] = 'Mobile Phone';
        $icons['icon-money'] = 'Money';
        $icons['icon-move'] = 'Move';
        $icons['icon-music'] = 'Music';
        $icons['icon-off'] = 'Off';
        $icons['icon-ok'] = 'Ok';
        $icons['icon-ok-circle'] = 'Ok Circle';
        $icons['icon-ok-sign'] = 'Ok Sign';
        $icons['icon-pencil'] = 'Pencil';
        $icons['icon-picture'] = 'Picture';
        $icons['icon-plane'] = 'Plane';
        $icons['icon-plus'] = 'Plus';
        $icons['icon-plus-sign'] = 'Plus Sign';
        $icons['icon-print'] = 'Print';
        $icons['icon-pushpin'] = 'Pushpin';
        $icons['icon-qrcode'] = 'Qrcode';
        $icons['icon-question-sign'] = 'Question Sign';
        $icons['icon-quote-left'] = 'Quote Left';
        $icons['icon-quote-right'] = 'Quote Right';
        $icons['icon-random'] = 'Random';
        $icons['icon-refresh'] = 'Refresh';
        $icons['icon-remove'] = 'Remove';
        $icons['icon-remove-circle'] = 'Remove Circle';
        $icons['icon-remove-sign'] = 'Remove Sign';
        $icons['icon-reorder'] = 'Reorder';
        $icons['icon-reply'] = 'Reply';
        $icons['icon-resize-horizontal'] = 'Resize Horizontal';
        $icons['icon-resize-vertical'] = 'Resize Vertical';
        $icons['icon-retweet'] = 'Retweet';
        $icons['icon-road'] = 'Road';
        $icons['icon-rss'] = 'Rss';
        $icons['icon-screenshot'] = 'Screenshot';
        $icons['icon-search'] = 'Search';
        $icons['icon-share'] = 'Share';
        $icons['icon-share-alt'] = 'Share Alt';
        $icons['icon-shopping-cart'] = 'Shopping Cart';
        $icons['icon-signal'] = 'Signal';
        $icons['icon-signin'] = 'Signin';
        $icons['icon-signout'] = 'Signout';
        $icons['icon-sitemap'] = 'Sitemap';
        $icons['icon-sort'] = 'Sort';
        $icons['icon-sort-down'] = 'Sort Down';
        $icons['icon-sort-up'] = 'Sort Up';
        $icons['icon-spinner'] = 'Spinner';
        $icons['icon-star'] = 'Star';
        $icons['icon-star-empty'] = 'Star Empty';
        $icons['icon-star-half'] = 'Star Half';
        $icons['icon-tablet'] = 'Tablet';
        $icons['icon-tag'] = 'Tag';
        $icons['icon-tags'] = 'Tags';
        $icons['icon-tasks'] = 'Tasks';
        $icons['icon-thumbs-down'] = 'Thumbs Down';
        $icons['icon-thumbs-up'] = 'Thumbs Up';
        $icons['icon-time'] = 'Time';
        $icons['icon-tint'] = 'Tint';
        $icons['icon-trash'] = 'Trash';
        $icons['icon-trophy'] = 'Trophy';
        $icons['icon-truck'] = 'Truck';
        $icons['icon-umbrella'] = 'Umbrella';
        $icons['icon-upload'] = 'Upload';
        $icons['icon-upload-alt'] = 'Upload Alt';
        $icons['icon-user'] = 'User';
        $icons['icon-user-md'] = 'User Md';
        $icons['icon-volume-off'] = 'Volume Off';
        $icons['icon-volume-down'] = 'Volume Down';
        $icons['icon-volume-up'] = 'Volume Up';
        $icons['icon-warning-sign'] = 'Warning Sign';
        $icons['icon-wrench'] = 'Wrench';
        $icons['icon-zoom-in'] = 'Zoom In';
        $icons['icon-zoom-out'] = 'Zoom Out';
        $icons['icon-file'] = 'File';
        $icons['icon-file-alt'] = 'File Alt';
        $icons['icon-cut'] = 'Cut';
        $icons['icon-copy'] = 'Copy';
        $icons['icon-paste'] = 'Paste';
        $icons['icon-save'] = 'Save';
        $icons['icon-undo'] = 'Undo';
        $icons['icon-repeat'] = 'Repeat';
        $icons['icon-text-height'] = 'Text Height';
        $icons['icon-text-width'] = 'Text Width';
        $icons['icon-align-left'] = 'Align Left';
        $icons['icon-align-center'] = 'Align Center';
        $icons['icon-align-right'] = 'Align Right';
        $icons['icon-align-justify'] = 'Align Justify';
        $icons['icon-indent-left'] = 'Indent Left';
        $icons['icon-indent-right'] = 'Indent Right';
        $icons['icon-font'] = 'Font';
        $icons['icon-bold'] = 'Bold';
        $icons['icon-italic'] = 'Italic';
        $icons['icon-strikethrough'] = 'Strikethrough';
        $icons['icon-underline'] = 'Underline';
        $icons['icon-link'] = 'Link';
        $icons['icon-paper-clip'] = 'Paper Clip';
        $icons['icon-columns'] = 'Columns';
        $icons['icon-table'] = 'Table';
        $icons['icon-th-large'] = 'Th Large';
        $icons['icon-th'] = 'Th';
        $icons['icon-th-list'] = 'Th List';
        $icons['icon-list'] = 'List';
        $icons['icon-list-ol'] = 'List Ol';
        $icons['icon-list-ul'] = 'List Ul';
        $icons['icon-list-alt'] = 'List Alt';
        $icons['icon-angle-left'] = 'Angle Left';
        $icons['icon-angle-right'] = 'Angle Right';
        $icons['icon-angle-up'] = 'Angle Up';
        $icons['icon-angle-down'] = 'Angle Down';
        $icons['icon-arrow-down'] = 'Arrow Down';
        $icons['icon-arrow-left'] = 'Arrow Left';
        $icons['icon-arrow-right'] = 'Arrow Right';
        $icons['icon-arrow-up'] = 'Arrow Up';
        $icons['icon-caret-down'] = 'Caret Down';
        $icons['icon-caret-left'] = 'Caret Left';
        $icons['icon-caret-right'] = 'Caret Right';
        $icons['icon-caret-up'] = 'Caret Up';
        $icons['icon-chevron-down'] = 'Chevron Down';
        $icons['icon-chevron-left'] = 'Chevron Left';
        $icons['icon-chevron-right'] = 'Chevron Right';
        $icons['icon-chevron-up'] = 'Chevron Up';
        $icons['icon-circle-arrow-down'] = 'Circle Arrow Down';
        $icons['icon-circle-arrow-left'] = 'Circle Arrow Left';
        $icons['icon-circle-arrow-right'] = 'Circle Arrow Right';
        $icons['icon-circle-arrow-up'] = 'Circle Arrow Up';
        $icons['icon-double-angle-left'] = 'Double Angle Left';
        $icons['icon-double-angle-right'] = 'Double Angle Right';
        $icons['icon-double-angle-up'] = 'Double Angle Up';
        $icons['icon-double-angle-down'] = 'Double Angle Down';
        $icons['icon-hand-down'] = 'Hand Down';
        $icons['icon-hand-left'] = 'Hand Left';
        $icons['icon-hand-right'] = 'Hand Right';
        $icons['icon-hand-up'] = 'Hand Up';
        $icons['icon-circle'] = 'Circle';
        $icons['icon-circle-blank'] = 'Circle Blank';
        $icons['icon-play-circle'] = 'Play Circle';
        $icons['icon-play'] = 'Play';
        $icons['icon-pause'] = 'Pause';
        $icons['icon-stop'] = 'Stop';
        $icons['icon-step-backward'] = 'Step Backward';
        $icons['icon-fast-backward'] = 'Fast Backward';
        $icons['icon-backward'] = 'Backward';
        $icons['icon-forward'] = 'Forward';
        $icons['icon-fast-forward'] = 'Fast Forward';
        $icons['icon-step-forward'] = 'Step Forward';
        $icons['icon-eject'] = 'Eject';
        $icons['icon-fullscreen'] = 'Fullscreen';
        $icons['icon-resize-full'] = 'Resize Full';
        $icons['icon-resize-small'] = 'Resize Small';
        $icons['icon-phone'] = 'Phone';
        $icons['icon-phone-sign'] = 'Phone Sign';
        $icons['icon-facebook'] = 'Facebook';
        $icons['icon-facebook-sign'] = 'Facebook Sign';
        $icons['icon-twitter'] = 'Twitter';
        $icons['icon-twitter-sign'] = 'Twitter Sign';
        $icons['icon-github'] = 'Github';
        $icons['icon-github-alt'] = 'Github Alt';
        $icons['icon-github-sign'] = 'Github Sign';
        $icons['icon-linkedin'] = 'Linkedin';
        $icons['icon-linkedin-sign'] = 'Linkedin Sign';
        $icons['icon-pinterest'] = 'Pinterest';
        $icons['icon-pinterest-sign'] = 'Pinterest Sign';
        $icons['icon-google-plus'] = 'Google Plus';
        $icons['icon-google-plus-sign'] = 'Google Plus Sign';
        $icons['icon-sign-blank'] = 'Sign Blank';
        $icons['icon-ambulance'] = 'Ambulance';
        $icons['icon-beaker'] = 'Beaker';
        $icons['icon-h-sign'] = 'H Sign';
        $icons['icon-hospital'] = 'Hospital';
        $icons['icon-medkit'] = 'Medkit';
        $icons['icon-plus-sign-alt'] = 'Plus Sign Alt';
        $icons['icon-stethoscope'] = 'Stethoscope';
        $icons['icon-user-md'] = 'User Md';
        */
        
        $icons = array(
    "icon-glass",
    "icon-music",
    "icon-search",
    "icon-envelope",
    "icon-heart",
    "icon-star",
    "icon-star-empty",
    "icon-user",
    "icon-film",
    "icon-th-large",
    "icon-th",
    "icon-th-list",
    "icon-ok",
    "icon-remove",
    "icon-zoom-in",
    "icon-zoom-out",
    "icon-off",
    "icon-signal",
    "icon-cog",
    "icon-trash",
    "icon-home",
    "icon-file",
    "icon-time",
    "icon-road",
    "icon-download-alt",
    "icon-download",
    "icon-upload",
    "icon-inbox",
    "icon-play-circle",
    "icon-repeat",
    "icon-refresh",
    "icon-list-alt",
    "icon-lock",
    "icon-flag",
    "icon-headphones",
    "icon-volume-off",
    "icon-volume-down",
    "icon-volume-up",
    "icon-qrcode",
    "icon-barcode",
    "icon-tag",
    "icon-tags",
    "icon-book",
    "icon-bookmark",
    "icon-print",
    "icon-camera",
    "icon-font",
    "icon-bold",
    "icon-italic",
    "icon-text-height",
    "icon-text-width",
    "icon-align-left",
    "icon-align-center",
    "icon-align-right",
    "icon-align-justify",
    "icon-list",
    "icon-indent-left",
    "icon-indent-right",
    "icon-facetime-video",
    "icon-picture",
    "icon-pencil",
    "icon-map-marker",
    "icon-adjust",
    "icon-tint",
    "icon-edit",
    "icon-share",
    "icon-check",
    "icon-move",
    "icon-step-backward",
    "icon-fast-backward",
    "icon-backward",
    "icon-play",
    "icon-pause",
    "icon-stop",
    "icon-forward",
    "icon-fast-forward",
    "icon-step-forward",
    "icon-eject",
    "icon-chevron-left",
    "icon-chevron-right",
    "icon-plus-sign",
    "icon-minus-sign",
    "icon-remove-sign",
    "icon-ok-sign",
    "icon-question-sign",
    "icon-info-sign",
    "icon-screenshot",
    "icon-remove-circle",
    "icon-ok-circle",
    "icon-ban-circle",
    "icon-arrow-left",
    "icon-arrow-right",
    "icon-arrow-up",
    "icon-arrow-down",
    "icon-share-alt",
    "icon-resize-full",
    "icon-resize-small",
    "icon-plus",
    "icon-minus",
    "icon-asterisk",
    "icon-exclamation-sign",
    "icon-gift",
    "icon-leaf",
    "icon-fire",
    "icon-eye-open",
    "icon-eye-close",
    "icon-warning-sign",
    "icon-plane",
    "icon-calendar",
    "icon-random",
    "icon-comment",
    "icon-magnet",
    "icon-chevron-up",
    "icon-chevron-down",
    "icon-retweet",
    "icon-shopping-cart",
    "icon-folder-close",
    "icon-folder-open",
    "icon-resize-vertical",
    "icon-resize-horizontal",
    "icon-hdd",
    "icon-bullhorn",
    "icon-bell",
    "icon-certificate",
    "icon-thumbs-up",
    "icon-thumbs-down",
    "icon-hand-right",
    "icon-hand-left",
    "icon-hand-up",
    "icon-hand-down",
    "icon-circle-arrow-right",
    "icon-circle-arrow-left",
    "icon-circle-arrow-up",
    "icon-circle-arrow-down",
    "icon-globe",
    "icon-wrench",
    "icon-tasks",
    "icon-filter",
    "icon-briefcase",
    "icon-fullscreen",
);

        
        $data = maybe_unserialize(get_post_meta($post->ID,'heavenly_post_meta', true));
        if(is_array($data))
        $icon = $data['icon'];
        ?>
        <label for="icons">Icon:</label> 
        <select id="icons" name="heavenly_post_meta[icon]" type="text">
        <?php foreach($icons  as $class ){ $name = ucwords(trim(str_replace(array('icon','-'),' ',$class))); echo "<option value='{$class}' ".selected($class, $icon).">{$name}</option>"; } ?>
        </select>        
        <?php       
    
} 



function heavenly_save_meta_data($postid, $post){
       if(isset($_POST['heavenly_post_meta'])&&is_array($_POST['heavenly_post_meta'])){
        update_post_meta($postid, 'heavenly_post_meta',$_POST['heavenly_post_meta']);   
       }
}

//comments
function heavenly_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   $GLOBALS['comment'] = $comment;
    
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        ?>
    <li class="post pingback">
        <p>Pingback: <?php comment_author_link(); ?><?php edit_comment_link( 'Edit', '<span class="edit-link">', '</span>' ); ?></p>
    <?php
        break;
        default :
   ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">         
            <div class="comment-body">
               <div id="comment-<?php comment_ID(); ?>" class="clearfix media">
                    <div class="author-box pull-left">
                        <?php echo get_avatar($comment,100); ?>
                         
                    </div> <!-- end .avatar-box -->
                    <div class="comment-wrap clearfix media-body">                        
                        <div class="comment-meta commentmetadata">
                        <?php printf('<span class="fn">%s</span>', get_comment_author_link()) ?>
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <?php
                                /* translators: 1: date, 2: time */
                                printf(  '%1$s at %2$s', get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( '(Edit)', ' ' );
                            ?>
                        </div><!-- .comment-meta .commentmetadata -->

                        <?php if ($comment->comment_approved == '0') : ?>
                            <em class="moderation">Your comment is awaiting moderation.</em>
                            <br />
                        <?php endif; ?>

                        <div class="comment-content"><?php comment_text() ?></div> <!-- end comment-content-->
                        <div class="reply-container"><?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
                    </div> <!-- end comment-wrap-->
                    <div class="comment-arrow"></div>
                </div> <!-- end comment-body-->
            </div> <!-- end comment-body-->
         
 
<?php 
        break;
    endswitch;    
 }
 
 
 
 //Sidebars
 function heavenly_widget_init(){
     
    register_sidebar(array(
      'name' => 'Single Post',
      'id' => 'single_post_sidebar',
      'description' => 'Sidebar For Single post.',
      'before_widget' => '<div class="box widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));
        
     register_sidebar(array(
      'name' => 'Archive Page',
      'id' => 'archive_page_sidebar',
      'description' => 'Sidebar For Archive Page.',
      'before_widget' => '<div class="box widget box_yellow">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));    
       
    
    register_sidebar(array(
      'name' => 'Footer Left',
      'id' => 'footer1',
      'description' => 'Footer Left',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    )); 
    
    register_sidebar(array(
      'name' => 'Footer Middle',
      'id' => 'footer2',
      'description' => 'Footer Middle',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    )); 
    
    register_sidebar(array(
      'name' => 'Footer Right',
      'id' => 'footer3',
      'description' => 'Footer Right',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));  
    register_sidebar(array(
      'name' => 'Footer Last',
      'id' => 'footer4',
      'description' => 'Footer Last',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    )); 
 }
 
 // wp_title filter
 function heavenly_filter_wp_title( $old_title, $sep, $sep_location ){
    $ssep = ' ' . $sep . ' ';
    // find the type of index page this is
    if( is_category() ) $insert = $ssep . 'Category';
    elseif( is_tag() ) $insert = $ssep . 'Tag';
    elseif( is_author() ) $insert = $ssep . 'Author';
    elseif( is_year() || is_month() || is_day() ) $insert = $ssep . 'Archives';
    else $insert = NULL;
     
    // get the page number we're on (index)
    if( get_query_var( 'paged' ) )
    $num = $ssep . 'page ' . get_query_var( 'paged' );
     
    // get the page number we're on (multipage post)
    elseif( get_query_var( 'page' ) )
    $num = $ssep . 'page ' . get_query_var( 'page' );
     
    // else
    else $num = NULL;
    
    $site_description = get_bloginfo( 'description', 'display' );
    if ( is_home() && $site_description )
    $old_title .=  $ssep  . $site_description;
     
    // concoct and return new title
    return get_bloginfo( 'name' ) . $insert . $old_title . $num;
}
 
 
//Theme setup function 
function heavenly_setup(){
    register_nav_menus( array(
        'primary' => 'Top Menu' 
          
    ) );
    
    
    add_theme_support( 'post-thumbnails' );
    if(has_post_format('aside'))
    add_theme_support("post-formats");
    add_theme_support("automatic-feed-links");
    add_theme_support("excerpt",array('post','page'));
    add_theme_support('custom-background');
     
    add_image_size( 'heavenly-post-thumb', 960, 99999, false );
    add_image_size( 'heavenly-blog-thumb', 960, 300, true ); 
    add_image_size( 'heavenly-intro-thumb', 470, 200, true ); 
    add_image_size( 'heavenly-category-thumb', 270, 270, true ); 
 
 }
 
 function heavenly_enqueue_scripts(){
    wp_enqueue_style('heavenly-main',get_stylesheet_uri());                 
    wp_enqueue_script('heavenly-bootstrap',get_template_directory_uri().'/bootstrap/js/bootstrap.min.js',array('jquery'));
    wp_enqueue_script('heavenly-site',get_template_directory_uri().'/js/site.js',array('jquery'));
    wp_enqueue_script( 'comment-reply' ); 
 }

 

add_action( 'wp_enqueue_scripts', 'heavenly_enqueue_scripts');
//add_action("init","heavenly_save_theme_opt"); 
add_filter( 'wp_title', 'heavenly_filter_wp_title', 10, 3 );
add_action( 'widgets_init', 'heavenly_widget_init' );  
add_action( 'after_setup_theme', 'heavenly_setup' );  
add_action( 'admin_init', 'heavenly_meta_boxes', 0 );
add_action( 'save_post', 'heavenly_save_meta_data',10,2); 
