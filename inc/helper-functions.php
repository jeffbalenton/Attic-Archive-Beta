<?php
/**
 * WordPress eXtended RSS file parser implementations
 *
 * @package WordPress
 * @subpackage Importer
 */

function aa_convert_date( $year, $month, $day ) {


  //switch structure for processing free_form date
  switch ( true ) {
    case !empty( $year ) && !empty( $month ) && !empty( $day ):
      $database_date = date_create( "$year-$month-$day" );
      // $sort_date = date( 'ddmmyyyy', $database_date );
      $display_date = date_format( $database_date, "M j, Y" );
      break;
	  case !empty( $year ) && empty( $month ):  
      $database_date = date_create( "$year-1-1" );
      $display_date = "Abt. $year";
      break;
    case  !empty( $year ) && !empty( $month )  && empty( $day ) :
		  if ( $month === "1" ):
          $Month = "January";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "2" ):
          $Month = "February";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "3" ):
          $Month = "March";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "4" ):
          $Month = "April";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $byear";
        elseif ( $month === "5" ):
          $Month = "May";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "6" ):
          $Month = "June";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "7" ):
          $Month = "July";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "8" ):
          $Month = "August";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "9" ):
          $Month = "September";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "10" ):
          $Month = "October";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";

        elseif ( $month === "11" ):
          $Month = "November";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";

        elseif ( $month === "12" ):
          $Month = "December";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        endif;
        break; 
	  case empty($year):
		$database_date = null;
        $display_date = null;
		  break;
  }


  /* switch ( true ) {
	  case empty($year) && empty($month) && empty($day):
		$database_date = date_create( "$year-$month-$day" );
        // $sort_date = date( 'ddmmyyyy', $database_date );
        $display_date = date_format( $database_date, "M j, Y" );
        break;
		  
      case empty( $year ) && empty( $month ) && !empty( $day ):
		
        if ( $month === "1" ):
          $Month = "JAN";
		  
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "2" ):
          $Month = "FEB";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "3" ):
          $Month = "MAR";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "4" ):
          $Month = "APR";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $byear";
        elseif ( $month === "5" ):
          $Month = "MAY";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "6" ):
          $Month = "JUN";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "7" ):
          $Month = "JUL";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "8" ):
          $Month = "AUG";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        elseif ( $month === "9" ):
          $Month = "SEP";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";

        elseif ( $month === "10" ):
          $Month = "OCT";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";

        elseif ( $month === "11" ):
          $Month = "NOV";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";

        elseif ( $month === "12" ):
          $Month = "DEC";
        $database_date = date_create( "$year-$month-1" );
        $display_date = "$Month $year";
        endif;
        break;
      case !empty( $month ) && empty( $year ) && empty( $day ):
        $database_date = date_create( "$year-01-01" );
        $display_date = "Abt. $year";
        break;
      case !empty( $month ) && !empty( $day ) && empty( $year ):
        $database_date = date_create( "$year-01-01" );
        $display_date = "Abt. $year";
        break;
   
      case !empty( $year ):
        $display_date = null;
        $database_date = null;
        break;
		
       
    }

*/


  return [ 'display_date' => $display_date,
    'database_date' => $database_date
  ];
}


/**
 * acf_import_field_group
 *
 * Imports a field group into the databse.
 *
 * @date    11/03/2014
 * @since   5.0.0
 *
 * @param   array $field_group The field group array.
 * @return  array The new field group.
 */
function aa_acf_import_field_group( $field_group ) {

	// Disable filters to ensure data is not modified by local, clone, etc.
	$filters = acf_disable_filters();

	// Validate field group (ensures all settings exist).
	$field_group = acf_get_valid_field_group( $field_group );

	// Prepare group for import (modifies settings).
	//$field_group = acf_prepare_field_group_for_import( $field_group );
	
	
	// Update parent and menu_order properties for all fields.
	if ( $field_group['fields'] ) {
		foreach ( $field_group['fields'] as $i => &$field ) {
			$field['parent']     = $field_group['key'];
			$field['menu_order'] = $i;
		}
	}
	
	
	

	// Prepare fields for import (modifies settings).
	//$fields = acf_prepare_fields_for_import( $field_group['fields'] );
	
		// Ensure array is sequential.
	$fields = array_values( $field_group['fields'] );

	// Prepare each field for import making sure to detect additional sub fields.
	$i = 0;
	while ( $i < count( $fields ) ) {

		// Prepare field.
		$field = acf_prepare_field_for_import( $fields[ $i ] );

		// Update single field.
		if ( isset( $field['key'] ) ) {
			$fields[ $i ] = $field;

			// Insert multiple fields.
		} else {
			array_splice( $fields, $i, 1, $field );
		}

		// Iterate.
		$i++;
	}


	// Stores a map of field "key" => "ID".
	$ids = array();

	// If the field group has an ID, review and delete stale fields in the database.
	if ( $field_group['ID'] ) {

		// Load database fields.
		$db_fields = acf_prepare_fields_for_import( acf_get_fields( $field_group ) );

		// Generate map of "index" => "key" data.
		$keys = wp_list_pluck( $fields, 'key' );

		// Loop over db fields and delete those who don't exist in $new_fields.
		foreach ( $db_fields as $field ) {

			// Add field data to $ids map.
			$ids[ $field['key'] ] = $field['ID'];

			// Delete field if not in $keys.
			if ( ! in_array( $field['key'], $keys ) ) {
				acf_delete_field( $field['ID'] );
			}
		}
	}

	// When importing a new field group, insert a temporary post and set the field group's ID.
	// This allows fields to be updated before the field group (field group ID is needed for field parent setting).
	if ( ! $field_group['ID'] ) {
		$field_group['ID'] = wp_insert_post( array( 'post_title' => $field_group['key'] ) );
	}

	// Add field group data to $ids map.
	$ids[ $field_group['key'] ] = $field_group['ID'];

	// Loop over and add fields.
	if ( $fields ) {
		foreach ( $fields as $field ) {

			// Replace any "key" references with "ID".
			if ( isset( $ids[ $field['key'] ] ) ) {
				$field['ID'] = $ids[ $field['key'] ];
			}
			if ( isset( $ids[ $field['parent'] ] ) ) {
				$field['parent'] = $ids[ $field['parent'] ];
			}

			// Save field.
			$field = acf_update_field( $field );

			// Add field data to $ids map for children.
			$ids[ $field['key'] ] = $field['ID'];
		}
	}

	// Save field group.
	$field_group = acf_update_field_group( $field_group );

	// Enable filters again.
	acf_enable_filters( $filters );



	// return new field group.
	return $field_group;
}
