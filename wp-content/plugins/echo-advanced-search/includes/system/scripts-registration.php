<?php

/**  Register JS and CSS files  */

/**
 * FRONT-END pages using our plugin features
 */
function asea_load_public_resources() {

	global $eckb_kb_id;
	
	asea_register_public_resources();
	
	// if this is not KB Main Page then do not load public resources or is a Category Archive page
	if ( empty($eckb_kb_id) ) {
		return;
	}

	asea_load_public_resources_now( $eckb_kb_id );
}
add_action( 'wp_enqueue_scripts', 'asea_load_public_resources' );
add_action( 'epkb_enqueue_scripts', 'asea_load_public_resources_now' );

function asea_register_public_resources( ) {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_style( 'asea-public-styles', Echo_Advanced_Search::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Advanced_Search::$version );
	wp_register_script( 'asea-jquery-ui-autocomplete', Echo_Advanced_Search::$plugin_url . 'js/asea-jquery-ui-autocomplete.min.js', array( 'jquery-ui-menu', 'wp-a11y' ), Echo_Advanced_Search::$version );
	wp_register_script( 'asea-public-scripts', Echo_Advanced_Search::$plugin_url . 'js/public-scripts' . $suffix . '.js', array('asea-jquery-ui-autocomplete'), Echo_Advanced_Search::$version );
	
}

function asea_load_public_resources_now( $eckb_kb_id = 0 ) {
	
	wp_enqueue_style( 'asea-public-styles' );
	wp_enqueue_script( 'asea-jquery-ui-autocomplete' );
	wp_enqueue_script( 'asea-public-scripts' );
	
	if ( empty($eckb_kb_id) ) {
		$auto_complete_wait = 1000;
	} else {
		$kb_config = asea_get_instance()->kb_config_obj->get_kb_config( $eckb_kb_id );
		$auto_complete_wait = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_auto_complete_wait' );
	}
	
	wp_localize_script( 'asea-public-scripts', 'asea_vars', array(
		'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
		'error_occurred'        => esc_html__( 'Error occurred (16)', 'echo-knowledge-base' ),
		'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
		'unknown_error'         => esc_html__( 'unknown error (17)', 'echo-knowledge-base' ),
		'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
		'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
		'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
		'advanced_search_auto_complete_wait'   => $auto_complete_wait,
	));
}

/**
 * ADMIN-PLUGIN MENU PAGES (Plugin settings, reports, lists etc.)
 */
function asea_load_admin_plugin_pages_resources() {

	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'asea-admin-plugin-pages-styles', Echo_Advanced_Search::$plugin_url . 'css/admin-plugin-pages' . $suffix . '.css', array(), Echo_Advanced_Search::$version );
	wp_enqueue_script( 'asea-admin-plugin-pages-scripts', Echo_Advanced_Search::$plugin_url . 'js/admin-plugin-pages' . $suffix . '.js',
					array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core'), Echo_Advanced_Search::$version );
	wp_localize_script( 'asea-admin-plugin-pages-scripts', 'asea_vars', array(
					'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
					'error_occurred'        => esc_html__( 'Error occurred (11)', 'echo-knowledge-base' ),
					'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved (12).', 'echo-knowledge-base' ),
					'unknown_error'         => esc_html__( 'unknown error (13)', 'echo-knowledge-base' ),
					'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
					'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
					'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
				));

	// data tables
	wp_enqueue_style( 'asea-admin-plugin-datatables-styles', Echo_Advanced_Search::$plugin_url . 'css/jquery.datatables-custom.min.css', array(), Echo_Advanced_Search::$version );
	wp_enqueue_script( 'asea-admin-jquery-datatables', Echo_Advanced_Search::$plugin_url . 'js/jquery.datatables.min.js', array( 'jquery' ), Echo_Advanced_Search::$version );

	if ( ASEA_Utilities::get('page', '', false) == 'ep'.'kb-plugin-analytics' ) {
		wp_enqueue_script( 'asea-admin-jquery-chart', Echo_Advanced_Search::$plugin_url . 'js/Chart.min.js', array( 'jquery' ), Echo_Advanced_Search::$version );
		wp_enqueue_script( 'asea-analytic-page-scripts', Echo_Advanced_Search::$plugin_url . 'js/admin-analytics' . $suffix . '.js',
				array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core'), Echo_Advanced_Search::$version );
	}

	// datarange widget
	wp_enqueue_style( 'asea-admin-plugin-datarange-styles', Echo_Advanced_Search::$plugin_url . 'css/daterangepicker.css', array(), Echo_Advanced_Search::$version );
	wp_enqueue_script( 'asea-admin-jquery-datarange', Echo_Advanced_Search::$plugin_url . 'js/moment.min.js', array( 'jquery' ), Echo_Advanced_Search::$version );
	wp_enqueue_script( 'asea-admin-jquery-datarange2', Echo_Advanced_Search::$plugin_url . 'js/daterangepicker.min.js', array( 'jquery' ), Echo_Advanced_Search::$version );

	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}
