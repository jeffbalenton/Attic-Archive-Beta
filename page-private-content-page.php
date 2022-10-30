<?php

function registration_header($wp_error=null){
	 if ( !is_wp_error( $wp_error ) ) {
    $wp_error = new WP_Error();
  }
      if ( $wp_error->has_errors() ) {
          $errors = '';
          $messages = '';

          foreach ( $wp_error->get_error_codes() as $code ) {
            $severity = $wp_error->get_error_data( $code );
            foreach ( $wp_error->get_error_messages( $code ) as $error_message ) {
              if ( 'message' === $severity ) {
                $messages .= '	' . $error_message . "<br />\n";
              } else {
                $errors .= '	' . $error_message . "<br />\n";
              }
            }
          }

          if ( !empty( $errors ) ) {
            /**
             * Filters the error messages displayed above the login form.
             *
             * @since 2.1.0
             *
             * @param string $errors Login error message.
             */
            echo '<div id="login_error">' . apply_filters( 'login_errors', $errors ) . "</div>\n";
          }

          if ( !empty( $messages ) ) {
            /**
             * Filters instructional messages displayed above the login form.
             *
             * @since 2.5.0
             *
             * @param string $messages Login messages.
             */

            echo '<p class="message ">' . apply_filters( 'login_messages', $messages ) . "</p>\n";

          }
        }	
	
}
get_header( 'private' );
/**
 * WordPress User Page
 *
 * Handles authentication, registering, resetting passwords, forgot password,
 * and other user handling.
 *
 * @package WordPress
 */


/**
 * Output the login page header.
 *
 * @since 2.1.0
 *
 * @global string      $error         Login error message set by deprecated pluggable wp_login() function
 *                                    or plugins replacing it.
 * @global bool|string $interim_login Whether interim login modal is being displayed. String 'success'
 *                                    upon successful login.
 * @global string      $action        The action that brought the visitor to the login page.
 *
 * @param string   $title    Optional. WordPress login Page title to display in the `<title>` element.
 *                           Default 'Log In'.
 * @param string   $message  Optional. Message to display in header. Default empty.
 * @param $errors $$errors Optional. The error to pass. Default is a $errors instance.
 */


get_header( 'private' );

?>
<div class="container">
<div class="row">
<div class="col-sm-6 align-items-center">
  <p class='display-6 '>Restricted Content</p>
  <p>You’ve reached content that is only available to family members.
    
    If you are a family member and have not created an account yet please fill out this form.
    
    Otherwise you can check out public content below:</p>
  <p class='display-6 text-center'>People</p>
  <?php
  $args = array(
    'post_type' => 'person',
    'order' => 'date',
    'orderby' => 'desc',
    'posts' => 3,
    'tax_query' => [
      [
        'taxonomy' => 'privacy_level',
        'field' => 'slug',
        'terms' => 'public',
      ]
    ],
  );
  $person_query = new WP_Query( $args );
  ?>

	<div id="person_carousel" class="carousel carousel-dark slide w-50" data-bs-interval="false">
  <?php rewind_posts(); ?>
  <div class="carousel-inner">
    <?php
    if ( $person_query->have_posts() ): while ( $person_query->have_posts() ): $person_query->the_post();
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'medium', true );
    $thumbnail_meta = get_post_meta( $thumbnail_id, '_wp_attatchment_image_alt', true );
    ?>
    <div class="carousel-item <?php if ( $person_query->current_post == 0 ) : ?>active<?php endif; ?>">
      <div class="card text-center mb-2" style="height: : 12.5rem;">
		  <h5 class="card-header"><?php the_title(); ?> </h5>
        <div class="card-body">
          <?php if ( has_post_thumbnail() ) : ?>
          <img src="<?php echo $thumbnail_url[0];  ?>" class="d-block w-100 h-50 mb-2">
			<?php else :  ?>
                <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="d-block w-100  mb-2">
          <?php endif; ?>
          </a> <a href="<?php the_permalink(); ?>" class="btn btn-warning text-white mt-2">View </a> </div>
      </div>
    </div>
    <!-- /.carousel-item --> 
    <!-- /.carousel-item --> 
    <!-- end second loop -->
    <?php endwhile;	endif; ?>
  </div>
  <!-- /.carousel-inner -->
  
  <div class="d-flex justify-content-center">
    <button class="carousel-control-prev" type="button" data-bs-target="#person_carousel" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
    <button class="carousel-control-next" type="button" data-bs-target="#person_carousel" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
  </div>
</div>
<!-- /.carousel-slide --> 

  <p class='display-6 text-center'>Materials</p>

</div>
<div class="col-sm-6">
<div id="login">
<?php


if ( 'POST' === $_SERVER[ 'REQUEST_METHOD' ] ):

  $user_login = $user_email = $user_fname = $user_lname = $request_check = '';

$request_check = isset($_POST['request_Check']) ? $_POST['request_Check'] : '';


if ( isset( $_POST[ 'user_login' ] ) && is_string( $_POST[ 'user_login' ] ) ):
  $user_login = wp_unslash( $_POST[ 'user_login' ] );
endif;

if ( isset( $_POST[ 'user_email' ] ) && is_string( $_POST[ 'user_email' ] ) ):
  $user_email = wp_unslash( $_POST[ 'user_email' ] );
endif;

if ( isset( $_POST[ 'user_fname' ] ) && is_string( $_POST[ 'user_fname' ] ) ):
  $user_fname = wp_unslash( $_POST[ 'user_fname' ] );
endif;

if ( isset( $_POST[ 'user_lname' ] ) && is_string( $_POST[ 'user_lname' ] ) ):
  $user_fname = wp_unslash( $_POST[ 'user_fname' ] );
endif;


$errors = register_new_user( $user_login, $user_email );

	if ( !is_wp_error( $errors ) ) :
      $redirect_to = !empty( $_POST[ 'redirect_to' ] ) ? $_POST[ 'redirect_to' ] : 'wp-login.php?checkemail=registered';
      wp_safe_redirect( $redirect_to );
      exit;
	endif;
	
	
	
  endif;


  $registration_redirect = !empty( $_REQUEST[ 'redirect_to' ] ) ? $_REQUEST[ 'redirect_to' ] : '';

  /**
   * Filters the registration redirect URL.
   *
   * @since 3.0.0
   * @since 5.9.0 Added the `$errors` parameter.
   *
   * @param string       $registration_redirect The redirect destination URL.
   * @param int|$errors $errors                User id if registration was successful,
   *                                            $errors object otherwise.
   */
  $redirect_to = apply_filters( 'registration_redirect', $registration_redirect, $errors );
/**
 * Filters the separator used between login form navigation links.
 *
 * @since 4.9.0
 *
 * @param string $login_link_separator The separator used between login form navigation links.
 */
//$login_link_separator = apply_filters( 'login_link_separator', ' | ' );
?>
	
<p class="border border-warning border-top-0 border-start-0 border-end-0 display-4">
  <?php	_e( 'Register Now' ) ?>
</p>
	<?php registration_header($errors); ?>
<form name="registerform" id="registerform" action="<?php echo htmlspecialchars(home_url('/private-content-page'));?>" method="post" novalidate="novalidate" class="border border-warning p-2 container">
  <div class="row">
    <div class="col mb-3">
      <input type"text" name="fname"  class="form-control" placeholder="First Name" >
    </div>
    <div class='col mb-3'>
      <input type"text" name="lname"  class="form-control" placeholder="Last Name" value=''>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <input type="text" name="user_login" class="form-control"  value="<?php echo esc_attr( wp_unslash( $user_login ) ); ?>"  autocapitalize="off" autocomplete="username" placeholder="Username"/>
    </div>
    <div class='col'>
      <input type="email" name="user_email" class="form-control"  value="<?php echo esc_attr( wp_unslash( $user_email ) ); ?>"  autocomplete="email" placeholder="Email Address"/>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <p id="reg_passmail" class='form-text'>
		  All registered users are able to comment on posts, materials, and other content.  In order to contribute to the archive or view private info about living people you must provide the info of a referring user.  When your referral has been confirmed you will receive an email letting you know you can start contributing.<strong>
        <?php _e( 'Registration confirmation will be emailed to you.' ); ?></strong>
      </p>
      <p class='form-text h4'>Contributor Request </p>
      <div class='form-check'>
        <input type="checkbox" name="request_check" id="requestCheck" class='form-check-input' <?php if ( !empty($request_check) ) echo 'checked'  ?>> </input>
        <label class"form-check-label">I want to contribute to the archive</label>
      </div>
    </div>
  </div>
  <div  id="contribute" class="row row-cols-auto">
    <div class="col mb-3">
      <input type="text" size="30"class="form-control" placeholder="Referring User First Nam" aria-label="First name" name="r_fname" >
    </div>
    <div class="col mb-3">
      <input type="text" size="30" class="form-control" placeholder="Referring User Last name" aria-label="Last name" name="r_lname" >
    </div>
	  <div class="col mb-3">
      <input type="email" size="45" class="form-control col" placeholder="Referring User Email Address" aria-label="referring user email" name="r_email" autocomplete="email">
    </div>
  </div>
	
  <input  class="col-sm-6" type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" class='form-control'/>
	<div class="col-sm-6">
  <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-sm btn-warning text-white" value="<?php esc_attr_e( 'Register' ); ?>">Register</button>
	</div>
</form>
<div class="d-flex flex-row justify-content-center"><a href="<?php echo esc_url( wp_login_url() ); ?>" class="nav-link">
  <?php _e( 'Already a Member? Log in' ); ?>
  </a><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="nav-link">
  <?php _e( 'Lost your password?' ); ?>
  </a></p>
	</div>
<?php

get_footer( 'private' );
