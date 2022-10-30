<?php


//$rest = esc_url_raw(rest_url());
//$screen=get_current_screen();
//var_dump($screen);

//echo 'Hello World!';

$file = get_theme_file_uri('inc/autoimport/files/field-groups.json');

			$json = file_get_contents( $file );
			$json = json_decode( $json,true );
            $json =$json[0]['item'];

//var_dump();

$postarr = [
'ID'=>$json[0]['ID'],
'post_author'=> '',
'post_content'=>$json[0]['post_content'][0]['__cdata'],
'post_content_filtered'=> '',
'post_title'=> $json[0]['post_title']['__cdata'],
'post_name'=>$json[0]['post_name']['__cdata'],
'post_excerpt'=>$json[0]['post_content'][1]['__cdata'],
'post_status'=>$json[0]['post_status']['__cdata'],
'post_type'=> $json[0]['post_type']['__cdata'],
'comment_status'=> '',
'ping_status'           => '',
'post_password'         => '',
'to_ping'               => '',
'pinged'                => '',
'post_parent'=> $json[0]['post_parent'],
'menu_order'            => $json[0]['menu_order'],
'guid'                  => '',
'import_id'             => 0,
'context'               => '',
'post_date'             => '',
'post_date_gmt'         => '',
'meta_input'=>[],
'tax_input'=>[],

];

var_dump($postarr);

?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Title</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>	