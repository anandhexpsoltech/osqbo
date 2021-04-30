<?php

/**  Register JS and CSS files  */

/**
 * FRONT-END pages using our plugin features
 */
function epie_load_public_resources() {

	// TODO limit to public KB pages only 

	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style('epie-public-styles', Echo_KB_Import_Export::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_KB_Import_Export::$version );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_script('epie-public-scripts', Echo_KB_Import_Export::$plugin_url . 'js/public-scripts' . $suffix . '.js',
					array('jquery', 'jquery-ui-core', 'jquery-ui-dialog', 'jquery-effects-core', 'jquery-effects-bounce'), Echo_KB_Import_Export::$version );
}
// NOT YET APPLICABLE: add_action( 'wp_enqueue_scripts', 'epie_load_public_resources' );

/**
 * ADMIN-PLUGIN MENU PAGES (Plugin settings, reports, lists etc.)
 */
function epie_load_admin_plugin_pages_resources() {

	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style('epie-admin-plugin-pages-styles', Echo_KB_Import_Export::$plugin_url . 'css/admin-plugin-pages' . $suffix . '.css', array(), Echo_KB_Import_Export::$version );
	wp_enqueue_style( 'wp-color-picker' ); //Color picker

	wp_enqueue_script('epie-admin-plugin-pages-scripts', Echo_KB_Import_Export::$plugin_url . 'js/admin-plugin-pages' . $suffix . '.js',
					array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core','jquery-effects-bounce', 'jquery-ui-sortable'), Echo_KB_Import_Export::$version );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	
	wp_localize_script( 'epie-admin-plugin-pages-scripts', 'epie_vars', array(
		'msg_content_import'         => esc_html__( 'Content Import', 'echo-kb-import-export' ),
		'msg_start_over'         => esc_html__( 'Start Over ', 'echo-kb-import-export' ),
		'msg_imported_articles'         => esc_html__( 'Number of imported articles: ', 'echo-kb-import-export' ),
		'msg_start_again'         => esc_html__( 'Start import from the beginning?', 'echo-kb-import-export' ),
		'msg_yes'         => esc_html__( 'Yes', 'echo-kb-import-export' ),
		'msg_no'         => esc_html__( 'No', 'echo-kb-import-export' ),
		'msg_ok'         => esc_html__( 'Ok', 'echo-kb-import-export' ),
		'msg_0_imported' => __( 'Processed 0 articles out of ', 'echo-kb-import-export' ),
		'msg_admin_error_l01'         => esc_html__( 'KB Import Export: Error occurred. Please try again later. (L01)', 'echo-kb-import-export' ),
		'msg_admin_error_l012'         => esc_html__( 'KB Import Export: Error occurred. Please try again later.', 'echo-kb-import-export' ),
		'msg_stop_import'         => esc_html__( 'Stopping the import process...', 'echo-kb-import-export' ),
	));
}
