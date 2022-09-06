<?php
    // if uninstall.php is not called by WordPress, die
    if ( ! defined('WP_UNINSTALL_PLUGIN' ) ) {
        die();
    }

    if ( false != get_option( 'acfps_delete_places_table' ) ) {
        // drop table
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}places");
    }
