<?php

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;


/**
 * Uninstall this plugin
 *
 */


flush_rewrite_rules(false);

/** Delete plugin options */
// do not delete 'epie_version' so we know whether this is a new install
// TODO if user explicitly specifies: delete_option( 'epie_version' );
delete_option( 'epie_error_log' );
delete_option( 'epie_license_key' );
delete_option( 'epie_license_status' );
delete_option( 'epie_license_state' );