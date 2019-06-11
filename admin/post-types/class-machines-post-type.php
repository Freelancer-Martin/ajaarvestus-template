<?php
/**
 * Use namespace to avoid conflict
 */
namespace PostTypeMachines;
/**
 * Class Event
 * @package PostType
 *
 * Use actual name of post type for
 * easy readability.
 *
 * Potential conflicts removed by namespace
 */
class Machines {
    /**
     * @var string
     *
     * Set post type params
     */
    private $type               = 'add_machines_type';
    private $slug               = 'add_machines';
    private $name               = 'Add Machines';
    private $singular_name      = 'Add Machines';
    /**
     * Register post type
     */
    public function register() {
        $labels = array(
            'name'                  => _x( $this->name, 'ilo-ee-ajaarvestus-template'),
            'singular_name'         => _x( $this->singular_name, 'ilo-ee-ajaarvestus-template'),
            'add_new'               => esc_html__( 'Add New ', 'ilo-ee-ajaarvestus-template'),
            'add_new_item'          => esc_html__( 'Add New ', 'ilo-ee-ajaarvestus-template')   . $this->singular_name,
            'edit_item'             => esc_html__( 'Edit ', 'ilo-ee-ajaarvestus-template')      . $this->singular_name,
            'new_item'              => esc_html__( 'New ', 'ilo-ee-ajaarvestus-template')       . $this->singular_name,
            'all_items'             => esc_html__( 'All ', 'ilo-ee-ajaarvestus-template')       . $this->name,
            'view_item'             => esc_html__( 'View ' , 'ilo-ee-ajaarvestus-template')     . $this->name,
            'search_items'          => esc_html__( 'Search ', 'ilo-ee-ajaarvestus-template')    . $this->name,
            'not_found'             => esc_html__( 'No ', 'ilo-ee-ajaarvestus-template')        . strtolower($this->name) . ' found',
            'not_found_in_trash'    => esc_html__( 'No ', 'ilo-ee-ajaarvestus-template')        . strtolower($this->name) . ' found in Trash',
            'parent_item_colon'     => '',
            'menu_name'             => _x( $this->name, 'ilo-ee-ajaarvestus-template'),
        );
        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'menu_icon'             => 'dashicons-hammer',
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array( 'slug' => $this->slug ),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => true,
            'menu_position'         => 8,
            'supports'              => array( 'title' /*, 'editor', 'excerpt', 'author', 'thumbnail'  */),
            'yarpp_support'         => true
        );
        register_post_type( $this->type, $args );
    }
    /**
     * @param $columns
     * @return mixed
     *
     * Choose the columns you want in
     * the admin table for this post
     */
    public function set_columns($columns) {
        // Set/unset post type table columns here
        return $columns;
    }
    /**
     * @param $column
     * @param $post_id
     *
     * Edit the contents of each column in
     * the admin table for this post
     */
    public function edit_columns($column, $post_id) {
        // Post type table column content code here
    }
    /**
     * Event constructor.
     *
     * When class is instantiated
     */
    public function __construct() {
      if( is_admin() ) {
        // Register the post type
        add_action('init', array($this, 'register'));
        // Admin set post columns
        add_filter( 'manage_edit-'.$this->type.'_columns',        array($this, 'set_columns'), 10, 1) ;
        // Admin edit post columns
        add_action( 'manage_'.$this->type.'_posts_custom_column', array($this, 'edit_columns'), 10, 2 );
      }
    }
}
/**
 * Instantiate class, creating post type
 */
new Machines();
