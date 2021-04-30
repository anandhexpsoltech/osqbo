<?php

/**  Register JS and CSS files  */

/**
 * FRONT-END pages using our plugin features
 */
function eprf_load_public_resources() {

	global $eckb_kb_id;

	$post = empty($GLOBALS['post']) ? '' : $GLOBALS['post'];
	if ( ! class_exists( EPRF_KB_Core::EPRF_KB_KNOWLEDGE_BASE) || empty($post) || empty($eckb_kb_id) ) {
		return;
	}

	// if this is KB Article then load EPRF resources
	eprf_load_public_resources_now( $eckb_kb_id );
}
add_action( 'wp_enqueue_scripts', 'eprf_load_public_resources' );

function eprf_load_public_resources_now( $eckb_kb_id ) {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'eprf-public-styles', Echo_Article_Rating_And_Feedback::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Article_Rating_And_Feedback::$version );
	wp_enqueue_script( 'eprf-public-scripts', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/public-scripts' . $suffix . '.js', array(), Echo_Article_Rating_And_Feedback::$version );
	wp_localize_script( 'eprf-public-scripts', 'eprf_vars', array(
		'ajaxurl'               => admin_url( 'admin-ajax.php' ),
		'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
		'error_occurred'        => esc_html__( 'Error occurred (16)', 'echo-knowledge-base' ),
		'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
		'unknown_error'         => esc_html__( 'unknown error (17)', 'echo-knowledge-base' ),
		'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
		'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
		'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
		'reduce_name_size'      => esc_html__( 'Warning: Please reduce your name size. Tab will only show first 25 characters', 'echo-knowledge-base' ),
		'kb_id'                 => $eckb_kb_id,
		'eprf_rating_nonce'     => wp_create_nonce('_wpnonce_user_rating_action_ajax')
	));
}

/**
 * Only used for KB Configuration page
 */
function eprf_kb_config_load_public_css() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'eprf-public-styles', Echo_Article_Rating_And_Feedback::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Article_Rating_And_Feedback::$version );
}

/**
 * ADMIN-PLUGIN MENU PAGES (Plugin settings, reports, lists etc.)
 */
function eprf_load_admin_plugin_pages_resources() {

	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'eprf-admin-plugin-pages-styles', Echo_Article_Rating_And_Feedback::$plugin_url . 'css/admin-plugin-pages' . $suffix . '.css', array(), Echo_Article_Rating_And_Feedback::$version );
	wp_enqueue_style( 'wp-color-picker' ); //Color picker

	wp_enqueue_script( 'eprf-admin-plugin-pages-scripts', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/admin-plugin-pages' . $suffix . '.js',
					array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core','jquery-effects-bounce', 'jquery-ui-sortable'), Echo_Article_Rating_And_Feedback::$version );
	wp_localize_script( 'eprf-admin-plugin-pages-scripts', 'eprf_vars', array(
					'ajaxurl'               => admin_url( 'admin-ajax.php' ),
					'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
					'error_occurred'        => esc_html__( 'Error occurred (11)', 'echo-knowledge-base' ),
					'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved (12).', 'echo-knowledge-base' ),
					'unknown_error'         => esc_html__( 'unknown error (13)', 'echo-knowledge-base' ),
					'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
					'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
					'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' )
				));

	if ( EPRF_Utilities::get('page') == EPRF_KB_Core::EPRF_KB_CONFIGURATION_PAGE ) {
		wp_enqueue_script( 'eprf-admin-kb-config-script', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/admin-eprf-config-script' . $suffix . '.js',
			array('jquery',	'jquery-ui-core', 'jquery-ui-dialog', 'jquery-effects-core', 'jquery-effects-bounce'), Echo_Article_Rating_And_Feedback::$version );
		wp_localize_script( 'eprf-admin-kb-config-script', 'eprf_vars', array(
			'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
			'error_occurred'        => esc_html__( 'Error occurred (14)', 'echo-knowledge-base' ),
			'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
			'unknown_error'         => esc_html__( 'unknown error (15)', 'echo-knowledge-base' ),
			'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
			'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
			'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' )
		));
	}

	if ( EPRF_Utilities::is_block_editor_active() && EPRF_Utilities::get('post') && EPRF_Utilities::get('action') == 'edit' && strstr(get_post_type(EPRF_Utilities::get('post')), 'ep'.'kb_post_type')) {
		wp_enqueue_script( 'eprf-admin-kb-gutenberg-script', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/admin-gutenberg-scripts' . $suffix . '.js', array(
            'wp-plugins',
            'wp-edit-post',
            'wp-element',
            'wp-components'
        )
		);
	}
		
	// data tables
	wp_enqueue_style( 'eprf-admin-plugin-datatables-styles', Echo_Article_Rating_And_Feedback::$plugin_url . 'css/jquery.datatables-custom.min.css', array(), Echo_Article_Rating_And_Feedback::$version );
	
	
	
	wp_enqueue_script( 'eprf-admin-jquery-datatables', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/jquery.datatables.min.js', array( 'jquery' ), Echo_Article_Rating_And_Feedback::$version );

	if ( eprf_Utilities::get('page', '', false) == 'ep'.'kb-plugin-analytics' ) {
		wp_enqueue_script( 'eprf-admin-jquery-chart', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/chart.min.js', array( 'jquery' ), Echo_Article_Rating_And_Feedback::$version );
		wp_enqueue_script( 'eprf-admin-analytics-scripts', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/admin-analytics' . $suffix . '.js',
				array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core'), Echo_Article_Rating_And_Feedback::$version );
	}

	// datarange
	wp_enqueue_style( 'eprf-admin-plugin-datarange-styles', Echo_Article_Rating_And_Feedback::$plugin_url . 'css/daterangepicker.css', array(), Echo_Article_Rating_And_Feedback::$version );
	wp_enqueue_script( 'eprf-admin-jquery-datarange', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/moment.min.js', array( 'jquery' ), Echo_Article_Rating_And_Feedback::$version );
	wp_enqueue_script( 'eprf-admin-jquery-datarange2', Echo_Article_Rating_And_Feedback::$plugin_url . 'js/daterangepicker.min.js', array( 'jquery' ), Echo_Article_Rating_And_Feedback::$version );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}
