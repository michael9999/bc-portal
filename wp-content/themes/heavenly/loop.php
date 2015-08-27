<div class="row-fluid">
    <div class="span12">

        <?php
        while(have_posts()): the_post(); ?>
            <div  <?php post_class('post box arc media'); ?>>
                <?php if(has_post_thumbnail()): ?>
                <a href="" class="pull-left thumbnail"><?php heavenly_post_thumb(array(200,200)); ?></a>
                <?php endif; ?>
                <div class="media-body">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2>
                <div class="entry-content"><?php the_excerpt(); ?>
                </div>
                </div>
            </div>
            <div class="breadcrumb mt5">Posted on <?php echo get_the_date(); ?> / Posted by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> / <a href="<?php the_permalink();?>">read more &#187;</a></div>
        <?php endwhile; ?>

        <?php
        global $wp_query;
        if (  $wp_query->max_num_pages > 1 ) : ?>
            <div class="clear"></div>
            <div id="nav-below" class="navigation post box arc breadcrumb">
                <div class="btn"><?php previous_posts_link(  '<i class="icon icon-chevron-left"></i> Previous'  ); ?></div>
                <div class="btn next-link"><?php next_posts_link( 'Next <i class="icon icon-chevron-right"></i>'  ); ?></div>
                <div class="clear"></div>
            </div><!-- #nav-below -->
        <?php endif; ?>

    </div>

</div>