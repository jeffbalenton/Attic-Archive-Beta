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
    case isset( $year ) && isset( $month ) && isset( $day ):
      $database_date = date_create( "$year-$month-$day" );
      // $sort_date = date( 'ddmmyyyy', $database_date );
      $display_date = date_format( $database_date, "M j, Y" );
      break;
    case isset( $year ) && !isset( $month )  &&  !isset( $day ):
      $database_date = date_create( "$year-1-1" );
      $display_date = "Abt. $year";
      break;
    case  isset( $year ) && isset( $month )  && !isset( $day ) :
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
	  case isset($year) && isset($day) && !isset ($month):
		    $database_date = date_create( "$year-1-$day" );
        $display_date = "Abt. $year";
		  break;
  }


  /* switch ( true ) {
	  case isset($year) && isset($month) && isset($day):
		$database_date = date_create( "$year-$month-$day" );
        // $sort_date = date( 'ddmmyyyy', $database_date );
        $display_date = date_format( $database_date, "M j, Y" );
        break;
		  
      case isset( $year ) && isset( $month ) && !isset( $day ):
		
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
      case !isset( $month ) && isset( $year ) && isset( $day ):
        $database_date = date_create( "$year-01-01" );
        $display_date = "Abt. $year";
        break;
      case !isset( $month ) && !isset( $day ) && isset( $year ):
        $database_date = date_create( "$year-01-01" );
        $display_date = "Abt. $year";
        break;
   
      case !isset( $year ):
        $display_date = null;
        $database_date = null;
        break;
		
       
    }

*/


  return [ 'display_date' => $display_date,
    'database_date' => $database_date
  ];
}