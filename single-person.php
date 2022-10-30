<?php
/*
 * Template Post Type: post
 */
acf_form_head();
get_header();
?>
<div id="content" class="site-content container py-5 mt-4">
  <div class="row">
    <div id="primary" class="content-area col-sm-12">
      <p class="Display-1 text-center text-white bg-warning">
        <?php the_Title(); ?>
      </p>
    </div>
  </div>
  <div class="row">
    <div id="content-area" class="col-sm-9">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 offset-sm-2">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <?php bootscore_post_thumbnail(); ?>
                <!-- Button trigger modal --> 
                <br />
                <button class="btn btn-warning text-white btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#feedbackModal">Give Feedback</button>
              </div>
              <div class="flex-grow-1 ms-3">
                <div class="table-responsive">
                  <table class="table table-sm table-borderless fs-6">
                    <tbody>
                      <tr>
                        <td><b>BIRTH</b></td>
                        <td class="text-end"><?php the_field('birth_date'); ?></td>
                        <td class="align-middle"><i class="fa-solid fa-circle fa-xs"></i></td>
                        <td><?php $birthplace = get_field( 'birth_place' ); ?>
                          <?php if ( $birthplace ) : ?>
                          <?php foreach ( $birthplace as $birth ) :
                      
                              echo get_the_title( $birth );
                          endforeach;
                          endif;

                          ?>
                  
                       </td>
                      </tr>
                      <tr>
                        <td><b>DEATH</b></td>
                        <td class="text-end"><?php the_field('death_date'); ?></td>
                        <td class="align-middle"><i class="fa-solid fa-circle fa-xs"></i></td>
                        <td><?php $deathplace = get_field( 'death_place' ); ?>
                          <?php if ( $deathplace ) : ?>
                          <?php foreach ( $deathplace as $death ) : 
							
							echo get_the_title($death);
							?>
                      
                          <?php endforeach; ?>
                          <?php endif; ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php
                  /**
				  *
				  *sample code
				  */

                  ?>
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="feedbackModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-sm-6 offset-sm-3 text-center">
            <p class='h6'>Bio</p>
            <?php $bio=get_field('person_bio');?>
            <?php if ($bio): ?>
            <?php echo $bio; ?>
            <?php else: ?>
            <p> No Bio Yet</p>
            <?php endif;?>
          </div>
        </div>
        <div class="row">
          <?php
          ?>
          <div class="col"> </div>
        </div>
        <div class="row text-center p-2">
          <div class="col-sm-6">
            <p class="h6">Alternate Names</p>
            <?php
            $alternate_names = get_field( 'alternate_names' );
            if ( $alternate_names ):
              the_field( 'alternate_names' );
            else :echo '<em>No Alternate Names</em>';
            endif

            ?>
          </div>
          <div class="col-sm-6">
            <p class="h6">Person Tags</p>
            <?php $person_tags = get_field( 'person_tags' ); ?>
            <?php if ( $person_tags ) : ?>
            <?php
            $get_terms_args = array(
              'taxonomy' => 'person_tags',
              'hide_empty' => 0,
              'include' => $person_tags,
            );
            ?>
            <?php $terms = get_terms( $get_terms_args ); ?>
            <?php if ( $terms ) : ?>
            <?php foreach ( $terms as $term ) : ?>
            <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="nav-link"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php
            else :
              echo '<em>No Tags Assigned</em>';
            ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="row text-center p-2">
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
        <div class="row text-center p-2">
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
        <div class="row text-center p-2">
          <div class="col-sm-6">
            <p class="h6">Generation</p>
            <?php $person_generation = get_field( 'person_generation' ); ?>
            <?php if ( $person_generation ) : ?>
            <a href="<?php echo esc_url( get_term_link( $person_generation ) ); ?>" class="nav-link"><?php echo esc_html( $person_generation->name ); ?></a>
            <?php endif; ?>
            </td>
          </div>
          <div class="col-sm-6">
            <p class="h6">Relationship to Base Person</p>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-12">
            <p id='test' class="text-center h3">Lineages</p>
            <p></p>
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
            <div class="d-flex flex-row justify-content-center">
              <?php foreach ( $terms as $term ) : ?>
              <div class="p-2"> <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="nav-link link-warning"><?php echo esc_html( $term->name ); ?></a> </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="d-grid gap-2">
        <button  class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal1">Places Lived</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Places Lived</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal2">Life Events</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Life Events</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?php
                $id = get_the_ID();
                $event_args = [
                  'post_type' => 'event',
                  'post_parent' => $id,
                  'meta_key' => 'event_date',
                  'orderby' => 'meta_value_date',
                  'order' => 'ASC',
                ];

                $events = get_posts( $event_args );


                if ( $events ):
                  echo '<ul>';
                foreach ( $events as $event ):
                  echo '<li>';
                $title = get_the_Title( $event->ID );
                echo $title;
                echo '</li>';

                endforeach;
                echo '</ul>';
                else :
                  esc_html_e( 'No life events have been entered.' );
                endif;


                ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal3">Materials</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Materials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal4">Photos</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Photos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal5">Research</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Research</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal6">Documentation</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal6" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Documentation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal7">Notes</button>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal8">Bookmarks</button>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal9">Tasks</button>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal10">Citations</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <footer class="entry-footer clear-both">
        <div class="mb-4">
          <?php bootscore_tags(); ?>
        </div>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <?php previous_post_link('%link'); ?>
            </li>
            <li class="page-item">
              <?php next_post_link('%link'); ?>
            </li>
          </ul>
        </nav>
      </footer>
    </div>
  </div>
</div>
<?php get_footer(); ?>
