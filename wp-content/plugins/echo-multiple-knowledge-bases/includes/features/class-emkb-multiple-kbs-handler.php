<?php

/**
 * Add-on main class.
 */
class EMKB_Multiple_KBs_Handler {

	public function __construct() {

		// create a new KB
		add_action( 'admin_post_emkb_add_knowledge_base', array( $this, 'add_knowledge_base' ) );
		add_action( 'admin_post_nopriv_emkb_add_knowledge_base', array( $this, 'user_not_logged_in' ) );

		// add button to create KB on the Manage KBs page 
		add_action( 'eckb_manage_show_header', array( $this, 'add_create_kb_button' ) );
		
		// add buttons to each KB tab on the Manage KBs page
		add_action( 'eckb_manage_content_tab_body_manage', array($this, 'add_manage_content_actions'), 10, 2 );
		
		// handle forms
		add_filter ( 'eckb_handle_manage_kb_actions', array($this, 'handle_manage_kb_actions'), 10, 3 );
	}

	/**
	 * Add new knowledge base when user clicks on Add button
	 */
	public function add_knowledge_base() {

		// verify that request is authentic
		if ( ! isset( $_REQUEST['_wpnonce_add_knowledge_base'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_add_knowledge_base'], '_wpnonce_add_knowledge_base' ) ) {
			EMKB_Utilities::show_top_level_admin_msg_and_redirect('kb_refresh_page');
		}

		// ensure user has correct permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			EMKB_Utilities::show_top_level_admin_msg_and_redirect('kb_security_failed');
		}

		// create new KB with default configuration
		$all_kb_ids = EMKB_KB_Core::get_kb_ids();
		$new_kb_id = empty($all_kb_ids) ? EMKB_KB_Core::DEFAULT_KB_ID : max($all_kb_ids) + 1;
		$new_kb_main_page_title = __( 'Knowledge Base', 'echo-multiple-knowledge-bases' ) . ' ' . $new_kb_id;

		$kb_config = EMKB_KB_Core::add_new_knowledge_base( $new_kb_id, $new_kb_main_page_title, '' );
		if ( is_wp_error($kb_config) ) {
			EMKB_Logging::add_log("Could not create a new knowledge base (add option failed)", $kb_config);
			EMKB_Utilities::show_top_level_admin_msg_and_redirect('kb_add_error');
		}

		// Clear permalinks
		update_option( EMKB_KB_Core::EMKB_KB_FLUSH_REWRITE_RULES, true );
		flush_rewrite_rules( false );

		$kb_post_type = EMKB_KB_Handler::get_post_type( $kb_config['id'] );
		$_REQUEST['emkb_redirect'] = '';

		EMKB_Utilities::show_top_level_admin_msg_and_redirect( 'kb_add_success', "edit.php?post_type={$kb_post_type}&page=" . EMKB_KB_Core::EMKB_KB_CONFIGURATION_PAGE . "&wizard-on" );
	}

	private function generate_error_summary( $errors ) {

		$output = '';

		if ( empty( $errors ) || ! is_array( $errors )) {
			return $output . 'unknown error (324234)';
		}

		$output .= '<ol>';
		foreach( $errors as $error ) {
			$output .= '<li>' . wp_kses( $error, array(
					'a' => array(
						'href' => array(),
						'title' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				) ) . '</li>';
		}
		$output .= '</ol>';

		return $output;
	}

	public function user_not_logged_in() {
		EMKB_Utilities::ajax_show_error_die( '<p>' . __( 'You are not logged in. Refresh your page and log in', 'echo-multiple-knowledge-bases' ) . '.</p>', __( 'Cannot save your changes', 'echo-multiple-knowledge-bases' ) );
	}

	/**
	 * Add button to create KB on the Manage KBs page
	 */
	public function add_create_kb_button() {		?>
			<div class="emkb-create-kb-button">
				<form id="emkb-add-kb" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="POST">
					<input type="hidden" id="_wpnonce_add_knowledge_base" name="_wpnonce_add_knowledge_base" value="<?php echo wp_create_nonce( '_wpnonce_add_knowledge_base' ); ?>"/>
					<input type="hidden" name="action" value="emkb_add_knowledge_base">
					<button id="emkb-create-wizard-kb-btn" type="submit"><?php echo  __( 'Create Knowledge Base', 'emkb' ); ?></button>
				</form>
			</div>  <?php
	}
	
	/**
	 * Add buttons to each KB tab on the Manage KBs page
	 * @param $kb_id
	 * @param $kb_config
	 */
	public function add_manage_content_actions( $kb_id, $kb_config ) {
		
		if ( $kb_config['status'] == 'archived' ) {
			$label = __( 'Activate KB', 'echo-multiple-knowledge-bases' );
			$action = 'emkb_activate_knowledge_base_v2';
			$icon ='ep_font_icon_error_circle';
			$button_class ='success-btn';
		}	else if ( $kb_config['status'] == 'published' ) {
			$label = __( 'Archive KB', 'echo-multiple-knowledge-bases' );
			$action = 'emkb_archive_knowledge_base_v2';
			$icon ='ep_font_icon_checkmark';
			$button_class ='info-btn';
		} else {
			$label = $kb_config['status'];
			$icon ='ep_font_icon_error_circle';
			$action = '';
		} ?>
		
		<div class="emkb-manage-content__tab__actions"><?php
			// user cannot archive or active default KB
			if ( $kb_config['id'] == EMKB_KB_Core::DEFAULT_KB_ID ) {			?>
				<p><i><?php _e( 'Default Knowledge Base cannot be archived', 'echo-multiple-knowledge-bases' ); ?></i></p><?php

			} else {

				if ( ! empty( $button_class ) ) {        ?>
					<form class="emkb-manage-kbs" action="<?php echo esc_url( add_query_arg( array( 'active_kb_tab' => $kb_id, 'active_action_tab' => 'manage', 'post_type' => EMKB_KB_Handler::get_post_type( EMKB_KB_Core::DEFAULT_KB_ID ) ) ) ); ?>" method="post">
						<input type="hidden" name="_wpnonce_manage_kbs" value="<?php echo wp_create_nonce( "_wpnonce_manage_kbs" ); ?>"/>
						<input type="hidden" name="action" value="<?php echo $action; ?>"/>
						<input type="hidden" name="emkb_kb_id" value="<?php echo $kb_id; ?>"/>
						<input type="submit" class="<?php echo $button_class; ?>" value="<?php echo $label; ?>" />
					</form><?php 
				} ?>

				<form class="emkb-delete-kbs" action="<?php echo esc_url( add_query_arg( array( 'active_kb_tab' => $kb_id, 'active_action_tab' => 'manage', 'post_type' => EMKB_KB_Handler::get_post_type( EMKB_KB_Core::DEFAULT_KB_ID ) ) ) ); ?>" method="post">
					<input type="hidden" name="_wpnonce_manage_kbs" value="<?php echo wp_create_nonce( "_wpnonce_manage_kbs" ); ?>"/>
					<input type="hidden" name="action" value="emkb_delete_knowledge_base_v2"/>
					<input type="hidden" name="emkb_kb_id" value="<?php echo $kb_id; ?>"/>
					<input type="submit" class="error-btn" value="<?php echo __( 'Delete KB', 'echo-multiple-knowledge-bases' ); ?>" <?php disabled( $kb_config['status'], 'archived' ); ?> /><?php

					if ( self::is_kb_have_content( $kb_id ) ) {
						$message = sprintf( __( 'To delete the "%s" knowledge base, you first need to delete its KB articles, KB categories, KB tags and remove KB shortcode from related KB page(s).', 'echo-multiple-knowledge-bases' ), $kb_config['kb_name']);
					} else {
						$message = sprintf( __( 'Are you sure you want to delete "%s" knowledge base?', 'echo-multiple-knowledge-bases' ), $kb_config['kb_name']);
					}

					EMKB_Utilities::dialog_box_form(array(
						'id' => 'emkb-delete-kbs-popup-' . $kb_id,
						'title' => __( 'Deleting KB', 'echo-multiple-knowledge-bases' ),
						'body' => $message,
						'accept_label' => __( 'Delete KB', 'echo-multiple-knowledge-bases' ),
						'accept_type' => 'warning',
					)); ?>

				</form>		<?php
			}       ?>
		</div><?php 
	}

	/**
	 * Handle user actions on Manage KBs page.
	 *
	 * @param $message
	 * @param $kb_id
	 * @param $current_config
	 *
	 * @return mixed|void
	 */
	public function handle_manage_kb_actions( $message, $kb_id, $current_config ) {

		// verify that request is authentic
		if ( ! isset( $_REQUEST['_wpnonce_manage_kbs'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_manage_kbs'], '_wpnonce_manage_kbs' ) ) {
			$message['error'] = __( 'Not authorized', 'echo-knowledge-base' ) . ' (1)';
			return $message;
		}

		// ensure user has correct permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			$message['error'] = __( 'Internal error', 'echo-knowledge-base' ) . ' (3)';
			return $message;
		}

		// retrieve KB ID we are handling
		$kb_id = EMKB_Utilities::sanitize_get_id( $kb_id );
		if ( empty($kb_id) || is_wp_error( $kb_id ) ) {
			EMKB_Logging::add_log("received invalid kb_id when archiving KB", $kb_id );
			$message['error'] = __( 'Internal error', 'echo-knowledge-base' ) . ' (4)';
			return $message;
		}

		// we cannot activate/archive/delete default KB
		if ( $kb_id == EMKB_KB_Core::DEFAULT_KB_ID && in_array( $_POST['action'], array('emkb_activate_knowledge_base_v2', 'emkb_archive_knowledge_base_v2', 'emkb_delete_knowledge_base_v2' ) ) ) {
			EMKB_Logging::add_log("Cannot archive/delete/activate default knowledge base");
			$message['error'] = __( 'Internal error', 'echo-knowledge-base' ) . ' (5)';
			return $message;
		}

		// Archive KB 
		if ( $_POST['action'] == 'emkb_archive_knowledge_base_v2' ) {
			// check that KB is active
			if ( $current_config['status'] != EMKB_KB_Core::PUBLISHED ) {
				EMKB_Logging::add_log("Trying to archive KB with status ", $current_config['status'] );
				$message['error'] = __( 'Could not archive the knowledge base. Please try again later.', 'echo-multiple-knowledge-bases' );
				return $message;
			}
			
			$current_config['status'] = EMKB_KB_Core::ARCHIVED;
			
			// sanitize and save configuration in the database
			$result = EMKB_KB_Core::update_kb_configuration( $kb_id, $current_config ); 
			if ( is_wp_error( $result ) ) {
				$message = $result->get_error_data();
				if ( empty($message) ) {
					EMKB_Logging::add_log("Could not archive knowledge base:", $result->get_error_message());
					$message['error'] = __( 'Could not archive the knowledge base. Please try again later.', 'echo-multiple-knowledge-bases' );
					return $message;
				} else {
					EMKB_Logging::add_log("Could not archive knowledge base:", $this->generate_error_summary( $result->get_error_data()) );
					$message['error'] = __( 'Could not archive the knowledge base. Please try again later.', 'echo-multiple-knowledge-bases' );
					return $message;
				}
			}
			
			// Clear permalinks
			update_option( EMKB_KB_Core::EMKB_KB_FLUSH_REWRITE_RULES, true );
			flush_rewrite_rules( false );
			
			$message['success'] = sprintf( __( "Knowledge Base '%s' was archived (hidden from users and KB screens).", 'echo-multiple-knowledge-bases' ), $current_config['kb_name'] );

			return $message;
		}

		// Activate KB
		if ( $_POST['action'] == 'emkb_activate_knowledge_base_v2' ) {
			$current_config['status'] = EMKB_KB_Core::PUBLISHED;
			
			// sanitize and save configuration in the database
			$result = EMKB_KB_Core::update_kb_configuration( $kb_id, $current_config ); 
			if ( is_wp_error( $result ) ) {
				$message = $result->get_error_data();
				if ( empty($message) ) {
					EMKB_Logging::add_log("Could not activate knowledge base:", $result->get_error_message());
					$message['error'] = __( 'Could not activate the knowledge base. Please try again later.', 'echo-multiple-knowledge-bases' );
				} else {
					EMKB_Logging::add_log("Could not activate knowledge base:", $this->generate_error_summary( $result->get_error_data()) );
					$message['error'] = __( 'Could not activate the knowledge base. Please try again later.', 'echo-multiple-knowledge-bases' );
				}
			}

			// Clear permalinks
			update_option( EMKB_KB_Core::EMKB_KB_FLUSH_REWRITE_RULES, true );
			flush_rewrite_rules( false );
			
			$message['success'] = sprintf( __( "Knowledge Base '%s' is now published.", 'echo-multiple-knowledge-bases' ), $current_config['kb_name'] );

			return $message;
		}
		
		// Delete KB 
		if ( $_POST['action'] == 'emkb_delete_knowledge_base_v2' ) {
			// ensure that all content was deleted
			if ( self::is_kb_have_content( $kb_id ) ) {
				EMKB_Logging::add_log("Cannot delete KB that has articles and categories.", $kb_id );
				$message['error'] = sprintf( __( "Cannot delete '%s' knowledge base because it has articles and categories. To delete '%s' KB, first bulk delete all articles, categories and tags.", 'echo-multiple-knowledge-bases' ), $current_config['kb_name'], $current_config['kb_name'] );
				return $message;
			}
			
			$old_config_value = get_option( 'ep'.'kb_config_' . $kb_id );
			
			// check pages with shortcode
			$main_pages = '';
			foreach ( $old_config_value['kb_main_pages'] as $id => $title ) {
				$post = get_post($id);
				$shortcode_kb_id = EMKB_KB_Handler::get_kb_id_from_kb_main_shortcode($post);
				if ( $post && $shortcode_kb_id && $shortcode_kb_id == $kb_id ) {
					if ( $main_pages ) {
						$main_pages .= ', ';
					}

					$main_pages .= $title;
				}
			}
			
			// do not allow delete before user removes KB shortcodes
			if ( $main_pages ) {
				$message['error'] = sprintf( __( "Could not delete '%s' knowledge base. You need to remove KB shortcode from the following pages: '%s'.", 'echo-multiple-knowledge-bases' ), $current_config['kb_name'], $main_pages );
				return $message;
			}

			// delete KB
			set_transient( '_ep'.'kb_old_config_', $old_config_value, WEEK_IN_SECONDS );
			delete_option( 'ep'.'kb_config_' . $kb_id );
			delete_option( 'ep'.'kb_orignal_config_' . $kb_id );
			delete_option( 'ep'.'kb_categories_sequence_' . $kb_id );
			delete_option( 'ep'.'kb_articles_sequence_' . $kb_id );
			delete_option( 'ep'.'kb_post_type_' . $kb_id .'_category_children_en' );
			delete_option( 'ep'.'kb_post_type_' . $kb_id .'_category_children_all' );
			delete_option( 'ep'.'kb_faq_articles_sequence_' . $kb_id );
			delete_option( 'ep'.'kb_faq_categories_sequence_' . $kb_id );
			delete_option( 'ep'.'kb_faq_config_' . $kb_id );
			
			// delete addons options 
			delete_option( 'asea_config_' . $kb_id );
			delete_option( 'eprf_config_' . $kb_id );
			delete_option( 'widg_config_' . $kb_id );
			delete_option( 'elay_config_' . $kb_id );
			delete_option( 'amgp_config_' . $kb_id );			
			delete_option( 'amgr_access_config_' . $kb_id );
			
			// Clear permalinks
			update_option( EMKB_KB_Core::EMKB_KB_FLUSH_REWRITE_RULES, true );
			flush_rewrite_rules( false );
			
			$message['success'] = sprintf( __( "Knowledge Base '%s' was deleted.", 'echo-multiple-knowledge-bases' ), $current_config['kb_name'] );

			return $message;
		}
		
	}

	/**
	 * Check any content existing in DB for KB
	 * @param $kb_id
	 * @return bool
	 */
	public static function is_kb_have_content( $kb_id ) {

		$posts = get_posts( array(
			'numberposts' => 1,
			'post_type'   => EMKB_KB_Core::EMKB_KB_POST_TYPE_PREFIX . $kb_id,
		) );

		if ( $posts ) {
			return true;
		}

		// categories and tags
		$terms = get_terms( array(
			'taxonomy'      => array( EMKB_KB_Handler::get_category_taxonomy_name( $kb_id ), EMKB_KB_Handler::get_tag_taxonomy_name( $kb_id ) ),
			'hide_empty'    => false,
			'number' => 1
		) );

		// wp_error is possible if we deactivated KB = no CPT added
		if ( ! is_wp_error($terms) && ! empty($terms) ) {
			return true;
		}

		return false;
	}
}