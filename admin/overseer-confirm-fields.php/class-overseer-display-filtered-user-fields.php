<?php
Class Display_Filtered_User_Fields
{
  private $fields;
  private $month;

  public function __construct(  $month, $fields ) {

    $this->fields = $fields;
    $this->month = $month;
    $this->user_fields();

  }


  public function confirm_select_options() {

    $custom_posts = array( 'no', 'yes');

    $array = array();
    foreach ($custom_posts as $key => $value) {

       $array[] = $value;

    }

    return $array;
  }




  public function user_fields ( ) {
    $user_meta = get_userdata( get_current_user_id() );
    $user_roles = $user_meta->roles;

    //  if ( is_array( $this->fields ) ) {
      foreach ( (array) $this->fields as $keys => $valuess ) {

        foreach ( (array) $valuess as $key => $value ) {
        //  print_r( $value['worker_role_'.$this->month] );
        if ( ! in_array( 'overseer' , $value ) ) {
        $html = '';
        $confirm_select_options = $this->confirm_select_options();
        $plus = ( $keys + rand(1,101) );
            $html .= '<tr>';

                if (isset( $value['confirmed_'.$this->month]) != '' ) {
                  $html .= '<td>';
                    $html .= '<select class="user-insert-job-select" name="confirmed_'.$this->month.'[]">';
                     foreach ( $confirm_select_options as $label => $field ) :
                       $html .= '<option value="'.$field.'"'.selected( $value['confirmed_'.$this->month], $field, false ).'>'.$field.'</option>';
                     endforeach;
                    $html .= '</select>';
                  $html .= '</td>';
                }
                if ( isset( $value['job_number_select_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="job_number_select_'.$this->month.'[]" value="'.$value['job_number_select_'.$this->month].'" />'.$value['job_number_select_'.$this->month].'</br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['worker_name_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="worker_name_'.$this->month.'[]" value="'.$value['worker_name_'.$this->month].'" />'.$value['worker_name_'.$this->month].'</br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['department_'.$this->month] ) ) {

                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="department_'.$this->month.'[]" value="'.$value['department_'.$this->month].'" />'.$value['department_'.$this->month]. '</br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['activities_select_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="activities_select_'.$this->month.'[]" value="'.$value['activities_select_'.$this->month].'" />'.$value['activities_select_'.$this->month] . '</br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['machine_select_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="machine_select_'.$this->month.'[]" value="'.$value['machine_select_'.$this->month].'" />'.$value['machine_select_'.$this->month] . '</br></p>';
                  //  }
                  $html .= '</td>';
                }

                if ( isset( $value['date_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="date_'.$this->month.'[]" value="'.$value['date_'.$this->month].'" />'.$value['date_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }

                if ( isset( $value['begging-time_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="begging-time_'.$this->month.'[]" value="'.$value['begging-time_'.$this->month].'" />'.$value['begging-time_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['end-time_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="end-time_'.$this->month.'[]" value="'.$value['end-time_'.$this->month].'" />'.$value['end-time_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }

                if ( isset( $value['day_and_night_period_'.$this->month] ) ) {
                  $html .= '<td style="display: none;" >';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="day_and_night_period_'.$this->month.'[]" value="'.$value['day_and_night_period_'.$this->month].'" />'.$value['day_and_night_period_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }

                if ( isset( $value['hours_spent_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="hours_spent_'.$this->month.'[]" value="'.$value['hours_spent_'.$this->month].'" />'.$value['hours_spent_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['quantity_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="quantity_'.$this->month.'[]" value="'.$value['quantity_'.$this->month].'" />'.$value['quantity_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['comment_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="comment_'.$this->month.'[]" value="'.$value['comment_'.$this->month].'" />'.$value['comment_'.$this->month] . '</br>'.'</p>';
                //    }
                  $html .= '</td>';
                }
                if ( isset( $value['produced_per_hour_'.$this->month] ) ) {
                  $html .= '<td >';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="produced_per_hour_'.$this->month.'[]" value="'.$value['produced_per_hour_'.$this->month].'" />'.$value['produced_per_hour_'.$this->month].'</br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['reject-quantity_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="reject-quantity_'.$this->month.'[]" value="'.$value['reject-quantity_'.$this->month].'" />'.$value['reject-quantity_'.$this->month] . '</br>'.'</p>';
                //    }
                  $html .= '</td>';
                }
                if ( isset( $value['reject-comment_'.$this->month] ) ) {
                  $html .= '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="reject-comment_'.$this->month.'[]" value="'.$value['reject-comment_'.$this->month].'" />'.$value['reject-comment_'.$this->month] . '</br>'.'</p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['return_month_'.$this->month] ) ) {
                  $html .= '<td style="display: none;" >';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="return_month_'.$this->month.'[]" value="'.$value['return_month_'.$this->month].'" /></br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['return_year_'.$this->month] ) ) {
                  $html .= '<td style="display: none;" >';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="return_year_'.$this->month.'[]" value="'.$value['return_year_'.$this->month].'" /></br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['worker_role_'.$this->month] ) ) {
                  $html .= '<td  style="display: none;"  >';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="worker_role_'.$this->month.'[]" value="'.$value['worker_role_'.$this->month].'" />'.$value['worker_role_'.$this->month].'</br></p>';
                  //  }
                  $html .= '</td>';
                }
                if ( isset( $value['worker_user_id_'.$this->month] ) ) {
                  $html .= '<td style="display: none;" >';
                  //  foreach ($user_fields as $key => $value) {
                          $html .=  '<p><input readonly type="hidden"   class="widefat" name="worker_user_id_'.$this->month.'[]" value="'.$value['worker_user_id_'.$this->month].'" /></br></p>';
                  //  }
                  $html .= '</td>';
                }
                //$html .='<td><a class="button remove-row" href="#">Remove</a></td>';

            $html .=  '</tr>';
            //$html .= '<p class="check-value" >Ajax Save Value</p>';
            print $html;
            //return $field;
            //print_r( $html );

          }
        }

      }
  // }
  }

}
