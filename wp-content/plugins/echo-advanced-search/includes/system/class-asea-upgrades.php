<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if plugin upgrade to a new version requires any actions like database upgrade
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ASEA_Upgrades {

	public function __construct() {
        // will run after plugin is updated but not always like front-end rendering
		add_action( 'admin_init', array( 'ASEA_Upgrades', 'update_plugin_version' ) );
		add_filter( 'eckb_plugin_upgrade_message', array( 'ASEA_Upgrades', 'display_upgrade_message' ) );
        add_action( 'eckb_remove_upgrade_message', array( 'ASEA_Upgrades', 'remove_upgrade_message' ) );
	}

    /**
     * If necessary run plugin database updates
     */
    public static function update_plugin_version() {

        $last_version = ASEA_Utilities::get_wp_option( 'asea_version', null );

        // fix empty version
        if ( empty($last_version) ) {
            $last_version = '2.8.5';
        }

        // if plugin is up-to-date then return
        if ( empty($last_version) || version_compare( $last_version, Echo_Advanced_Search::$version, '>=' ) ) {
            return;
        }

		// since we need to upgrade this plugin, on the Overview Page show an upgrade message
	    ASEA_Utilities::save_wp_option( 'asea_show_upgrade_message', true, true );

        // upgrade the plugin
        self::invoke_upgrades( $last_version );

        // update the plugin version
        $result = ASEA_Utilities::save_wp_option( 'asea_version', Echo_Advanced_Search::$version, true );
        if ( is_wp_error( $result ) ) {
	        ASEA_Logging::add_log( 'Could not update plugin version', $result );
            return;
        }
    }

    /**
     * Invoke each database update as necessary.
     *
     * @param $last_version
     */
    private static function invoke_upgrades( $last_version ) {

        // update all KBs
	    $update_config = false;
        $all_kb_ids = asea_get_instance()->kb_config_obj->get_kb_ids();
        foreach ( $all_kb_ids as $kb_id ) {

	        $add_on_config = asea_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );

            if ( version_compare( $last_version, '1.1.0', '<' ) ) {
                self::upgrade_to_v110( $add_on_config );
	            $update_config = true;
            }

            if ( version_compare( $last_version, '2.11.0', '<' ) ) {
                self::upgrade_to_v2110( $add_on_config );
                $update_config = true;
            }

	        // store the updated KB data
	        if ( $update_config ) {
            	asea_get_instance()->kb_config_obj->update_kb_configuration( $kb_id, $add_on_config );
	        }
        }
    }

    /**
     * Change of minimum value for KB config.
     * @param $add_on_config
     */
    private static function upgrade_to_v2110( &$add_on_config ) {
        if ( $add_on_config['advanced_search_mp_filter_dropdown_width'] < 200 ) {
            $add_on_config['advanced_search_mp_filter_dropdown_width'] = 200;
        }
        if ( $add_on_config['advanced_search_ap_filter_dropdown_width'] < 200 ) {
            $add_on_config['advanced_search_ap_filter_dropdown_width'] = 200;
        }
    }

	/**
	 * For first Advanced Search users, copy their KB Core search configuration to Advanced Search configuration
	 * @param $add_on_config
	 */
	private static function upgrade_to_v110( &$add_on_config ) {

		// if possible port search configuration from KB Core
		$core_kb_config = ASEA_KB_Core::get_kb_config( $add_on_config['id'] );
		if ( is_wp_error($core_kb_config) ) {
			return;
		}

		$add_on_config = ASEA_Search_Utilities::set_search_config_from_current_config( $add_on_config['id'], $core_kb_config, $add_on_config );
	}

    /**
     * Show upgrade message on Overview Page.
     *
     * @param $output
     * @return string
     */
	public static function display_upgrade_message( $output ) {

		if ( ASEA_Utilities::get_wp_option( 'asea_show_upgrade_message', false ) ) {

			$plugin_name = '<strong>' . __('Advanced Search', 'echo-advanced-search') . '</strong>';
			$output .= '<p>' . $plugin_name . ' ' . sprintf( esc_html( _x( 'add-on was updated to version %s.',
									' version number, link to what is new page', 'echo-knowledge-base' ) ),
									Echo_Advanced_Search::$version ) . '</p>';
		}

		return $output;
	}
    
    public static function remove_upgrade_message() {
        delete_option('asea_show_upgrade_message');
    }
}
