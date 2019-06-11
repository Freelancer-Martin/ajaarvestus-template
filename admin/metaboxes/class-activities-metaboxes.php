<?php
add_action( 'cmb2_admin_init', 'render_activities_meta_box_content' );

function render_activities_meta_box_content( ) {

  $prefix = 'activities_fields_';

  /**
   * Sample metabox to demonstrate each field type included
   */
  $cmb_demo = new_cmb2_box( array(
    'id'            => $prefix . 'metabox',
    'title'         => esc_html__( 'Activities Metabox', 'ilo-ee-ajaarvestus-template' ),
    'object_types'  => array( 'add_activities_type' ), // Post type
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
    'name' => esc_html__( 'Activities Name ', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Insert activities name here', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'activities_name',
    'type' => 'text_small',
    // 'repeatable' => true,
    // 'column' => array(
    // 	'name'     => esc_html__( 'Column Title', 'ilo-ee-ajaarvestus-template' ), // Set the admin column title
    // 	'position' => 2, // Set as the second column.
    // );
    // 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
  ) );
/*
  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Text Medium', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textmedium',
    'type' => 'text_medium',
  ) );

  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Read-only Disabled Field', 'ilo-ee-ajaarvestus-template' ),
    'desc'       => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'         => $prefix . 'readonly',
    'type'       => 'text_medium',
    'default'    => esc_attr__( 'Hey there, I\'m a read-only field', 'ilo-ee-ajaarvestus-template' ),
    'save_field' => false, // Disables the saving of this field.
    'attributes' => array(
      'disabled' => 'disabled',
      'readonly' => 'readonly',
    ),
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Custom Rendered Field', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'render_row_cb',
    'type' => 'text',
    'render_row_cb' => 'yourprefix_render_row_cb',
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Website URL', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'url',
    'type' => 'text_url',
    // 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
    // 'repeatable' => true,
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Text Email', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'email',
    'type' => 'text_email',
    // 'repeatable' => true,
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Time', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'time',
    'type' => 'text_time',
    // 'time_format' => 'H:i', // Set to 24hr format
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Time zone', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Time zone', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'timezone',
    'type' => 'select_timezone',
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Date Picker', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textdate',
    'type' => 'text_date',
    // 'date_format' => 'Y-m-d',
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Date Picker (UNIX timestamp)', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textdate_timestamp',
    'type' => 'text_date_timestamp',
    // 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Date/Time Picker Combo (UNIX timestamp)', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'datetime_timestamp',
    'type' => 'text_datetime_timestamp',
  ) );

  // This text_datetime_timestamp_timezone field type
  // is only compatible with PHP versions 5.3 or above.
  // Feel free to uncomment and use if your server meets the requirement
  // $cmb_demo->add_field( array(
  // 	'name' => esc_html__( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'ilo-ee-ajaarvestus-template' ),
  // 	'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
  // 	'id'   => $prefix . 'datetime_timestamp_timezone',
  // 	'type' => 'text_datetime_timestamp_timezone',
  // ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Money', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textmoney',
    'type' => 'text_money',
    // 'before_field' => '£', // override '$' symbol if needed
    // 'repeatable' => true,
  ) );

  $cmb_demo->add_field( array(
    'name'    => esc_html__( 'Test Color Picker', 'ilo-ee-ajaarvestus-template' ),
    'desc'    => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'      => $prefix . 'colorpicker',
    'type'    => 'colorpicker',
    'default' => '#ffffff',
    // 'options' => array(
    // 	'alpha' => true, // Make this a rgba color picker.
    // ),
    // 'attributes' => array(
    // 	'data-colorpicker' => json_encode( array(
    // 		'palettes' => array( '#3dd0cc', '#ff834c', '#4fa2c0', '#0bc991', ),
    // 	) ),
    // ),
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Text Area', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textarea',
    'type' => 'textarea',
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Text Area Small', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textareasmall',
    'type' => 'textarea_small',
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Text Area for Code', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'textarea_code',
    'type' => 'textarea_code',
    // 'attributes' => array(
    // 	// Optionally override the code editor defaults.
    // 	'data-codeeditor' => json_encode( array(
    // 		'codemirror' => array(
    // 			'lineNumbers' => false,
    // 			'mode' => 'css',
    // 		),
    // 	) ),
    // ),
    // To keep the previous formatting, you can disable codemirror.
    // 'options' => array( 'disable_codemirror' => true ),
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Title Weeeee', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'This is a title description', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'title',
    'type' => 'title',
  ) );

  $cmb_demo->add_field( array(
    'name'             => esc_html__( 'Test Select', 'ilo-ee-ajaarvestus-template' ),
    'desc'             => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'               => $prefix . 'select',
    'type'             => 'select',
    'show_option_none' => true,
    'options'          => array(
      'standard' => esc_html__( 'Option One', 'ilo-ee-ajaarvestus-template' ),
      'custom'   => esc_html__( 'Option Two', 'ilo-ee-ajaarvestus-template' ),
      'none'     => esc_html__( 'Option Three', 'ilo-ee-ajaarvestus-template' ),
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'             => esc_html__( 'Test Radio inline', 'ilo-ee-ajaarvestus-template' ),
    'desc'             => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'               => $prefix . 'radio_inline',
    'type'             => 'radio_inline',
    'show_option_none' => 'No Selection',
    'options'          => array(
      'standard' => esc_html__( 'Option One', 'ilo-ee-ajaarvestus-template' ),
      'custom'   => esc_html__( 'Option Two', 'ilo-ee-ajaarvestus-template' ),
      'none'     => esc_html__( 'Option Three', 'ilo-ee-ajaarvestus-template' ),
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'    => esc_html__( 'Test Radio', 'ilo-ee-ajaarvestus-template' ),
    'desc'    => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'      => $prefix . 'radio',
    'type'    => 'radio',
    'options' => array(
      'option1' => esc_html__( 'Option One', 'ilo-ee-ajaarvestus-template' ),
      'option2' => esc_html__( 'Option Two', 'ilo-ee-ajaarvestus-template' ),
      'option3' => esc_html__( 'Option Three', 'ilo-ee-ajaarvestus-template' ),
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'     => esc_html__( 'Test Taxonomy Radio', 'ilo-ee-ajaarvestus-template' ),
    'desc'     => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'       => $prefix . 'text_taxonomy_radio',
    'type'     => 'taxonomy_radio', // Or `taxonomy_radio_inline`/`taxonomy_radio_hierarchical`
    'taxonomy' => 'category', // Taxonomy Slug
    // 'inline'  => true, // Toggles display to inline
  ) );

  $cmb_demo->add_field( array(
    'name'     => esc_html__( 'Test Taxonomy Select', 'ilo-ee-ajaarvestus-template' ),
    'desc'     => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'       => $prefix . 'taxonomy_select',
    'type'     => 'taxonomy_select',
    'taxonomy' => 'category', // Taxonomy Slug
  ) );

  $cmb_demo->add_field( array(
    'name'     => esc_html__( 'Test Taxonomy Multi Checkbox', 'ilo-ee-ajaarvestus-template' ),
    'desc'     => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'       => $prefix . 'multitaxonomy',
    'type'     => 'taxonomy_multicheck', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`
    'taxonomy' => 'post_tag', // Taxonomy Slug
    // 'inline'  => true, // Toggles display to inline
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Checkbox', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'checkbox',
    'type' => 'checkbox',
  ) );

  $cmb_demo->add_field( array(
    'name'    => esc_html__( 'Test Multi Checkbox', 'ilo-ee-ajaarvestus-template' ),
    'desc'    => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'      => $prefix . 'multicheckbox',
    'type'    => 'multicheck',
    // 'multiple' => true, // Store values in individual rows
    'options' => array(
      'check1' => esc_html__( 'Check One', 'ilo-ee-ajaarvestus-template' ),
      'check2' => esc_html__( 'Check Two', 'ilo-ee-ajaarvestus-template' ),
      'check3' => esc_html__( 'Check Three', 'ilo-ee-ajaarvestus-template' ),
    ),
    // 'inline'  => true, // Toggles display to inline
  ) );

  $cmb_demo->add_field( array(
    'name'    => esc_html__( 'Test wysiwyg', 'ilo-ee-ajaarvestus-template' ),
    'desc'    => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
    'id'      => $prefix . 'wysiwyg',
    'type'    => 'wysiwyg',
    'options' => array(
      'textarea_rows' => 5,
    ),
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'Test Image', 'ilo-ee-ajaarvestus-template' ),
    'desc' => esc_html__( 'Upload an image or enter a URL.', 'ilo-ee-ajaarvestus-template' ),
    'id'   => $prefix . 'image',
    'type' => 'file',
  ) );

  $cmb_demo->add_field( array(
    'name'         => esc_html__( 'Multiple Files', 'ilo-ee-ajaarvestus-template' ),
    'desc'         => esc_html__( 'Upload or add multiple images/attachments.', 'ilo-ee-ajaarvestus-template' ),
    'id'           => $prefix . 'file_list',
    'type'         => 'file_list',
    'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
  ) );

  $cmb_demo->add_field( array(
    'name' => esc_html__( 'oEmbed', 'ilo-ee-ajaarvestus-template' ),
    'desc' => sprintf(

      esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'ilo-ee-ajaarvestus-template' ),
      '<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
    ),
    'id'   => $prefix . 'embed',
    'type' => 'oembed',
  ) );

  $cmb_demo->add_field( array(
    'name'         => 'Testing Field Parameters',
    'id'           => $prefix . 'parameters',
    'type'         => 'text',
    'before_row'   => 'yourprefix_before_row_if_2', // callback.
    'before'       => '<p>Testing <b>"before"</b> parameter</p>',
    'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
    'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
    'after'        => '<p>Testing <b>"after"</b> parameter</p>',
    'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
  ) );
*/


} // end of render metabox functions
