<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta content="width=device-width,minimum-scale=1,maximum-scale=1" name="viewport">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<title>
<?php wp_title('-', true, 'right'); ?>
<?php bloginfo('name'); ?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- #site-container -->
<div id="site-container" class="clearfix">

<!-- #primary-nav-mobile -->
<nav id="primary-nav-mobile">
<a class="menu-toggle clearfix" href="#"><i class="icon-reorder"></i></a>
<?php wp_nav_menu( array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'clearfix', 'menu_id' => 'mobile-menu', )); ?>
</nav>
<!-- /#primary-nav-mobile -->

<!-- #header -->
<header id="site-header" class="clearfix" role="banner">
<div class="container">

<!-- #logo -->
  <div id="logo">
    <?php if (is_front_page()) { ?><h1><?php } ?>
      <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>">
      <?php if (of_get_option('st_logo')) { ?>
      <img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo of_get_option('st_logo'); ?>">
      <?php } else { ?>
      <?php bloginfo( 'name' ); ?>
      <?php } ?>
      </a>
     <?php if (is_front_page()) { ?></h1><?php } ?>
  </div>
<!-- /#logo -->
<!-- #primary-nav -->
<nav id="primary-nav" role="navigation" class="clearfix">
  <?php if ( has_nav_menu( 'primary-nav' ) ) { ?>
    <?php wp_nav_menu( array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'nav sf-menu clearfix' )); ?>
  <?php } ?>
  </nav>
<!-- #primary-nav -->

</div>
</header>
<!-- /#header -->

<!-- #live-search -->
    <div id="live-search">
    <div class="container">
    <div id="search-wrap">
      <form role="search" method="get" id="searchform" class="clearfix" action="<?php echo home_url( '/' ); ?>">
        <input type="text" onfocus="if (this.value == '<?php echo of_get_option('st_search_text'); ?>') {this.value = '';}" onblur="if (this.value == '')  {this.value = '<?php echo of_get_option('st_search_text'); ?>';}" value="<?php echo of_get_option('st_search_text'); ?>" name="s" id="s" autocapitalize="off" autocorrect="off" autocomplete="off" />
        <i class="live-search-loading icon-spinner icon-spin"></i>
        <button type="submit" id="searchsubmit">
                <i class='icon-search'></i><span><?php _e("Search", "framework") ?></span>
            </button>
      </form>
      </div>
    </div>
    </div>
<!-- /#live-search -->