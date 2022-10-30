<?php


if ( !class_exists( 'AdminSubscriber' ) ):

  class AdminSubscriber
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
      'admin_head' => 'archive_admin_meta_boxes',
     // 'admin_menu' => 'change_post_menu_label',
    // 'init' => 'change_post_object_label',
    //  'admin_menu' => 'setup_admin_menus',
      'menu_order' => 'remove_these_admin_menus',
      'menu_order' => 'my_new_admin_menu_order',
      'admin_footer_text' => [ 'remove_admin_footer', 11 ],
      'update_footer' => 'remove_bottom_footer',
      'admin_menu' => 'my_footer_shh',
      'menu_order' => 'my_new_admin_order',
      'admin_enqueue_scripts' => 'archive_admin_scripts',
     // 'admin_menu' => 'setup_admin_menus',

    ];
  }

	  
	



	  
  function archive_admin_scripts( $hook ) {

    // Get modification time. Enqueue files with modification date to prevent browser from loading cached scripts and styles when file content changes.
    $modificated_adminJs = date( 'YmdHi', filemtime( get_template_directory() . '/js/admin/admin.js' ) );
    $modificated_adminCss = date( 'YmdHi', filemtime( get_template_directory() . '/css/admin/admin-style.css' ) );

	  $screen = get_current_screen();
	  
	  if ('post-new.php?post_type=person' == $screen->parent_file):
	   wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/css/admin/person-admin-style.css', array()  );

    wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/js/admin/person-admin.js', array( 'jquery' ) );
	
	  
	  endif;
	  
   
	  if("attic-archive_page_unit-tests" == $screen->id):
	   wp_enqueue_script( 'admin-scratch-script', get_template_directory_uri() . '/js/admin/admin-scratch.js', array( 'jquery' ),  true );
	  
	  wp_enqueue_style( 'main', get_template_directory_uri() . '/css/bootstrap.min.css');
	    // Bootstrap JS
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.bundle.min.js', array(), true );
	  endif;
	  
    wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/css/admin/admin-style.css', array(), $modificated_adminCss );

    wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/js/admin/admin.js', array( 'jquery' ), $modificated_adminJs, true );
	  
	      wp_enqueue_script( 'admin-scratch-script', get_template_directory_uri() . '/js/admin/admin-scratch.js', array( 'jquery' ),  true );
  }

	  
	  
	  
  //set menu order
  function my_new_admin_menu_order( $menu_order ) {
    // define your new desired menu positions here
    // for example, move 'upload.php' to position #9 and built-in pages to position #1
    $new_positions = array(
      'index.php' => 1, // Dashboard
      'edit.php' => 2, // Posts
      'upload.php' => 3, // Media
      'edit.php?post_type=page' => 4, // Pages
      'edit-comments.php' => 5, // Comments

    );
    // helper function to move an element inside an array
    function move_element( & $array, $a, $b ) {
      $out = array_splice( $array, $a, 1 );
      array_splice( $array, $b, 0, $out );
    }
    // traverse through the new positions and move 
    // the items if found in the original menu_positions
    foreach ( $new_positions as $value => $new_index ) {
      if ( $current_index = array_search( $value, $menu_order ) ) {
        move_element( $menu_order, $current_index, $new_index );
      }
    }
    return $menu_order;
  }


  function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[ 5 ][ 0 ] = 'Article';
    //  $submenu[ 'edit.php' ][ 5 ][ 0 ] = 'Posts';
    //  $submenu[ 'edit.php' ][ 10 ][ 0 ] = 'Add New';
     $submenu[ 'edit.php' ][ 16 ][ 0 ] = 'Blog Topics';
 
  }


  function change_post_object_label() {
    global $wp_post_types;
    $labels = & $wp_post_types[ 'post' ]->labels;
    $labels->name = 'Blog';
    $labels->singular_name = 'Blog';
    $labels->add_new = 'Add Blog Post';
    $labels->add_new_item = 'Add  Post';
    $labels->edit_item = 'Edit Post';
    $labels->new_item = 'Blog Posts';
    $labels->view_item = 'View Blog Posts';
    $labels->search_items = 'Search Blog';
    $labels->not_found = 'No Blog posts found';
    $labels->not_found_in_trash = 'No Blog posts found in Trash';

  }


  function remove_admin_footer() {
    return '';
  }

  function remove_bottom_footer() {
    return '';
  }

  function archive_admin_meta_boxes() {

    //Remove Person Metaboxes 
    remove_meta_box( 'tagsdiv-occupation', 'person', 'side' );
    remove_meta_box( 'tagsdiv-cause_of_death', 'person', 'side' );
    remove_meta_box( 'tagsdiv-topic', 'person', 'side' );
    remove_meta_box( 'tagsdiv-generation', 'person', 'side' );
    remove_meta_box( 'tagsdiv-lineage', 'person', 'side' );
    remove_meta_box( 'tagsdiv-gender', 'person', 'side' );
    remove_meta_box( 'tagsdiv-privacy_level', 'person', 'side' );
    remove_meta_box( 'tagsdiv-military_branch', 'person', 'side' );
    remove_meta_box( 'tagsdiv-person_tags', 'person', 'side' );
    remove_meta_box( 'tagsdiv-relation', 'person', 'side' );
    remove_meta_box( 'acf-group_5f0c6eb201deb', 'person', 'side' );
    remove_meta_box( 'postimagediv', 'person', 'side' );
	remove_meta_box( 'tagsdiv-status', 'person', 'side' ); 
	  //Remove Event Metaboxes
	  
	   remove_meta_box( 'tagsdiv-course_of_study', 'event', 'side' );
	    remove_meta_box( 'tagsdiv-privacy_level', 'event', 'side' );
	    remove_meta_box( 'tagsdiv-degree', 'event', 'side' );
	    remove_meta_box( 'tagsdiv-event_type', 'event', 'side' );
	    remove_meta_box( 'postimagediv', 'event', 'side' );
	  
	  //Remove Bookmark Metaboxes
	   remove_meta_box( 'tagsdiv-topic', 'bookmark', 'side' );
	    remove_meta_box( 'tagsdiv-privacy_level', 'bookmark', 'side' );

	    remove_meta_box( 'postimagediv', 'bookmark', 'side' );
	  
	  //Remove Task Metaboxes
	  remove_meta_box('tagsdiv-topic','task','side');
  }


  /* 
   *Set User Roles
   *
   */
  function configure_archive_custom_roles() {
    if ( get_option( 'custom_roles_version' ) < 1 ) {

      add_role( 'family', 'Family', get_role( 'subscriber' )->capabilities );
      $family = get_role( 'family' );
      $family->add_cap( 'view_person' );
      update_option( 'custom_roles_version', 1 );
    }
  }

  //then remove menu items based on that
  function remove_these_menu_items( $menu_order ) {
    global $menu;
    // check using the new capability with current_user_can
    if ( !current_user_can( 'see_all_menus' ) ) {
      foreach ( $menu as $mkey => $m ) {
        //custom post type name "portfolio"
        $key = array_search( 'admin.php?page=acf-options-general', $m );
        //pages menu
        $keyB = array_search( 'edit.php?post_type=acf-field-group', $m );
        //posts menu
        $keyC = array_search( 'tools.php', $m );
        //tools menu
        $keyD = array_search( 'tools.php', $m );

        //settings menu
        $keyE = array_search( 'options-general.php', $m );


        if ( $key || $keyB || $keyC || $keyD || $keyE )
          unset( $menu[ $mkey ] );
      }
    }
    return $menu_order;
  }


  //Configure Materials and Research Admin Menus



  function remove_these_admin_menus( $menu_order ) {

    // first add your role the capability like so
    // get the "author" role object
    $role = get_role( 'administrator' );

    // add "see_all_menus" to this role object
    $role->add_cap( 'see_all_menus' );

    //then remove menu items based on that	

    global $menu;
    // check using the new capability with current_user_can
    if ( !current_user_can( 'see_all_menus' ) ) {
      foreach ( $menu as $mkey => $m ) {
        //custom post type name "portfolio"
        $key = array_search( 'admin.php?page=acf-options-general', $m );
        //pages menu
        $keyB = array_search( 'edit.php?post_type=acf-field-group', $m );
        //posts menu
        $keyC = array_search( 'tools.php', $m );
        //tools menu
        $keyD = array_search( 'edit.php?post_type=search-filter-widget', $m );

        //settings menu
        $keyE = array_search( 'options-general.php', $m );
        
		//appearance menu
		 $keyF =array_search('themes.php',$m); 
		
          $keyG =array_search('plugins.php',$m); 
		  
		   $keyH =array_search('admin.php?page=theme-general-settings',$m); 
		  
		   $keyI =array_search('themes.php',$m); 
		  
		   $keyJ =array_search('themes.php',$m); 
		  
        if ( $key || $keyB || $keyC || $keyD || $keyE ||$keyF ||$keyG ||$keyH )
          unset( $menu[ $mkey ] );
      }
    }
    return $menu_order;
  }

  function my_footer_shh() {
    remove_filter( 'update_footer', 'core_update_footer' );
  }
	
	 
	  function custom_materials_page() {
 // include( 'inc/admin/materials.php' );
}

function custom_research_page() {
 // include( 'inc/admin/materials.php' );
}
} // End Of Class.
endif;