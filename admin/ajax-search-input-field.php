<?php



add_shortcode( 'cmb-form', 'cmb2_do_frontend_form_shortcode' );
/**
 * Shortcode to display a CMB2 form for a post ID.
 * @param  array  $atts Shortcode attributes
 * @return string       Form HTML markup
 */
function cmb2_do_frontend_form_shortcode( $atts = array() ) {
	global $post;

	/**
	 * Depending on your setup, check if the user has permissions to edit_posts
	 */
/*
	if ( ! current_user_can( 'edit_posts' ) ) {
		return __( 'You do not have permissions to edit this post.', 'lang_domain' );
	}
*/
	/**
	 * Make sure a WordPress post ID is set.
	 * We'll default to the current post/page
	 */
	if ( ! isset( $atts['post_id'] ) ) {
		$atts['post_id'] = $post->ID;
	}

	// If no metabox id is set, yell about it
	if ( empty( $atts['id'] ) ) {
		return __( "Please add an 'id' attribute to specify the CMB2 form to display.", 'lang_domain' );
	}

	// This is the WordPress post ID where the data should be stored/displayed.

	$metabox_id = 'autocomplete_test';

	cmb2_metabox_form( 'autocomplete_test' );

	return $form;
}


function job_number_select_options() {

	$args = array(
			'posts_per_page' => -1,
			'post_type' => 'add_job_number_type',
			'fields' => 'ids'
	);
	$custom_posts = get_posts($args);


	$user_deparment = get_user_meta( get_current_user_id() , 'cmb2_profile_fields_user_deparment', true);
	//print_r( $user_deparment['deparment'] );

	$array = array();
	foreach ( $custom_posts as $key => $value ) {

		 $job_list_deparments = get_post_meta( $value, 'job_list_fields_user_deparment', false );
		 $meta = get_post_meta( $value, false );
		 $decode = json_decode( $meta['job_list_fields_user_deparment'][0] );
		// if ( $job_list_deparments[0]['department'] ==  $user_deparment['department'] ) { // $user_department['deparment']  have to be for new ones seting name
			// return  $meta['job_list_fields_job_name'][0];

			 $first_array[$meta['job_list_fields_job_name'][0]][] = $meta['job_list_fields_job_name'][0];

		// }
		 //print_r( $user_deparment );
	}
	//print_r( $first_array );
	return $first_array;
}


/**
 * Define the metabox and field configurations.
 */
function autocomplete_cmb2_meta_boxes() {
	// Start with an underscore to hide fields from custom fields list
	//$prefix = '_autocomplete_cmb2_';
	$cmb = new_cmb2_box( array(
		'id' => 'autocomplete_test',
		'title' => __('Autocomplete Field Examples', 'autocomplete_cmb2'),
		'object_types' => array('post'),
	) );

	$cmb->add_field( array(
		//'name' => __('Related Post', 'autocomplete_cmb2'),
		'desc' => __('Post that is related to this one', 'autocomplete_cmb2'),
		'id' => 'job_number_select_12',
		'type' => 'autocomplete',
		'source' => 'get_post_options',
		'mapping_function' => 'autocomplete_cmb2_get_post_title_from_id'
	) );
/*
	$cmb->add_field( array(
		'name' => __('Related Posts', 'autocomplete_cmb2'),
		'desc' => __('Posts that are related to this one', 'autocomplete_cmb2'),
		'id' => $prefix.'related_posts',
		'repeatable' => true,
		'type' => 'autocomplete',
		'source' => 'get_post_options',
		'repeatable_class' => 'related-posts',
		'mapping_function' => 'job_number_select_options'
	) );
*/
}
/**
 * Gets the post title from the ID for mapping purposes in autocompletes.
 *
 * @param int $id
 * @return string
 */
function autocomplete_cmb2_get_post_title_from_id($id) {
	if (empty($id)) {
		return '';
	}
	$post = get_post($id);
	return $post->post_title;
}
/**
 * Renders the autocomplete type
 *
 * @param CMB2_Field $field_object
 * @param string $escaped_value The value of this field passed through the escaping filter. It defaults to sanitize_text_field.
 *                 If you need the unescaped value, you can access it via $field_type_object->value().
 * @param string $object_id The id of the object you are working with. Most commonly, the post id.
 * @param string $object_type The type of object you are working with. Most commonly, post (this applies to all post-types),
 *                but could also be comment, user or options-page.
 * @param CMB2_Object $field_type_object This is an instance of the CMB2 object and gives you access to all of the methods that CMB2 uses to build its field types.
 */
function autocomplete_cmb2_render_autocomplete($field_object, $escaped_value, $object_id, $object_type, $field_type_object) {
	// Store the value in a hidden field.
	echo $field_type_object->hidden();
	if (isset($field_object->args['repeatable_class'])) {
		$repeatable_class = $field_object->args['repeatable_class'];
	}
	$options = $field_object->options();
	// Set up the options or source PHP variables.
	if (empty($options)) {
		$source = $field_object->args['source'];
		$value = $field_object->args['mapping_function']($field_object->escaped_value);
	} else {
		// Set the value.
		if (empty($field_object->escaped_value)) {
			$value = '';
		} else {
			foreach ($options as $option) {
				if ($option['value'] == $field_object->escaped_value) {
					$value = $option['name'];
					break;
				}
			}
		}
	}
	// Set up the autocomplete field.  Replace the '_' with '-' to not interfere with the ID from CMB2.
	$id = str_replace('_', '-', $field_object->args['id']);
	if ( '_' !== substr( $field_object->args['id'], 0, 1 ) ) {
		$id = '-' . $field_object->args['id'];
	}
	print_r( $value );
	// Don't use the ID on repeatable elements as it won't change; use the class instead.
	echo '<input size="50"'.(empty($repeatable_class) ? ' id="'.$id.'"' : '') . ' value="'.$value.'"'.
		(!empty($repeatable_class) ? ' class="'.$repeatable_class.'"' : '').'/>';
	if (!$field_object->args['repeatable'] && isset($field_object->args['desc'])) {
		echo '<p class="cmb2-metabox-description">'.$field_object->args['desc'].'</p>';
	}
	// Now, set up the script.
	?>
	<script>
		jQuery(document).ready(function($) {
			var options = [];
			var nameToValue = [];
			<?php
			if (!empty($options)) {
				foreach ($options as $option) {
					echo "options.push('".addcslashes($option['name'], "'")."');\r\n";
					echo "nameToValue['".addcslashes($option['name'], "'")."'] = '".$option['value']."';\r\n";
				}
			}
			if (!empty($repeatable_class)) { ?>
			$('.<?php echo $repeatable_class; ?>').each(function(i, el) {
				if (typeof $(this).data('ui-autocomplete') === 'undefined') {
						$(this).autocomplete({
			<?php } else { ?>
			$('#<?php echo $id; ?>').autocomplete({
			<?php } ?>
				source: <?php if (empty($options)) { ?>
					function(request, response) {
						$.ajax(
							{url: ajaxurl,
							 data: {
								action: '<?php echo $source; ?>',
								q: request.term
							 },
							 success: function(data) {
								// Set up options and name to value for this returned set.
								var values = $.parseJSON(data);
								options = [];
								nameToValue = [];
								for (optionI in values) {
									var option = values[optionI];
									options.push(option.name);
									nameToValue[option.name] = option.value;
								}
								response(options);
							}
						 });
						} <?php } else {
							echo 'options';
						} ?>
			});
			// Also set up a blur function to update the ID.
			$(<?php echo empty($repeatable_class) ? "'#".$id."'" : 'this'; ?>).blur(function(e) {
				$(this).prev('input').val(nameToValue[$(this).val()]);
			});
			<?php
			if (!empty($repeatable_class)) { ?>
					}
				});
			<?php
			}
			?>
		});
	</script>
	<?php
}
/**
 * Gets post options using a post type
 *
 * @param mixed $post_type array or string of post type(s)
 * @param boolean $include_empty whether or not to include an empty value
 * @param string $like_test used to query for posts like a certain value
 * @return array
 */
function autocomplete_cmb2_get_post_options_using_post_type($post_type, $include_empty = false, $like_test = '%%') {
	// Use a query instead of "get_posts" to save on a ton of memory.
	global $wpdb;
	if (is_array($post_type)) {
		$post_type_query = "('".implode("', '", $post_type)."')";
	} else {
		$post_type_query = "('".$post_type."')";
	}
	$posts = $wpdb->get_results($wpdb->prepare("
		SELECT ID, post_title
    FROM $wpdb->posts
    WHERE post_status = 'publish' AND post_type IN $post_type_query AND post_title LIKE %s
    ORDER BY post_title ASC
 	", $like_test), OBJECT);
	if ($include_empty) {
		$post_options = array(array('name' => '--- Select ---', 'value' => ''));
	} else {
		$post_options = array();
	}
	foreach ($posts as $post) {
		$post_options[] = array(
			 'name' => $post->post_title,
			 'value' => $post->ID
		);
	}
	return $post_options;
}
/**
 * Gets the jQuery autocomplete widget ready.
 */
function autocomplete_cmb2_admin_enqueue_scripts() {
	wp_enqueue_script('jquery-ui-autocomplete');
}
/**
 * Gets the post options in JSON format for the autocomplete
 */
function autocomplete_cmb2_get_post_autocomplete_options() {
	die(json_encode(autocomplete_cmb2_get_post_options_using_post_type('add_job_number_type', false, '%'.$_GET['q'].'%')));
}
add_action('cmb2_render_autocomplete', 'autocomplete_cmb2_render_autocomplete', 10, 5);
add_action('admin_enqueue_scripts', 'autocomplete_cmb2_admin_enqueue_scripts');
add_action('wp_ajax_get_post_options', 'autocomplete_cmb2_get_post_autocomplete_options');
add_filter('cmb2_admin_init', 'autocomplete_cmb2_meta_boxes');
