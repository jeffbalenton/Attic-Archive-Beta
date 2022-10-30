<?php


if ( !class_exists( 'ThemeConfig' ) ):

  class ThemeConfig
implements SubscriberInterface {

  var $max_wxr_version = 1.2; // max. supported WXR version

  var $id; // WXR attachment ID

  // information to import from WXR file

  var $authors = array();
  var $posts = array();
  var $terms = array();
  var $categories = array();
  var $tags = array();
  var $base_url = '';

  // mappings from old information to new
  var $processed_authors = array();
  var $author_mapping = array();
  var $processed_terms = array();
  var $processed_posts = array();
  var $post_orphans = array();
  var $processed_menu_items = array();
  var $menu_item_orphans = array();
  var $missing_menu_items = array();

  var $fetch_attachments = false;
  var $url_remap = array();
  var $featured_images = array();

  var $settings = [];

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

      'acf/settings/url' => 'my_acf_settings_url',
      'acfe/settings/url' => 'my_acfe_settings_url',
      'wp_nav_menu_objects' => [ 'my_wp_nav_menu_objects', 10, 2 ],
      'acf/save_post' => 'contact_form_submission',
      'acf/save_post' => 'normalized_photo_date',
      'acf/save_post' => 'create_normalized_date',

      'wp_loaded' => 'load_starter_content',
      // '' => '',
      // '' => '',
      // '' => '',
      // '' => '',
      // '' => '',


    ];
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


  function contact_form_submission( $post_id ) {

    // bail early if not a contact_form post
    if ( get_post_type( $post_id ) !== 'contact_form' ) {

      return;

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


  function create_normalized_date( $post_id ) {


    // bail out if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ):
      return;
    endif;

    $post_type = get_post_type( $post_id );

    if ( $post_type == 'person' ):
      // Get newly saved values.
      $values = get_fields( $post_id );

    //Create Birth Date


    $bmonth = get_field( 'birth_month', $post_id );
    $bday = get_field( 'birth_day', $post_id );
    $byear = get_field( 'birth_year', $post_id );
    $birthplace = get_field( 'birth_place', $post_id );


   

    $date = date_create( "$byear-$bmonth-$bday" );
    $formal_bdate = date_format( $date, "M j, Y" );

    if ( $formal_bdate ):

      update_post_meta( $post_id, 'birthdate', $formal_bdate );

    //Save Built-in Birth Event
 if ( $birthplace ):
      foreach ( $birthplace as $post_ids ):
        $birth_place = get_the_title( $post_ids );
    $title = get_the_title( $post_id ) . " is born in " . $birth_place;
    endforeach;
    else :
      $title = get_the_title( $post_id ) . " is born";
    endif;

	  
	
	  
	  
	  	 $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
		 'tax_query' =>[
			 [
				 'taxonomy' => 'event_type',
				 'field' => 'slug',
				 'terms' => ['birth']
			 ]
		 ],
			 ];
	  	$found_events=get_posts($postarr);
				  
				 

    if ( $found_events ):
			 
		
				  foreach ($found_events as $event):
				  $event_id = $event->ID;
				  wp_trash_post($event_id);
				  endforeach;
				  
			 
      $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [
          'event_date' => $formal_bdate,
		  'event_city' =>$birthplace,
        ]
      ];
   $event_post= wp_insert_post( $postarr, true );
	wp_set_object_terms($event_post,'birth' ,'event_type',true);
	    //else remove/update old post
	   else:
		 
      $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [
          'event_date' => $formal_bdate,
		  'event_city' =>$birthplace,
        ]
      ];
   $event_post= wp_insert_post( $postarr, true );
	wp_set_object_terms($event_post,'birth' ,'event_type',true);
    endif;

    endif;


    //Create Death Date

    $dmonth = get_field( 'death_month', $post_id );
    $dday = get_field( 'death_day', $post_id );
    $dyear = get_field( 'death_year', $post_id );
    $deathplace = get_field( 'death_place', $post_id );

    $ddate = date_create( "$dyear-$dmonth-$dday" );
    $formal_ddate = date_format( $ddate, "M j, Y" );


    if ( $formal_ddate ):
      update_post_meta( $post_id, 'deathdate', $formal_ddate );
	  
	  
	      //Save Built-in Death Event
 if ( $deathplace ):
      foreach ( $deathplace as $post_ids ):
        $death_place = get_the_title( $post_ids );
    $title = get_the_title( $post_id ) . " dies in " . $death_place;
    endforeach;
    else :
      $title = get_the_title( $post_id ) . " dies";
    endif;
	  
	 
	  
	  	 $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
		 'tax_query' =>[
			 [
				 'taxonomy' => 'event_type',
				 'field' => 'slug',
				 'terms' => ['death']
			 ]
		 ],
			 ];
	  	$found_events=get_posts($postarr);
    
    if ( $found_events ):
	  
	    foreach ($found_events as $event):
				  $event_id = $event->ID;
				  wp_trash_post($event_id);
				  endforeach;
				  
	  
	  
      $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [
          'event_date' => $formal_bdate,
        ]
      ];
      $event_post= wp_insert_post( $postarr, true );
	  wp_set_object_terms($event_post,'death' ,'event_type',true);
	  //else remove/update old post
	  /* else:
	   $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [
          'event_date' => $formal_ddate,
        ]
      ];
	   $event_post= wp_update_post( $postarr, true );
	   
	  */
	  else:
	   $postarr = [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [
          'event_date' => $formal_bdate,
        ]
      ];
      $event_post= wp_insert_post( $postarr, true );
	  wp_set_object_terms($event_post,'death' ,'event_type',true);
	  
    endif;  

    endif;


    elseif ( $post_type == 'event' ):

      // Get newly saved values.
      $values = get_fields( $post_id );

    $eventmonth = get_field( 'event_month', $post_id );
    $eventday = get_field( 'event_day', $post_id );
    $eventyear = get_field( 'event_year', $post_id );

    $event_date = date_create( "$eventyear-$eventmonth-$eventday" );
    $formal_event_date = date_format( $event_date, "M j, Y" );


    if ( $formal_event_date ):
      update_post_meta( $post_id, 'event_date', $formal_event_date );
    endif;


    endif;


    //Create Birth Date


    //Create Birth Event if one does not already exist

    /*
	
	 $birth = get_term_by( 'slug', 'birth', 'event_type' );
    $title = get_the_title( $post_id ) . " is born";
    if ( !post_exists_by_title( $title, $post_id ) ):
      $about = wp_insert_post( [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [ 'event_type' => $birth->term_id, ]
      ] );

    endif;
	
	   $death = get_term_by( 'slug', 'death', 'event_type' );
    $title = get_the_title( $post_id ) . " died";
    if ( !post_exists_by_title( $title, $post_id ) ):
      $about = wp_insert_post( [
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'event',
        'post_parent' => $post_id,
        'meta_input' => [ 'event_type' => $birth->term_id, ]
      ] );
	endif;
    	  // Cheks if doen't exists a post with slug "wordpress-post-created-with-code".
    	  
    	  
      if ( !post_exists_by_title( $post_title, $post_id ) ):
        $about = wp_insert_post( [
          'comment_status' => 'closed',
          'ping_status' => 'closed',
          'post_title' => $title,
          'post_status' => 'publish',
          'post_type' => 'event',
    	  'post_parent'=>$post_id,
        ] );

      endif;
      
      
    	  
          $name= get_field('person_name', $post_id);
    	  $event_title=$name . "is born";
    	  $event_type = 'birth'; // Can use array of ids or string of tax names separated 
    	  $postarr = [
    		  'post_type' => 'event',
    		  'post_title' => $event_title,
    		  'tax_imput' => ['non_hierarchical_tax'=>$event_type],
    		   
    	  ];
    	  
    	  $found_post=post_exists($event_title,'','','');
    	  if (!found_post):
          save($postarr);
    	  endif;
    	  
    	  */

  }


  function normalized_photo_date( $post_id ) {
    // Get newly saved values.
    $values = get_fields( $post_id );
    // Check the new value of a specific field.
    $year = get_field( 'year_taken', $post_id );
    $month = get_field( 'month_taken', $post_id );
    $day = get_field( 'day_taken', $post_id );

    $database_date = "$month $day $year";

    if ( $database_date ):
      update_post_meta( $post_id, 'date_taken', $database_date );
    endif;
  }

  /**
   * The main controller for the actual import stage.
   *
   * @param string $file Path to the WXR file for importing
   */
  public function load_starter_content() {

 
    /*    
   $import_check = get_option( 'import-check' );
    if ( $import_check != 'done' ):

      $file = get_template_directory() . '/inc/starter-content/starter-content.xml';

    add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );

  $this->process_upload( $file );
   $this->get_author_mapping();
    $this->create_content();
    $this->import_end();
    update_option( 'import-check', 'done' );
    endif;
	  
 $import_check = get_option( 'import-check' );
    if ( $import_check != 'done' ):

      $file = get_template_directory() . '/inc/starter-content/starter-content.xml';

    add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );

    $this->process_upload( $file );
    $this->get_author_mapping();
    $this->create_content();
    $this->import_end();
    update_option( 'import-check', 'done' );
    endif;
    $db_version = get_option( 'archive_db' );
          if ( $this->settings[ 'db_version' ] != $db_version ):
            $place_resource = ARCHIVE_PLUGIN_PATH . '/starter-content/place-resource/us.csv';
          import_place_resource( $place_resource );
          //create_pages();
          update_option( 'archive_db', $this->settings[ 'db_version' ] );
          endif;

   $menu_check = get_option( 'menu_check' );
    if ( !$menu_check ):
      $name = "Logged-in-menu";
    $menu = get_term_by( 'name', $name, 'nav_menu' );

    //then you set the wanted theme  location
    $locations = get_theme_mod( 'nav_menu_locations' );
    $locations[ 'logged-in' ] = $menu->term_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    $name = "Logged-out-menu";
    $menu = get_term_by( 'name', $name, 'nav_menu' );


    //then you set the wanted theme  location
    $locations = get_theme_mod( 'nav_menu_locations' );
    $locations[ 'logged-out' ] = $menu->term_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    // then update the menu_check option to make sure this code only runs once
    update_option( 'menu_check', true );
    endif;
    */

    //Set Home Page and Blog Page
    $set_default_pages = get_option( 'set_default_pages' );
    if ( $set_default_pages != 'yes' ):


      //Set options for Front Page and Blog Page

      // Use a static front page
      $home = get_page_by_title( 'Home' );
    update_option( 'page_on_front', $home->ID );
    update_option( 'show_on_front', 'page' );

    // Set the blog page
    $blog = get_page_by_title( 'Blog' );
    update_option( 'page_for_posts', $blog->ID );

    update_option( 'set_default_pages', 'yes' );
    endif;

    //Set Nav Menus

 
  }

  /**
   * Parses the WXR file and prepares us for the task of processing parsed data
   *
   * @param string $file Path to the WXR file for importing
   */
  function process_upload( $file ) {
    if ( !is_file( $file ) ) {
      echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
      echo __( 'The file does not exist, please try again.', 'wordpress-importer' ) . '</p>';

      die();
    }

    $import_data = $this->parse( $file );

    if ( is_wp_error( $import_data ) ) {
      echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
      echo esc_html( $import_data->get_error_message() ) . '</p>';

      die();
    }

    $this->version = $import_data[ 'version' ];
    $this->get_authors_from_import( $import_data );
    $this->posts = $import_data[ 'posts' ];
    $this->terms = $import_data[ 'terms' ];
    $this->categories = $import_data[ 'categories' ];
    $this->tags = $import_data[ 'tags' ];
    $this->base_url = esc_url( $import_data[ 'base_url' ] );

    wp_defer_term_counting( true );
    wp_defer_comment_counting( true );


  }

  function create_content() {
    wp_suspend_cache_invalidation( true );
    $this->process_categories();
    $this->process_tags();
    $this->process_terms();
    $this->process_posts();
    wp_suspend_cache_invalidation( false );

    // update incorrect/missing information in the DB
    $this->backfill_parents();
    $this->backfill_attachment_urls();
    $this->remap_featured_images();
  }
  /**
   * Retrieve authors from parsed WXR data
   *
   * Uses the provided author information from WXR 1.1 files
   * or extracts info from each post for WXR 1.0 files
   *
   * @param array $import_data Data returned by a WXR parser
   */
  function get_authors_from_import( $import_data ) {
    if ( !empty( $import_data[ 'authors' ] ) ) {
      $this->authors = $import_data[ 'authors' ];
      // no author information, grab it from the posts
    } else {
      foreach ( $import_data[ 'posts' ] as $post ) {
        $login = sanitize_user( $post[ 'post_author' ], true );
        if ( empty( $login ) ) {
          printf( __( 'Failed to import author %s. Their posts will be attributed to the current user.', 'wordpress-importer' ), esc_html( $post[ 'post_author' ] ) );
          echo '<br />';
          continue;
        }

        if ( !isset( $this->authors[ $login ] ) )
          $this->authors[ $login ] = array(
            'author_login' => $login,
            'author_display_name' => $post[ 'post_author' ]
          );
      }
    }
  }

  /**
   * Map old author logins to local user IDs based on decisions made
   * in import options form. Can map to an existing user, create a new user
   * or falls back to the current user in case of error with either of the previous
   */
  function get_author_mapping() {


    if ( !isset( $this->authors ) )
      return;

    $user = get_user_by( 'display_name', 'Admin' );
    if ( !$user ):
      $userdata = [
        'ID' => 0, //(int) User ID. If supplied, the user will be updated.
        'user_pass' => 'archiveuser2022', //(string) The plain-text user password.
        'user_login' => 'webmaster@exammple2.com', //(string) The user's login username.
        'user_nicename' => '', //(string) The URL-friendly user name.
        'user_url' => '', //(string) The user URL.
        'user_email' => 'webmaster@exammple2.com', //(string) The user email address.
        'display_name' => 'Admin', //(string) The user's display name. Default is the user's username.
        'nickname' => '', //(string) The user's nickname. Default is the user's username.
        'first_name' => 'Admin', //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
        'last_name' => 'User', //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
        'description' => '', //(string) The user's biographical description.
        'rich_editing' => '', //(string|bool) Whether to enable the rich-editor for the user. False if not empty.
        'syntax_highlighting' => '', //(string|bool) Whether to enable the rich code editor for the user. False if not empty.
        'comment_shortcuts' => '', //(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
        'admin_color' => '', //(string) Admin color scheme for the user. Default 'fresh'.
        'use_ssl' => '', //(bool) Whether the user should always access the admin over https. Default false.
        'user_registered' => '', //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
        'show_admin_bar_front' => '', //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
        'role' => 'administrator', //(string) User's role.
        'locale' => '', //(string) User's locale. Default empty.
      ];

    $user = wp_insert_user( $userdata );

    endif;


    foreach ( ( array )$this->authors as $author ) {

      // Multisite adds strtolower to sanitize_user. Need to sanitize here to stop breakage in process_posts.
      $santized_old_login = sanitize_user( $old_login, true );
      $old_id = isset( $this->authors[ $old_login ][ 'author_id' ] ) ? intval( $this->authors[ $old_login ][ 'author_id' ] ) : false;

      // failsafe: if the user_id was invalid, default to the current user
      if ( !isset( $this->author_mapping[ $santized_old_login ] ) ) {
        if ( $old_id )
          $this->processed_authors[ $old_id ] = ( int )get_user_by( 'display_name', 'Admin' );
        $this->author_mapping[ $santized_old_login ] = ( int )get_user_by( 'display_name', 'Admin' );
      }
    }
  }


  /**
   * Create new categories based on import information
   *
   * Doesn't create a new category if its slug already exists
   */
  function process_categories() {
    $this->categories = apply_filters( 'wp_import_categories', $this->categories );

    if ( empty( $this->categories ) )
      return;

    foreach ( $this->categories as $cat ) {
      // if the category already exists leave it alone
      $term_id = term_exists( $cat[ 'category_nicename' ], 'category' );
      if ( $term_id ) {
        if ( is_array( $term_id ) )$term_id = $term_id[ 'term_id' ];
        if ( isset( $cat[ 'term_id' ] ) )
          $this->processed_terms[ intval( $cat[ 'term_id' ] ) ] = ( int )$term_id;
        continue;
      }

      $parent = empty( $cat[ 'category_parent' ] ) ? 0 : category_exists( $cat[ 'category_parent' ] );
      $description = isset( $cat[ 'category_description' ] ) ? $cat[ 'category_description' ] : '';

      $data = array(
        'category_nicename' => $cat[ 'category_nicename' ],
        'category_parent' => $parent,
        'cat_name' => wp_slash( $cat[ 'cat_name' ] ),
        'category_description' => wp_slash( $description ),
      );

      $id = archive_insert_category( $data );
      if ( !is_wp_error( $id ) && $id > 0 ) {
        if ( isset( $cat[ 'term_id' ] ) )
          $this->processed_terms[ intval( $cat[ 'term_id' ] ) ] = $id;
      } else {
        printf( __( 'Failed to import category %s', 'wordpress-importer' ), esc_html( $cat[ 'category_nicename' ] ) );
        if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG )
          echo ': ' . $id->get_error_message();
        echo '<br />';
        continue;
      }

      $this->process_termmeta( $cat, $id );
    }

    unset( $this->categories );
  }

  /**
   * Create new post tags based on import information
   *
   * Doesn't create a tag if its slug already exists
   */
  function process_tags() {
    $this->tags = apply_filters( 'wp_import_tags', $this->tags );

    if ( empty( $this->tags ) )
      return;

    foreach ( $this->tags as $tag ) {
      // if the tag already exists leave it alone
      $term_id = term_exists( $tag[ 'tag_slug' ], 'post_tag' );
      if ( $term_id ) {
        if ( is_array( $term_id ) )$term_id = $term_id[ 'term_id' ];
        if ( isset( $tag[ 'term_id' ] ) )
          $this->processed_terms[ intval( $tag[ 'term_id' ] ) ] = ( int )$term_id;
        continue;
      }

      $description = isset( $tag[ 'tag_description' ] ) ? $tag[ 'tag_description' ] : '';
      $args = array(
        'slug' => $tag[ 'tag_slug' ],
        'description' => wp_slash( $description ),
      );

      $id = wp_insert_term( wp_slash( $tag[ 'tag_name' ] ), 'post_tag', $args );
      if ( !is_wp_error( $id ) ) {
        if ( isset( $tag[ 'term_id' ] ) )
          $this->processed_terms[ intval( $tag[ 'term_id' ] ) ] = $id[ 'term_id' ];
      } else {
        printf( __( 'Failed to import post tag %s', 'wordpress-importer' ), esc_html( $tag[ 'tag_name' ] ) );
        if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG )
          echo ': ' . $id->get_error_message();
        echo '<br />';
        continue;
      }

      $this->process_termmeta( $tag, $id[ 'term_id' ] );
    }

    unset( $this->tags );
  }

  /**
   * Create new terms based on import information
   *
   * Doesn't create a term its slug already exists
   */
  function process_terms() {
    $this->terms = apply_filters( 'wp_import_terms', $this->terms );

    if ( empty( $this->terms ) )
      return;

    foreach ( $this->terms as $term ) {
      // if the term already exists in the correct taxonomy leave it alone
      $term_id = term_exists( $term[ 'slug' ], $term[ 'term_taxonomy' ] );
      if ( $term_id ) {
        if ( is_array( $term_id ) )$term_id = $term_id[ 'term_id' ];
        if ( isset( $term[ 'term_id' ] ) )
          $this->processed_terms[ intval( $term[ 'term_id' ] ) ] = ( int )$term_id;
        continue;
      }

      if ( empty( $term[ 'term_parent' ] ) ) {
        $parent = 0;
      } else {
        $parent = term_exists( $term[ 'term_parent' ], $term[ 'term_taxonomy' ] );
        if ( is_array( $parent ) ) {
          $parent = $parent[ 'term_id' ];
        }
      }

      $description = isset( $term[ 'term_description' ] ) ? $term[ 'term_description' ] : '';
      $args = array(
        'slug' => $term[ 'slug' ],
        'description' => wp_slash( $description ),
        'parent' => ( int )$parent
      );

      $id = wp_insert_term( wp_slash( $term[ 'term_name' ] ), $term[ 'term_taxonomy' ], $args );
      if ( !is_wp_error( $id ) ) {
        if ( isset( $term[ 'term_id' ] ) )
          $this->processed_terms[ intval( $term[ 'term_id' ] ) ] = $id[ 'term_id' ];
      } else {
        printf( __( 'Failed to import %s %s', 'wordpress-importer' ), esc_html( $term[ 'term_taxonomy' ] ), esc_html( $term[ 'term_name' ] ) );
        if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG )
          echo ': ' . $id->get_error_message();
        echo '<br />';
        continue;
      }

      $this->process_termmeta( $term, $id[ 'term_id' ] );
    }

    unset( $this->terms );
  }

  /**
   * Add metadata to imported term.
   *
   * @since 0.6.2
   *
   * @param array $term    Term data from WXR import.
   * @param int   $term_id ID of the newly created term.
   */
  protected function process_termmeta( $term, $term_id ) {
    if ( !function_exists( 'add_term_meta' ) ) {
      return;
    }

    if ( !isset( $term[ 'termmeta' ] ) ) {
      $term[ 'termmeta' ] = array();
    }

    /**
     * Filters the metadata attached to an imported term.
     *
     * @since 0.6.2
     *
     * @param array $termmeta Array of term meta.
     * @param int   $term_id  ID of the newly created term.
     * @param array $term     Term data from the WXR import.
     */
    $term[ 'termmeta' ] = apply_filters( 'wp_import_term_meta', $term[ 'termmeta' ], $term_id, $term );

    if ( empty( $term[ 'termmeta' ] ) ) {
      return;
    }

    foreach ( $term[ 'termmeta' ] as $meta ) {
      /**
       * Filters the meta key for an imported piece of term meta.
       *
       * @since 0.6.2
       *
       * @param string $meta_key Meta key.
       * @param int    $term_id  ID of the newly created term.
       * @param array  $term     Term data from the WXR import.
       */
      $key = apply_filters( 'import_term_meta_key', $meta[ 'key' ], $term_id, $term );
      if ( !$key ) {
        continue;
      }

      // Export gets meta straight from the DB so could have a serialized string
      $value = maybe_unserialize( $meta[ 'value' ] );

      add_term_meta( $term_id, wp_slash( $key ), wp_slash_strings_only( $value ) );

      /**
       * Fires after term meta is imported.
       *
       * @since 0.6.2
       *
       * @param int    $term_id ID of the newly created term.
       * @param string $key     Meta key.
       * @param mixed  $value   Meta value.
       */
      do_action( 'import_term_meta', $term_id, $key, $value );
    }
  }

  /**
   * Create new posts based on import information
   *
   * Posts marked as having a parent which doesn't exist will become top level items.
   * Doesn't create a new post if: the post type doesn't exist, the given post ID
   * is already noted as imported or a post with the same title and date already exists.
   * Note that new/updated terms, comments and meta are imported for the last of the above.
   */
  function process_posts() {
    $this->posts = apply_filters( 'wp_import_posts', $this->posts );

    foreach ( $this->posts as $post ) {
      $post = apply_filters( 'wp_import_post_data_raw', $post );

      if ( !post_type_exists( $post[ 'post_type' ] ) ) {
        printf( __( 'Failed to import &#8220;%s&#8221;: Invalid post type %s', 'wordpress-importer' ),
          esc_html( $post[ 'post_title' ] ), esc_html( $post[ 'post_type' ] ) );
        echo '<br />';
        do_action( 'wp_import_post_exists', $post );
        continue;
      }

      if ( isset( $this->processed_posts[ $post[ 'post_id' ] ] ) && !empty( $post[ 'post_id' ] ) )
        continue;

      if ( $post[ 'status' ] == 'auto-draft' )
        continue;

      if ( 'nav_menu_item' == $post[ 'post_type' ] ) {
        $this->process_menu_item( $post );
        continue;
      }

      $post_type_object = get_post_type_object( $post[ 'post_type' ] );

      $post_exists = archive_post_exists( $post[ 'post_title' ], '', $post[ 'post_date' ] );

      /**
       * Filter ID of the existing post corresponding to post currently importing.
       *
       * Return 0 to force the post to be imported. Filter the ID to be something else
       * to override which existing post is mapped to the imported post.
       *
       * @see post_exists()
       * @since 0.6.2
       *
       * @param int   $post_exists  Post ID, or 0 if post did not exist.
       * @param array $post         The post array to be inserted.
       */
      $post_exists = apply_filters( 'wp_import_existing_post', $post_exists, $post );

      if ( $post_exists && get_post_type( $post_exists ) == $post[ 'post_type' ] ) {
       /*
		  printf( __( '%s &#8220;%s&#8221; already exists.', 'wordpress-importer' ), $post_type_object->labels->singular_name, esc_html( $post[ 'post_title' ] ) );
        echo '<br />';
        $comment_post_ID = $post_id = $post_exists;
        $this->processed_posts[ intval( $post[ 'post_id' ] ) ] = intval( $post_exists ); */
      } else {
        $post_parent = ( int )$post[ 'post_parent' ];
        if ( $post_parent ) {
          // if we already know the parent, map it to the new local ID
          if ( isset( $this->processed_posts[ $post_parent ] ) ) {
            $post_parent = $this->processed_posts[ $post_parent ];
            // otherwise record the parent for later
          } else {
            $this->post_orphans[ intval( $post[ 'post_id' ] ) ] = $post_parent;
            $post_parent = 0;
          }
        }

        // map the post author
        $author = sanitize_user( $post[ 'post_author' ], true );
        if ( isset( $this->author_mapping[ $author ] ) )
          $author = $this->author_mapping[ $author ];
        else
          $author = ( int )get_current_user_id();

        $postdata = array(
          'import_id' => $post[ 'post_id' ], 'post_author' => $author, 'post_date' => $post[ 'post_date' ],
          'post_date_gmt' => $post[ 'post_date_gmt' ], 'post_content' => $post[ 'post_content' ],
          'post_excerpt' => $post[ 'post_excerpt' ], 'post_title' => $post[ 'post_title' ],
          'post_status' => $post[ 'status' ], 'post_name' => $post[ 'post_name' ],
          'comment_status' => $post[ 'comment_status' ], 'ping_status' => $post[ 'ping_status' ],
          'guid' => $post[ 'guid' ], 'post_parent' => $post_parent, 'menu_order' => $post[ 'menu_order' ],
          'post_type' => $post[ 'post_type' ], 'post_password' => $post[ 'post_password' ]
        );

        $original_post_ID = $post[ 'post_id' ];
        $postdata = apply_filters( 'wp_import_post_data_processed', $postdata, $post );

        $postdata = wp_slash( $postdata );

        if ( 'attachment' == $postdata[ 'post_type' ] ) {
          $remote_url = !empty( $post[ 'attachment_url' ] ) ? $post[ 'attachment_url' ] : $post[ 'guid' ];

          // try to use _wp_attached file for upload folder placement to ensure the same location as the export site
          // e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
          $postdata[ 'upload_date' ] = $post[ 'post_date' ];
          if ( isset( $post[ 'postmeta' ] ) ) {
            foreach ( $post[ 'postmeta' ] as $meta ) {
              if ( $meta[ 'key' ] == '_wp_attached_file' ) {
                if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta[ 'value' ], $matches ) )
                  $postdata[ 'upload_date' ] = $matches[ 0 ];
                break;
              }
            }
          }

          $comment_post_ID = $post_id = wp_insert_post( $postdata, true );
          do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
        } else {
          $comment_post_ID = $post_id = wp_insert_post( $postdata, true );
          do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
        }

        if ( is_wp_error( $post_id ) ) {
          printf( __( 'Failed to import %s &#8220;%s&#8221;', 'wordpress-importer' ),
            $post_type_object->labels->singular_name, esc_html( $post[ 'post_title' ] ) );
          if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG )
            echo ': ' . $post_id->get_error_message();
          echo '<br />';
          continue;
        }

        if ( $post[ 'is_sticky' ] == 1 )
          stick_post( $post_id );
      }

      // map pre-import ID to local ID
      $this->processed_posts[ intval( $post[ 'post_id' ] ) ] = ( int )$post_id;

      if ( !isset( $post[ 'terms' ] ) )
        $post[ 'terms' ] = array();

      $post[ 'terms' ] = apply_filters( 'wp_import_post_terms', $post[ 'terms' ], $post_id, $post );

      // add categories, tags and other terms
      if ( !empty( $post[ 'terms' ] ) ) {
        $terms_to_set = array();
        foreach ( $post[ 'terms' ] as $term ) {
          // back compat with WXR 1.0 map 'tag' to 'post_tag'
          $taxonomy = ( 'tag' == $term[ 'domain' ] ) ? 'post_tag' : $term[ 'domain' ];
          $term_exists = term_exists( $term[ 'slug' ], $taxonomy );
          $term_id = is_array( $term_exists ) ? $term_exists[ 'term_id' ] : $term_exists;
          if ( !$term_id ) {
            $t = wp_insert_term( $term[ 'name' ], $taxonomy, array( 'slug' => $term[ 'slug' ] ) );
            if ( !is_wp_error( $t ) ) {
              $term_id = $t[ 'term_id' ];
              do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
            } else {
              printf( __( 'Failed to import %s %s', 'wordpress-importer' ), esc_html( $taxonomy ), esc_html( $term[ 'name' ] ) );
              if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG )
                echo ': ' . $t->get_error_message();
              echo '<br />';
              do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
              continue;
            }
          }
          $terms_to_set[ $taxonomy ][] = intval( $term_id );
        }

        foreach ( $terms_to_set as $tax => $ids ) {
          $tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
          do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
        }
        unset( $post[ 'terms' ], $terms_to_set );
      }

      if ( !isset( $post[ 'comments' ] ) )
        $post[ 'comments' ] = array();

      $post[ 'comments' ] = apply_filters( 'wp_import_post_comments', $post[ 'comments' ], $post_id, $post );

      // add/update comments
      if ( !empty( $post[ 'comments' ] ) ) {
        $num_comments = 0;
        $inserted_comments = array();
        foreach ( $post[ 'comments' ] as $comment ) {
          $comment_id = $comment[ 'comment_id' ];
          $newcomments[ $comment_id ][ 'comment_post_ID' ] = $comment_post_ID;
          $newcomments[ $comment_id ][ 'comment_author' ] = $comment[ 'comment_author' ];
          $newcomments[ $comment_id ][ 'comment_author_email' ] = $comment[ 'comment_author_email' ];
          $newcomments[ $comment_id ][ 'comment_author_IP' ] = $comment[ 'comment_author_IP' ];
          $newcomments[ $comment_id ][ 'comment_author_url' ] = $comment[ 'comment_author_url' ];
          $newcomments[ $comment_id ][ 'comment_date' ] = $comment[ 'comment_date' ];
          $newcomments[ $comment_id ][ 'comment_date_gmt' ] = $comment[ 'comment_date_gmt' ];
          $newcomments[ $comment_id ][ 'comment_content' ] = $comment[ 'comment_content' ];
          $newcomments[ $comment_id ][ 'comment_approved' ] = $comment[ 'comment_approved' ];
          $newcomments[ $comment_id ][ 'comment_type' ] = $comment[ 'comment_type' ];
          $newcomments[ $comment_id ][ 'comment_parent' ] = $comment[ 'comment_parent' ];
          $newcomments[ $comment_id ][ 'commentmeta' ] = isset( $comment[ 'commentmeta' ] ) ? $comment[ 'commentmeta' ] : array();
          if ( isset( $this->processed_authors[ $comment[ 'comment_user_id' ] ] ) )
            $newcomments[ $comment_id ][ 'user_id' ] = $this->processed_authors[ $comment[ 'comment_user_id' ] ];
        }
        ksort( $newcomments );

        foreach ( $newcomments as $key => $comment ) {
          // if this is a new post we can skip the comment_exists() check
          if ( !$post_exists || !comment_exists( $comment[ 'comment_author' ], $comment[ 'comment_date' ] ) ) {
            if ( isset( $inserted_comments[ $comment[ 'comment_parent' ] ] ) ) {
              $comment[ 'comment_parent' ] = $inserted_comments[ $comment[ 'comment_parent' ] ];
            }

            $comment_data = wp_slash( $comment );
            unset( $comment_data[ 'commentmeta' ] ); // Handled separately, wp_insert_comment() also expects `comment_meta`.
            $comment_data = wp_filter_comment( $comment_data );

            $inserted_comments[ $key ] = wp_insert_comment( $comment_data );

            do_action( 'wp_import_insert_comment', $inserted_comments[ $key ], $comment, $comment_post_ID, $post );

            foreach ( $comment[ 'commentmeta' ] as $meta ) {
              $value = maybe_unserialize( $meta[ 'value' ] );

              add_comment_meta( $inserted_comments[ $key ], wp_slash( $meta[ 'key' ] ), wp_slash_strings_only( $value ) );
            }

            $num_comments++;
          }
        }
        unset( $newcomments, $inserted_comments, $post[ 'comments' ] );
      }

      if ( !isset( $post[ 'postmeta' ] ) )
        $post[ 'postmeta' ] = array();

      $post[ 'postmeta' ] = apply_filters( 'wp_import_post_meta', $post[ 'postmeta' ], $post_id, $post );

      // add/update post meta
      if ( !empty( $post[ 'postmeta' ] ) ) {
        foreach ( $post[ 'postmeta' ] as $meta ) {
          $key = apply_filters( 'import_post_meta_key', $meta[ 'key' ], $post_id, $post );
          $value = false;

          if ( '_edit_last' == $key ) {
            if ( isset( $this->processed_authors[ intval( $meta[ 'value' ] ) ] ) )
              $value = $this->processed_authors[ intval( $meta[ 'value' ] ) ];
            else
              $key = false;
          }

          if ( $key ) {
            // export gets meta straight from the DB so could have a serialized string
            if ( !$value ) {
              $value = maybe_unserialize( $meta[ 'value' ] );
            }

            add_post_meta( $post_id, wp_slash( $key ), wp_slash_strings_only( $value ) );

            do_action( 'import_post_meta', $post_id, $key, $value );

            // if the post has a featured image, take note of this in case of remap
            if ( '_thumbnail_id' == $key )
              $this->featured_images[ $post_id ] = ( int )$value;
          }
        }
      }
    }

    unset( $this->posts );
  }

  /**
   * Attempt to create a new menu item from import data
   *
   * Fails for draft, orphaned menu items and those without an associated nav_menu
   * or an invalid nav_menu term. If the post type or term object which the menu item
   * represents doesn't exist then the menu item will not be imported (waits until the
   * end of the import to retry again before discarding).
   *
   * @param array $item Menu item details from WXR file
   */
  function process_menu_item( $item ) {
    // skip draft, orphaned menu items
    if ( 'draft' == $item[ 'status' ] )
      return;

    $menu_slug = false;
    if ( isset( $item[ 'terms' ] ) ) {
      // loop through terms, assume first nav_menu term is correct menu
      foreach ( $item[ 'terms' ] as $term ) {
        if ( 'nav_menu' == $term[ 'domain' ] ) {
          $menu_slug = $term[ 'slug' ];
          break;
        }
      }
    }

    // no nav_menu term associated with this menu item
    if ( !$menu_slug ) {
      _e( 'Menu item skipped due to missing menu slug', 'wordpress-importer' );
      echo '<br />';
      return;
    }

    $menu_id = term_exists( $menu_slug, 'nav_menu' );
    if ( !$menu_id ) {
      printf( __( 'Menu item skipped due to invalid menu slug: %s', 'wordpress-importer' ), esc_html( $menu_slug ) );
      echo '<br />';
      return;
    } else {
      $menu_id = is_array( $menu_id ) ? $menu_id[ 'term_id' ] : $menu_id;
    }

    foreach ( $item[ 'postmeta' ] as $meta )
      $ {
        $meta[ 'key' ]
      } = $meta[ 'value' ];

    if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[ intval( $_menu_item_object_id ) ] ) ) {
      $_menu_item_object_id = $this->processed_terms[ intval( $_menu_item_object_id ) ];
    } else if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[ intval( $_menu_item_object_id ) ] ) ) {
      $_menu_item_object_id = $this->processed_posts[ intval( $_menu_item_object_id ) ];
    } else if ( 'custom' != $_menu_item_type ) {
      // associated object is missing or not imported yet, we'll retry later
      $this->missing_menu_items[] = $item;
      return;
    }

    if ( isset( $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ] ) ) {
      $_menu_item_menu_item_parent = $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ];
    } else if ( $_menu_item_menu_item_parent ) {
      $this->menu_item_orphans[ intval( $item[ 'post_id' ] ) ] = ( int )$_menu_item_menu_item_parent;
      $_menu_item_menu_item_parent = 0;
    }

    // wp_update_nav_menu_item expects CSS classes as a space separated string
    $_menu_item_classes = maybe_unserialize( $_menu_item_classes );
    if ( is_array( $_menu_item_classes ) )
      $_menu_item_classes = implode( ' ', $_menu_item_classes );

    $args = array(
      'menu-item-object-id' => $_menu_item_object_id,
      'menu-item-object' => $_menu_item_object,
      'menu-item-parent-id' => $_menu_item_menu_item_parent,
      'menu-item-position' => intval( $item[ 'menu_order' ] ),
      'menu-item-type' => $_menu_item_type,
      'menu-item-title' => $item[ 'post_title' ],
      'menu-item-url' => $_menu_item_url,
      'menu-item-description' => $item[ 'post_content' ],
      'menu-item-attr-title' => $item[ 'post_excerpt' ],
      'menu-item-target' => $_menu_item_target,
      'menu-item-classes' => $_menu_item_classes,
      'menu-item-xfn' => $_menu_item_xfn,
      'menu-item-status' => $item[ 'status' ]
    );

    $id = wp_update_nav_menu_item( $menu_id, 0, $args );
    if ( $id && !is_wp_error( $id ) )
      $this->processed_menu_items[ intval( $item[ 'post_id' ] ) ] = ( int )$id;
  }

  /**
   * Attempt to associate posts and menu items with previously missing parents
   *
   * An imported post's parent may not have been imported when it was first created
   * so try again. Similarly for child menu items and menu items which were missing
   * the object (e.g. post) they represent in the menu
   */
  function backfill_parents() {
    global $wpdb;

    // find parents for post orphans
    foreach ( $this->post_orphans as $child_id => $parent_id ) {
      $local_child_id = $local_parent_id = false;
      if ( isset( $this->processed_posts[ $child_id ] ) )
        $local_child_id = $this->processed_posts[ $child_id ];
      if ( isset( $this->processed_posts[ $parent_id ] ) )
        $local_parent_id = $this->processed_posts[ $parent_id ];

      if ( $local_child_id && $local_parent_id ) {
        $wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
        clean_post_cache( $local_child_id );
      }
    }

    // all other posts/terms are imported, retry menu items with missing associated object
    $missing_menu_items = $this->missing_menu_items;
    foreach ( $missing_menu_items as $item )
      $this->process_menu_item( $item );

    // find parents for menu item orphans
    foreach ( $this->menu_item_orphans as $child_id => $parent_id ) {
      $local_child_id = $local_parent_id = 0;
      if ( isset( $this->processed_menu_items[ $child_id ] ) )
        $local_child_id = $this->processed_menu_items[ $child_id ];
      if ( isset( $this->processed_menu_items[ $parent_id ] ) )
        $local_parent_id = $this->processed_menu_items[ $parent_id ];

      if ( $local_child_id && $local_parent_id )
        update_post_meta( $local_child_id, '_menu_item_menu_item_parent', ( int )$local_parent_id );
    }
  }

  /**
   * Use stored mapping information to update old attachment URLs
   */
  function backfill_attachment_urls() {
    global $wpdb;
    // make sure we do the longest urls first, in case one is a substring of another
    uksort( $this->url_remap, array( & $this, 'cmpr_strlen' ) );

    foreach ( $this->url_remap as $from_url => $to_url ) {
      // remap urls in post_content
      $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url ) );
      // remap enclosure urls
      $result = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url ) );
    }
  }

  /**
   * Update _thumbnail_id meta to new, imported attachment IDs
   */
  function remap_featured_images() {
    // cycle through posts that have a featured image
    foreach ( $this->featured_images as $post_id => $value ) {
      if ( isset( $this->processed_posts[ $value ] ) ) {
        $new_id = $this->processed_posts[ $value ];
        // only update if there's a difference
        if ( $new_id != $value )
          update_post_meta( $post_id, '_thumbnail_id', $new_id );
      }
    }
  }


  /**
   * Parse a WXR file
   *
   * @param string $file Path to WXR file for parsing
   * @return array Information gathered from the WXR file
   */
  function parse( $file ) {
    // Attempt to use proper XML parsers first
    if ( extension_loaded( 'simplexml' ) ) {
      $parser = new WXR_Parser_SimpleXML;
      $result = $parser->parse( $file );

      // If SimpleXML succeeds or this is an invalid WXR file then return the results
      if ( !is_wp_error( $result ) || 'SimpleXML_parse_error' != $result->get_error_code() )
        return $result;
    } else if ( extension_loaded( 'xml' ) ) {
      $parser = new WXR_Parser_XML;
      $result = $parser->parse( $file );

      // If XMLParser succeeds or this is an invalid WXR file then return the results
      if ( !is_wp_error( $result ) || 'XML_parse_error' != $result->get_error_code() )
        return $result;
    }

    // We have a malformed XML file, so display the error and fallthrough to regex
    if ( isset( $result ) && defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG ) {
      echo '<pre>';
      if ( 'SimpleXML_parse_error' == $result->get_error_code() ) {
        foreach ( $result->get_error_data() as $error )
          echo $error->line . ':' . $error->column . ' ' . esc_html( $error->message ) . "\n";
      } else if ( 'XML_parse_error' == $result->get_error_code() ) {
        $error = $result->get_error_data();
        echo $error[ 0 ] . ':' . $error[ 1 ] . ' ' . esc_html( $error[ 2 ] );
      }
      echo '</pre>';
      echo '<p><strong>' . __( 'There was an error when reading this WXR file', 'wordpress-importer' ) . '</strong><br />';
      echo __( 'Details are shown above. The importer will now try again with a different parser...', 'wordpress-importer' ) . '</p>';
    }

    // use regular expressions if nothing else available or this is bad XML
    $parser = new WXR_Parser_Regex;
    return $parser->parse( $file );
  }
  /**
   * Decide if the given meta key maps to information we will want to import
   *
   * @param string $key The meta key to check
   * @return string|bool The key if we do want to import, false if not
   */
  function is_valid_meta_key( $key ) {
    // skip attachment metadata since we'll regenerate it from scratch
    // skip _edit_lock as not relevant for import
    if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) )
      return false;
    return $key;
  }

 

  /**
   * Added to http_request_timeout filter to force timeout at 60 seconds during import
   * @return int 60
   */
  function bump_request_timeout( $val ) {
    return 60;
  }

  function import_end() {
   // wp_import_cleanup( $this->id );

    wp_cache_flush();
    foreach ( get_taxonomies() as $tax ) {
      delete_option( "{$tax}_children" );
      _get_term_hierarchy( $tax );
    }

    wp_defer_term_counting( false );
    wp_defer_comment_counting( false );

    $url = admin_url( 'index.php' );

    wp_safe_redirect( $url );
    exit;
    /*
          echo '<p>' . __( 'All done.', 'wordpress-importer' ) . ' <a href="' . admin_url() . '">' . __( 'Have fun!', 'wordpress-importer' ) . '</a>' . '</p>';
          echo '<p>' . __( 'Remember to update the passwords and roles of imported users.', 'wordpress-importer' ) . '</p>';
    */
  }


  // return the difference in length between two strings
  function cmpr_strlen( $a, $b ) {
    return strlen( $b ) - strlen( $a );
  }
  /**
   * Parses filename from a Content-Disposition header value.
   *
   * As per RFC6266:
   *
   *     content-disposition = "Content-Disposition" ":"
   *                            disposition-type *( ";" disposition-parm )
   *
   *     disposition-type    = "inline" | "attachment" | disp-ext-type
   *                         ; case-insensitive
   *     disp-ext-type       = token
   *
   *     disposition-parm    = filename-parm | disp-ext-parm
   *
   *     filename-parm       = "filename" "=" value
   *                         | "filename*" "=" ext-value
   *
   *     disp-ext-parm       = token "=" value
   *                         | ext-token "=" ext-value
   *     ext-token           = <the characters in token, followed by "*">
   *
   * @since 0.7.0
   *
   * @see WP_REST_Attachments_Controller::get_filename_from_disposition()
   *
   * @link http://tools.ietf.org/html/rfc2388
   * @link http://tools.ietf.org/html/rfc6266
   *
   * @param string[] $disposition_header List of Content-Disposition header values.
   * @return string|null Filename if available, or null if not found.
   */
  protected static function get_filename_from_disposition( $disposition_header ) {
    // Get the filename.
    $filename = null;

    foreach ( $disposition_header as $value ) {
      $value = trim( $value );

      if ( strpos( $value, ';' ) === false ) {
        continue;
      }

      list( $type, $attr_parts ) = explode( ';', $value, 2 );

      $attr_parts = explode( ';', $attr_parts );
      $attributes = array();

      foreach ( $attr_parts as $part ) {
        if ( strpos( $part, '=' ) === false ) {
          continue;
        }

        list( $key, $value ) = explode( '=', $part, 2 );

        $attributes[ trim( $key ) ] = trim( $value );
      }

      if ( empty( $attributes[ 'filename' ] ) ) {
        continue;
      }

      $filename = trim( $attributes[ 'filename' ] );

      // Unquote quoted filename, but after trimming.
      if ( substr( $filename, 0, 1 ) === '"' && substr( $filename, -1, 1 ) === '"' ) {
        $filename = substr( $filename, 1, -1 );
      }
    }

    return $filename;
  }

  /**
   * Retrieves file extension by mime type.
   *
   * @since 0.7.0
   *
   * @param string $mime_type Mime type to search extension for.
   * @return string|null File extension if available, or null if not found.
   */
  protected static function get_file_extension_by_mime_type( $mime_type ) {
    static $map = null;

    if ( is_array( $map ) ) {
      return isset( $map[ $mime_type ] ) ? $map[ $mime_type ] : null;
    }

    $mime_types = wp_get_mime_types();
    $map = array_flip( $mime_types );

    // Some types have multiple extensions, use only the first one.
    foreach ( $map as $type => $extensions ) {
      $map[ $type ] = strtok( $extensions, '|' );
    }

    return isset( $map[ $mime_type ] ) ? $map[ $mime_type ] : null;
  }


}
// End Of Class.
endif;