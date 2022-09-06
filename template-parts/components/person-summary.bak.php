<?php
global $post;

?>
<h5 class="h6">Born</h5>
                      <?php
                      $birth_date = get_field( 'person_birth' );
                      if ( $birth_date ): 
						
						?>
                      <?php
                      foreach ( $birth_date as $birth_day ):
                        $birthdate = get_field( 'event_date', $birth_day->ID );
					    $event_place = get_field( 'event_city', $birth_day->ID );
							if ( $event_place ):
                        foreach ( $event_place as $eventplace ):
                          $title = get_the_title( $eventplace->ID );
                      ?>
                      <div class=""><?php echo $title; ?></div>
                      <?php endforeach; else:?>
                      <p class="text-center">?</p>
                      <?php endif;;
                      ?>
                      <div class=""> <?php echo $birthdate; ?> </div>
                      <?php endforeach; ?>
                      <?php else: ?>
                      <p class="text-center">Unknown</p>
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
					   <div class=""><?php echo $title; ?></div>
                      <?php endforeach; else:?>
                      <p class="text-center">?</p>
                      <?php endif;
                    ?>
                    <div class=""> <?php echo $deathdate; ?> </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-center">Unknown</p>
                    <?php endif; ?>
                    </div>
                 