<?php
    /*
     * Content for the settings page
     */
    function acfps_dashboard() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
        }

        ACF_Place_Selector::acfps_show_admin_notices();

        $show_raw_import = true;
        ?>

        <div class="wrap acfps">
            <div id="icon-options-general" class="icon32"><br /></div>

            <h1>
                <?php echo get_admin_page_title(); ?>
            </h1>

            <?php echo ACF_Place_Selector::acfps_admin_menu(); ?>

            <div class="acfps__container">
                <div class="admin_left">
                    <div class="content">

                        <div class="acfps__section acfps__section--upload-csv">

                            <h2>
                                <?php esc_html_e( 'Upload a CSV file', 'acf-place-selector' ); ?>
                            </h2>

                            <form enctype="multipart/form-data" method="post">
                                <input name="acfps_upload_csv_nonce" type="hidden" value="<?php echo wp_create_nonce( 'acfps-upload-csv-nonce' ); ?>" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />

                                <div class="upload-element">
                                    <label for="csv_upload">
                                        <?php esc_html_e( 'Choose a (CSV) file to upload', 'acf-place-selector' ); ?>
                                    </label>
                                    <div class="form--upload form--csv_upload">
                                        <input type="file" name="csv_upload" id="csv_upload" accept=".csv" />
                                        <span class="val"></span>
                                        <span class="upload_button button-primary" data-type="csv_upload">
                                            <?php _e( 'Select file', 'acf-place-selector' ); ?>
                                        </span>
                                    </div>
                                </div>
                                <input type="submit" class="button button-primary" value="<?php esc_html_e( 'Upload CSV', 'acf-place-selector' ); ?>" />
                            </form>
                        </div>

                        <?php
                            $file_index = acfps_check_if_files();
                            if ( ! empty( $file_index ) ) { ?>
                                <div class="acfps__section acfps__section--process-file">
                                    <h2>
                                        <?php esc_html_e( 'Select a file to import', 'acf-place-selector' ); ?>
                                    </h2>

                                    <p>
                                        <small>
                                            Max lines has no effect when verifying. The entire file will be checked.
                                        </small>
                                    </p>

                                    <form method="post">
                                        <input name="acfps_select_file_nonce" type="hidden" value="<?php echo wp_create_nonce( 'acfps-select-file-nonce' ); ?>" />

                                        <div class="acfps__process-file">
                                            <div class="acfps__process-file-element acfps__process-file-element--file">
                                                <label for="acfps_file_name">
                                                    <?php esc_html_e( 'File', 'acf-place-selector' ); ?>
                                                </label>
                                                <select name="acfps_file_name" id="acfps_file_name">
                                                    <?php if ( count( $file_index ) > 1 ) { ?>
                                                        <option value="">
                                                            <?php esc_html_e( 'Select a file', 'acf-place-selector' ); ?>
                                                        </option>
                                                    <?php } ?>
                                                    <?php foreach ( $file_index as $file_name ) { ?>
                                                        <?php $selected = ( isset( $_POST[ 'acfps_file_name' ] ) && $_POST[ 'acfps_file_name' ] == $file_name ) ? ' selected="selected"' : false; ?>
                                                        <option value="<?php echo $file_name; ?>"<?php echo $selected; ?>>
                                                            <?php echo $file_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="acfps__process-file-element acfps__process-file-element--delimiter">
                                                <?php $delimiters = [ ';', ',', '|' ]; ?>
                                                <label for="acfps_delimiter">
                                                    <?php esc_html_e( 'Delimiter', 'acf-place-selector' ); ?>
                                                </label>
                                                <select name="acfps_delimiter" id="acfps_delimiter">
                                                    <?php foreach( $delimiters as $delimiter ) { ?>
                                                        <?php $selected_delimiter = ( $delimiter == apply_filters( 'acfps_delimiter', ';' ) ) ? ' selected' : false; ?>
                                                        <option value="<?php echo $delimiter; ?>"<?php echo $selected_delimiter; ?>>
                                                            <?php echo $delimiter; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="acfps__process-file-element acfps__process-file-element--maxlines">
                                                <label for="acfps_max_lines">
                                                    <?php esc_html_e( 'Max lines', 'acf-place-selector' ); ?>
                                                </label>
                                                <input type="number" name="acfps_max_lines" id="acfps_max_lines" />
                                            </div>
                                        </div>

                                        <input name="verify" type="submit" class="button button-primary" value="<?php esc_html_e( 'Verify selected file', 'acf-place-selector' ); ?>" />
                                        <input name="import" type="submit" class="button button-primary" value="<?php esc_html_e( 'Import selected file', 'acf-place-selector' ); ?>" />
                                        <input name="remove" type="submit" class="button button-primary" value="<?php esc_html_e( 'Remove selected file', 'acf-place-selector' ); ?>" />
                                    </form>
                                </div>
                        <?php } ?>

                        <?php if ( true === $show_raw_import ) { ?>
                            <?php $placeholder = "Amsterdam;NH;Noord-Holland;NL;Netherlands\nRotterdam;ZH;Zuid-Holland;NL;Netherlands"; ?>
                            <?php $submitted_raw_data = ( isset( $_POST[ 'raw_csv_import' ] ) ) ? sanitize_textarea_field( $_POST[ 'raw_csv_import' ] ) : false; ?>
                            <div class="acfps__section acfps__section--raw-import">
                                <h2>
                                    <?php esc_html_e( 'Import CSV data (from clipboard)', 'acf-place-selector' ); ?>
                                </h2>
                                <p>
                                    <?php esc_html_e( 'Here you can paste CSV data from your clipboard.', 'acf-place-selector' ); ?>
                                    <br />
                                    <?php esc_html_e( 'Make sure the cursor is ON the last line (after the last character), NOT on a new line.', 'acf-place-selector' ); ?>
                                    <br />
                                    <?php esc_html_e( 'This is seen as a new entry and creates an error !!!', 'acf-place-selector' ); ?>
                                </p>
                                <form method="post">
                                    <input name="acfps_import_raw_nonce" type="hidden" value="<?php echo wp_create_nonce( 'acfps-import-raw-nonce' ); ?>" />
                                    <label for="raw-import">
                                        <?php esc_html_e( 'Raw CSV import', 'acf-place-selector' ); ?>
                                    </label>
                                    <textarea name="acfps_raw_csv_import" id="raw-import" rows="5" placeholder="<?php echo $placeholder; ?>"><?php echo $submitted_raw_data; ?></textarea>
                                    <br />
                                    <input name="verify" type="submit" class="button button-primary" value="<?php esc_html_e( 'Verify CSV data', 'acf-place-selector' ); ?>" />
                                    <input name="import" type="submit" class="button button-primary" value="<?php esc_html_e( 'Import CSV data', 'acf-place-selector' ); ?>" />
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php include 'admin-right.php'; ?>
            </div>

        </div>
        <?php
    }

