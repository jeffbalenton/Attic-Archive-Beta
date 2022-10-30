<?php


if ( !class_exists( 'ThemeConfig' ) ):

  class ThemeConfig
implements SubscriberInterface {


  /* * * * * * * * * *
   * Class constructor
   * * * * * * * * * */
  public function __construct() {


  }

  public static function get_subscribed_hooks() {
    return [

      'acf/settings/url' => 'my_acf_settings_url',
      'acfe/settings/url' => 'my_acfe_settings_url',
      'wp_nav_menu_objects' => [ 'my_wp_nav_menu_objects', 10, 2 ],


      //ACF Logic
      'acf/save_post' => 'contact_form_submission',
      'acf/save_post' => 'normalized_photo_date',
      //'save_post' => ['create_person',75,2],
      //'save_post_person' => ['create_birth_event',35,2],
      //'save_post' => ['create_death_event',36,2],
      // 'save_post' => ['create_event_date',45,2],
      'acf/load_field/name=event_cat' => 'acf_load_term_choices',
      // 'save_post' => 'create_life_event',75,2,
      // 'acf/render_field/name=user_login_name'=>'user_name_register',
      //
      'acf/save_post' => 'registration_form_submission',

      //Starter
      //'admin_init' => 'autoimport',
      'wp_loaded' => 'archive_defaults',
      'template_include' => 'private_content',
      //'registration_enqueue_scripts' => 'custom_login_scripts',
	  //'registration_errors' => ['reg_validation',10,3],
      // '' => '',
      // '' => '',


    ];
  }
	
	

function custom_login_scripts(){
	  if ( file_exists( get_template_directory() . '/css/main.css' ) ) {
    $modificated_bootscoreCss = date( 'YmdHi', filemtime( get_template_directory() . '/css/bootstrap.min.css' ) );
  } else {
    $modificated_bootscoreCss = 1;
  }
	$modificated_bootstrapJs = date( 'YmdHi', filemtime( get_template_directory() . '/js/lib/bootstrap.bundle.min.js' ) );
	// Bootstrap CSS
	
wp_enqueue_style( 'main', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $modificated_bootscoreCss );
	wp_enqueue_style( get_template_directory_uri() . '/css/custom.css');
	 // Bootstrap JS
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.bundle.min.js', array(), $modificated_bootstrapJs, true );
	
}
	  
	  
function user_name_register($field){
	return '<p>hello world';
}
  function private_content( $template ) {
	  
	  
	  
	  
	  
    $user = wp_get_current_user();
    $allowed_roles = array( 'editor', 'administrator', 'author' );
	  switch (true){
		  case is_single() && has_term('family','privacy_level') && !is_user_logged_in():
			  wp_safe_redirect(home_url("/private-content-page?action=register"));
			  die();
			 case is_single() && has_term('family','privacy_level') && !array_intersect( $allowed_roles, $user->roles ):
			  wp_safe_redirect(home_url('/private-content-page'));
			  die();
		  default :
			  return $template;
	  }
	  
	  
	
	  
	  
    

    }

  

  function acf_load_term_choices( $field ) {

    //Workaround for issues with Child Post Field not saving terms to life event 

    //Reset choices 
    $field[ 'choices' ] = [];

    $terms = get_terms( array(
      'taxonomy' => 'event_type',
      'hide_empty' => false,
    ) );
    foreach ( $terms as $term ):
      // append to choices
      $field[ 'choices' ][ $term->slug ] = $term->name;
    endforeach;

    // return the field
    return $field;

  }


  function create_birth_event( $post_id, $post ) {
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

    //Create Birth Date

    $privacy_level = get_field( 'person_privacy', $post_id );
    //Get Birth Data
    $month = get_field( 'birth_month', $post_id );
    $day = get_field( 'birth_day', $post_id );
    $year = get_field( 'birth_year', $post_id );
    $birth_city = get_field( 'birth_place', $post_id );


    $date_data = aa_convert_date( $year, $month, $day );

    $title = get_the_title( $post_id ) . " Birth";


    update_post_meta( $post_id, 'birth_date', $date_data[ 'display_date' ] );

    //Postarr (Birth)


    $postarr = [

      'post_type' => 'event',
      'post_parent' => $post_id,
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
    unset( $postarr );

    if ( $birth ):
      $postarr = [
        'ID' => $birth->ID,
        'post_title' => $title,
        'post_name' => $title,
        'meta_input' => [
          'display_date' => $date_data[ 'display_date' ],
          'event_date' => $date_data[ 'database_date' ],
          'event_city' => $birth_city,
          'event_year' => $year,
          'event_month' => $month,
          'event_day' => $day,
          'event_name' => $title,
          //'event_place' => $birth_place,

        ]
      ];

    else :
      $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_title' => $title,
        'post_name' => $title,
        'post_parent' => $post_id,
        'meta_input' => [
          'display_date' => $date_data[ 'display_date' ],
          'event_date' => $date_data[ 'database_date' ],
          'event_city' => $birth_city,
          'event_year' => $year,
          'event_month' => $month,
          'event_day' => $day,
          'event_name' => $title,
          // 'event_place' => $birth_place
        ]
      ];

    endif;
    $birth_event = $repository->save( $postarr );

    wp_set_object_terms( $birth_event, 'primary_birth', 'event_type', true );
    wp_set_object_terms( $birth_event, $privacy_level, 'privacy_level', true );


  }

  function create_death_event( $post_id, $post ) {

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

    //Get Death Data

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

    $death_event = $repository->save( $postarr );

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
    $death_event = $repository->save( $postarr );
    endif;


    wp_set_object_terms( $death_event, 'primary_death', 'event_type', true );
    wp_set_object_terms( $death_event, $privacy_level, 'privacy_level', true );


  }

  // Customize the url setting to fix incorrect asset URLs.
  function my_acf_settings_url( $url ) {
    return MY_ACF_URL;
  }

  function my_acfe_settings_url( $url ) {
    return MY_ACFE_URL;
  }

  function my_wp_nav_menu_objects( $items, $args ) {

    // loop
    foreach ( $items as & $item ) {

      // vars
      $icon = get_field( 'icon', $item );


      // append icon
      if ( $icon ) {

        $item->title .= ' <i class="fa fa-' . $icon . '"></i>';

      }

    }
    // return
    return $items;

  }

  function registration_form_submission( $post_id ) {
    // bail early if not a contact_form post
    if ( get_post_type( $post_id ) !== 'register_form' ) {

      return;

    }

    // bail early if editing in admin
    if ( is_admin() ) {

      return;

    }


    // vars
    $post = get_post( $post_id );

    $title = 'new registration request';

    update_post_meta( $post_id, 'title', $title );


  }

  function contact_form_submission( $post_id ) {

    // bail early if not a contact_form post
    if ( get_post_type( $post_id ) !== 'contact_form' ) {

      return;

      // get custom fields (field group exists for content_form)
      $name = get_field( 'name', $post_id );
      $email = get_field( 'email', $post_id );

    }


    // bail early if editing in admin
    if ( is_admin() ) {

      return;

    }


    // vars
    $post = get_post( $post_id );


    // get custom fields (field group exists for content_form)
    $name = get_field( 'name', $post_id );
    $email = get_field( 'email', $post_id );


    // email data
    $to = 'contact@website.com';
    $headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
    $subject = $post->post_title;
    $body = $post->post_content;


    // send email
    wp_mail( $to, $subject, $body, $headers );

  }


  function normalized_photo_date( $post_id ) {

    // bail early if not a person post
    if ( get_post_type( $post_id ) !== 'photo' ):

      return;
    endif;

    // Get newly saved values.
    $values = get_fields( $post_id );
    // Check the new value of a specific field.
    $year = get_field( 'year_taken', $post_id );
    $month = get_field( 'month_taken', $post_id );
    $day = get_field( 'day_taken', $post_id );


    $photo_date = aa_convert_date( $year, $month, $day );

    if ( $photo_date ):
      update_post_meta( $post_id, 'date_taken', $photo_date[ 'display_date' ] );

    endif;

  }

  /**
   * The main controller for the actual import stage.
   *
   * @param string $file Path to the WXR file for importing
   */
   function archive_defaults() {
	       global $repository;
$starter_content_chech=get_option('starter_content_check');
	   if($starter_content_check !== 'yes'):
	   
    $posts = [ 'Root Person' => 'person',
      'Sample Task' => 'task',
      'Sample Bookmark' => 'bookmark',
      'Sample Photo' => 'photo',
      'Sample Photo Album' => 'photo-album',
      'Sample Story' => 'story'
    ];


  if ( $posts ):

  foreach ( $posts as $post_name => $post_type ):
    $postarr = [ 'post_title' => $post_name,
      'post_name' => $postname,
      'post_type' => $post_type,
      'post_status' => 'publish',
    ];
  $found_post = $repository->find_one( $postarr );
  if ( !$found_post ) {
    $repository->save( $postarr );
  }
  endforeach;
  endif;
	   
    //Create Pages if they don't exist
    $pages = [ 'locations' => 'Locations',
      'collections' => 'Collections',
      'articles' => 'Articles',
      'letters' => 'Letters',
      'texts' => 'Texts',
      'ephemera' => 'Ephemera',
      'audio-recordings' => 'Audio Recordings',
      'document-finder' => 'Documents',
      'objects' => 'Objects',
      'home' => 'Home',
      'blog' => 'Blog',
      'private-content-page' => 'Private Content Page',
      'contact-form-thank-you' => 'Thank You Page',
	  'about' => 'About',
    ];


    foreach ( $pages as $k => $v ):

      if ( !page_exists( $k ) ):
        $postarr = [ 'post_type' => 'page',
          'post_name' => $k,
          'post_title' => $v,
          'post_status' => 'publish'
        ];
    wp_insert_post( $postarr );
    endif;

    endforeach;

    $about_check = get_option( 'about_page_check' );
    if ( $about_check !== 'done' ):
   

    $postarr = [
      'post_type' => 'page',
      'post_title' => 'about',
	  
    ];
    $about = $repository->find_one( $postarr );

    $postarr = [ 'ID' => !empty( $about ) ? $about->ID : '',
      'post_content' => "When my parents passed away recently I made many fascinating discoveries within boxes that had been shuffled around for 3 and in some cases 4 generations.  

The treasures included:

Albums of antique family photos dating back to the civil war,
Customer letters my grandma saved when she worked at Montgomery Ward in the 1930s
My Great Great Grandmother’s scrapbook full of clippings dating back to the 1850s
Thousands of letters including every letter exchanged by my grandparents during WWII
So much more
 
In the process of going through these items I started to learn more about my family’s history.  

I ran with it and started digging into genealogical research for the first time.

I built this site as a way to organize what I found in the boxes and while doing research.

Along the way it occurred to me that I’m not the only one in this situation and maybe others could use a similar site.

I’m starting with a round of private beta testers but you can play around with a demo site here.  You can add photos, materials,etc. ",
      'post_status' => 'publish'
    ];

    $repository->save( $postarr );

  update_option('about_page_check','done');
    endif;

	update_option('starter_content_check','yes');
	   endif;
	   
    //Set Initial Defaults
    $defaults_check = get_option( 'set_archive_defaults' );
    if ( $defauls_check !== 'done' ):
      update_option( 'posts_per_page', '5' );
    update_option( 'set_archive_defaults', 'complete' );
    endif;


    //Set Home Page and Blog Page
    $set_default_pages = get_option( 'set_default_pages' );
    if ( $set_default_pages != 'done' ):


      //Set options for Front Page and Blog Page

      // Use a static front page
      $home = get_page_by_title( 'Home' );
    update_option( 'page_on_front', $home->ID );
    update_option( 'show_on_front', 'page' );

    // Set the blog page
    $blog = get_page_by_title( 'Blog' );
    update_option( 'page_for_posts', $blog->ID );

    update_option( 'set_default_pages', 'done' );
    endif;

    $menu_check = get_option( 'menu_check' );
    if ( $menu_check !== 'yes' ):


      //Create Menu
      $menu_name = 'Logged-out-menu';
    $menu_id = wp_create_nav_menu( $menu_name );

    //$menu = get_term_by( 'name', $name, 'nav_menu' );  

    //then add the actuall link/ menu item/s and you do this for each item you want to add
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Home' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/' ),
      'menu-item-status' => 'publish' ) );

    //then add the actuall link/ menu item and you do this for each item you want to add
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'About' ),
      'menu-item-classes' => 'about',
      'menu-item-url' => home_url( '/about' ),
      'menu-item-status' => 'publish' ) );

    //then add the actuall link/ menu item and you do this for each item you want to add
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Blog' ),
      'menu-item-classes' => 'blog',
      'menu-item-url' => home_url( '/blog' ),
      'menu-item-status' => 'publish' ) );

    //then add the actuall link/ menu item and you do this for each item you want to add
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Person Finder' ),
      'menu-item-classes' => 'person-finder',
      'menu-item-url' => home_url( '/people' ),
      'menu-item-status' => 'publish' ) );

    //Top Level Menu (menu_item-parent-id=0)
    $photo = wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Photos' ),
      'menu-item-classes' => 'photos',
      'menu-item-url' => '#',
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Photo Albums' ),
      'menu-item-classes' => 'photo-albums',
      'menu-item-url' => home_url( '/photo-albums' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $photo,
    ] );


    //Top Level Menu (menu_item-parent-id=0)
    $materials_id = wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Materials' ),
      'menu-item-classes' => 'materials',
      'menu-item-url' => '#',
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish'
    ] );


    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Articles' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/articles' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,

    ] );


    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Audio Recordings' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/audio-recordings' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id
    ] );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Document Finder' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/document-finder' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,
    ] );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Ephemera' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/ephemera' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,
    ] );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Letters' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/letters' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,
    ] );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Objects' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/objects' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,
    ] );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Places' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/places' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,
    ] );

    //Sub menu item (first child)
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Texts' ),
      'menu-item-classes' => 'home',
      'menu-item-url' => home_url( '/texts' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $materials_id,
    ] );

    $name = 'Logged-in-menu';
    //create the menu
    $menu_id = wp_create_nav_menu( $name );

    //Top Level Menu (menu_item-parent-id=0)
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Blog' ),
      'menu-item-classes' => 'Blog',
      'menu-item-url' => home_url( '/blog' ),
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );

    //Top Level Menu (menu_item-parent-id=0)
    $people = wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'People' ),
      'menu-item-classes' => 'people',
      'menu-item-url' => '#',
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );

    //Submenu (menu_item-parent-id='people')
    wp_update_nav_menu_item( $menu_id, 0, [
      'menu-item-title' => __( 'Person Finder' ),
      'menu-item-classes' => 'people',
      'menu-item-url' => home_url( '/people' ),
      'menu-item-status' => 'publish',
      'menu-item-parent-id' => $people,
    ] );

    //Top Level Menu (menu_item-parent-id=0)
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Places' ),
      'menu-item-classes' => 'places',
      'menu-item-url' => home_url( '/places' ),
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );

    //Top Level Menu (menu_item-parent-id=0)
    wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Stories' ),
      'menu-item-classes' => 'stories',
      'menu-item-url' => home_url( '/stories' ),
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );

    //Top Level Menu (menu_item-parent-id=0)
    $materials = wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Materials' ),
      'menu-item-classes' => 'materials',
      'menu-item-url' => '#',
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );

    $submenu = [
      'Photos' => 'photos',
      'letters' => 'letters',
      'Articles' => 'articles',
      'Texts' => 'texts',
      'Audio Recordings' => 'audio-recordings',
      'Ephemera' => 'ephemera',
      'Objects' => 'objects',
    ];

    foreach ( $submenu as $k => $v ):
      wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title' => __( $k ),
        'menu-item-classes' => $v,
        'menu-item-url' => home_url( '/' . $v ),
        'menu-item-status' => 'publish',
        'menu-item-parent-id' => $materials,
      ] );
    endforeach;

    //Top Level Menu (menu_item-parent-id=0)
    $research = wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Research' ),
      'menu-item-classes' => 'research',
      'menu-item-url' => '#',
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );


    $submenu = [
      'Tasks' => 'tasks',
      'Bookmarks' => 'bookmarks',
      'Documents' => 'documents',
    ];

    foreach ( $submenu as $k => $v ):
      wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title' => __( $k ),
        'menu-item-classes' => $v,
        'menu-item-url' => home_url( '/' . $v ),
        'menu-item-status' => 'publish',
        'menu-item-parent-id' => $research,
      ] );
    endforeach;

    //Top Level Menu (menu_item-parent-id=0)
    $organization = wp_update_nav_menu_item( $menu_id, 0, array(
      'menu-item-title' => __( 'Organization' ),
      'menu-item-classes' => 'organization',
      'menu-item-url' => '#',
      'menu-item-parent-id' => 0,
      'menu-item-status' => 'publish' ) );


    $submenu = [
      'Locations' => 'locations',
      'Collections' => 'collections',
      'Photo Albums' => 'photo-albums',
    ];

    foreach ( $submenu as $k => $v ):
      wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title' => __( $k ),
        'menu-item-classes' => $v,
        'menu-item-url' => home_url( '/' . $v ),
        'menu-item-status' => 'publish',
        'menu-item-parent-id' => $organization,
      ] );
    endforeach;


    // Set Menu Locations

    $name = "Logged-in-menu";
    $menu = get_term_by( 'name', $name, 'nav_menu' );
    $menu_id = $menu->term_id;
    //then you set the wanted theme  location
    $locations = get_theme_mod( 'nav_menu_locations' );
    $locations[ 'logged-in' ] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    $name = "Logged-out-menu";
    $menu = get_term_by( 'name', $name, 'nav_menu' );
    $menu_id = $menu->term_id;

    //then you set the wanted theme  location
    $locations = get_theme_mod( 'nav_menu_locations' );
    $locations[ 'logged-out' ] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );


    // then update the menu_check option to make sure this code only runs once
    update_option( 'menu_check', 'yes' );
    endif;


    /*
      

    	
       */


    //Set Nav Menus
    /*
        
          $name = "Logged-in-menu";
        $menu = get_term_by( 'name', $name, 'nav_menu' );

        //then you set the wanted theme  location
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations[ 'logged-in' ] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        $name = "Logged-out-menu";
        $menu = get_term_by( 'name', $name, 'nav_menu' );


        //then you set the wanted theme  location
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations[ 'logged-out' ] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

       
    	  
    	  */


  }


}
// End Of Class.
endif;