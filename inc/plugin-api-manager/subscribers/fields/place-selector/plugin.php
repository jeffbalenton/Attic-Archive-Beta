<?php
    /*
    Plugin Name:    ACF City Selector
    Plugin URI:     https://acf-place-selector.com
    Description:    An extension for ACF which allows you to select a city based on country and province/state.
    Version:        1.3.2
    Tested up to:   5.7.1
    Requires PHP:   7.0
    Author:         Beee
    Author URI:     https://berryplasman.com
    Text Domain:    acf-place-selector
    Domain Path:    /languages
    License:        GPLv2 or later
    License URI:    https://www.gnu.org/licenses/gpl.html
    */

    if ( ! defined( 'ABSPATH' ) ) exit;

    // check if class already exists
    if ( ! class_exists( 'ACF_Place_Selector' ) ) {

        /*
         * Main class
         */
        class ACF_Place_Selector {

            /*
             * __construct
             *
             * This function will setup the class functionality
             */
            public function __construct() {

                $this->settings = array(
                    'db_version' => '1.0',
                    'url'        => my_plugins_dir_url( 'acf/custom/fields/place-selector/plugin.php' ),
                    'version'    => '1.3.2',
                );

                if ( ! class_exists( 'acfps_WEBSITE_URL' ) ) {
                    define( 'acfps_WEBSITE_URL', 'https://acf-place-selector.com' );
                }

                if ( ! defined( 'acfps_PLUGIN_PATH' ) ) {
                    $plugin_path = get_template_directory() .'/inc/acf/custom/fields/place-selector';
						
                    define( 'acfps_PLUGIN_PATH', $plugin_path );
                }

                if ( ! defined( 'acfps_PLUGIN_URL' ) ) {
                    $plugin_url = get_template_directory_uri() .'/inc/acf/custom/fields/place-selector';
                    define( 'acfps_PLUGIN_URL', $plugin_url );
                }

               // load_plugin_textdomain( 'acf-place-selector', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

               // register_activation_hook( __FILE__,             array( $this, 'acfps_plugin_activation' ) );
               // register_deactivation_hook( __FILE__,           array( $this, 'acfps_plugin_deactivation' ) );

              //  add_action( 'acf/register_fields',                  array( $this, 'acfps_include_field_types' ) );    // v4
                //add_action( 'acf/include_field_types',              array( $this, 'acfps_include_field_types' ) );    // v5

                add_action( 'admin_enqueue_scripts',                array( $this, 'acfps_add_scripts' ) );
                add_action( 'wp_enqueue_scripts',                   array( $this, 'acfps_add_scripts' ) );

                add_action( 'admin_menu',                           array( $this, 'acfps_add_admin_pages' ) );
                add_action( 'admin_init',                           array( $this, 'acfps_admin_menu' ) );
                add_action( 'admin_init',                           array( $this, 'acfps_errors' ) );
				add_action( 'admin_init',                           array( $this, 'acfps_check_uploads_folder' ) );
                add_action( 'admin_init',                           array( $this, 'acfps_check_table' ) );
			
               // add_action( 'plugins_loaded',                       array( $this, 'acfps_change_plugin_order' ), 5 );
                //add_action( 'plugins_loaded',                       array( $this, 'acfps_check_for_acf' ), 6 );
              //  add_action( 'plugins_loaded',                       array( $this, 'acfps_check_acf_version' ) );

              //  add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'acfps_settings_link' ) );

                require 'inc/acfps-actions.php';
                require 'inc/acfps-functions.php';
                require 'inc/acfps-help-tabs.php';
                require 'inc/acfps-i18n.php';
               require 'inc/acfps-ajax.php';
                require 'inc/form-handling.php';

            }


            /*
             * Do stuff upon plugin activation
             */
            public function acfps_plugin_activation() {
                $this->acfps_check_table();
                $this->acfps_check_uploads_folder();
                if ( false == get_option( 'acfps_preserve_settings' ) ) {
                    $this->acfps_fill_database();
                }
            }


            /*
             * Do stuff upon plugin activation
             */
            public function acfps_plugin_deactivation() {
                delete_option( 'acfps_db_version' );
                // this hook is here because didn't want to create a new hook for an existing action
                do_action( 'acfps_delete_transients' );
                // other important stuff gets done in uninstall.php
            }


            /*
             * Prepare database upon plugin activation
             */
            public function acfps_fill_database() {
                $countries = array( 'nl', 'be' );
                foreach( $countries as $country ) {
                    acfps_import_data( $country . '.csv', acfps_PLUGIN_PATH . 'import/' );
                }
            }


            /*
             * Check if table exists
             */
            public function acfps_check_table() {
                $acfps_db_version = get_option( 'acfps_db_version', false );
                if ( false == $acfps_db_version || $acfps_db_version != $this->settings[ 'db_version' ] ) {
                    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
                    ob_start();
                    global $wpdb;
                    ?>
                    CREATE TABLE <?php echo $wpdb->prefix; ?>places (
                    id int(6) unsigned NOT NULL auto_increment,
                    city_name varchar(50) NULL,
                    state_code varchar(3) NULL,
                    state_name varchar(50) NULL,
                    country_code varchar(2) NULL,
                    country varchar(50) NULL,
                    PRIMARY KEY  (id)
                    )
                    COLLATE <?php echo $wpdb->collate; ?>;
                    <?php
                    $sql = ob_get_clean();
                    dbDelta( $sql );
                    update_option( 'acfps_db_version', $this->settings[ 'db_version' ] );
                }
				
				 if ( false == get_option( 'acfps_preserve_settings' ) ) {
                    $this->acfps_fill_database();
					 update_option('acfps_preserve_settings', true);
                }
            }


            /*
             * Check if (upload) folder exists
             * If not, create it.
             */
            public static function acfps_check_uploads_folder() {
                $target_folder = acfps_upload_folder( '/' );
                if ( ! file_exists( $target_folder ) ) {
                    mkdir( $target_folder, 0755 );
                }
            }


            /*
             * Error function
             *
             * @return WP_Error
             */
            public static function acfps_errors() {
                static $wp_error; // Will hold global variable safely

                return isset( $wp_error ) ? $wp_error : ( $wp_error = new WP_Error( null, null, null ) );
            }


            /*
             * Displays error messages from form submissions
             */
            public static function acfps_show_admin_notices() {
                if ( $codes = ACF_Place_Selector::acfps_errors()->get_error_codes() ) {
                    if ( is_wp_error( ACF_Place_Selector::acfps_errors() ) ) {
                        $span_class = false;
                        $prefix     = false;
                        foreach ( $codes as $code ) {
                            if ( strpos( $code, 'success' ) !== false ) {
                                $span_class = 'notice--success ';
                            } elseif ( strpos( $code, 'error' ) !== false ) {
                                $span_class = 'error ';
                            } elseif ( strpos( $code, 'warning' ) !== false ) {
                                $span_class = 'notice--warning ';
                            } elseif ( strpos( $code, 'info' ) !== false ) {
                                $span_class = 'notice--info ';
                            } else {
                                $span_class = 'notice--error ';
                            }
                        }
                        echo '<div id="message" class="notice ' . $span_class . 'is-dismissible">';
                        foreach ( $codes as $code ) {
                            $message = ACF_Place_Selector::acfps_errors()->get_error_message( $code );
                            echo '<p class="">';
                            echo $message;
                            echo '</p>';
                        }
                        echo '</div>';
                    }
                }
            }


            /**
             * include_field_types
             *
             * This function will include the field type class
             *
             * @param bool $version (int) major ACF version. Defaults to false
             */
            public function acfps_include_field_types( $version = false ) {
                if ( ! $version ) { $version = 4; }
                include_once( 'fields/acf-place-selector-v' . $version . '.php' );
            }


            /*
             * Add settings link on plugin page
             *
             * @param $links
             *
             * @return array
             */
            public function acfps_settings_link( $links ) {
                $settings_link = [ 'settings' => '<a href="options-general.php?page=acfps-dashboard">' . esc_html__( 'Settings', 'acf-place-selector' ) . '</a>' ];
                $links         = array_merge( $settings_link, $links );

                return $links;
            }


            /*
             * Admin menu
             */
            public static function acfps_admin_menu() {
                $admin_url      = admin_url('page=materials' );
                $info           = false;
                $preview        = false;
                $search         = false;
                $url_array      = parse_url( esc_url_raw( $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] ) );

                if ( isset( $url_array[ 'query' ] ) ) {
                    $acfps_subpage = substr( $url_array[ 'query' ], 11 );
                }

                $current_page = ( isset( $acfps_subpage ) && 'dashboard' == $acfps_subpage ) ? ' class="current_page"' : false;
                $dashboard    = '<a href="' . $admin_url . 'acfps-dashboard"' . $current_page . '>' . esc_html__( 'Dashboard', 'acf-place-selector' ) . '</a>';
                $current_page = ( isset( $acfps_subpage ) && 'settings' == $acfps_subpage ) ? ' class="current_page"' : false;
                $settings     = ' | <a href="' . $admin_url . 'acfps-settings"' . $current_page . '>' . esc_html__( 'Settings', 'acf-place-selector' ) . '</a>';

                if ( true === acfps_has_places() ) {
                    $current_page = ( isset( $acfps_subpage ) && 'search' == $acfps_subpage ) ? ' class="current_page"' : false;
                    $search = ' | <a href="' . $admin_url . 'acfps-search"' . $current_page . '>' . esc_html__( 'Search', 'acf-place-selector' ) . '</a>';
                }

                if ( ! empty ( acfps_check_if_files() ) ) {
                    $current_page = ( isset( $acfps_subpage ) && 'preview' == $acfps_subpage ) ? ' class="current_page"' : false;
                    $preview = ' | <a href="' . $admin_url . 'acfps-preview"' . $current_page . '>' . esc_html__( 'Preview', 'acf-place-selector' ) . '</a>';
                }

                if ( current_user_can( 'manage_options' ) ) {
                    $current_page = ( isset( $acfps_subpage ) && 'info' == $acfps_subpage ) ? ' class="current_page"' : false;
                    $info = ' | <a href="' . $admin_url . 'acfps-info"' . $current_page . '>' . esc_html__( 'Info', 'acf-place-selector' ) . '</a>';
                }

                $countries = ' | <a href="' . $admin_url . 'acfps-countries" class="cta">' . esc_html__( 'Get more countries', 'acf-place-selector' ) . '</a>';

                $menu = '<p class="acfps-admin-menu">' . $dashboard . $search . $preview . $settings . $info  . '</p>';

                return $menu;
            }


            /*
             * Check if ACF is active and if not add an admin notice
             */
            public function acfps_check_for_acf() {
                if ( ! class_exists( 'acf' ) ) {
                    add_action( 'admin_notices', function () {
                        echo '<div class="notice notice-error"><p>';
                        echo sprintf( __( '"%s" is not activated. This plugin <strong>must</strong> be activated, because without it "%s" won\'t work. Activate it <a href="%s">here</a>.', 'acf-place-selector' ),
                            'Advanced Custom Fields',
                            'ACF City Selector',
                            esc_url( admin_url( 'plugins.php?s=acf&plugin_status=inactive' ) ) );
                        echo '</p></div>';
                    });
                }
            }


            /*
             * Add admin notice when ACF version < 5
             */
            public function acfps_check_acf_version() {
                if ( ! function_exists( 'get_plugins' ) ) {
                    require_once ABSPATH . 'wp-admin/includes/plugin.php';
                }
                $plugins = get_plugins();

                if ( isset( $plugins[ 'advanced-custom-fields-pro/acf.php' ] ) ) {
                    if ( $plugins[ 'advanced-custom-fields-pro/acf.php' ][ 'Version' ] < 5 && is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
                        add_action( 'admin_notices', function () {
                            echo '<div class="notice notice-error"><p>';
                            echo sprintf( __( '<b>Warning</b>: The "%s" plugin will probably not work properly (anymore) with %s v4.x. Please upgrade to PRO.', 'acf-place-selector' ), 'City Selector', 'Advanced Custom Fields' );
                            echo '</p></div>';
                        } );
                    }
                }
            }


            /*
             * Change plugin order so acfps loads after ACF
             */
            public function acfps_change_plugin_order() {
                $active_plugins = get_option( 'active_plugins' );
                $acfps_key      = array_search( 'acf-place-selector/ACF_Place_Selector.php', $active_plugins );
                $acf_key        = array_search( 'advanced-custom-fields-pro/acf.php', $active_plugins );
                if ( false !== $acf_key && false !== $acfps_key ) {
                    if ( $acfps_key < $acf_key ) {
                        $this->acfps_move_array_element( $active_plugins, $acfps_key, $acf_key );
                        update_option( 'active_plugins', $active_plugins, true );
                    }
                }
            }


            /**
             * Move array element to specific position
             *
             * @param $array
             * @param $from_index
             * @param $to_index
             */
            public static function acfps_move_array_element( &$array, $from_index, $to_index ) {
                $splice = array_splice( $array, $from_index, 1 );
                array_splice( $array, $to_index, 0, $splice );
            }


            /*
             * Add admin pages
             */
            public function acfps_add_admin_pages() {
                include 'admin/acfps-dashboard.php';
                add_options_page( 'ACF Place Selector', 'Place Selector', 'manage_options', 'acfps-dashboard', 'acfps_dashboard' );

                include 'admin/acfps-preview.php';
                add_submenu_page( null, 'Preview data', 'Preview data', 'manage_options', 'acfps-preview', 'acfps_preview_page' );

                include 'admin/acfps-settings.php';
                add_submenu_page( null, 'Settings', 'Settings', 'manage_options', 'acfps-settings', 'acfps_settings' );

                if ( true === acfps_has_places() ) {
                    include 'admin/acfps-search.php';
                    add_submenu_page( null, 'City Overview', 'City Overview', 'manage_options', 'acfps-search', 'acfps_search' );
                }
                
                if ( current_user_can( 'manage_options' ) ) {
                    include 'admin/acfps-info.php';
                    add_submenu_page( null, 'Info', 'Info', 'manage_options', 'acfps-info', 'acfps_info_page' );
                }

               /* include 'admin/acfps-countries.php';
                add_submenu_page( null, 'Get countries', 'Get countries', 'manage_options', 'acfps-countries', 'acfps_country_page' ); */
            }


            /*
             * Adds CSS on the admin side
             */
            public function acfps_add_scripts() {
                wp_enqueue_style( 'acfps-general', my_plugins_url( 'assets/css/general.css', 'acf/custom/fields/place-selector/plugin.php' ), [], $this->settings[ 'version' ] );
                if ( is_admin() ) {
                    wp_enqueue_style( 'acfps-admin', my_plugins_url( 'assets/css/admin.css', 'acf/custom/fields/place-selector/plugin.php' ), [], $this->settings[ 'version' ] );
                    wp_register_script( 'acfps-admin', my_plugins_url( 'assets/js/upload-csv.js', 'acf/custom/fields/place-selector/plugin.php' ), [ 'jquery' ], $this->settings[ 'version' ] );
                    wp_enqueue_script( 'acfps-admin' );
                }
            }
        }

        new ACF_Place_Selector();

    }
