<?php get_header(); ?>     
<div class="container">
<div class="row-fluid">
<div class="span8">
<div  id="post-<?php the_ID(); ?>" <?php post_class(); ?>>         
<?php 

while(have_posts()): the_post(); ?>
 
<div  <?php post_class('post'); ?>>
<div class="breadcrumb">Posted on <?php the_date(); ?> / Posted by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>
<nav id="nav-single"> 
                        <?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> Previous Post'); ?>
                        <?php next_post_link( '%link', 'Next Post<span class="meta-nav">&rarr;</span>' ); ?>
</nav>
</div>
<div class="clear"></div>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
<?php heavenly_post_thumb('edenfresh-responsive-post-thumb'); ?>  
<?php the_content(); ?>
</div>
<?php wp_link_pages( ); ?>

<div class="well tags">
<b><span>Post Tags</span><div class="spc"></div></b>
<?php the_tags('',', '); ?>
<div class="clear"></div>
</div>

<div class="well author-box">
 
 <div class="media">
 <div class="pull-left">
 <?php echo get_avatar( get_the_author_meta('ID'), 90 ); ?>
 </div>
 <div class="media-body">  <span class="txt">
 <b><i class="icon icon-edit"></i> About Author: <?php echo get_the_author_meta('display_name'); ?></b>
 </span>
 <div class="clear"></div>
 <?php echo get_the_author_meta('description'); ?>
 </div>
 </div>
 </div>

</div>
 <div class="mx_comments"> 
<?php comments_template(); ?>
</div>
<?php endwhile; ?>
</div>
</div>
<div class="span4">
<div class="sidebar"> 
<?php dynamic_sidebar('Single Post'); ?>
</div>
</div>
</div>
</div>

         

<?php get_footer(); ?>
