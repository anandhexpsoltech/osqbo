<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class EPIE_KB_Core {

	const DEFAULT_KB_ID = 1;
	const EPIE_KB_CONFIG_PREFIX =  'epkb_config_';
	const EPIE_KB_DEBUG = 'epkb_debug';
	const EPIE_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const EPIE_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update
	const EPIE_ARTICLES_SEQUENCE = 'epkb_articles_sequence';
	const EPIE_CATEGORIES_SEQUENCE = 'epkb_categories_sequence';
	const EPIE_CATEGORIES_ICONS = 'epkb_categories_icons_images';

	// plugin pages
	const EPIE_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const EPIE_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const EPIE_KB_LICENSES_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-add-ons&epkb-tab=licenses';
	const EPIE_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const EPIE_KB_LICENSE_FIELD = 'epkb_license_fields';
	const EPIE_KB_DEBUG_PAGE = 'epkb-add-ons';

	// FILTERS
	const EPIE_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';

    // actions
    const EPIE_LOAD_ADMIN_PLUGIN_PAGES_RESOURCES = 'epkb_load_admin_plugin_pages_resources';
	const EPIE_KB_FLUSH_REWRITE_RULES = 'epkb_flush_rewrite_rules';

	// KB states
	const PUBLISHED = 'published';
	const ARCHIVED = 'archived';



	/**
	 * Get value from KB Configuration
	 *
	 * @param string $kb_id
	 * @param $setting_name
	 * @param string $default
	 *
	 * @return string|array with value or $default value if this settings not found
	 */
	public static function get_value( $kb_id='', $setting_name, $default='' ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_value( $setting_name, $kb_id, $default ); // TODO switch arguments
		}
		return $default;
	}

	/**
	 * Get KB Configuration
	 *
	 * @param string $kb_id
	 * @return array|WP_Error with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_config( $kb_id ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}

	/**
	 * Get KB Configuration or default
	 *
	 * @param string $kb_id
	 * @return array|WP_Error with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_config_or_default( $kb_id ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}


	/**
	 * Get all KB Configuration
	 *
	 * @param boolean $skip_check
	 * @return array|string with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_configs( $skip_check=false ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_configs( $skip_check );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}


	/**
	 * @return mixed array containing all existing KB IDs
	 */
	public static function get_kb_ids() {
		return self::get_result( 'EPKB_KB_Config_DB', 'get_kb_ids', array(self::DEFAULT_KB_ID) );
	}

	/**
	 * @param $kb_id
	 * @param array $config
	 * @return array|WP_Error configuration that was updated
	 */
	public static function update_kb_configuration( $kb_id, array $config ) {
		return self::get_param_result( 'EPKB_KB_Config_DB', 'update_kb_configuration', array($kb_id, $config), new WP_Error("Internal Error (x3)") );
	}

	public static function get_current_kb_id() {
		return self::get_result( 'EPKB_KB_Handler', 'get_current_kb_id', self::DEFAULT_KB_ID );
	}

	/**
	 * @param string $category_id
	 *
	 * @return array|WP_Error configuration that was updated
	 */
	public static function update_categories_sequence( $category_id='' ) {
		return self::get_param_result( 'EPKB_Categories_Admin', 'update_categories_sequence', array( $category_id ), new WP_Error("Internal Error (x5)") );
	}


	/**********************************************************************************************************
	 *
	 *                                       CORE CALLING FUNCTIONS
	 *
	 **********************************************************************************************************/

	/**
	 * Safely invoke function.
	 *
	 * @param $class_name
	 * @param $method
	 * @param $default
	 * @return mixed
	 */
	private static function get_result( $class_name, $method, $default ) {

		// instantiate certain classes
		$class = $class_name;
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter', 'EPKB_Categories_Admin')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method) ) ) {
			EPIE_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func( array( $class, $method ) );
	}

	/**
	 * Safely invoke function with parameters.
	 *
	 * @param $class_name
	 * @param $method
	 * @param $params
	 * @param $default
	 * @return mixed
	 */
	private static function get_param_result( $class_name, $method, $params, $default ) {

		// instantiate certain classes
		$class = $class_name;
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter', 'AMGR_Access_Articles_Front', 'EPKB_Categories_Admin')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method ) ) ) {
			EPIE_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
