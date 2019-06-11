<?php
/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

// plugin folder url
if(!defined('RC_SCD_PLUGIN_URL')) {
	define('RC_SCD_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

/*
|--------------------------------------------------------------------------
| MAIN CLASS
|--------------------------------------------------------------------------
*/

class rc_sweet_custom_dashboard {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		add_action('admin_menu', array( &$this,'rc_scd_register_menu') );
		add_action('load-index.php', array( &$this,'rc_scd_redirect_dashboard') );

	} // end constructor

	function rc_scd_redirect_dashboard() {

		if( is_admin() ) {
			$screen = get_current_screen();

			if( $screen->base == 'dashboard' ) {

				wp_redirect( admin_url( 'index.php?page=custom-dashboard' ) );

			}
		}

	}



	function rc_scd_register_menu() {
		add_dashboard_page( 'Custom Dashboard', 'Custom Dashboard', 'read', 'custom-dashboard', array( &$this,'rc_scd_create_dashboard') );
	}

	function rc_scd_create_dashboard() {

    require_once( ABSPATH . 'wp-load.php' );
    require_once( ABSPATH . 'wp-admin/admin.php' );
    require_once( ABSPATH . 'wp-admin/admin-header.php' );
		$user_query = new WP_User_Query( array( 'role' => 'tootajad' ) );
		$user_meta = get_userdata( get_current_user_id() );
		$user_roles = $user_meta->roles;
    ?>
    <div class="wrap">
			<img class="welcome-dashboard-background-img" src="https://images.pexels.com/photos/1438761/pexels-photo-1438761.jpeg?auto=compress&cs=tinysrgb&h=1280&w=740" />
    	<h1 class="welcome-page-title" style=" z-index: 3; margin: 1% 10% 5% 10%; text-align: center; font-family: Cinzel; font-size: 50px;" ><?php _e( 'Tere Tulemast !', 'ilo-ee-ajaarvestus-template' ); ?></h1>

    	<div style="text-align: center;" class="about-text">
    		<?php _e('Loodame et teie päev möödub hästi.', 'ilo-ee-ajaarvestus-template' ); ?>
    	</div>

    	<div style="text-align: center;" class="changelog welcome-page-button">
				<?php if ( 'overseer' === $user_roles ) { ?>
					<a href="<?php  echo esc_url(admin_url('/admin.php?page=insert_job') );  ?>" style="text-align: center;" ><?php echo  _e( 'Sisestage Töötunnid',  'ilo-ee-ajaarvestus-template' ); ?></a>
				<?php 	} else {  ?>
					<a href="<?php  echo esc_url(admin_url('/admin.php?page=Prepress_insert_job') );  ?>" style="text-align: center;" ><?php echo  _e( 'Sisestage Töötunnid',  'ilo-ee-ajaarvestus-template' ); ?></a>
				<?php 	}     ?>

    	</div>

    </div>
    <?php include( ABSPATH . 'wp-admin/admin-footer.php' );


	}


}

// instantiate plugin's class
$GLOBALS['sweet_custom_dashboard'] = new rc_sweet_custom_dashboard();
