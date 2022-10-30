<?php

/**
 * Bootscore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootscore
 */


// WooCommerce
//require get_template_directory() . '/woocommerce/woocommerce-functions.php';
// WooCommerce END


define( 'MY_ACF_PATH', get_template_directory() . '/inc/acf/' );
define( 'MY_ACF_URL', get_template_directory_uri() . '/inc/acf/' );
define( 'MY_ACFE_PATH', get_template_directory() . '/inc/acf-extended/' );
define( 'MY_ACFE_URL', get_template_directory_uri() . '/inc/acf-extended/' );


//include ACF And ACF Extended and local field groups

include_once( 'inc/acf/acf.php' );
include_once( 'inc/acf-extended/acf-extended.php' );
//Include ACF Fields
//require_once('inc/acf-fields.php');
//Search Filter

include_once( 'inc/search-filter-pro/search-filter-pro.php' );

//Bs-swiper

//include_once( 'inc/bs-swiper/main.php' );

//Include Parsers

//include_once( 'inc/parsers.php' );

//Include repository class ToDo add description of what it does

require_once ('inc/class-repository.php');

//Include Helpers

require_once( 'inc/helper-functions.php' );

require_once('inc/unit-tests.php');

//include content control

//require_once('inc/content-control/content-control.php');

//AutoImporter

require_once('inc/autoimport/autoimporter.php');

//include User Registration Approve

//require_once('inc/user-registration/new-user-approve.php');


/**
 * post_exists_by_slug.
 *
 * @return mixed boolean false if no post exists; post ID otherwise.
 */
function page_exists( $page_name ) {
   $page = get_page_by_path( $page_name , OBJECT );

     if ( isset($page) ):
        return true;
     else:
        return false;
    endif;
  }
  
//@TODO Figure out why event post doesn't save date use acf/save_post hook and/or PluginAPI interface
//add_action('acf/save_post','create_event_date');
function create_event_date($post_id) {

  // bail early if not a person post
 /*   if ( get_post_type( $post_id ) !== 'event' ) :

      return;

    endif;
	  */
    // bail out if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ):
      return;
    endif;

// bail out if this is not an event item
 // bail early if not a person post
    if ( get_post_type( $post_id ) !== 'event' ) {

      return;

    }

    // Get newly saved values.
    $values = get_fields( $post_id );



  $eventmonth = get_field( 'event_month', $post_id );
    $eventday = get_field( 'event_day', $post_id );
    $eventyear = get_field( 'event_year', $post_id );
	
	    switch(true){
			 case !isset($eventyear):
				 $eventmonth=null;
				 $eventday=null;
				 break;
			 case isset($eventyear):
				 if( $eventmonth ==="0" && $eventday ==="0" ):
				 $eventmonth=null;
				 $eventday=null;
				 elseif ($month ==="0" && $eventday !=="0"):
				 $eventmonth=null;
				 elseif($eventmonth !=="0" && $evenyday === "0" ):
				 $eventday=null;
				 endif;
				 break;
		 }
	
$date_data=aa_convert_date($eventyear,$eventmonth,$eventday);

    update_post_meta( $post_id, 'event_date', $date_data['database_date']);
    update_post_meta( $post_id, 'display_date', $date_data['display_date']);
 



  }

add_filter('gettext', 'change_howdy', 10, 3);

function change_howdy($translated, $text, $domain) {

    if (!is_admin() || 'default' != $domain)
        return $translated;

    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome', $translated);

    return $translated;
}

// MOVE THE AUTHOR METABOX INTO THE PUBLISH METABOX
add_action( 'admin_menu', 'remove_author_metabox' );
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
function remove_author_metabox() {
    remove_meta_box( 'authordiv', 'post', 'normal' );
}
function move_author_to_publish_metabox() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
    post_author_meta_box( $post );
    echo '</div>';
}
  /*
  $pages = [ 'Locations' => 'locations',
      'Collections' => 'collections',
      'Articles' => 'articles',
      'Letters' => 'letters',
      'Texts' => 'texts',
      'Ephemera' => 'ephemera',
      'Audio Recordings' => 'audio-recordings',
      'Documents' => 'document-finder',
      'Objects' => 'objects',
      'Home' => 'home',
      'Blog' => 'blog',
      'Private Content Page' => 'private-content-page',
      'Thank You' => 'contact-form-thank-you',
      'About' => 'about'
    ];


    foreach ( $pages as $k => $v ):
      $found_post = page_exists( $k );
    if ( !$found_post ):
      $args = [
        'post_type' => 'page',
        'post_title' => $k,
        'post_name' => $v,
        'post_status' => 'publish'
      ];

    $post_id = wp_insert_post( $args );
    if ( !is_wp_error( $post_id ) ):
      //the post is valid
      else :
        //there was an error in the post insertion, 
        echo $post_id->get_error_message();
    endif;
    endif;
    endforeach;
*/
   


  //Create Pages if they don't exist
/*
	  $pages=['locations',
	  'collections',
	  'articles',
	  'letters',
	  'texts',
	  'ephemera',
	  'audio-recordings',
	  'document-finder',
	  'objects',
	  'home',
	  'blog',
	  'private-content-page',
	  'contact-form-thank-you',
	  'about'
	  ];
	  
	if($pages):
	  foreach ($pages as $page):
	  
	
	  $postarr=['post_type'=>'page',
				'post_name'=>$page
				'post_title'];
	  wp_insert_post($postarr);
	  endforeach;
	endif; */

//add_action('admin_menu','archive_admin_menus');

function archive_admin_menus(){
	  add_menu_page(
      __( 'Custom Menu Title', 'textdomain' ),
      'Research',
      'read',
      'research',
      'custom_research_page',
      'dashicons-info-outline',
		  7
  
    );

    add_menu_page(
      __( 'Custom Menu Title', 'textdomain' ),
      'Materials',
      'read',
      'materials',
      'custom_materials_page',
      'dashicons-database',
		8
     );

}

//Plugin API Manager

include_once( 'inc/plugin-api-manager/plugin-api-manager.php' );
include_once( 'inc/plugin-api-manager/subscribers/cpts.php' );
include_once( 'inc/plugin-api-manager/subscribers/archive-config.php' );
include_once( 'inc/plugin-api-manager/subscribers/admin.php' );
include_once( 'inc/plugin-api-manager/subscribers/ajax.php' );
include_once( 'inc/plugin-api-manager/subscribers/fields.php' );


$PluginAPIManager = new PluginAPIManager();
$PluginAPIManager->add_subscriber( new CustomPostTypesSubscriber() );
$PluginAPIManager->add_subscriber( new CustomFieldsSubscriber() );
$PluginAPIManager->add_subscriber( new ThemeConfig() );

$PluginAPIManager->add_subscriber( new AdminSubscriber() );
$PluginAPIManager->add_subscriber( new AjaxSubscriber() );

add_action('acf/save_post','create_person');
 function create_person($post_id) {
    // bail out if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ):
      return;
    endif;


    // Get newly saved values.
    $values = get_fields( $post_id );

    // bail early if not a person post
    if ( get_post_type( $post_id ) !== 'person' ) {

      return;

    }

    $privacy_level = get_field( 'person_privacy', $post_id );
    wp_set_object_terms( $post_id, $privacy_level, 'privacy_level', true );

    $gender = get_field( 'person_gender', $post_id );
    wp_set_object_terms( $post_id, $gender, 'gender', true );
	  
	 
	 //Workaround Re: Child Post not saving certain post meta
	 
	  $life_events=get_field('life_events',$post_id);
	  if($life_events):
	  
	  foreach ($life_events as $event):
	  $event_type=get_field('event_cat',$event);
	  $event_year=get_field('event_year',$event);
	  $event_month=get_field('event_month',$event);
	  $event_day=get_field('event_day',$event);
	  
	
	  
	  
	  $date_data=aa_convert_date($event_year,$event_month,$event_day);
	  
	  update_post_meta($event,'event_date',$date_data['database_date']);
	  update_post_meta($event,'display_date',$date_data['display_date']);
	   wp_set_object_terms($event,$event_type,'event_type',true);
	  
	  endforeach;
	  endif;
	  
	 
	 //Built-in Birth Event
	 
	   //Get Birth Data
    $month = get_field( 'birth_month', $post_id );
    $day = get_field( 'birth_day', $post_id );
    $year = get_field( 'birth_year', $post_id );
    $birth_city = get_field( 'birth_place', $post_id );


	 $date_data = aa_convert_date( $year, $month, $day );  
	 
    $birth_title = get_the_title( $post_id ) . " Birth";


    update_post_meta( $post_id, 'birth_date', $date_data[ 'display_date' ] );

    //Postarr (Birth)


    $postarr = [

      'post_type' => 'event',
      'post_parent' => $post_id,
	  'post_title'=>$birth_title,
      'tax_query' => [
        [
          'taxonomy' => 'event_type',
          'field' => 'slug',
          'terms' => 'primary_birth'
        ]
      ],
    ];

    global $repository;
    $birth = $repository->find_one( $postarr );
    unset($postarr);
    
	  if ( $birth ):
      $postarr = [
        'ID' => $birth->ID,
        'post_title' => $birth_title,
        'post_name' => $birth_title,
        'meta_input' => [
          'display_date' => $date_data[ 'display_date' ],
          'event_date' => $date_data[ 'database_date' ],
          'event_city' => $birth_city,
          'event_year' => $year,
          'event_month' => $month,
          'event_day' => $day,
          'event_name' => $birth_title,
          //'event_place' => $birth_place,

        ]
      ];

    else :
      $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_title' => $birth_title,
        'post_name' => $birth_title,
        'post_parent' => $post_id,
        'meta_input' => [
          'display_date' => $date_data[ 'display_date' ],
          'event_date' => $date_data[ 'database_date' ],
          'event_city' => $birth_city,
          'event_year' => $year,
          'event_month' => $month,
          'event_day' => $day,
          'event_name' => $birth_title,
          // 'event_place' => $birth_place
        ]
      ];
   
    endif;
 $birth_event = $repository->save( $postarr );

    wp_set_object_terms( $birth_event, 'primary_birth', 'event_type', true );
    wp_set_object_terms( $birth_event, $privacy_level, 'privacy_level', true );
	 
	  unset($month);
	 unset($day);
	 unset($year);
	 
	 
	 //Built-in Death Event
	 
	$month = get_field( 'death_month', $post_id );
    $day = get_field( 'death_day', $post_id );
    $year = get_field( 'death_year', $post_id );
    $death_city = get_field( 'death_place', $post_id );

   
    $death_data = aa_convert_date( $year, $month, $day );

    update_post_meta( $post_id, 'death_date', $death_data[ 'display_date' ] );
    $death_title = get_the_title( $post_id ) . " Death";


    $postarr = [

      'post_type' => 'event',
      'post_parent' => $post_id,
	  'post_title' =>$death_title,
      'tax_query' => [
        [
          'taxonomy' => 'event_type',
          'field' => 'slug',
          'terms' => 'primary_death'
        ]
      ],
    ];

    global $repository;
    $death = $repository->find_one( $postarr );
 unset($postarr);
	 
    if ( $death ):
      $postarr = [
        'ID' => $death->ID,
        'post_title' => $death_title,
        'post_name' => $death_title,
        'meta_input' => [
          'display_date' => $death_data[ 'display_date' ],
          'event_date' => $death_data[ 'database_date' ],
          'event_city' => $death_city,
          'event_year' => $year,
          'event_month' => $month,
          'event_day' => $day,
          'event_name' => $death_title,
          //'event_place' => $death_place,

        ]
      ];

    else :
      $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_title' => $death_title,
        'post_name' => $death_title,
        'post_parent' => $post_id,
        'meta_input' => [
          'display_date' => $death_data[ 'display_date' ],
          'event_date' => $death_data[ 'database_date' ],
          'event_city' => $death_city,
          'event_year' => $year,
          'event_month' => $month,
          'event_day' => $day,
          'event_name' => $death_title,
          // 'event_place' => $death_place
        ]
      ];
    
    endif;

$death_event = $repository->save( $postarr );
    wp_set_object_terms( $death_event, 'primary_death', 'event_type', true );
    wp_set_object_terms( $death_event, $privacy_level, 'privacy_level', true );

  }


// Register Bootstrap 5 Nav Walker
if ( !function_exists( 'register_navwalker' ) ):
  function register_navwalker() {
    require_once( 'inc/class-bootstrap-5-navwalker.php' );
    // Register Menus
    register_nav_menus(
      [

        'logged-out' => __( 'Logged-out' ),
        'logged-in' => __( 'Logged-in' ),

      ] );
  }
endif;
add_action( 'after_setup_theme', 'register_navwalker' );
// Register Bootstrap 5 Nav Walker END


// Register Comment List
if ( !function_exists( 'register_comment_list' ) ):
  function register_comment_list() {
    // Register Comment List
    require_once( 'inc/comment-list.php' );
  }
endif;
add_action( 'after_setup_theme', 'register_comment_list' );
// Register Comment List END


if ( !function_exists( 'bootscore_setup' ) ):
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function bootscore_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Bootscore, use a find and replace
     * to change 'bootscore' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'bootscore', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    if ( get_option( 'custom_roles_version' ) < 1 ):

      add_role( 'family', 'Family', get_role( 'subscriber' )->capabilities );
    $family = get_role( 'family' );
    $family->add_cap( 'view_family' );
    update_option( 'custom_roles_version', 1 );
    endif;



    /*
     * Set permlinks on theme activate
     */

    $current_setting = get_option( 'permalink_structure' );

    // Abort if already saved to something else
    if ( $current_setting == '/%postname%/' ) {
      return;
    }

    // Save permalinks to a custom setting, force create of rules file
    global $wp_rewrite;
    update_option( "rewrite_rules", FALSE );
    $wp_rewrite->set_permalink_structure( '/%postname%/' );
    $wp_rewrite->flush_rules( true );


/*if (get_option()):
endif; */


  }
endif;
add_action( 'after_setup_theme', 'bootscore_setup' );



//add_action('acf/save_post', 'my_acf_save_post', 5);
function my_acf_save_post( $post_id ) {

    // Get previous values.
    $prev_values = get_fields( $post_id );

    // Get submitted values.
    $values = $_POST['acf'];

    // Check if a specific value was updated.
    if( !isset($_POST['acf']['field_632ee78']) ) {
        // Do something.
		update_post_meta( $post_id, 'birth_month', "00" );
    }
	
	 // Check if a specific value was updated.
    if( !isset($_POST['acf']['field_abc123']) ) {
        // Do something.
		update_post_meta( $post_id, 'birth_day', $formal_bdate );
    }
	
}





/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bootscore_content_width() {
  // This variable is intended to be overruled from themes.
  // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
  // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
  $GLOBALS[ 'content_width' ] = apply_filters( 'bootscore_content_width', 640 );
}
add_action( 'after_setup_theme', 'bootscore_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// Widgets
if ( !function_exists( 'bootscore_widgets_init' ) ):

  function bootscore_widgets_init() {

    // Top Nav
    register_sidebar( array(
      'name' => esc_html__( 'Top Nav', 'bootscore' ),
      'id' => 'top-nav',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="ms-3">',
      'after_widget' => '</div>',
      'before_title' => '<div class="widget-title d-none">',
      'after_title' => '</div>'
    ) );
    // Top Nav End

    // Top Nav Search
    register_sidebar( array(
      'name' => esc_html__( 'Top Nav Search', 'bootscore' ),
      'id' => 'top-nav-search',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="top-nav-search">',
      'after_widget' => '</div>',
      'before_title' => '<div class="widget-title d-none">',
      'after_title' => '</div>'
    ) );
    // Top Nav Search End

    // Sidebar
    register_sidebar( array(
      'name' => esc_html__( 'Sidebar', 'bootscore' ),
      'id' => 'sidebar-1',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s card card-body mb-4 bg-light border-0">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title card-title border-bottom py-2">',
      'after_title' => '</h2>',
    ) );
    // Sidebar End

    // Top Footer
    register_sidebar( array(
      'name' => esc_html__( 'Top Footer', 'bootscore' ),
      'id' => 'top-footer',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="footer_widget mb-5">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>'
    ) );
    // Top Footer End

    // Footer 1
    register_sidebar( array(
      'name' => esc_html__( 'Footer 1', 'bootscore' ),
      'id' => 'footer-1',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title h4">',
      'after_title' => '</h2>'
    ) );
    // Footer 1 End

    // Footer 2
    register_sidebar( array(
      'name' => esc_html__( 'Footer 2', 'bootscore' ),
      'id' => 'footer-2',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title h4">',
      'after_title' => '</h2>'
    ) );
    // Footer 2 End

    // Footer 3
    register_sidebar( array(
      'name' => esc_html__( 'Footer 3', 'bootscore' ),
      'id' => 'footer-3',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title h4">',
      'after_title' => '</h2>'
    ) );
    // Footer 3 End

    // Footer 4
    register_sidebar( array(
      'name' => esc_html__( 'Footer 4', 'bootscore' ),
      'id' => 'footer-4',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title h4">',
      'after_title' => '</h2>'
    ) );
    // Footer 4 End

    // 404 Page
    register_sidebar( array(
      'name' => esc_html__( '404 Page', 'bootscore' ),
      'id' => '404-page',
      'description' => esc_html__( 'Add widgets here.', 'bootscore' ),
      'before_widget' => '<div class="mb-4">',
      'after_widget' => '</div>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>'
    ) );
    // 404 Page End

  }
add_action( 'widgets_init', 'bootscore_widgets_init' );


endif;
// Widgets END


// Shortcode in HTML-Widget
add_filter( 'widget_text', 'do_shortcode' );
// Shortcode in HTML-Widget End


//Enqueue scripts and styles
function bootscore_scripts() {

  // Get modification time. Enqueue files with modification date to prevent browser from loading cached scripts and styles when file content changes.
  $modificated_styleCss = date( 'YmdHi', filemtime( get_stylesheet_directory() . '/style.css' ) );
  if ( file_exists( get_template_directory() . '/css/main.css' ) ) {
    $modificated_bootscoreCss = date( 'YmdHi', filemtime( get_template_directory() . '/css/bootstrap.min.css' ) );
  } else {
    $modificated_bootscoreCss = 1;
  }
  $modificated_customCss = date( 'YmdHi', filemtime( get_template_directory() . '/css/custom.css' ) );
  $modificated_fontawesomeCss = date( 'YmdHi', filemtime( get_template_directory() . '/fontawesome/css/all.min.css' ) );
  $modificated_bootstrapJs = date( 'YmdHi', filemtime( get_template_directory() . '/js/lib/bootstrap.bundle.min.js' ) );
  $modificated_themeJs = date( 'YmdHi', filemtime( get_template_directory() . '/js/theme.js' ) );


  // $modificated_lightboxCss = date( 'YmdHi', filemtime( get_template_directory_uri() . '/css/lib/lightbox/lightbox.css' ) );
  // $modificated_lightboxJs = date( 'YmdHi', filemtime( get_template_directory_uri() . '/js/lib/lightbox/lightbox.js' ) );

  // Style CSS
  wp_enqueue_style( 'bootscore-style', get_stylesheet_uri(), array(), $modificated_styleCss );

  // bootScore
  //require_once 'inc/scss-compiler.php';
  //bootscore_compile_scss();
  wp_enqueue_style( 'main', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $modificated_bootscoreCss );

  //Custom Css
  wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css', array(), $modificated_customCss );

	
	
	
  //Lightbox Css & Js

  wp_enqueue_style( 'lightbox', get_template_directory() . '/css/lib/lightbox/lightbox.css', array(), $modificated_lightboxCss );
  wp_enqueue_script( 'lightbox', get_template_directory() . '/js/lib/lightbox/lightbox.js', array( 'jquery' ), $modificated_lightboxJs, true );

  // Fontawesome
  wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/fontawesome/css/all.min.css', array(), $modificated_fontawesomeCss );

  // Bootstrap JS
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.bundle.min.js', array(), $modificated_bootstrapJs, true );

  // Theme JS
  wp_enqueue_script( 'bootscore-script', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), $modificated_themeJs, true );

  // IE Warning
  wp_localize_script( 'bootscore-script', 'bootscore', array(
    'ie_title' => __( 'Internet Explorer detected', 'bootscore' ),
    'ie_limited_functionality' => __( 'This website will offer limited functionality in this browser.', 'bootscore' ),
    'ie_modern_browsers_1' => __( 'Please use a modern and secure web browser like', 'bootscore' ),
    'ie_modern_browsers_2' => __( ' <a href="https://www.mozilla.org/firefox/" target="_blank">Mozilla Firefox</a>, <a href="https://www.google.com/chrome/" target="_blank">Google Chrome</a>, <a href="https://www.opera.com/" target="_blank">Opera</a> ', 'bootscore' ),
    'ie_modern_browsers_3' => __( 'or', 'bootscore' ),
    'ie_modern_browsers_4' => __( ' <a href="https://www.microsoft.com/edge" target="_blank">Microsoft Edge</a> ', 'bootscore' ),
    'ie_modern_browsers_5' => __( 'to display this site correctly.', 'bootscore' ),
  ) );
  // IE Warning End

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'bootscore_scripts' );
//Enqueue scripts and styles END


// Preload Font Awesome
add_filter( 'style_loader_tag', 'bootscore_fa_preload' );

function bootscore_fa_preload( $tag ) {

  $tag = preg_replace( "/id='fontawesome-css'/", "id='fontawesome-css' online=\"if(media!='all')media='all'\"", $tag );

  return $tag;
}
// Preload Font Awesome END


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
  require get_template_directory() . '/inc/jetpack.php';
}


// Amount of posts/products in category
if ( !function_exists( 'wpsites_query' ) ):

  function wpsites_query( $query ) {
    if ( $query->is_archive() && $query->is_main_query() && !is_admin() ) {
      $query->set( 'posts_per_page', 24 );
    }
  }
add_action( 'pre_get_posts', 'wpsites_query' );

endif;
// Amount of posts/products in category END


// Pagination Categories
if ( !function_exists( 'bootscore_pagination' ) ):

  function bootscore_pagination( $pages = '', $range = 2 ) {
    $showitems = ( $range * 2 ) + 1;
    global $paged;
    // default page to one if not provided
    if ( empty( $paged ) )$paged = 1;
    if ( $pages == '' ) {
      global $wp_query;
      $pages = $wp_query->max_num_pages;

      if ( !$pages )
        $pages = 1;
    }

    if ( 1 != $pages ) {
      echo '<nav aria-label="Page navigation" role="navigation">';
      echo '<span class="sr-only">Page navigation</span>';
      echo '<ul class="pagination justify-content-center ft-wpbs mb-4">';


      if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( 1 ) . '" aria-label="First Page">&laquo;</a></li>';

      if ( $paged > 1 && $showitems < $pages )
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( $paged - 1 ) . '" aria-label="Previous Page">&lsaquo;</a></li>';

      for ( $i = 1; $i <= $pages; $i++ ) {
        if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) )
          echo( $paged == $i ) ? '<li class="page-item active"><span class="page-link"><span class="sr-only">Current Page </span>' . $i . '</span></li>': '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( $i ) . '"><span class="sr-only">Page </span>' . $i . '</a></li>';
      }

      if ( $paged < $pages && $showitems < $pages )
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( ( $paged === 0 ? 1 : $paged ) + 1 ) . '" aria-label="Next Page">&rsaquo;</a></li>';

      if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages )
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( $pages ) . '" aria-label="Last Page">&raquo;</a></li>';

      echo '</ul>';
      echo '</nav>';
      // Uncomment this if you want to show [Page 2 of 30]
      // echo '<div class="pagination-info mb-5 text-center">[ <span class="text-muted">Page</span> '.$paged.' <span class="text-muted">of</span> '.$pages.' ]</div>';	 	
    }
  }

endif;
//Pagination Categories END


// Pagination Buttons Single Posts
add_filter( 'next_post_link', 'post_link_attributes' );
add_filter( 'previous_post_link', 'post_link_attributes' );

function post_link_attributes( $output ) {
  $code = 'class="page-link"';
  return str_replace( '<a href=', '<a ' . $code . ' href=', $output );
}
// Pagination Buttons Single Posts END


// Excerpt to pages
add_post_type_support( 'page', 'excerpt' );
// Excerpt to pages END


// Breadcrumb
if ( !function_exists( 'the_breadcrumb' ) ):
  function the_breadcrumb() {
    if ( !is_home() ) {
      echo '<nav class="breadcrumb mb-4 mt-2 bg-light py-2 px-3 small rounded">';
      echo '<a href="' . home_url( '/' ) . '">' . ( '<i class="fa-solid fa-house"></i>' ) . '</a><span class="divider">&nbsp;/&nbsp;</span>';
      if ( is_category() || is_single() ) {
        the_category( ' <span class="divider">&nbsp;/&nbsp;</span> ' );
        if ( is_single() ) {
          echo ' <span class="divider">&nbsp;/&nbsp;</span> ';
          the_title();
        }
      } elseif ( is_page() ) {
        echo the_title();
      }
      echo '</nav>';
    }
  }
add_filter( 'breadcrumbs', 'breadcrumbs' );
endif;
// Breadcrumb END


// Comment Button
function bootscore_comment_form( $args ) {
  $args[ 'class_submit' ] = 'btn btn-outline-primary'; // since WP 4.1    
  return $args;
}
add_filter( 'comment_form_defaults', 'bootscore_comment_form' );
// Comment Button END


// Password protected form
function bootscore_pw_form() {
  $output = '
		  <form action="' . get_option( 'siteurl' ) . '/wp-login.php?action=postpass" method="post" class="form-inline">' . "\n"
  . '<input name="post_password" type="password" size="" class="form-control me-2 my-1" placeholder="' . __( 'Password', 'bootscore' ) . '"/>' . "\n"
  . '<input type="submit" class="btn btn-outline-primary my-1" name="Submit" value="' . __( 'Submit', 'bootscore' ) . '" />' . "\n"
  . '</p>' . "\n"
  . '</form>' . "\n";
  return $output;
}
add_filter( "the_password_form", "bootscore_pw_form" );
// Password protected form END


// Allow HTML in term (category, tag) descriptions
foreach ( array( 'pre_term_description' ) as $filter ) {
  remove_filter( $filter, 'wp_filter_kses' );
  if ( !current_user_can( 'unfiltered_html' ) ) {
    add_filter( $filter, 'wp_filter_post_kses' );
  }
}

foreach ( array( 'term_description' ) as $filter ) {
  remove_filter( $filter, 'wp_kses_data' );
}
// Allow HTML in term (category, tag) descriptions END


// Allow HTML in author bio
remove_filter( 'pre_user_description', 'wp_filter_kses' );
add_filter( 'pre_user_description', 'wp_filter_post_kses' );
// Allow HTML in author bio END


// Hook after #primary
function bs_after_primary() {
  do_action( 'bs_after_primary' );
}
// Hook after #primary END


// Open links in comments in new tab
if ( !function_exists( 'bs_comment_links_in_new_tab' ) ):
  function bs_comment_links_in_new_tab( $text ) {
    return str_replace( '<a', '<a target="_blank" rel=”nofollow”', $text );
  }
add_filter( 'comment_text', 'bs_comment_links_in_new_tab' );
endif;
// Open links in comments in new tab END


// Disable Gutenberg blocks in widgets (WordPress 5.8)
// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );
// Disable Gutenberg blocks in widgets (WordPress 5.8) END


function my_plugins_dir_url( $file ) {
  return trailingslashit( my_plugins_url( '', $file ) );
}

function my_plugins_url( $path = '', $plugin = '' ) {

  $path = wp_normalize_path( $path );
  $plugin = wp_normalize_path( $plugin );
  $mu_plugin_dir = wp_normalize_path( WPMU_PLUGIN_DIR );


  $url = get_template_directory_uri() . '/inc';

  $url = set_url_scheme( $url );

  if ( !empty( $plugin ) && is_string( $plugin ) ) {
    $folder = dirname( plugin_basename( $plugin ) );
    if ( '.' !== $folder ) {
      $url .= '/' . ltrim( $folder, '/' );
    }
  }

  if ( $path && is_string( $path ) ) {
    $url .= '/' . ltrim( $path, '/' );
  }

  /**
   * Filters the URL to the plugins directory.
   *
   * @since 2.8.0
   *
   * @param string $url    The complete URL to the plugins directory including scheme and path.
   * @param string $path   Path relative to the URL to the plugins directory. Blank string
   *                       if no path is specified.
   * @param string $plugin The plugin file path to be relative to. Blank string if no plugin
   *                       is specified.
   */
  return apply_filters( 'my_plugins_url', $url, $path, $plugin );
}


//Install Search Filter Pro Database

function search_filter_db_install() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'search_filter_cache';

  $charset_collate = '';

  if ( $wpdb->has_cap( 'collation' ) ) {
    $charset_collate = $wpdb->get_charset_collate();
  }

  $sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			post_id bigint(20) NOT NULL,
			post_parent_id bigint(20) NOT NULL,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			field_parent_num bigint(20) NULL,
			term_parent_id bigint(20) NULL,
			PRIMARY KEY  (id),
            KEY sf_c_field_name_index (field_name(32)),
            KEY sf_c_field_value_index (field_value(32)),
            KEY sf_c_field_value_num_index (field_value_num)
		) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  $table_name = $wpdb->prefix . 'search_filter_term_results';


  $sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			result_ids mediumtext NOT NULL,
			PRIMARY KEY  (id),
            KEY sf_tr_field_name_index (field_name(32)),
            KEY sf_tr_field_value_index (field_value(32)),
            KEY sf_tr_field_value_num_index (field_value_num)

		) $charset_collate;";


  dbDelta( $sql );
}


function example_db_install() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'ajax_database';

  $charset_collate = '';

  if ( $wpdb->has_cap( 'collation' ) ) {
    $charset_collate = $wpdb->get_charset_collate();
  }

  $sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			
			_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			field_parent_num bigint(20) NULL,
			term_parent_id bigint(20) NULL,
			PRIMARY KEY  (id),
            KEY sf_c_field_name_index (field_name(32)),
            KEY sf_c_field_value_index (field_value(32)),
            KEY sf_c_field_value_num_index (field_value_num)
		) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  $table_name = $wpdb->prefix . 'search_filter_term_results';


  $sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			result_ids mediumtext NOT NULL,
			PRIMARY KEY  (id),
            KEY sf_tr_field_name_index (field_name(32)),
            KEY sf_tr_field_value_index (field_value(32)),
            KEY sf_tr_field_value_num_index (field_value_num)

		) $charset_collate;";


  dbDelta( $sql );
}



function archive_scratch_page(){
	include ('inc/scratch/scratch.php');

}

function aa_scratch_function(){
		include ('inc/scratch/scratch.php');
}


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Field Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Event Settings',
		'menu_title'	=> 'Event',
		'parent_slug'	=> 'theme-general-settings',
	));
	
		acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme People Settings',
		'menu_title'	=> 'People',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Place Settings',
		'menu_title'	=> 'Place',
		'parent_slug'	=> 'theme-general-settings',
	));
}

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Blog';
   // $submenu['edit.php'][5][0] = 'Posts';
   // $submenu['edit.php'][10][0] = 'Add Post';
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Blog';
        $labels->singular_name = 'Blog';
        $labels->add_new = 'Add Blog Post';
        $labels->add_new_item = 'Add Post';
        $labels->edit_item = 'Edit Post';
        $labels->new_item = 'Post';
        $labels->view_item = 'View Post';
        $labels->search_items = 'Search Blog';
        $labels->not_found = 'No Blog Posts found';
        $labels->not_found_in_trash = 'No Blog posts found in Trash';
        $labels->name_admin_bar = 'Add Post';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

//Stuff to organize later

/**
 * Fire a callback only when my-custom-post-type posts are transitioned to 'publish'.
 *
 * @param string  $new_status New post status.
 * @param string  $old_status Old post status.
 * @param WP_Post $post       Post object.
 */

function aa_get_all_post_meta_keys()
	{
	
	$post_meta_keys = array();
	
		if(is_array($post_meta_keys))
		{
			$num_meta_keys = count($post_meta_keys);
			if($num_meta_keys==0)
			{
				$ignore_list = array(
					'_wp_page_template', '_edit_lock', '_edit_last', '_menu_item_type', '_menu_item_menu_item_parent', '_menu_item_object_id', '_menu_item_object', '_menu_item_target', '_menu_item_classes', '_menu_item_xfn', '_menu_item_url', '_search-filter-fields'
				);
				global $wpdb;
				$data   =   array();

			
	                $wpdb->query("
                        SELECT DISTINCT(`meta_key`) 
                        FROM $wpdb->postmeta ORDER BY `meta_key` ASC
                    ");
                

				foreach($wpdb->last_result as $k => $v){
					//$data[$v->meta_key] =   $v->meta_value;
					$data[] = $v->meta_key;
				}
				
				$post_meta_keys = $data;

			}
		}
		
		return $post_meta_keys;
	}
	
add_filter('registration_errors','reg_validation',10,3);
function reg_validation($errors, $sanitized_user_login, $user_email){
		    if ( empty( $_POST['fname'])  ) {
        $errors->add( 'user_fname_error', __( '<strong>Error</strong>: Please provide your first name.', 'my_textdomain' ) );
    }
		
	
		return $errors;
	}

add_action('admin_menu','setup_admin_menus');
     function setup_admin_menus() {
    add_menu_page(
      __( 'Custom Menu Title', 'textdomain' ),
      'Research',
      'read',
      'research',
      'custom_research_page',
      'dashicons-info-outline',
		7
  
    );

    add_menu_page(
      __( 'Custom Menu Title', 'textdomain' ),
      'Materials',
      'read',
      'materials',
      'custom_materials_page',
      'dashicons-database',
		8
		
     );

$menu_slug = 'scratch-slug';
add_menu_page( 
	__('Active Archive Admin','textdomain'), 
	'Attic Archive', 
	'read', 
	$menu_slug, 
	false 
);
add_submenu_page( $menu_slug, 'Overview', 'Settings', 'read', $menu_slug, 'aa_scratch_function',1 );
add_submenu_page( $menu_slug, 'Overview', 'Unit Tests', 'read', 'unit-tests', 'unit_tests',2 );
}
function unit_tests(){
	include ('inc/scratch/unit-tests.php');
}