<?php
Class Overseer_Save_User_Fields
{
  private $fields;
  private $month;

  public function __construct(  $month, $fields ) {

    $this->fields = $fields;
    $this->month = $month;
    $this->filter_and_save_user_fields( $fields );

  }


  public function confirm_select_options() {

    $custom_posts = array( 'no', 'yes');

    $array = array();
    foreach ($custom_posts as $key => $value) {

       $array[] = $value;

    }

    return $array;
  }



  public function save_user_fields( $row_value )
  {

        $confirm_select_options = $this->confirm_select_options();
        $year_selected = $_POST['year_selected'];
        //if ( $worker_user_id  ) {

          $date = $_POST['date_'. $this->month];
          $names = $_POST['begging-time_'. $this->month];
          $end_time = $_POST['end-time_'. $this->month];
          $day_and_night_period = $_POST['day_and_night_period_'. $this->month];
          $hours_spent = $_POST['hours_spent_'. $this->month];
          $quantity = $_POST['quantity_'. $this->month];
          $comment = $_POST['comment_'. $this->month];
          $reject_quantity = $_POST['reject-quantity_'. $this->month];
          $reject_comment = $_POST['reject-comment_'. $this->month];
          $job_number_select = $_POST['job_number_select_'. $this->month];
          $department = $_POST['department_'. $this->month];
          $activities_select = $_POST['activities_select_'. $this->month];
          $machine_select = $_POST['machine_select_'. $this->month];
          $return_year = $_POST['return_year_'. $this->month];
          $return_month = $_POST['return_month_'. $this->month];
          $worker_name = $_POST['worker_name_'. $this->month];
          $produced_per_hour = $_POST['produced_per_hour_'. $this->month];
          $confirmed = $_POST['confirmed_'. $this->month];
          $worker_user_id = $_POST['worker_user_id_'. $this->month];
          $worker_role = $_POST['worker_role_'. $this->month];
          $year_selected = $_POST['year_selected'];

          if ( ! empty( $worker_user_id ) ) {
            $count = count( $worker_user_id );
          }


          for ( $i = 0; $i < $count; $i++ ) {
            if ( $worker_user_id[$i] != '' ) :
              $new[$i]['date_'. $this->month] = stripslashes( strip_tags( $date[$i] ) );

              $new[$i]['begging-time_'. $this->month] = stripslashes( strip_tags( $names[$i] ) );

              $new[$i]['end-time_'. $this->month] = stripslashes( strip_tags( $end_time[$i] ) );

              $new[$i]['day_and_night_period_'. $this->month] = stripslashes( strip_tags( $day_and_night_period[$i] ) );

              $new[$i]['hours_spent_'. $this->month] = stripslashes( strip_tags( $hours_spent[$i] ) );

              $new[$i]['quantity_'. $this->month] = stripslashes( strip_tags( $quantity[$i] ) );

              $new[$i]['comment_'. $this->month] = stripslashes( strip_tags( $comment[$i] ) );

              $new[$i]['reject-quantity_'. $this->month] = stripslashes( strip_tags( $reject_quantity[$i] ) );

              $new[$i]['reject-comment_'. $this->month] = stripslashes( strip_tags( $reject_comment[$i] ) );

              $new[$i]['department_'. $this->month] = stripslashes( strip_tags( $department[$i] ) );

              $new[$i]['return_year_'. $this->month] = stripslashes( strip_tags( $return_year[$i] ) );

              $new[$i]['return_month_'. $this->month] = stripslashes( strip_tags( $return_month[$i] ) );

              $new[$i]['worker_name_'. $this->month] = stripslashes( strip_tags( $worker_name[$i] ) );

              $new[$i]['produced_per_hour_'. $this->month] = stripslashes( strip_tags( $produced_per_hour[$i] ) );

              //$new[$i]['year_selected'] = stripslashes( strip_tags( $year_selected[$i] ) );

              $new[$i]['worker_role_'. $this->month] = stripslashes( strip_tags( $worker_role[$i] ) );

              $new[$i]['worker_user_id_'. $this->month] = stripslashes( strip_tags( $worker_user_id[$i] ) );

              $new[$i]['job_number_select_'.$this->month] = stripslashes( strip_tags( $job_number_select[$i] ) );

              $new[$i]['activities_select_'.$this->month] = stripslashes( strip_tags( $activities_select[$i] ) );

              $new[$i]['machine_select_'.$this->month] = stripslashes( strip_tags( $machine_select[$i] ) );


              if ( in_array( $confirmed[$i], $confirm_select_options ) )
                $new[$i]['confirmed_'. $this->month] = $confirmed[$i];
              else
                $new[$i]['confirmed_'. $this->month] = '';




            endif;
          }
          if ( is_array( $new )  ) {
            foreach( (array)$new as $key => $value ) {
              $save_array[$value['worker_user_id_'.$this->month]][] = $value;
            }
          }

          //print_r( $save_array );
          //print_r( $year_selected );
        //}
        if ( is_array( $save_array )  ) {
          foreach ( (array)$save_array as $array_key => $array_value ) {
            foreach ( (array)$array_value as $save_key => $save_value ) {

              update_user_meta( $array_key, 'user_worker_field_' . $save_key , $save_value );
              //print_r( $save_value );
              //print_r( $get_field );


            }
          }
        }

        update_user_meta( get_current_user_id() , 'year_selected' , $year_selected );


    }


    public function filter_and_save_user_fields( $fields )
    {
        $this->save_user_fields( $fields  );
        //print_r( $this->save_user_fields( $fields  ) );

    }








}
