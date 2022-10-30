<?php

/**
 * Bootscore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootscore
 */

function archive_insert_category( $catarr, $wp_error = false ) {
	$cat_defaults = array(
		'cat_ID'               => 0,
		'taxonomy'             => 'category',
		'cat_name'             => '',
		'category_description' => '',
		'category_nicename'    => '',
		'category_parent'      => '',
	);
	$catarr       = wp_parse_args( $catarr, $cat_defaults );

	if ( '' === trim( $catarr['cat_name'] ) ) {
		if ( ! $wp_error ) {
			return 0;
		} else {
			return new WP_Error( 'cat_name', __( 'You did not enter a category name.' ) );
		}
	}

	$catarr['cat_ID'] = (int) $catarr['cat_ID'];

	// Are we updating or creating?
	$update = ! empty( $catarr['cat_ID'] );

	$name        = $catarr['cat_name'];
	$description = $catarr['category_description'];
	$slug        = $catarr['category_nicename'];
	$parent      = (int) $catarr['category_parent'];
	if ( $parent < 0 ) {
		$parent = 0;
	}

	if ( empty( $parent )
		|| ! term_exists( $parent, $catarr['taxonomy'] )
		|| ( $catarr['cat_ID'] && term_is_ancestor_of( $catarr['cat_ID'], $parent, $catarr['taxonomy'] ) ) ) {
		$parent = 0;
	}

	$args = compact( 'name', 'slug', 'parent', 'description' );

	if ( $update ) {
		$catarr['cat_ID'] = wp_update_term( $catarr['cat_ID'], $catarr['taxonomy'], $args );
	} else {
		$catarr['cat_ID'] = wp_insert_term( $catarr['cat_name'], $catarr['taxonomy'], $args );
	}

	if ( is_wp_error( $catarr['cat_ID'] ) ) {
		if ( $wp_error ) {
			return $catarr['cat_ID'];
		} else {
			return 0;
		}
	}
	return $catarr['cat_ID']['term_id'];
}

function archive_import_cleanup( $id ) {
	wp_delete_attachment( $id );
}

// WooCommerce
//require get_template_directory() . '/woocommerce/woocommerce-functions.php';
// WooCommerce END


define( 'MY_ACF_PATH', get_template_directory() . '/inc/acf/' );
define( 'MY_ACF_URL', get_template_directory_uri() . '/inc/acf/' );
define( 'MY_ACFE_PATH', get_template_directory() . '/inc/acf-extended/' );
define( 'MY_ACFE_URL', get_template_directory_uri() . '/inc/acf-extended/' );


//include ACF And ACF Extended 

include_once( 'inc/acf/acf.php' );
include_once( 'inc/acf-extended/acf-extended.php' );

//Search Filter

include_once( 'inc/search-filter-pro/search-filter-pro.php' );

//Bs-swiper

//include_once( 'inc/bs-swiper/main.php' );

//Include Parsers

include_once( 'inc/parsers.php' );

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
    $family->add_cap( 'view_person' );
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




    // Check if Webmaster is user


    $user = get_user_by( 'display_name', 'Webmaster' );
    if ( !$user ):
      $userdata = [
        'ID' => 0, //(int) User ID. If supplied, the user will be updated.
        'user_pass' => 'archiveuser2022', //(string) The plain-text user password.
        'user_login' => 'webmaster@exammple.com', //(string) The user's login username.
        'user_nicename' => '', //(string) The URL-friendly user name.
        'user_url' => '', //(string) The user URL.
        'user_email' => 'webmaster@exammple.com', //(string) The user email address.
        'display_name' => 'Webmaster', //(string) The user's display name. Default is the user's username.
        'nickname' => '', //(string) The user's nickname. Default is the user's username.
        'first_name' => 'Webmaster', //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
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

    wp_insert_user( $userdata );

    endif;


  }
endif;
add_action( 'after_setup_theme', 'bootscore_setup' );

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

function archive_post_exists( $title, $content = '', $date = '', $type = '', $status = '' ) {
  global $wpdb;

  $post_title = wp_unslash( sanitize_post_field( 'post_title', $title, 0, 'db' ) );
  $post_content = wp_unslash( sanitize_post_field( 'post_content', $content, 0, 'db' ) );
  $post_date = wp_unslash( sanitize_post_field( 'post_date', $date, 0, 'db' ) );
  $post_type = wp_unslash( sanitize_post_field( 'post_type', $type, 0, 'db' ) );
  $post_status = wp_unslash( sanitize_post_field( 'post_status', $status, 0, 'db' ) );

  $query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
  $args = array();

  if ( !empty( $date ) ) {
    $query .= ' AND post_date = %s';
    $args[] = $post_date;
  }

  if ( !empty( $title ) ) {
    $query .= ' AND post_title = %s';
    $args[] = $post_title;
  }

  if ( !empty( $content ) ) {
    $query .= ' AND post_content = %s';
    $args[] = $post_content;
  }

  if ( !empty( $type ) ) {
    $query .= ' AND post_type = %s';
    $args[] = $post_type;
  }

  if ( !empty( $status ) ) {
    $query .= ' AND post_status = %s';
    $args[] = $post_status;
  }

  if ( !empty( $args ) ) {
    return ( int )$wpdb->get_var( $wpdb->prepare( $query, $args ) );
  }

  return 0;
}