<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display plugin settings
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class KBLK_Settings_Page {

	public function __construct() {
		add_filter( 'eckb_add_on_debug_data', array( $this, 'display_debug_data' ) );
	}

	public function display_debug_data() {

		// only administrators can handle licenses
		if ( ! current_user_can('manage_options') ) {
			return 'No access';
		}

		// display KB configuration
		$output = "KBLK Configuration:\n\n";
		$all_kb_configs = kblk_get_instance()->kb_config_obj->get_kb_configs();
		foreach ( $all_kb_configs as $kb_config ) {
			$output .= 'KBLK Config ' . $kb_config['id'] . "\n\n";
			$specs = KBLK_KB_Config_Specs::get_fields_specification();
			foreach( $kb_config as $name => $value ) {
				if ( ! is_string($value) ) {
					$value = KBLK_Utilities::get_variable_string($value);
				}
				$label = empty($specs[$name]['label']) ? 'unknown' : $specs[$name]['label'];
				$output .= '- ' . $label . ' [' . $name . ']' . ' => ' . $value . "\n";
			}

			$output .= "\n\n";
		}

		// display error logs
		$output .= "\n\nERROR LOG:\n\n";
		$logs = KBLK_Logging::get_logs();
		foreach( $logs as $log ) {
			$output .= empty($log[0]) ? '' : $log[0] . " ";
			$output .= empty($log[1]) ? '' : $log[1] . " ";
			$output .= empty($log[2]) ? '' : $log[2] . "\n";
		}

		return $output;
	}

}