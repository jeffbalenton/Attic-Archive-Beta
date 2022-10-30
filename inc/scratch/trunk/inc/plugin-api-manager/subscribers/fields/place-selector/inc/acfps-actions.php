<?php
    /**
     * Function to delete transients
     *
     * @param false $country_code
     */
    function acfps_delete_transients( $country_code = false ) {
        if ( false != $country_code ) {
            delete_transient( 'acfps_states_' . strtolower( $country_code ) );
            delete_transient( 'acfps_places_' . strtolower( $country_code ) );
        } else {
            delete_transient( 'acfps_countries' );
            // get all countries
            $countries = acfps_get_countries( false, false, true );
            if ( ! empty( $countries ) ) {
                foreach( $countries as $country_code => $label ) {
                    do_action( 'acfps_delete_transients', $country_code );
                }
            }
        }
    }
    add_action( 'acfps_delete_transients', 'acfps_delete_transients' );
    add_action( 'acfps_after_success_import', 'acfps_delete_transients' );
    add_action( 'acfps_after_success_import_raw', 'acfps_delete_transients' );
    add_action( 'acfps_after_success_nuke', 'acfps_delete_transients' );
