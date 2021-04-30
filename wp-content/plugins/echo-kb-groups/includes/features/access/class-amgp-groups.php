<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handle KB Groups actions.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class AMGP_Groups {

	function __construct() {
		add_filter( 'aman_is_kb_manager', array( $this, 'is_kb_manager' ), 10, 2 );
	}

	/**
	 * is user KB Manager
	 *
	 * @param $ignore
	 * @param $user_id
	 *
	 * @return bool
	 */
	public static function is_kb_manager( /** @noinspection PhpUnusedParameterInspection */ $ignore, $user_id ) {
		$kb_managers = self::get_kb_managers();
		return ! empty($kb_managers) && in_array($user_id, $kb_managers);
	}

	/**
	 * Retrieve known KB Managers
	 * @return array|null
	 */
	public static function get_kb_managers() {
		return amgp_get_instance()->kb_config_obj->get_value( AMGP_KB_Core::DEFAULT_KB_ID, 'kb_managers', null );
	}

	/**
	 * Set KB Managers
	 *
	 * @param $kb_managers
	 * @return array|WP_Error
	 */
	public static function set_kb_managers( $kb_managers ) {
		return amgp_get_instance()->kb_config_obj->set_value( AMGP_KB_Core::DEFAULT_KB_ID, 'kb_managers', $kb_managers );
	}
}

