<!-- Modal -->
<div class="modal fade" id="familyTree" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row row-cols-1">
            <div class="col text-center">
              <p class="h6">Parents</p>
              <?php
              $parents = get_field( 'person_parents' );
              if ( $parents ): ?>
              <div class="row row-cols-auto justify-content-center">
                <?php
                foreach ( $parents as $parent ):
                  $permalink = get_permalink( $parent->ID );
                $title = get_the_title( $parent->ID );
                ?>
                <div class="col"> <a href="<?php echo esc_url( $permalink ); ?>" class="nav-link"><?php echo esc_html( $title ); ?></a> </div>
                <?php endforeach; ?>
              </div>
              <?php else: ?>
              <p class="h5">Unknown</p>
              <?php endif; ?>
            </div>
            <div class="col text-center">
              <p class="h6">Siblings</p>
              <?php
              $parents = get_field( 'person_siblings' );
              if ( $parents ): ?>
              <div class="row row-cols-auto justify-content-evenly">
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
            <div class="col text-center">
              <p class="h6">Children</p>
              <?php
              $parents = get_field( 'person_children' );
              if ( $parents ): ?>
              <div class="row row-cols-auto justify-content-evenly">
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
        </div>
      </div>
    </div>
  </div>
</div>
