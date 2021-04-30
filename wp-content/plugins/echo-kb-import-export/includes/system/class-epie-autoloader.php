<?php  if ( ! defined( 'ABSPATH' ) ) exit;

spl_autoload_register(array( 'EPIE_Autoloader', 'autoload'), false);

/**
 * A class which contains the autoload function, that the spl_autoload_register
 * will use to autoload PHP classes.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class EPIE_Autoloader {

	public static function autoload( $class ) {
		static $classes = null;

		if ( $classes === null ) {
			$classes = array(

				// CORE
				'epie_utilities'             =>  'includes/class-epie-utilities.php',
				'epie_utilities_export'      =>  'includes/class-epie-utilities-export.php',
				'epie_html_elements'         =>  'includes/class-epie-html-elements.php',
				'epie_input_filter'          =>  'includes/class-epie-input-filter.php',

				// SYSTEM
				'epie_logging'               =>  'includes/system/class-epie-logging.php',
				'epie_kb_core'               =>  'includes/system/class-epie-kb-core.php',
				'epie_license_handler'       =>  'includes/system/class-epie-license-handler.php',
				'epie_upgrades'              =>  'includes/system/class-epie-upgrades.php',

				// ADMIN CORE
				'epie_admin_notices'         =>  'includes/admin/class-epie-admin-notices.php',

				// ADMIN PLUGIN MENU PAGES
				'epie_add_ons_page'          =>  'includes/admin/add-ons/class-epie-add-ons-page.php',

				// FEATURE
				'epie_kb_handler'            =>  'includes/features/kbs/class-epie-kb-handler.php',
				'epie_kb_import_processor'   =>  'includes/features/import/class-epie-kb-import-processor.php',
				'epie_kb_export_ctrl'        =>  'includes/features/export/class-epie-kb-export-ctrl.php',
				'epie_kb_import_export_page' =>  'includes/features/class-epie-kb-import-export-page.php'
			);
		}

		$cn = strtolower( $class );
		if ( isset( $classes[ $cn ] ) ) {
			/** @noinspection PhpIncludeInspection */
			include_once( plugin_dir_path( Echo_KB_Import_Export::$plugin_file ) . $classes[ $cn ] );
		}
	}
}
