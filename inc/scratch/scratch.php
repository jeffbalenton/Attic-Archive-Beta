<?php
?>
<p></p>
<form>
  <select id="users">
    <option  value="">Select a person:</option>
    <option value="1">Peter Griffin</option>
    <option value="2">Lois Griffin</option>
    <option value="3">Joseph Swanson</option>
    <option value="4">Glenn Quagmire</option>
  </select>
</form>
<br>
<div id="txtHint"><b>Person info will be listed here...</b></div>
<?php

echo "<p>";
$meta = aa_get_all_post_meta_keys();
var_export( $meta );
?>
<p>
  <select is="postMeta">
    <option value="">Select Meta</option>
  </select>
  <?php

  echo '<br>';
  //Read JSON  file 
  $file = get_template_directory() . '/inc/autoimport/files/custom-fields.json';
  // for windows systems
  $file = str_replace( '\\', '/', $file );


  $json = file_get_contents( $file );
  $json = json_decode( $json, true );

  // Ensure $json is an array of groups.
  if ( isset( $json[ 'key' ] ) ) {
    $json = array( $json );
  }
  //var_export($json);
  echo '<br>';

  // Remeber imported field group ids.
  $ids = array();
	
  foreach ( $json as $field_group ) {
   
    // Search database for existing field group.
    $post = acf_get_field_group_post( $field_group[ 'key' ] );
    if ( $post ) {
      $field_group[ 'ID' ] = $post->ID;
    }
// Import field group.
	  
    echo $field_group[ 'title' ] . " : " . $field_group[ 'ID' ];
	  echo "<br>";
	  // Update parent and menu_order properties for all fields.
	if ( $field_group['fields'] ) {
		foreach ( $field_group['fields'] as $i => &$field ) {
			$field['parent']     = $field_group['key'];
			$field['menu_order'] = $i;
		}
	}
	  echo $field['parent'] ." : ". $field_group['key'];
    echo "<br>";

    //var_dump($field_group['title']); 
    //echo'<br>';//remove when done
    //var_dump($field_group['ID']);

    /*
    global $repository;
    $postarr=[
    	'post_title'=>$field_group['title'],
    	'post_status'=>'publish',
    	'post_type' =>'acf-field-group',
    	
    ];
    $found_post=$repository->find_one($postarr);
    if (!$found_post):
	
    if ( ! $field_group['ID'] ) {
    	$field_group['ID'] = wp_insert_post( array( 'post_title' => $field_group['key'] ) );
    }

    endif;
    */

  }


  ?>
