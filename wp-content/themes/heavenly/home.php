<?php 

if ( !defined('ABSPATH')) exit; 

 

get_header(); 

?>


<div class="container">
    <?php  if('posts' == get_option( 'show_on_front' )&&!heavenly_get_theme_opts('heavenly_home')) :  ?>
        <div class="row-fluid">
        <div class="span9">
        <?php        get_template_part('loop'); ?>
        </div>
        <div class="span3">
            <?php if(!dynamic_sidebar('homepage_sidebar')) echo "<div class='box widget'><h3><span>Categories</span></h3><ul>";wp_list_categories('title_li=&hide_empty=0'); echo "</ul></div>"; ?>
        </div>
        </div>
    <?php else:   ?>

    <div class="row-fluid">
        <div class="span12">
            <div class="bqwrap">
            <blockquote class="light">
            <div class="row-fluid">
            <div class="span9">
                <h3><?php echo esc_attr(heavenly_get_theme_opts('home_featured_title','Welcome to Simply Clean')); ?></h3>
                <?php
                     echo esc_attr(heavenly_get_theme_opts('home_featured_desc','Fully responsive, clean looking WordPress Theme'));
                 ?> 
          </div> 
          <div class="span3">    
                <a href="<?php echo esc_url(heavenly_get_theme_opts('home_featured_btnurl','#')); ?>" class="btn btn-large btn-info pull-right"><?php echo esc_attr(heavenly_get_theme_opts('home_featured_btntxt','Get It Now!')); ?></a>
          </div>    
          </div>
            </blockquote> 
            </div>
        </div>
    </div>
 
    <div class="row-fluid">
    
     <?php for($i=1;$i<=4;$i++): ?>
        <div class="span3">
        <?php $tpid = (int)heavenly_get_theme_opts('home_featured_page_'.$i); $intropage = get_page($tpid); $meta = get_post_meta($tpid,'heavenly_post_meta',true); if(!$meta) $meta = array('excerpt'=>'','icon'=>'icon-leaf'); $introcontent = $meta['excerpt']; ?>
        <div class="service-box">
          <div class="entry-content">
          <h3><span class="service-icon"><i class="icon icon-white <?php echo $meta['icon']; ?>"></i></span> <a href="<?php echo get_permalink($tpid); ?>"><?php echo esc_attr($intropage->post_title); ?></a><div class="clear"></div></h3>
          <p><?php echo esc_attr($introcontent); ?></p>
          </div>
        </div>  
        </div>
        
     <?php endfor; ?>
     
    </div> <br>
    <div class="row-fluid">
    
     <?php for($i=5;$i<=8;$i++): ?>
        <div class="span3">
        <?php $tpid = (int)esc_attr(heavenly_get_theme_opts('home_featured_page_'.$i)); $intropage = get_page($tpid); $meta = get_post_meta($tpid,'heavenly_post_meta',true); if(!$meta) $meta = array('excerpt'=>'','icon'=>'icon-leaf'); $introcontent = $meta['excerpt']; ?>
        <div class="service-box">
          <div class="entry-content">
          <h3><span class="service-icon"><i class="icon icon-white <?php echo esc_attr($meta['icon']); ?>"></i></span> <a href="<?php echo esc_url(get_permalink($tpid)); ?>"><?php echo esc_attr($intropage->post_title); ?></a><div class="clear"></div></h3>
          <p><?php echo esc_attr($introcontent); ?></p>
          </div>
        </div>  
        </div>
        
     <?php endfor; ?>
     
    </div>
    
    <br>
        
        <!-- /.span4 -->
      
        <?php get_template_part('homepage','category'); ?>

    <?php  endif; ?>
 
<div class="clear"></div>
         

</div><!-- /.span4 -->
         
 

        
<?php get_footer(); ?>
