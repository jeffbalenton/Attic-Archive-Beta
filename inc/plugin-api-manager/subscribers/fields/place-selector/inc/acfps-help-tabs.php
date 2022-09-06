<?php

    /**
     * Add help tabs
     *
     * @param $screen
     *
     * @return bool
     */
    function acfps_help_tabs( $screen ) {

        if ( isset( $screen->id ) ) {
            if ( strpos( $screen->id, 'acfps' ) !== false ) {
                $on_this_page = esc_html__( 'On this page you can import places by either CSV file or raw (pasted) CSV data.', 'acf-place-selector' );
                $field_info = '<p>' . esc_html__( 'The required order is "City,State code,State,Country code,Country".', 'acf-place-selector' ) . '</p>
                        <table class="">
                        <thead>
                        <tr>
                        <th>' . esc_html__( 'Field', 'acf-place-selector' ) . '</th>
                        <th>' . esc_html__( 'What to enter', 'acf-place-selector' ) . '</th>
                        <th>' . esc_html__( 'Note', 'acf-place-selector' ) . '</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>' . esc_html__( 'City', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'full name', 'acf-place-selector' ) . '</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>' . esc_html__( 'State code', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'state abbreviation', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'max 3 characters', 'acf-place-selector' ) . '</td>
                        </tr>
                        <tr>
                        <td>' . esc_html__( 'State', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'full state name', 'acf-place-selector' ) . '</td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>' . esc_html__( 'Country code', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'country abbreviation', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'exactly 2 characters', 'acf-place-selector' ) . '</td>
                        </tr>
                        <tr>
                        <td>' . esc_html__( 'Country', 'acf-place-selector' ) . '</td>
                        <td>' . esc_html__( 'full country name', 'acf-place-selector' ) . '</td>
                        <td>&nbsp;</td>
                        </tr>
                        </tbody>
                        </table>';

                $screen->add_help_tab( array(
                    'id'      => 'import-file',
                    'title'   => esc_html__( 'Import CSV from file', 'acf-place-selector' ),
                    'content' =>
                        '<h5>Import CSV from file</h5>
                        <p>' . $on_this_page . '</p>
                        <p>' . esc_html__( 'You can only upload *.csv files.', 'acf-place-selector' ) . '</p>'
                        . $field_info
                ) );

                $screen->add_help_tab( array(
                    'id'      => 'import-raw',
                    'title'   => esc_html__( 'Import raw CSV data', 'acf-place-selector' ),
                    'content' =>
                        '<h5>Import places through CSV data</h5>
                        <p>' . $on_this_page . '</p>
                        <p>' . esc_html__( 'Raw CSV data has to be formatted (and ordered) in a certain way, otherwise it won\'t work.', 'acf-place-selector' ) . '</p>'
                        . $field_info
                ) );

                $screen->add_help_tab( array(
                    'id'      => 'preview-data',
                    'title'   => esc_html__( 'Preview CSV data', 'acf-place-selector' ),
                    'content' =>
                        '<h5>Preview CSV data</h5>
                        <p>' . esc_html__( 'On the preview page, you can preview uploaded csv files. Not to be confused with search where you can search imported places. Please keep in mind, if you preview an uploaded csv file, the file will get verified and it can be deleted if it contains errors.', 'acf-place-selector' ) . '</p>
                        '
                ) );

                $screen->add_help_tab( array(
                    'id'      => 'search-data',
                    'title'   => esc_html__( 'Search CSV data', 'acf-place-selector' ),
                    'content' =>
                        '<h5>Preview CSV data</h5>
                        <p>' . esc_html__( 'On the search page, you can search in imported places. Not to be confused with preview where you can preview uploaded csv files.', 'acf-place-selector' ) . '</p>
                        '
                ) );

                $screen->add_help_tab( array(
                    'id'      => 'more-countries',
                    'title'   => esc_html__( 'More countries', 'acf-place-selector' ),
                    'content' =>
                        '<h5>More countries</h5>
                        <p>' . __( 'If you need more countries, you can get them on the official website: <a href="https://acf-place-selector.com/get-countries/" target="_blank" rel="noopener">acf-place-selector.com</a>.', 'acf-place-selector' ) . '</p>
                        '
                ) );

                get_current_screen()->set_help_sidebar(
                    '<p><strong>' . esc_html__( 'Official website', 'acf-place-selector' ) . '</strong></p>
                <p><a href="https://acf-place-selector.com?utm_source=' . $_SERVER[ 'SERVER_NAME' ] . '&utm_medium=plugin_admin&utm_campaign=free_promo">acf-place-selector.com</a></p>'
                );
            }
        }

        return false;

    }
    add_filter( 'current_screen', 'acfps_help_tabs' );
