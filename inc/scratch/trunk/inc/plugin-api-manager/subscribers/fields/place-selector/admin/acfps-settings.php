<?php
    /*
     * Content for the settings page
     */
    function acfps_settings() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
        }

        ACF_Place_Selector::acfps_show_admin_notices();
        ?>

        <div class="wrap acfps">
            <div id="icon-options-general" class="icon32"><br /></div>

            <h1>ACF City Selector</h1>

            <?php echo ACF_Place_Selector::acfps_admin_menu(); ?>

            <div class="acfps__container">
                <div class="admin_left">
                    <div class="content">

                        <form method="post" action="">
                            <input name="acfps_import_actions_nonce" value="<?php echo wp_create_nonce( 'acfps-import-actions-nonce' ); ?>" type="hidden" />
                            <h2>
                                <?php esc_html_e( 'Import countries', 'acf-place-selector' ); ?>
                            </h2>
                            <p>
                                <?php esc_html_e( "Here you can (re-)import all places for the individual countries listed below.", 'acf-place-selector' ); ?>
                            </p>
                            <ul class="acfps__checkboxes">
                                <li>
                                    <label for="import_be" class="screen-reader-text">
                                        <?php esc_html_e( 'Import all places in Belgium', 'acf-place-selector' ); ?>
                                    </label>
                                    <input type="checkbox" name="import_be" id="import_be" value="1" /> <?php esc_html_e( 'Import all places in Belgium', 'acf-place-selector' ); ?> (1166)
                                </li>
                                <li>
                                    <label for="import_nl" class="screen-reader-text">
                                        <?php esc_html_e( 'Import all places in Holland/The Netherlands', 'acf-place-selector' ); ?>
                                    </label>
                                    <input type="checkbox" name="import_nl" id="import_nl" value="1" /> <?php esc_html_e( 'Import all places in Holland/The Netherlands', 'acf-place-selector' ); ?> (2449)
                                </li>
                            </ul>

                            <input type="submit" class="button button-primary" value="<?php esc_html_e( 'Import selected countries', 'acf-place-selector' ); ?>" />
                        </form>

                        <br /><hr />

                        <?php $countries = acfps_get_countries( false, false,  true ); ?>
                        <?php if ( ! empty( $countries ) ) { ?>
                            <h2>
                                <?php esc_html_e( 'Remove countries', 'acf-place-selector' ); ?>
                            </h2>
                            <form method="post" action="">
                                <input name="acfps_remove_countries_nonce" value="<?php echo wp_create_nonce( 'acfps-remove-countries-nonce' ); ?>" type="hidden" />
                                <p>
                                    <?php esc_html_e( "Here you can remove a country and all its states and places from the database.", 'acf-place-selector' ); ?>
                                </p>
                                <ul class="acfps__checkboxes">
                                    <?php foreach( $countries as $key => $value ) { ?>
                                        <li>
                                            <label for="delete_<?php echo strtolower( $key ); ?>" class="screen-reader-text">
                                                <?php esc_html_e( $value, 'acf-place-selector' ); ?>
                                            </label>
                                            <input type="checkbox" name="delete_country[]" id="delete_<?php echo strtolower( $key ); ?>" value="<?php echo strtolower( $key ); ?>" /> <?php esc_html_e( $value, 'acf-place-selector' ); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <input type="submit" class="button button-primary" value="<?php esc_html_e( 'Delete selected countries', 'acf-place-selector' ); ?>" />
                            </form>

                            <br /><hr />
                        <?php } ?>

                        <form method="post" action="">
                            <input name="acfps_delete_transients" value="<?php echo wp_create_nonce( 'acfps-delete-transients-nonce' ); ?>" type="hidden" />
                            <h2>
                                <?php esc_html_e( 'Delete transients', 'acf-place-selector' ); ?>
                            </h2>
                            <p>
                                <?php esc_html_e( "If you're seeing unexpected results in your dropdowns, try clearing all transients with this option.", 'acf-place-selector' ); ?>
                            </p>
                            <input type="submit" class="button button-primary" value="<?php esc_html_e( "Delete transients", 'acf-place-selector' ); ?>" />
                        </form>

                        <br /><hr />

                        <form method="post" action="">
                            <input name="acfps_truncate_table_nonce" value="<?php echo wp_create_nonce( 'acfps-truncate-table-nonce' ); ?>" type="hidden" />
                            <h2>
                                <?php esc_html_e( 'Clear the database', 'acf-place-selector' ); ?>
                            </h2>
                            <p>
                                <?php esc_html_e( "By selecting this option, you will remove all places, which are present in the database. This is useful if you don't need the preset places or you want a fresh start.", 'acf-place-selector' ); ?>
                            </p>
                            <input type="submit" class="button button-primary"  onclick="return confirm( 'Are you sure you want to delete all places ?' )" value="<?php esc_html_e( 'Delete everything', 'acf-place-selector' ); ?>" />
                        </form>

                        <br /><hr />

                        <form method="post" action="">
                            <input name="acfps_remove_places_nonce" value="<?php echo wp_create_nonce( 'acfps-remove-places-nonce' ); ?>" type="hidden" />
                            <h2>
                                <?php esc_html_e( 'Delete data', 'acf-place-selector' ); ?>
                            </h2>
                            <p>
                                <?php esc_html_e( 'When the plugin is deleted, all places are not automatically deleted. Select this option to delete the places table as well upon deletion.', 'acf-place-selector' ); ?>
                            </p>
                            <?php $checked = get_option( 'acfps_delete_places_table' ) ? ' checked="checked"' : false; ?>
                            <ul>
                                <li>
                                    <span class="acfps_input">
                                        <label for="remove_places_table" class="screen-reader-text">
                                            <?php esc_html_e( 'Remove places table on plugin deletion', 'acf-place-selector' ); ?>
                                        </label>
                                        <input type="checkbox" name="remove_places_table" id="remove_places_table" value="1" <?php echo $checked; ?>/> <?php esc_html_e( 'Remove places table on plugin deletion', 'acf-place-selector' ); ?>
                                    </span>
                                </li>
                            </ul>
                            <input type="submit" class="button button-primary" value="<?php esc_html_e( 'Save settings', 'acf-place-selector' ); ?>" />
                        </form>
                    </div>
                </div>

                <?php include 'admin-right.php'; ?>

            </div>

        </div>
        <?php
    }
