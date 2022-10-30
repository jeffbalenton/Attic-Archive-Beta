<?php

// exit if accessed directly
if ( !defined( 'ABSPATH' ) )exit;

if ( !class_exists( 'CustomFieldsSubscriber' ) ):
  class CustomFieldsSubscriber implements SubscriberInterface {


    // vars
    var $settings;


    /*
     *  __construct
     *
     *  This function will setup the class functionality
     *
     *  @type	function
     *  @date	17/02/2016
     *  @since	1.0.0
     *
     *  @param	void
     *  @return	void
     */

    function __construct() {

      // settings
      // - these will be passed into the field class.
      $this->settings = array(
        'version' => '1.0.0',
        'url' => get_template_directory_uri() . '/inc/plugin-api-manager/subscribers/fields/',
        'path' => get_template_directory() . '/inc/plugin-api-manager/subscribers/fields/' ,
      );

     $this->_includes();
      // include field
     // add_action( 'acf/include_field_types', array( $this, 'include_fields' ) ); // v5
    
    }

public static function get_subscribed_hooks(){
	return [
		'acf/include_field_types' => 'include_fields',
		'acf/register_fields' => 'include_fields',
		//'wp_loaded' =>'archive_importer_init',
	];
}
	  function _includes(){
	
		   require_once( 'fields/acf-child-post-field/acf-child-post-field.php' );
		  
	  }
	

    /*
     *  include_field
     *
     *  This function will include the field type class
     *
     *  @type	function
     *  @date	17/02/2016
     *  @since	1.0.0
     *
     *  @param	$version (int) major ACF version. Defaults to false
     *  @return	void
     */

    function include_fields( $version = 5 ) {

      // support empty $version
      if ( !$version )$version = 4;


      // load textdomain
      //load_plugin_textdomain( 'TEXTDOMAIN', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' ); 


      // include

     // require_once( 'fields/general/file.php' );
    // require_once( 'fields/general/flexible-content.php' );
    //  require_once( 'fields/general/group.php' );
     // require_once( 'fields/general/list-items.php' );
     // require_once( 'fields/general/recaptcha.php' );
    //  require_once( 'fields/general/related-terms.php' );
		
	 // require_once( 'fields/general/archive-date-field.php' );
			
		
      //require_once( 'fields/general/relationship.php' );
		
     // require_once( 'fields/general/repeater.php' );
    //  require_once( 'fields/general/submit-button.php' );
     // require_once( 'fields/general/text-input.php' );
    //  require_once( 'fields/general/text.php' );
     //require_once( 'fields/general/upload-file.php' );
     // require_once( 'fields/general/upload-files.php' );
     // require_once( 'fields/general/url-upload.php' );
     // require_once( 'fields/post/allow-comments.php' );
      //require_once( 'fields/post/featured-image.php' );
    //  require_once( 'fields/post/post-author.php' );
    //  require_once( 'fields/post/post-content.php' );
     // require_once( 'fields/post/post-date.php' );
     // require_once( 'fields/post/post-excerpt.php' );
     // require_once( 'fields/post/post-slug.php' );
      require_once( 'fields/post/post-title.php' );
     //require_once( 'fields/post/child-post-field.php' );

    
     // require_once( 'fields/attic-archive/event-field.php' );
		
		
      //require_once( 'fields/city-selector/acf-city-selector.php' );

     //require_once( 'term/term-description.php' );
     // require_once( 'term/term-name.php' );
      //require_once( 'term/term-slug.php' );


    }


  }



// class_exists check
endif;