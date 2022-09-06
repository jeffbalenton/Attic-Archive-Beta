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
  
  <!-- Hook to add something nice -->
  <?php bs_after_primary(); ?>
  <div class="row"> 
    
    <!--  Search Filter Form-->
    <div class="col-sm-3"> <?php echo do_shortcode('[searchandfilter id="3299"]'); ?> </div>
    <div  id="primary" class="col-sm-9 content-area">
      <h1 class="text-warning text-center">Tasks</h1>
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


        if ( have_posts() ): ?>
        <div class="containter">
          <?php while (have_posts()) : the_post(); ?>
          <div class="row">
            <div class="col">
              <div class="card mb-2">
                <div class="card-header bg-warning">
                  <p class="text-white text-center h3">
                    <?php the_title(); ?>
                  </p>
                </div>
                <div class="card-body">
                  <div class="d-flex flex-row justify-content-around">
                    <div class="p-2 text-center">
                      <h4 class="h-4">Date Added</h4>
                      <?php
                      $date_created = date_create( "$post->post_date" );
                      $date_created = date_format( $date_created, "M j, Y" );
                      echo $date_created ?>
                    </div>
                    <div class="p-2 text-center">
                      <h4 class="h-4">Date Updated</h4>
                      <?php
                      $date_modified = date_create( "$post->post_modified" );
                      $date_modified = date_format( $date_modified, "M j, Y" );
                      echo $date_modified ?>
                    </div>
                    <div class="p-2">
                      <h4 class="h-4">Priority</h4>
                      <p class="text-center">
                        <?php the_field('task_priority'); ?>
                      </p>
                    </div>
                  </div>
                  <div class="d-flex flex-row justify-content-around">
                    <div class="p-2"><a href="<?php the_permalink(); ?>">
                      <button type="button" class="btn btn-warning text-white">More Info</button>
                      </a>
                      <h4 class="h-4">
                    </div>
                  </div>
                </div>
              </div>
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
<!-- #content -->

<?php
get_footer();
