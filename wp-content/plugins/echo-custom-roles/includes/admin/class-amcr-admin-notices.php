<?php

/**
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class AMCR_Admin_Notices {

	public function __construct() {
		add_action( 'admin_notices', array( $this, 'show_admin_notices' ) );
		//add_action( 'amcr_dismiss_notices', array( $this, 'dismiss_admin_notices' ) );
	}

	/**
	 * Show noticers for admin at the top of the page
	 */
	public function show_admin_notices() {

		$errors = AMCR_Logging::get_logs();
		$errors = array_slice($errors, 0, 2);
		$error_message = '';
		foreach( $errors as $error ) {
			$error_message .= AMCR_Logging::to_string($error) . '<br>';
		}
		$errors = AMCR_Logging::get_logs();
		$errors = array_slice($errors, 0, 2);
		foreach( $errors as $error ) {
			$error_message .= AMCR_Logging::to_string($error) . '<br>';
		}

		// only if debug is truly on
		$show_errors = true; // TODO ( defined( 'ECKB_EKB_SCRIPT_DEBUG' ) && ECKB_EKB_SCRIPT_DEBUG );
		$error_message = $show_errors ? $error_message : '';

		// get the problem type
		$admin_notice_type = empty($_GET['amcr_admin_notice']) ? ( empty($error_message)  ? '' : 'amcr_misconfigured' ) : $_GET['amcr_admin_notice'];
		if ( empty($admin_notice_type) ) {
			return;
		}

		// get the problem detailed message
		$class = 'error';
		switch ( $admin_notice_type ) {

				case 'kb_refresh_page' :
					$message = __( 'Refresh your page', 'echo-knowledge-base' );
					$class = 'primary';
					break;
				case 'kb_refresh_page_error' :
					$message = __( 'Error occurred. Please refresh your browser and try again.', 'echo-knowledge-base' );
					break;
				case 'kb_security_failed' :
					$message = __( 'You do not have permission.', 'echo-knowledge-base' );
					break;
				case 'amcr_misconfigured' :
					$message = __( 'Access Manager found an issue. Please contact customer support.' . '<br>' . $error_message, 'echo-knowledge-base' );
					break;
				default:
					$message = 'unknown error (133)';
					break;
			}

		echo  AMCR_Utilities::get_bottom_notice_message_box( $message, '', $class );
	}

	/**
	 * Dismiss admin notices when Dismiss links are clicked
	 *
	 * @return void
	 */
	function dismiss_admin_notices() {

		if ( empty( $_GET['amcr_dismiss_notice_nonce'] ) || ! wp_verify_nonce( $_GET['amcr_dismiss_notice_nonce'], 'amcr_dismiss_notice') ) {
			wp_die( __( 'Security check failed', 'echo-knowledge-base' ), __( 'Error', 'echo-knowledge-base' ), array( 'response' => 403 ) );
		}

		if ( ! empty( $_GET['amcr_admin_notice'] ) ) {
			update_user_meta( get_current_user_id(), '_amcr_' . AMCR_Utilities::sanitize_english_text( $_GET['amcr_admin_notice'], 'AMCR admin notice' ) . '_dismissed', 1 );
			wp_redirect( remove_query_arg( array( 'amcr_action', 'amcr_admin_notice' ) ) );
			exit;
		}
	}
}
