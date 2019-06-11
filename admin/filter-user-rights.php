<?php
function ft_remove_menus(){

  $user_query = new WP_User_Query( array( 'role' => 'tootajad' ) );
  $user_meta = get_userdata( get_current_user_id() );

  $user_roles = $user_meta->roles;
  //print_r( $user_roles );

  switch ( implode($user_roles) ) {
    case "overseer":
        remove_menu_page( 'index.php' );                  //Dashboard
        remove_menu_page( 'jetpack' );                    //Jetpack*
        remove_menu_page( 'edit.php' );                   //Posts
        remove_menu_page( 'upload.php' );                 //Media
        remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        remove_menu_page( 'themes.php' );                 //Appearance
        remove_menu_page( 'plugins.php' );                //Plugins
        remove_menu_page( 'users.php' );                  //Users
        remove_menu_page( 'tools.php' );                  //Tools
        remove_menu_page( 'options-general.php' );        //Settings
        remove_menu_page( 'loginpress-settings' );
        remove_menu_page( 'ultimatemember' );
        remove_menu_page( 'profile.php' );
        remove_menu_page( 'import.php' );
        remove_menu_page( 'export.php' );
        remove_menu_page( 'import.php?page=export_personal_data' );
        remove_menu_page( 'import.php?page=remove_personal_data' );
        remove_menu_page( 'wpfront-user-role-editor-all-roles' );
        remove_menu_page( 'edit.php?post_type=add_department_type' );
        remove_menu_page( 'edit.php?post_type=add_machines_type' );
        remove_menu_page( 'edit.php?post_type=add_activities_type' );
        remove_menu_page( 'edit.php?post_type=add_job_number_type' );
        remove_menu_page( 'link-manager.php' );
        remove_menu_page( 'wp_file_manager' );
        remove_menu_page( 'maintenance' );
        //remove_menu_page( 'confirm-job-list' );
        //remove_menu_page( 'job-order-list' );
        remove_menu_page( 'specific_job' );
        // Include Templates
        //require get_template_directory() . '/admin/option-pages/class-worker-insert-job-option-page.php';
        remove_menu_page( 'ai1wm_export' );
        remove_menu_page( 'backwpup' );
        break;
    case "muugi_osakond":
        remove_menu_page( 'index.php' );                  //Dashboard
        remove_menu_page( 'jetpack' );                    //Jetpack*
        remove_menu_page( 'edit.php' );                   //Posts
        remove_menu_page( 'upload.php' );                 //Media
        remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        remove_menu_page( 'themes.php' );                 //Appearance
        remove_menu_page( 'plugins.php' );                //Plugins
        remove_menu_page( 'users.php' );                  //Users
        remove_menu_page( 'tools.php' );                  //Tools
        remove_menu_page( 'options-general.php' );        //Settings
        remove_menu_page( 'loginpress-settings' );
        remove_menu_page( 'ultimatemember' );
        remove_menu_page( 'profile.php' );
        remove_menu_page( 'import.php' );
        remove_menu_page( 'export.php' );
        remove_menu_page( 'import.php?page=export_personal_data' );
        remove_menu_page( 'import.php?page=remove_personal_data' );
        remove_menu_page( 'job-order-list' );
        remove_menu_page( 'edit.php?post_type=add_department_type' );
        remove_menu_page( 'edit.php?post_type=add_machines_type' );
        remove_menu_page( 'edit.php?post_type=add_activities_type' );
        //remove_menu_page( 'edit.php?post_type=add_job_number_type' );
        remove_menu_page( 'link-manager.php' );
        remove_menu_page( 'wp_file_manager' );
        remove_menu_page( 'maintenance' );
        remove_menu_page( 'confirm-job-list' );
        remove_menu_page( 'specific_job' );
        remove_menu_page( 'wpfront-user-role-editor-all-roles' );
        // Include Templates
        //require get_template_directory() . '/admin/option-pages/class-worker-insert-job-option-page.php';
        remove_menu_page( 'ai1wm_export' );
        remove_menu_page( 'backwpup' );
        break;
      case "tootajad":
          remove_menu_page( 'index.php' );                  //Dashboard
          remove_menu_page( 'jetpack' );                    //Jetpack*
          remove_menu_page( 'edit.php' );                   //Posts
          remove_menu_page( 'upload.php' );                 //Media
          remove_menu_page( 'edit.php?post_type=page' );    //Pages
          remove_menu_page( 'edit-comments.php' );          //Comments
          remove_menu_page( 'themes.php' );                 //Appearance
          remove_menu_page( 'plugins.php' );                //Plugins
          remove_menu_page( 'users.php' );                  //Users
          remove_menu_page( 'tools.php' );                  //Tools
          remove_menu_page( 'options-general.php' );        //Settings
          remove_menu_page( 'loginpress-settings' );
          remove_menu_page( 'ultimatemember' );
          remove_menu_page( 'profile.php' );
          remove_menu_page( 'import.php' );
          remove_menu_page( 'export.php' );
          remove_menu_page( 'import.php?page=export_personal_data' );
          remove_menu_page( 'import.php?page=remove_personal_data' );
          remove_menu_page( 'job-order-list' );
          remove_menu_page( 'job-order-list#tabs-12' );
          remove_menu_page( 'confirm-job-list#tabs-12' );
          remove_menu_page( 'edit.php?post_type=add_department_type' );
          remove_menu_page( 'edit.php?post_type=add_machines_type' );
          remove_menu_page( 'edit.php?post_type=add_activities_type' );
          remove_menu_page( 'edit.php?post_type=add_job_number_type' );
          remove_menu_page( 'link-manager.php' );
          remove_menu_page( 'wp_file_manager' );
          remove_menu_page( 'maintenance' );
          remove_menu_page( 'confirm-job-list' );
          remove_menu_page( 'specific_job' );
          remove_menu_page( 'ai1wm_export' );
          remove_menu_page( 'wpfront-user-role-editor-all-roles' );
          remove_menu_page( 'backwpup' );
          // Include Templates
          //require get_template_directory() . '/admin/option-pages/class-worker-insert-job-option-page.php';
          break;
      case "pre_press":
          remove_menu_page( 'index.php' );                  //Dashboard
          remove_menu_page( 'jetpack' );                    //Jetpack*
          remove_menu_page( 'edit.php' );                   //Posts
          remove_menu_page( 'upload.php' );                 //Media
          remove_menu_page( 'edit.php?post_type=page' );    //Pages
          remove_menu_page( 'edit-comments.php' );          //Comments
          remove_menu_page( 'themes.php' );                 //Appearance
          remove_menu_page( 'plugins.php' );                //Plugins
          remove_menu_page( 'users.php' );                  //Users
          remove_menu_page( 'tools.php' );                  //Tools
          remove_menu_page( 'options-general.php' );        //Settings
          remove_menu_page( 'loginpress-settings' );
          remove_menu_page( 'ultimatemember' );
          remove_menu_page( 'profile.php' );
          remove_menu_page( 'import.php' );
          remove_menu_page( 'export.php' );
          remove_menu_page( 'import.php?page=export_personal_data' );
          remove_menu_page( 'import.php?page=remove_personal_data' );
          remove_menu_page( 'edit.php?post_type=add_department_type' );
          remove_menu_page( 'edit.php?post_type=add_machines_type' );
          remove_menu_page( 'edit.php?post_type=add_activities_type' );
          //remove_menu_page( 'edit.php?post_type=add_job_number_type' );
          remove_menu_page( 'link-manager.php' );
          remove_menu_page( 'wp_file_manager' );
          remove_menu_page( 'maintenance' );
          remove_menu_page( 'confirm-job-list' );
          remove_menu_page( 'specific_job' );
          remove_menu_page( 'ai1wm_export' );
          remove_menu_page( 'wpfront-user-role-editor-all-roles' );
          remove_menu_page( 'job-order-list' );
          remove_menu_page( 'backwpup' );
          break;
      case "owner_admin":   //administrator
          remove_menu_page( 'index.php' );                  //Dashboard
          remove_menu_page( 'jetpack' );                    //Jetpack*
          remove_menu_page( 'edit.php' );                   //Posts
          remove_menu_page( 'upload.php' );                 //Media
          remove_menu_page( 'edit.php?post_type=page' );    //Pages
          remove_menu_page( 'edit-comments.php' );          //Comments
          remove_menu_page( 'themes.php' );                 //Appearance
          remove_menu_page( 'plugins.php' );                //Plugins
         // remove_menu_page( 'users.php' );                  //Users
          remove_menu_page( 'tools.php' );                  //Tools
          remove_menu_page( 'options-general.php' );        //Settings
          remove_menu_page( 'loginpress-settings' );
          remove_menu_page( 'ultimatemember' );
          //remove_menu_page( 'profile.php' );
          remove_menu_page( 'import.php' );
          remove_menu_page( 'export.php' );
          remove_menu_page( 'import.php?page=export_personal_data' );
          remove_menu_page( 'import.php?page=remove_personal_data' );
          remove_menu_page( 'ai1wm_export' );
          remove_menu_page( 'wpfront-user-role-editor-all-roles' );
        //  remove_menu_page( 'job-order-list' );
         // remove_menu_page( 'edit.php?post_type=add_department_type' );
         // remove_menu_page( 'edit.php?post_type=add_machines_type' );
          //remove_menu_page( 'edit.php?post_type=add_activities_type' );
         // remove_menu_page( 'edit.php?post_type=add_job_number_type' );
          remove_menu_page( 'link-manager.php' );
          remove_menu_page( 'wp_file_manager' );
          remove_menu_page( 'backwpup' );
          //remove_menu_page( 'maintenance' );
          break;
      default:
          //echo "Your favorite color is neither red, blue, nor green!";
  }

}
add_action( 'admin_menu', 'ft_remove_menus', 999 );



// hide update notifications
function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes


add_action('after_setup_theme', 'wpdocs_theme_setup');

/**
* Load translations for wpdocs_theme
*/
function wpdocs_theme_setup(){
 load_theme_textdomain('wpdocs_theme', get_template_directory() . '/languages');
}

function remove_from_admin_bar($wp_admin_bar) {
 /*
  * Placing items in here will only remove them from admin bar
  * when viewing the fronte end of the site
 */
 global $wp_roles;
 $all_roles = $wp_roles->roles;
 //print_r( $all_roles['tootajad'] );

//if ( ! is_admin()  || isset( $all_roles['tootajad'] ) ) {
     // Example of removing item generated by plugin. Full ID is #wp-admin-bar-si_menu
     $wp_admin_bar->remove_node('si_menu');

     // WordPress Core Items (uncomment to remove)
     global $wp_roles;
     $wp_admin_bar->remove_node('updates');
     $wp_admin_bar->remove_node('comments');
     $wp_admin_bar->remove_node('new-content');
     $wp_admin_bar->remove_node('wp-logo');
     $wp_admin_bar->remove_node('site-name');
     //$wp_admin_bar->remove_node('my-account');
     $wp_admin_bar->remove_node('search');
     $wp_admin_bar->remove_node('customize');
     $wp_admin_bar->remove_node('customize-background');
     $wp_admin_bar->remove_node('customize-header');
// }

 /*
  * Items placed outside the if statement will remove it from both the frontend
  * and backend of the site
 */
 $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_from_admin_bar', 999);



// This will only work if the node is using a :before element for the icon
function clear_node_title( $wp_admin_bar ) {

 // Get all the nodes
 $all_toolbar_nodes = $wp_admin_bar->get_nodes();
 // Create an array of node ID's we'd like to remove
 $clear_titles = array(
     'site-name',
     'customize',
 );

 foreach ( $all_toolbar_nodes as $node ) {

     // Run an if check to see if a node is in the array to clear_titles
     if ( in_array($node->id, $clear_titles) ) {
         // use the same node's properties
         $args = $node;

         // make the node title a blank string
         $args->title = '';

         // update the Toolbar node
         $wp_admin_bar->add_node( $args );
     }
 }
}
add_action( 'admin_bar_menu', 'clear_node_title', 999 );
