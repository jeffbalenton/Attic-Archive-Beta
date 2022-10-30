                                                                                                                                                                                                                                                       
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
      'wp_ajax_example_ajax_request' => 'example_ajax_request',
      'wp_ajax_nopriv_example_ajax_request' => 'example_ajax_request',
     

    ];
  }

  public function archive_scripts() {

	
    wp_enqueue_script( 'person-script', get_template_directory_uri() . '/inc/assets/js/person.js',array('jquery'),false,true);

	  
	  $js_data = [
		  'ajax_url'=>admin_url( 'admin-ajax.php' )
	  ];
	  
	wp_localize_script ('person-script','person_ajax',$js_data);


  }
 function example_ajax_request() {
    // The $_REQUEST contains all the data sent via AJAX from the Javascript call
    if ( isset( $_REQUEST ) ) :
      $tab = $_REQUEST[ 'tab' ];
      // This bit is going to process our fruit variable into an Apple
      if ( $tab == 'Banana' ) :
	ob_start();
  get_template_part( 'template-parts/components/ajax/person' );
  $result = ob_get_contents();
  ob_end_clean();
  $return = array('content' => $result);
  wp_send_json($return);
  
		endif;
       
	  endif;
 
    
  }
  

  }
// End Of Class.
endif;