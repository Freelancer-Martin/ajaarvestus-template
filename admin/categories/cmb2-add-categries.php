<?php
function wporg_register_taxonomy_preparation()
{
    $labels = [
        'name'              => _x('Preparation', 'taxonomy general name'),
        'singular_name'     => _x('Preparation', 'taxonomy singular name'),
        'search_items'      => __('Search Preparation'),
        'all_items'         => __('All Preparation'),
        'parent_item'       => __('Parent Preparation'),
        'parent_item_colon' => __('Parent Preparation:'),
        'edit_item'         => __('Edit Preparation'),
        'update_item'       => __('Update Preparation'),
        'add_new_item'      => __('Add New Preparation'),
        'new_item_name'     => __('New Preparation Name'),
        'menu_name'         => __('Preparation'),
        ];
        $args = [
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'preparation'],
        ];
register_taxonomy('preparation', ['add_activities_type'], $args);
}
add_action('init', 'wporg_register_taxonomy_preparation');


function wporg_register_taxonomy_print()
{
    $labels = [
        'name'              => _x('Print', 'taxonomy general name'),
        'singular_name'     => _x('Print', 'taxonomy singular name'),
        'search_items'      => __('Search Print'),
        'all_items'         => __('All Print'),
        'parent_item'       => __('Parent Print'),
        'parent_item_colon' => __('Parent Print:'),
        'edit_item'         => __('Edit Print'),
        'update_item'       => __('Update Print'),
        'add_new_item'      => __('Add New Print'),
        'new_item_name'     => __('New Print Name'),
        'menu_name'         => __('Print'),
        ];
        $args = [
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'print'],
        ];
register_taxonomy('print', ['add_activities_type'], $args);
}
add_action('init', 'wporg_register_taxonomy_print');


function wporg_register_taxonomy_follow_up()
  {
      $labels = [
          'name'              => _x('Follow Up', 'taxonomy general name'),
          'singular_name'     => _x('Follow Up', 'taxonomy singular name'),
          'search_items'      => __('Search Follow Up'),
          'all_items'         => __('All Follow Up'),
          'parent_item'       => __('Parent Follow Up'),
          'parent_item_colon' => __('Parent Follow Up:'),
          'edit_item'         => __('Edit Follow Up'),
          'update_item'       => __('Update Follow Up'),
          'add_new_item'      => __('Add New Follow Up'),
          'new_item_name'     => __('New Follow Up Name'),
          'menu_name'         => __('Follow Up'),
          ];
          $args = [
          'hierarchical'      => true, // make it hierarchical (like categories)
          'labels'            => $labels,
          'show_ui'           => true,
          'show_admin_column' => true,
          'query_var'         => true,
          'rewrite'           => ['slug' => 'follow-up'],
          ];
  register_taxonomy('follow-up', ['add_activities_type'], $args);
  }
  add_action('init', 'wporg_register_taxonomy_follow_up');



  function wporg_register_taxonomy_transport()
    {
        $labels = [
            'name'              => _x('Transport', 'taxonomy general name'),
            'singular_name'     => _x('Transport', 'taxonomy singular name'),
            'search_items'      => __('Search Transport'),
            'all_items'         => __('All Transport'),
            'parent_item'       => __('Parent Transport'),
            'parent_item_colon' => __('Parent Transport:'),
            'edit_item'         => __('Edit Transport'),
            'update_item'       => __('Update Transport'),
            'add_new_item'      => __('Add New Transport'),
            'new_item_name'     => __('New Transport Name'),
            'menu_name'         => __('Transport'),
            ];
            $args = [
            'hierarchical'      => true, // make it hierarchical (like categories)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'transport'],
            ];
    register_taxonomy('transport', ['add_activities_type'], $args);
    }
    add_action('init', 'wporg_register_taxonomy_transport');



/*
function activities_register_taxonomy_metabox() {
	$prefix = 'activities_term_';


	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => esc_html__( 'Category Metabox', 'ilo-ee-ajaarvestus-template' ), // Doesn't output for term boxes
		'object_types'     => array( 'term', 'add_activities_type' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );

	$cmb_term->add_field( array(
		'name'     => esc_html__( 'Extra Info', 'ilo-ee-ajaarvestus-template' ),
		'desc'     => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Term Image', 'ilo-ee-ajaarvestus-template' ),
		'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
		'id'   => $prefix . 'avatar',
		'type' => 'file',
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Arbitrary Term Field', 'ilo-ee-ajaarvestus-template' ),
		'desc' => esc_html__( 'field description (optional)', 'ilo-ee-ajaarvestus-template' ),
		'id'   => $prefix . 'term_text_field',
		'type' => 'text',
	) );

}
