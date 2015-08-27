<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Author Archives - Filter Query To Retrieve Different Statuses And Types
- Author Archives - Determine The Label For A Contribution
- Author Archives - Get Array of User Data
- Author Archives - Get The Social Icons
- Author Archives - Get The Author Info Box
- Author Archives - Add Custom Fields to User Profile Admin Screens
- Author Archives - Save Custom Fields from User Profile Admin Screens
- Author Archives - Setup Field Groups and Fields For User Profile Admin Screens
- Author Archives - Add Custom Contact Methods

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Filter Query To Retrieve Different Statuses And Types */
/*-----------------------------------------------------------------------------------*/

add_filter( 'pre_get_posts', 'woo_filter_author_archive_query', 10 );

if ( ! function_exists( 'woo_filter_author_archive_query' ) ) {
	function woo_filter_author_archive_query ( $query ) {
		if ( ! $query->is_admin && $query->is_author ) {
			$query->set( 'post_type', array( 'post', 'revision', 'attachment', 'page' ) );
			$query->set( 'post_status', array( 'publish' ) );
			$query->set( 'posts_per_page', '30' );
			$query->set( 'orderby', 'post_date' );
			$query->set( 'order', 'DESC' );
			$query->parse_query();
		}
	
		return $query;
	} // End woo_filter_author_archive_query()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Determine The Label For A Contribution */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_get_contribution_label' ) ) {
	function woo_get_contribution_label ( $type, $status, $title ) {
		switch ( $type ) {
			case 'post':
				$label = __( 'Posted', 'woothemes' ) . ' ' . $title;
			break;
			
			case 'revision':
				$label = __( 'Revised', 'woothemes' ) . ' ' . $title;
			break;
			
			case 'attachment':
				$label = __( 'Uploaded', 'woothemes' ) . ' ' . $title;
			break;
			
			case 'page':
				$label = sprintf( __( 'Created the &quot;%s&quot; page', 'woothemes' ), $title );
			break;
			
			default:
			$label = __( 'Added', 'woothemes' ) . ' ' . $title;
			break;
			
			do_action( 'woo_get_contribution_label', $type, $status );
		}
		
		return apply_filters( 'woo_contribution_label', $label, $type, $status );
	} // End woo_get_contribution_label()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Get Array of User Data */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_get_user_data' ) ) {
	function woo_get_user_data ( $author ) {
		if ( ! is_numeric( $author ) ) { return array(); }
		
		$data = array();
		
		// Array of fields to retrieve.
		$fields = array( 'email', 'display_name', 'user_description', 'facebook', 'twitter', 'byline', 'gender', 'location', 'timezone' );
		
		$field_settings = array();
		$field_data = woo_get_profile_fields_settings();
		
		foreach ( $field_data['fields'] as $k => $v ) {
			foreach ( $v as $i => $j ) {
				$field_settings[$j['id']] = $j;
			}
		}
		
		$value = '';
		
		foreach ( $fields as $k => $v ) {
			$value = get_the_author_meta( $v, $author );
			if ( $value != '' ) {
				$data[$v] = $value;
				
				if ( isset( $field_settings[$v]['options'][$value] ) ) {
					$data[$v] = $field_settings[$v]['options'][$value];
				}
			}
		}
		
		$data['avatar'] = get_avatar( $data['email'], 40 );
		
		return $data;
	} // End woo_get_user_data()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Get The Social Icons */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_get_author_social_links' ) ) {
	function woo_get_author_social_links ( $author, $user_data ) {
		$social_links = array( 'rss' => get_author_feed_link( $author ) );
		
		foreach ( array( 'facebook', 'twitter' ) as $k => $v ) {
			if ( isset( $user_data[$v] ) && ( $user_data[$v] != '' ) ) {
				$social_links[$v] = esc_url( $user_data[$v] );
			}
		}
		
		$social_icons = '<ul class="social-icons">' . "\n";
		foreach ( $social_links as $k => $v ) {
			$social_icons .= '<li class="' . $k . '"><a href="' . $v . '"></a></li>' . "\n";
		}
		$social_icons .= '</ul>' . "\n";
		
		return $social_icons;
	} // End woo_get_author_social_links()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Get The Author Info Box */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_get_author_info_box' ) ) {
	function woo_get_author_info_box ( $author ) {
		if ( ! is_numeric( $author ) ) { return; }
		
		$data = woo_get_user_data( $author );
		
		$fields = apply_filters( 'woo_author_info_box_fields', array( 'display_name' => '', 'gender' => '', 'location' => '', 'timezone' => '' ) );
		
		$field_settings = woo_get_profile_fields_settings();
		
		foreach ( $field_settings['fields'] as $k => $v ) {
			foreach ( $v as $i => $j ) {
				if ( in_array( $j['id'], array_keys( $fields ) ) ) {
					$fields[$j['id']] = $j['label'];
				}
			}
		}

		// Fill in the default WordPress fields.
		$fields['display_name'] = __( 'Name', 'woothemes' );

		$output = array();

		if ( is_array( $data ) ) {
			foreach ( $fields as $k => $v ) {
				if ( isset( $data[$k] ) && $data[$k] != '' ) { $output[$k] = array( 'label' => $v, 'value' => $data[$k] ); }
			}
		}
		
		$html = '';
		
		if ( count( $output ) > 0 ) {
			$html .= '<div id="author-info-box" class="author-info-box">' . "\n";
			$html .= '<h3>' . $output['display_name']['value'] . '</h3>' . "\n";
			
			unset( $output['display_name'] );
			
			$html .= '<dl>' . "\n";
			foreach ( $output as $k => $v ) {
				$html .= '<dt>' . $v['label'] . '</dt>' . "\n";
				$html .= '<dd>' . $v['value'] . '</dd>' . "\n";
			}
			$html .= '</dl>' . "\n" . '</div><!--/.author-info-box-->' . "\n";
		}
		
		return $html;
	} // End woo_get_author_info_box()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Add Custom Fields to User Profile Admin Screens */
/*-----------------------------------------------------------------------------------*/

add_action( 'show_user_profile', 'woo_add_profile_fields_admin', 10 );
add_action( 'edit_user_profile', 'woo_add_profile_fields_admin', 10 );

if ( ! function_exists( 'woo_add_profile_fields_admin' ) ) {
	function woo_add_profile_fields_admin ( $user ) {
		// Setup field groups and fields.
		$data = woo_get_profile_fields_settings();
					   
		// Generate HTML for output.
		$html = '';
		
		foreach ( $data['groups'] as $k => $v ) {
			$html .= '<h3>' . $v . '</h3>' . "\n";
			
			if ( isset( $data['fields'][$k] ) && is_array( $data['fields'][$k] ) ) {
				$html .= '<table class="form-table">' . "\n" . '<tbody>' . "\n";
					foreach ( $data['fields'][$k] as $k => $v ) {
						// Determine the value to display.
						$value = get_the_author_meta( $v['id'], $user->ID );
						if ( $value == '' && isset( $v['default'] ) && ( $v['default'] != '' ) ) { $value = $v['default']; }
					
						$html .= '<tr>' . "\n";
							$html .= '<th><label for="' . $v['id'] . '">' . esc_attr( $v['label'] ) . '</label></th>' . "\n";
							$html .= '<td>' . "\n";
							
							// Determine field display based on $v['type'].
							switch ( $v['type'] ) {
								
								/* Select Fields
								--------------------------------------------------*/
								case 'select':
									if ( isset( $v['options'] ) && is_array( $v['options'] ) ) {
										$html .= '<select name="' . $v['id'] . '" id="' . $v['id'] . '">' . "\n";
											foreach ( $v['options'] as $i => $j ) {
												$html .= '<option value="' . $i . '"' . selected( $i, $value, false ) . '>' . $j . '</option>' . "\n";
											}
										$html .= '</select>' . "\n";
									} else {
										$html .= '<input type="text" name="' . $v['id'] . '" id="' . $v['id'] . '" value="' . esc_attr( $value ) . '" class="regular-text" />' . "\n";
									}
								break;
								
								/* Timezone Fields
								--------------------------------------------------*/
								case 'timezone':
									$current_offset = get_option( 'gmt_offset' );
									
									$check_zone_info = true;
									
									// Remove old Etc mappings.  Fallback to gmt_offset.
									if ( false !== strpos( $value, 'Etc/GMT' ) )
										$value = '';
									
									if ( empty( $value ) ) { // Create a UTC+- zone if no timezone string exists
										$check_zone_info = false;
										if ( 0 == $current_offset )
											$value = 'UTC+0';
										elseif ($current_offset < 0)
											$value = 'UTC' . $current_offset;
										else
											$value = 'UTC+' . $current_offset;
									}
								
									$html .= '<select name="' . $v['id'] . '" id="' . $v['id'] . '">' . "\n";
										$html .= wp_timezone_choice( $value );
									$html .= '</select>' . "\n";
								break;
								
								/* Default "Text" Fields
								--------------------------------------------------*/
								default:
									$html .= '<input type="text" name="' . $v['id'] . '" id="' . $v['id'] . '" value="' . esc_attr( $value ) . '" class="regular-text" />' . "\n";
								break;
							}
							
							if ( isset( $v['description'] ) && ( $v['description'] != '' ) ) { $html .= '<br /><span class="description">' . esc_attr( $v['description'] ) . '</span>' . "\n"; }
							$html .= '</td>' . "\n";
						$html .= '</tr>' . "\n";
					}
				$html .= '</tbody>' . "\n" . '</table>' . "\n";
			}
		}
		
		echo $html;
	} // End woo_add_profile_fields_admin()	
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Save Custom Fields from User Profile Admin Screens */
/*-----------------------------------------------------------------------------------*/

add_action( 'personal_options_update', 'woo_save_custom_profile_fields' );
add_action( 'edit_user_profile_update', 'woo_save_custom_profile_fields' );

if ( ! function_exists( 'woo_save_custom_profile_fields' ) ) {
	function woo_save_custom_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;
		
			$fields = array();
			$field_data = woo_get_profile_fields_settings();
			
			foreach ( $field_data['fields'] as $k => $v ) {
				foreach ( $v as $i => $j ) {
					$fields[] = $j['id'];
				}
			}
			
			if ( count( $fields ) > 0 ) {
				foreach ( $fields as $k => $v ) {
					if ( isset( $_POST[$v] ) && ( $_POST[$v] != '' ) ) {
						update_user_meta( $user_id, $v, esc_attr( $_POST[$v] ) );
					}
					
					if ( ! isset( $_POST[$v] ) || ( isset( $_POST[$v] ) && $_POST[$v] == '' ) ) {
						delete_user_meta( $user_id, $v );
					}
				}
			}
	} // End woo_save_custom_profile_fields()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Setup Field Groups and Fields For User Profile Admin Screens */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_get_profile_fields_settings' ) ) {
	function woo_get_profile_fields_settings () {
		$field_groups = array(
								'personal-info' => __( 'Additional Biographic Details', 'woothemes' ), 
								'location-info' => __( 'Location Information', 'woothemes' )
							);
		
		$fields = array(
						'personal-info' => array(
													array(
															'id' => 'gender', 
															'label' => __( 'Gender', 'woothemes' ), 
															'type' => 'select', 
															'default' => 'm', 
															'description' => __( 'Your gender.', 'woothemes' ), 
															'options' => array(
																				'm' => __( 'Male', 'woothemes' ), 
																				'f' => __( 'Female', 'woothemes' )
																			  )
														), 
													array(
															'id' => 'byline', 
															'label' => __( 'Byline', 'woothemes' ), 
															'type' => 'text', 
															'default' => '', 
															'description' => __( 'A short byline about you.', 'woothemes' )
														)
												), 
						'location-info' => array(
													array(
															'id' => 'location', 
															'label' => __( 'Location', 'woothemes' ), 
															'type' => 'text', 
															'default' => '', 
															'description' => __( 'Your location (eg: Stafford, UK).', 'woothemes' )
														), 
													array(
															'id' => 'timezone', 
															'label' => __( 'Timezone', 'woothemes' ), 
															'type' => 'timezone', 
															'default' => '', 
															'description' => __( 'The timezone in which you reside (eg: GMT +2).', 'woothemes' )
														)
												)
					   );
					   
		return apply_filters( 'woo_get_profile_fields_settings', array( 'groups' => $field_groups, 'fields' => $fields ) );
	} // End woo_get_profile_fields_settings()
}

/*-----------------------------------------------------------------------------------*/
/* Author Archives - Add Custom Contact Methods */
/*-----------------------------------------------------------------------------------*/

add_filter( 'user_contactmethods', 'woo_add_user_contact_methods', 10, 2 );

if ( ! function_exists( 'woo_add_user_contact_methods' ) ) {
	function woo_add_user_contact_methods ( $methods, $user ) {
		$methods['facebook'] = __( 'Facebook URL', 'woothemes' );
		$methods['twitter'] = __( 'Twitter URL', 'woothemes' );
		return $methods;
	} // End woo_add_user_contact_methods()
}
?>