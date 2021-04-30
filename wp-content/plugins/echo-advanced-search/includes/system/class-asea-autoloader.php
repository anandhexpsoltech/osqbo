<?php  if ( ! defined( 'ABSPATH' ) ) exit;

spl_autoload_register(array( 'ASEA_Autoloader', 'autoload'), false);

/**
 * A class which contains the autoload function, that the spl_autoload_register
 * will use to autoload PHP classes.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ASEA_Autoloader {

	public static function autoload( $class ) {
		static $classes = null;

		if ( $classes === null ) {
			$classes = array(

				// CORE
				'asea_utilities'                    =>  'includes/class-asea-utilities.php',
				'asea_search_utilities'             =>  'includes/class-asea-search-utilities.php',
				'asea_html_elements'                =>  'includes/class-asea-html-elements.php',
				'asea_input_filter'                 =>  'includes/class-asea-input-filter.php',

				// SYSTEM
				'asea_logging'                      =>  'includes/system/class-asea-logging.php',
				'asea_kb_core'                      =>  'includes/system/class-asea-kb-core.php',
				'asea_templates'                    =>  'includes/system/class-asea-templates.php',
				'asea_license_handler'              =>  'includes/system/class-asea-license-handler.php',
				'asea_upgrades'                     =>  'includes/system/class-asea-upgrades.php',
				'asea_db'                           =>  'includes/system/class-asea-db.php',

				// ADMIN CORE
				'asea_admin_notices'                =>  'includes/admin/class-asea-admin-notices.php',
				'asea_settings_page'                =>  'includes/admin/settings/class-asea-settings-page.php',

				// ADMIN PLUGIN MENU PAGES
				// KB Configuration
				'asea_kb_config_controller'         =>  'includes/admin/kb-configuration/class-asea-kb-config-controller.php',
				'asea_kb_config_specs'              =>  'includes/admin/kb-configuration/class-asea-kb-config-specs.php',
				'asea_kb_config_page'               =>  'includes/admin/kb-configuration/class-asea-kb-config-page.php',
				'asea_kb_config_db'                 =>  'includes/admin/kb-configuration/class-asea-kb-config-db.php',
				'asea_kb_config_elements'           =>  'includes/admin/kb-configuration/class-asea-kb-config-elements.php',
				'asea_kb_config_styles'             =>  'includes/admin/kb-configuration/class-asea-kb-config-styles.php',

				'asea_add_ons_page'                 =>  'includes/admin/add-ons/class-asea-add-ons-page.php',
				
				// WIZARD
				'asea_kb_wizard'                    =>  'includes/admin/wizard/class-asea-kb-wizard.php',
				'asea_kb_wizard_text'               =>  'includes/admin/wizard/class-asea-kb-wizard-text.php',
				'asea_kb_wizard_search'             =>  'includes/admin/wizard/class-asea-kb-wizard-search.php',

				// FEATURES - KB
				'asea_kb_handler'                   =>  'includes/features/kbs/class-asea-kb-handler.php',

				// FEATURES - SEARCH
				'asea_search_box_query'             =>  'includes/features/search/class-asea-search-box-query.php',
				'asea_search_box_view'              =>  'includes/features/search/class-asea-search-box-view.php',
				'asea_search_box_cntrl'             =>  'includes/features/search/class-asea-search-box-cntrl.php',
				'asea_search_logging'               =>  'includes/features/search/class-asea-search-logging.php',
				'asea_search_db'                    =>  'includes/features/search/class-asea-search-db.php',
				'asea_search_shortcode'             =>  'includes/features/search/class-asea-search-shortcode.php',

				// FEATURES - ANALYTICS
				'asea_analytics_view'               =>  'includes/features/analytics/class-asea-analytics-view.php'
			);
		}

		$cn = strtolower( $class );
		if ( isset( $classes[ $cn ] ) ) {
			/** @noinspection PhpIncludeInspection */
			include_once( plugin_dir_path( Echo_Advanced_Search::$plugin_file ) . $classes[ $cn ] );
		}
	}
}
