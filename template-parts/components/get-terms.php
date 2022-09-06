
<?php
$terms = get_terms( 'lineage' );

echo '<ul class="nav flex-column">';

foreach ( $terms as $term ) {

// The $term is an object, so we don't need to specify the $taxonomy.
$term_link = get_term_link( $term );

// If there was an error, continue to the next term.
if ( is_wp_error( $term_link ) ) {
  continue;
}

echo '<li class="nav-item h6"><a class="nav-link" href="' . esc_url( $term_link ) . ' ">' . $term->name . ( " ($term->count)" ) . '</a></li>';
}

echo '</ul>';

?>
