<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package archive
 */
acf_form_head();
get_header();
?>

<div id="content" class="site-content container py-5 mt-5">
  <div id="primary" class="content-area">

    <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>

    <div class="row">
      <div class="col-md-6 col-xxl-9 flex-fill">

        <main id="main" class="site-main">

          <header class="entry-header">
      
            <!-- Featured Image-->
        
            <!-- .entry-header -->
          </header>

          <div class="entry-content">
            <!-- Content -->
            <?php the_content(); ?>
            <!-- .entry-content -->
            <?php wp_link_pages(array(
              'before' => '<div class="page-links">' . esc_html__('Pages:', 'archive'),
              'after'  => '</div>',
            ));
            ?>
          </div>

          <footer class="entry-footer">

          </footer>
          <!-- Comments -->
          <?php comments_template(); ?>

        </main><!-- #main -->

      </div><!-- col -->
   <div class="col-md-6 col-xxl-3 flex-fill">
	   <div class="d-grid">
				  <div class="h3">Send Us a Message</div>
		   <div>
		   <!-- Contact Form -->
<?php
	
	acf_form(array(
		'post_id'		=> 'new_post',
		'post_title'	=> false,
		'post_content'	=> false,
		'new_post'		=> array(
			'post_type'		=> 'contact_form',
			'post_status'	=> 'publish'
		),
		'return'		=> home_url('contact-form-thank-you'),
		'submit_value'	=> 'Send'
	));
	
	?>
		   </div>
	   </div>
	</div>
    </div><!-- row -->

  </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
