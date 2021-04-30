<?php  if ( ! defined( 'ABSPATH' ) ) exit;

spl_autoload_register(array( 'ELAY_Autoloader', 'autoload'), false);

/**
 * A class which contains the autoload function, that the spl_autoload_register
 * will use to autoload PHP classes.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ELAY_Autoloader {

	public static function autoload( $class ) {
		static $classes = null;

		if ( $classes === null ) {
			$classes = array(

				// CORE
				'elay_utilities'                    =>  'includes/class-elay-utilities.php',
				'elay_input_filter'                 =>  'includes/class-elay-input-filter.php',

				// SYSTEM
				'elay_logging'                      =>  'includes/system/class-elay-logging.php',
				'elay_kb_core'                      =>  'includes/system/class-elay-kb-core.php',
				'elay_license_handler'              =>  'includes/system/class-elay-license-handler.php',
				'elay_upgrades'                     =>  'includes/system/class-elay-upgrades.php',

				// ADMIN CORE
				'elay_admin_notices'                =>  'includes/admin/class-elay-admin-notices.php',
				'elay_settings_page'                =>  'includes/admin/settings/class-elay-settings-page.php',

				// ADMIN PLUGIN MENU PAGES
				// KB Configuration
				'elay_kb_config_controller'         =>  'includes/admin/kb-configuration/class-elay-kb-config-controller.php',
				'elay_kb_config_specs'              =>  'includes/admin/kb-configuration/class-elay-kb-config-specs.php',
				'elay_kb_config_db'                 =>  'includes/admin/kb-configuration/class-elay-kb-config-db.php',
				'elay_kb_config_layouts'            =>  'includes/admin/kb-configuration/class-elay-kb-config-layouts.php',
				'elay_kb_config_layout_sidebar'     =>  'includes/admin/kb-configuration/class-elay-kb-config-layout-sidebar.php',
				'elay_kb_config_layout_grid'        =>  'includes/admin/kb-configuration/class-elay-kb-config-layout-grid.php',
				'elay_kb_config_elements'           =>  'includes/admin/kb-configuration/class-elay-kb-config-elements.php',
				'elay_kb_config_advanced'           =>  'includes/admin/kb-configuration/class-elay-kb-config-advanced.php',

				// WIZARD
				'elay_kb_wizard'                    =>  'includes/admin/wizard/class-elay-kb-wizard.php',
				'elay_kb_wizard_text'               =>  'includes/admin/wizard/class-elay-kb-wizard-text.php',
				'elay_kb_wizard_features'           =>  'includes/admin/wizard/class-elay-kb-wizard-features.php',
				'elay_kb_wizard_search'             =>  'includes/admin/wizard/class-elay-kb-wizard-search.php',

				'elay_add_ons_page'                 =>  'includes/admin/add-ons/class-elay-add-ons-page.php',

				// FEATURES - KB
				'elay_kb_handler'                   =>  'includes/features/kbs/class-elay-kb-handler.php',
				'elay_kb_search'                    =>  'includes/features/kbs/class-elay-kb-search.php',

				// FEATURES - LAYOUT
				'elay_layout'                       =>  'includes/features/layouts/class-elay-layout.php',
				'elay_layout_sidebar'               =>  'includes/features/layouts/class-elay-layout-sidebar.php',
				'elay_layout_sidebar_v2'            =>  'includes/features/layouts/class-elay-layout-sidebar-v2.php',
				'elay_layout_grid'                  =>  'includes/features/layouts/class-elay-layout-grid.php'
			);
		}

		$cn = strtolower( $class );
		if ( isset( $classes[ $cn ] ) ) {
			/** @noinspection PhpIncludeInspection */
			include_once( plugin_dir_path( Echo_Elegant_Layouts::$plugin_file ) . $classes[ $cn ] );
		}
	}
}
