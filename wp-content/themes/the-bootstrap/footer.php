<?php
/** footer.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */

				?>

				<?php
				tha_footer_before(); ?>
				<footer id="colophon" role="contentinfo" class="span12">
					<?php tha_footer_top(); ?>
					<div id="page-footer" class="clearfix row-fluid">
						
						<div id="page-footer-1" class="span3">
							<?php dynamic_sidebar( 'footer_1' ); ?>
						</div>
						<div id="page-footer-2" class="span3">
							<?php dynamic_sidebar( 'footer_2' ); ?>
						</div>
						<div id="page-footer-3" class="span3">
							<?php dynamic_sidebar( 'footer_3' ); ?>
						</div>
						<div id="page-footer-4" class="span3">
							<?php dynamic_sidebar( 'footer_4' ); ?>
						</div>

					</div><!-- #page-footer .clearfix -->
					<?php tha_footer_bottom(); ?>
				</footer><!-- #colophon -->
				<?php tha_footer_after(); ?>
			</div></div>
			</div><!-- #page -->
		</div><!-- .container -->
	<!-- <?php printf( __( '%d queries. %s seconds.', 'the-bootstrap' ), get_num_queries(), timer_stop(0, 3) ); ?> -->
	<?php wp_footer(); ?>
	</body>
</html>
<?php


/* End of file footer.php */
/* Location: ./wp-content/themes/the-bootstrap/footer.php */