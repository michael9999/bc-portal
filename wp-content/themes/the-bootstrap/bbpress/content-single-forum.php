<?php

/**
 * Single Forum Content Part
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

		<?php do_action( 'bbp_template_before_single_forum' ); ?>

		<?php if ( post_password_required() ) : ?>

			<?php bbp_get_template_part( 'form', 'protected' ); ?>

		<?php else : ?>

			<?php bbp_single_forum_description(); ?>

			<?php if ( bbp_has_forums() ) : ?>

				<?php bbp_get_template_part( 'loop', 'forums' ); ?>

			<?php endif; ?>

			<?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

				<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

				<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

				<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

				<?php bbp_get_template_part( 'form',       'topic'     ); ?>

			<?php elseif ( !bbp_is_forum_category() ) : ?>

				<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

				<?php bbp_get_template_part( 'form',       'topic'     ); ?>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_template_after_single_forum' ); ?>

	</div>
	</div><!-- .padder -->
</div><!-- #primary -->
