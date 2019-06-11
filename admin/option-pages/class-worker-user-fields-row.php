<?php class WorkerUserFieldsEmptyRow {

  private $month;

  function __construct( $month )
  {

    $this->month = $month;

    $this->worker_role_user_fields_last_row( $month );
    //if( $_POST['updated'] === 'true' ){
      //$this->worker_role_user_fields_handle_form( $month );
    //}

  }

  public function calculate_hour_diff( $start_time, $end_time ) {
    $start_date = new DateTime( $start_time );
    $since_start = $start_date->diff(new DateTime( $end_time ));
    return $hours = $since_start->h;

  }


  public function worker_role_user_fields_last_row( $month ) {


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
                  echo'<select class="user-insert-job-select" name=" job_number_select_'.$month.'[]">';
                   foreach ( $job_number_select_options as $label => $value ) :
                     echo'<option value="'.$value.'"'.selected( $field[' job_number_select_'.$month], $value ).'>'.$value.'</option>';
                   endforeach;
                  echo'</select>';
                echo'</a></td>';

/*
                echo'<td>'.cmb2_metabox_form( 'autocomplete_test' ).'
                    <input type="hidden"  class="widefat" name="job_number_select_'.$month.'[]"  value=""/>
                  </td>';
*/


                echo'<td><a>';
                  echo'<select class="user-insert-job-select" name=" activities_select_'.$month.'[]">';
                   foreach ( $activities_select_options as $label => $value ) :
                     echo'<option value="'.$value.'"'.selected( $field[' activities_select_'.$month], $value ).'>'.$value.'</option>';
                   endforeach;
                  echo'</select>';
                echo'</a></td>';

                echo'<td><a>';
                  echo'<select class="user-insert-job-select" name=" machine_select_'.$month.'[]">';
                   foreach ( $machine_select_options as $label => $value ) :
                     echo'<option value="'.$value.'"'.selected( $field[' machine_select_'.$month], $value ).'>'.$value.'</option>';
                   endforeach;
                  echo'</select>';
                echo'</a></td>';


                echo'<td><a><input type="date"  class="widefat" name=" date_'.$month.'[]" value="'.$date->format('Y-m-d').'" /></a></td>';

                echo'<td><a><input type="time" class="widefat" name=" begging-time_'.$month.'[]" value="" /></a></td>';

                echo'<td><a><input type="time" class="widefat" name=" end-time_'.$month.'[]" value="'.$date->format('H:i:s').'" /></a></td>';

                echo'<td><a><input type="text" class="widefat" placeholder="'.esc_html__( 'Empty', 'ilo-ee-ajaarvestus-template' ).'"  name=" hours_spent_'.$month.'[]" value="'.$_POST[' return_year_'.$month].'" readonly value="" /></a></td>';

                echo'<td><a><input type="text" class="widefat" name=" quantity_'.$month.'[]" value="" /></a></td>';

                echo'<td><a><input type="text" class="widefat" name=" comment_'.$month.'[]" value="" /></a></td>';

                echo'<td><a><input type="text" readonly placeholder="'.esc_html__( 'Empty', 'ilo-ee-ajaarvestus-template' ).'" class="widefat" name=" produced_per_hour_'.$month.'[]" value="" /></a></td>';

                echo'<td><a><input type="text" class="widefat" name=" reject-quantity_'.$month.'[]" value="" /></a></td>';

                echo'<td><a><input type="text" class="widefat" name=" reject-comment_'.$month.'[]" value="" /></a></td>';

                //if($field['date'] != '') {
                  echo'<td style="display: none;" ><input type="hidden" class="widefat" name=" return_month_'.$month.'[]" value="'.esc_attr( $date->format( 'm') ).'" /></td>';
                //}
                //if($date->format( 'Y')) {
                  echo'<td style="display: none;" ><input type="hidden" class="widefat" name=" return_year_'.$month.'[]" value="'.esc_attr( $date->format( 'Y') ).'" /></td>';
                //}
                //if(  ! empty( $field['confirmed_'. $month_key ] ) or empty( $field['confirmed_'. $month_key ] ) ) {
                  echo'<td style="display: none;" ><input type="hidden" class="widefat" name=" confirmed_'.$month.'[]" value="'.esc_attr( $field['confirmed_'. $month] ).'" /></td>';
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



               echo'<td><a class="button remove-row" href="#">Remove</a></td>';
           echo'</tr>';

         echo'</tbody>';
         echo'</table>';
  }


  public function worker_role_user_fields_handle_form( $month ) {


      //$new = array( 0 => '');

      $select_fields = new Prepress_Job_Fields_Plugin();
      $job_number_select_options = $select_fields->Prepress_job_number_select_options();
      $activities_select_options = $select_fields->Prepress_activities_select_options();
      $machine_select_options = $select_fields->Prepress_machine_select_options();
      //if ( ! empty( $_POST['reject-comment_'.$month]  ) && isset( $_POST['reject-comment_'.$month]  ) ) {
        // code...

      $date = $_POST[' date_'.$month];
      $names = $_POST[' begging-time_'.$month];
      $end_time = $_POST[' end-time_'.$month];
      $day_and_night_period = $_POST[' day_and_night_period_'.$month];
      $hours_spent = $_POST[' hours_spent_'.$month];
      $quantity = $_POST[' quantity_'.$month];
      $comment = $_POST[' comment_'.$month];
      $reject_quantity = $_POST[' reject-quantity_'.$month];
      $reject_comment = $_POST[' reject-comment_'.$month];
      $job_number_select = $_POST[' job_number_select_'.$month];
      $department = $_POST[' department_'.$month];
      $activities_select = $_POST[' activities_select_'.$month];
      $machine_select = $_POST[' machine_select_'.$month];
      $return_year = $_POST[' return_year_'.$month];
      $return_month = $_POST[' return_month_'.$month];
      $worker_name = $_POST[' worker_name_'.$month];
      $produced_per_hour = $_POST[' produced_per_hour_'.$month];
      //if(  ! isset( $_POST['confirmed_'.$month] ) ) {
      $empty_confirmed = $_POST[' confirmed_'.$month];
      //}
      $worker_user_id = $_POST[' worker_user_id_'.$month];
      $worker_role = $_POST[' worker_role_'.$month];
      if ( isset( $names ) ) {
        $count = array_sum( $names );
      }
      for ( $i = 0; $i < $count; $i++ ) {
        if ( $names[$i] != '') :
          $new[$i][' date_'.$month] = stripslashes( strip_tags( $date[$i] ) );

          $new[$i][' begging-time_'.$month] = stripslashes( strip_tags( $names[$i] ) );

          $new[$i][' end-time_'.$month] = stripslashes( strip_tags( $end_time[$i] ) );

          $new[$i][' night_period_'.$month] = stripslashes( strip_tags( $day_and_night_period[$i] ) );

          $new[$i][' hours_spent_'.$month] = stripslashes( strip_tags( $hours_spent[$i] ) );

          $new[$i][' quantity_'.$month] = stripslashes( strip_tags( $quantity[$i] ) );

          $new[$i][' comment_'.$month] = stripslashes( strip_tags( $comment[$i] ) );

          $new[$i][' reject-quantity_'.$month] = stripslashes( strip_tags( $reject_quantity[$i] ) );

          $new[$i][' reject-comment_'.$month] = stripslashes( strip_tags( $reject_comment[$i] ) );

          $new[$i][' department_'.$month] = stripslashes( strip_tags( $department[$i] ) );

          $new[$i][' return_year_'.$month] = stripslashes( strip_tags( $return_year[$i] ) );

          $new[$i][' return_month_'.$month] = stripslashes( strip_tags( $return_month[$i] ) );

          $new[$i][' worker_name_'.$month] = stripslashes( strip_tags( $worker_name[$i] ) );

          $new[$i][' produced_per_hour_'.$month] = stripslashes( strip_tags( $produced_per_hour[$i] ) );

          $new[$i][' confirmed_'.$month] = stripslashes( strip_tags( $empty_confirmed[$i] ) );

          $new[$i][' worker_role_'.$month] = stripslashes( strip_tags( $worker_role[$i] ) );

          $new[$i][' worker_user_id_'.$month] = stripslashes( strip_tags( $worker_user_id[$i] ) );


          if ( in_array( $job_number_select[$i], $job_number_select_options ) )
            $new[$i][' job_number_select_'.$month] = $job_number_select[$i];
          else
            $new[$i][' job_number_select_'.$month] = '';

          if ( in_array( $activities_select[$i], $activities_select_options ) )
            $new[$i][' activities_select_'.$month] = $activities_select[$i];
          else
            $new[$i][' activities_select_'.$month] = '';

          if ( in_array( $machine_select[$i], $machine_select_options ) )
            $new[$i][' machine_select_'.$month] = $machine_select[$i];
          else
            $new[$i][' machine_select_'.$month] = '';


        endif;
      }
      //array_multisort( $new );
      //print_r( $job_number_select[0] );

      //add_user_meta( get_current_user_id(), $job_number_select[0] , $new, true );
    }
//  }


}
