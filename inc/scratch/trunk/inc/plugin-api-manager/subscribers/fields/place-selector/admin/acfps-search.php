<?php
    /*
     * Content for the search page
     */
    function acfps_search() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
        }

        ACF_Place_Selector::acfps_show_admin_notices();

        // get all countries from database
        global $wpdb;
        $places                  = array();
        $countries               = array();
        $search_criteria_state   = ( isset( $_POST[ 'acfps_state' ] ) ) ? sanitize_text_field( $_POST[ 'acfps_state' ] ) : false;
        $search_criteria_country = ( isset( $_POST[ 'acfps_country' ] ) ) ? sanitize_text_field( $_POST[ 'acfps_country' ] ) : false;
        $searched_orderby        = ( ! empty( $_POST[ 'acfps_orderby' ] ) ) ? sanitize_text_field( $_POST[ 'acfps_orderby' ] ) : false;
        $searched_term           = ( ! empty( $_POST[ 'acfps_search' ] ) ) ? sanitize_text_field( $_POST[ 'acfps_search' ] ) : false;
        $selected_limit          = ( ! empty( $_POST[ 'acfps_limit' ] ) ) ? (int) $_POST[ 'acfps_limit' ] : 100;

        // get places by country
        $results = acfps_get_countries( false );

        // if there is at least 1 country
        if ( ! empty( $results ) ) {
            foreach ( $results as $country_code => $label ) {
                $countries[] = [
                    'code' => $country_code,
                    'name' => esc_attr__( $label, 'acf-place-selector' ),
                ];
            }

            // get states for these countries
            if ( ! empty( $countries ) ) {
                $states = array();
                foreach ( $countries as $country ) {
                    $states[] = array(
                        'state' => 'open_optgroup',
                        'name'  => esc_attr__( acfps_get_country_name( $country[ 'code' ] ), 'acf-place-selector' ),
                    );
                    $order = 'ORDER BY state_name ASC';
                    if ( 'FR' == $country[ 'code' ] ) {
                        $order = "ORDER BY LENGTH(state_name), state_name";
                    }
                    $sql = $wpdb->prepare( "
                        SELECT *
                        FROM " . $wpdb->prefix . "places
                        WHERE country_code = %s
                        GROUP BY state_code
                        " . $order, $country[ 'code' ]
                    );
                    $results = $wpdb->get_results( $sql );

                    if ( count( $results ) > 0 ) {
                        foreach ( $results as $data ) {
                            $states[] = array(
                                'state' => strtolower( $data->country_code ) . '-' . strtolower( $data->state_code ),
                                'name'  => esc_attr__( $data->state_name, 'acf-place-selector' ),
                            );
                        }
                    }
                    $states[] = array(
                        'state' => 'close_optgroup',
                        'name'  => '',
                    );
                }
            }
        }

        // if has searched
        if ( isset( $_POST[ 'acfps_search_form' ] ) ) {
            $search_limit = false;
            $where        = array();

            if ( false != $search_criteria_state ) {
                $where[] = "state_code = '" . substr( $search_criteria_state, 3, 3) . "' AND country_code = '" . substr( $search_criteria_state, 0, 2) . "'";
            } elseif ( false != $search_criteria_country ) {
                $where[] = "country_code = '" . $search_criteria_country . "'";
            }
            if ( false != $searched_term ) {
                $search[] = 'city_name LIKE "%' . $searched_term . '%"';

                if ( $search_criteria_country || $search_criteria_state ) {
                    $where[] = '(' . implode( ' OR ', $search ) . ')';
                } else {
                    $where[] = implode( ' OR ', $search );
                }

            }
            if ( 0 != $selected_limit ) {
                $search_limit = "LIMIT " . $selected_limit;
            }

            if ( ! empty( $where ) ) {
                $where   = "WHERE " . implode( ' AND ', $where );
            } else {
                $where = false;
            }

            if ( 'state' == $searched_orderby ) {
                $orderby = 'ORDER BY state_name ASC, city_name ASC';
            } else {
                $orderby = 'ORDER BY city_name ASC, state_name ASC';
            }

            $sql = "SELECT *
                FROM " . $wpdb->prefix . "places
                " . $where . "
                " . $orderby . "
                " . $search_limit . "
            ";
            $places     = $wpdb->get_results( $sql );
            $city_array = array();
            foreach( $places as $city_object ) {
                $city_array[] = (array) $city_object;
            }
            if ( ! empty( $city_array ) ) {
                uasort( $city_array, 'acfps_sort_array_with_quotes' );
            }
            $result_count = count( $city_array );
        }

        // output
        ?>
        <div class="wrap acfps">
            <div id="icon-options-general" class="icon32"><br /></div>

            <h1>ACF City Selector</h1>

            <?php echo ACF_Place_Selector::acfps_admin_menu(); ?>

            <div class="acfps__container">
                <div class="admin_left">
                    <div class="content">

                        <h2>
                            <?php esc_html_e( 'Search for places', 'acf-place-selector' ); ?>
                        </h2>

                        <?php if ( count( $countries ) > 0 ) { ?>
                            <form action="" method="POST">
                                <input name="acfps_search_form" type="hidden" value="1" />

                                <div class="acfps__search-form">
                                    <?php // if there's only 1 country, no need to add country dropdown ?>
                                    <?php if ( count( $countries ) > 1 ) { ?>
                                        <div class="acfps__search-criteria acfps__search-criteria--country">
                                            <label for="acfps_country" class="screen-reader-text"><?php echo apply_filters( 'acfps_select_country_label', esc_html__( 'Select a country', 'acf-place-selector' ) ); ?></label>
                                            <select name="acfps_country" id="acfps_country">
                                                <option value="">
                                                    <?php echo apply_filters( 'acfps_select_country_label', esc_html__( 'Select a country', 'acf-place-selector' ) ); ?>
                                                </option>
                                                <?php foreach( $countries as $country ) { ?>
                                                    <?php $selected = ( $country[ 'code' ] == $search_criteria_country ) ? ' selected="selected"' : false; ?>
                                                    <option value="<?php echo $country[ 'code' ]; ?>"<?php echo $selected; ?>>
                                                        <?php _e( $country[ 'name' ], 'acf-place-selector' ); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="acfps__search-criteria acfps__search-criteria--or">
                                            <small><?php esc_html_e( 'OR', 'acf-place-selector' ); ?></small>
                                        </div>
                                    <?php } ?>

                                    <div class="acfps__search-criteria acfps__search-criteria--state">
                                        <label for="acfps_state" class="screen-reader-text">
                                            <?php echo apply_filters( 'acfps_select_province_state_label', esc_html__( 'Select a province/state', 'acf-place-selector' ) ); ?>
                                        </label>
                                        <select name="acfps_state" id="acfps_state">
                                            <option value="">
                                                <?php echo apply_filters( 'acfps_select_province_state_label', esc_html__( 'Select a province/state', 'acf-place-selector' ) ); ?>
                                            </option>
                                            <?php
                                                foreach( $states as $state ) {
                                                    if ( 'open_optgroup' == $state[ 'state' ] ) {
                                                        echo '<optgroup label="'. $state[ 'name' ] . '">';
                                                    }
                                                    if ( strpos( $state[ 'state' ], 'optgroup' ) === false ) {
                                                        $selected = ( $state[ 'state' ] == $search_criteria_state ) ? ' selected="selected"' : false;
                                                        echo '<option value="' . $state[ 'state' ] . '"' . $selected . '>' . esc_html__( $state[ 'name' ], 'acf-place-selector' ) . '</option>';
                                                    }
                                                    if ( 'close_optgroup' == $state[ 'state' ] ) {
                                                        echo '</optgroup>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="acfps__search-criteria acfps__search-criteria--plus">+</div>

                                    <div class="acfps__search-criteria acfps__search-criteria--search">
                                        <label for="acfps_search" class="screen-reader-text">
                                            <?php esc_html_e( 'Search term', 'acf-place-selector' ); ?>
                                        </label>
                                        <input name="acfps_search" id="acfps_search" type="text" value="<?php if ( false != $searched_term ) { echo stripslashes( $searched_term ); } ?>" placeholder="<?php esc_html_e( 'City name', 'acf-place-selector' ); ?>">
                                    </div>

                                    <div class="acfps__search-criteria acfps__search-criteria--plus">+</div>

                                    <div class="acfps__search-criteria acfps__search-criteria--limit">
                                        <label for="acfps_limit" class="screen-reader-text">
                                            <?php esc_html_e( 'Limit', 'acf-place-selector' ); ?>
                                        </label>
                                        <input name="acfps_limit" id="acfps_limit" type="number" value="<?php if ( false != $selected_limit ) { echo $selected_limit; } ?>" placeholder="<?php esc_html_e( 'Limit', 'acf-place-selector' ); ?>">
                                    </div>

                                    <div class="acfps__search-criteria acfps__search-criteria--plus">+</div>

                                    <div class="acfps__search-criteria acfps__search-criteria--orderby">
                                        <label for="acfps_orderby" class="screen-reader-text">
                                            <?php esc_html_e( 'Order by', 'acf-place-selector' ); ?>
                                        </label>
                                        <select name="acfps_orderby" id="acfps_orderby">
                                            <option value="">
                                                <?php esc_html_e( 'Order by', 'acf-place-selector' ); ?>
                                            </option>
                                            <?php
                                                $orderby = [
                                                    esc_attr__( 'City', 'acf-place-selector' ),
                                                    esc_attr__( 'State', 'acf-place-selector' ),
                                                ];
                                                foreach( $orderby as $criterium ) {
                                                    $selected = ( $criterium == $searched_orderby ) ? ' selected' : false;
                                                    echo '<option value="' . $criterium . '" ' . $selected . '>' . ucfirst( $criterium ) . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="acfps__search-criteria acfps__search-criteria--submit">
                                        <input type="submit" class="button button-primary" value="<?php esc_html_e( 'Search', 'acf-place-selector' ); ?>" />
                                    </div>
                                </div>
                            </form>
                        <?php } ?>

                        <?php // Results output below ?>
                        <?php if ( isset( $_POST[ 'acfps_search_form' ] ) && empty( $places ) ) { ?>
                            <p>
                                <br />
                                <?php _e( 'No results, please try again.', 'acf-place-selector'); ?>
                            </p>
                        <?php } elseif ( ! empty( $places ) ) { ?>
                            <form enctype="multipart/form-data" action="" method="POST">
                                <input name="acfps_delete_row_nonce" type="hidden" value="<?php echo wp_create_nonce( 'acfps-delete-row-nonce' ); ?>" />
                                <div class="acfps__search-results">
                                    <p class="hide568">
                                        <small>
                                            <?php _e( 'Table scrolls horizontally.', 'acf-place-selector' ); ?>
                                        </small>
                                    </p>
                                    <p>
                                        <?php echo $result_count; ?> <?php esc_html_e( 'results',  'acf-place-selector' ); ?>
                                    </p>
                                    <table class="acfps__table acfps__table--search scrollable">
                                        <thead>
                                        <tr>
                                            <th>
                                                <?php esc_html_e( 'ID', 'acf-place-selector' ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( 'Select', 'acf-place-selector' ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( 'City', 'acf-place-selector' ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( 'State', 'acf-place-selector' ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( 'Country', 'acf-place-selector' ); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <?php foreach( $city_array as $city ) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $city[ 'id' ]; ?>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input name="row_id[]" type="checkbox" value="<?php echo $city[ 'id' ]; ?> <?php echo $city[ 'city_name' ]; ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <?php echo $city[ 'city_name' ]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $city[ 'state_name' ]; ?>
                                                </td>
                                                <td>
                                                    <?php _e( $city[ 'country' ], 'acf-place-selector' ); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>

                                    <input type="submit" class="button button-primary" value="<?php esc_html_e( 'Delete selected', 'acf-place-selector' ); ?>" />
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <?php include 'admin-right.php'; ?>

            </div>

        </div>
        <?php
    }

