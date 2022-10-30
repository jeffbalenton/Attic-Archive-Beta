<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package archive
 */


 global $interim_login;

          // Don't allow interim logins to navigate away from the page.
          if ( !$interim_login ) {
            ?>
        <p id="backtoblog">
          <?php
          $html_link = sprintf(
            '<a href="%s" class="nav-link">%s</a>',
            esc_url( home_url( '/' ) ),
            sprintf(
              /* translators: %s: Site title. */
              _x( '&larr; Back to %s', 'site' ),
              get_bloginfo( 'title', 'display' ) . ' Home'
            )
          );
          /**
           * Filter the "Go to site" link displayed in the login page footer.
           *
           * @since 5.7.0
           *
           * @param string $link HTML link to the home URL of the current site.
           */
          echo apply_filters( 'login_site_html_link', $html_link );
          ?>
        </p>
        <?php

        the_privacy_policy_link( '<div class="privacy-policy-page-link">', '</div>' );
        }

        ?>
      </div>
      <?php // End of <div id="login">. ?>
    </div>
    <!-- end of Col--> 
  </div>
  <!-- end of Row-->
  <?php
  if ( !$interim_login &&
    /**
     * Filters the Languages select input activation on the login screen.
     *
     * @since 5.9.0
     *
     * @param bool Whether to display the Languages select input on the login screen.
     */
    apply_filters( 'login_display_language_dropdown', true )
  ) {
    $languages = get_available_languages();

    if ( !empty( $languages ) ) {
      ?>
  <div class="language-switcher">
    <form id="language-switcher" action="" method="get">
      <label for="language-switcher-locales"> <span class="dashicons dashicons-translation" aria-hidden="true"></span> <span class="screen-reader-text">
        <?php _e( 'Language' ); ?>
        </span> </label>
      <?php
      $args = array(
        'id' => 'language-switcher-locales',
        'name' => 'wp_lang',
        'selected' => determine_locale(),
        'show_available_translations' => false,
        'explicit_option_en_us' => true,
        'languages' => $languages,
      );

      /**
       * Filters default arguments for the Languages select input on the login screen.
       *
       * @since 5.9.0
       *
       * @param array $args Arguments for the Languages select input on the login screen.
       */
      wp_dropdown_languages( apply_filters( 'login_language_dropdown_args', $args ) );
      ?>
      <?php if ( $interim_login ) { ?>
      <input type="hidden" name="interim-login" value="1" />
      <?php } ?>
      <?php if ( isset( $_GET['redirect_to'] ) && '' !== $_GET['redirect_to'] ) { ?>
      <input type="hidden" name="redirect_to" value="<?php echo esc_url_raw( $_GET['redirect_to'] ); ?>" />
      <?php } ?>
      <?php if ( isset( $_GET['action'] ) && '' !== $_GET['action'] ) { ?>
      <input type="hidden" name="action" value="<?php echo esc_attr( $_GET['action'] ); ?>" />
      <?php } ?>
      <input type="submit" class="button" value="<?php esc_attr_e( 'Change' ); ?>">
    </form>
  </div>
  <?php } ?>
  <?php } ?>
  <?php

  if ( !empty( $input_id ) ) {
    ?>
  <script type="text/javascript">
		try{document.getElementById('<?php echo $input_id; ?>').focus();}catch(e){}
		if(typeof wpOnload==='function')wpOnload();
		</script>
  <?php
  }
			?>

<script type="text/javascript">
		  // Get the checkbox
  var checkBox = document.getElementById("requestCheck");
	 // Get the output text
  var text = document.getElementById("contribute");
	  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
	function myFunction() {

 
	</script><?php
  /**
   * Fires in the login page footer.
   *
   * @since 3.1.0
   */
  do_action( 'login_footer' );

  ?>
  <div class="clear"></div>
</div>
<!-- End of Container-->
</body>
</html>
