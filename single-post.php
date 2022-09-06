<?php
/*
 * Template Post Type: post
 */

get_header();
?>
<div id="content" class="site-content container py-5 mt-4">
  
    
    <div class="row">
      <div class="col-md-8 col-xxl-9">
		   <div id="primary" class="content-area"> 
			   <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>
    <?php the_breadcrumb(); ?>
			   
	</div> <!-- #primary END--> 
        <main id="main" class="site-main">
    <header class="entry-header">
		
			</header><!-- #entry-header END --> 
	      <div class="entry-content">
            <?php
            the_content();
    if ( have_rows( 'post_field_repeater' ) ) : ?>
	<?php while ( have_rows( 'post_field_repeater' ) ) : the_row(); ?>
		<?php the_sub_field( 'post_section_text' ); ?>
		<?php $post_repeater_image = get_sub_field( 'post_repeater_image' ); ?>
		<?php if ( $post_repeater_image ) : ?>
	        <div class='text-center mb-2'>
			<img src="<?php echo esc_url( $post_repeater_image['url'] ); ?>" class="w-50 align-middle" alt="<?php echo esc_attr( $post_repeater_image['alt'] ); ?>" />
			</div>	 
		<?php endif; ?>
		<?php $post_repeater_link = get_sub_field( 'post_repeater_link' ); ?>
		<?php if ( $post_repeater_link ) : ?>
			
			<a href="<?php echo esc_url( $post_repeater_link['url'] ); ?>" target="<?php echo esc_attr( $post_repeater_link['target'] ); ?>">More Info</a>
		<?php endif; ?>
			
		<?php $post_repeater_material = get_sub_field( 'post_repeater_material' ); ?>
		<?php if ( $post_repeater_material ) : ?>
			  <div class="d-flex flex-row  justify-content-center">
			<?php foreach ( $post_repeater_material as $material ) :
				  
				 $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($material), array('220','220'), true );
    		     $thumbnail_url = $thumbnail_url[0]; 
				  $fullimage_url=get_the_post_thumbnail_url($material);
			//$fullimage_url=$fullimage_url[0];
				  ?>
				 <div class="p-2">
				<?php if (!empty($thumbnail_url)):?>
			<a href="<?php echo $fullimage_url; ?>" data-lightbox="material" data-title="<?php echo get_the_title($material) ?>"><img src="<?php echo $thumbnail_url; ?>" class="d-block w-50 mb-2"></img></a>
			<?php else :  ?>
           <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="d-block w-100 mb-2">
			<?php endif; ?>
				<a href="<?php echo get_permalink( $material ); ?>" class=" nav-link"><button class="btn btn-warning text-white">More Info</button></a>
			
					 </div>
			<?php endforeach; ?>
				
			  </div>
		<?php endif; ?>
		<?php $post_repeater_person = get_sub_field( 'post_repeater_person' ); ?>
		<?php if ( $post_repeater_person ) :
				$i=0;
			?>
		
		<div class="d-flex flex-row align-items-center">
			<?php foreach ( $post_repeater_person as $person ) : 
			$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($person), array('220','220'), true );
    		$thumbnail_url = $thumbnail_url[0];
			$fullimage_url=get_the_post_thumbnail_url($person);
			//$fullimage_url=$fullimage_url[0];
			?>
				 <div class="p-2">
				<?php if (!empty($thumbnail_url)):?>
			<a href="<?php echo $fullimage_url; ?>" data-lightbox="person" data-title="<?php echo get_the_title($person) ?>"><img src="<?php echo $thumbnail_url; ?>" class="d-block w-50 mb-2"></img></a>
			<?php else :  ?>
           <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="d-block w-100 mb-2">
			<?php endif; ?>
				<a href="<?php echo get_permalink( $person ); ?>" class=" nav-link"><button class="btn btn-warning text-white">More Info</button></a>
			<?php $i++; ?>
					 </div>
			<?php endforeach; ?>
			  </div>		
		<?php endif; ?>
		<?php $post_repeater_place = get_sub_field( 'post_repeater_place' ); ?>
		<?php if ( $post_repeater_place ) : ?>
		
			<?php foreach ( $post_repeater_place as $place ) : ?>
				<a href="<?php echo get_permalink( $place ); ?>">More Info</a>
			<?php endforeach; ?>
				
		<?php endif; ?>
		<?php $post_repeater_event = get_sub_field( 'post_repeater_event' ); ?>
		<?php if ( $post_repeater_event ) : ?>
			
			<?php foreach ( $post_repeater_event as $event ) : ?>
				<?php setup_postdata ( $post ); 
			    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, array('220','220'), true );
    $thumbnail_meta = get_post_meta( $thumbnail_id, '_wp_attatchment_image_alt', true );?>
				<a href="<?php the_permalink(); ?>">More Info</a>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
			
		<?php endif; ?>
		<?php $post_repeater_story = get_sub_field( 'post_repeater_story' ); ?>
		<?php if ( $post_repeater_story ) : ?>
	<div class="d-flex flex-column align-items-center">
			<?php foreach ( $post_repeater_story as $story ) : 
		
			$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($story), array('220','220'), true );
    		$thumbnail_url = $thumbnail_url[0];
			
		?>
				<div>
			<div class="card w-50 text-center mb-2">
        <h5 class="card-header"> <?php echo get_the_title($story); ?></h5>
        <div class="card-body d-flex flex-column">
			<?php if (!empty($thumbnail_url)):?>
			<img src="<?php echo $thumbnail_url; ?>" class="d-block w-100 mb-2"></img>
			<?php else :  ?>
           <img src="<?php echo get_theme_file_uri(); ?> /img/no-photo-icon.png" class="d-block w-100 mb-2">
			<?php endif; ?>
			
			<a href="<?php echo get_permalink( $story ); ?>" class="nav-link"><button class="btn btn-warning text-white">View Story</button></a> 
			<br>
			<?php // echo get_the_title($story); ?>
				</div>
					</div>
			</div>
			<?php endforeach; ?>
	</div>
		<?php endif; ?>
			  
	<?php endwhile; ?>
<?php else : ?>
	<?php // no rows found ?>
<?php endif; ?>

          </div>
        </main>    <!-- #main --> 
    
   <p></p>
			    
      </div>    <!-- col -->
  
	
		<?php get_sidebar(); ?>

      
    </div>    <!--Main row End--> 

    
  

</div><!-- #content container end-->


<?php get_footer(); ?>
