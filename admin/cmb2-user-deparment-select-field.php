<?php
/**
 * Returns options markup for a state select field.
 * @param  mixed $value Selected/saved state
 * @return string       html string containing all state options
 */

function department_select_options() {

	 $args = array(
			 'posts_per_page' => 20,
			 'post_type' => 'add_department_type',
			 'fields' => 'ids'
	 );
	 $custom_posts = get_posts($args);

	 $array = array();
	 foreach ($custom_posts as $key => $value) {
			$meta = get_post_meta( $value );
			$array[] = $meta['department_fields_deparment_name'][0];

	 }

	 return $array;

 }


	function cmb2_get_state_options( $value = false ) {

				$department_list = department_select_options();
				//print_r( $value );
				//$department_options = '';
				foreach ( $department_list as $abrev => $state ) {
					//if( ! empty( $value ) ) :
						$department_options .= '<option'. selected( $value, $state ).' value="'. $state.'">'.$state .'</option>';
					//endif;
				}

				return $department_options;
	}


/**
 * Render Address Field
 */
function cmb2_render_deparment_field_callback( $field, $value, $object_id, $object_type, $field_type ) {
	// make sure we specify each part of the value we need.
		$value = wp_parse_args( $value, array(

			'department'     => '',

		) );

		?>

		<div class="alignleft"><p><label for="<?php echo $field_type->_id( '_department' ); ?>'">Department</label></p>
			<?php echo $field_type->select( array(
				'name'    => $field_type->_name( '[department]' ),
				'id'      => $field_type->_id( '_department' ),
				'options' => cmb2_get_state_options( $value['department'] ),
				'desc'    => '',
			) ); ?>
		</div>

		<br class="clear">
		<?php
		echo $field_type->_desc( true );

}
add_filter( 'cmb2_render_deparment', 'cmb2_render_deparment_field_callback', 10, 5 );
