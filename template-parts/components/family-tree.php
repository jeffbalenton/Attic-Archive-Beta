<?php

?>
<!-- Modal -->
<div class="modal fade" id="familyTree" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
		<p class="text-center">Parents</p>
              <?php
              $parents = get_field( 'person_parents' );
              if ( $parents ): ?>
              <div class="row row-cols-2">
				
                <?php
                foreach ( $parents as $parent ):
                  $permalink = get_permalink( $parent->ID );
                $title = get_the_title( $parent->ID );
                ?>
                <div class="col"> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                <?php endforeach; ?>
              </ul>
				<?php else: ?>
				<p class="text-center">Unknown</p>
              <?php endif; ?>
             <p class="text-center">Siblings</p>
              <?php
              $parents = get_field( 'person_siblings' );
              if ( $parents ): ?>
              <div class="row-cols-3">
				
                <?php
                foreach ( $parents as $parent ):
                  $permalink = get_permalink( $parent->ID );
                $title = get_the_title( $parent->ID );
                ?>
                <div class="col"> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                <?php endforeach; ?>
              </div>
				<?php else: ?>
				<p class="text-center">Unknown</p>
              <?php endif; ?>
            </div>
			  <p class="text-center">Children</p>
              <?php
              $parents = get_field( 'person_children' );
              if ( $parents ): ?>
              <div class="row row-cols-3">
				
                <?php
                foreach ( $parents as $parent ):
                  $permalink = get_permalink( $parent->ID );
                $title = get_the_title( $parent->ID );
                ?>
                <div class="col"> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                <?php endforeach; ?>
              </div>
				<?php else: ?>
				<p class="text-center">Unknown</p>
              <?php endif; ?>
          </div>
        </div>
      
      <div class="modal-footer"> <p='text-center'>Under Construction </p></div>
    </div>
  </div>
</div>

