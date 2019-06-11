<?php
Class Overseer_Filter_User_Fields
{
  private $fields;
  private $month;

  public function __construct(  $month, $fields ) {

    $this->fields = $fields;
    $this->month = $month;

  }


 public function return_saved_fields(  )
 {

   $fields = $this->fields;
   if ( is_array( $fields )) {
    foreach ( (array)$fields as $fields_key => $fields_value ) {
       foreach ( (array)$fields_value as $key => $value ) {
         if ( 'yes' ===   $value['confirmed_'. $this->month]  ) {
            $field_array[] = $value;
         }
       }
      }
    }

   if ( is_array( $fields )) {
     $user_meta = get_userdata( get_current_user_id() );
     $user_roles = $user_meta->roles;
     $user_department = get_user_meta( get_current_user_id(), 'cmb2_profile_fields_user_deparment', true);
     foreach ( (array)$field_array as $filtered_key => $filtered_value ) {
       //print_r( $filtered_value['department_' . $this->month ] );
       $year_selected = get_user_meta( get_current_user_id() , 'year_selected', true);
      // if ( ! in_array( 'overseer', $user_roles ) ) {
         if ( in_array( $filtered_value['department_' . $this->month ], $user_department ) ) {
           if ( $filtered_value['return_year_' . $this->month ] == $year_selected ) {
             if ( $filtered_value['return_month_' . $month ] == $month ) {
               $filtered_user_fields[$filtered_value['worker_user_id_'. $this->month ]][$filtered_value['job_number_select_'. $this->month]] = $filtered_value;
             }
           }
         }
      // }
     }
   }


   //print_r( $filtered_user_fields );
   return $filtered_user_fields;

 }





 public function return_none_saved_fields(  )
 {
    $fields = $this->fields;
    if ( is_array( $fields )) {
       foreach ( (array)$fields as $fields_key => $fields_value ) {
         foreach ( (array)$fields_value as $key => $value ) {
             if ( 'no' ===   $value['confirmed_'. $this->month] ) {
             //print_r( $value['confirmed_12']  );
             $field_array[] = $value;
           }
         }
       }
    }

   if ( is_array( $field_array )) {
     $user_meta = get_userdata( get_current_user_id() );
     $user_roles = $user_meta->roles;
     $user_department = get_user_meta( get_current_user_id(), 'cmb2_profile_fields_user_deparment', true);
     foreach ( (array)$field_array as $filtered_key => $filtered_value ) {
       $year_selected = get_user_meta( get_current_user_id() , 'year_selected', true);
       //print_r( $filtered_value['department' . $this->month ] );
       //if ( ! in_array( 'overseer', $user_roles ) ) {
         if ( in_array( $filtered_value['department_' . $this->month ], $user_department ) ) {
           if ( $filtered_value['return_year_' . $this->month ] == $year_selected ) {
             if ( $filtered_value['return_month_' . $month ] == $month ) {
               $filtered_user_fields[$filtered_value['worker_user_id_'. $this->month ]][$filtered_value['job_number_select_'. $this->month]] = $filtered_value;
             }
           }
         }
      // }
     }
   }


   //print_r( $filtered_user_fields );
   return $filtered_user_fields;


 }



}
