<?php


if ( !class_exists( 'AjaxSubscriber' ) ):

  class AjaxSubscriber
implements SubscriberInterface {


  /**
   * @var string
   */
  public $version = '1.5.0';

  /* * * * * * * * * *
   * Class constructor
   * * * * * * * * * */
  public function __construct() {


  }

  public static function get_subscribed_hooks() {
    return [
      'wp_enqueue_scripts' => 'archive_scripts',
      'wp_head' => 'my_wp_head_ajax_url',
      'wp_ajax_example_ajax_request' => 'example_ajax_request',
      'wp_ajax_nopriv_example_ajax_request' => 'example_ajax_request',
      'wp_ajax_example_ajax_request' => 'person_ajax_request',
      'wp_ajax_nopriv_example_ajax_request' => 'person_ajax_request',

    ];
  }

  public function my_wp_head_ajax_url() 
  {
?>
<script type="text/Javascript">
var ajaxurl ='<?php echo admin_url("admin-ajax.php"); ?>';
</script>
<!-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script> -->
<?php
}

public function archive_scripts() {


  wp_enqueue_script( 'person-script', get_template_directory_uri() . '/js/person.js', array( 'jquery' ), false, true );


  $js_data = [
    'ajax_url' => admin_url( 'admin-ajax.php' )
  ];

  wp_localize_script( 'person-script', 'person_ajax', $js_data );


}

function example_ajax_request() {
  // The $_REQUEST contains all the data sent via AJAX from the Javascript call
  if ( isset( $_REQUEST ) ):
    $select = $_REQUEST[ 'value' ];
  // This bit is going to process our fruit variable into an Apple
	

$con = mysqli_connect('localhost','root','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"wp_ajax_database");
$sql="SELECT * FROM user WHERE id = '".$select."'";
$result = mysqli_query($con,$sql);
	
 
    ob_start();
	echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
	while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['FirstName'] . "</td>";
  echo "<td>" . $row['LastName'] . "</td>";
  echo "<td>" . $row['Age'] . "</td>";
  echo "<td>" . $row['Hometown'] . "</td>";
  echo "<td>" . $row['Job'] . "</td>";
  echo "</tr>";
}
echo "</table>";
mysqli_close($con);
  $result = ob_get_contents();
  ob_end_clean();
  $return = array( 'content' => $result );
  wp_send_json( $return );



  endif;


}


}
// End Of Class.
endif;