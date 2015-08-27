<?php
/**
 * Enqueues styles for front-end.
 */
function st_theme_styles() {
	global $wp_styles;

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
		
	/*
	 * Loads our Google Font.
	 */
	 
	$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'framework' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400,400italic,600,700',
			'subset' => $subsets,
		);
	wp_enqueue_style( 'theme-font', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );

	
	/*
	* Add font awesome CSS
	*/
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array('theme-style') );
	wp_enqueue_style( 'font-awesome-ie7', get_template_directory_uri() . '/css/font-awesome-ie7.min.css', array('font-awesome')  );
    $wp_styles->add_data( 'font-awesome-ie7', 'conditional', 'lte IE 7' );
	
	
	/*
	* Adds stylesheet for shortcodes
	* (will be mvoed to plugin soon)
	*/
	wp_enqueue_style( 'shortcodes', get_template_directory_uri() . '/framework/shortcodes/shortcodes.css' );
	
	
	/*
	* Load theme custom colors
	*/
	
	$st_nav_top = '';
	if (of_get_option('st_logo')) {
		$st_theme_logo = of_get_option('st_logo');
		list($st_theme_logo_width, $st_theme_logo_height) = getimagesize($st_theme_logo);
		$st_nav_top = $st_theme_logo_height / 2 - 10;
	}

	$theme_custom_css = ' 
				/* Links */
				a, 
				a:visited { color:'. of_get_option('st_link_color') .'; }
				a:hover, 
				.widget a:hover,
				#primary-nav ul a:hover,
				#footer-nav a:hover,
				#breadcrumbs a:hover { color:'. of_get_option('st_link_color_hover') .'; }
				
				/* Theme Color */
				#commentform #submit, 
				.st_faq h2.active .action, 
				.widget_categories ul span, 
				.pagination .current, 
				.tags a, 
				.page-links span,
				#comments .comment-meta .author-badge,
				input[type="reset"],
				input[type="submit"],
				input[type="button"] { background: '. of_get_option('st_theme_color') .'; }
				#live-search #searchsubmit, input[type="submit"] { background-color: '. of_get_option('st_theme_color') .'; }
				.tags a:before { border-color: transparent '. of_get_option('st_theme_color') .' transparent transparent; }
				#primary-nav { top: '. $st_nav_top .'px; }

				'. of_get_option('st_custom_css') .'
				
				';
				
	wp_add_inline_style('theme-style',$theme_custom_css);
	
	
}
add_action( 'wp_enqueue_scripts', 'st_theme_styles' );
