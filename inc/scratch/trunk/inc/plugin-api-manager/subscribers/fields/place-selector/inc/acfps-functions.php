<?php
    // function to check for field values
    include 'acfps-field-settings.php';

    /**
     * Create an array with available countries from db.
     * This function makes use of a transient to speed up the process.
     *
     * @param false $show_first
     * @param false $field
     * @param false $force
     *
     * @return array
     */
    function acfps_get_countries( $show_first = true, $field = false, $force = false ) {

        $countries            = array();
        $select_country_label = apply_filters( 'acfps_select_country_label', esc_html__( 'Select a country', 'acf-place-selector' ) );
        $show_labels          = ( isset( $field[ 'show_labels' ] ) ) ? $field[ 'show_labels' ] : true;

        if ( $show_first ) {
            $countries[ '' ] = '-';
            if ( ! $show_labels ) {
                $countries[ '' ] = $select_country_label;
            }
        }

        $transient = get_transient( 'acfps_countries' );
        if ( false != $force || false == $transient || is_array( $transient ) && empty( $transient ) ) {
            global $wpdb;
            $results = $wpdb->get_results( '
                SELECT * FROM ' . $wpdb->prefix . 'places
                GROUP BY country
                ORDER BY country ASC
            ' );

            $country_results = array();
            foreach ( $results as $data ) {
                if ( isset( $data->country_code ) && isset( $data->country ) ) {
                    $country_results[ $data->country_code ] = esc_html__( $data->country, 'acf-place-selector' );
                }
            }

            set_transient( 'acfps_countries', $country_results, DAY_IN_SECONDS );
            $countries = array_merge( $countries, $country_results );

        } elseif ( is_array( $transient ) ) {
            $countries = array_merge( $countries, $transient );
        }

        return $countries;
    }


    /**
     * Create an array with states based on a country code
     *
     * @param false $country_code
     * @param false $show_first
     * @param false $field
     *
     * @return array
     */
    function acfps_get_states( $country_code = false, $show_first = true, $field = false ) {

        $select_province_state_label = apply_filters( 'acfps_select_province_state_label', esc_attr__( 'Select a province/state', 'acf-place-selector' ) );
        $show_labels                 = ( isset( $field[ 'show_labels' ] ) ) ? $field[ 'show_labels' ] : true;
        $states                      = array();

        if ( $show_first ) {
            if ( $show_labels ) {
                $states[ '' ] = '-';
            } else {
                $states[ '' ] = $select_province_state_label;
            }
        }

        if ( false != $country_code ) {
            $transient = get_transient( 'acfps_states_' . strtolower( $country_code ) );
            if ( false == $transient || is_array( $transient ) && empty( $transient ) ) {
                $order = 'ORDER BY state_name ASC';
                if ( 'FR' == $country_code ) {
                    $order = "ORDER BY LENGTH(state_name), state_name";
                }

                global $wpdb;
                $sql = $wpdb->prepare( "
                    SELECT *
                    FROM " . $wpdb->prefix . "places
                    WHERE country_code = %s
                    GROUP BY state_code
                    " . $order, strtoupper( $country_code )
                );
                $results = $wpdb->get_results( $sql );

                $state_results = array();
                foreach ( $results as $data ) {
                    $state_results[ $country_code . '-' . $data->state_code ] = esc_attr__( $data->state_name, 'acf-place-selector' );
                }

                set_transient( 'acfps_states_' . strtolower( $country_code ), $state_results, DAY_IN_SECONDS );

                $states = array_merge( $states, $state_results );

            } else {
                $states = array_merge( $states, $transient );
            }
        }

        return $states;
    }


    /**
     * Create an array with places for a certain country/state
     *
     * @param false $country_code
     * @param false $state_code
     * @param false $field
     *
     * @return array
     */
    function acfps_get_places( $country_code = false, $state_code = false, $field = false ) {

        $places            = array();
        $places_transient  = false;
        $select_city_label = apply_filters( 'acfps_select_city_label', esc_attr__( 'Select a city', 'acf-place-selector' ) );
        $set_transient     = false;
        $show_labels       = ( isset( $field[ 'show_labels' ] ) ) ? $field[ 'show_labels' ] : true;

        if ( $show_labels ) {
            $places[ '' ] = '-';
        } else {
            $places[ '' ] = $select_city_label;
        }

        if ( $country_code && ! $state_code ) {
            $places_transient = get_transient( 'acfps_places_' . strtolower( $country_code ) );
        } elseif ( $country_code && $state_code ) {
            $places_transient = get_transient( 'acfps_places_' . strtolower( $country_code ) . '-' . strtolower( $state_code ) );
        }

        if ( false == $places_transient || empty( $places_transient ) ) {
            $set_transient = true;
        } else {
            foreach ( $places_transient as $data ) {
                $city_array[ esc_attr__( $data, 'acf-place-selector' ) ] = esc_attr__( $data, 'acf-place-selector' );
            }
            if ( isset( $city_array ) ) {
                $places = array_merge( $places, $city_array );
            }
        }

        if ( $set_transient ) {
            if ( false !== $country_code ) {
                global $wpdb;
                $query = 'SELECT * FROM ' . $wpdb->prefix . 'places';
                if ( $country_code && $state_code ) {
                    if ( 3 < strlen( $state_code ) ) {
                        $state_code = substr( $state_code, 3 );
                    }
                    $query .= " WHERE country_code = '{$country_code}' AND state_code = '{$state_code}'";
                    $query .= " ORDER BY state_name, city_name ASC";
                } elseif ( $country_code ) {
                    $query .= " WHERE country_code = '{$country_code}'";
                }
                $city_results = array();
                $results      = $wpdb->get_results( $query );
                foreach ( $results as $data ) {
                    $city_results[] = [
                        'city_name' => $data->city_name,
                    ];
                }

                if ( ! empty( $city_results ) ) {
                    uasort( $city_results, 'acfps_sort_array_with_quotes' );
                }
                foreach ( $city_results as $data ) {
                    $city_array[ esc_attr__( $data[ 'city_name' ], 'acf-place-selector' ) ] = esc_attr__( $data[ 'city_name' ], 'acf-place-selector' );
                }
                if ( isset( $city_array ) ) {
                    $places = array_merge( $places, $city_array );
                }
                if ( ! $state_code ) {
                    set_transient( 'acfps_places_' . strtolower( $country_code ), $city_array, DAY_IN_SECONDS );
                } elseif ( $state_code ) {
                    set_transient( 'acfps_places_' . strtolower( $country_code ) . '-' . strtolower( $state_code ), $city_array, DAY_IN_SECONDS );
                }
            }
        }

        return $places;

    }


    /**
     * Get country name by country code
     *
     * @param $country_code
     *
     * @return mixed
     */
    function acfps_get_country_name( $country_code = false ) {

        if ( false != $country_code ) {
            global $wpdb;
            $country = $wpdb->get_row( $wpdb->prepare( "SELECT country FROM {$wpdb->prefix}places WHERE country_code = %s", $country_code ) );
            if ( isset( $country->country ) ) {
                return $country->country;
            } else {
                $country_name = acfps_country_i18n( $country_code );
                if ( $country_code != $country_name ) {
                    return $country_name;
                }
            }
        }

        return $country_code;

    }


    /**
     * Checks if there any places in the database (for page availability)
     *
     * @return bool
     */
    function acfps_has_places() {
        global $wpdb;
        $results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'places LIMIT 1' );

        if ( count( $results ) > 0 ) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Checks if files are uploaded
     *
     * @return array
     */
    function acfps_check_if_files() {
        $target_dir = acfps_upload_folder();
        if ( is_dir( $target_dir ) ) {
            $file_index = scandir( $target_dir );
            $excluded_files = [
                '.',
                '..',
                '.DS_Store',
                'debug.json',
            ];

            if ( is_array( $file_index ) ) {
                $actual_files = array();
                foreach ( $file_index as $file ) {
                    if ( ! in_array( $file, $excluded_files ) ) {
                        $actual_files[] = $file;
                    }
                }
                if ( ! empty( $actual_files ) ) {
                    return $actual_files;
                }
            }
        }

        return array();
    }


    /**
     * Convert data from an uploaded CSV file to an array
     *
     * @param        $file_name
     * @param string $delimiter
     * @param string $upload_folder
     * @param false  $verify
     * @param false  $max_lines
     *
     * @return array|WP_Error
     */
    function acfps_csv_to_array( $file_name, $upload_folder = '', $delimiter = ';', $verify = false, $max_lines = false ) {

        $upload_folder = ( ! empty( $upload_folder ) ) ? $upload_folder : acfps_upload_folder( '/' );

        $csv_array   = array();
        $empty_array = false;
        $new_array   = array();
        if ( ( file_exists( $upload_folder . $file_name ) && $handle = fopen( $upload_folder . $file_name, "r" ) ) !== false ) {
            $column_benchmark = 5;
            $line_number      = 0;

            while ( ( $csv_line = fgetcsv( $handle, apply_filters( 'acfps_line_length', 1000 ), "{$delimiter}" ) ) !== false ) {
                $line_number++;
                $csv_array[ 'delimiter' ] = $delimiter;

                // if column count doesn't match benchmark
                if ( count( $csv_line ) != $column_benchmark ) {
                    // if column count < benchmark
                    if ( count( $csv_line ) < $column_benchmark ) {
                        $error_message = esc_html__( 'Since your file is not accurate anymore, the file is deleted.', 'acf-place-selector' );
                        ACF_Place_Selector::acfps_errors()->add( 'error_no_correct_columns_' . $line_number, sprintf( esc_html__( 'There are too few columns on line %d. %s', 'acf-place-selector' ), $line_number, $error_message ) );

                    } elseif ( count( $csv_line ) > $column_benchmark ) {
                        // if column count > benchmark
                        $error_message = esc_html__( 'Since your file is not accurate anymore, the file is deleted.', 'acf-place-selector' );
                        if ( false === $verify ) {
                            $error_message = 'Lines 0-' . ( $line_number - 1 ) . ' are correctly imported but since your file is not accurate anymore, the file is deleted';
                        }
                        ACF_Place_Selector::acfps_errors()->add( 'error_no_correct_columns_' . $line_number, sprintf( esc_html__( 'There are too many columns on line %d. %s', 'acf-place-selector' ), $line_number, $error_message ) );
                    }
                }

                if ( ACF_Place_Selector::acfps_errors()->get_error_codes() ) {
                    $empty_array = true;
                    $new_array   = array();
                } else {
                    // create a new array for each row
                    $new_line = array();
                    foreach ( $csv_line as $item ) {
                        $new_line[] = $item;
                    }
                    if ( ! empty( $new_line ) ) {
                        $new_array[] = $new_line;
                    }

                    if ( false != $max_lines ) {
                        if ( $line_number == $max_lines ) {
                            break;
                        }
                    }
                }
            }
            fclose( $handle );
    
            if ( ACF_Place_Selector::acfps_errors()->get_error_codes() ) {
                // delete file
                if ( file_exists( acfps_upload_folder( '/' ) . $file_name ) ) {
                    unlink( acfps_upload_folder( '/' ) . $file_name );
                    $csv_array[ 'error' ] = 'file_deleted';
                }
            }
    
            /**
             * Don't add data if there are any errors. This to prevent rows which had no error from outputting
             * on the preview page.
             */
            if ( ! empty( $new_array ) && false === $empty_array ) {
                $csv_array[ 'data' ] = array_values( $new_array );
            }
        }

        return $csv_array;
    }


    /**
     * Verify raw csv import
     *
     * @param false  $csv_data
     * @param string $delimiter
     *
     * @return array|false
     */
    function acfps_verify_csv_data( $csv_data = false, $delimiter = ";" ) {

        if ( false != $csv_data ) {
            $column_benchmark = 5;
            $line_number      = 0;
            $lines            = explode( "\r\n", $csv_data );

            foreach ( $lines as $line ) {
                $line_number++;

                if ( ! is_array( $csv_data ) ) {
                    $line_array = explode( $delimiter, $line );
                }

                if ( count( $line_array ) != $column_benchmark ) {
                    // length of a line is not correct
                    if ( count( $line_array ) < $column_benchmark ) {
                        ACF_Place_Selector::acfps_errors()->add( 'error_no_correct_columns', sprintf( esc_html__( 'There are too few columns on line %d.', 'acf-place-selector' ), $line_number ) );

                        return false;

                    } elseif ( count( $line_array ) > $column_benchmark ) {
                        ACF_Place_Selector::acfps_errors()->add( 'error_no_correct_columns', sprintf( esc_html__( 'There are too many columns on line %d.', 'acf-place-selector' ), $line_number ) );

                        return false;
                    }
                }

                $column_counter = 0;
                foreach( $line_array as $element ) {
                    $column_counter++;
                    if ( $column_counter == 4 ) {
                        if ( 2 != strlen( $element ) ) {
                            ACF_Place_Selector::acfps_errors()->add( 'error_wrong_country_length', sprintf( esc_html__( 'The length of the country abbreviation on line %d is incorrect.', 'acf-place-selector' ), $line_number ) );

                            return false;
                        }
                    }
                }
                $validated_data[] = $line_array;
            }

            return $validated_data;
        }

        return false;
    }


    /**
     * Get packages through WP_Http
     *
     * @return array|mixed
     */
    function acfps_get_packages( $endpoint = 'single' ) {

        $url     = acfps_WEBSITE_URL . '/wp-json/countries/v1/' . $endpoint;
        $request = new WP_Http;
        $result  = $request->request( $url, array( 'method' => 'GET' ) );
        if ( 200 == $result[ 'response' ][ 'code' ] ) {
            $response = json_decode( $result[ 'body' ] );

            return $response;
        }

        return array();
    }


    /**
     * Get country info for debug
     *
     * @return array
     */
    function acfps_get_countries_info() {

        global $wpdb;
        $results = $wpdb->get_results( '
                SELECT country_code FROM ' . $wpdb->prefix . 'places
                GROUP BY country_code
                ORDER BY country_code ASC
            ' );

        $acfps_info = array();
        foreach ( $results as $data ) {
            $country_code = $data->country_code;
            $results      = $wpdb->get_results( $wpdb->prepare( '
                SELECT * FROM ' . $wpdb->prefix . 'places
                WHERE country_code = %s
                ORDER BY country_code ASC
            ', $country_code ) );

            $acfps_info[ $country_code ] = [
                'country_code' => $country_code,
                'count'        => count( $results ),
                'name'         => acfps_get_country_name( $country_code ),
            ];
        }

        return $acfps_info;
    }


    /**
     * Search an array which contains quotes like "'t Veld"
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    function acfps_sort_array_with_quotes( $a, $b ) {
        return strnatcasecmp( acfps_custom_sort_with_quotes( $a[ 'city_name' ] ), acfps_custom_sort_with_quotes( $b[ 'city_name' ] ) );
    }


    /**
     * Sort with quotes
     *
     * @param $city
     *
     * @return string|string[]|null
     */
    function acfps_custom_sort_with_quotes( $city ) {
        // strip quote marks
        $city = trim( $city, '\'s ' );
        $city = preg_replace( '/^\s*\'s \s+/i', '', $city );

        return $city;
    }


    /**
     * Render select in ACF field
     *
     * @param $type
     * @param $field
     * @param $stored_value
     * @param $prefill_values
     *
     * @return false|string
     */
    function acfps_render_dropdown( $type, $field, $stored_value, $prefill_values ) {

        $acfps_dropdown       = 'acfps__dropdown';
        $city_label           = apply_filters( 'acfps_select_city_label', esc_attr__( 'Select a city', 'acf-place-selector' ) );
        $countries            = acfps_get_countries( true, $field );
        $country_label        = apply_filters( 'acfps_select_country_label', esc_attr__( 'Select a country', 'acf-place-selector' ) );
        $default_country      = ( isset( $field[ 'default_country' ] ) && ! empty( $field[ 'default_country' ] ) ) ? $field[ 'default_country' ] : false;
        $default_value        = false;
        $field_id             = $field[ 'id' ];
        $field_name           = $field[ 'name' ];
        $prefill_places       = $prefill_values[ 'prefill_places' ];
        $prefill_states       = $prefill_values[ 'prefill_states' ];
        $province_state_label = apply_filters( 'acfps_select_province_state_label', esc_attr__( 'Select a province/state', 'acf-place-selector' ) );
        $selected_selected    = ' selected="selected"';
        $show_labels          = ( isset( $field[ 'show_labels' ] ) ) ? $field[ 'show_labels' ] : true;
        $use_select2          = ( isset( $field[ 'use_select2' ] ) ) ? $field[ 'use_select2' ] : false;
        $dropdown_class       = ( true == $use_select2 ) ? 'select2 ' . $acfps_dropdown : $acfps_dropdown;
        $data_label_value     = ( true == $show_labels ) ? '1' : '0';
        $which_fields         = ( isset( $field[ 'which_fields' ] ) ) ? $field[ 'which_fields' ] : 'all';

        switch( $type ) {
            case 'country':
                $default_value  = $default_country;
                $field_label    = $country_label;
                $field_suffix   = 'countryCode';
                $modifier       = 'countries';
                $selected_value = esc_attr( $stored_value );
                $values         = $countries;
                break;
            case 'state':
                $field_label    = $province_state_label;
                $field_suffix   = 'stateCode';
                $modifier       = 'states';
                $selected_value = esc_attr( $stored_value );
                $values         = $prefill_states;
                break;
            case 'city':
                $field_label    = $city_label;
                $field_suffix   = 'cityName';
                $modifier       = 'places';
                $selected_value = esc_attr( $stored_value );
                $values         = $prefill_places;
                break;
        }
        $dropdown_class = $dropdown_class . ' ' . $acfps_dropdown . '--' . $modifier;

        ob_start();
        ?>
        <div class="acfps__dropdown-box acfps__dropdown-box--<?php echo $modifier; ?>">
            <?php if ( $show_labels ) { ?>
                <div class="acf-input-header">
                    <?php echo $field_label; ?>
                </div>
            <?php } ?>
            <label for="<?php echo $field_id . $field_suffix; ?>" class="screen-reader-text">
                <?php echo $field_label; ?>
            </label>
            <select name="<?php echo $field_name; ?>[<?php echo $field_suffix; ?>]" id="<?php echo $field_id . $field_suffix; ?>" class="<?php echo $dropdown_class; ?>" data-show-labels="<?php echo $data_label_value; ?>" data-which-fields="<?php echo $which_fields; ?>">
                <?php
                    if ( ! empty( $values ) ) {
                        foreach ( $values as $key => $label ) {
                            if ( false !== $selected_value ) {
                                $selected = ( $selected_value == $key ) ? $selected_selected : false;
                            } elseif ( ! empty( $default_value ) ) {
                                // only when a default country is set
                                $selected = ( $default_value == $key ) ? $selected_selected : false;
                            } else {
                                $selected = false;
                            }
                            echo '<option value="' . $key . '"' . $selected . '>' . $label . '</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <?php
        $dropdown = ob_get_clean();

        return $dropdown;
    }


    /**
     * Verify CSV data
     *
     * @param        $file_name
     * @param string $delimiter
     * @param bool   $verify
     */
    function acfps_verify_data( $file_name, $delimiter = ';', $verify = true ) {
        $csv_array = acfps_csv_to_array( $file_name, '', $delimiter, $verify );
        if ( isset( $csv_array[ 'data' ] ) ) {
            ACF_Place_Selector::acfps_errors()->add( 'success_no_errors_in_csv', sprintf( esc_html__( 'Congratulations, there appear to be no errors in CSV file: "%s".', 'acf-place-selector' ), $file_name ) );

            do_action( 'acfps_after_success_verify' );

            return;
        }
    }


    /**
     * Import CSV data
     *
     * @param        $file_name
     * @param string $upload_folder
     * @param string $delimiter
     * @param false  $verify
     * @param false  $max_lines
     */
    function acfps_import_data( $file_name, $upload_folder = '', $delimiter = ';', $verify = false, $max_lines = false ) {
        if ( $file_name ) {
            if ( strpos( $file_name, '.csv', -4 ) !== false ) {
                $csv_array = acfps_csv_to_array( $file_name, $upload_folder, $delimiter, $verify, $max_lines );

                if ( ! is_wp_error( $csv_array ) ) {
                    if ( isset( $csv_array[ 'data' ] ) && ! empty( $csv_array[ 'data' ] ) ) {
                        $line_number = 0;
                        foreach ( $csv_array[ 'data' ] as $line ) {
                            $line_number++;

                            $city_row = array(
                                'city_name'    => $line[ 0 ],
                                'state_code'   => $line[ 1 ],
                                'state_name'   => $line[ 2 ],
                                'country_code' => $line[ 3 ],
                                'country'      => $line[ 4 ],
                            );

                            global $wpdb;
                            $wpdb->insert( $wpdb->prefix . 'places', $city_row );
                        }
                        if ( in_array( $file_name, [ 'be.csv', 'nl.csv' ] ) ) {
                            $country_code = substr( $file_name, 0, 2 );
                            ACF_Place_Selector::acfps_errors()->add( 'success_lines_imported_' . $country_code, sprintf( esc_html__( 'You have successfully imported %d places from "%s".', 'acf-place-selector' ), $line_number, $file_name ) );
                        } else {
                            ACF_Place_Selector::acfps_errors()->add( 'success_lines_imported', sprintf( esc_html__( 'You have successfully imported %d places from "%s".', 'acf-place-selector' ), $line_number, $file_name ) );
                        }

                        do_action( 'acfps_after_success_import' );
                    }
                }
            } else {
                // raw data
                global $wpdb;
                $line_number   = 0;
                $verified_data = $file_name;

                foreach ( $verified_data as $line ) {
                    $line_number++;

                    $city_row = array(
                        'city_name'    => $line[ 0 ],
                        'state_code'   => $line[ 1 ],
                        'state_name'   => $line[ 2 ],
                        'country_code' => $line[ 3 ],
                        'country'      => $line[ 4 ],
                    );

                    $wpdb->insert( $wpdb->prefix . 'places', $city_row );
                }
                ACF_Place_Selector::acfps_errors()->add( 'success_places_imported', sprintf( _n( 'Congratulations, you imported 1 city.', 'Congratulations, you imported %d places.', $line_number, 'acf-place-selector' ), $line_number ) );

                do_action( 'acfps_after_success_import_raw' );
            }

        } else {
            ACF_Place_Selector::acfps_errors()->add( 'error_no_file_selected', esc_html__( "You didn't select a file.", 'acf-place-selector' ) );
        }

    }


  /**
     * Import Place CSV data
     *
     * @param        $file_name
     * @param string $upload_folder
     * @param string $delimiter
     * @param false  $verify
     * @param false  $max_lines
     */
    function acfps_import_place_data( $filename, $upload_folder = '', $delimiter = ';', $verify = false, $max_lines = false ) {
		
		
        }



    /**
     * Remove an uploaded file
     *
     * @param false $file_name
     */
    function acfps_delete_file( $file_name = false ) {
        if ( false != $file_name ) {
            if ( file_exists( acfps_upload_folder( '/' ) . $file_name ) ) {
                $delete_result = unlink( acfps_upload_folder( '/' ) . $file_name );
                if ( true === $delete_result ) {
                    ACF_Place_Selector::acfps_errors()->add( 'success_file_deleted', sprintf( esc_html__( 'File "%s" successfully deleted.', 'acf-place-selector' ), $file_name ) );
                    do_action( 'acfps_after_success_file_delete' );
                } else {
                    ACF_Place_Selector::acfps_errors()->add( 'error_file_deleted', sprintf( esc_html__( 'File "%s" is not deleted. Please try again.', 'acf-place-selector' ), $file_name ) );
                }
            }
        }

        return;
    }


    /**
     * Delete one or more countries
     *
     * @param $countries
     */
    function acfps_delete_country( $countries ) {

        $country_names_and       = false;
        $sanitized_country_codes = array();
        foreach( $countries as $country_code ) {
            $sanitized_country_code    = sanitize_text_field( $country_code );
            $sanitized_country_codes[] = $sanitized_country_code;
            $country_names[]           = acfps_get_country_name( $sanitized_country_code );
        }
        if ( ! empty( $country_names ) ) {
            $country_names_quotes = "'" . implode( "', '", $country_names ) . "'";
            if ( 1 < count( $country_names ) ) {
                $country_names_and = substr_replace( $country_names_quotes, ' and', strrpos( $country_names_quotes, ',' ), 1 );
            } else {
                $country_names_and = $country_names_quotes;
            }
        }

        if ( ! empty( $sanitized_country_codes ) ) {
            global $wpdb;
            $country_string = strtoupper( "'" . implode( "', '", $sanitized_country_codes ) . "'" );
            $query          = "DELETE FROM {$wpdb->prefix}places WHERE `country_code` IN ({$country_string})";
            $result         = $wpdb->query( $query );
            if ( $result > 0 ) {
                ACF_Place_Selector::acfps_errors()->add( 'success_country_remove', sprintf( esc_html__( 'You have successfully removed all entries for %s.', 'acf-place-selector' ), $country_names_and ) );
                foreach( $countries as $country_code ) {
                    do_action( 'acfps_delete_transients', $country_code );
                }
            }
        }
    }


    /**
     * Get upload folder for plugin, can be overriden with filter
     *
     * @param false $suffix
     *
     * @return mixed|void
     */
    function acfps_upload_folder( $suffix = false ) {
        $upload_folder = apply_filters( 'acfps_upload_folder', wp_upload_dir()[ 'basedir' ] . '/acfps' . $suffix );

        return $upload_folder;
    }
