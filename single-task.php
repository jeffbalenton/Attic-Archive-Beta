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
    <div class="col-sm-3">
      <div class="d-grid gap-3">
        <div class="p-2 text-center">
          <h4 class="h-4">Date Added</h4>
          <?php
          $date_created = date_create( "$post->post_date" );
          $date_created = date_format( $date_created, "M j, Y" );
          echo $date_created ?>
          <h4 class="h-4">Date Updated</h4>
          <?php
          $date_modified = date_create( "$post->post_modified" );
          $date_modified = date_format( $date_modified, "M j, Y" );
          echo $date_modified ?>
          <h4 class="h-4">Priority</h4>
          <p class="text-center">
            <?php the_field('task_priority'); ?>
          </p>
          <h4 class="h-4">Status</h4>
          <p class="text-center">
            <?php the_field('task_status'); ?>
          </p>
        </div>
      </div>
    </div>
    <div id="content-area" class="col-sm-5">
      <div class="d-grid gap-2 text-center">
        <h4 class='h4'>People</h4>
		  <?php $task_person = get_field( 'task_person' ); ?>
<?php if ( $task_person ) : ?>
	<?php foreach ( $task_person as $post_ids ) : ?>
		<a href="<?php echo get_permalink( $post_ids ); ?>" class="btn btn-sm btn-secondary text-white"><?php echo get_the_title( $post_ids ); ?></a>
	<?php endforeach; ?>
<?php else:
		  _e("No people Related to task");
		  endif; ?>
        <h4 class='h4'>Places</h4>
		  <?php $task_place = get_field( 'task_place' ); ?>
<?php if ( $task_place ) : ?>
	<?php foreach ( $task_place as $post_ids ) : ?>
		<a href="<?php echo get_permalink( $post_ids ); ?>"  class="btn btn-sm btn-secondary text-white"><?php echo get_the_title( $post_ids ); ?></a>
	<?php endforeach; ?>
<?php else:
	     _e("No places Related to task");
		  endif; ?>
        <h4 class='h4'>Events</h4>
		  <?php $task_event = get_field( 'task_event' ); ?>
<?php if ( $task_event ) : ?>
	<?php foreach ( $task_event as $post_ids ) : ?>
		<a href="<?php echo get_permalink( $post_ids ); ?>"  class="btn btn-sm btn-secondary text-white"><?php echo get_the_title( $post_ids ); ?></a>
	<?php endforeach; ?>
<?php else:
	     _e("No events Related to task");
		  endif; ?>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="d-grid gap-2 text-center">
        <h4 class='h4'>Task Description</h4>
        <?php
        $description = get_field( 'task_description' );

        if ( $description ):
          the_field( 'task_description' );
        else :
          _e( "N/A" );
        endif;

        ?>
        <h4 class='h4'>Task Bookmarks</h4>
        <?php $task_bookmark = get_field( 'task_bookmark' ); ?>
        <?php if ( $task_bookmark ) : ?>
        <?php foreach ( $task_bookmark as $post_ids ) : ?>
        <a href="<?php echo get_permalink( $post_ids ); ?>"><?php echo get_the_title( $post_ids ); ?></a>
        <?php endforeach; ?>
        <?php else:
		      _e("No Bookmarks related to task");
		  
		  endif; ?>
        <h4 class='h4'>Research Notes</h4>
		  <?php if ( have_rows( 'note_repeater' ) ) : ?>
	<?php while ( have_rows( 'note_repeater' ) ) : the_row(); ?>
		<?php the_sub_field( 'note_date' ); ?>
		<?php the_sub_field( 'note_content' ); ?>
		<?php the_sub_field( 'note_source' ); ?>
	<?php endwhile; ?>
<?php else : ?>
	<?php _e("No research notes have been added to task"); ?>
<?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
