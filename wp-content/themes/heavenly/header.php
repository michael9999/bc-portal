<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
 <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet/less" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style.less" />
    <script src="<?php echo get_template_directory_uri(); ?>/js/less.js" type="text/javascript"></script>
    <script type="text/javascript">
        less.modifyVars({
            '@color': '<?php echo heavenly_get_theme_opts('color_scheme','#3399ff'); ?>'
        });
    </script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

 
     
<!-- NAVBAR
    ================================================== -->
    <div class="navbar-wrapper">
      <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
      <div class="nav-area">
      <div class="container">

        <div class="navbar">
          <div class="navbar-inner clean">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><?php heavenly_logo(); ?></a>
            <div class="nav-collapse collapse">
              <?php

     
                        $args = array(
                        'theme_location' => 'primary',
                        'depth' => 3,
                        'container' => false,
                        'menu_class' => 'nav',
                        'fallback_cb' => false,
                        'walker' => new heavenly_bootstrap_walker_nav_menu()
                        );

                         
                        wp_nav_menu($args);

                         
                        ?>
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

      </div> <!-- /.container -->
     </div> 
      <?php if(is_archive()): ?>
      <div class="container">
      <div class="row-fluid"><div class="span12 arc-header">
      <h1 class="entry-title">
                        <?php if ( is_day() ) : ?>                            
                        <?php echo get_the_date(); ?>    
                        <?php elseif ( is_month() ) : ?>
                        Monthly Archives: <?php echo get_the_date( 'F Y' ); ?>                        
                        <?php elseif ( is_year() ) : ?>
                        <?php echo get_the_date( 'Y' ); ?>                            
                        <?php elseif(is_category()) : ?>
                        <?php echo single_cat_title( '', false ); ?>
                        <?php elseif(is_tag()) : ?> 
                        <?php echo single_tag_title(); ?>
                        <?php else : the_post(); ?> 
                        <?php echo get_the_author(); ?>
                        <?php rewind_posts(); endif; ?>
      </h1>
      </div></div></div>
      <?php endif; ?>
      
      <?php
          if(is_front_page()) get_template_part('homepage','top');
      ?>
      
    </div><!-- /.navbar-wrapper -->
        
