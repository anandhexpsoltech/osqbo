<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ASEA_KB_Wizard {

	public static function register_all_wizard_hooks() {

		// global hooks
		add_filter( ASEA_KB_Core::ASEA_ALL_WIZARDS_CONFIGURATION_DEFAULTS, array('ASEA_KB_Wizard','get_configuration_defaults') );
		add_filter( ASEA_KB_Core::ASEA_ALL_WIZARDS_GET_CURRENT_CONFIG, array('ASEA_KB_Wizard', 'get_current_config' ), 10, 2 );

		// THEME WIZARD hooks
		add_filter( ASEA_KB_Core::ASEA_THEME_WIZARD_GET_THEME_CONFIG, array('ASEA_KB_Wizard', 'get_theme_config'), 30 );
		add_action( ASEA_KB_Core::ASEA_THEME_WIZARD_MAIN_PAGE_COLORS, array('ASEA_KB_Wizard', 'get_main_page_colors') );
		add_action( ASEA_KB_Core::ASEA_THEME_WIZARD_ARTICLE_PAGE_COLORS, array('ASEA_KB_Wizard', 'get_article_page_colors') );
		add_filter( ASEA_KB_Core::ASEA_THEME_WIZARD_GET_COLOR_PRESETS, array('ASEA_KB_Wizard', 'get_color_presets' ), 10, 2 );
		
		// Fields filters 
		add_filter( ASEA_KB_Core::ASEA_KB_SEARCH_FIELDS_LIST, array('ASEA_KB_Wizard', 'get_kb_search_fields_list') );
		add_filter( ASEA_KB_Core::ASEA_KB_TEXT_FIELDS_LIST, array('ASEA_KB_Wizard', 'get_kb_text_fields_list') );
		add_filter( ASEA_KB_Core::ASEA_KB_THEME_FIELDS_LIST, array('ASEA_KB_Wizard', 'get_kb_theme_fields_list') );
		
		// TEXT WIZARD hooks
		ASEA_KB_Wizard_Text::register_text_wizard_hooks();

		// SEARCH WIZARD hooks
		ASEA_KB_Wizard_Search::register_search_wizard_hooks();
	}

	/**
	 * Returnt to Wizard the current KB configuration
	 *
	 * @param $kb_config
	 * @param $kb_id
	 * @return array
	 */
	public static function get_current_config( $kb_config, $kb_id ) {
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return array_merge( $kb_config, $asea_config );
	}

	/**
	 * Return add-on configuration defaults.
	 *
	 * @param $template_defaults
	 * @return array
	 */
	public static function get_configuration_defaults( $template_defaults ) {

		$kb_asea_defaults = ASEA_KB_Config_Specs::get_default_kb_config();

		$asea_template_defaults = array (
		);

		return array_merge($template_defaults, $kb_asea_defaults, $asea_template_defaults);
	}

	/**
	 * Return ASEA Wizard themes and add additional parameters
	 *
	 * @param $all_themes
	 * @return array
	 */
	public static function get_theme_config( $all_themes ) {

		$new_all_themes = array();
		$asea_themes = self::$themes;

		$all_themes = is_array($all_themes) ? $all_themes : array();
		foreach ( $all_themes as $theme_id => $theme ) {

			if ( isset( $asea_themes[$theme_id] ) ) {
				$new_all_themes[$theme_id] = array_merge( $theme, $asea_themes[$theme_id] );
				unset( $asea_themes[$theme_id] );
			}
		}

		return $new_all_themes;
	}

	/**
	 * Add color pickers to Wizard Main Page
	 * @param $kb_id
	 */
	public static function get_main_page_colors ( $kb_id ) {

		$form = new ASEA_KB_Config_Elements();
		
		$asea_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		$asea_specs['advanced_search_mp_title_font_color']['label'] = __( 'Title Text', 'echo-advanced-search' );
		$asea_specs['advanced_search_mp_text_input_background_color']['label'] = __( 'Input Background', 'echo-advanced-search' );
		$asea_specs['advanced_search_mp_text_input_border_color']['label'] = __( 'Input Border', 'echo-advanced-search' );

		$form->option_group_wizard( $asea_specs, array(
			'option-heading'    => __( 'Advanced Search Box', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'inputs'            => array (
				'0' => $form->text( $asea_specs['advanced_search_mp_title_font_color'] + array(
						'value'             => $asea_config['advanced_search_mp_title_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 #asea-search-title, .eckb-wizard-step-3 #asea-search-description-1, .eckb-wizard-step-3 #asea-search-description-2,  .eckb-wizard-step-2 .epkb-wt-panel--active #asea-search-title, .eckb-wizard-step-2 .epkb-wt-panel--active #asea-search-description-1, .eckb-wizard-step-2 .epkb-wt-panel--active #asea-search-description-2',
							'style_name' => 'color'
						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_mp_title_font_shadow_color'] + array(
						'value'             => $asea_config['advanced_search_mp_title_font_shadow_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_title_font_shadow_color.jpg',
							'preview' => '1'
						)
					) ),
				'2' => $form->text( $asea_specs['advanced_search_mp_description_below_title_font_shadow_color'] + array(
						'value'             => $asea_config['advanced_search_mp_description_below_title_font_shadow_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_description_below_title_font_shadow_color.jpg',
							'preview' => '1'
						)
					) ),
				'3' => $form->text( $asea_specs['advanced_search_mp_link_font_color'] + array(
						'value'             => $asea_config['advanced_search_mp_link_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 #asea-doc-search-container #asea-section-1 a, .eckb-wizard-step-2 .epkb-wt-panel--active #asea-doc-search-container #asea-section-1 a',
							'style_name' => 'color'
						)
					) ),
				'4' => $form->text( $asea_specs['advanced_search_mp_background_color'] + array(
						'value'             => $asea_config['advanced_search_mp_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 #asea-section-1, .eckb-wizard-step-2 .epkb-wt-panel--active #asea-section-1',
							'style_name' => 'background-color'
						)
					) ),
				'5' => $form->text( $asea_specs['advanced_search_mp_text_input_background_color'] + array(
						'value'             => $asea_config['advanced_search_mp_text_input_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-box, .eckb-wizard-step-2 .epkb-wt-panel--active .asea-search-box',
							'style_name' => 'background'
						)
					) ), 
				'6' => $form->text( array(
						'label' => __('Gradient background: From', 'echo-advanced-search'),
						'value'             => $asea_config['advanced_search_mp_background_gradient_from_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_background_gradient_from_color.jpg',
							'preview' => '1'
						)
					) + $asea_specs['advanced_search_mp_background_gradient_from_color'] ),
				'7' => $form->text( array(
						'label' => __('Gradient background: To', 'echo-advanced-search'),
						'value'             => $asea_config['advanced_search_mp_background_gradient_to_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_background_gradient_to_color.jpg',
							'preview' => '1'
						)
					) + $asea_specs['advanced_search_mp_background_gradient_to_color'] ),	
				'8' => $form->text( $asea_specs['advanced_search_mp_filter_box_font_color'] + array(
						'value'             => $asea_config['advanced_search_mp_filter_box_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_filter_box_font_color.jpg',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-filter-icon-container, .eckb-wizard-step-2 .epkb-wt-panel--active .asea-search-filter-icon-container',
							'style_name' => 'color'
						)
					) ),	
				'9' => $form->text( $asea_specs['advanced_search_mp_filter_box_background_color'] + array(
						'value'             => $asea_config['advanced_search_mp_filter_box_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_filter_box_background_color.jpg',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-filter-icon-container, .eckb-wizard-step-2 .epkb-wt-panel--active .asea-search-filter-icon-container',
							'style_name' => 'background-color'
						)
					) ),	
				'10' => $form->text( $asea_specs['advanced_search_mp_search_result_category_color'] + array(
						'value'             => $asea_config['advanced_search_mp_search_result_category_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_mp_search_result_category_color.jpg',
						)
					) ),
					/* keep in Search Wizard
				'3' => $form->text( $asea_specs['advanced_search_mp_btn_background_color'] + array(
						'value'             => $asea_config['advanced_search_mp_btn_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-box',
							'style_name' => 'background'
						)
					) ),
				'4' => $form->text( $asea_specs['advanced_search_mp_btn_border_color'] + array(
						'value'             => $asea_config['advanced_search_mp_btn_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-box',
							'style_name' => 'background'
						)
					) ),  */
				'11' => $form->text( $asea_specs['advanced_search_mp_text_input_border_color'] + array(
						'value'             => $asea_config['advanced_search_mp_text_input_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-box, .eckb-wizard-step-2 .epkb-wt-panel--active .asea-search-box',
							'style_name' => 'border-color'
						)
						
					) ), /* keep in Search Wizard
				'6' => $form->text( $asea_specs['advanced_search_mp_filter_box_font_color'] + array(
						'value'             => $asea_config['advanced_search_mp_filter_box_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
					) ),
				'7' => $form->text( $asea_specs['advanced_search_mp_filter_box_background_color'] + array(
						'value'             => $asea_config['advanced_search_mp_filter_box_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
					) ),
				'8' => $form->text( $asea_specs['advanced_search_mp_search_result_category_color'] + array(
						'value'             => $asea_config['advanced_search_mp_search_result_category_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
					) ), */
					
			)
		));
		
	}

	/**
	 * Add color pickers to Wizard Article Page
	 * @param $kb_id
	 */
	public static function get_article_page_colors ( $kb_id ) {
		$form = new ASEA_KB_Config_Elements();
		
		$asea_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		$asea_specs['advanced_search_ap_title_font_color']['label'] = __( 'Title Text', 'echo-advanced-search' );
		$asea_specs['advanced_search_ap_text_input_background_color']['label'] = __( 'Input Background', 'echo-advanced-search' );
		$asea_specs['advanced_search_ap_text_input_border_color']['label'] = __( 'Input Border Color', 'echo-advanced-search' );
		
		$form->option_group_wizard( $asea_specs, array(
			'option-heading'    => __( 'Advanced Search Box', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs'            => array (
				'0' => $form->text( $asea_specs['advanced_search_ap_title_font_color'] + array(
						'value'             => $asea_config['advanced_search_ap_title_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 #asea-search-title, .eckb-wizard-step-4 #asea-search-description-1',
							'style_name' => 'color'
						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_ap_title_font_shadow_color'] + array(
						'value'             => $asea_config['advanced_search_ap_title_font_shadow_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_title_font_shadow_color.jpg',
							'preview' => '1'
						)
					) ),
				'2' => $form->text( $asea_specs['advanced_search_ap_description_below_title_font_shadow_color'] + array(
						'value'             => $asea_config['advanced_search_ap_description_below_title_font_shadow_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_description_below_title_font_shadow_color.jpg',
							'preview' => '1'
						)
					) ),
				'3' => $form->text( $asea_specs['advanced_search_ap_link_font_color'] + array(
						'value'             => $asea_config['advanced_search_ap_link_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 #asea-doc-search-container #asea-section-1 a',
							'style_name' => 'color'
						)
					) ),
				'4' => $form->text( $asea_specs['advanced_search_ap_background_color'] + array(
						'value'             => $asea_config['advanced_search_ap_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 #asea-section-1',
							'style_name' => 'background-color'
						)
					) ),
				'5' => $form->text( $asea_specs['advanced_search_ap_text_input_background_color'] + array(
						'value'             => $asea_config['advanced_search_ap_text_input_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .asea-search-box',
							'style_name' => 'background'
						)
					) ),
				'6' => $form->text( array(
						'label' => __('Gradient background: From', 'echo-advanced-search'),
						'value'             => $asea_config['advanced_search_ap_background_gradient_from_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_background_gradient_from_color.jpg',
							'preview' => '1'
						)
					) + $asea_specs['advanced_search_ap_background_gradient_from_color'] ),
				'7' => $form->text( array(
						'label' => __('Gradient background: To', 'echo-advanced-search'),
						'value'             => $asea_config['advanced_search_ap_background_gradient_to_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_background_gradient_to_color.jpg',
							'preview' => '1'
						)
					) + $asea_specs['advanced_search_ap_background_gradient_to_color'] ),	
				'8' => $form->text( $asea_specs['advanced_search_ap_filter_box_font_color'] + array(
						'value'             => $asea_config['advanced_search_ap_filter_box_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_filter_box_font_color.jpg',
							'target_selector' => '.eckb-wizard-step-4 .asea-search-filter-icon-container',
							'style_name' => 'color'
						)
					) ),	
				'9' => $form->text( $asea_specs['advanced_search_ap_filter_box_background_color'] + array(
						'value'             => $asea_config['advanced_search_ap_filter_box_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_filter_box_background_color.jpg',
							'target_selector' => '.eckb-wizard-step-4 .asea-search-filter-icon-container',
							'style_name' => 'background-color'
						)
					) ),	
				'10' => $form->text( $asea_specs['advanced_search_ap_search_result_category_color'] + array(
						'value'             => $asea_config['advanced_search_ap_search_result_category_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'example_image'     =>      '[asea]theme-wizard/wizard-screenshot-advanced_search_ap_search_result_category_color.jpg',
						)
					) ),/* keep in Search Wizard
				'3' => $form->text( $asea_specs['advanced_search_ap_btn_background_color'] + array(
						'value'             => $asea_config['advanced_search_ap_btn_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-box',
							'style_name' => 'background'
						)
					) ),
				'4' => $form->text( $asea_specs['advanced_search_ap_btn_border_color'] + array(
						'value'             => $asea_config['advanced_search_ap_btn_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .asea-search-box',
							'style_name' => 'background'
						)
					) ), */
				'11' => $form->text( $asea_specs['advanced_search_ap_text_input_border_color'] + array(
						'value'             => $asea_config['advanced_search_ap_text_input_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .asea-search-box',
							'style_name' => 'border-color'
						)
					) ),/* keep in Search Wizard
				'6' => $form->text( $asea_specs['advanced_search_ap_filter_box_font_color'] + array(
						'value'             => $asea_config['advanced_search_ap_filter_box_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
					) ),
				'7' => $form->text( $asea_specs['advanced_search_ap_filter_box_background_color'] + array(
						'value'             => $asea_config['advanced_search_ap_filter_box_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
					) ),
				'8' => $form->text( $asea_specs['advanced_search_ap_search_result_category_color'] + array(
						'value'             => $asea_config['advanced_search_ap_search_result_category_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
					) ), */
			)
		));
		
	}

	/**
	 * Add presets for Grid/Sidebar
	 *
	 * @param $presets
	 * @param $preset_id
	 * @return array
	 */
	public static function get_color_presets( $presets, $preset_id ) {

		$preset_config_default = array(
			'advanced_search_mp_title_font_color'                              =>  '#000000',
			'advanced_search_mp_link_font_color'                               =>  '#000000',
			'advanced_search_mp_background_color'                              =>  '#F7F7F7',
			'advanced_search_mp_text_input_background_color'                   =>  '#FFFFFF',
			'advanced_search_mp_text_input_border_color'                       =>  '#CCCCCC',
			'advanced_search_mp_btn_background_color'                          =>  '#686868',
			'advanced_search_mp_btn_border_color'                              =>  '#F1F1F1',
			'advanced_search_mp_background_gradient_from_color'                =>  '#00c1b6',
			'advanced_search_mp_background_gradient_to_color'                  =>  '#136eb5',
			'advanced_search_mp_title_font_shadow_color'                       =>  '#010000',
			'advanced_search_mp_description_below_title_font_shadow_color'     =>  '#010000',
			'advanced_search_mp_filter_box_font_color'                         =>  '#000000',
			'advanced_search_mp_filter_box_background_color'                   =>  '#ffffff',
			'advanced_search_mp_search_result_category_color'                  =>  '#000000',

			'advanced_search_ap_title_font_color'                              =>  '#000000',
			'advanced_search_ap_link_font_color'                               =>  '#000000',
			'advanced_search_ap_background_color'                              =>  '#F7F7F7',
			'advanced_search_ap_text_input_background_color'                   =>  '#FFFFFF',
			'advanced_search_ap_text_input_border_color'                       =>  '#CCCCCC',
			'advanced_search_ap_btn_background_color'                          =>  '#686868',
			'advanced_search_ap_btn_border_color'                              =>  '#F1F1F1',
			'advanced_search_ap_background_gradient_from_color'                =>  '#00c1b6',
			'advanced_search_ap_background_gradient_to_color'                  =>  '#136eb5',
			'advanced_search_ap_title_font_shadow_color'                       =>  '#010000',
			'advanced_search_ap_description_below_title_font_shadow_color'     =>  '#010000',
			'advanced_search_ap_filter_box_font_color'                         =>  '#000000',
			'advanced_search_ap_filter_box_background_color'                   =>  '#ffffff',
			'advanced_search_ap_search_result_category_color'                  =>  '#000000',

			'advanced_search_mp_background_gradient_toggle'                    => 'off',
			'advanced_search_mp_background_image_url'                          => '',
			'advanced_search_ap_background_gradient_toggle'                    => 'off',
			'advanced_search_ap_background_image_url'                          => ''
		);

		// for Eleg. Layout search box color presets should be set from basic search
		$preset_config['advanced_search_mp_title_font_color'] = $presets['search_title_font_color'];
		$preset_config['advanced_search_mp_background_color'] = $presets['search_background_color'];
		$preset_config['advanced_search_mp_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['advanced_search_mp_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['advanced_search_mp_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['advanced_search_mp_btn_border_color'] = $presets['search_btn_border_color'];

		$preset_config['advanced_search_ap_title_font_color'] = $presets['search_title_font_color'];
		$preset_config['advanced_search_ap_background_color'] = $presets['search_background_color'];
		$preset_config['advanced_search_ap_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['advanced_search_ap_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['advanced_search_ap_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['advanced_search_ap_btn_border_color'] = $presets['search_btn_border_color'];

		$preset_config = array_merge($preset_config_default, $preset_config);

		return array_merge($presets, $preset_config);
	}

	
	// custom themes or custom parameters to existing themes (you can use id from core theme and add only 1-2 strings of the paramenters)
	public static $themes = array(

		// BASIC LAYOUT

		'theme_standard' => array(
			'advanced_search_mp_title_font_color'               => '#FFFFFF',
			'advanced_search_mp_background_color'               => '#f7941d',
			'advanced_search_mp_text_input_background_color'    => '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        => '#CCCCCC',
			'advanced_search_mp_btn_background_color'           => '#40474f',
			'advanced_search_mp_btn_border_color'               => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_title_font_color'               => '#FFFFFF',
			'advanced_search_ap_background_color'               => '#f7941d',
			'advanced_search_ap_text_input_background_color'    => '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        => '#CCCCCC',
			'advanced_search_ap_btn_background_color'           => '#40474f',
			'advanced_search_ap_btn_border_color'               => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),

		'theme_spacious' => array(
			'advanced_search_mp_title_font_color'			    => '#000000',
			'advanced_search_mp_background_color'			    => '#ffffff',
			'advanced_search_mp_text_input_border_color'		=> '#CCCCCC',
			'advanced_search_mp_btn_background_color'			=> '#1168bf',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'			    => '#000000',
			'advanced_search_ap_background_color'			    => '#ffffff',
			'advanced_search_ap_text_input_border_color'		=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			=> '#1168bf',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'theme_informative' => array(
			'advanced_search_mp_title_font_color'               => '#ffffff',
			'advanced_search_mp_background_color'			    => '#904e95',
			'advanced_search_mp_text_input_border_color'        => '#CCCCCC',
			'advanced_search_mp_btn_background_color'			=> '#686868',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#ffffff',

			'advanced_search_ap_title_font_color'               => '#ffffff',
			'advanced_search_ap_background_color'			    => '#904e95',
			'advanced_search_ap_text_input_border_color'        => '#CCCCCC',
			'advanced_search_ap_btn_background_color'			=> '#686868',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#ffffff',
		),
		
		'theme_image' => array(
			'advanced_search_mp_title_font_color'               => '#ffffff',
			'advanced_search_mp_background_color'			    => '#B1D5E1',
			'advanced_search_mp_text_input_border_color'        => '#CCCCCC',
			'advanced_search_mp_btn_background_color'			=> '#686868',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_title_font_color'               => '#ffffff',
			'advanced_search_ap_background_color'			    => '#B1D5E1',
			'advanced_search_ap_text_input_border_color'        => '#CCCCCC',
			'advanced_search_ap_btn_background_color'			=> '#686868',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),

		'theme_modern' => array(
			'advanced_search_mp_title_font_color'               => '#ffffff',
			'advanced_search_mp_background_color'			    => '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        => '#40474f',
			'advanced_search_mp_btn_background_color'			=> '#40474f',
			'advanced_search_mp_btn_border_color'			    => '#40474f',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',
			'advanced_search_mp_title_text_shadow_toggle'       => 'off',

			'advanced_search_ap_title_font_color'               => '#ffffff',
			'advanced_search_ap_background_color'			    => '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        => '#40474f',
			'advanced_search_ap_btn_background_color'			=> '#40474f',
			'advanced_search_ap_btn_border_color'			    => '#40474f',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
			'advanced_search_ap_title_font_shadow_color'        => '#ffffff',
			'advanced_search_ap_title_text_shadow_toggle'       => 'off',
		),

		'theme_bright' => array(
			'advanced_search_mp_title_font_color'               => '#ffffff',
			'advanced_search_mp_background_color'			    => '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        => '#0bcad9',
			'advanced_search_mp_btn_background_color'			=> '#f4c60c',
			'advanced_search_mp_btn_border_color'			    => '#f4c60c',
			'advanced_search_mp_link_font_color'                => '#000000',
			'advanced_search_mp_title_font_shadow_color'        => '#ffffff',
			'advanced_search_mp_title_text_shadow_toggle'       => 'off',

			'advanced_search_ap_title_font_color'               => '#ffffff',
			'advanced_search_ap_background_color'			    => '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        => '#0bcad9',
			'advanced_search_ap_btn_background_color'			=> '#f4c60c',
			'advanced_search_ap_btn_border_color'			    => '#f4c60c',
			'advanced_search_ap_link_font_color'                => '#000000',
			'advanced_search_ap_title_font_shadow_color'        => '#ffffff',
			'advanced_search_ap_title_text_shadow_toggle'       => 'off',
		),

		'theme_formal' => array(
			'advanced_search_mp_title_font_color'               => '#000000',
			'advanced_search_mp_background_color'			    => '#edf2f6',
			'advanced_search_mp_text_input_border_color'        => '#d1d1d1',
			'advanced_search_mp_btn_background_color'			=> '#666666',
			'advanced_search_mp_btn_border_color'			    => '#666666',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'               => '#000000',
			'advanced_search_ap_background_color'			    => '#edf2f6',
			'advanced_search_ap_text_input_border_color'        => '#d1d1d1',
			'advanced_search_ap_btn_background_color'			=> '#666666',
			'advanced_search_ap_btn_border_color'			    => '#666666',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'theme_disctinct' => array(
			'advanced_search_mp_title_font_color'               => '#528ffe',
			'advanced_search_mp_background_color'			    => '#f4f8ff',
			'advanced_search_mp_text_input_border_color'        => '#bf25ff',
			'advanced_search_mp_btn_background_color'			=> '#bf25ff',
			'advanced_search_mp_btn_border_color'			    => '#bf25ff',
			'advanced_search_mp_link_font_color'                => '#528ffe',

			'advanced_search_ap_title_font_color'               => '#528ffe',
			'advanced_search_ap_background_color'			    => '#f4f8ff',
			'advanced_search_ap_text_input_border_color'        => '#bf25ff',
			'advanced_search_ap_btn_background_color'			=> '#bf25ff',
			'advanced_search_ap_btn_border_color'			    => '#bf25ff',
			'advanced_search_ap_link_font_color'                => '#528ffe',
		),

		'theme_faqs' => array(
			'advanced_search_mp_title_font_color'               => '#ffffff',
			'advanced_search_mp_background_color'			    => '#bf25ff',
			'advanced_search_mp_text_input_border_color'        => '#37de89',
			'advanced_search_mp_btn_background_color'			=> '#666666',
			'advanced_search_mp_btn_border_color'			    => '#666666',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_title_font_color'               => '#ffffff',
			'advanced_search_ap_background_color'			    => '#37de89',
			'advanced_search_ap_text_input_border_color'        => '#37de89',
			'advanced_search_ap_btn_background_color'			=> '#666666',
			'advanced_search_ap_btn_border_color'			    => '#666666',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),


		// TABS LAYOUT

		'theme_organized' => array(
			'advanced_search_mp_background_color'			    => '#8c1515',
			'advanced_search_mp_text_input_border_color'		=> '#000000',
			'advanced_search_mp_btn_background_color'			=> '#878787',
			'advanced_search_mp_btn_border_color'			    => '#000000',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_background_color'			    => '#8c1515',
			'advanced_search_ap_text_input_border_color'		=> '#000000',
			'advanced_search_ap_btn_background_color'			=> '#878787',
			'advanced_search_ap_btn_border_color'			    => '#000000',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),

		'theme_organized_2' => array(
			'advanced_search_mp_background_color'			    => '#00b4b3',
			'advanced_search_mp_text_input_border_color'		=> '#00c6c6',
			'advanced_search_mp_btn_background_color'			=> '#686868',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_background_color'			    => '#00b4b3',
			'advanced_search_ap_text_input_border_color'		=> '#00c6c6',
			'advanced_search_ap_btn_background_color'			=> '#686868',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),

		'theme_products_style' => array(
			'advanced_search_mp_title_font_color'               => '#FFFFFF',
			'advanced_search_mp_background_color'			    => '#6e6767',
			'advanced_search_mp_text_input_border_color'		=> '#1e73be',
			'advanced_search_mp_btn_background_color'			=> '#686868',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_title_font_color'               => '#FFFFFF',
			'advanced_search_ap_background_color'			    => '#6e6767',
			'advanced_search_ap_text_input_border_color'		=> '#1e73be',
			'advanced_search_ap_btn_background_color'			=> '#686868',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),

		'theme_tabs_clean_style' => array(
			'advanced_search_mp_title_font_color'               => '#000000',
			'advanced_search_mp_background_color'			    => '#f2f2f2',
			'advanced_search_mp_text_input_border_color'		=> '#000000',
			'advanced_search_mp_btn_background_color'			=> '#000000',
			'advanced_search_mp_btn_border_color'			    => '#000000',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'               => '#000000',
			'advanced_search_ap_background_color'			    => '#f2f2f2',
			'advanced_search_ap_text_input_border_color'		=> '#000000',
			'advanced_search_ap_btn_background_color'			=> '#000000',
			'advanced_search_ap_btn_border_color'			    => '#000000',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		// Category Focused LAYOUT
		'standard_2' => array(
			'advanced_search_mp_title_font_color'               =>  '#FFFFFF',
			'advanced_search_mp_background_color'               =>  '#2991a3',
			'advanced_search_mp_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        =>  '#CCCCCC',
			'advanced_search_mp_btn_background_color'           =>  '#40474f',
			'advanced_search_mp_btn_border_color'               =>  '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'               =>  '#FFFFFF',
			'advanced_search_ap_background_color'               =>  '#2991a3',
			'advanced_search_ap_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        =>  '#CCCCCC',
			'advanced_search_ap_btn_background_color'           =>  '#40474f',
			'advanced_search_ap_btn_border_color'               =>  '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'standard_3' => array(
			'advanced_search_mp_title_font_color'               =>  '#fcfcfc',
			'advanced_search_mp_background_color'               =>  '#fcfcfc',
			'advanced_search_mp_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        =>  '#0bcad9',
			'advanced_search_mp_btn_background_color'           =>  '#f4c60c',
			'advanced_search_mp_btn_border_color'               =>  '#0bcad9',
			'advanced_search_mp_link_font_color'                => '#000000',
			'advanced_search_mp_title_font_shadow_color'        => '#ffffff',
			'advanced_search_mp_title_text_shadow_toggle'       => 'off',

			'advanced_search_ap_title_font_color'               =>  '#fcfcfc',
			'advanced_search_ap_background_color'               =>  '#fcfcfc',
			'advanced_search_ap_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        =>  '#0bcad9',
			'advanced_search_ap_btn_background_color'           =>  '#f4c60c',
			'advanced_search_ap_btn_border_color'               =>  '#0bcad9',
			'advanced_search_ap_link_font_color'                => '#000000',
			'advanced_search_ap_title_font_shadow_color'        => '#ffffff',
			'advanced_search_ap_title_text_shadow_toggle'       => 'off',
		),

		'business' => array(
			'advanced_search_mp_title_font_color'               =>  '#000000',
			'advanced_search_mp_background_color'               =>  '#fbfbfb',
			'advanced_search_mp_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        =>  '#CCCCCC',
			'advanced_search_mp_btn_background_color'           =>  '#40474f',
			'advanced_search_mp_btn_border_color'               =>  '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'               =>  '#000000',
			'advanced_search_ap_background_color'               =>  '#fbfbfb',
			'advanced_search_ap_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        =>  '#CCCCCC',
			'advanced_search_ap_btn_background_color'           =>  '#40474f',
			'advanced_search_ap_btn_border_color'               =>  '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'business_2' => array(
			'advanced_search_mp_title_font_color'               =>  '#6fb24c',
			'advanced_search_mp_background_color'               =>  '#fbfbfb',
			'advanced_search_mp_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_mp_text_input_border_color'        =>  '#6fb24c',
			'advanced_search_mp_btn_background_color'           =>  '#6fb24c',
			'advanced_search_mp_btn_border_color'               =>  '#6fb24c',
			'advanced_search_mp_link_font_color'                => '#6fb24c',

			'advanced_search_ap_title_font_color'               =>  '#6fb24c',
			'advanced_search_ap_background_color'               =>  '#fbfbfb',
			'advanced_search_ap_text_input_background_color'    =>  '#FFFFFF',
			'advanced_search_ap_text_input_border_color'        =>  '#6fb24c',
			'advanced_search_ap_btn_background_color'           =>  '#6fb24c',
			'advanced_search_ap_btn_border_color'               =>  '#6fb24c',
			'advanced_search_ap_link_font_color'                => '#6fb24c',
		),

		// GRID

		'theme_grid_basic' => array(
			'advanced_search_mp_title_font_color'			    => '#000000',
			'advanced_search_mp_background_color'			    => '#ffffff',
			'advanced_search_mp_text_input_border_color'		=> '#CCCCCC',
			'advanced_search_mp_btn_background_color'			=> '#1168bf',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'			    => '#000000',
			'advanced_search_ap_background_color'			    => '#ffffff',
			'advanced_search_ap_text_input_border_color'		=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			=> '#1168bf',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'theme_grid_demo_5' => array(
			'advanced_search_mp_title_font_color'               => '#000000',
			'advanced_search_mp_background_color'               => '#904e95',
			'advanced_search_mp_text_input_border_color'        => '#CCCCCC',
			'advanced_search_mp_btn_background_color'			=> '#1168bf',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'               => '#000000',
			'advanced_search_ap_background_color'               => '#904e95',
			'advanced_search_ap_text_input_border_color'        => '#CCCCCC',
			'advanced_search_ap_btn_background_color'			=> '#1168bf',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'theme_grid_demo_6' => array(
			'advanced_search_mp_title_font_color'			    => '#000000',
			'advanced_search_mp_background_color'			    => '#ffffff',
			'advanced_search_mp_text_input_border_color'		=> '#f7941d',
			'advanced_search_mp_btn_background_color'			=> '#1168bf',
			'advanced_search_mp_btn_border_color'			    => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'			    => '#000000',
			'advanced_search_ap_background_color'			    => '#ffffff',
			'advanced_search_ap_text_input_border_color'		=> '#f7941d',
			'advanced_search_ap_btn_background_color'			=> '#1168bf',
			'advanced_search_ap_btn_border_color'			    => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'theme_grid_demo_7' => array(
			'advanced_search_mp_title_font_color'			        => '#000000',
			'advanced_search_mp_background_color'			        => '#ffffff',
			'advanced_search_mp_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_mp_btn_background_color'			    => '#1168bf',
			'advanced_search_mp_btn_border_color'			        => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'			        => '#000000',
			'advanced_search_ap_background_color'			        => '#ffffff',
			'advanced_search_ap_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			    => '#1168bf',
			'advanced_search_ap_btn_border_color'			        => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		// SIDEBAR

		'theme_sidebar_basic' => array(
			'advanced_search_mp_title_font_color'			        => '#000000',
			'advanced_search_mp_background_color'			        => '#ffffff',
			'advanced_search_mp_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_mp_btn_background_color'			    => '#1168bf',
			'advanced_search_mp_btn_border_color'			        => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'			        => '#000000',
			'advanced_search_ap_background_color'			        => '#ffffff',
			'advanced_search_ap_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			    => '#1168bf',
			'advanced_search_ap_btn_border_color'			        => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),

		'theme_sidebar_colapsed' => array(
			'advanced_search_mp_title_font_color'			        => '#ffffff',
			'advanced_search_mp_background_color'			        => '#904e95',
			'advanced_search_mp_text_input_border_color'			=> '#eeee22',
			'advanced_search_mp_btn_background_color'			    => '#1168bf',
			'advanced_search_mp_btn_border_color'			        => '#F1F1F1',
			'advanced_search_mp_text_input_background_color' => '#ffffff',
			'advanced_search_mp_link_font_color'                => '#FFFFFF',

			'advanced_search_ap_title_font_color'			        => '#000000',
			'advanced_search_ap_background_color'			        => '#ffffff',
			'advanced_search_ap_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			    => '#1168bf',
			'advanced_search_ap_btn_border_color'			        => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#FFFFFF',
		),

		'theme_sidebar_formal' => array(
			'advanced_search_mp_title_font_color'			        => '#136eb5',
			'advanced_search_mp_background_color'			        => '#f9f9f9',
			'advanced_search_mp_text_input_border_color'			=> '#00c1b6',
			'advanced_search_mp_btn_background_color'			    => '#1168bf',
			'advanced_search_mp_btn_border_color'			        => '#F1F1F1',
			'advanced_search_mp_text_input_background_color' => '#ffffff',
			'advanced_search_mp_link_font_color'                => '#136eb5',

			'advanced_search_ap_title_font_color'			        => '#000000',
			'advanced_search_ap_background_color'			        => '#ffffff',
			'advanced_search_ap_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			    => '#1168bf',
			'advanced_search_ap_btn_border_color'			        => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#136eb5',
		),

		'theme_sidebar_compact' => array(
			'advanced_search_mp_title_font_color'                   => '#f7941d',
			'advanced_search_mp_background_color'                   => '#fbfbfb',
			'advanced_search_mp_text_input_border_color'            => '#f7941d',
			'advanced_search_mp_btn_background_color'			    => '#1168bf',
			'advanced_search_mp_btn_border_color'			        => '#F1F1F1',
			'advanced_search_mp_text_input_background_color' => '#ffffff',
			'advanced_search_mp_link_font_color'                => '#f7941d',

			'advanced_search_ap_title_font_color'                   => '#ffffff',
			'advanced_search_ap_background_color'                   => '#827a74',
			'advanced_search_ap_text_input_border_color'            => '#F1F1F1',
			'advanced_search_ap_btn_background_color'			    => '#1168bf',
			'advanced_search_ap_btn_border_color'			        => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#f7941d',
		),

		'theme_sidebar_plain' => array(
			'advanced_search_mp_title_font_color'			        => '#000000',
			'advanced_search_mp_background_color'			        => '#ffffff',
			'advanced_search_mp_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_mp_btn_background_color'			    => '#1168bf',
			'advanced_search_mp_btn_border_color'			        => '#F1F1F1',
			'advanced_search_mp_link_font_color'                => '#000000',

			'advanced_search_ap_title_font_color'			        => '#000000',
			'advanced_search_ap_background_color'			        => '#ffffff',
			'advanced_search_ap_text_input_border_color'			=> '#CCCCCC',
			'advanced_search_ap_btn_background_color'			    => '#1168bf',
			'advanced_search_ap_btn_border_color'			        => '#F1F1F1',
			'advanced_search_ap_link_font_color'                => '#000000',
		),
	);
		
	public static function get_kb_search_fields_list( $fields ) {
		
		$fields = array_merge( $fields, array(
			// ADVANCED SEARCH - MAIN PAGE
			'advanced_search_mp_box_visibility',
			'advanced_search_mp_auto_complete_wait',
			'advanced_search_mp_results_list_size',
			'advanced_search_mp_results_page_size',
			'advanced_search_mp_show_top_category',
			'advanced_search_mp_title_font_size',
			'advanced_search_mp_title_font_weight',
			'advanced_search_mp_title_padding_bottom',
			'advanced_search_mp_box_font_width',
		
			'advanced_search_mp_box_input_width',
			'advanced_search_mp_input_border_width',
			'advanced_search_mp_input_box_radius',
			'advanced_search_mp_input_box_font_size',
			'advanced_search_mp_input_box_padding_top',
			'advanced_search_mp_input_box_padding_bottom',
			'advanced_search_mp_input_box_padding_left',
			'advanced_search_mp_input_box_padding_right',
			'advanced_search_mp_input_box_shadow_x_offset',
			'advanced_search_mp_input_box_shadow_y_offset',
			'advanced_search_mp_input_box_shadow_blur',
			'advanced_search_mp_input_box_shadow_spread',
			'advanced_search_mp_input_box_shadow_rgba',
			'advanced_search_mp_input_box_shadow_position_group',
			'advanced_search_mp_input_box_shadow_position_group',
			'advanced_search_mp_input_box_search_icon_placement',
			'advanced_search_mp_input_box_loading_icon_placement',
			'advanced_search_mp_background_image_url',
			'advanced_search_mp_background_image_position_x',
			'advanced_search_mp_background_image_position_y',
			'advanced_search_mp_background_pattern_image_url',
			'advanced_search_mp_background_pattern_image_position_x',
			'advanced_search_mp_background_pattern_image_position_y',
			'advanced_search_mp_background_pattern_image_opacity',
			'advanced_search_mp_background_gradient_degree',
			'advanced_search_mp_background_gradient_opacity',
			'advanced_search_mp_background_gradient_toggle',
			'advanced_search_mp_box_padding_top',
			'advanced_search_mp_box_padding_bottom',
			'advanced_search_mp_box_padding_left',
			'advanced_search_mp_box_padding_right',
			'advanced_search_mp_box_margin_top',
			'advanced_search_mp_box_margin_bottom',
			'advanced_search_mp_box_input_width',
			'advanced_search_mp_title_font_size',
			'advanced_search_mp_title_font_weight',
			'advanced_search_mp_title_padding_bottom',
			'advanced_search_mp_text_title_shadow_position_group',
			'advanced_search_mp_title_text_shadow_x_offset',
			'advanced_search_mp_title_text_shadow_y_offset',
			'advanced_search_mp_title_text_shadow_blur',
			'advanced_search_mp_title_text_shadow_toggle',
			'advanced_search_mp_title_tag',
			'advanced_search_mp_filter_category_level',
			'advanced_search_mp_filter_toggle',
			'advanced_search_mp_filter_dropdown_width',

			'advanced_search_mp_description_below_title_font_size',
			'advanced_search_mp_description_below_title_padding_top',
			'advanced_search_mp_description_below_title_padding_bottom',
			'advanced_search_mp_description_below_title_text_shadow_x_offset',
			'advanced_search_mp_description_below_title_text_shadow_y_offset',
			'advanced_search_mp_description_below_title_text_shadow_blur',
			'advanced_search_mp_description_below_title_text_shadow_toggle',
			'advanced_search_mp_description_below_input',
			'advanced_search_mp_description_below_input_font_size',
			'advanced_search_mp_description_below_input_padding_top',
			'advanced_search_mp_description_below_input_padding_bottom',
			'advanced_search_mp_search_results_article_font_size',
			'advanced_search_mp_box_results_style',
			'advanced_search_mp_title_font_color',
			'advanced_search_mp_link_font_color',
			'advanced_search_mp_background_color',
			'advanced_search_mp_text_input_background_color',
			'advanced_search_mp_text_input_border_color',
			'advanced_search_mp_btn_background_color',
			'advanced_search_mp_btn_border_color',
			'advanced_search_mp_background_gradient_from_color',
			'advanced_search_mp_background_gradient_to_color',
			'advanced_search_mp_title',
			'advanced_search_mp_description_below_title',
			'advanced_search_mp_description_below_title',
			'advanced_search_mp_box_hint',
			'advanced_search_mp_button_name',
			'advanced_search_mp_title_font_shadow_color',
			'advanced_search_mp_filter_box_font_color',
			'advanced_search_mp_filter_box_background_color',
			'advanced_search_mp_filter_indicator_text',	

			// ADVANCED SEARCH - ARTICLE PAGE
			'advanced_search_ap_box_visibility',
			'advanced_search_ap_auto_complete_wait',
			'advanced_search_ap_results_list_size',
			'advanced_search_ap_results_page_size',
			'advanced_search_ap_show_top_category',
			'advanced_search_ap_title_font_size',
			'advanced_search_ap_title_font_weight',
			'advanced_search_ap_title_padding_bottom',
			'advanced_search_ap_text_title_shadow_position_group',
			'advanced_search_ap_title_text_shadow_x_offset',
			'advanced_search_ap_title_text_shadow_y_offset',
			'advanced_search_ap_title_text_shadow_blur',
			'advanced_search_ap_title_text_shadow_toggle',
			'advanced_search_ap_title_tag',
			'advanced_search_ap_filter_category_level',
			'advanced_search_ap_filter_toggle',
			'advanced_search_ap_filter_dropdown_width',
			'advanced_search_ap_box_font_width',


			'advanced_search_ap_box_input_width',
			'advanced_search_ap_input_border_width',
			'advanced_search_ap_input_box_radius',
			'advanced_search_ap_input_box_font_size',
			'advanced_search_ap_input_box_padding_top',
			'advanced_search_ap_input_box_padding_bottom',
			'advanced_search_ap_input_box_padding_left',
			'advanced_search_ap_input_box_padding_right',
			'advanced_search_ap_input_box_shadow_x_offset',
			'advanced_search_ap_input_box_shadow_y_offset',
			'advanced_search_ap_input_box_shadow_blur',
			'advanced_search_ap_input_box_shadow_spread',
			'advanced_search_ap_input_box_shadow_rgba',
			'advanced_search_ap_input_box_shadow_position_group',
			'advanced_search_ap_input_box_shadow_position_group',
			'advanced_search_ap_input_box_search_icon_placement',
			'advanced_search_ap_input_box_loading_icon_placement',
			'advanced_search_ap_background_image_url',
			'advanced_search_ap_background_image_position_x',
			'advanced_search_ap_background_image_position_y',
			'advanced_search_ap_background_pattern_image_url',
			'advanced_search_ap_background_pattern_image_position_x',
			'advanced_search_ap_background_pattern_image_position_y',
			'advanced_search_ap_background_pattern_image_opacity',
			'advanced_search_ap_background_gradient_degree',
			'advanced_search_ap_background_gradient_opacity',
			'advanced_search_ap_background_gradient_toggle',
			'advanced_search_ap_box_padding_top',
			'advanced_search_ap_box_padding_bottom',
			'advanced_search_ap_box_padding_left',
			'advanced_search_ap_box_padding_right',
			'advanced_search_ap_box_margin_top',
			'advanced_search_ap_box_margin_bottom',
			'advanced_search_ap_box_input_width',
			'advanced_search_ap_title_font_size',
			'advanced_search_ap_title_font_weight',
			'advanced_search_ap_title_padding_bottom',
			'advanced_search_ap_description_below_title_font_size',
			'advanced_search_ap_description_below_title_padding_top',
			'advanced_search_ap_description_below_title_padding_bottom',
			'advanced_search_ap_description_below_title_text_shadow_x_offset',
			'advanced_search_ap_description_below_title_text_shadow_y_offset',
			'advanced_search_ap_description_below_title_text_shadow_blur',
			'advanced_search_ap_description_below_title_text_shadow_toggle',
			'advanced_search_ap_description_below_input_font_size',
			'advanced_search_ap_description_below_input_padding_top',
			'advanced_search_ap_description_below_input_padding_bottom',
			'advanced_search_ap_search_results_article_font_size',
			'advanced_search_ap_box_results_style',
			'advanced_search_ap_title_font_color',
			'advanced_search_ap_link_font_color',
			'advanced_search_ap_background_color',
			'advanced_search_ap_text_input_background_color',
			'advanced_search_ap_text_input_border_color',
			'advanced_search_ap_btn_background_color',
			'advanced_search_ap_btn_border_color',
			'advanced_search_ap_background_gradient_from_color',
			'advanced_search_ap_background_gradient_to_color',
			'advanced_search_ap_title',
			'advanced_search_ap_description_below_title',
			'advanced_search_ap_description_below_title',
			'advanced_search_ap_box_hint',
			'advanced_search_ap_button_name',
			'advanced_search_ap_title_font_shadow_color',
			'advanced_search_ap_filter_box_font_color',
			'advanced_search_ap_filter_box_background_color',
			'advanced_search_ap_filter_indicator_text',
			
		) );
		return array_unique($fields);
	}
	
	public static function get_kb_text_fields_list( $fields ) {
		
		$fields = array_merge( $fields, array(
				// ADVANCED SEARCH TEXTS MAIN PAGE
			'advanced_search_mp_title',
			'advanced_search_mp_description_below_title',
			'advanced_search_mp_description_below_input',
			'advanced_search_mp_box_hint',
			'advanced_search_mp_results_msg',
			'advanced_search_mp_no_results_found',
			'advanced_search_mp_more_results_found',
			'advanced_search_mp_filter_indicator_text',

			// ADVANCED SEARCH TEXTS ARTICLE PAGE
			'advanced_search_ap_title',
			'advanced_search_ap_description_below_title',
			'advanced_search_ap_description_below_input',
			'advanced_search_ap_box_hint',
			'advanced_search_ap_results_msg',
			'advanced_search_ap_no_results_found',
			'advanced_search_ap_more_results_found',
			'advanced_search_ap_filter_indicator_text',

		) );
		
		return array_unique($fields);
	}
	
	public static function get_kb_theme_fields_list( $fields ) {
		
		$fields = array_merge( $fields, array(
			// ADVANCED SEARCH COLORS - MAIN PAGE
			'advanced_search_mp_title_text_shadow_toggle',
			'advanced_search_mp_title_font_color',
			'advanced_search_mp_title_font_shadow_color',
			'advanced_search_mp_description_below_title_font_shadow_color',
			'advanced_search_mp_link_font_color',
			'advanced_search_mp_background_color',
			'advanced_search_mp_text_input_background_color',
			'advanced_search_mp_text_input_border_color',
			'advanced_search_mp_btn_background_color',
			'advanced_search_mp_btn_border_color',
			'advanced_search_mp_background_gradient_from_color',
			'advanced_search_mp_background_gradient_to_color',
			'advanced_search_mp_filter_box_font_color',
			'advanced_search_mp_filter_box_background_color',
			'advanced_search_mp_search_result_category_color',
			'advanced_search_mp_show_top_category', // need to hide default search 
			'advanced_search_mp_background_image_url',

			'advanced_search_mp_input_box_shadow_x_offset',
			'advanced_search_mp_input_box_shadow_y_offset',
			'advanced_search_mp_input_box_shadow_blur',
			'advanced_search_mp_input_box_shadow_spread',
			'advanced_search_mp_input_box_shadow_rgba',
			'advanced_search_mp_input_box_shadow_position_group',
			'advanced_search_mp_input_box_shadow_position_group',
			'advanced_search_mp_background_image_position_x',
			'advanced_search_mp_background_image_position_y',
			'advanced_search_mp_background_pattern_image_url',
			'advanced_search_mp_background_pattern_image_position_x',
			'advanced_search_mp_background_pattern_image_position_y',
			'advanced_search_mp_background_pattern_image_opacity',
			'advanced_search_mp_background_gradient_degree',
			'advanced_search_mp_background_gradient_opacity',
			'advanced_search_mp_description_below_title',
			'advanced_search_mp_description_below_input',
			'advanced_search_mp_background_gradient_toggle',
			'advanced_search_mp_text_title_shadow_position_group',
			'advanced_search_mp_title_text_shadow_x_offset',
			'advanced_search_mp_title_text_shadow_y_offset',
			'advanced_search_mp_title_text_shadow_blur',
			'advanced_search_mp_description_below_title_text_shadow_x_offset',
			'advanced_search_mp_description_below_title_text_shadow_y_offset',
			'advanced_search_mp_description_below_title_text_shadow_blur',
			'advanced_search_mp_description_below_title_text_shadow_toggle',
			'advanced_search_mp_box_visibility', 
			'advanced_search_mp_input_box_radius',
			// ADVANCED SEARCH COLORS - ARTICLE PAGE
			'advanced_search_ap_title_text_shadow_toggle',
			'advanced_search_ap_title_font_color',
			'advanced_search_ap_title_font_shadow_color',
			'advanced_search_ap_description_below_title_font_shadow_color',
			'advanced_search_ap_link_font_color',
			'advanced_search_ap_background_color',
			'advanced_search_ap_text_input_background_color',
			'advanced_search_ap_text_input_border_color',
			'advanced_search_ap_btn_background_color',
			'advanced_search_ap_btn_border_color',
			'advanced_search_ap_background_gradient_from_color',
			'advanced_search_ap_background_gradient_to_color',
			'advanced_search_ap_filter_box_font_color',
			'advanced_search_ap_filter_box_background_color',
			'advanced_search_ap_search_result_category_color',
			'advanced_search_ap_background_gradient_toggle',
			'advanced_search_ap_background_image_url',
			'advanced_search_ap_input_box_radius',
			'advanced_search_ap_text_title_shadow_position_group',
			'advanced_search_ap_title_text_shadow_x_offset',
			'advanced_search_ap_title_text_shadow_y_offset',
			'advanced_search_ap_title_text_shadow_blur',
			'advanced_search_ap_input_box_shadow_x_offset',
			'advanced_search_ap_input_box_shadow_y_offset',
			'advanced_search_ap_input_box_shadow_blur',
			'advanced_search_ap_input_box_shadow_spread',
			'advanced_search_ap_input_box_shadow_rgba',
			'advanced_search_ap_input_box_shadow_position_group',
			'advanced_search_ap_background_image_position_x',
			'advanced_search_ap_background_image_position_y',
			'advanced_search_ap_background_pattern_image_url',
			'advanced_search_ap_background_pattern_image_position_x',
			'advanced_search_ap_background_pattern_image_position_y',
			'advanced_search_ap_background_pattern_image_opacity',
			'advanced_search_ap_background_gradient_degree',
			'advanced_search_ap_background_gradient_opacity',
			'advanced_search_ap_description_below_title_text_shadow_x_offset',
			'advanced_search_ap_description_below_title_text_shadow_y_offset',
			'advanced_search_ap_description_below_title_text_shadow_blur',
			'advanced_search_ap_description_below_title_text_shadow_toggle',
			'advanced_search_ap_filter_indicator_text',
			'advanced_search_ap_box_visibility',
			'advanced_search_ap_description_below_title',
			'advanced_search_ap_description_below_input',
		) );
		
		return array_unique($fields);
	}
}