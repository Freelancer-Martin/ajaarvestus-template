<?php
class Overseer_confirm_Job_Order_List {
    public function __construct() {
      $user_meta = get_userdata( get_current_user_id() );
      $user_roles = $user_meta->roles;
    	add_action( 'admin_menu', array( $this, 'create_confirm_job_list_settings_page' ) );
      add_action( 'save_post', array( $this, 'confirm_job_handle_form' ), 1 );
      add_action( 'admin_menu', array( $this, 'add_external_link_admin' ) , 100 );

    }



    public function add_external_link_admin() {

        $user_meta = get_userdata( get_current_user_id() );
        $user_roles = $user_meta->roles;
        //print_r( $user_roles[0] );
        if(  in_array('overseer', $user_roles ) xor in_array('owner_admin ', $user_roles ) xor in_array('admin ', $user_roles ) xor in_array('administrator  ', $user_roles ) ) {
            $date = new DateTime(  );

            global $menu;
            foreach($menu as $k=>$item){
                if ($item[2] == 'confirm-job-list'){
                        $menu[$k][2] = admin_url( ) . 'admin.php?page=confirm-job-list#tabs-' . $date->format( 'm');
                }
            }
          }
      }


    public function create_confirm_job_list_settings_page() {

    	$page_title = 'Kinnita Tööd';
    	$menu_title = 'Kinnita Tööd';
    	$capability = 'manage_options';
    	$slug = 'confirm-job-list';
    	$callback = array( $this, 'confirm_job_list_page_content' );
    	$icon = 'dashicons-media-spreadsheet ';
    	$position = 100;
    	add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }




    public static function arrayDifference(array $array1, array $array2, array $keysToCompare = null) {
        $serialize = function (&$item, $idx, $keysToCompare) {
            if (is_array($item) && $keysToCompare) {
                $a = array();
                foreach ($keysToCompare as $k) {
                    if (array_key_exists($k, $item)) {
                        $a[$k] = $item[$k];
                    }
                }
                $item = $a;
            }
            $item = serialize($item);
        };
        $deserialize = function (&$item) {
            $item = unserialize($item);
        };
        array_walk($array1, $serialize, $keysToCompare);
        array_walk($array2, $serialize, $keysToCompare);
        // Items that are in the original array but not the new one
        $deletions = array_diff($array1, $array2);
        $insertions = array_diff($array2, $array1);
        array_walk($insertions, $deserialize);
        array_walk($deletions, $deserialize);
        return array('insertions' => $insertions, 'deletions' => $deletions);
    }

    public function job_select_field_array_values() {

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
           $array[] = $meta['job_list_fields_job_name'][0];
        // }
         //print_r( $user_deparment );
      }

      return $array;
    }



    public function year_select_options() {

      $custom_posts = array( '2018', '2019', '2020' );

      $array = array();
      foreach ($custom_posts as $key => $value) {

         $array[] = $value;

      }

      return $array;
    }



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
      $job_list = $this->job_select_field_array_values();

      foreach ( $get_users as $user_id ) {
        $user_fields = get_user_meta( $user_id );
        $user_field_array[$user_id] = $user_fields;
      }


      foreach ( $user_field_array as $user_field_key => $user_field_value ) {
          foreach ( $user_field_value as $field_key => $field_value ) {
            //if ( in_array( $field_key,  $job_list ) ) {
               foreach ( $field_value as $key => $value ) {
                 $filtered_fields[] = unserialize( $value );
                 //print_r( $fields );
               }
          //  }
          }
        }


      foreach ( $filtered_fields as $filtered_key => $filtered_value ) {
        //print_r( $filtered_value['worker_user_id_'. $month ] );
        $filtered_user_fields[$filtered_value['worker_user_id_'. $month ]][] = $filtered_value;
      }

      return $filtered_user_fields;

    }


    public function confirm_job_list_page_content() {  ?>
    	<div class="wrap">
    		<form method="POST">
                <input type="hidden" name="updated" value="true" />
                      <?php


                      $month_array  = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Decemeber'); ?>
                      <?php
                          $year_select_options = $this->year_select_options();
                          $year_selected = get_user_meta( get_current_user_id() , 'year_selected', true);
                          //print_r( $year_selected );
                          //if (isset( $value['confirmed_'.$this->month]) != '' ) {
                            $html .= '<td>';
                              $html .= '<select class="user-insert-job-select" name="year_selected">';
                               foreach ( $year_select_options as $label => $field ) :
                                 $html .= '<option '.selected( $year_selected , $field, false ).' value="'.$field.'" >'.$field.'</option>';
                               endforeach;
                              $html .= '</select>';
                            $html .= '</td>';
                            print $html;
                          //}
                       ?>
                      <div id="tabs">
                        <ul class="admin-nav-tabs">
                          <li class="month-item" ><a href="#tabs-1"><?php  _e( 'January', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-2"><?php  _e( 'February', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
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

                            echo '<div id="tabs-'.$month_key.'">';
                            //print_r( $b );
                            echo '<table  width="100%">';


                                ?>
                                  <thead>
                                    <tr>
                                      <tr>
                                        <th width="8%"><?php echo _e('Confirmed', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="8%"><?php echo _e('Job Number', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="8%"><?php echo _e('Worker Name', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="8%"><?php echo _e('Deparment', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="8%"><?php echo _e('Activities', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="8%"><?php echo _e('Machine', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Date', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Begging Time', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('End Time', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Hours Spent', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Quantity', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Comment', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Quantity / h', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Reject Quantity', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                        <th width="10%"><?php echo _e('Reject Comment', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                      </tr>
                                    </tr>
                                   </thead>
                                  <?php

                                echo '<tbody>';
                                  //print_r( '<p>'.$month_key.'</p>'  );
                                  //print_r( $month_value );
                                  switch ( $month_key ) {
                                    case 1:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 2:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 3:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 4:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 5:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 6:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 7:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 8:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 9:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                          $get_fields = $this->get_user_fields( $month_key );
                                          $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                          $saved_fields = $filtered_fields->return_saved_fields();
                                          $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                          //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          if ( $none_saved_fields ) {
                                            $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                          }
                                          if ( $saved_fields ) {
                                            $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                          }
                                          //print_r( $none_saved_fields );


                                        }

                                      break;
                                    case 10:
                                      $date = new DateTime(  );
                                      if ( $month_key ) {
                                        $get_fields = $this->get_user_fields( $month_key );
                                        $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                        $saved_fields = $filtered_fields->return_saved_fields();
                                        $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                        //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                        if ( $none_saved_fields ) {
                                          $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                        }
                                        if ( $saved_fields ) {
                                          $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                        }
                                        //print_r( $none_saved_fields );


                                      }

                                      break;
                                  case 11:
                                      $date = new DateTime(  );
                                      if ( $month_key ) {
                                        $get_fields = $this->get_user_fields( $month_key );
                                        $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                        $saved_fields = $filtered_fields->return_saved_fields();
                                        $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                        //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                        if ( $none_saved_fields ) {
                                          $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                        }
                                        if ( $saved_fields ) {
                                          $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                        }
                                        //print_r( $none_saved_fields );

                                      }

                                    break;
                                  case 12:
                                        $date = new DateTime(  );
                                        if ( $month_key ) {
                                            $get_fields = $this->get_user_fields( $month_key );
                                            $filtered_fields = new Overseer_Filter_User_Fields( $month_key , $get_fields );

                                            $saved_fields = $filtered_fields->return_saved_fields();
                                            $none_saved_fields = $filtered_fields->return_none_saved_fields();
                                            //$display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                            if ( $none_saved_fields ) {
                                              $display_none_fields = new Display_Filtered_User_Fields( $month_key , $none_saved_fields  );
                                            }
                                            if ( $saved_fields ) {
                                              $display_saved_fields = new Display_Filtered_User_Fields( $month_key , $saved_fields  );
                                            }
                                            //print_r( $none_saved_fields  );


                                        }
                                      break;
                                    default:
                                      // code...
                                      break;
                                  }

                                  if( $_POST['updated'] === 'true' ){
                                    $save_user_fields = new Overseer_Save_User_Fields( $month_key , $none_saved_fields  );
                                  }

                                   echo '</tbody>';
                                  echo '</table>';
                            echo '</div>';
                          }

                           ?>

                        </div>
                      </div>



                      <p class="submit">
                         <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo _e( 'Confirm job list', 'ilo-ee-ajaarvestus-template' ) ?>">
                      </p>


                  </form>
                  </div>



               <?php
      }









}
new Overseer_confirm_Job_Order_List();
