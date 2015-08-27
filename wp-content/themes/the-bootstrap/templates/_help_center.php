<?php
/** _help_center.php
 *
 * Template Name: Help Center
 *
 * @author 	Tom Brehm / InDaCloud
 * @package The Bootstrap
 * @since	1.3.0	- 29.04.2012
 */

get_header(); ?>

<section id="primary" class="span9">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();
		
		the_post();
		
		//	find the top level page
		
		$top_level_id = get_the_ID();
		$level1_id = get_the_ID();
		$ancestors = get_ancestors( get_the_ID(), 'page');
		
		if(is_array($ancestors)){
			if(count($ancestors)>=1)
				$top_level_id = $ancestors[count($ancestors)-1]	;
			if(count($ancestors)>=2)
				$level1_id = $ancestors[count($ancestors)-2];			
		}
		
		
		echo the_breadcrumbs();

		$args = array(
			'sort_order' => 'ASC',
			'sort_column' => 'menu_order',
			'hierarchical' => 0,
			'parent' => $top_level_id,
			'post_type' => 'page',
			'post_status' => 'publish'
		); 
		$siblings = get_pages($args); 

		?>
		<div class="content-help row-fluid">
			<div class="content-left span3">
				<ul class="nav">
			<?php

				foreach ($siblings as $index => $sibling) {
					
					$active = ($sibling->ID == $level1_id)?'active':'';
					$icon = get_post_meta( $sibling->ID, '_custom_icon', true );
					if($icon)
						$icon_tag = '<i class="'.$icon.'"></i> ';
					else
						$icon_tag = '';
					?>
					<li class="<?php echo $active; ?>"><a href="<?php echo get_permalink($sibling->ID) ?>"><?php echo $icon_tag . get_the_title($sibling->ID); ?></a></li>
					<?php
				}

			?>
				</ul>
			</div>
			<div class="content-right span9">
				

				<?php 
				
				$args = array(
					'sort_order' => 'ASC',
					'sort_column' => 'menu_order',
					'hierarchical' => 0,
					'parent' => get_the_ID(),
					'post_type' => 'page',
					'post_status' => 'publish'
				); 
				$childrens = get_pages($args);
				if(count($childrens) > 0){
					?>
					<header class="page-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
					<div class="parent-content">
						<?php the_content( ); ?>
					</div> 

					<ul class="childrens">
					<?php
					foreach ($childrens as $children) {
						?>
						<li class="child"><a href="<?php echo get_permalink($children->ID) ?>"><?php echo get_the_title( $children->ID ); ?></a></li>
						<?php
					}
					?>
					</ul>
					<?php
				}
				else
					get_template_part( '/partials/content', 'page' );
				
				 ?>
			</div>
		</div>
		<?php
		
		tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php

get_sidebar(  );
get_footer();

?>
	</div>
</div>
<?php

/* End of file _help_center.php */
/* Location: ./wp-content/themes/the-bootstrap/_help_center.php */