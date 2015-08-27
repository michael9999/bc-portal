<?php 
//Template Name: Portfolio Page 4 cols
get_header(); ?>    
       
            
<div class="container">
<div class="row-fluid">
<div class="span12"><h1 class="text-center section-head"><span class='bgwhite'><?php the_post(); the_title(); ?></span></h1> </div>
</div>
<div id="portfolio-page" <?php post_class('row-fluid edenfresh-portfolio-4col thumbnails'); ?>>
 
 
<?php 
query_posts('post_type=portfolio&posts_per_page=12&paged='.get_query_var('paged'));
while(have_posts()): the_post(); ?> 

<div class="span3 tbox">
<div class="thumbnail">         
          <?php heavenly_post_thumb(array(300,200)); ?> 
          <div class="text-center">
          <h2><?php the_title(); ?></h2>
          <div class="det"> 
          <a rel="lightbox" href="<?php echo heavenly_post_thumb_url(); ?>" class="btn btn-primary"><i class="icon icon-white icon-search"></i></a> 
          <a href="<?php the_permalink(); ?>" class="btn btn-success"><i class="icon icon-white icon-arrow-right"></i></a> 
          </div>
          </div>
</div>         
</div>

<?php endwhile; ?>   
<div class="clear"></div>            
  
</div>
 
<?php 
global $wp_query;
if (  $wp_query->max_num_pages > 1 ) : ?>
<div class="clear"></div>
                <div id="nav-below" class="navigation post box arc">
                    <?php get_template_part('pagination'); ?>
                </div><!-- #nav-below -->
<?php endif; ?>

</div>
 
 
      
<?php get_footer(); ?>
