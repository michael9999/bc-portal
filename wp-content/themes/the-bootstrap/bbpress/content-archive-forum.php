<?php

/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="content" class="row-fluid">
	<div class="padder">
	<div class="row-fluid">
		<div class="span12">
			<?php bbp_breadcrumb(); ?>
		</div>
	</div>

	<div class="span3" id="bp-menu">
		<?php 
		$defaults = array(
			'theme_location'  => 'buddypress-menu',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);

		wp_nav_menu( $defaults );
		 ?>
	</div>
	<div id="bbpress-forums" class="page span9">

		<div class="bbp-search-form">

			<?php bbp_get_template_part( 'form', 'search' ); ?>

		</div>

		<?php do_action( 'bbp_template_before_forums_index' ); ?>

		<?php if ( bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop',     'forums'    ); ?>

		<?php else : ?>

			<?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_template_after_forums_index' ); ?>

	</div>
	</div><!-- .padder -->
</div><!-- #primary -->
