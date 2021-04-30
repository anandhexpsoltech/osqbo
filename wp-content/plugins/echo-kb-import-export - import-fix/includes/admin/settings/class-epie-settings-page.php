<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display plugin settings
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPIE_Settings_Page {

	public function __construct() {
		add_filter( 'eckb_add_on_debug_data', array( $this, 'display_debug_data' ) );
	}

	public function display_debug_data() {

		// only administrators can handle licenses
		if ( ! current_user_can('manage_options') ) {
			return 'No access';
		}

		// display error logs
		$output = "\n\n\n\nERROR LOG:\n\n";
		$logs = EPIE_Logging::get_logs();
		foreach( $logs as $log ) {
			$output .= empty($log['date']) ? '' : $log['date'] . " ";
			$output .= empty($log['message']) ? '' : $log['message'] . " ";
			$output .= empty($log['trace']) ? '' : $log['trace'] . "\n";
		}

		return $output;
	}
}