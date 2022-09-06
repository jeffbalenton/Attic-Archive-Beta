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

?>
<footer class="d-none d-md-block">
  <div class="archive-footer border-top border-warning">
    <div class="container pt-4 pb-4">
      <div class="row justify-content-around">
        <div class="col ">
          <p class="h6">&copy;&nbsp;<?php echo Date('Y'); ?> - Attic Archive</p>
        </div>
        <div class="col"> <a href="<?php echo home_url('about');  ?>" class="btn btn-warning text-white btn-md">About Attic Archives</a> </div>
        <div class="col">
          <div class=" ms-2">
            <form class="searchform input-group" method="get" action="<?php home_url(); ?>">
              <input type="text" name="s" class="form-control" placeholder="Search">
            </form>
          </div>
        </div>
        <div class="col">
          <?php if ( is_user_logged_in() ) : ?>
          <a href="<?php echo wp_logout_url( home_url('about') ); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
          <?php else : ?>
          <a href="<?php echo esc_url( wp_login_url() ); ?>" alt="<?php esc_attr_e( 'Login', 'textdomain' ); ?>" class="btn btn-link btn-md link-warning" title="Members Area Login" rel="home"><i class="fas fa-sign-in-alt"></i> Log in</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<div class="top-button position-fixed zi-1020"> <a href="#to-top" class="btn btn-warning shadow"><i class="fas fa-chevron-up"></i></a> </div>
</div>
<!-- #page -->
<script src=”https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js”></script>
<?php wp_footer(); ?>

</body></html>