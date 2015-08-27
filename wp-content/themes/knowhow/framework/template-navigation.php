<?php

/**
 * Display navigation to next/previous pages when applicable
 */
if ( ! function_exists( 'st_content_nav' ) ):
function st_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'framework' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'framework' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'framework' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'framework' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'framework' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


/**
 * Pagination
 */
function st_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


/**
 * Breadcrumbs
 */
function st_breadcrumb() {
	//global WordPress variable $post. Needed to display multi-page navigations.
    global $post, $cat;    
	
$sep = '<span class="sep">/</span>';
if (!is_front_page()) {  
echo '<div id="breadcrumbs">';

//Home Link
echo '<a href="' . home_url() . '"><icon class="icon-home"></i></a>' . $sep;   
	
	
//Category
if (is_category()) {
	echo get_category_parents($cat, true,' ' . $sep . ' ');

} elseif ( 'st_faq' == get_post_type() ) {
// FAQ Archive			
	$st_faq_data = get_post_type_object('st_faq');
	echo $st_faq_data->labels->name;	 

} elseif ( is_single() && 'st_faq' != get_post_type() ) {
//Single Post	

$terms = wp_get_post_terms( $post->ID , 'category');
	
$visited = array();

foreach($terms as $term) {
	
if ($term->parent != 0) { 
	echo get_category_parents($term->term_id, true,' ' . $sep . ' ', false, $visited );
} else {
	echo '<a href="' . esc_attr(get_term_link($term, 'category')) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '>' . $term->name.'</a> ';
	echo $sep;
	$visited[] = $term->term_id;
}

} // End foreach
echo get_the_title();

} else {
	//Display the post title.
	echo get_the_title();
}
	
echo '</div>';	
} //is_front_page
}


/**
 * Breadcrumbs (legacy)
 */
function st_legacy_breadcrumb() {
    //Variable (symbol >> encoded) and can be styled separately.
    //Use >> for different level categories (parent >> child >> grandchild)
    $delimiter = '<span class="sep"> / </span>';
    //Use bullets for same level categories ( parent . parent )
    $delimiter1 = '<span class="delimiter1"> &bull; </span>';
     
    //text link for the 'Home' page
            $main = '<icon class="icon-home"></i>';
    //Display only the first 30 characters of the post title.
            $maxLength= 30;
     
    //variable for archived year
    $arc_year = get_the_time('Y');
    //variable for archived month
    $arc_month = get_the_time('F');
    //variables for archived day number + full
    $arc_day = get_the_time('d');
    $arc_day_full = get_the_time('l'); 
     
    //variable for the URL for the Year
    $url_year = get_year_link($arc_year);
    //variable for the URL for the Month   
    $url_month = get_month_link($arc_year,$arc_month);
 
    /*is_front_page(): If the front of the site is displayed, whether it is posts or a Page. This is true
    when the main blog page is being displayed and the 'Settings > Reading ->Front page displays'
    is set to "Your latest posts", or when 'Settings > Reading ->Front page displays' is set to
    "A static page" and the "Front Page" value is the current Page being displayed. In this case
    no need to add breadcrumb navigation. is_home() is a subset of is_front_page() */
     
    //Check if NOT the front page (whether your latest posts or a static page) is displayed. Then add breadcrumb trail.
    if (!is_front_page()) {        
        //If Breadcrump exists, wrap it up in a div container for styling.
        //You need to define the breadcrumb class in CSS file.
        echo '<div id="breadcrumbs">';
         
        //global WordPress variable $post. Needed to display multi-page navigations.
        global $post, $cat;        
        //A safe way of getting values for a named option from the options database table.
        $homeLink = home_url(); //same as: $homeLink = get_bloginfo('url');
        //If you don't like "You are here:", just remove it.
        echo '<a href="' . $homeLink . '">' . $main . '</a>' . $delimiter;   
         
		if ( is_post_type_archive() ) {
		
		$st_faq_data = get_post_type_object('st_faq');
		echo $st_faq_data->labels->name;
		
		} elseif ( 'st_faq' == get_post_type() ) {
			
			$st_faq_data = get_post_type_object('st_faq');
			echo $st_faq_data->labels->name;
		
        //Display breadcrumb for single post
		} elseif (is_single() && 'st_faq' != get_post_type()) { //check if any single post is being displayed.          
            //Returns an array of objects, one object for each category assigned to the post.
            //This code does not work well (wrong delimiters) if a single post is listed
            //at the same time in a top category AND in a sub-category. But this is highly unlikely.
            $category = get_the_category();
            $num_cat = count($category); //counts the number of categories the post is listed in.
             
            //If you have a single post assigned to one category.
            //If you don't set a post to a category, WordPress will assign it a default category.
			if( $num_cat == 0 ) {

			} elseif ($num_cat <=1)  //I put less or equal than 1 just in case the variable is not set (a catch all).
            {				
				is_wp_error( $cat_parents = get_category_parents($cat, TRUE, '' . $delimiter . '') ) ? '' : $cat_parents;
				
                //Display the full post title.
                echo get_the_title();
            }
            //then the post is listed in more than 1 category. 
            else {
                //Put bullets between categories, since they are at the same level in the hierarchy.
                echo the_category( $delimiter1, 'multiple');
                    //Display partial post title, in order to save space.
                    if (strlen(get_the_title()) >= $maxLength) { //If the title is long, then don't display it all.
                        echo $delimiter . trim(substr(get_the_title(), 0, $maxLength)) . ' ...';
                    }                        
                    else { //the title is short, display all post title.
                        echo $delimiter . get_the_title();
                    }
            }          
        }
        //Display breadcrumb for category and sub-category archive
        elseif (is_category()) { //Check if Category archive page is being displayed.
            //returns the category title for the current page.
            //If it is a subcategory, it will display the full path to the subcategory.
            //Returns the parent categories of the current category with links separated by '»'
            echo get_category_parents($cat, true,' ' . $delimiter . ' ');
        }      
        //Display breadcrumb for tag archive       
        elseif ( is_tag() ) { //Check if a Tag archive page is being displayed.
            //returns the current tag title for the current page.
            echo single_tag_title("", false);
        }       
        //Display breadcrumb for calendar (day, month, year) archive
        elseif ( is_day()) { //Check if the page is a date (day) based archive page.
            echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . ' ';
            echo '<a href="' . $url_month . '">' . $arc_month . '</a> ' . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
        }
        elseif ( is_month() ) {  //Check if the page is a date (month) based archive page.
            echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . $arc_month;
        }
        elseif ( is_year() ) {  //Check if the page is a date (year) based archive page.
            echo $arc_year;
        }      
        //Display breadcrumb for search result page
        elseif ( is_search() ) {  //Check if search result page archive is being displayed.
            echo 'Search Results for: "' . get_search_query() . '"';
        }      
        //Display breadcrumb for top-level pages (top-level menu)
        elseif ( is_page() && !$post->post_parent ) { //Check if this is a top Level page being displayed.
            echo get_the_title();
        }          
        //Display breadcrumb trail for multi-level subpages (multi-level submenus)
        elseif ( is_page() && $post->post_parent ) {  //Check if this is a subpage (submenu) being displayed.
            //get the ancestor of the current page/post_id, with the numeric ID
            //of the current post as the argument.
            //get_post_ancestors() returns an indexed array containing the list of all the parent categories.               
            $post_array = get_post_ancestors($post);
             
            //Sorts in descending order by key, since the array is from top category to bottom.
            krsort($post_array);
             
            //Loop through every post id which we pass as an argument to the get_post() function.
            //$post_ids contains a lot of info about the post, but we only need the title.
            foreach($post_array as $key=>$postid){
                //returns the object $post_ids
                $post_ids = get_post($postid);
                //returns the name of the currently created objects
                $title = $post_ids->post_title;
                //Create the permalink of $post_ids
                echo '<a href="' . get_permalink($post_ids) . '">' . $title . '</a>' . $delimiter;
            }
            the_title(); //returns the title of the current page.              
        }          
        //Display breadcrumb for author archive  
        elseif ( is_author() ) {//Check if an Author archive page is being displayed.
            global $author;
            //returns the user's data, where it can be retrieved using member variables.
            $user_info = get_userdata($author);
            echo  $user_info->display_name;
        }      
        //Display breadcrumb for 404 Error
        elseif ( is_404() ) {//checks if 404 error is being displayed

        }      
        else {
            //All other cases that I missed. No Breadcrumb trail.
        }
       echo '</div>';    
    } 
}


/**
 * The formatted output of a list of pages.
 */
add_action( 'numbered_in_page_links', 'numbered_in_page_links', 10, 1 );

/**
 * Modification of wp_link_pages() with an extra element to highlight the current page.
 *
 * @param  array $args
 * @return void
 */
function numbered_in_page_links( $args = array () )
{
    $defaults = array(
        'before'      => '<p>' . __('Pages:', 'framework')
    ,   'after'       => '</p>'
    ,   'link_before' => ''
    ,   'link_after'  => ''
    ,   'pagelink'    => '%'
    ,   'echo'        => 1
        // element for the current page
    ,   'highlight'   => 'span'
    );

    $r = wp_parse_args( $args, $defaults );
    $r = apply_filters( 'wp_link_pages_args', $r );
    extract( $r, EXTR_SKIP );

    global $page, $numpages, $multipage, $more, $pagenow;

    if ( ! $multipage )
    {
        return;
    }

    $output = $before;

    for ( $i = 1; $i < ( $numpages + 1 ); $i++ )
    {
        $j       = str_replace( '%', $i, $pagelink );
        $output .= ' ';

        if ( $i != $page || ( ! $more && 1 == $page ) )
        {
            $output .= _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>";
        }
        else
        {   // highlight the current page
            // not sure if we need $link_before and $link_after
            $output .= "<$highlight>{$link_before}{$j}{$link_after}</$highlight>";
        }
    }

    print $output . $after;
}