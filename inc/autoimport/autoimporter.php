<?php

/** Display verbose errors */
if ( !defined( 'IMPORT_DEBUG' ) ) {
  define( 'IMPORT_DEBUG', false );
}

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( !class_exists( 'WP_Importer' ) ) {
  $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
  if ( file_exists( $class_wp_importer ) )
    require $class_wp_importer;
}


$required = array(
  'post_exists' => ABSPATH . 'wp-admin/includes/post.php',
  'wp_generate_attachment_metadata' => ABSPATH . 'wp-admin/includes/image.php',
  'comment_exists' => ABSPATH . 'wp-admin/includes/comment.php',
  'wp_insert_category' => ABSPATH . '/wp-admin/includes/taxonomy.php',
);

foreach ( $required as $func => $req_file ) {
  if ( !function_exists( $func ) )
    require_once $req_file;
}



 
 
 

// get the file
require_once 'class-archive-import.php';

require_once 'parsers.php';
add_action( 'admin_init', 'autoimport' );

//autoimport();

function autoimport() {

  //import Field Groups

 

  $import_check = get_option( 'import_check' );

  if ( $import_check !== 'done' ):



  $user = get_user_by( 'login', 'Admin' );
  if ( !$user ):
    $userdata = [
      'user_pass' => 'archiveuser2022', //(string) The plain-text user password.
      'user_login' => 'Admin', //(string) The user's login username.
      'user_nicename' => 'admin', //(string) The URL-friendly user name.
      'user_url' => '', //(string) The user URL.
      'user_email' => 'webmaster@exammple2.com', //(string) The user email address.
      'display_name' => 'Admin', //(string) The user's display name. Default is the user's username.
      'nickname' => '', //(string) The user's nickname. Default is the user's username.
      'first_name' => 'Evan', //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
      'last_name' => 'Gregg', //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
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

  $user_id = wp_insert_user( $userdata );


  $args = array(
    'file' => get_template_directory() . '/inc/autoimport/files/import.xml',
    'map_user_id' => $user_id, );
  else :
    // call the function

    $user_id = $user->ID;
  $args = array(
    'file' => get_template_directory() . '/inc/autoimport/files/import.xml',
    'map_user_id' => $user->ID, );

  endif;


  auto_import( $args );

  update_option( 'import_check', 'done' );
  endif;


}

function auto_import( $args ) {

  $defaults = array( 'file' => '', 'map_user_id' => 0 );
  $args = wp_parse_args( $args, $defaults );

  $autoimport = new Auto_Importer( $args );
  $autoimport->do_import();

}