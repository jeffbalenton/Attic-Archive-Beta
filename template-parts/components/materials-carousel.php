<!-- Bootstrap 5 Carousel with WordPress Loop -->
<?php
$args = array(
  'post_type' => array( 'letter', 'photo', 'objects', 'article', 'document', 'ephemera', 'text', 'audio', 'video' ),
  'order' => 'date',
  'orderby' => 'desc',
  'posts' => 3,
);
$materials_query = new WP_Query( $args );
?>
<div id="materials_carousel" class="carousel carousel-dark slide" data-bs-interval="false">
  <?php rewind_posts(); ?>
  <div class="carousel-inner">
    <?php
    if ( $materials_query->have_posts() ): while ( $materials_query->have_posts() ): $materials_query->the_post();
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id,'medium', true );
    $thumbnail_meta = get_post_meta( $thumbnail_id, '_wp_attatchment_image_alt', true );
    ?>
    <div class="carousel-item <?php if ( $materials_query->current_post == 0 ) : ?>active<?php endif; ?>">
      <div class="card text-center mb-2">
        <h5 class="card-header"> 
          <?php the_title(); ?>
          </h5>
        <div class="card-body">
          <?php if ( has_post_thumbnail() ) : ?>
          <img src="<?php echo $thumbnail_url[0];  ?>" class="d-block w-100 mb-2">
				<?php else :  ?>
                <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="d-block w-100 mb-2">
          <?php endif; ?>
          <a href="<?php the_permalink(); ?>" class="btn btn-warning text-white">View </a> </div>
      </div>
    </div>
    <!-- /.carousel-item --> 
    <!-- end second loop -->
    <?php endwhile;	endif; ?>
  </div>
  <!-- /.carousel-inner -->
  <div class="d-flex justify-content-center">
    <button class="carousel-control-prev" type="button" data-bs-target="#materials_carousel" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
    <button class="carousel-control-next" type="button" data-bs-target="#materials_carousel" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
  </div>
</div>
<!-- /.carousel-slide --> 
