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
    <div class="col-sm-4">
    <header class="entry-header">
               <?php bootscore_post_thumbnail(); ?>   
            <p class="entry-meta">
              <small class="text-muted">
                <?php
                bootscore_date();
                _e(' by ', 'bootscore');
                the_author_posts_link();
                bootscore_comment_count();
                ?>
              </small>
            </p>
		
          </header>
         
          
        
    </div>
    <div id="content-area" class="col-sm-6 border border-secondary">
		<?php the_field( 'story_full' ); ?>
    </div>
    <div class="col-sm-2">
      <div class="d-grid gap-2">
        <button  class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal1">Materials</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Materials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal2">Photos</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Photos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal3">Other Materials</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Other Materials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal4">Texts</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Texts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal5">Objects</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Objects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal6">Ephemera</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal6" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ephemera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Close</button>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-warning text-white" type="button" data-bs-toggle="modal" data-bs-target="#Modal7">Research</button>
        
        <!-- Modal -->
        <div class="modal fade" id="Modal7" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
