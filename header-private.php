<?php

// Redirect to HTTPS login if forced to use SSL.
if ( force_ssl_admin() && !is_ssl() ) {
  if ( 0 === strpos( $_SERVER[ 'REQUEST_URI' ], 'http' ) ) {
    wp_safe_redirect( set_url_scheme( $_SERVER[ 'REQUEST_URI' ], 'https' ) );
    exit;
  } else {
    wp_safe_redirect( 'https://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] );
    exit;
  }
}

 // Don't index any of these forms.
  add_filter( 'wp_robots', 'wp_robots_sensitive_page' );

 // Shake it!
  $shake_error_codes = array( 'empty_password', 'empty_email', 'invalid_email', 'invalidcombo', 'empty_username', 'invalid_username', 'incorrect_password', 'retrieve_password_email_failure' );
  /**
   * Filters the error codes array for shaking the login form.
   *
   * @since 3.0.0
   *
   * @param string[] $shake_error_codes Error codes that shake the login form.
   */



  $shake_error_codes = apply_filters( 'shake_error_codes', $shake_error_codes );

  
  $login_title = get_bloginfo( 'name', 'display' );

  /* translators: Login screen title. 1: Login screen name, 2: Network or site name. */
  $login_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; WordPress' ), $title, $login_title );

  if ( wp_is_recovery_mode() ) {
    /* translators: %s: Login screen title. */
    $login_title = sprintf( __( 'Recovery Mode &#8212; %s' ), $login_title );
  }

  /**
   * Filters the title tag content for login page.
   *
   * @since 4.9.0
   *
   * @param string $login_title The page title, with extra context added.
   * @param string $title       The original page title.
   */
  $login_title = apply_filters( 'login_title', $login_title, $title );
 ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php echo $login_title; ?></title>
<?php



/**
 * Enqueue scripts and styles for the login page.
 *
 * @since 3.1.0
 */
do_action( 'registration_enqueue_scripts' );

/**
 * Fires in the login page header after scripts are enqueued.
 *
 * @since 2.1.0
 */
do_action( 'login_head' );
//Loads the internal WP jQuery 
   wp_enqueue_script('jquery'); 
	
$login_header_url = __( 'https://wordpress.org/' );

/**
 * Filters link URL of the header logo above login form.
 *
 * @since 2.1.0
 *
 * @param string $login_header_url Login header logo URL.
 */
$login_header_url = apply_filters( 'login_headerurl', $login_header_url );

$login_header_title = '';

/**
 * Filters the title attribute of the header logo above login form.
 *
 * @since 2.1.0
 * @deprecated 5.2.0 Use {@see 'login_headertext'} instead.
 *
 * @param string $login_header_title Login header logo title attribute.
 */
$login_header_title = apply_filters_deprecated(
  'login_headertitle',
  array( $login_header_title ),
  '5.2.0',
  'login_headertext',
  __( 'Usage of the title attribute on the login logo is not recommended for accessibility reasons. Use the link text instead.' )
);

$login_header_text = empty( $login_header_title ) ? __( 'Powered by WordPress' ) : $login_header_title;

/**
 * Filters the link text of the header logo above the login form.
 *
 * @since 5.2.0
 *
 * @param string $login_header_text The login header logo link text.
 */
$login_header_text = apply_filters( 'login_headertext', $login_header_text );

$classes = array( 'login-action-' . $action, 'wp-core-ui' );

if ( is_rtl() ) {
  $classes[] = 'rtl';
}

if ( $interim_login ) {
  $classes[] = 'interim-login';

  ?>
<style type="text/css">
html {
    background-color: transparent;
}
</style>
<?php

if ( 'success' === $interim_login ) {
  $classes[] = 'interim-login-success';
}
}

$classes[] = ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

/**
 * Filters the login page body classes.
 *
 * @since 3.5.0
 *
 * @param string[] $classes An array of body classes.
 * @param string   $action  The action that brought the visitor to the login page.
 */
$classes = apply_filters( 'login_body_class', $classes, $action );
wp_head();	
?>

</head>

<body class="login no-js <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
<script type="text/javascript">
		document.body.className = document.body.className.replace('no-js','js');
	</script>
<?php
/**
 * Fires in the registration page header after the body tag is opened.
 *
 * @since 4.6.0
 */