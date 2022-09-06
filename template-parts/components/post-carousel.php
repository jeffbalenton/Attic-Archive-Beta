<?php


$args = array(
  'post_type' => 'post',
  'order' => 'date',
  'orderby' => 'desc',
  'posts' => 3,
);
$post_query = new WP_Query( $args );
?>
<div id="post_carousel" class="carousel carousel-dark slide p-2" data-bs-interval="false">
  <?php rewind_posts(); ?>
  <div class="carousel-inner">
    <?php
    if ( $post_query->have_posts() ): while ( $post_query->have_posts() ): $post_query->the_post();
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, array( '400', '400' ), true );
    $thumbnail_meta = get_post_meta( $thumbnail_id, '_wp_attatchment_image_alt', true );
    ?>
    <div class="carousel-item <?php if ( $post_query->current_post == 0 ) : ?>active<?php endif; ?>">
      <div class="card text-center mb-2">
        <div class="card-body">
          <?php if ( has_post_thumbnail() ) : ?>
          <img src="<?php echo $thumbnail_url[0];  ?>" class="d-block w-100">
			<?php else :  ?>
                <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="rounded mb-3 img-fluid">
          <?php endif; ?>
          <a href="<?php the_permalink(); ?>" class="nav-link">
          <?php the_title(); ?>
          </a> <a href="<?php the_permalink(); ?>" class="btn btn-warning text-white mt-2">View </a> </div>
      </div>
    </div>
    <!-- /.carousel-item --> 
    <!-- /.carousel-item --> 
    <!-- end second loop -->
    <?php endwhile;	endif; ?>
  </div>
  <!-- /.carousel-inner -->
  
  <div class="d-flex justify-content-center">
    <button class="carousel-control-prev" type="button" data-bs-target="#post_carousel" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
    <button class="carousel-control-next" type="button" data-bs-target="#post_carousel" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
  </div>
</div>
<!-- /.carousel-slide --> 

