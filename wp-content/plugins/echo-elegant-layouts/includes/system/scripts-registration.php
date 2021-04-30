<?php

/**  Register JS and CSS files  */

/**
 * FRONT-END pages using our plugin features
 */
function elay_load_public_resources() {

	global $eckb_kb_id;
	
	elay_register_public_resources();
	
	$post = empty($GLOBALS['post']) ? '' : $GLOBALS['post'];
	if ( ! class_exists( ELAY_KB_Core::ELAY_KB_KNOWLEDGE_BASE) || empty($post) || empty($eckb_kb_id) ) {
		return;
	}

	elay_load_public_resources_now();

	// if this is ELAY layout then load ELAY resources
	/*$article_page_layout = ELAY_KB_Core::get_value( $eckb_kb_id, 'kb_article_page_layout' );
	$main_page_layout = ELAY_KB_Core::get_value( $eckb_kb_id, 'kb_main_page_layout' );
	if ( $main_page_layout == ELAY_KB_Config_Layout_Grid::LAYOUT_NAME ||
	     $main_page_layout == ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ||
	     $article_page_layout == ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ) {
		elay_load_public_resources_now();
		return;
	}*/

}
add_action( 'wp_enqueue_scripts', 'elay_load_public_resources' );
add_action( 'epkb_enqueue_scripts', 'elay_load_public_resources_now' );

function elay_register_public_resources() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_style( 'elay-public-styles', Echo_Elegant_Layouts::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	wp_register_script( 'elay-public-scripts', Echo_Elegant_Layouts::$plugin_url . 'js/public-scripts' . $suffix . '.js', array(), Echo_Elegant_Layouts::$version );
	wp_localize_script( 'elay-public-scripts', 'elay_vars', array(
		'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
		'error_occurred'        => esc_html__( 'Error occurred (16)', 'echo-knowledge-base' ),
		'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
		'unknown_error'         => esc_html__( 'unknown error (17)', 'echo-knowledge-base' ),
		'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
		'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
		'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
		'reduce_name_size'      => esc_html__( 'Warning: Please reduce your name size. Tab will only show first 25 characters', 'echo-knowledge-base' ),
	));
}

function elay_load_public_resources_now() {
	wp_enqueue_style( 'elay-public-styles' );
	wp_enqueue_script( 'elay-public-scripts' );
}

/**
 * Only used for KB Configuration page
 */
function elay_kb_config_load_public_css() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'elay-public-styles', Echo_Elegant_Layouts::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
}


/**
 * ADMIN-PLUGIN MENU PAGES (Plugin settings, reports, lists etc.)
 */
function elay_load_admin_plugin_pages_resources(  ) {

	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'elay-admin-plugin-pages-styles', Echo_Elegant_Layouts::$plugin_url . 'css/admin-plugin-pages' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	wp_enqueue_style( 'wp-color-picker' ); //Color picker

	wp_enqueue_script( 'elay-admin-plugin-pages-scripts', Echo_Elegant_Layouts::$plugin_url . 'js/admin-plugin-pages' . $suffix . '.js',
					array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core','jquery-effects-bounce', 'jquery-ui-sortable'), Echo_Elegant_Layouts::$version );
	wp_localize_script( 'elay-admin-plugin-pages-scripts', 'elay_vars', array(
					'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
					'error_occurred'        => esc_html__( 'Error occurred (11)', 'echo-knowledge-base' ),
					'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved (12).', 'echo-knowledge-base' ),
					'unknown_error'         => esc_html__( 'unknown error (13)', 'echo-knowledge-base' ),
					'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
					'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
					'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
				));

	if ( ELAY_Utilities::get('page') == ELAY_KB_Core::ELAY_KB_CONFIGURATION_PAGE ) {
		wp_enqueue_script( 'elay-admin-kb-config-script', Echo_Elegant_Layouts::$plugin_url . 'js/admin-elay-config-script' . $suffix . '.js',
			array('jquery',	'jquery-ui-core', 'jquery-ui-dialog', 'jquery-effects-core', 'jquery-effects-bounce'), Echo_Elegant_Layouts::$version );
		wp_localize_script( 'elay-admin-kb-config-script', 'elay_vars', array(
			'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
			'error_occurred'        => esc_html__( 'Error occurred (14)', 'echo-knowledge-base' ),
			'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
			'unknown_error'         => esc_html__( 'unknown error (15)', 'echo-knowledge-base' ),
			'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
			'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
			'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' )
		));
	}
		
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}

/**
 * Certain styles need to be inserted in the header.
 *
 * @param $add_on_output
 * @param $kb_id
 * @param $is_kb_main_page
 * @return string
 */
function elay_frontend_kb_theme_styles_now( $add_on_output, $kb_id, $is_kb_main_page ) {

	$add_on_config = elay_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );

	// if this is not Sidebar Layout then don't continue
	$article_page_layout = ELAY_KB_Core::get_value( $kb_id, 'kb_article_page_layout' );
	$main_page_layout = ELAY_KB_Core::get_value( $kb_id, 'kb_main_page_layout' );
	if ( ( $is_kb_main_page && $main_page_layout != ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME) ||
	     ( ! $is_kb_main_page && $article_page_layout != ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ) ) {
		return $add_on_output;
	}

	$add_on_output .= '
		/* ELAY2 
		-----------------------------------------------------------------------*/
		#elay-content-container .elay-articles .active {
			background-color: ' . $add_on_config['sidebar_article_active_background_color'] . ' !important;
			border-radius: 4px;
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-left: -5px !important;
		}
		#elay-content-container .elay-articles .active span {
			color: ' . $add_on_config['sidebar_article_active_font_color'] . ' !important;
		}
		#elay-content-container .elay-articles .active i {
			color: ' . $add_on_config['sidebar_article_active_font_color'] . ' !important;
		}
	';

	return $add_on_output;

}
add_filter( 'eckb_frontend_kb_theme_style', 'elay_frontend_kb_theme_styles_now', 10, 3 );

