<?php
class Prepress_Job_Fields_Plugin {
    public function __construct() {

    	add_action( 'admin_menu', array( $this, 'Prepress_create_plugin_settings_page' ) );
      add_action( 'admin_menu', array( $this, 'add_external_link_admin_submenu' ) , 100 );

    }



    public function add_external_link_admin_submenu() {

          $date = new DateTime(  );

          global $menu;
          foreach($menu as $k=>$item){
              if ($item[2] == 'Prepress_insert_job'){
                      $menu[$k][2] = admin_url( ) . 'admin.php?page=Prepress_insert_job#tabs-' . $date->format( 'm');
              }
          }
    }

    public function Prepress_create_plugin_settings_page() {
    	// Add the menu item and page
    	$page_title = 'Insert Job';
    	$menu_title = 'Insert Job';
    	$capability = 'manage_options';
    	$slug = 'Prepress_insert_job';
    	$callback = array( $this, 'Prepress_plugin_settings_page_content' );
    	$icon = 'dashicons-admin-plugins';
    	$position = 100;
    	add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }

    public function Prepress_job_number_select_options() {

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

    public function Prepress_activities_select_options() {
      $args = array(
          'posts_per_page' => -1,
          'post_type' => 'add_activities_type',
          'fields' => 'ids'
      );
      $custom_posts = get_posts($args);

      $array = array();

      foreach ($custom_posts as $key => $value) {
         $meta = get_post_meta( $value );
         $array[] = $meta['activities_fields_activities_name'][0];

      }

      return $array;
    }

    public function day_and_night_period( $now ) {

              //$now= '07:41'; //date("H:i:s");
              $sunrise = '05:59';
              $sunset = '21:59:';
              //$result = aaray();
              if ($sunrise < $sunset) {
                  if (($now > $sunrise) && ($now < $sunset))
                  {
                    $result .=  "day";
                  } else {
                    $result .= "night";
                  }
               } else  {
                  if (($now > $sunrise) || ($now < $sunset))
                  {
                    $result .= "day";
                  } else {
                    $result .= "night";
                  }
              }

              return $result;
    }

    public function Prepress_machine_select_options() {
      $args = array(
          'posts_per_page' => 20,
          'post_type' => 'add_machines_type',
          'fields' => 'ids'
      );
      $custom_posts = get_posts($args);

      $array = array();
      foreach ($custom_posts as $key => $value) {
         $meta = get_post_meta( $value );
         $array[] = $meta['machines_fields_machine_name'][0];

      }

      return $array;
    }

    public function calc_production_per_hour( $quantity, $hours) {
      $a = (int) $quantity;
      $b =  (int)$hours;

      $value = ( $a / $b );
      //print_r(  $a   );
      return $value;

    }



    //if (isset( $value['confirmed_'.$this->month]) != '' ) {
    public function year_worker_select_options() {

      $custom_posts = array( '2018', '2019', '2020' );

      $array = array();
      foreach ($custom_posts as $key => $value) {

         $array[] = $value;

      }

      //return $array;

      $year_select_options = $array;
      $year_selected = get_user_meta( get_current_user_id() , 'year_worker_selected_', true);
      //print_r( $year_selected );
      $html .= '<td>';
        $html .= '<select class="user-insert-job-select" name="year_worker_selected_">';
         foreach ( $year_select_options as $label => $field ) :
           $html .= '<option '.selected( $year_selected , $field, false ).' value="'.$field.'" >'.$field.'</option>';
         endforeach;
        $html .= '</select>';
      $html .= '</td>';
      return $html;

    }


    public function prepress_user_fields( $month, $saved_fields ) {

      $dates = new DateTime();

      $job_number_select_options = $this->Prepress_job_number_select_options();
      $activities_select_options = $this->Prepress_activities_select_options();
      $machine_select_options = $this->Prepress_machine_select_options();

      $user_department = get_user_meta( get_current_user_id(), 'cmb2_profile_fields_user_deparment', true);
      $current_user = wp_get_current_user();
      $user_query = new WP_User_Query( array( 'role' => 'tootajad' ) );
      $user_meta = get_userdata( get_current_user_id() );
      $user_roles = $user_meta->roles;
      //print_r( $repeatable_fields );
      $repeatable_fields = array( 0 => '' );


       if ( $saved_fields ) {
         $day_hours_array = array( );
         $night_hours_array = array();
         $all_hours_array = array();
         foreach ( $saved_fields as $key => $field ) {
             if ( isset( $field['day_and_night_period_'.$month] ) ) {
               $day_and_night_period =  $field['day_and_night_period_'.$month] ;
             }

           if ( 'day' == $day_and_night_period ) {
             if ( isset( $field['hours_spent_'.$month] ) ) {
               $day_hours_array[] = $field['hours_spent_'.$month] ;
             }

           } else {
             if ( isset( $field['hours_spent_'.$month] ) ) {
               $night_hours_array[] = $field['hours_spent_'.$month] ;
             }

           }

           if ( isset( $field['hours_spent_'.$month] ) ) {
             $all_hours_array[] = $field['hours_spent_'.$month] ;
           }
         }
       }

       if ( is_array( $day_hours_array ) xor is_array( $night_hours_array ) xor is_array( $all_hours_array ) ) {
         echo
         '<tr class="col-lg-12" >
             <td class="all-filtered-insert-job" >'.esc_html__("Day Hours", 'ilo-ee-ajaarvestus-template' ).': '.esc_attr( array_sum( $day_hours_array ) ).' h </td>
             <td class="all-filtered-insert-job" >'.esc_html__("Night Hours", 'ilo-ee-ajaarvestus-template' ).': '.esc_attr( array_sum( $night_hours_array ) ).' h </td>
             <td class="all-filtered-insert-job" >'.esc_html__("All Hours", 'ilo-ee-ajaarvestus-template' ).': '.esc_attr( array_sum( $all_hours_array ) ).' h </td>
         </tr>';
       }

      // print_r( $saved_fields );
      if (  is_array( $saved_fields ) ) {

      //foreach ( (array)$saved_fields as $keys => $value) {
        foreach ( $saved_fields as $key => $field ) {
          $year_selected = get_user_meta( get_current_user_id() , 'year_worker_selected_', true);
          if (  $year_selected == $field['return_year_'.$month]  ) {
            $date = new DateTime( $field['date'] );
          //}


            echo'<tr>';
            if (isset( $field['machine_select_'.$month]) != '' ) {
                echo'<td>';
                  echo'<select class="user-insert-job-select" name="job_number_select_'.$month.'[]">';
                   foreach ( $job_number_select_options as $label => $value ) :
                     echo'<option value="'.$value.'"'.selected( $field['job_number_select_'.$month], $value ).'>'.$value.'</option>';
                   endforeach;
                  echo'</select>';
                echo'</td>';
              }
              if (isset( $field['machine_select_'.$month]) != '' ) {
                echo'<td>';
                  echo'<select class="user-insert-job-select" name="activities_select_'.$month.'[]">';
                   foreach ( $activities_select_options as $label => $value ) :
                     echo'<option value="'.$value.'"'.selected( $field['activities_select_'.$month], $value ).'>'.$value.'</option>';
                   endforeach;
                  echo'</select>';
                echo'</td>';
              }
              if (isset( $field['machine_select_'.$month]) != '' ) {
                echo'<td>';
                  echo'<select class="user-insert-job-select" name="machine_select_'.$month.'[]">';
                   foreach ( $machine_select_options as $label => $value ) :
                     echo'<option value="'.$value.'"'.selected( $field['machine_select_'.$month], $value ).'>'.$value.'</option>';
                   endforeach;
                  echo'</select>';
                echo'</td>';
              }
              if( isset(  $field['date_'.$month] ) != '') {
                echo'<td id="theDatetd" ><input id="theDate" type="date"  class="widefat" name="date_'.$month.'[]" value="'.esc_attr( $field['date_'.$month] ).'" /></td>';
              }
              if( isset(  $field['begging-time_'.$month]) != '') {
                echo'<td><input type="time" class="widefat" name="begging-time_'.$month.'[]" value="'.esc_attr( $field['begging-time_'.$month] ).'" /></td>';
              }
              if( isset(  $field['end-time_'.$month]) != '') {
                echo'<td><input type="time" class="widefat" name="end-time_'.$month.'[]" value="'.esc_attr( $field['end-time_'.$month] ).'" /></td>';
              }
              if( isset(  $field['begging-time_'.$month]) != '' ) {
                echo'<td><input type="text" class="widefat" name="hours_spent_'.$month.'[]" readonly value="'.esc_attr( calculate_hour_diff( $field['begging-time_'.$month], $field['end-time_'.$month]  ) ).'" /></td>';
              }
              if( isset(  $field['quantity_'.$month]) != '') {
                echo'<td><input type="text" class="widefat" name="quantity_'.$month.'[]" value="'.esc_attr( $field['quantity_'.$month] ).'" /></td>';
              }
              if( isset(  $field['comment_'.$month]) != '') {
                echo'<td><input type="text" class="widefat" name="comment_'.$month.'[]" value="'.esc_attr( $field['comment_'.$month] ).'" /></td>';
              }
              if( isset(  $field['quantity_'.$month]) != '' ) {
                echo'<td><input type="text" readonly class="widefat" name="produced_per_hour_'.$month.'[]" value="'.esc_attr( $this->calc_production_per_hour($field['quantity_'.$month],$field['hours_spent_'.$month] ) ).'" /></td>';
              }
              if( isset(  $field['reject-quantity_'.$month]) != '') {
                echo'<td><input type="text" class="widefat" name="reject-quantity_'.$month.'[]" value="'.esc_attr( $field['reject-quantity_'.$month] ).'" /></td>';
              }
              if( isset(  $field['reject-comment_'.$month] ) != '') {
                echo'<td><input type="text" class="widefat" name="reject-comment_'.$month.'[]" value="'.esc_attr( $field['reject-comment_'.$month] ).'" /></td>';
              }
              //if($field['date'] != '') {
                echo'<td style="display: none;" ><input type="hidden" class="widefat" name="return_month_'.$month.'[]" value="'.esc_attr( $date->format( 'm') ).'" /></td>';
              //}
              //if($date->format( 'Y')) {
                echo'<td style="display: none;" ><input type="hidden" class="widefat" name="return_year_'.$month.'[]" value="'.esc_attr( $date->format( 'Y') ).'" /></td>';
              //}
              //if(  ! empty( $field['confirmed_'. $month_key ] ) or empty( $field['confirmed_'. $month_key ] ) ) {
                echo'<td style="display: none;" ><input type="hidden" class="widefat" name="confirmed_'.$month.'[]" value="'.esc_attr( $field['confirmed_'. $month] ).'" /></td>';
              //}
              if($user_roles) {
                echo'<td style="display: none;"><input type="hidden"  class="widefat" name="department_'.$month.'[]" value="'.esc_attr( implode( $user_department ) ).'" /></td>';
              }
              if( $current_user ) {
                echo'<td style="display: none;"><input type="hidden"  class="widefat" name="worker_name_'.$month.'[]"  value="'.esc_attr( $current_user->display_name ).'"/></td>';
              }
              if( $current_user ) {
                echo'<td style="display: none;"><input type="hidden"  class="widefat" name="worker_role_'.$month.'[]"  value="'.esc_attr( $current_user->roles[0] ).'"/></td>';
              }
              if( $current_user ) {
                echo'<td style="display: none;"><input type="hidden"  class="widefat" name="worker_user_id_'.$month.'[]"  value="'.esc_attr( $current_user->ID ).'"/></td>';
              }
              if( isset( $field['begging-time_'.$month] ) != '') {
                echo'<td style="display: none;"><input type="hidden"  class="widefat" name="day_and_night_period_'.$month.'[]" value="'.esc_attr( $this->day_and_night_period( $field['begging-time_'.$month] ) ).'" /></td>';
                //echo'<td><a class="button remove-row" href="#">Remove</a></td>';
                echo'<td></td>';
              }


          }

        echo'</tr>';

      //  }
      }

    }


   }

   public function prepress_user_fields_last_row( $month ) {

     $select_fields = new Prepress_Job_Fields_Plugin();
     $job_number_select_options = $select_fields->Prepress_job_number_select_options();
     $activities_select_options = $select_fields->Prepress_activities_select_options();
     $machine_select_options = $select_fields->Prepress_machine_select_options();
     $date = new DateTime();
     $date_output = $date->format('d-m-Y');

     $user_department = get_user_meta( get_current_user_id(), 'cmb2_profile_fields_user_deparment', true);
     $current_user = wp_get_current_user();
     $user_query = new WP_User_Query( array( 'role' => 'tootajad' ) );
     $user_meta = get_userdata( get_current_user_id() );
     $user_roles = $user_meta->roles;


         echo'<table>';

         echo'<tbody>';
           echo'<tr>';
             echo'<td><a>';
                   echo'<select class="user-insert-job-select" name="job_number_select_'.$month.'[]">';
                    foreach ( $job_number_select_options as $label => $value ) :
                      echo'<option value="'.$value.'"'.selected( $field['job_number_select_'.$month], $value ).'>'.$value.'</option>';
                    endforeach;
                   echo'</select>';
                 echo'</a></td>';


                 echo'<td><a>';
                   echo'<select class="user-insert-job-select" name="activities_select_'.$month.'[]">';
                    foreach ( $activities_select_options as $label => $value ) :
                      echo'<option value="'.$value.'"'.selected( $field['activities_select_'.$month], $value ).'>'.$value.'</option>';
                    endforeach;
                   echo'</select>';
                 echo'</a></td>';

                 echo'<td><a>';
                   echo'<select class="user-insert-job-select" name="machine_select_'.$month.'[]">';
                    foreach ( $machine_select_options as $label => $value ) :
                      echo'<option value="'.$value.'"'.selected( $field['machine_select_'.$month], $value ).'>'.$value.'</option>';
                    endforeach;
                   echo'</select>';
                 echo'</a></td>';


                 echo'<td><a><input type="date"  class="widefat" name="date_'.$month.'[]" value="'.$date->format('Y-m-d').'" /></a></td>';

                 echo'<td><a><input type="time" class="widefat" name="begging-time_'.$month.'[]" value="" /></a></td>';

                 echo'<td><a><input type="time" class="widefat" name="end-time_'.$month.'[]" value="'.$date->format('H:i:s').'" /></a></td>';

                 echo'<td><a><input type="text" class="widefat" placeholder="'.esc_html__( 'Empty', 'ilo-ee-ajaarvestus-template' ).'"  name="hours_spent_'.$month.'[]" readonly value="" /></a></td>';

                 echo'<td><a><input type="text" class="widefat" name="quantity_'.$month.'[]" value="" /></a></td>';

                 echo'<td><a><input type="text" class="widefat" name="comment_'.$month.'[]" value="" /></a></td>';

                 echo'<td><a><input type="text" readonly placeholder="'.esc_html__( 'Empty', 'ilo-ee-ajaarvestus-template' ).'" class="widefat" name="produced_per_hour_'.$month.'[]" value="" /></a></td>';

                 echo'<td><a><input type="text" class="widefat" name="reject-quantity_'.$month.'[]" value="" /></a></td>';

                 echo'<td><a><input type="text" class="widefat" name="reject-comment_'.$month.'[]" value="" /></a></td>';

                 //if($field['date'] != '') {
                   echo'<td style="display: none;" ><input type="hidden" class="widefat" name=" return_month_'.$month.'[]" value="'.esc_attr( $date->format( 'm') ).'" /></td>';
                 //}
                 //if($date->format( 'Y')) {
                   echo'<td style="display: none;" ><input type="hidden" class="widefat" name=" return_year_'.$month.'[]" value="'.esc_attr( $date->format( 'Y') ).'" /></td>';
                 //}
                 //if(  ! empty( $field['confirmed_'. $month_key ] ) or empty( $field['confirmed_'. $month_key ] ) ) {
                   echo'<td style="display: none;" ><input type="hidden" class="widefat" name=" confirmed_'.$month.'[]" value="no" /></td>';
                 //}
                 if($user_roles) {
                   echo'<td style="display: none;"><input type="hidden"  class="widefat" name=" department_'.$month.'[]" value="'.esc_attr( implode( $user_department ) ).'" /></td>';
                 }
                 if( $current_user ) {
                   echo'<td style="display: none;"><input type="hidden"  class="widefat" name=" worker_name_'.$month.'[]"  value="'.esc_attr( $current_user->display_name ).'"/></td>';
                 }
                 if( $current_user ) {
                   echo'<td style="display: none;"><input type="hidden"  class="widefat" name=" worker_role_'.$month.'[]"  value="'.esc_attr( $current_user->roles[0] ).'"/></td>';
                 }
                 if( $current_user ) {
                   echo'<td style="display: none;"><input type="hidden"  class="widefat" name=" worker_user_id_'.$month.'[]"  value="'.esc_attr( $current_user->ID ).'"/></td>';
                 }




                //echo'<td><a class="button remove-row" href="#">Remove</a></td>';
            echo'</tr>';

          echo'</tbody>';
          echo'</table>';
   }





    public function Prepress_plugin_settings_page_content() {
      $date = new DateTime(  );

        ?>
    	<div class="wrap">

    		<h2><?php echo _e('Insert Job Details', 'ilo-ee-ajaarvestus-template' ); ?></h2>
    		  <form method="POST">
                <input type="hidden" name="updated" value="true" />

                <?php
                global $post;
                $repeatable_fields = get_user_meta(get_current_user_id(), 'repeatable_fields_' . $date->format( 'm') , true);
                $job_number_select_options = $this->Prepress_job_number_select_options();
                $activities_select_options = $this->Prepress_activities_select_options();
                $machine_select_options = $this->Prepress_machine_select_options();
                //$job_list_deparments = get_post_meta( get_the_ID(), 'job_list_fields_user_deparment', true );

                //$old = get_user_meta( get_current_user_id(), 'cmb2_profile_fields_user_deparment', true);
                //print_r(  );

                function calculate_hour_diff( $start_time, $end_time ) {
                  $start_date = new DateTime( $start_time );
                  $since_start = $start_date->diff(new DateTime( $end_time ));
                  return $hours = $since_start->h;

                }


              //print_r( $repeatable_fields );
              $month_array  = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Decemeber'); ?>
                <?php $year_selected = get_user_meta( get_current_user_id() , 'year_selected', true);
                      print $this->year_worker_select_options(); ?>
                      <div id="tabs">
                        <ul class="admin-nav-tabs">
                         	<li class="month-item" ><a href="#tabs-1"><?php  _e( 'January', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                         	<li class="month-item" ><a href="#tabs-2"><?php  _e( 'February', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                         	<li class="month-item" ><a href="#tabs-3"><?php  _e( 'March', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-4"><?php  _e( 'April', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-5"><?php  _e( 'May', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-6"><?php  _e( 'June','ilo-ee-ajaarvestus-template'  ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-7"><?php  _e( 'July', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-8"><?php  _e( 'August', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-9"><?php  _e( 'September', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a href="#tabs-10"><?php  _e( 'October', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a  href="#tabs-11"><?php  _e( 'November', 'ilo-ee-ajaarvestus-template' ); ?></a></li>
                          <li class="month-item" ><a  href="#tabs-12"><?php  _e( 'Decemeber', 'ilo-ee-ajaarvestus-template' ); ?></a></li>

                        </ul>



                        <?php
                        $date = new DateTime(  );
                        if( $_POST['updated'] === 'true' ){
                            $date = new DateTime(  );
                            $this->Prepress_handle_form( $date->format( 'm') );
                        }
                          echo '<div class="add-new-row" ></div>';
                        foreach ( $month_array as $month_key => $month_value ) {

                            echo '<div id="tabs-'.$month_key.'">';

                              echo '<table  width="100%">';   ?>
                                <thead>
                                <tr>
                                  <th ><?php  _e('Job Number', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php  _e('Department', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php  _e('Activities', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('Date', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('Begging Time', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('End Time', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('Hours Spent', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php  _e('Quantity', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('Comment', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('Quantity / h', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php _e('Reject Quantity', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php  _e('Reject Comment', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                  <th ><?php  _e('', 'ilo-ee-ajaarvestus-template' ); ?></th>
                                </tr>
                               </thead>
                                <?php
                                echo '<tbody>';

                                  switch ( $month_key ) {
                                          case 1:
                                                if ( $month_key ) {

                                                  $user_metadata = get_user_meta( get_current_user_id() );
                                                  $job_number_select_options = $this->Prepress_job_number_select_options();
                                                  //print_r(  $user_metadata );
                                                  foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                    //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                      foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                        $decode_value = unserialize( $metadata_value );
                                                        //print_r(   );
                                                        if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                          $user_fields_array[$user_metadata_key] = $decode_value;
                                                        }
                                                      }
                                                      //print_r( $value );
                                                    //}
                                                  }
                                                  if ( is_array( $user_fields_array ) ) {
                                                    $this->prepress_user_fields( $month_key , $user_fields_array );
                                                  }
                                                  //print_r( $user_fields_array );
                                                }
                                            break;
                                          case 2:
                                                if ( $month_key ) {

                                                  $user_metadata = get_user_meta( get_current_user_id() );
                                                  $job_number_select_options = $this->Prepress_job_number_select_options();
                                                  //print_r(  $user_metadata );
                                                  foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                    //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                      foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                        $decode_value = unserialize( $metadata_value );
                                                        //print_r(   );
                                                        if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                          $user_fields_array[$user_metadata_key] = $decode_value;
                                                        }
                                                      }
                                                      //print_r( $value );
                                                    //}
                                                  }
                                                  if ( is_array( $user_fields_array ) ) {
                                                    $this->prepress_user_fields( $month_key , $user_fields_array );
                                                  }
                                                  //print_r( $user_fields_array );
                                                }
                                            break;
                                          case 3:
                                              if ( $month_key ) {

                                                $user_metadata = get_user_meta( get_current_user_id() );
                                                $job_number_select_options = $this->Prepress_job_number_select_options();
                                                //print_r(  $user_metadata );
                                                foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                  //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                    foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                      $decode_value = unserialize( $metadata_value );
                                                      //print_r(   );
                                                      if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                        $user_fields_array[$user_metadata_key] = $decode_value;
                                                      }
                                                    }
                                                    //print_r( $value );
                                                  //}
                                                }
                                                if ( is_array( $user_fields_array ) ) {
                                                  $this->prepress_user_fields( $month_key , $user_fields_array );
                                                }
                                                //print_r( $user_fields_array );
                                              }

                                            break;
                                          case 4:
                                                if ( $month_key ) {

                                                  $user_metadata = get_user_meta( get_current_user_id() );
                                                  $job_number_select_options = $this->Prepress_job_number_select_options();
                                                  //print_r(  $user_metadata );
                                                  foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                    //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                      foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                        $decode_value = unserialize( $metadata_value );
                                                        //print_r(   );
                                                        if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                          $user_fields_array[$user_metadata_key] = $decode_value;
                                                        }
                                                      }
                                                      //print_r( $value );
                                                    //}
                                                  }
                                                  if ( is_array( $user_fields_array ) ) {
                                                    $this->prepress_user_fields( $month_key , $user_fields_array );
                                                  }
                                                  //print_r( $user_fields_array );
                                                }
                                            break;
                                          case 5:
                                              if ( $month_key ) {

                                                $user_metadata = get_user_meta( get_current_user_id() );
                                                $job_number_select_options = $this->Prepress_job_number_select_options();
                                                //print_r(  $user_metadata );
                                                foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                  //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                    foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                      $decode_value = unserialize( $metadata_value );
                                                      //print_r(   );
                                                      if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                        $user_fields_array[$user_metadata_key] = $decode_value;
                                                      }
                                                    }
                                                    //print_r( $value );
                                                  //}
                                                }
                                                if ( is_array( $user_fields_array ) ) {
                                                  $this->prepress_user_fields( $month_key , $user_fields_array );
                                                }
                                                //print_r( $user_fields_array );
                                              }
                                            break;
                                          case 6:

                                              if ( $month_key ) {

                                                $user_metadata = get_user_meta( get_current_user_id() );
                                                $job_number_select_options = $this->Prepress_job_number_select_options();
                                                //print_r(  $user_metadata );
                                                foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                  //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                    foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                      $decode_value = unserialize( $metadata_value );
                                                      //print_r(   );
                                                      if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                        $user_fields_array[$user_metadata_key] = $decode_value;
                                                      }
                                                    }
                                                    //print_r( $value );
                                                  //}
                                                }
                                                if ( is_array( $user_fields_array ) ) {
                                                  $this->prepress_user_fields( $month_key , $user_fields_array );
                                                }
                                                //print_r( $user_fields_array );
                                              }
                                            break;
                                          case 7:
                                                  if ( $month_key ) {

                                                    $user_metadata = get_user_meta( get_current_user_id() );
                                                    $job_number_select_options = $this->Prepress_job_number_select_options();
                                                    //print_r(  $user_metadata );
                                                    foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                      //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                        foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                          $decode_value = unserialize( $metadata_value );
                                                          //print_r(   );
                                                          if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                            $user_fields_array[$user_metadata_key] = $decode_value;
                                                          }
                                                        }
                                                        //print_r( $value );
                                                      //}
                                                    }
                                                    if ( is_array( $user_fields_array ) ) {
                                                      $this->prepress_user_fields( $month_key , $user_fields_array );
                                                    }
                                                    //print_r( $user_fields_array );
                                                  }
                                            break;
                                          case 8:
                                                if ( $month_key ) {

                                                  $user_metadata = get_user_meta( get_current_user_id() );
                                                  $job_number_select_options = $this->Prepress_job_number_select_options();
                                                  //print_r(  $user_metadata );
                                                  foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                    //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                      foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                        $decode_value = unserialize( $metadata_value );
                                                        //print_r(   );
                                                        if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                          $user_fields_array[$user_metadata_key] = $decode_value;
                                                        }
                                                      }
                                                      //print_r( $value );
                                                    //}
                                                  }
                                                  if ( is_array( $user_fields_array ) ) {
                                                    $this->prepress_user_fields( $month_key , $user_fields_array );
                                                  }
                                                  //print_r( $user_fields_array );
                                                }

                                            break;
                                          case 9:

                                                if ( $month_key ) {

                                                  $user_metadata = get_user_meta( get_current_user_id() );
                                                  $job_number_select_options = $this->Prepress_job_number_select_options();
                                                  //print_r(  $user_metadata );
                                                  foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                    //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                      foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                        $decode_value = unserialize( $metadata_value );
                                                        //print_r(   );
                                                        if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                          $user_fields_array[$user_metadata_key] = $decode_value;
                                                        }
                                                      }
                                                      //print_r( $value );
                                                    //}
                                                  }
                                                  if ( is_array( $user_fields_array ) ) {
                                                    $this->prepress_user_fields( $month_key , $user_fields_array );
                                                  }
                                                  //print_r( $user_fields_array );
                                                }

                                            break;
                                          case 10:
                                                if ( $month_key ) {

                                                  $user_metadata = get_user_meta( get_current_user_id() );
                                                  $job_number_select_options = $this->Prepress_job_number_select_options();
                                                  //print_r(  $user_metadata );
                                                  foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                    //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                      foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                        $decode_value = unserialize( $metadata_value );
                                                        //print_r(   );
                                                        if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                          $user_fields_array[$user_metadata_key] = $decode_value;
                                                        }
                                                      }
                                                      //print_r( $value );
                                                    //}
                                                  }
                                                  if ( is_array( $user_fields_array ) ) {
                                                    $this->prepress_user_fields( $month_key , $user_fields_array );
                                                  }
                                                  //print_r( $user_fields_array );
                                                }


                                            break;
                                        case 11:
                                              if ( $month_key ) {

                                                $user_metadata = get_user_meta( get_current_user_id() );
                                                $job_number_select_options = $this->Prepress_job_number_select_options();
                                                //print_r(  $user_metadata );
                                                foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                  //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                    foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                      $decode_value = unserialize( $metadata_value );
                                                      //print_r(   );
                                                      if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                        $user_fields_array[$user_metadata_key] = $decode_value;
                                                      }
                                                    }
                                                    //print_r( $value );
                                                  //}
                                                }
                                                //print_r( $user_fields_array );
                                                if ( is_array( $user_fields_array ) ) {
                                                  $this->prepress_user_fields( $month_key , $user_fields_array );
                                                }

                                              }

                                          break;
                                        case 12:

                                              if ( $month_key ) {

                                                $user_metadata = get_user_meta( get_current_user_id() );
                                                $job_number_select_options = $this->Prepress_job_number_select_options();
                                                //print_r(  $user_metadata );
                                                foreach ( $user_metadata as $user_metadata_key => $user_metadata_value ) {
                                                  //if ( in_array( $user_metadata_key . '_' . $month_key, $job_number_select_options  ) ) {
                                                    foreach ( $user_metadata_value as $metadata_key => $metadata_value ) {
                                                      $decode_value = unserialize( $metadata_value );
                                                      //print_r(   );
                                                      if ( $decode_value['return_month_' . $month_key ] == $month_key ) {
                                                        $user_fields_array[$user_metadata_key] = $decode_value;
                                                      }
                                                    }
                                                    //print_r( $value );
                                                  //}
                                                }
                                                //print_r( $user_fields_array );


                                                if ( is_array( $user_fields_array ) ) {
                                                  $this->prepress_user_fields( $month_key , $user_fields_array );
                                                }
                                              }

                                            break;
                                          default:
                                            // code...
                                            break;
                                        }


                                       echo '</tbody>';
                                      echo '</table>';
                                echo '</div>';

                          }
                          echo '<div class="repeatable-fieldset-one" >';
                              echo '<div class="empty-row screen-reader-text" >';

                                 $this->prepress_user_fields_last_row( $date->format( 'm') )[0];


                              echo '</div>';
                          echo '</div>';?>

                       </div>
                     </div>
                   <p class="submit">
                      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save">
                      <a class="add-row" class="button" href="#">Add another</a>
                  </p>
                <script type="text/javascript">

                  //jQuery.noConflict();
                  jQuery(document).ready(function($) {


                    $( ".add-row" ).on("click", function() {
                      var row = $( ".empty-row.screen-reader-text" ).clone(true);
                      row.removeClass( "empty-row screen-reader-text" );
                      row.insertBefore( ".add-new-row" );

                      return false;
                    });

                    $( ".remove-row" ).on("click", function() {
                      $(this).parents("tr").remove();
                      return false;
                    });
                  });
                </script>

    		</form>

    	</div> <?php

    }
    public function Prepress_handle_form( $month ) {


        //$new = array( 0 => '');


        $job_number_select_options = $this->Prepress_job_number_select_options();
        $activities_select_options = $this->Prepress_activities_select_options();
        $machine_select_options = $this->Prepress_machine_select_options();
        $year_worker_selected = $_POST['year_worker_selected_'];


        $date = $_POST['date_'.$month];
        $names = $_POST['begging-time_'.$month];
        $end_time = $_POST['end-time_'.$month];
        $day_and_night_period = $_POST['day_and_night_period_'.$month];
        $hours_spent = $_POST['hours_spent_'.$month];
        $quantity = $_POST['quantity_'.$month];
        $comment = $_POST['comment_'.$month];
        $reject_quantity = $_POST['reject-quantity_'.$month];
        $reject_comment = $_POST['reject-comment_'.$month];
        $job_number_select = $_POST['job_number_select_'.$month];
        $department = $_POST['department_'.$month];
        $activities_select = $_POST['activities_select_'.$month];
        $machine_select = $_POST['machine_select_'.$month];
        $return_year = $_POST['return_year_'.$month];
        $return_month = $_POST['return_month_'.$month];
        $worker_name = $_POST['worker_name_'.$month];
        $produced_per_hour = $_POST['produced_per_hour_'.$month];
        //if(  ! isset( $_POST['confirmed_'.$month] ) ) {
          $confirmed = $_POST['confirmed_'.$month];
        //}
        $worker_user_id = $_POST['worker_user_id_'.$month];
        $worker_role = $_POST['worker_role_'.$month];
        if ( ! empty( $names ) ) {
            $count = count( $names );
        }


        for ( $i = 0; $i < $count; $i++ ) {
          if ( $names[$i] != '' ) :
            $new[$i]['date_'.$month] = stripslashes( strip_tags( $date[$i] ) );

            $new[$i]['begging-time_'.$month] = stripslashes( strip_tags( $names[$i] ) );

            $new[$i]['end-time_'.$month] = stripslashes( strip_tags( $end_time[$i] ) );

            $new[$i]['day_and_night_period_'.$month] = stripslashes( strip_tags( $day_and_night_period[$i] ) );

            $new[$i]['hours_spent_'.$month] = stripslashes( strip_tags( $hours_spent[$i] ) );

            $new[$i]['quantity_'.$month] = stripslashes( strip_tags( $quantity[$i] ) );

            $new[$i]['comment_'.$month] = stripslashes( strip_tags( $comment[$i] ) );

            $new[$i]['reject-quantity_'.$month] = stripslashes( strip_tags( $reject_quantity[$i] ) );

            $new[$i]['reject-comment_'.$month] = stripslashes( strip_tags( $reject_comment[$i] ) );

            $new[$i]['department_'.$month] = stripslashes( strip_tags( $department[$i] ) );

            $new[$i]['return_year_'.$month] = stripslashes( strip_tags( $return_year[$i] ) );

            $new[$i]['return_month_'.$month] = stripslashes( strip_tags( $return_month[$i] ) );

            $new[$i]['worker_name_'.$month] = stripslashes( strip_tags( $worker_name[$i] ) );

            $new[$i]['produced_per_hour_'.$month] = stripslashes( strip_tags( $produced_per_hour[$i] ) );

            $new[$i]['confirmed_'.$month] = stripslashes( strip_tags( $confirmed[$i] ) );

            $new[$i]['worker_role_'.$month] = stripslashes( strip_tags( $worker_role[$i] ) );

            $new[$i]['worker_user_id_'.$month] = stripslashes( strip_tags( $worker_user_id[$i] ) );


            if ( in_array( $job_number_select[$i], $job_number_select_options ) )
              $new[$i]['job_number_select_'.$month] = $job_number_select[$i];
            else
              $new[$i]['job_number_select_'.$month] = '';

            if ( in_array( $activities_select[$i], $activities_select_options ) )
              $new[$i]['activities_select_'.$month] = $activities_select[$i];
            else
              $new[$i]['activities_select_'.$month] = '';

            if ( in_array( $machine_select[$i], $machine_select_options ) )
              $new[$i]['machine_select_'.$month] = $machine_select[$i];
            else
              $new[$i]['machine_select_'.$month] = '';


          endif;
        }
        if ( is_array( $new ) ) {
          foreach ( (array)$new as $key => $value ) {
            $save_array[] = $value;
          }
        }

        //array_multisort( $new );
        //print_r( $save_array );
        update_user_meta( get_current_user_id(), 'year_worker_selected_' , $year_worker_selected  );

        if ( is_array( $save_array ) ) {
          foreach ( (array)$save_array as $key => $value ) {

          //update_user_meta( get_current_user_id(), 'user_worker_field_' . $key , $value );


            $get_field = get_user_meta( get_current_user_id(), 'user_worker_field_' . $key, false );

            if ( ! in_array( $value , $get_field  ) )
            {
              //print_r( $value );
              //print_r( $key );
              update_user_meta( get_current_user_id(), 'user_worker_field_' . $key , $value );
            } else {
              //print_r( $value );
              //print_r( $key );
              add_user_meta( get_current_user_id(), 'user_worker_field_' . $key , $value, true );
            }


          }

      }

    }

}
new Prepress_Job_Fields_Plugin();
