<?php
	$s = '';
	if ( get_query_var( 's' ) != '' ) { $s = get_query_var( 's' ); }
?>
<section id="advanced-search-form">
<h1><?php _e( 'Search the Wiki', 'woothemes' ); ?></h1>
<form name="advanced-search-form" method="get" action="<?php echo home_url( '/' ); ?>" class="auto-complete" autocomplete="off">
	<input type="text" class="input-text input-txt" name="s" id="s" value="<?php echo esc_attr( $s ); ?>" />
	<button type="submit" class="adv-button"><?php _e( 'Search', 'woothemes' ); ?></button>
</form>
</section>