<?php

    /**
     * Content for the settings page
     */
    function acfps_preview_page() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Sorry, you do not have sufficient permissions to access this page.', 'acf-place-selector' ) );
        }

        ACF_Place_Selector::acfps_show_admin_notices();
        ?>

        <div class="wrap acfps">
            <div id="icon-options-general" class="icon32"><br/></div>

            <h1>ACF City Selector</h1>

            <?php
                echo ACF_Place_Selector::acfps_admin_menu();

                $file_index      = acfps_check_if_files();
                $file_name       = ( isset( $_POST[ 'acfps_file_name' ] ) ) ? $_POST[ 'acfps_file_name' ] : false;
                $max_lines       = ( isset( $_POST[ 'acfps_max_lines' ] ) ) ? (int) $_POST[ 'acfps_max_lines' ] : false;
                $max_lines_value = ( false != $max_lines ) ? $max_lines : 100;
                $delimiter       = ( isset( $_POST[ 'acfps_delimiter' ] ) ) ? sanitize_text_field( $_POST[ 'acfps_delimiter' ] ) : apply_filters( 'acfps_delimiter', ';' );

                // Get imported data
                if ( $file_name ) {
                    $csv_info   = acfps_csv_to_array( $file_name, '', $delimiter, true, $max_lines );
                    $file_index = acfps_check_if_files();
                }
            ?>

            <div class="acfps__container">
                <div class="admin_left">
                    <div class="content">

                        <?php if ( ! empty( $file_index ) ) { ?>
                            <h2><?php esc_html_e( 'Preview data', 'acf-place-selector' ); ?></h2>
                            <p><?php esc_html_e( 'Here you can preview any uploaded csv files.', 'acf-place-selector' ); ?></p>
                            <p><?php esc_html_e( 'Please keep in mind that all csv files are verified before displaying (and therefor can be deleted, when errors are encountered).', 'acf-place-selector' ); ?></p>

                            <div class="acfps__section acfps__section--preview">

                                <form name="select-preview-file" id="settings-form" action="" method="post">
                                    <div class="acfps__process-file">
                                        <div class="acfps__process-file-element">
                                            <label for="acfps_file_name">
                                                <?php esc_html_e( 'File', 'acf-place-selector' ); ?>
                                            </label>
                                            <select name="acfps_file_name" id="acfps_file_name">
                                                <?php if ( count( $file_index ) > 1 ) { ?>
                                                    <option value=""><?php esc_html_e( 'Select a file', 'acf-place-selector' ); ?></option>
                                                <?php } ?>
                                                <?php foreach ( $file_index as $file ) { ?>
                                                    <?php $selected = ( $file_name == $file ) ? ' selected="selected"' : false; ?>
                                                    <option value="<?php echo $file; ?>"<?php echo $selected; ?>><?php echo $file; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="acfps__process-file-element">
                                            <?php $delimiters = [ ';', ',', '|' ]; ?>
                                            <label for="acfps_delimiter">
                                                <?php esc_html_e( 'Delimiter', 'acf-place-selector' ); ?>
                                            </label>
                                            <select name="acfps_delimiter" id="acfps_delimiter">
                                                <?php foreach( $delimiters as $delimiter_value ) { ?>
                                                    <?php $selected_delimiter = ( $delimiter_value == $delimiter ) ? ' selected' : false; ?>
                                                    <option value="<?php echo $delimiter_value; ?>"<?php echo $selected_delimiter; ?>><?php echo $delimiter_value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="acfps__process-file-element">
                                            <label for="acfps_max_lines">
                                                <?php esc_html_e( 'Max lines', 'acf-place-selector' ); ?>
                                            </label>
                                            <input type="number" name="acfps_max_lines" id="acfps_max_lines" value="<?php echo $max_lines_value; ?>" />
                                        </div>
                                    </div>

                                    <div>
                                        <input type="submit" class="button button-primary" value="<?php esc_html_e( 'View this file', 'acf-place-selector' ); ?>"/>
                                    </div>
                                </form>
                            </div>

                        <?php } else { ?>
                            <div>
                                <?php esc_html_e( 'You have no files to preview.', 'acf-place-selector' ); ?>
                                <?php echo sprintf( __( 'Upload a csv file from your <a href="%s">dashboard</a>.', 'acf-place-selector' ), esc_url( admin_url( '/admin.php?page=acfps-dashboard' ) ) ); ?>
                            </div>
                        <?php } ?>

                        <?php
                            // Get imported data
                            if ( $file_name ) {
                                echo '<div class="acfps__section acfps__section--results">';

                                if ( array_key_exists( 'error', $csv_info ) ) {
                                    if ( 'file_deleted' == $csv_info[ 'error' ] ) {
                                        echo '<div class="notice notice-error is-dismissable">';
                                        echo '<p>';
                                        echo sprintf( esc_html__( 'You either have errors in your CSV or there is no data. In case of an error, the file is deleted. Please check "%s".', 'acf-place-selector' ), $file_name );
                                        echo '</p>';
                                        echo '<button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_html__( 'Dismiss this notice', 'acf-place-selector' ) . '</span></button>';
                                        echo '</div>';
                                    } elseif ( ! isset( $csv_info[ 'data' ] ) || ( isset( $csv_info[ 'data' ] ) && empty( $csv_info[ 'data' ] ) ) ) {
                                        echo '<div class="notice notice-error">';
                                        echo esc_html__( 'There appears to be no data in the file. Are you sure it has content and you selected the correct delimiter ?', 'acf-place-selector' );
                                        echo '</div>';
                                    }
                                } elseif ( isset( $csv_info[ 'data' ] ) && ! empty( $csv_info[ 'data' ] ) ) {
                                    echo '<h2>' . esc_html__( 'CSV contents', 'acf-place-selector' ) . '</h2>';
                                    echo '<p class="hide640"><small>' . esc_html__( 'Table scrolls horizontally.', 'acf-place-selector' ) . '</small></p>';
                                    echo '<table class="acfps__table acfps__table--preview-result scrollable">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>' . esc_html__( 'City', 'acf-place-selector' ) . '</th>';
                                    echo '<th>' . esc_html__( 'State code', 'acf-place-selector' ) . '</th>';
                                    echo '<th>' . esc_html__( 'State', 'acf-place-selector' ) . '</th>';
                                    echo '<th>' . esc_html__( 'Country code', 'acf-place-selector' ) . '</th>';
                                    echo '<th>' . esc_html__( 'Country', 'acf-place-selector' ) . '</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    $line_number = 0;
                                    foreach ( $csv_info[ 'data' ] as $line ) {
                                        $line_number++;
                                        echo '<tr>';
                                        foreach ( $line as $column ) {
                                            echo '<td>';
                                            echo stripslashes( htmlspecialchars( $column ) );
                                            echo '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                }
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>

                <?php include 'admin-right.php'; ?>

            </div>
        </div>
        <?php
    }
