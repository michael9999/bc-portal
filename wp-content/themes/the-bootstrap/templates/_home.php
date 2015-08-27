<?php
/** _home.php
 *
 * Template Name: Home page
 *
 * @author 	Tom Brehm / InDaCloud
 * @package The Bootstrap
 * @since	1.3.0	- 29.04.2012
 */

get_header(); ?>

<div class="hero">
<section id="primary" class="container">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();
		
		the_post();
		tha_entry_before(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php tha_entry_top(); ?>
			
			<div class="entry-content clearfix">
				<?php
				the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'the-bootstrap' ) );
				the_bootstrap_link_pages(); ?>
			</div><!-- .entry-content -->
			<?php edit_post_link( __( 'Edit', 'the-bootstrap' ), '<footer class="entry-meta"><span class="edit-link label">', '</span></footer>' );
			
			tha_entry_bottom(); ?>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php tha_entry_after();

				
		tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->
</div>
<section id="secondary" class="container">
	<div class="row">
		<?php dynamic_sidebar( 'home' ); ?>
	</div>
</section>
<div class="container">
	<div class="row">
<?php
get_footer();

?>
	</div>
</div>
<?php

/* End of file _home.php */
/* Location: ./wp-content/themes/the-bootstrap/_home.php */