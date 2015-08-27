<?php
global $loaded_profile;
global $table_prefix;
if ( $this->is_valid_licence() ) {
	?>
	<div class="option-section multisite-tools-options">

		<label class="multisite-tools checkbox-label" for="multisite-subsite-export">
			<input type="checkbox" name="multisite_subsite_export" value="1" data-available="1" id="multisite-subsite-export"<?php echo( isset( $loaded_profile['multisite_subsite_export'] ) ? ' checked="checked"' : '' ); ?> />
			<?php _e( 'Export a subsite as a single site install', 'wp-migrate-db-pro-multisite-tools' ); ?>
		</label>

		<div class="indent-wrap expandable-content">
			<select name="select_subsite" class="select-subsite" id="select-subsite" autocomplete="off">
				<?php
				printf(
					'<option value="">%1$s</option>',
					esc_html( '-- ' . __( 'Select a subsite', 'wp-migrate-db-pro-multisite-tools' ) . ' --' )
				);
				foreach ( wp_get_sites( array( 'limit' => 0 ) ) as $subsite ) :
					$blog_id = ( ! empty( $subsite['blog_id'] ) ) ? $subsite['blog_id'] : '';
					$subsite_path = untrailingslashit( $this->scheme_less_url( get_blogaddress_by_id( $blog_id ) ) );

					$selected = '';
					if ( ! empty( $loaded_profile['select_subsite'] ) && $blog_id == $loaded_profile['select_subsite'] ) {
						$selected = ' selected="selected"';
					}
					printf(
						'<option value="%1$s"' . $selected . '>%2$s</option>',
						esc_attr( $blog_id ),
						esc_html( $subsite_path )
					);
				endforeach;
				?>
			</select>

			<div class="new-prefix-field">
				<label><?php echo esc_html( __( 'New Table Name Prefix', 'wp-migrate-db-pro-multisite-tools' ) ) . ':'; ?>
				<input type="text" id="new-prefix" size="15" name="new_prefix" class="code" placeholder="<?php echo esc_attr( __( 'New Prefix', 'wp-migrate-db-pro-multisite-tools' ) ); ?>" value="<?php echo esc_attr( ! empty( $loaded_profile['new_prefix'] ) ? $loaded_profile['new_prefix'] : $table_prefix ); ?>" autocomplete="off"/></label>
			</div>
		</div>
	</div>
<?php
}
