<?php
class Specific_Job {

    public function __construct() {
      add_action( 'admin_menu', array( $this, 'create_specific_job_settings_page' ) );
      add_action( 'admin_menu', array( $this, 'add_external_link_admin_submenu' ) , 100 );

    }



    public function add_external_link_admin_submenu() {
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

    public function create_specific_job_settings_page() {

    	$page_title = 'Töö aruanne';
    	$menu_title = 'Töö aruanne';
    	$capability = 'manage_options';
    	$slug = 'specific_job';
    	$callback = array( $this, 'specific_job_page_content' );
    	$icon = 'dashicons-media-spreadsheet ';
    	$position = 100;
    	add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }



    public function specific_job_user_fields ( $value , $month) {
      if ( ! empty( $value ) ) {
        echo '<tr>';
                if ( isset( $value['confirmed_'.$month ] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="job_number_select_'.$month.'[]" value="'.$value['confirmed_'.$month ].'" />Kontrollitud</br></p>';

                  echo '</td>';
                }
                if ( isset( $value['job_number_select_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="job_number_select_'.$month.'[]" value="'.$value['job_number_select_'.$month].'" />'.$value['job_number_select_'.$month].'</br></p>';

                  echo '</td>';
                }
                if ( isset( $value['worker_name_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="worker_name_'.$month.'[]" value="'.$value['worker_name_'.$month].'" />'.$value['worker_name_'.$month].'</br></p>';

                  echo '</td>';
                }
                if ( isset( $value['department_'.$month] ) ) {

                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="department_'.$month.'[]" value="'.$value['department_'.$month].'" />'.$value['department_'.$month]. '</br></p>';

                  echo '</td>';
                }
                if ( isset( $value['activities_select_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="activities_select_'.$month.'[]" value="'.$value['activities_select_'.$month].'" />'.$value['activities_select_'.$month] . '</br></p>';

                  echo '</td>';
                }
                if ( isset( $value['machine_select_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="machine_select_'.$month.'[]" value="'.$value['machine_select_'.$month].'" />'.$value['machine_select_'.$month] . '</br></p>';

                  echo '</td>';
                }
                if ( isset( $value['date_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="date_'.$month.'[]" value="'.$value['date_'.$month].'" />'.$value['date_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['begging-time_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="begging-time_'.$month.'[]" value="'.$value['begging-time_'.$month].'" />'.$value['begging-time_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['end-time_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="end-time_'.$month.'[]" value="'.$value['end-time_'.$month].'" />'.$value['end-time_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['end-time_'.$month] ) ) {
                  echo '<td style="display: none" >';

                          print  '<p><input readonly type="hidden"   class="widefat" name="day_and_night_period_'.$month.'[]" value="'.$value['day_and_night_period_'.$month].'" />'.$value['day_and_night_period_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['hours_spent_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="hours_spent_'.$month.'[]" value="'.$value['hours_spent_'.$month].'" />'.$value['hours_spent_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['quantity_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="quantity_'.$month.'[]" value="'.$value['quantity_'.$month].'" />'.$value['quantity_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['comment_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="comment_'.$month.'[]" value="'.$value['comment_'.$month].'" />'.$value['comment_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['produced_per_hour_'.$month] ) ) {
                  echo '<td>';
                  //  foreach ($user_fields as $key => $value) {
                          print  '<p><input readonly type="hidden"   class="widefat" name="produced_per_hour_'.$month.'[]" value="'.$value['produced_per_hour_'.$month].'" />'.$value['produced_per_hour_'.$month].'</br></p>';
                  //  }
                  echo '</td>';
                }
                if ( isset( $value['reject-quantity_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="reject-quantity_'.$month.'[]" value="'.$value['reject-quantity_'.$month].'" />'.$value['reject-quantity_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['reject-comment_'.$month] ) ) {
                  echo '<td>';

                          print  '<p><input readonly type="hidden"   class="widefat" name="reject-comment_'.$month.'[]" value="'.$value['reject-comment_'.$month].'" />'.$value['reject-comment_'.$month] . '</br>'.'</p>';

                  echo '</td>';
                }
                if ( isset( $value['return_month_'.$month] ) ) {
                  echo '<td style="display: none" >';

                          print  '<p><input readonly type="hidden"   class="widefat" name="return_month_'.$month.'[]" value="'.$value['return_month_'.$month].'" /></br></p>';

                  echo '</td>';
                }
                if ( isset( $value['return_year_'.$month] ) ) {
                  echo '<td style="display: none" >';

                          print  '<p><input readonly type="hidden"   class="widefat" name="return_year_'.$month.'[]" value="'.$value['return_year_'.$month].'" /></br></p>';

                  echo '</td>';
                }
                              echo '</tr>';



          }
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

            }

          }


        foreach ( $filtered_fields as $filtered_key => $filtered_value ) {
          //print_r( $filtered_value['worker_user_id_'. $month ] );
          $filtered_user_fields[$filtered_value['worker_user_id_'. $month ]][] = $filtered_value;
        }
        //print_r( $filtered_user_fields );

        return $filtered_user_fields;

      }



      public function year_confirmed_select_options() {

        $custom_posts = array( '2018', '2019', '2020' );

        $array = array();
        foreach ($custom_posts as $key => $value) {

           $array[] = $value;

        }

        //return $array;

        $year_select_options = $array;
        $year_selected = get_user_meta( get_current_user_id() , 'year_selected', true);

        $html .= '<td>';
          $html .= '<select class="user-insert-job-select" name="year_selected">';
           foreach ( $year_select_options as $label => $field ) :
             $html .= '<option '.selected( $year_selected , $field, false ).' value="'.$field.'" >'.$field.'</option>';
           endforeach;
          $html .= '</select>';
        $html .= '</td>';
        return $html;

      }

      public function filter_correct_fields( $value, $month, $selected_deparment ) {
            //if( $selected_deparment  == isset( $value['department_'.$month] )  ) {
            //print_r( $value );
            if( isset( $value['department_'.$month ] ) ) {
              if( isset( $value['department_'.$month ] ) ) {
              $deparment = $value['department_'.$month ];
              $confirmed = $value['confirmed_'.$month ];

              if ( $selected_deparment === $deparment ) {
                $saved_html_tag = get_user_meta( get_current_user_id(), 'save_html_tag', true);
                $tag_decode = json_decode( $saved_html_tag );
                if ( $tag_decode->html_tag ==  $value['job_number_select_'.$month ] ) {
                  //print_r( $value );
                  $this->specific_job_user_fields( $value, $month, $selected_deparment );

              }
            }
          }
        }
      }

      public function filter_right_spent_hours( $value, $month, $selected_deparment ){

        if( isset( $value['department_'.$month ] ) ) {
          if( isset( $value['department_'.$month ] ) ) {
              $deparment = $value['department_'.$month ];
              $confirmed = $value['confirmed_'.$month ];
              $job_nr = $value['job_number_select_'.$month ];
              if ( $selected_deparment === $deparment ) {
                $saved_html_tag = get_user_meta( get_current_user_id(), 'save_html_tag', true);
                $tag_decode = json_decode( $saved_html_tag );
                if ( $tag_decode->html_tag ===  $job_nr ) {
                    return $value['hours_spent_'.$month ];
                }
              }
            }
          }
       }


       public function filter_right_quantity( $value, $month, $selected_deparment ){

         if( isset( $value['department_'.$month ] ) ) {
           if( isset( $value['department_'.$month ] ) ) {
               $deparment = $value['department_'.$month ];
               $confirmed = $value['confirmed_'.$month ];
               $job_nr = $value['job_number_select_'.$month ];
               if ( $selected_deparment === $deparment ) {
                 $saved_html_tag = get_user_meta( get_current_user_id(), 'save_html_tag', true);
                 $tag_decode = json_decode( $saved_html_tag );
                 if ( $tag_decode->html_tag ===  $job_nr ) {
                     return $value['quantity_'.$month ];
                 }
               }
             }
           }
        }



        public function filter_right_reject_quantity( $value, $month, $selected_deparment ){

          if( isset( $value['department_'.$month ] ) ) {
            if( isset( $value['department_'.$month ] ) ) {
                $deparment = $value['department_'.$month ];
                $confirmed = $value['confirmed_'.$month ];
                $job_nr = $value['job_number_select_'.$month ];
                if ( $selected_deparment === $deparment ) {
                  $saved_html_tag = get_user_meta( get_current_user_id(), 'save_html_tag', true);
                  $tag_decode = json_decode( $saved_html_tag );
                  if ( $tag_decode->html_tag ===  $job_nr ) {
                      return $value['reject-quantity_'.$month ];
                  }
                }
              }
            }
         }

      public function html_table_output( $title, $selected_deparment, $confirmed_array, $month  ){ ?>
        <table id="repeatable-fieldset-one" width="100%">
          <thead>
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
           </thead>
           <?php
        echo '<caption style="text-align: left;" ><h1>'.$title.'</h1></caption>';
        $hours_array = array();
        $quantity_array = array();
        $reject_quantity_array = array();
        $saved_html_tag = get_user_meta( get_current_user_id(), 'save_html_tag', true);
        $tag_decode = json_decode( $saved_html_tag );

      //print_r(  $confirmed_array );
      foreach ( $confirmed_array as $confirmed_key => $confirmed_value ) {
        //print_r(  $confirmed_value );
          foreach ( ( array ) $confirmed_value as $key => $value ) {
            if ( ! empty( $value ) ) {
            if ( 'yes' == $value['confirmed_'.$month] )  {

              if( $selected_deparment  == $value['department_'.$month]  ) {
                //print_r(  $value );
                if ( $month ==  $value['return_month_'.$month] ) {
                  //print_r( $value['confirmed_'.$month] );
                  //if ( 'yes' == isset( $value['confirmed_'.$month] ) ) {


                    $this->filter_correct_fields( $value, $month, $selected_deparment );
                    //print_r( $correct_fields );
                    $new_array[] = $correct_fields;
                    //$this->specific_job_user_fields( $correct_fields, $month );
                    $hours_spent = $this->filter_right_spent_hours( $value, $month, $selected_deparment );
                    $reject_quantity = $this->filter_right_reject_quantity( $value, $month, $selected_deparment );
                    $quantity = $this->filter_right_quantity( $value, $month, $selected_deparment );
                    //if ( ! empty( $hours_spent ) ) {
                        //print_r( $value );
                        $hours_array[] = $hours_spent;
                        $quantity_array[] = $quantity;
                        $reject_quantity_array[] = $reject_quantity;
                  }

                }

              }

            }

          }

        }

        $all_hours = array_sum( $hours_array );
        $all_quantity = array_sum( $quantity_array );
        $all_reject_quantity = array_sum( $reject_quantity_array );
        echo '<tr><td class="all-filtered" >'.esc_html__( $selected_deparment . ':', 'ilo-ee-ajaarvestus-template' ).' kokku</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        <td class="all-filtered" >'.esc_html__( 'Time : ', 'ilo-ee-ajaarvestus-template' ), $all_hours.' h</td><td class="all-filtered" >'.esc_html__( 'Amount :', 'ilo-ee-ajaarvestus-template' ), $all_quantity.'  </td><td></td><td></td>
        <td class="all-filtered" >'.esc_html__( 'Rejection :', 'ilo-ee-ajaarvestus-template' ), $all_reject_quantity.' </td><td></td></tr>';
        ?>
       </table>
      <?php
      }



    public function specific_job_page_content() {      ?>
    	<div class="wrap">
        <form method="POST">
                <input type="hidden" name="updated" value="true" />
                  <?php
                      echo '<div id="tabs-'.$key.'">';

                        echo '<table  width="100%">';

                            echo '<tbody>';

                                $user_fields_array = $this->get_user_fields( 12 );
                                $saved_html_tag = get_user_meta( get_current_user_id(), 'save_html_tag', true);
                                $tag_decode = json_decode( $saved_html_tag );
                                //$confirmed_fields = get_post_meta(get_current_user_id() , 'repeatable_fields_'.$tag_decode->month , true);
                                //print_r( $user_fields_array );


                                $this->html_table_output( 'TRÜKK', 'Trükk', $user_fields_array, $tag_decode->month  );

                                $this->html_table_output( 'ETTEVALMISTUS', 'Ettevalmistus', $user_fields_array, $tag_decode->month  );

                                $this->html_table_output( 'JÄRELTÖÖTUS', 'Järeltöötlus', $user_fields_array, $tag_decode->month  );

                                $this->html_table_output( 'MÜÜGIOSAKOND', 'Müügiosakond', $user_fields_array, $tag_decode->month  );

                              echo '</tbody>';

                            echo '</table>';

                        echo '</div>';

                        ?>

                    </div>
                  </div>

              </form>

            <?php }

}
new Specific_Job();
