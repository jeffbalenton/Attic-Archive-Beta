<?php
    /*
     * Content for the settings page
     */
    function acfps_info_page() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
        }

        ACF_Place_Selector::acfps_show_admin_notices();

        $countries    = acfps_get_countries_info();
        $prepare_json = array();
        ?>

        <div class="wrap acfps">
            <div id="icon-options-general" class="icon32"><br /></div>

            <h1>ACF City Selector</h1>

            <?php echo ACF_Place_Selector::acfps_admin_menu(); ?>

            <div class="acfps__container">
                <div class="admin_left">
                    <div class="content">

                        <div class="acfps__section">
                            <h2><?php esc_html_e( 'Info', 'acf-place-selector' ); ?></h2>
                            <p>
                                <?php esc_html_e( 'This page shows real-time info about your site and settings.', 'acf-place-selector' ); ?>
                                <br />
                                <?php esc_html_e( 'We might ask for this info if support is helping you fix a problem.', 'acf-place-selector' ); ?>
                            </p>
                        </div>

                        <div class="acfps__section acfps__section--countries">
                            <?php if ( ! empty( $countries ) ) { ?>
                                <h2>
                                    <?php esc_html_e( 'Countries in database', 'acf-place-selector' ); ?>
                                </h2>

                                <table class="acfps__table acfps__table--info">
                                    <thead>
                                    <tr>
                                        <th><?php esc_html_e( 'Country name', 'acf-place-selector' ); ?></th>
                                        <th><?php esc_html_e( '# places', 'acf-place-selector' ); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach( $countries as $country_code => $values ) { ?>
                                        <?php $prepare_json[ 'countries' ][ $country_code ] = $values[ 'name' ] . ' (' . $values[ 'count' ] . ')'; ?>
                                        <tr>
                                            <td><?php echo $values[ 'name' ]; ?></td>
                                            <td><?php echo $values[ 'count' ]; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <?php $prepare_json[ 'countries' ] = 'none'; ?>
                            <?php } ?>

                            <h2>
                                <?php esc_html_e( 'Server info', 'acf-place-selector' ); ?>
                            </h2>

                            <table class="acfps__table acfps__table--info">
                                <thead>
                                <tr>
                                    <th><?php esc_html_e( 'What ?', 'acf-place-selector' ); ?></th>
                                    <th><?php esc_html_e( 'Value', 'acf-place-selector' ); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php $prepare_json[ 'server_info' ][ 'operating_system' ] = $_SERVER[ 'SERVER_SOFTWARE' ]; ?>
                                    <td><?php esc_html_e( 'Operating system', 'acf-place-selector' ); ?></td>
                                    <td><?php echo $_SERVER[ 'SERVER_SOFTWARE' ]; ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'server_info' ][ 'phpversion' ] = phpversion(); ?>
                                    <td><?php esc_html_e( 'PHP version', 'acf-place-selector' ); ?></td>
                                    <td><?php echo phpversion(); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'server_info' ][ 'server_ip' ] = $_SERVER[ 'SERVER_ADDR' ]; ?>
                                    <td><?php esc_html_e( 'Server IP', 'acf-place-selector' ); ?></td>
                                    <td><?php echo $_SERVER[ 'SERVER_ADDR' ]; ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'server_info' ][ 'server_port' ] = $_SERVER[ 'SERVER_PORT' ]; ?>
                                    <td><?php esc_html_e( 'Server port', 'acf-place-selector' ); ?></td>
                                    <td><?php echo $_SERVER[ 'SERVER_PORT' ]; ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'server_info' ][ 'scheme' ] = $_SERVER[ 'REQUEST_SCHEME' ]; ?>
                                    <td><?php esc_html_e( 'Scheme', 'acf-place-selector' ); ?></td>
                                    <td><?php echo $_SERVER[ 'REQUEST_SCHEME' ]; ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'server_info' ][ 'document_root' ] = $_SERVER[ 'DOCUMENT_ROOT' ]; ?>
                                    <td><?php esc_html_e( 'Home path', 'acf-place-selector' ); ?></td>
                                    <td><?php echo $_SERVER[ 'DOCUMENT_ROOT' ]; ?></td>
                                </tr>
                                </tbody>
                            </table>

                            <h2>
                                <?php esc_html_e( 'WordPress info', 'acf-place-selector' ); ?>
                            </h2>

                            <table class="acfps__table acfps__table--info">
                                <thead>
                                <tr>
                                    <th><?php esc_html_e( 'What ?', 'acf-place-selector' ); ?></th>
                                    <th><?php esc_html_e( 'Value', 'acf-place-selector' ); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'wordpress_version' ] = get_bloginfo( 'version' ); ?>
                                    <td><?php esc_html_e( 'WordPress version', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_bloginfo( 'version' ); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'home_url' ] = get_home_url(); ?>
                                    <td><?php esc_html_e( 'Home URL', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_home_url(); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'blog_public' ] = get_option( 'blog_public' ); ?>
                                    <td><?php esc_html_e( 'Blog public', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_option( 'blog_public' ); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'users_can_register' ] = get_option( 'users_can_register' ); ?>
                                    <td><?php esc_html_e( 'Users can register', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_option( 'users_can_register' ); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'page_on_front' ] = get_option( 'page_on_front' ); ?>
                                    <td><?php esc_html_e( 'Page on front', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_option( 'page_on_front' ); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'current_theme' ] = get_option( 'current_theme' ); ?>
                                    <td><?php esc_html_e( 'Current theme', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_option( 'current_theme' ); ?></td>
                                </tr>
                                <?php $stylesheet = get_option( 'stylesheet' ); ?>
                                <?php $template   = get_option( 'template' ); ?>
                                <?php if ( $stylesheet != $template ) { ?>
                                    <tr>
                                        <?php $prepare_json[ 'wordpress_info' ][ 'stylesheet' ] = $stylesheet; ?>
                                        <td><?php esc_html_e( 'Stylesheet folder', 'acf-place-selector' ); ?></td>
                                        <td><?php echo $stylesheet; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'template' ] = get_option( 'template' ); ?>
                                    <td><?php esc_html_e( 'Template folder', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_option( 'template' ); ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'charset' ] = get_option( 'charset' ); ?>
                                    <td><?php esc_html_e( 'Charset', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_bloginfo( 'charset' ); ?></td>
                                </tr>
                                <tr>
                                    <?php $text_direction = is_rtl() ? 'RTL' : 'LTR'; ?>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'text_direction' ] = $text_direction; ?>
                                    <td><?php esc_html_e( 'Text direction', 'acf-place-selector' ); ?></td>
                                    <td><?php echo $text_direction; ?></td>
                                </tr>
                                <tr>
                                    <?php $prepare_json[ 'wordpress_info' ][ 'language' ] = get_bloginfo( 'language' ); ?>
                                    <td><?php esc_html_e( 'Language', 'acf-place-selector' ); ?></td>
                                    <td><?php echo get_bloginfo( 'language' ); ?></td>
                                </tr>
                                </tbody>
                            </table>

                            <?php if ( is_multisite() ) { ?>
                                <h2>
                                    <?php esc_html_e( 'Multisite', 'acf-place-selector' ); ?>
                                </h2>

                                <table class="acfps__table acfps__table--info">
                                    <thead>
                                    <tr>
                                        <th><?php esc_html_e( 'What ?', 'acf-place-selector' ); ?></th>
                                        <th><?php esc_html_e( 'Value', 'acf-place-selector' ); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <?php $main_site = ( is_main_site() ) ? esc_html__( 'Yes', 'acf-place-selector' ) : esc_html__( 'No', 'acf-place-selector' ); ?>
                                        <?php $prepare_json[ 'multisite' ][ 'main_site' ] = $main_site; ?>
                                        <td><?php esc_html_e( 'Main site', 'acf-place-selector' ); ?></td>
                                        <td><?php echo $main_site; ?> </td>
                                    </tr>
                                    <tr>
                                        <?php $registration = ( get_site_option( 'registration' ) ) ? 'TRUE' : 'FALSE'; ?>
                                        <?php $prepare_json[ 'multisite' ][ 'registration' ] = $registration; ?>
                                        <td><?php esc_html_e( 'Main registration', 'acf-place-selector' ); ?></td>
                                        <td><?php echo $registration; ?> </td>
                                    </tr>
                                    <?php if ( class_exists( 'B3Onboarding' ) ) { ?>
                                        <?php $subsite_registration = ( get_option( 'b3_registration_type' ) ) ? 'TRUE' : 'FALSE'; ?>
                                        <?php $prepare_json[ 'multisite' ][ 'subsite_registration' ] = $subsite_registration; ?>
                                        <tr>
                                            <td><?php esc_html_e( 'Subsite registration', 'acf-place-selector' ); ?></td>
                                            <td><?php echo $subsite_registration; ?> </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>


                            <h2>
                                <?php esc_html_e( 'Active plugins', 'acf-place-selector' ); ?>
                            </h2>

                            <?php $plugins = get_plugins(); ?>
                            <?php if ( ! empty( $plugins ) ) { ?>
                                <table class="acfps__table acfps__table--info">
                                    <thead>
                                    <tr>
                                        <th><?php esc_html_e( 'Name', 'acf-place-selector' ); ?></th>
                                        <th><?php esc_html_e( 'Version', 'acf-place-selector' ); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach( $plugins as $key => $value ) { ?>
                                        <?php if ( is_plugin_active( $key ) ) { ?>
                                            <?php $prepare_json[ 'plugins' ][] = [ 'name' => $value[ 'Name' ], 'version' => $value[ 'Version' ], 'author' => $value[ 'Author' ], 'author_uri' => $value[ 'AuthorURI' ] ]; ?>
                                            <tr>
                                                <td>
                                                    <?php echo $value[ 'Name' ]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value[ 'Version' ]; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>

                        <div class="acfps__section acfps__section--export">
                            <h2>
                                <?php esc_html_e( 'Download JSON', 'acf-place-selector' ); ?>
                            </h2>
                            <p>
                                <?php esc_html_e( "If you're in need of support, the info above might helpful for us to fix a problem.", 'acf-place-selector' ); ?>
                                <br />
                                <?php esc_html_e( 'You can download the settings to a JSON file below (and send it to us when asked).', 'acf-place-selector' ); ?>
                            </p>
                            <?php $file_name       = acfps_upload_folder( '/' ) . 'debug.json'; ?>
                            <?php $serialized_json = json_encode( $prepare_json ); // encode json before saving ?>
                            <?php file_put_contents( $file_name, $serialized_json ); // write to file ?>
                            <p class="json_button">
                                <a href="<?php echo wp_upload_dir()['baseurl'] . '/acfps/debug.json'; ?>" class="button button-primary">
                                    <?php esc_attr_e( 'View JSON file', 'acf-place-selector' ); ?>
                                </a> <small>(right-click to save)</small>
                            </p>
                        </div>

                    </div>
                </div>

                <?php include 'admin-right.php'; ?>

            </div>
        </div>
        <?php
    }
