<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package archive
 */

get_header();
?>
<div id="content" class="site-content container py-5 mt-5">
  <div id="primary" class="content-area"> 
    
    <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>
    <div class="row">
      <div class="col-sm-3"> <?php echo do_shortcode('[searchandfilter id="275"]'); ?> </div>
      <div class="col">
		  <h1 class="bg-warning text-white text-center">Photos</h1>
        <main id="main" class="site-main"> 
          
          <!-- Title & Description --> 
          <!--
          <header class="page-header mb-4">
            <h1>
              <?php // the_archive_title(); ?>
            </h1>
            <?php // the_archive_description('<div class="archive-description">', '</div>'); ?>
          </header>
          --> 
          <!-- Grid Layout -->
			
			
			
          <?php 
		
			
			if (have_posts()) : ?>
			<div class="row row-cols-auto">
			
          <?php while (have_posts()) : the_post(); ?>
           <div class="col">
			   <div class="d-flex flex-column align-items-center">
				  
				   <div class="p-2">
					   <?php
                      if ( has_post_thumbnail() ):
                        echo '<div class="">' . get_the_post_thumbnail( null, 'thumbnail' ) . '</div>';
                      ?>
                      <?php else :  ?>
                      <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="rounded mb-3 img-fluid">
                      <?php endif;?>
				   </div>
				   <div class="p-2 fw-bold">
				    <?php the_title(); ?>
				   </div>
				    <div class="p-2"> <a href="<?php the_permalink(); ?>">
                        <button type="button" class="btn btn-warning text-white">More Info</button>
                        </a> </div>
			   </div>
		   </div>
          <?php endwhile; ?>
				</div>
          <?php endif; ?>
          
          <!-- Pagination -->
          <div>
            <?php bootscore_pagination(); ?>
          </div>
        </main>
        <!-- #main --> 
        
      </div>
      <!-- col -->
      
      <?php // get_sidebar(); ?>
    </div>
    <!-- row --> 
    
  </div>
  <!-- #primary --> 
</div>
<!-- #content -->

<?php
get_footer();
