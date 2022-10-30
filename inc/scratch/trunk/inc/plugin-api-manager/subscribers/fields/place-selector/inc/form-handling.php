<?php
    /**
     * Handle CSV upload form
     */
    function acfps_upload_csv_file() {
        if ( isset( $_POST[ 'acfps_upload_csv_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_upload_csv_nonce' ], 'acfps-upload-csv-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                ACF_Place_Selector::acfps_check_uploads_folder();
                $target_file = acfps_upload_folder( '/' ) . basename( $_FILES[ 'csv_upload' ][ 'name' ] );
                if ( move_uploaded_file( $_FILES[ 'csv_upload' ][ 'tmp_name' ], $target_file ) ) {
                    ACF_Place_Selector::acfps_errors()->add( 'success_file_uploaded', sprintf( esc_html__( "File '%s' is successfully uploaded and now shows under 'Select files to import'", 'acf-place-selector' ), $_FILES[ 'csv_upload' ][ 'name' ] ) );
                    do_action( 'acfps_after_success_file_upload' );

                    return;
                } else {
                    ACF_Place_Selector::acfps_errors()->add( 'error_file_uploaded', esc_html__( 'Upload failed. Please try again.', 'acf-place-selector' ) );

                    return;
                }
            }
        }
    }
    add_action( 'admin_init', 'acfps_upload_csv_file' );


    /**
     * Handle process CSV form
     */
    function acfps_do_something_with_file() {
        if ( isset( $_POST[ 'acfps_select_file_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_select_file_nonce' ], 'acfps-select-file-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_nonce_no_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                if ( empty( $_POST[ 'acfps_file_name' ] ) ) {
                    ACF_Place_Selector::acfps_errors()->add( 'error_no_file_selected', esc_html__( "You didn't select a file.", 'acf-place-selector' ) );

                    return;
                }

                $file_name = $_POST[ 'acfps_file_name' ];
                $delimiter = ! empty( $_POST[ 'acfps_delimiter' ] ) ? sanitize_text_field( $_POST[ 'acfps_delimiter' ] ) : apply_filters( 'acfps_delimiter', ';' );
                $max_lines = isset( $_POST[ 'acfps_max_lines' ] ) ? (int) $_POST[ 'acfps_max_lines' ] : false;
                $import    = isset( $_POST[ 'import' ] ) ? true : false;
                $remove    = isset( $_POST[ 'remove' ] ) ? true : false;
                $verify    = isset( $_POST[ 'verify' ] ) ? true : false;

                if ( true === $verify ) {
                    acfps_verify_data( $file_name, $delimiter, $verify );
                } elseif ( true === $import ) {
                    acfps_import_place_data( $file_name, '', $delimiter, $verify, $max_lines );
                } elseif ( true === $remove ) {
                    acfps_delete_file( $file_name );
                }
            }
        }
    }
    add_action( 'admin_init', 'acfps_do_something_with_file' );


    /**
     * Handle importing of raw CSV data
     */
    function acfps_import_raw_data() {
        if ( isset( $_POST[ 'acfps_import_raw_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_import_raw_nonce' ], 'acfps-import-raw-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                $verified_data = acfps_verify_csv_data( sanitize_textarea_field( $_POST[ 'acfps_raw_csv_import' ] ) );
                if ( isset( $_POST[ 'verify' ] ) ) {
                    if ( false != $verified_data ) {
                        ACF_Place_Selector::acfps_errors()->add( 'success_csv_valid', esc_html__( 'Congratulations, your CSV data seems valid.', 'acf-place-selector' ) );
                    }
                } elseif ( isset( $_POST[ 'import' ] ) ) {
                    if ( false != $verified_data ) {
                        acfps_import_data( $verified_data );
                    }
                }
            }
        }
    }
    add_action( 'admin_init', 'acfps_import_raw_data' );


    /**
     * Handle form to delete one or more countries
     */
    function acfps_delete_countries() {
        if ( isset( $_POST[ 'acfps_remove_countries_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_remove_countries_nonce' ], 'acfps-remove-countries-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                if ( empty( $_POST[ 'delete_country' ] ) ) {
                    ACF_Place_Selector::acfps_errors()->add( 'error_no_country_selected', esc_html__( "You didn't select any countries, please try again.", 'acf-place-selector' ) );

                    return;
                } else {
                    if ( is_array( $_POST[ 'delete_country' ] ) ) {
                        acfps_delete_country( $_POST[ 'delete_country' ] );
                    }
                }
            }
        }
    }
    add_action( 'admin_init', 'acfps_delete_countries' );


    /**
     * Form to delete individual rows/places
     */
    function acfps_delete_rows() {
        if ( isset( $_POST[ 'acfps_delete_row_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_delete_row_nonce' ], 'acfps-delete-row-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                global $wpdb;
                if ( is_array( $_POST[ 'row_id' ] ) ) {
                    foreach( $_POST[ 'row_id' ] as $row ) {
                        $sanitized_row = sanitize_text_field( $row );
                        $split    = explode( ' ', $sanitized_row, 2 );
                        if ( isset( $split[ 0 ] ) && isset( $split[ 1 ] ) ) {
                            $ids[]    = $split[ 0 ];
                            $places[] = $split[ 1 ];
                        }
                    }
                    $places  = implode( ', ', $places );
                    $row_ids = implode( ',', $ids );
                    $amount  = $wpdb->query("
                                DELETE FROM " . $wpdb->prefix . "places
                                WHERE id IN (" . $row_ids . ")
                            ");

                    if ( $amount > 0 ) {
                        ACF_Place_Selector::acfps_errors()->add( 'success_row_delete', sprintf( _n( 'You have deleted the city %s.', 'You have deleted the following places: %s.', $amount, 'acf-place-selector' ), $places ) );
                    }
                }
            }
        }
    }
    add_action( 'admin_init', 'acfps_delete_rows' );


    /**
     * Form to handle deleting of all transients
     */
    function acfps_delete_all_transients() {
        if ( isset( $_POST[ 'acfps_delete_transients' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_delete_transients' ], 'acfps-delete-transients-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                do_action( 'acfps_delete_transients' );
                ACF_Place_Selector::acfps_errors()->add( 'success_transients_delete', esc_html__( 'You have successfully deleted all transients.', 'acf-place-selector' ) );
            }
        }
    }
    add_action( 'admin_init', 'acfps_delete_all_transients' );


    /**
     * Delete contents of entire places table
     */
    function acfps_truncate_table() {
        if ( isset( $_POST[ 'acfps_truncate_table_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_truncate_table_nonce' ], 'acfps-truncate-table-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                global $wpdb;
                $prefix = $wpdb->get_blog_prefix();
                $wpdb->query( 'TRUNCATE TABLE ' . $prefix . 'places' );
                ACF_Place_Selector::acfps_errors()->add( 'success_table_truncated', esc_html__( 'All places are deleted.', 'acf-place-selector' ) );
                do_action( 'acfps_after_success_nuke' );
            }
        }
    }
    add_action( 'admin_init', 'acfps_truncate_table' );


    /**
     * Handle preserve settings option
     */
    function acfps_delete_settings() {
        if ( isset( $_POST[ 'acfps_remove_places_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_remove_places_nonce' ], 'acfps-remove-places-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                if ( isset( $_POST[ 'remove_places_table' ] ) ) {
                    update_option( 'acfps_delete_places_table', 1 );
                } else {
                    delete_option( 'acfps_delete_places_table' );
                }
                ACF_Place_Selector::acfps_errors()->add( 'success_settings_saved', esc_html__( 'Settings saved', 'acf-place-selector' ) );
            }
        }
    }
    add_action( 'admin_init', 'acfps_delete_settings' );


    /**
     * Manually import default available countries
     */
    function acfps_import_preset_countries() {
        if ( isset( $_POST[ 'acfps_import_actions_nonce' ] ) ) {
            if ( ! wp_verify_nonce( $_POST[ 'acfps_import_actions_nonce' ], 'acfps-import-actions-nonce' ) ) {
                ACF_Place_Selector::acfps_errors()->add( 'error_no_nonce_match', esc_html__( 'Something went wrong, please try again.', 'acf-place-selector' ) );

                return;
            } else {
                if ( isset( $_POST[ 'import_be' ] ) || isset( $_POST[ 'import_nl' ] ) ) {
                    if ( isset( $_POST[ 'import_be' ] ) && 1 == $_POST[ 'import_be' ] ) {
                        acfps_import_data( 'be.csv', acfps_PLUGIN_PATH . 'import/' );
                        do_action( 'acfps_delete_transients', 'be' );
                    }
                    if ( isset( $_POST[ 'import_nl' ] ) && 1 == $_POST[ 'import_nl' ] ) {
                        acfps_import_data( 'nl.csv', acfps_PLUGIN_PATH . 'import/' );
                        do_action( 'acfps_delete_transients', 'nl' );
                    }
                    do_action( 'acfps_after_success_import' );
                }
            }
        }
    }
    add_action( 'admin_init', 'acfps_import_preset_countries' );
