<?php get_header(); ?>
<div id="content" class="site-content container-md py-5 mt-4">
  <div class="row">
    <div class="col-sm-12 col-md-10">
      <div class="row">
        <?php
		  
		
/*
        use WeDevs\ORM\WP\Post as Post;
 $birth_day='17';
 $birth_month='Nov';
 $birth_year= '1983';
 
        var_dump( Post::all() );
  global $menu;
		  var_dump($menu);
  */     
		  
		
		  ?>
        <div class="col">
          <?php /* $dir =get_theme_file_uri('inc/loginpress'); var_dump($dir); */?>
          <?php the_content(); ?>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-sm-7">
          <div class="d-grid gap-3 mw-50">
            <p class="h4 text-center p-2">New Blog Posts</p>
            <?php get_template_part( 'template-parts/components/post', 'carousel' ); ?>
          </div>
        </div>
        <div class="text-center align-self-center col-sm-5">
          <div class="">
            <p class="h5">Updates are brief messages from the administrator of the site.  They can be notes about what’s new on the site, requests for info about a person or material in the archive, or anything really.</p>
            <a href="#"  class="btn btn-warning text-white mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> View Updates</a> </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?php $args = array( 'post_type' => 'update' ); ?>
                <?php $updates = get_posts( $args ); ?>
                <?php if ( $updates ):?>
                <?php  foreach ( $updates as $update ): ?>
                <?php $title = $update->post_title; ?>
                <?php $content= $update->post_content; ?>
                <div class="card">
                  <h5 class="card-header bg-warning text-white"> <?php echo $title ?> </h5>
                  <div class="card-body"> <?php echo $content; ?> </div>
                </div>
                <?php endforeach; ?>
                <?php else: echo 'No Updates';?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row  row-cols-1 row-cols-sm-3 text-center">
        <div class="col">
          <p class="h5">Recently Added People</p>
          <?php get_template_part( 'template-parts/components/person', 'carousel' ); ?>
        </div>
        <div class="col">
          <p class="h5">Recently Added Materials</p>
          <?php get_template_part( 'template-parts/components/materials', 'carousel' ); ?>
        </div>
        <div class="col">
          <p class="h5">Recentaly Added Stories</p>
          <?php get_template_part( 'template-parts/components/story', 'carousel' ); ?>
        </div>
      </div>
    </div>
    <div class="col-md-2 display-none display-md-block text-center" id="lineages">
      <p class="h3">Lineages</p>
      <?php get_template_part( 'template-parts/components/get', 'terms' ); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
