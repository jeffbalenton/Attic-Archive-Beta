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
    <div class="col-sm-3"> <?php echo do_shortcode('[searchandfilter id="3535"]'); ?> </div>
    <div  id="primary" class="col-sm-9 content-area">
      <h1 class="text-warning text-center">Bookmarks</h1>
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
                  <div class="container text-center">
                    <div class="row">
                      <div class="col mb-2">
                        <h6 class="h-6">Bookmark Description</h6>
                        <?php the_field( 'bookmark_description' ); ?>
                        <?php
                        $link = get_field( 'bookmark_link' );
                        if ( $link ):
                          ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="btn btn-secondary">Continue Reading</a>;
                        <?php
                        endif;

                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4 border border-secondary">
                        <div class="d-flex flex-column">
                          <div class="p-2 text-center">
                            <h6 class="h-6">Date Added</h6>
                            <?php
                            $date_created = date_create( "$post->post_date" );
                            $date_created = date_format( $date_created, "M j, Y" );
                            echo $date_created ?>
                          </div>
                          <div class="p-2 text-center">
                            <h6 class="h-6">Date Updated</h6>
                            <?php
                            $date_modified = date_create( "$post->post_modified" );
                            $date_modified = date_format( $date_modified, "M j, Y" );
                            echo $date_modified ?>
                          </div>
                          <div class="p-2">
                            <?php $bookmark_topic = get_field( 'bookmark_topic' ); ?>
                            <?php if ( $bookmark_topic ) : ?>
                            <h6 class="h-6">Topics</h6>
                            <?php
                            $get_terms_args = array(
                              'taxonomy' => 'topic',
                              'hide_empty' => 0,
                              'include' => $bookmark_topic,
                            );
                            ?>
                            <?php $terms = get_terms( $get_terms_args ); ?>
                            <?php if ( $terms ) : ?>
                            <?php foreach ( $terms as $term ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="nav-link"><?php echo esc_html( $term->name ); ?></a>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-8">
						  <div class="container">
                                             <div class="row row-cols-2">
                        
                          <?php if ( $bookmark_person ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">People</h6>
                            <?php foreach ( $bookmark_person as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $bookmark_letter = get_field( 'bookmark_letter' ); ?>
                          <?php if ( $bookmark_letter ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Letters</h6>
                            <?php foreach ( $bookmark_letter as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $bookmark_place = get_field( 'bookmark_place' ); ?>
                          <?php if ( $bookmark_place ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Places</h6>
                            <?php foreach ( $bookmark_place as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $bookmark_event = get_field( 'bookmark_event' ); ?>
                          <?php if ( $bookmark_event ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Events</h6>
                            <?php foreach ( $bookmark_event as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $bookmark_story = get_field( 'bookmark_story' ); ?>
                          <?php if ( $bookmark_story ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Stories</h6>
                            <?php foreach ( $bookmark_story as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $bookmark_city = get_field( 'bookmark_city' ); ?>
                          <?php if ( $bookmark_city ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Cities</h6>
                            <?php foreach ( $bookmark_city as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                          <?php $bookmark_task = get_field( 'bookmark_task' ); ?>
                          <?php if ( $bookmark_task ) : ?>
                          <div class="col text-center">
                            <h6 class="h-6">Tasks</h6>
                            <?php foreach ( $bookmark_task as $post_ids ) : ?>
                            <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link"><?php echo get_the_title( $post_ids ); ?></a>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                        </div>
						  
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
