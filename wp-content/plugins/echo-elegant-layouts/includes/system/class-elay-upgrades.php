<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if plugin upgrade to a new version requires any actions like database upgrade
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ELAY_Upgrades {

	public function __construct() {
        // will run after plugin is updated but not always like front-end rendering
		add_action( 'admin_init', array( 'ELAY_Upgrades', 'update_plugin_version' ) );
		add_filter( 'eckb_plugin_upgrade_message', array( 'ELAY_Upgrades', 'display_upgrade_message' ) );
        add_action( 'eckb_remove_upgrade_message', array( 'ELAY_Upgrades', 'remove_upgrade_message' ) );
	}

    /**
     * If necessary run plugin database updates
     */
    public static function update_plugin_version() {

        $last_version = ELAY_Utilities::get_wp_option( 'elay_version', null );

        // if plugin is up-to-date then return
        if ( empty($last_version) || version_compare( $last_version, Echo_Elegant_Layouts::$version, '>=' ) ) {
            return;
        }

		// since we need to upgrade this plugin, on the Overview Page show an upgrade message
	    ELAY_Utilities::save_wp_option( 'elay_show_upgrade_message', true, true );

        // upgrade the plugin
        self::invoke_upgrades( $last_version );

        // update the plugin version
        $result = ELAY_Utilities::save_wp_option( 'elay_version', Echo_Elegant_Layouts::$version, true );
        if ( is_wp_error( $result ) ) {
	        ELAY_Logging::add_log( 'Could not update plugin version', $result );
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
        $all_kb_ids = elay_get_instance()->kb_config_obj->get_kb_ids();
        foreach ( $all_kb_ids as $kb_id ) {

	        $add_on_config = elay_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );

	        if ( version_compare( $last_version, '1.2.1', '<' ) ) {
		        self::upgrade_to_v121( $add_on_config, $kb_id );
		        $update_config = true;
	        }

	        if ( version_compare( $last_version, '1.6.0', '<' ) ) {
		        self::upgrade_to_v160( $add_on_config, $kb_id );
		        $update_config = true;
	        }
			
	        // store the updated KB data
	        if ( $update_config ) {
            	elay_get_instance()->kb_config_obj->update_kb_configuration( $kb_id, $add_on_config );
	        }
        }
    }
	
	private static function upgrade_to_v160( &$add_on_config, $kb_id ) {

		$kb_config_value = ELAY_KB_Core::get_value( $kb_id, 'search_title' );
		$add_on_config['grid_search_title'] = $kb_config_value;
		$add_on_config['sidebar_search_title'] = $kb_config_value;

		$kb_config_value = ELAY_KB_Core::get_value( $kb_id, 'search_box_hint' );
		$add_on_config['grid_search_box_hint'] = $kb_config_value;
		$add_on_config['sidebar_search_box_hint'] = $kb_config_value;

		$kb_config_value = ELAY_KB_Core::get_value( $kb_id, 'search_button_name' );
		$add_on_config['grid_search_button_name'] = $kb_config_value;
		$add_on_config['sidebar_search_button_name'] = $kb_config_value;
	}

	private static function upgrade_to_v121( &$add_on_config, $kb_id ) {
		$add_on_config['grid_category_icon']           = str_replace( 'ep_icon', 'ep_font_icon', $add_on_config['grid_category_icon'] );
		$add_on_config['sidebar_expand_articles_icon'] = str_replace( 'ep_icon', 'ep_font_icon', $add_on_config['sidebar_expand_articles_icon'] );

		// update stored icons
		$new_categories_icons = array();
		$categories_icons = ELAY_Utilities::get_kb_option( $kb_id, 'elay_categories_icon', array(), true );
		foreach( $categories_icons as $category_id => $icon_name ) {
			$new_categories_icons[$category_id] = str_replace( 'ep_icon', 'ep_font_icon', $icon_name );
		}

		$result = ELAY_Utilities::save_kb_option( $kb_id, 'elay_categories_icon', $new_categories_icons, true );
		if ( is_wp_error( $result ) ) {
			ELAY_Logging::add_log( 'Could not update plugin version', $result );
		}
	}

    /**
     * Show upgrade message on Overview Page.
     *
     * @param $output
     * @return string
     */
	public static function display_upgrade_message( $output ) {

		if ( ELAY_Utilities::get_wp_option( 'elay_show_upgrade_message', false ) ) {

			$plugin_name = '<strong>' . __('Elegant Layouts', 'echo-knowledge-base') . '</strong>';
			$output .= '<p>' . $plugin_name . ' ' . sprintf( esc_html( _x( 'add-on was updated to version %s.',
									' version number, link to what is new page', 'echo-knowledge-base' ) ),
									Echo_Elegant_Layouts::$version ) . '</p>';
		}

		return $output;
	}
    
    public static function remove_upgrade_message() {
        delete_option('elay_show_upgrade_message');
    }
}
