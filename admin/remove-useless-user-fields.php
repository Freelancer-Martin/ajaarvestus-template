<?php
// be nice to the children (make it pluggable)

  function butter_modified_fields( $contact_methods ){

    $contact_methods['skype'] = __('Skype Username', 'butter');
    $contact_methods['twitter'] = __('Twitter Username', 'butter');
    $contact_methods['dribbble'] = __('Dribbble Username', 'butter');
    $contact_methods['facebook'] = __('Full FB URL', 'butter');

    // Unset fields you don’t need
    // you CAN do this but maybe think about it before you do
    unset($contact_methods['aim']);
    unset($contact_methods['jabber']);
    unset($contact_methods['facebook']);
    unset($contact_methods['dribbble']);
    unset($contact_methods['email']);
    unset($contact_methods['skype']);
    unset($contact_methods['twitter']);
    unset($contact_methods['url']);
    unset($contact_methods['yim']);
    unset($contact_methods['admin_color_scheme_picker']);


    return $contact_methods;
  }

  add_filter('user_contactmethods', 'butter_modified_fields');
  remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
  add_action( 'admin_head', function(){
      ob_start(); ?>
      <style>
          #your-profile > h2,
          .user-rich-editing-wrap,
          .user-syntax-highlighting-wrap,
          .user-comment-shortcuts-wrap,
          .user-admin-bar-front-wrap {
              display: none;
          }
      </style>
      <?php ob_end_flush();
  });


  add_action( 'personal_options', array ( 'T5_Hide_Profile_Bio_Box', 'start' ) );

  /**
   * Captures the part with the biobox in an output buffer and removes it.
   *
   * @author Thomas Scholz, <info@toscho.de>
   *
   */
  class T5_Hide_Profile_Bio_Box
  {
      /**
       * Called on 'personal_options'.
       *
       * @return void
       */
      public static function start()
      {
          $action = ( IS_PROFILE_PAGE ? 'show' : 'edit' ) . '_user_profile';
          add_action( $action, array ( __CLASS__, 'stop' ) );
          ob_start();
      }

      /**
       * Strips the bio box from the buffered content.
       *
       * @return void
       */
      public static function stop()
      {
          $html = ob_get_contents();
          ob_end_clean();

          // remove the headline
          $headline = __( IS_PROFILE_PAGE ? 'About Yourself' : 'About the user' );
          $html = str_replace( '<h2>' . $headline . '</h2>', '', $html );

          // remove the table row
          $html = preg_replace( '~<tr>\s*<th><label for="description".*</tr>~imsUu', '', $html );
          print $html;
      }
  }
  $start_Class = new T5_Hide_Profile_Bio_Box();
