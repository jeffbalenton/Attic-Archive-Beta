<?php

?>
<h5 class="h6">Born</h5>
<?php
$person_birth = get_field( 'person_birth' );
if ( $person_birth ): ?>
<?php
foreach ( $person_birth as $birth_fact ):
  $birthdate = get_field( 'event_date', $birth_fact->ID );
$birth_place = get_field( 'event_city', $birth_fact->ID );
if ( $birth_place ):
  foreach ( $birth_place as $birthplace ):
    $title = get_the_title( $birthplace->ID );
?>
<?php echo $birthdate; ?>
<?php endforeach; else: echo 'Unknown';?>
<?php
endif;
?>
<div class="mb-2"> <?php echo $title; ?> </div>
<?php endforeach; ?>
<?php else: echo 'Unkown'; ?>
<?php endif; ?>
</div>
</div>
<div class="text-center d-grid">
  <h5 class="h6">Died</h5>
  <?php
  $death_date = get_field( 'person_death' );
  if ( $death_date ): ?>
  <?php
  foreach ( $death_date as $death_day ):
    $deathdate = get_field( 'event_date', $death_day->ID );
  $death_place = get_field( 'event_city', $death_day->ID );
  if ( $death_place ):
    foreach ( $death_place as $deathplace ):
      $title = get_the_title( $deathplace->ID );
  ?>
  <?php echo $deathdate; ?>
  <?php endforeach; else: echo 'Unknown';?>
  <?php
  endif;
  ?>
  <div class="mb-2"> <?php echo $title; ?> </div>
  <?php endforeach; ?>
  <?php else: echo "Unknown"; ?>
  <?php endif; ?>
</div>
<div class="text-center">
  <h6 class="h6">Generation</h6>
  <?php
  $term = get_field( 'person_generation' );
  if ( $term ): ?>

  <?php echo esc_html( $term->name ); ?>
  
  <?php endif; ?>
</div>
	  </div>
