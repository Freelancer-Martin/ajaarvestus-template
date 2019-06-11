<?php
class Job_Order_List {
    public function __construct() {

      add_action( 'admin_menu', array( $this, 'create_job_order_list_settings_page' ) );
      add_action('wp_ajax_save_cool_options',  array( $this, 'save_cool_options' ) );
      add_action( 'admin_menu', array( $this, 'add_external_link' ) , 100 );

    }



    public function add_external_link() {
      $user_meta = get_userdata( get_current_user_id() );
      $user_roles = $user_meta->roles;
      //print_r( $user_roles[0] );
      if(  in_array('overseer', $user_roles ) xor in_array('owner_admin ', $user_roles ) xor in_array('admin ', $user_roles ) xor in_array('administrator  ', $user_roles ) ) {
          $date = new DateTime(  );

          global $menu;
          if (is_array( $menu ) || is_object( $menu ))
          {
            foreach( (array) $menu as $k=>$item ){
                if ($item[2] == 'job-order-list'){
                        $menu[$k][2] = admin_url( ) . 'admin.php?page=job-order-list#tabs-' . $date->format( 'm');
                }
            }
          }
        }
    }

    public function save_cool_options() {
        global $wpdb; // this is how you get access to the database

        $itemArray = array(
            'html_tag' => $_POST['html_tag'],
            'month' => $_POST['month'],
            //'favorite_color' => $_POST['color'],
        );

        $saveData = json_encode($itemArray);
        update_user_meta( get_current_user_id(), 'save_html_tag', $saveData);
        //print_r( $saveData );
        echo 'true';

        die(); // this is required to return a proper result
    }


    public function create_job_order_list_settings_page() {
      // Add the menu item and page
      $page_title = 'Töö Aruannded';
      $menu_title = 'Töö Aruannded';
      $capability = 'manage_options';
      $slug = 'job-order-list';
      $callback = array( $this, 'job_order_list_page_content' );
      $icon = 'dashicons-media-spreadsheet ';
      $position = 100;
      add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }



    public function user_fields ( $fields_array, $month ) {
      $year_selected = get_user_meta( get_current_user_id() , 'year_confirmed_selected', true);
      if ( is_array( $fields_array ) ) {
      foreach ( $fields_array as $fields_key => $fields_field ) {
        //print_r( $fields_field );
        foreach ( $fields_field as $key => $field ) {
          //print_r( count( $field ) );
          if ( ! empty( $field ) ) {
            //print_r( $field['return_year_'.$month ] );


          //    if ( $field['confirmed_'.$month ] == 'yes' ) {
              echo '<div class="job-list-container" >';

                  if ( isset( $field['job_number_select_'.$month ] ) ) {
                    echo '<div class="job-list-inside-container" >';

                            print  '<h6><input readonly type="hidden"   class="widefat" name="job_number_select[]" value="'.$field['job_number_select_'.$month].'" />'.$field['job_number_select_'.$month].'</h6>';
                            print '<a class="ajax-save-html-tag" value="'.$field['job_number_select_'.$month].'" href="'.esc_url( admin_url() . 'admin.php?page=specific_job#' . $field['return_month_'.$month] ).'" >
                            <input readonly type="hidden"   class="ajax-month-value" name="ajax-month-value[]" value="'.$month.'" />
                            <input readonly type="hidden"   class="ajax-html-tag-value" name="ajax-html-tag-value[]" value="'.$field['job_number_select_'.$month].'" />'.esc_html__( 'View job time report' , 'ilo-ee-ajaarvestus-template' ).'</a></br>';

                    echo '</div><br>';
                  }

              echo '</div>';
            }

        //    }


          }

        }

      }
    }

    //if (isset( $value['confirmed_'.$this->month]) != '' ) {
    public function year_confirmed_select_options() {

      $custom_posts = array( '2018', '2019', '2020' );

      $array = array();
      foreach ($custom_posts as $key => $value) {

         $array[] = $value;

      }

      //return $array;

      $year_select_options = $array;
      $year_selected = get_user_meta( get_current_user_id() , 'year_confirmed_selected', true);
      //print_r( $year_selected );
      $html .= '<td>';
        $html .= '<select class="user-insert-job-select" name="year_confirmed_selected">';
         foreach ( $year_select_options as $label => $field ) :
           $html .= '<option '.selected( $year_selected , $field, false ).' value="'.$field.'" >'.$field.'</option>';
         endforeach;
        $html .= '</select>';
      $html .= '</td>';
      return $html;

    }
    //}

    public function get_user_fields( $month  )
    {
      $year_selected = get_user_meta( get_current_user_id() , 'year_selected', true);
      $args = array(
          'posts_per_page' => -1,
          'post_type' => 'user',
          'fields' => 'ids',
/*
          'date_query' => array(
            array(
              //'year'  => $year_selected,
              //'month' => ,
              //'day'   => 12,
            ),
          ),
*/
      );
      $get_users =  get_users($args);

      if( is_array( $get_users )  ) {
        foreach ( $get_users as $user_id ) {
          $user_fields = get_user_meta( $user_id );
          $user_field_array[$user_id] = $user_fields;
        }
      }

      if( is_array( $user_field_array )  ) {
      foreach ( (array)$user_field_array as $user_field_key => $user_field_value ) {
          foreach ( (array)$user_field_value as $field_key => $field_value ) {
            //if ( in_array( $field_key,  $job_list ) ) {
               foreach ( (array)$field_value as $key => $value ) {
                 if( isset( $value ) ) {
                 $filtered_fields[] = unserialize( $value );
                 //print_r( $fields );
                }
               }
          //  }
          }
        }
      }


      if( is_array( $filtered_fields )  ) {
        foreach ( (array)$filtered_fields as $filtered_key => $filtered_value ) {
          //print_r( $filtered_value['worker_user_id_'. $month ] );
          $filtered_user_fields[$filtered_value['worker_user_id_'. $month ]][] = $filtered_value;
        }
      }
      //print_r( $filtered_user_fields );


      //print_r( $sorted_user_fields );
      $filtered_deparmnet_array = array( );
      $deparment_array = array( 'Ettevalmistus', 'Müügiosakond', 'Järeltöötlus', 'Trükk', 'Transport'  );
      $user_department = get_user_meta( get_current_user_id() , 'cmb2_profile_fields_user_deparment', true);
      foreach ( $filtered_user_fields as $filtered_deparmnet_key => $filtered_deparmnet_value ) {
        foreach ( $filtered_deparmnet_value as $deparmnet_key => $deparmnet_value ) {
          if( in_array(  $deparmnet_value['department_'. $month ]  , $user_department )  ) {
            if ( in_array( $deparmnet_value['department_'. $month ] , $deparment_array ) ) {
                $filtered_deparmnet_array[$filtered_deparmnet_key] = $filtered_deparmnet_value;
            }
          }
        }
        //print_r( $filtered_deparmnet_value['department_'. $month_key ] );
      }
    //print_r(   $filtered_deparmnet_array );


    $this_month_value = array();
    $year_selected = get_user_meta( get_current_user_id() , 'year_confirmed_selected', true);
    foreach ( $filtered_deparmnet_array as $filtered_array_key => $filtered_array_values ) {
      foreach ( $filtered_array_values as $filtered_key => $filtered_value) {
        if ( $year_selected == $filtered_value['return_year_'. $month]   ) {
          if ( $month == $filtered_value['return_month_'. $month]   ) {
            if ( 'yes' == $filtered_value['confirmed_'. $month]   ) {
              $december_month_fields[$filtered_key][] = $filtered_value;
            }
          }
        }
      }
    }
      return $december_month_fields;

    }



    public function job_order_list_page_content() { ?>

    	<div class="wrap">
    		<form method="POST">
                <input type="hidden" name="updated" value="true" />
                      <?php


                      $month_array  = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Decemeber'); ?>
                      <?php print $this->year_confirmed_select_options(); ?>
                      <div id="tabs">
                        <ul class="admin-nav-tabs">
                          <li class="month-item" ><a href="#tabs-1"><?php  _e( 'January', 'ilo-ee-ajaarvestus-template'); ?></a></li>
                          <li class="month-item" ><a href="#tabs-2"><?php  _e( 'February', 'ilo-ee-ajaarvestus-template'); ?></a></li>
                          <li class="month-item" ><a href="#tabs-3"><?php  _e( 'March', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-4"><?php  _e( 'April', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-5"><?php  _e( 'May', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-6"><?php  _e( 'June', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-7"><?php  _e( 'July', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-8"><?php  _e( 'August', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-9"><?php  _e( 'September', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-10"><?php  _e( 'October', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a  href="#tabs-11"><?php  _e( 'November', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a  href="#tabs-12"><?php  _e( 'Decemeber', 'ilo-ee-ajaarvestus-template' ); ?></a></li>

                        </ul>
                        <div id="repeatable-fieldset-one" >
                        <?php

                        foreach ( $month_array as $month_key => $month_value ) {
                            if( isset( $confirmed_array[$month_key]['return_month'] ) ) {
                              $b = $confirmed_array[$month_key]['return_month'];
                            }
                            echo '<div id="tabs-'.$month_key.'">';
                            //print_r( $b );
                            echo '<table  width="100%">';

                                echo '<tbody>';
                                  //print_r( '<p>'.$month_key.'</p>'  );
                                  //print_r( $month_value );
                                  switch ( $month_key ) {
                                    case 1:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 2:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 3:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 4:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 5:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 6:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }

                                      break;
                                    case 7:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 8:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 9:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 10:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                        break;
                                    case 11:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }
                                      break;
                                    case 12:
                                        if ( $month_key ) {

                                          $sorted_user_fields = $this->get_user_fields( $month_key );
                                            //print_r( $december_month_fields );
                                           //$saved_fields_array = get_post_meta( get_current_user_id(), 'confirm_user_fields_'. $month_key , true);


                                           $this->user_fields( $sorted_user_fields , $month_key  );


                                         }

                                      break;
                                    default:
                                      // code...
                                      break;
                                  }
                                  if( $_POST['updated'] === 'true' ){
                                      //$this->save_cool_options();
                                      $this->save_confirmed_user_fields(  );
                                  }


                                   echo '</tbody>';
                                  echo '</table>';
                            echo '</div>';
                          }

                           ?>
                           <p class="submit">
                              <input type="submit" name="submit" id="submit" class="button button-primary" value="Save">

                          </p>
                        </div>
                      </div>
                    </form>
                  </div>
            <?php }

            public function save_confirmed_user_fields( )
            {


                  $year_selected = $_POST['year_confirmed_selected'];
                  //print_r( $year_selected  );
                  update_user_meta( get_current_user_id() , 'year_confirmed_selected' , $year_selected );

            }


}
new Job_Order_List();
