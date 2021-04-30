<?php

/**
 * Various utility functions for SEARCH
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ASEA_Search_Utilities {

	public static function get_search_index( $kb_config=array() ) {
		global $eckb_is_kb_main_page;
		
		$ix = (isset($eckb_is_kb_main_page) && $eckb_is_kb_main_page) || ASEA_Utilities::post('is_kb_main_page') == 1 ? 'mp' : 'ap';
		
		$ix = empty($kb_config['kb_main_page_layout']) || $kb_config['kb_main_page_layout'] != 'Sidebar' ? $ix : 'mp';
		
		return $ix;
	}

	/**
	 * Return value for given search configuration and whether we are on Main Page or Article Page
	 * @param $kb_config
	 * @param $config_name
	 *
	 * @return string
	 */
	public static function get_search_kb_config( $kb_config, $config_name ) {

		$config_name = str_replace('*', self::get_search_index( $kb_config ), $config_name);

		if ( isset($kb_config[$config_name]) ) {
			return $kb_config[$config_name];
		}

		$default_specs = ASEA_KB_Config_Specs::get_default_kb_config();

		return isset($default_specs[$config_name]) ? $default_specs[$config_name] : '';
	}

	/**
	 * Copy current search configuration to Advanced Search configuration.
	 *
	 * @param $kb_id
	 * @param $core_kb_config
	 * @param $add_on_defaults
	 *
	 * @return array
	 */
	public static function set_search_config_from_current_config( $kb_id, $core_kb_config, $add_on_defaults ) {
		$kb_main_page_layout = $core_kb_config['kb_main_page_layout'];
		$kb_article_page_layout = $core_kb_config['kb_article_page_layout'];

		$el_ay_config = ASEA_KB_Core::get_el_ay_config( $kb_id );
		$el_ay_config = is_wp_error($el_ay_config) ? array() : $el_ay_config;

		// handle KB Core Main Page
		if ( in_array($kb_main_page_layout, array('Basic', 'Tabs', 'Categories')) || empty($el_ay_config) ) {
			self::copy_configuration( $core_kb_config, $add_on_defaults, '', 'advanced_search_mp_' );
		}

		// handle EL AY Main Page
		else if ( in_array($kb_main_page_layout, array('Grid')) ) {
			self::copy_configuration( $el_ay_config, $add_on_defaults, 'grid_', 'advanced_search_mp_' );
		} else {
			self::copy_configuration( $el_ay_config, $add_on_defaults, 'sidebar_', 'advanced_search_mp_' );
		}

		// handle KB Core Article Page
		if ( ! empty($el_ay_config) && $kb_article_page_layout == 'Sidebar' ) {
			self::copy_configuration( $el_ay_config, $add_on_defaults, 'sidebar_', 'advanced_search_ap_' );
		} else {
			self::copy_configuration( $core_kb_config, $add_on_defaults, '', 'advanced_search_ap_' );
		}

		return $add_on_defaults;
	}

	/**
	 * Copy current search configuration to Advanced Search configuration.
	 *
	 * @param $old_search_confing
	 * @param $add_on_defaults
	 * @param $old_config_prefix
	 * @param $new_config_prefix
	 */
	private static function copy_configuration( $old_search_confing, &$add_on_defaults, $old_config_prefix, $new_config_prefix ) {

		$core_search_configs = array('search_input_border_width', 'search_box_padding_top', 'search_box_padding_bottom', 'search_box_padding_left', 'search_box_padding_right',
			'search_box_margin_top', 'search_box_margin_bottom', 'search_box_input_width', 'search_box_results_style', 'search_title_font_color', 'search_background_color',
			'search_text_input_background_color', 'search_text_input_border_color', 'search_btn_background_color', 'search_btn_border_color', 'search_title',
			'search_box_hint', 'search_button_name', 'search_results_msg', 'no_results_found', 'min_search_word_size_msg');

		foreach( $core_search_configs as $core_search_config ) {
			if ( ! isset($old_search_confing[$old_config_prefix . $core_search_config]) ) {
				continue;
			}

			$matching_mp_add_on_config = str_replace('search_', $new_config_prefix , $core_search_config );
			if ( isset($add_on_defaults[$matching_mp_add_on_config]) ) {
				$add_on_defaults[$matching_mp_add_on_config] = $old_search_confing[$old_config_prefix . $core_search_config];
			}
		}
	}
}
