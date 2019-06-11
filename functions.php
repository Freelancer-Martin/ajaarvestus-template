<?php
load_theme_textdomain( 'ilo-ee-ajaarvestus-template', get_template_directory() . '/languages' );
/**
 * ILO.EE Ajaarvestus template functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ILO.EE_Ajaarvestus_template
 */

if ( ! function_exists( 'ilo_ee_ajaarvestus_template_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function ilo_ee_ajaarvestus_template_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on ILO.EE Ajaarvestus template, use a find and replace
     * to change 'ilo-ee-ajaarvestus-template' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'ilo-ee-ajaarvestus-template', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
      'menu-1' => esc_html__( 'Primary', 'ilo-ee-ajaarvestus-template' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );

    // Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'ilo_ee_ajaarvestus_template_custom_background_args', array(
      'default-color' => 'ffffff',
      'default-image' => '',
    ) ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support( 'custom-logo', array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
    ) );
  }
endif;
add_action( 'after_setup_theme', 'ilo_ee_ajaarvestus_template_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ilo_ee_ajaarvestus_template_content_width() {
  // This variable is intended to be overruled from themes.
  // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
  // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
  $GLOBALS['content_width'] = apply_filters( 'ilo_ee_ajaarvestus_template_content_width', 640 );
}
add_action( 'after_setup_theme', 'ilo_ee_ajaarvestus_template_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ilo_ee_ajaarvestus_template_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'ilo-ee-ajaarvestus-template' ),
    'id'            => 'sidebar-1',
    'description'   => esc_html__( 'Add widgets here.', 'ilo-ee-ajaarvestus-template' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'ilo_ee_ajaarvestus_template_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ilo_ee_ajaarvestus_template_scripts() {
  wp_enqueue_style( 'ilo-ee-ajaarvestus-template-style', get_stylesheet_uri() );

  wp_enqueue_style( 'owl.carousel-style', get_template_directory_uri( ) . '/inc/owlcarousel/owl.carousel.css', array(), 'all' );

  wp_enqueue_script( 'ilo-ee-ajaarvestus-template-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

  wp_enqueue_script( 'ilo-ee-ajaarvestus-template-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20151215', true );

  wp_enqueue_script( 'ilo-ee-ajaarvestus-template-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

  wp_enqueue_script( 'ilo-ee-ajaarvestus-owl-carousel-init', get_template_directory_uri() . '/js/owl-carousel-init.js', array(), '20151215', true );

  //wp_enqueue_script( 'ilo-ee-ajaarvestus-owl-carousel-js', get_template_directory_uri() . '/inc/owlcarousel/owl.carousel.js', array(), '20151215', true );

  wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/tabs.js', array('jquery'));
  wp_enqueue_script('jquery-ui-tabs');

  wp_enqueue_script( 'ilo-ee-ajax-functions', get_template_directory_uri() . '/js/ajax-autocomplete.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-autocomplete' ), '20151215', true );

  wp_localize_script( 'autocomplete', 'opts', array(
    'ajax_url' => admin_url( 'admin-ajax.php' ) )
  );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'ilo_ee_ajaarvestus_template_scripts' );
add_action( 'admin_enqueue_scripts', 'ilo_ee_ajaarvestus_template_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
  require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Jetpack compatibility file.
 */

  require get_template_directory() . '/admin/option-pages/class-worker-user-fields-row.php';

  require get_template_directory() . '/admin/include-cmb2-fields.php';

  //require get_template_directory() . '/admin/job-order-list/class-filter-worker-role-fieldds.php';

  require get_template_directory() . '/admin/post-types/class-machines-post-type.php';

  require get_template_directory() . '/admin/post-types/class-activities-post-type.php';

  require get_template_directory() . '/admin/post-types/class-department-post-type.php';

  require get_template_directory() . '/admin/remove-useless-user-fields.php';

  require get_template_directory() . '/admin/metaboxes/class-department-metaboxes.php';

  require get_template_directory() . '/admin/metaboxes/class-activities-metaboxes.php';

  require get_template_directory() . '/admin/metaboxes/class-machines-metaboxes.php';

  require get_template_directory() . '/admin/user/class-show-user-profile-option-page.php';

  require get_template_directory() . '/admin/categories/cmb2-add-categries.php';

  require get_template_directory() . '/admin/job-order-list/class-show-specific-job-option-page.php';

  require get_template_directory() . '/admin/welcome-dashboard-page.php';

  //require get_template_directory() . '/admin/job-order-list/class-overseer-confirm-jobs-option-page.php';

  require get_template_directory() . '/admin/job-order-list/class-show-confirmed-job-list-option-page.php';

  require get_template_directory() . '/admin/filter-user-rights.php';

  //require get_template_directory() . '/admin/job-order-list/class-confirm-user-fields.php';



  require get_template_directory() . '/admin/post-types/class-job-list-post-type.php';

  require get_template_directory() . '/admin/metaboxes/class-job-list-metaboxes.php';

  require get_template_directory() . '/admin/cmb2-user-deparment-select-field.php';

  require get_template_directory() . '/admin/ajax-search-input-field.php';

  require get_template_directory() . '/admin/overseer-confirm-fields.php/class-main-overseer-confirm-fields.php';

  require get_template_directory() . '/admin/overseer-confirm-fields.php/class-overseer-display-filtered-user-fields.php';

  require get_template_directory() . '/admin/overseer-confirm-fields.php/class-overseer-filter-user-fields.php';

  require get_template_directory() . '/admin/overseer-confirm-fields.php/class-overseer-save-user-fields.php';


  function user_insert_fiels_filter(){

    $user_query = new WP_User_Query( array( 'role' => 'tootajad' ) );
    $user_meta = get_userdata( get_current_user_id() );

    $user_roles = $user_meta->roles;
    //print_r( $user_roles );

    switch ( implode((array)$user_roles) ) {
      case "overseer":
            require get_template_directory() . '/admin/option-pages/class-overseer-insert-job-option-page.php';
          break;
      case "muugi_osakond":
            require get_template_directory() . '/admin/option-pages/class-prepress-insert-job-option-page.php';
          break;
      case "tootajad":
            require get_template_directory() . '/admin/option-pages/class-prepress-insert-job-option-page.php';
          break;
      case "pre_press":
            require get_template_directory() . '/admin/option-pages/class-prepress-insert-job-option-page.php';
          break;
      case "owner_admin":   //administrator
            require get_template_directory() . '/admin/option-pages/class-prepress-insert-job-option-page.php';
          break;
      case "administrator":   //administrator
            require get_template_directory() . '/admin/option-pages/class-prepress-insert-job-option-page.php';
          break;
      default:

    }

  }
  add_action( 'init', 'user_insert_fiels_filter', 999 );


  add_filter( 'admin_footer_text', '__return_false' );
