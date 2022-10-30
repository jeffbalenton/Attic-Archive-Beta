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
    <div class="col-sm-6">
      <div class="d-flex flex-column align-items-center">
        <div class="p-2 w-75">
          <p class='h-4 text-center'>Front Image</p>
          <?php $photo_front = get_field( 'photo_front' ); ?>
          <?php if ( $photo_front ) : ?>
          <img src="<?php echo esc_url( $photo_front['url'] ); ?>" alt="<?php echo esc_attr( $photo_front['alt'] ); ?>" class="img-fluid" />
          <?php endif; ?>
        </div>
        <div class='p-2 w-75 text-center'>
          <p class='h-4'>Back Image</p>
          <?php $photo_front = get_field( 'photo_back' ); ?>
          <?php if ( $photo_front ) : ?>
          <img src="<?php echo esc_url( $photo_back['url'] ); ?>" alt="<?php echo esc_attr( $photo_front['alt'] ); ?>" />
          <?php else: echo "No Back Image" ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div id="content-area" class="col-sm-4 border border-secondary">
      <div class="d-flex flex-column align-items-center">
        <div class="p-2">
          <h4 class="h-4">Photo Type</h4>
          <?php $photo_type_values = get_field( 'photo_type' ); ?>
          <?php if ( $photo_type_values ) : ?>
          <?php foreach ( $photo_type_values as $photo_type_value ) : ?>
          <?php echo esc_html( $photo_type_value ); ?>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class='p-2'>
          <h4 class="h-4">Date Taken</h4>
        </div>
        <div class="p-2 text-center">
          <h4 class="h-4">Place Taken</h4>
          <?php $photo_place_taken = get_field( 'photo_place_taken' ); ?>
          <?php if ( $photo_place_taken ) : ?>
          <?php foreach ( $photo_place_taken as $post_ids ) : ?>
          <a href="<?php echo get_permalink( $post_ids ); ?>" class="nav-link link-warning"><?php echo get_the_title( $post_ids ); ?></a>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class='p-2 text-center'>
          <h4 class="h-4">Description</h4>
			<?php 
		$description = get_field('photo_description');
			if($description):
			the_field('photo_description');
			else:
			echo "No Description Given";
			endif;
			?>
        </div>
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
</div>
<?php get_footer(); ?>
