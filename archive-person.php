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
      <div class="col-sm-3"> 
		 
		  <?php echo do_shortcode('[searchandfilter id="1254"]'); ?> 
	
		</div>
      <div class="col-sm-9">
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
          <?php while (have_posts()) : the_post(); ?>
          <div class="card mb-2">
            <div class="card-header bg-warning">
              <p class="text-white text-center h3">
                <?php the_title(); ?>
              </p>
            </div>
            <div class="card-body">
              <div class="container">
                <div class="row">
                  <div class="col">
                    <div class="w-50">
                      <?php
                      if ( has_post_thumbnail() ):
                        echo '<div class="">' . get_the_post_thumbnail( null, 'medium' ) . '</div>';
                      ?>
                      <?php else :  ?>
                      <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="rounded mb-3 img-fluid">
                      <?php endif;?>
                    </div>
                  </div>
                  <div class="col-sm-10">
                    <table class="table table-responsive table-borderless">
                      <thead>
                        <tr class="text-center">
                          <th scope="col" class="flex-fill">Born</th>
                          <th scope="col" class="flex-fill">Died</th>
                          <th scope="col" class="flex-shrink">Generation</th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        <tr>
                          <td class=""><?php the_field('birth_date'); ?>
                            <p></p>
                            <p>
                           <?php $birthplace = get_field( 'birth_place' ); ?>
                          <?php if ( $birthplace ) : ?>
                          <?php foreach ( $birthplace as $birth ) :
                      
                              echo get_the_title( $birth );
                          endforeach;
                          endif;

                          ?>
                            </p></td>
                          <td class=""><?php the_field('death_date'); ?>
                            <p></p>
                            <p>
                            <?php $deathplace = get_field( 'death_place' ); ?>
                          <?php if ( $deathplace ) : ?>
                          <?php foreach ( $deathplace as $death ) : 
							
							echo get_the_title($death);
							?>
                      
                          <?php endforeach; ?>
                          <?php endif; ?>
                            </p></td>
                          <td class=""><?php $person_generation = get_field( 'person_generation' ); ?>
                            <?php if ( $person_generation ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $person_generation ) ); ?>" class="nav-link"><?php echo esc_html( $person_generation->name ); ?></a>
                            <?php endif; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
					  <div class="container">
					    <p class="text-center h4">Family Lines</p>
						        <?php $person_lineage = get_field( 'person_lineage' ); ?>
                    <?php if ( $person_lineage ) : ?>
                    <?php
                    $get_terms_args = array(
                      'taxonomy' => 'lineage',
                      'hide_empty' => 0,
                      'include' => $person_lineage,
                    );
                    ?>
                    <?php $terms = get_terms( $get_terms_args ); ?>
                    <?php if ( $terms ) : ?>
					  
					  <div class="row row-cols-auto">
					  
                    <?php foreach ( $terms as $term ) : ?>
					  
					  <div class="col">
					  
                    <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="nav-link"><?php echo esc_html( $term->name ); ?></a>
						  
						</div>
						  
                    <?php endforeach; ?>
					  
					  </div>
					  
                    <?php endif; ?>
                    <?php endif; ?>
					   
					  </div>
                  
                    
             
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-sm-6 offset-sm-3">
                    <div class="d-inline-flex">
                      <div class="p-2">
                        <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#familyTree-<?php the_ID(); ?>">Family Tree</button>
                        <!-- Family Tree Modal -->
                        <div class="modal fade" id="familyTree-<?php the_ID(); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title text-center" id="staticBackdropLabel">
                                  <?php // the_title(); ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="container">
                                  <div class="row text-center">
                                    <div class="col-sm-6">
                                      <p class='h6'>Parents</p>
                                      <?php
                                      $parents = get_field( 'person_parents' );
                                      if ( $parents ): ?>
                                      <div class="row row-cols-auto justify-content-center">
                                        <?php
                                        foreach ( $parents as $parent ):
                                          $permalink = get_permalink( $parent );
                                        $title = get_the_title( $parent );
                                        ?>
                                        <div class="col nav-item"> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                                        <?php endforeach; ?>
                                      </div>
                                      <?php else: ?>
                                      <p class="text-center">Unknown</p>
                                      <?php endif; ?>
                                    </div>
                                    <div class="col-sm-6">
                                      <p class='h6'>Siblings</p>
                                      <?php
                                      $siblings = get_field( 'person_siblings' );
                                      if ( $siblings ): ?>
                                      <div class="d-grid">
                                        <?php
                                        foreach ( $siblings as $sibling ):
                                          $permalink = get_permalink( $sibling );
                                        $title = get_the_title( $sibling );
                                        ?>
                                        <div class=""> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                                        <?php endforeach; ?>
                                      </div>
                                      <?php else: ?>
                                      <p class="text-center">Unknown</p>
                                      <?php endif; ?>
                                    </div>
                                  </div>
                                  <div class="row text-center">
                                    <div class="col-sm-6">
                                      <p class='h6'>Spouse(s)</p>
                                      <?php
                                      $spouses = get_field( 'person_spouses' );
                                      if ( $spouses ): ?>
                                      <div class="d-grid">
                                        <?php
                                        foreach ( $spouses as $spouse ):
                                          $permalink = get_permalink( $spouse );
                                        $title = get_the_title( $spouse );
                                        ?>
                                        <div class=""> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                                        <?php endforeach; ?>
                                      </div>
                                      <?php else: ?>
                                      <p class="text-center">Unknown</p>
                                      <?php endif; ?>
                                    </div>
                                    <div class="col-sm-6">
                                      <p class='h6'>Children</p>
                                      <?php
                                      $children = get_field( 'person_children' );
                                      if ( $children ): ?>
                                      <div class="d-grid">
                                        <?php
                                        foreach ( $children as $child ):
                                          $permalink = get_permalink( $child );
                                        $title = get_the_title( $child );
                                        ?>
                                        <div class=""> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                                        <?php endforeach; ?>
                                      </div>
                                      <?php else: ?>
                                      <p class="text-center">Unknown</p>
                                      <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                                <!--  Container End--> 
                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary d-none" >Close</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="p-2"> <a href="<?php the_permalink(); ?>">
                        <button type="button" class="btn btn-warning text-white">More Info</button>
                        </a> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
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
