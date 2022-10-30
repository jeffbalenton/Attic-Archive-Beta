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
    <div class="col-sm-3"> <?php echo do_shortcode('[searchandfilter id="5924"]'); ?> </div>
    <div  id="primary" class="col-sm-9 content-area">
      <h1 class="text-center text-warning">Stories</h1>
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
                  <div class="container">
                    <div class="row mb-2">
                      <div class="col-sm-8">
                        <div class="d-flex align-items-center">
                          <div class="flex-shirnk-0">
                            <?php
                            if ( has_post_thumbnail() ):
                              echo '<div class="">' . get_the_post_thumbnail( null, 'medium' ) . '</div>';
                            ?>
                            <?php else :  ?>
                            <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="rounded mb-3 img-fluid">
                            <?php endif;?>
                          </div>
                          <div class="flex-grow-1 ms-3"> <?php the_field('story_description');?></div>
                        </div>
                      </div>
                    </div>
					                       <div class="row row-cols-2">
                          <?php $story_person = get_field( 'story_person' ); ?>
                          <?php if ( $story_person ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">People</h6>
                            <?php foreach ( $story_person as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $story_letter = get_field( 'story_letter' ); ?>
                          <?php if ( $story_letter ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Letters</h6>
                            <?php foreach ( $story_letter as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $story_place = get_field( 'story_place' ); ?>
                          <?php if ( $story_place ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Places</h6>
                            <?php foreach ( $story_place as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $story_event = get_field( 'story_event' ); ?>
                          <?php if ( $story_event ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Events</h6>
                            <?php foreach ( $story_event as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $story_story = get_field( 'story_story' ); ?>
                          <?php if ( $story_story ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Stories</h6>
                            <?php foreach ( $story_story as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $story_city = get_field( 'story_city' ); ?>
                          <?php if ( $story_city ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Cities</h6>
                            <?php foreach ( $story_city as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $story_task = get_field( 'story_task' ); ?>
                          <?php if ( $story_task ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Tasks</h6>
                            <?php foreach ( $story_task as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                        </div>
                    <div class="row">
                      <div class="col-sm-6 offset-sm-6">
                    <a href="<?php the_permalink(); ?>">
                        <button type="button" class="btn btn-warning text-white">More Info</button>
                        </a> 
                      </div>
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
