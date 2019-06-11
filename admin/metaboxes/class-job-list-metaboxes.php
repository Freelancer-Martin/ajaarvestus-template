<?php
add_action( 'cmb2_admin_init', 'render_job_list_meta_box_content' );

function render_job_list_meta_box_content( ) {

  $prefix = 'job_list_fields_';

  /**
   * Sample metabox to demonstrate each field type included
   */
  $cmb_demo = new_cmb2_box( array(
    'id'            => $prefix . 'metabox',
    'title'         => esc_html__( 'Job List Metabox', 'ilo-ee-ajaarvestus-template' ),
    'object_types'  => array( 'add_job_number_type' ), // Post type
    // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
    // 'context'    => 'normal',
    // 'priority'   => 'high',
    // 'show_names' => true, // Show field names on the left
    // 'cmb_styles' => false, // false to disable the CMB stylesheet
    // 'closed'     => true, // true to keep the metabox closed by default
    // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
    // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
  ) );

  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Test Text', 'ilo-ee-ajaarvestus-template' ),
    'desc'       => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'         => $prefix . 'text',
    'type'       => 'text',
    'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
    // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
    // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
    // 'on_front'        => false, // Optionally designate a field to wp-admin only
    // 'repeatable'      => true,
    // 'column'          => true, // Display field value in the admin post-listing columns
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Printing part', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert Printing part here', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'printing_part',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );


  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Format', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert Format here', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'format',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Plates', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert Plates here', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'plates',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Kogus', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert Kogus here', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'amount',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Poke ', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert Poke', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'poke',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Stocks (head / legs / front / rear) ', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Stoks', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'stocks',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Activities Name ', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert activities name here', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'job_name',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );


} // end of render metabox functions
