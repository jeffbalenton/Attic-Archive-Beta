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
    <div id="content-area" class="col-sm-9 border-secondary">
      <div class="container">
        <div class="row">
          <div class="col-sm-5">
            <div class="d-flex flex-column align-items-center">
              <div class="p-2">
                <p class='h-4'>Front Image</p>
                <?php $photo_front = get_field( 'photo_front' ); ?>
                <?php if ( $photo_front ) : ?>
                <img src="<?php echo esc_url( $photo_front['url'] ); ?>" alt="<?php echo esc_attr( $photo_front['alt'] ); ?>" />
                <?php endif; ?>
              </div>
              <div class='p-2'>
                <p class='h-4'>Back Image</p>
                <?php $photo_front = get_field( 'photo_back' ); ?>
                <?php if ( $photo_front ) : ?>
                <img src="<?php echo esc_url( $photo_back['url'] ); ?>" alt="<?php echo esc_attr( $photo_front['alt'] ); ?>" />
                <?php else: echo "No Back Image" ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="d-flex flex-column align-items-center">
              <div class="p-2"><h4 class="h-4">Photo Type</h4> </div>
              <div class='p-2'><h4 class="h-4">Date Taken</h4> </div>
              <div class="p-2"><h4 class="h-4">Place Taken</h4> </div>
              <div class='p-2'><h4 class="h-4">Description</h4> </div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="d-grid gap-2">
              <button  class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal1">Album Details</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Album Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal2">Subject Matter</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Subject Matter</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal3">Collections</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Collections</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal4">Tasks</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Tasks</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal5">Bookmarks</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Bookmarks</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal6">Research Notes</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal6" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Research Notes</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal7">Feedback</button>
              
              <!-- Modal -->
              <div class="modal fade" id="Modal7" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Feedback</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> ... </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
                    </div>
                  </div>
                </div>
              </div>
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
    </div>
  </div>

</div>
<?php get_footer(); ?>
