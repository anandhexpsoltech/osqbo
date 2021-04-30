<?php

/**
 * KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class AMCR_KB_Core {

	const DEFAULT_KB_ID = 1;
	const AMCR_KB_CONFIG_PREFIX =  'epkb_config_';
	const AMCR_KB_DEBUG = 'epkb_debug';
	const AMCR_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const AMCR_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update
	const AMCR_KB_CAPABILITIES_SUFFIX = '_cpt';
	const AMCR_KB_ARTICLES_SEQ_META = 'epkb_articles_sequence';
	const AMCR_KB_CATEGORIES_SEQ_META = 'epkb_categories_sequence';

	// plugin pages links
	const AMCR_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const AMCR_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const AMCR_KB_LICENSES_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-add-ons&epkb-tab=licenses';
	const AMCR_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const AMCR_KB_LICENSE_FIELD = 'epkb_license_fields';

	// FILTERS
	const AMCR_KB_REGISTER_KB_CONFIG_HOOKS = 'epkb_register_kb_config_hooks';
	const AMCR_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';
	const AMCR_KB_ARTICLE_PAGE_ADD_ON_LINKS = 'epkb_kb_article_page_add_on_links';

	// ACTIONS
    const AMCR_KB_CONFIG_GET_ADD_ON_INPUT           = 'epkb_kb_config_get_add_on_input';
    const AMCR_KB_CONFIG_SAVE_INPUT                 = 'epkb_kb_config_save_input_v2';
	const AMCR_LOAD_ADMIN_PLUGIN_PAGES_RESOURCES    = 'epkb_load_admin_plugin_pages_resources';

	// AJAX action events
    const AMCR_SAVE_KB_CONFIG_CHANGES = 'epkb_save_kb_config_changes';


	/**
	 * Get value from KB Configuration
	 *
	 * @param string $kb_id
	 * @param $setting_name
	 * @param string $default
	 *
	 * @return array|string with value or $default value if this settings not found
	 */
	public static function get_value( $kb_id = '', $setting_name, $default = '' ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_value( $setting_name, $kb_id, $default ); // TODO switch arguments
		}
		return $default;
	}

	public static function get_am_gr_version() {
		return Echo_Knowledge_Base::$amag_version;
	}

	public static function get_kb_groups( $kb_id ) {
		return self::get_param_result( 'AMGR_WP_Roles', 'get_kb_groups', array( $kb_id ), array() );
	}

	public static function update_wp_role_mapping( $kb_id, $wp_role_name, $kb_role_name, $kb_group_id ) {
		return self::get_param_result( 'AMGR_WP_Roles', 'update_wp_role_mapping', array($kb_id, $wp_role_name, $kb_role_name, $kb_group_id), false );
	}

	public static function delete_wp_role_mapping( $kb_id, $wp_role_name, $kb_group_id ) {
		return self::get_param_result( 'AMGR_WP_Roles', 'delete_wp_role_mapping', array($kb_id, $wp_role_name, $kb_group_id), false );
	}

	public static function get_wp_roles_mappings_for_kb( $kb_id ) {
		return self::get_param_result( 'AMGR_WP_Roles', 'get_wp_roles_mappings_for_kb', array($kb_id), new WP_Error('Error', 'Failed to retrieve Mappings.') );
	}

	public static function use_kb_groups() {
		return self::get_result( 'AMGR_WP_Roles', 'use_kb_groups', null );
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
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method) ) ) {
			AMCR_Logging::add_log("Cannot invoke class $class with method $method.");
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
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method ) ) ) {
			AMCR_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
