<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Wizard {

	public static function register_all_wizard_hooks() {

		// global hooks
		add_filter( ELAY_KB_Core::ELAY_ALL_WIZARDS_CONFIGURATION_DEFAULTS, array('ELAY_KB_Wizard', 'get_configuration_defaults') );
		add_filter( ELAY_KB_Core::ELAY_ALL_WIZARDS_GET_CURRENT_CONFIG, array('ELAY_KB_Wizard', 'get_current_config' ), 10, 2 );

		// THEME WIZARD hooks
		add_filter( ELAY_KB_Core::ELAY_THEME_WIZARD_GET_THEMES, array('ELAY_KB_Wizard', 'get_theme_config'), 20 );
		add_action( ELAY_KB_Core::ELAY_THEME_WIZARD_MAIN_PAGE_COLORS, array('ELAY_KB_Wizard', 'get_main_page_colors' ) );
		add_action( ELAY_KB_Core::ELAY_THEME_WIZARD_ARTICLE_PAGE_COLORS, array('ELAY_KB_Wizard', 'get_article_page_colors' ) );
		add_filter( ELAY_KB_Core::ELAY_THEME_WIZARD_GET_COLOR_PRESETS, array('ELAY_KB_Wizard', 'get_color_presets' ), 10, 2 );

		// TEXT WIZARD hooks
		ELAY_KB_Wizard_Text::register_text_wizard_hooks();

		// FEATURES WIZARD hooks
		ELAY_KB_Wizard_Features::register_features_wizard_hooks();
		
		// SEARCH WIZARD hooks
		ELAY_KB_Wizard_Search::register_search_wizard_hooks();
	}

	/**
	 * Returnt to Wizard the current KB configuration
	 *
	 * @param $kb_config
	 * @param $kb_id
	 * @return array
	 */
	public static function get_current_config( $kb_config, $kb_id ) {
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return array_merge( $kb_config, $elay_config );
	}

	/**
	 * Return add-on configuration defaults.
	 *
	 * @param $template_defaults
	 * @return array
	 */
	public static function get_configuration_defaults( $template_defaults ) {

		$kb_elay_defaults = ELAY_KB_Config_Specs::get_default_kb_config();

		$elay_template_defaults = array (
		);

		return array_merge($template_defaults, $kb_elay_defaults, $elay_template_defaults);
	}

	/**
	 * Return ELAY Wizard themes and add additional parameters
	 *
	 * @param $all_themes
	 * @return array
	 */
	public static function get_theme_config( $all_themes ) {

		$new_all_themes = array();
		$elay_themes = self::$themes;

		$all_themes = is_array($all_themes) ? $all_themes : array();
		foreach ( $all_themes as $theme_id => $theme ) {
			if ( isset( $elay_themes[$theme_id] ) ) {
				$new_all_themes[$theme_id] = array_merge( $theme, $elay_themes[$theme_id] );
				unset( $elay_themes[$theme_id] );
			} else {
				$new_all_themes[$theme_id] = $theme;
			}
		}

		// add ELAY specific themes (full config)
		foreach ( $elay_themes as $theme_id => $theme ) {
			$new_all_themes[$theme_id] = $theme;
		}

		return $new_all_themes;
	}

	/**
	 * Add color pickers to Wizard Main Page
	 * @param $kb_id
	 */
	public static function get_main_page_colors ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		// GRID layout 
			
		// change input names
		$elay_specs['grid_section_head_font_color']['label'] = __( 'Category Name', 'echo-elegant-layouts' );
		$elay_specs['grid_section_body_text_color']['label'] = __( 'Article Counter', 'echo-elegant-layouts' );
		$elay_specs['grid_section_border_color']['label'] = __( 'Panel Border', 'echo-elegant-layouts' );
		$elay_specs['grid_section_head_background_color']['label'] = __( 'Panel Top Background', 'echo-elegant-layouts' );
		$elay_specs['grid_section_body_background_color']['label'] = __( 'Panel Bottom Background', 'echo-elegant-layouts' );
		
		// GRID SEARCH BOX
		$grid_arg1_input_text_field = $elay_specs['grid_search_text_input_background_color'] + array( 
			'value' => $elay_config['grid_search_text_input_background_color'], 
			'current' => $elay_config['grid_search_text_input_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box input[type=text]',
				'style_name' => 'background'
			)
		);
			
		$grid_arg2_input_text_field = $elay_specs['grid_search_text_input_border_color']     + array( 
			'value' => $elay_config['grid_search_text_input_border_color'], 
			'current' => $elay_config['grid_search_text_input_border_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box input[type=text]',
				'style_name' => 'border-color'
			)
		);

		$grid_arg1_button = $elay_specs['grid_search_btn_background_color']  + array( 
			'value' => $elay_config['grid_search_btn_background_color'],
			'current' => $elay_config['grid_search_btn_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box button',
				'style_name' => 'background'
			)
		);
			
		$grid_arg2_button = $elay_specs['grid_search_btn_border_color'] + array( 
			'value' => $elay_config['grid_search_btn_border_color'],
			'current' => $elay_config['grid_search_btn_border_color'],
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box button',
				'style_name' => 'border-color'
			)
		);

		// GRID SEARCH BOX COLORS
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __('Grid Search Box', 'echo-elegant-layouts'),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'depends'        => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid'
				),
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
				)
			),
			'inputs'            => array (
				'0' => $form->text( $elay_specs['grid_search_title_font_color'] + array(
						'value'             => $elay_config['grid_search_title_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-doc-search-container>h2',
							'style_name' => 'color'
						)
					) ),
				'1' => $form->text( $elay_specs['grid_search_background_color'] + array(
						'value'             => $elay_config['grid_search_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-doc-search-container',
							'style_name' => 'background-color'
						)
					) ),
				'2' => $form->text_fields_horizontal( array(
					'id'                => 'input_text_field',
					'input_class'       => 'ekb-color-picker',
					'label'             => __( 'Input Text Field', 'echo-elegant-layouts' ),
					'input_group_class' => 'ep'.'kb-wizard-dual-color',
				), $grid_arg1_input_text_field, $grid_arg2_input_text_field ),
				'3' => $form->text_fields_horizontal( array(
					'id'                => 'button',
					'input_class'       => 'ekb-color-picker',
					'label'             => __( 'Search Button', 'echo-elegant-layouts' ),
					'input_group_class' => 'ep'.'kb-wizard-dual-color',
				), $grid_arg1_button, $grid_arg2_button ),
			)
		));

		// GRID COLORS
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Grid Colors', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body elay-grid',
			'depends'          => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid'
				)
			),
			'inputs'            => array(
				'1' => $form->text( $elay_specs['grid_section_head_icon_color'] + array(
						'value'             => $elay_config['grid_section_head_icon_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template  .elay-icon-elem',
							'style_name' => 'color'
						)
					) ),
				'2' => $form->text( $elay_specs['grid_section_head_font_color'] + array(
						'value'             => $elay_config['grid_section_head_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-grid-category-name',
							'style_name' => 'color'
						)
					) ),
				'3' => $form->text( $elay_specs['grid_section_head_description_font_color'] + array(
						'value'             => $elay_config['grid_section_head_description_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-category-desc',
							'style_name' => 'color'
						)
					) ),
				'4' => $form->text( $elay_specs['grid_section_divider_color'] + array(
						'value'             => $elay_config['grid_section_divider_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .section-head',
							'style_name' => 'border-bottom-color'
						)
					) ),
				'5' => $form->text( $elay_specs['grid_section_body_text_color'] + array(
						'value'             => $elay_config['grid_section_body_text_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-top-category-box',
							'style_name' => 'color'
						)
					) ),
				'6' => $form->text( $elay_specs['grid_section_border_color'] + array(
						'value'             => $elay_config['grid_section_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-top-category-box',
							'style_name' => 'border-color'
						)
					) ),
				'7' => $form->text( $elay_specs['grid_section_head_background_color'] + array(
						'value'             => $elay_config['grid_section_head_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .section-head',
							'style_name' => 'background-color'
						)
					) ),
				'8' => $form->text( $elay_specs['grid_section_body_background_color'] + array(
						'value'             => $elay_config['grid_section_body_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-top-category-box',
							'style_name' => 'background-color'
						)
					) ),
				'9' => $form->text( $elay_specs['grid_background_color'] + array(
						'value'             => $elay_config['grid_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template #elay-content-container',
							'style_name' => 'background-color'
						)
					) ),
			)
		));
		
	}

	/**
	 * Add color pickers to Wizard Article Page
	 * @param $kb_id
	 */
	public static function get_article_page_colors ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// SIDEBAR layout

		// rename default labels because we have no info button
		$elay_specs['sidebar_background_color']['label'] = __( 'Sidebar Background', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_head_font_color']['label'] = __( 'Category Text', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_head_background_color']['label'] = __( 'Category Background', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_category_icon_color']['label'] = __( 'Subcategory Icon', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_category_font_color']['label'] = __( 'Subcategory Title', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_icon_color']['label'] = __( 'Article Icon', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_font_color']['label'] = __( 'Article', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_active_font_color']['label'] = __( 'Active Article', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_active_background_color']['label'] = __( 'Active Article background', 'echo-elegant-layouts' );

		// SIDEBAR COLORS
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Sidebar Colors', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body elay-sidebar',
			'depends'          => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Categories',
				)
			),
			'inputs'            => array(
				'0' => $form->text( $elay_specs['sidebar_background_color'] + array(
						'value'             => $elay_config['sidebar_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-4 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-3 #elay-sidebar-container-v2, .eckb-wizard-step-4 #elay-sidebar-container-v2',
							'style_name' => 'background-color'
						)
					) ),
				'1' => $form->text( $elay_specs['sidebar_section_head_font_color'] + array(
						'value'             => $elay_config['sidebar_section_head_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-category-level-1, 
							.eckb-wizard-step-4 .elay-sidebar-template .elay-category-level-1,
							.eckb-wizard-step-3 .elay-sidebar-template .elay-category-level-1 a, 
							.eckb-wizard-step-4 .elay-sidebar-template .elay-category-level-1 a, 
							.eckb-wizard-step-3  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name, 
							.eckb-wizard-step-3  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name>a,
							.eckb-wizard-step-4  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name, 
							.eckb-wizard-step-4  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name>a',
							'style_name' => 'color'
						)
					) ),
				'2' => $form->text( $elay_specs['sidebar_section_head_background_color'] + array(
						'value'             => $elay_config['sidebar_section_head_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay_section_heading,
							.eckb-wizard-step-4 .elay-sidebar-template .elay_section_heading, 
							.eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container,
							.eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
							'style_name' => 'background-color'
						)
					) ),
				'3' => $form->text( $elay_specs['sidebar_section_head_description_font_color'] + array(
						'value'             => $elay_config['sidebar_section_head_description_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay_section_heading p, .eckb-wizard-step-4 .elay-sidebar-template .elay_section_heading p, .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__desc p, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__desc p',
							'style_name' => 'color',
							'example_image' => '[elay]themes-wizard/wizard-screenshot-sidebar-section-head-description-font-color.jpg'
						)
					) ),
				'4' => $form->text( $elay_specs['sidebar_section_category_icon_color'] + array(
						'value'             => $elay_config['sidebar_section_category_icon_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 i, .eckb-wizard-step-4 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 i, .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay_sidebar_expand_category_icon, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay_sidebar_expand_category_icon',
							'style_name' => 'color'
						)
					) ),
				'5' => $form->text( $elay_specs['sidebar_section_category_font_color'] + array(
						'value'             => $elay_config['sidebar_section_category_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 a, .eckb-wizard-step-4 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 a, .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-category-level-2-3 a, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-category-level-2-3 a',
							'style_name' => 'color'
						)
					) ),
				'6' => $form->text( $elay_specs['sidebar_section_divider_color'] + array(
						'value'             => $elay_config['sidebar_section_divider_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay_section_heading, .eckb-wizard-step-4 .elay-sidebar-template .elay_section_heading, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container,  .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
							'style_name' => 'border-bottom-color'
						)
					) ),
				'7' => $form->text( $elay_specs['sidebar_article_icon_color'] + array(
						'value'             => $elay_config['sidebar_article_icon_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-article-title i, .eckb-wizard-step-4 .elay-article-title i',
							'style_name' => 'color'
						)
					) ),
				'8' => $form->text( $elay_specs['sidebar_article_font_color'] + array(
						'value'             => $elay_config['sidebar_article_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-article-title, .eckb-wizard-step-4 .elay-article-title',
							'style_name' => 'color'
						)
					) ),
				'9' => $form->text( $elay_specs['sidebar_article_active_font_color'] + array(
						'value'             => $elay_config['sidebar_article_active_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template #elay-content-container .elay-articles .active span, body .eckb-wizard-step-4 .elay-sidebar-template #elay-content-container .elay-articles .active span',
							'style_name' => 'color',
							'example_image' => '[elay]themes-wizard/wizard-screenshot-sidebar-article-active-font-color.jpg'
						)
					) ),
				'10' => $form->text( $elay_specs['sidebar_article_active_background_color'] + array(
						'value'             => $elay_config['sidebar_article_active_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template #elay-content-container .elay-articles .active, .eckb-wizard-step-4 .elay-sidebar-template #elay-content-container .elay-articles .active',
							'style_name' => 'background-color',
							'example_image' => '[elay]themes-wizard/wizard-screenshot-sidebar-article-active-background-color.jpg'
						)
					) ),
				'11' => $form->text( $elay_specs['sidebar_section_border_color'] + array(
						'value'             => $elay_config['sidebar_section_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-4 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-3 #elay-sidebar-container-v2, .eckb-wizard-step-4 #elay-sidebar-container-v2',
							'style_name' => 'border-color'
						)
					) ),
			)
		));
		
		
		// SIDEBAR layout 
		// SIDEBAR SEARCH BOX
		$sidebar_arg1_input_text_field = $elay_specs['sidebar_search_text_input_background_color'] + array( 
			'value' => $elay_config['sidebar_search_text_input_background_color'], 
			'current' => $elay_config['sidebar_search_text_input_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-3 #eckb-article-page-container-v2 #elay_search_terms, .eckb-wizard-step-4 #eckb-article-page-container-v2 #elay_search_terms',
				'style_name' => 'background'
			)
		);
			
		$sidebar_arg2_input_text_field = $elay_specs['sidebar_search_text_input_border_color']     + array( 
			'value' => $elay_config['sidebar_search_text_input_border_color'], 
			'current' => $elay_config['sidebar_search_text_input_border_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-3 #eckb-article-page-container-v2 #elay_search_terms, .eckb-wizard-step-4 #eckb-article-page-container-v2 #elay_search_terms',
				'style_name' => 'border-color'
			)
		);

		$sidebar_arg1_button = $elay_specs['sidebar_search_btn_background_color']  + array( 
			'value' => $elay_config['sidebar_search_btn_background_color'],
			'current' => $elay_config['sidebar_search_btn_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-3 #eckb-article-page-container-v2 #sidebar-elay-search-kb, .eckb-wizard-step-4 #eckb-article-page-container-v2 #sidebar-elay-search-kb',
				'style_name' => 'background'
			)
		);
			
		$sidebar_arg2_button = $elay_specs['sidebar_search_btn_border_color'] + array( 
			'value' => $elay_config['sidebar_search_btn_border_color'],
			'current' => $elay_config['sidebar_search_btn_border_color'],
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-3 #eckb-article-page-container-v2 #sidebar-elay-search-kb, .eckb-wizard-step-4 #eckb-article-page-container-v2 #sidebar-elay-search-kb',
				'style_name' => 'border-color'
			)
		);


		// SIDEBAR SEARCH BOX
		$kb_config = ELAY_KB_Core::get_kb_config_or_default( $kb_id );
		if ( ( ELAY_KB_Core::is_article_structure_v2( $kb_config ) && $kb_config['kb_main_page_layout'] != 'Categories' ) ||
		     ( ! ELAY_KB_Core::is_article_structure_v2( $kb_config ) && $kb_config['kb_article_page_layout'] == 'Sidebar' )) {

			$form->option_group_wizard( $elay_specs, array(
				'option-heading' => __( 'Search Box', 'echo-elegant-layouts' ),
				'class'          => 'eckb-wizard-colors eckb-wizard-accordion__body',
				'depends'        => array(
					'hide_when' => array(
						'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
						// 'kb_article_page_layout' => 'Article'  show all the time since V2 makes it more complex to filter
					),
				),
				'inputs'         => array(
					'0' => $form->text( $elay_specs['sidebar_search_title_font_color'] + array(
							'value'             => $elay_config['sidebar_search_title_font_color'],
							'input_class'       => 'ekb-color-picker',
							'input_group_class' => 'eckb-wizard-single-color',
							'data'              => array(
								'wizard_input'    => '1',
								'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-doc-search-container>h2, .eckb-wizard-step-4 .elay-sidebar-template .elay-doc-search-container>h2, .eckb-wizard-step-3 #eckb-article-page-container-v2 .elay-doc-search-title, .eckb-wizard-step-4 #eckb-article-page-container-v2 .elay-doc-search-title',
								'style_name'      => 'color'
							)
						) ),
					'1' => $form->text( $elay_specs['sidebar_search_background_color'] + array(
							'value'             => $elay_config['sidebar_search_background_color'],
							'input_class'       => 'ekb-color-picker',
							'input_group_class' => 'eckb-wizard-single-color',
							'data'              => array(
								'wizard_input'    => '1',
								'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-doc-search-container, .eckb-wizard-step-4 .elay-sidebar-template .elay-doc-search-container, .eckb-wizard-step-3 #eckb-article-page-container-v2 .elay-doc-search-container, .eckb-wizard-step-4 #eckb-article-page-container-v2 .elay-doc-search-container',
								'style_name'      => 'background-color'
							)
						) ),
					'2' => $form->text_fields_horizontal( array(
						'id'                => 'input_text_field',
						'input_class'       => 'ekb-color-picker',
						'label'             => __( 'Input Text Field', 'echo-elegant-layouts' ),
						'input_group_class' => 'ep' . 'kb-wizard-dual-color',
					), $sidebar_arg1_input_text_field, $sidebar_arg2_input_text_field ),
					'3' => $form->text_fields_horizontal( array(
						'id'                => 'button',
						'input_class'       => 'ekb-color-picker',
						'label'             => __( 'Search Button', 'echo-elegant-layouts' ),
						'input_group_class' => 'ep' . 'kb-wizard-dual-color',
					), $sidebar_arg1_button, $sidebar_arg2_button ),
				)
			) );

		}
		
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
			'grid_background_color'                     => '#FFFFFF',
			'grid_search_title_font_color'              => '#FFFFFF',
			'grid_search_background_color'              => '#827a74',
			'grid_search_text_input_background_color'   => '#FFFFFF',
			'grid_search_text_input_border_color'       => '#FFFFFF',
			'grid_search_btn_background_color'          => '#686868',
			'grid_search_btn_border_color'              => '#F1F1F1',
			'grid_section_head_font_color'              => '#000000',
			'grid_section_head_background_color'        => '#FFFFFF',
			'grid_section_head_description_font_color'  => '#B3B3B3',
			'grid_section_body_background_color'        => '#FFFFFF',
			'grid_section_border_color'                 => '#E1E0E0',
			'grid_section_divider_color'                => '#E1E0E0',
			'grid_section_head_icon_color'              => '#FFFFFF',
			'grid_section_body_text_color'              => '#000000',
			'sidebar_background_color'                  => '#fdfdfd',
			'sidebar_search_title_font_color'           => '#000000',
			'sidebar_search_background_color'           => '#e0e0e0',
			'sidebar_search_text_input_background_color'=> '#FFFFFF',
			'sidebar_search_text_input_border_color'    => '#FFFFFF',
			'sidebar_search_btn_background_color'       => '#686868',
			'sidebar_search_btn_border_color'           => '#F1F1F1',
			'sidebar_article_font_color'                => '#333232',
			'sidebar_article_icon_color'                => '#333232',
			'sidebar_article_active_font_color'         => '#000000',
			'sidebar_article_active_background_color'   => '#e8e8e8',
			'sidebar_section_head_font_color'           => '#000000',
			'sidebar_section_head_background_color'     => '#7d7d7d',
			'sidebar_section_head_description_font_color' => '#b3b3b3',
			'sidebar_section_border_color'              => '#7d7d7d',
			'sidebar_section_divider_color'             => '#FFFFFF',
			'sidebar_section_category_font_color'       => '#000000',
			'sidebar_section_category_icon_color'       => '#868686'
		);

		switch ( $preset_id ) {
			case 1:
				$preset_config = array(
					'grid_section_head_font_color'              => '#3a3a3a',
					'grid_section_body_text_color'              => '#3a3a3a',

					'grid_section_head_background_color'        => '#eded00',
					'grid_section_head_description_font_color'  => '#515151',
					'grid_section_head_icon_color'              => '#efc300',
					'grid_section_divider_color'                => '#515151',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#eeee22',

					'sidebar_section_head_font_color'           => '#3a3a3a',
					'sidebar_section_head_background_color'     => '#eded00',
					'sidebar_section_head_description_font_color' => '#515151',
					'sidebar_section_divider_color'             => '#515151',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#efc300',
					'sidebar_section_border_color'              => '#eeee22',

					'sidebar_article_font_color'                => '#3a3a3a',
					'sidebar_article_icon_color'                => '#becc00',
				);
				break;
			// BLUE
			case 3:
				$preset_config = array(
					'grid_section_head_font_color'              => '#53ccfb',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#53ccfb',
					'sidebar_section_head_background_color'     => '#FFFFFF',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#dbdbdb'
				);
				break;
			case 4:
				$preset_config = array(
					'grid_section_head_font_color'              => '#333333',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#515151',
					'grid_section_head_icon_color'              => '#039be5',
					'grid_section_divider_color'                => '#039be5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#039be5',

					'sidebar_section_head_font_color'           => '#333333',
					'sidebar_section_head_background_color'     => '#039be5',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#039be5',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#039be5',
					'sidebar_section_border_color'              => '#039be5',

					'sidebar_article_font_color'                => '#333333',
					'sidebar_article_icon_color'                => '#039be5',
				);
				break;
			case 5:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#4398ba',
					'grid_section_head_description_font_color'  => '#FFFFFF',
					'grid_section_head_icon_color'              => '#000000',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#f9f9f9',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#4398ba',
					'sidebar_section_head_description_font_color' => '#FFFFFF',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#000000',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			// GREEN
			case 6:
				$preset_config = array(
					'grid_section_head_font_color'              => '#4a714e',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#bfdac1',
					'grid_section_head_icon_color'              => '#a7d686',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_article_font_color'                => '#333333',
					'sidebar_article_icon_color'                => '#81d742',

					'sidebar_section_head_font_color'           => '#4a714e',
					'sidebar_section_head_background_color'     => '#b6d6a9',
					'sidebar_section_head_description_font_color' => '#bfdac1',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#b1d8b4',
					'sidebar_section_category_icon_color'       => '#a7d686',
					'sidebar_section_border_color'              => '#dbdbdb'
				);
				break;
			case 7:
				$preset_config = array(
					'grid_section_head_font_color'              => '#81d742',

					'grid_section_head_background_color'        => '#fcfcfc',
					'grid_section_head_description_font_color'  => '#515151',
					'grid_section_head_icon_color'              => '#333333',
					'grid_section_divider_color'                => '#81d742',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dddddd',

					'sidebar_section_head_font_color'           => '#81d742',
					'sidebar_section_head_background_color'     => '#fcfcfc',
					'sidebar_section_head_description_font_color' => '#515151',
					'sidebar_section_divider_color'             => '#81d742',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#333333',
					'sidebar_section_border_color'              => '#dddddd'
				);
				break;
			case 8:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#628365',
					'grid_section_head_description_font_color'  => '#FFFFFF',
					'grid_section_head_icon_color'              => '#FFFFFF',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#edf4ee',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#628365',
					'sidebar_section_head_description_font_color' => '#FFFFFF',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#FFFFFF',
					'sidebar_section_border_color'              => '#dbdbdb',
				);
				break;
			// RED
			case 9:
				$preset_config = array(
					'grid_section_head_font_color'              => '#fb8787',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#fb8787',
					'sidebar_section_head_background_color'     => '#FFFFFF',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#dbdbdb',
				);
				break;
			case 10:
				$preset_config = array(
					'grid_section_head_font_color'              => '#CC0000',

					'grid_section_head_background_color'        => '#f9e5e5',
					'grid_section_head_description_font_color'  => '#e57f7f',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#CC0000',
					'sidebar_section_head_background_color'     => '#f9e5e5',
					'sidebar_section_head_description_font_color' => '#e57f7f',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			case 11:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#fb6262',
					'grid_section_head_description_font_color'  => '#FFFFFF',
					'grid_section_head_icon_color'              => '#FFFFFF',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#fefcfc',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#fb6262',
					'sidebar_section_head_description_font_color' => '#FFFFFF',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#FFFFFF',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			// GRAY
			case 12:
				$preset_config = array(
					'grid_section_head_font_color'              => '#827a74',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#dadada',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#827a74',
					'sidebar_section_head_background_color'     => '#FFFFFF',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#dadada',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#dbdbdb',
				);
				break;
			case 13:
				$preset_config = array(
					'grid_section_head_font_color'              => '#525252',

					'grid_section_head_background_color'        => '#f1f1f1',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#000000',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#fdfdfd',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#525252',
					'sidebar_section_head_background_color'     => '#f1f1f1',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#000000',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			case 14:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#7d7d7d',
					'grid_section_head_description_font_color'  => '#bfbfbf',
					'grid_section_head_icon_color'              => '#FFFFFF',
					'grid_section_divider_color'                => '#dddddd',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dddddd',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#7d7d7d',
					'sidebar_section_head_description_font_color' => '#bfbfbf',
					'sidebar_section_divider_color'             => '#dddddd',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#FFFFFF',
					'sidebar_section_border_color'              => '#dddddd',
				);
				break;
			default:
				$preset_config = array();
		}

		// color presets
		$preset_config['grid_search_title_font_color'] = $presets['search_title_font_color'];
		$preset_config['grid_search_background_color'] = $presets['search_background_color'];
		$preset_config['grid_search_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['grid_search_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['grid_search_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['grid_search_btn_border_color'] = $presets['search_btn_border_color'];
		$preset_config['sidebar_search_title_font_color'] = $presets['search_title_font_color'];
		
		$preset_config['sidebar_search_background_color'] = $presets['search_background_color'];
		$preset_config['sidebar_search_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['sidebar_search_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['sidebar_search_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['sidebar_search_btn_border_color'] = $presets['search_btn_border_color'];

		$preset_config = array_merge($preset_config_default, $preset_config);

		return array_merge($presets, $preset_config);
	}
	
	// custom themes or custom parameters to existing themes (you can use id from core theme and add only 1-2 strings of the paramenters)
	public static $themes = array(
		
		// Basic 
		'theme_standard' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#f7941d',
			'sidebar_search_text_input_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
			'sidebar_search_btn_background_color' => '#40474f',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'			    => '50',
			'sidebar_section_head_background_color'         => '#f7941d',
			'sidebar_article_active_background_color'       => '#ffc278',
			'sidebar_article_active_font_color'             => '#000000',
			'sidebar_article_font_color'                    => '#459fed',
			'sidebar_article_icon_color'                    => '#b3b3b3',
		),
		
		'theme_spacious' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#000000',
			'sidebar_search_background_color' => '#ffffff',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
			'sidebar_search_btn_background_color' => '#1168bf',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'			        => '50',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#1e73be', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#000000', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#1168bf', // From Core - article_icon_color
		),
		
		'theme_informative' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#904e95',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
			'sidebar_search_btn_background_color' => '#686868',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'                => '50',
			'sidebar_search_title_font_size'			    => 40,

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#868686', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#606060', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#904e95', // From Core - article_icon_color
		),
		
		'theme_image' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#B1D5E1',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
			'sidebar_search_btn_background_color' => '#686868',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'                => '50',
			'search_box_search_title'			            => 'How Can We Help?',
			'search_box_search_title_font_size'			    => 40,

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#868686', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#606060', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#904e95', // From Core - article_icon_color
		),
		
		'theme_modern' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#40474f',
			'sidebar_search_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#40474f',
			'sidebar_search_btn_background_color' => '#40474f',
			'sidebar_search_btn_border_color' => '#40474f',
			'sidebar_search_input_border_width'             => 3,
			'sidebar_search_box_input_width'                => '50',
			'sidebar_search_title'			                => 'Have a Question?',
			'sidebar_search_title_font_size'			    => 40,

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#ffffff', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#606060', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#81d742', // From Core - article_icon_color
		),
		
		'theme_bright' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#f4c60c',
			'sidebar_search_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#f4c60c',
			'sidebar_search_btn_background_color' => '#f4c60c',
			'sidebar_search_btn_border_color' => '#f4c60c',
			'sidebar_search_input_border_width'             => 3,
			'sidebar_search_box_input_width'                => '50',
			'sidebar_search_title'			                => 'What are you looking for?',
			'sidebar_search_title_font_size'			    => 40,

			'sidebar_background_color'                      => '#ffffff', // Adjust Manually
			'sidebar_section_head_font_color'               => '#0b6ea0', // Adjust Manually
			'sidebar_section_head_background_color'         => '#fcfcfc', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#cccccc', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#0bcad9', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#1e1e1e', // From Core - article_icon_color
		),
		
		'theme_formal' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#000000',
			'sidebar_search_background_color' => '#edf2f6',
			'sidebar_search_text_input_border_color' => '#d1d1d1',
			'sidebar_search_btn_background_color' => '#666666',
			'sidebar_search_btn_border_color' => '#666666',
			'sidebar_search_box_input_width'                => '50',
			'sidebar_search_title'			                => 'Welcome to our Knowledge Base',
			'sidebar_search_title_font_size'			    => 40,
			'sidebar_search_input_border_width'             => 1,
			'sidebar_search_box_padding_top'			    => '50',
			'sidebar_search_box_padding_bottom'			    => '50',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#e3474b', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#616161', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#000000', // From Core - article_icon_color
		),
		
		'theme_disctinct' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#528ffe',
			'sidebar_search_background_color' => '#f4f8ff',
			'sidebar_search_text_input_border_color' => '#bf25ff',
			'sidebar_search_btn_background_color' => '#bf25ff',
			'sidebar_search_btn_border_color' => '#bf25ff',
			'sidebar_search_box_input_width'                => '50',
			'sidebar_search_title'			                => 'Self Help Documentation',
			'sidebar_search_title_font_size'			    => 40,
			'sidebar_search_input_border_width'             => 1,
			'sidebar_search_box_padding_top'                => 30,
			'sidebar_search_box_padding_bottom'             => 30,

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#528ffe', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#566e8b', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#566e8b', // From Core - article_icon_color
		),
		
		'theme_faqs' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#37de89',
			'sidebar_search_text_input_border_color' => '#37de89',
			'sidebar_search_btn_background_color' => '#666666',
			'sidebar_search_btn_border_color' => '#666666',
			'sidebar_search_layout'                         => 'elay-search-form-0',
			'sidebar_search_box_input_width'                => '50',
			'sidebar_search_title'			                => 'Support Center',
			'sidebar_search_title_font_size'			    => 40,
			'sidebar_search_input_border_width'             => 1,
			'sidebar_search_box_padding_top'                => 30,
			'sidebar_search_box_padding_bottom'             => 30,

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#528ffe', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#566e8b', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#566e8b', // From Core - article_icon_color
		),
		
		// TABS LAYOUT 
		'theme_organized' => array(
			'kb_article_page_layout'                        => 'Sidebar',
			'sidebar_search_background_color'               => '#8c1515',
			'sidebar_search_text_input_border_color'        => '#000000',
			'sidebar_search_btn_background_color'           => '#878787',
			'sidebar_search_btn_border_color'               => '#000000',
			'sidebar_search_box_input_width'			    => '50',
			'sidebar_search_title'			                => 'Have a Question?',
			'sidebar_search_title_font_color'               => '#FFFFFF',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#8c1515', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#8c1515', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#000000', // From Core - article_icon_color
		),
		
		'theme_organized_2' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#00b4b3',
			'sidebar_search_text_input_border_color' => '#00c6c6',
			'sidebar_search_btn_background_color' => '#686868',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'			        => '50',
			'sidebar_search_input_border_width'			    => '5',
			'sidebar_search_box_padding_top'			    => '50',
			'sidebar_search_box_padding_bottom'			    => '50',
			'sidebar_search_layout'			                => 'elay-search-form-3',
			'sidebar_search_title'			                => 'Help Center',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#00b4b3', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#000000', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#00b4b3', // From Core - article_icon_color
		),
		
		'theme_products_style' => array(
			'kb_article_page_layout'                        => 'Sidebar',
			'sidebar_search_background_color'               => '#6e6767',
			'sidebar_search_text_input_border_color'        => '#1e73be',
			'sidebar_search_btn_background_color'           => '#686868',
			'sidebar_search_btn_border_color'               => '#000000',
			'sidebar_search_box_input_width'			    => '50',
			'sidebar_section_box_height_mode'               => 'section_no_height',
			'sidebar_search_input_border_width'             => '5',
			'sidebar_search_layout'			                => 'elay-search-form-3',
			'sidebar_search_box_padding_top'			    => '50',
			'sidebar_search_box_padding_bottom'			    => '50',
			'sidebar_search_title'			                => 'Help Center',
			'sidebar_search_title_font_color'               => '#FFFFFF',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#6e6767', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#000000', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#000000', // From Core - article_icon_color     1e73be
			'sidebar_section_divider_color'                 => '#1e73be',
		),
		
		'theme_tabs_clean_style' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#000000',
			'sidebar_search_background_color' => '#f2f2f2',
			'sidebar_search_text_input_border_color' => '#000000',
			'sidebar_search_btn_background_color' => '#000000',
			'sidebar_search_btn_border_color' => '#000000',
			'sidebar_search_input_border_width'             => '1',
			'sidebar_search_layout'			                => 'elay-search-form-1',
			'sidebar_search_box_input_width'			                => '50',
			'sidebar_search_box_padding_top'			    => '50',
			'sidebar_search_box_padding_bottom'			    => '50',
			'sidebar_search_title'			                => 'Help Center',

			'sidebar_section_head_font_color'               => '#000000', // Adjust Manually
			'sidebar_section_head_background_color'         => '#ffffff', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#000000', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#adadad', // From Core - article_icon_color
		),
		
		'standard_2' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#2991a3',
			'sidebar_search_text_input_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
			'sidebar_search_btn_background_color' => '#40474f',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'			        => '50',
			'sidebar_search_box_padding_top'			        => '50',
			'sidebar_search_box_padding_bottom'			        => '50',
			'sidebar_search_title'			                    => 'Have a Question?',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#2991a3', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#666666', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#2991a3', // From Core - article_icon_color
		),
		
		'standard_3' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#FFFFFF',
			'sidebar_search_background_color' => '#fcfcfc',
			'sidebar_search_text_input_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#0bcad9',
			'sidebar_search_btn_background_color' => '#f4c60c',
			'sidebar_search_btn_border_color' => '#0bcad9',
			'sidebar_search_box_input_width'			        => '50',
			'sidebar_search_box_padding_top'			        => '50',
			'sidebar_search_box_padding_bottom'			        => '50',
			'sidebar_search_title'			                    => 'Have a Question?',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#2991a3', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#0bcad9', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#2991a3', // From Core - article_icon_color
		),
		
		'business' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#000000',
			'sidebar_search_background_color' => '#fbfbfb',
			'sidebar_search_text_input_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
			'sidebar_search_btn_background_color' => '#40474f',
			'sidebar_search_btn_border_color' => '#F1F1F1',
			'sidebar_search_box_input_width'			    => '50',
			'sidebar_search_box_padding_top'			    => '50',
			'sidebar_search_box_padding_bottom'			    => '90',
			'sidebar_search_box_margin_bottom'			    => '0',
			'sidebar_search_title'			                    => 'Have a Question?',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#eb5a46', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#666666', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#e8a298', // From Core - article_icon_color
		),
		
		'business_2' => array(
			'kb_article_page_layout'                    => 'Sidebar',
			'sidebar_search_title_font_color' => '#6fb24c',
			'sidebar_search_background_color' => '#fbfbfb',
			'sidebar_search_text_input_background_color' => '#FFFFFF',
			'sidebar_search_text_input_border_color' => '#6fb24c',
			'sidebar_search_btn_background_color' => '#6fb24c',
			'sidebar_search_btn_border_color' => '#6fb24c',
			'sidebar_search_box_input_width'			    => '50',
			'sidebar_search_box_padding_top'			    => '50',
			'sidebar_search_box_padding_bottom'			    => '90',
			'sidebar_search_box_margin_bottom'			    => '0',
			'sidebar_search_title'			                => 'Have a Question?',

			'sidebar_section_head_font_color'               => '#ffffff', // Adjust Manually
			'sidebar_section_head_background_color'         => '#6fb24c', // From Core - section_category_icon_color
			'sidebar_article_active_background_color'       => '#5d91bf', // Should be lighter color than sidebar_section_head_background_color
			'sidebar_article_active_font_color'             => '#000000', // Keep Black for most themes
			'sidebar_article_font_color'                    => '#666666', // From Core - article_font_color
			'sidebar_article_icon_color'                    => '#6fb24c', // From Core - article_icon_color
		),
		
		// GRID
		'theme_grid_basic' => array(
			'kb_name'			                            => 'Basic',
			'theme_desc'			                        => 'Big icons for easy navigation',
			'kb_articles_common_path'			            => 'knowledge-base-50',
			'kb_main_page_layout'			                => 'Grid',
			'kb_article_page_layout'                        => 'Sidebar',
			'theme_category'                 			    => 'Grid Layout',
			'grid_section_head_icon_color'                  => '#1e73be',
			'grid_section_body_padding_top'                 => '15',
			'grid_search_box_input_width'                   => '50',

			'breadcrumb_text_color'			                => '#1e73be',
			'back_navigation_text_color'			        => '#1e73be',
			//'grid_search_layout'                            => 'elay-search-form-1',
			'grid_search_title_font_color'			        => '#000000',
			'grid_search_background_color'			        => '#ffffff',
			'grid_search_text_input_border_color'		    => '#CCCCCC',
			'grid_search_btn_background_color'			    => '#1168bf',
			'grid_search_btn_border_color'			        => '#F1F1F1',
			'sidebar_search_title_font_color'			    => '#000000',
			'sidebar_search_background_color'			    => '#ffffff',
			'sidebar_search_text_input_border_color'		=> '#CCCCCC',
			'sidebar_search_btn_background_color'			=> '#1168bf',
			'sidebar_search_btn_border_color'			    => '#F1F1F1',
			'article_font_color'			                => '#000000',
			'article_icon_color'			                => '#1168bf',
			'section_hyperlink_text_on'                     => 'on',
			'sidebar_section_head_font_color'     => '#1168bf',
			
			'sidebar_search_title'			                => 'Have a Question?',
			'grid_search_title'			                    => 'Have a Question?',
		),

		'theme_grid_demo_5' => array(
			'kb_name'			                        => 'Informative',
			'theme_desc'			                    => 'Categories with descriptions',
			'kb_articles_common_path'			        => 'knowledge-base-51',
			'kb_main_page_layout'			            => 'Grid',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Grid Layout',
			'grid_search_box_input_width'               => '50',
			'grid_width'                                => 'elay-full',
			'grid_search_box_padding_top'               => '40',
			'grid_section_head_padding_top'             => '10',
			'grid_section_head_padding_bottom'          => '10',
			'grid_section_head_padding_left'            => '10',
			'grid_section_head_padding_right' => '10',
			'grid_section_cat_name_padding_top' => '17',
			'grid_section_cat_name_padding_bottom' => '0',
			'grid_section_desc_padding_top' => '40',
			'grid_section_desc_padding_bottom' => '15',
			'grid_section_desc_text_on' => 'on',
			'grid_section_border_radius' => '0',
			'grid_section_border_width' => '0',
			'grid_section_box_shadow' => 'section_light_shadow',
			'grid_section_box_hover' => 'hover-4',
			'grid_article_list_spacing' => '7',
			'grid_section_icon_padding_top' => '10',
			'grid_section_icon_padding_bottom' => '0',
			'grid_section_icon_padding_left' => '10',
			'grid_search_title_font_color' => '#000000',
			'grid_search_background_color' => '#904e95',
			'grid_search_text_input_border_color' => '#CCCCCC',
			'grid_section_head_font_color' => '#904e95',
			'grid_section_border_color' => '#F7F7F7',
			'grid_section_divider_color' => '#ffffff',
			'grid_section_head_icon_color' => '#904e95',
			'grid_section_body_text_color' => '#b3b3b3',

			'sidebar_search_title_font_color' => '#000000',
			'sidebar_search_background_color' => '#904e95',
			'sidebar_search_text_input_border_color' => '#CCCCCC',
            'sidebar_search_btn_background_color'			=> '#904e95',
			'sidebar_search_title'			                => 'Support Center',
			'grid_search_title'                             => 'Support Center',

			'breadcrumb_text_color'			            => '#1e73be',
			'back_navigation_text_color'			    => '#1e73be',
			'grid_search_btn_background_color'			=> '#904e95',
			'grid_search_btn_border_color'			    => '#F1F1F1',
			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf',
			'section_hyperlink_text_on'               => 'on',
			'sidebar_section_head_font_color'     => '#904e95',
		),

		'theme_grid_demo_6' => array(
			'kb_name'			                        => 'Simple',
			'theme_desc'			                    => 'Minimal layout',
			'kb_articles_common_path'			        => 'knowledge-base-52',
			'kb_main_page_layout'			            => 'Grid',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Grid Layout',
			'grid_search_box_input_width'               => '50',
			'grid_width'                                => 'elay-full',
			'grid_category_icon'                        => 'ep_font_icon_pencil',
			'grid_section_cat_name_padding_bottom'      => '0',
			'grid_section_desc_padding_bottom'          => '10',
			'grid_section_box_hover'                    => 'hover-4',
			'grid_section_divider'                      => 'off',
			'grid_article_list_spacing'                 => '5',
			'grid_section_head_font_color'              => '#000000',
			'grid_section_head_description_font_color'  => '#000000',
			'grid_section_border_color'                 => '#f7941d',
			'grid_section_head_icon_color'              => '#f7941d',
			'grid_section_body_text_color'              => '#000000',
			'sidebar_top_categories_collapsed'          => 'off',
			'sidebar_expand_articles_icon'              => 'ep_font_icon_plus',
			'sidebar_section_divider' => 'off',
			'sidebar_article_active_bold' => 'off',
			'sidebar_main_page_intro_text'              => 'Welcome to our Knowledge Base.',
			'sidebar_section_head_background_color' => '#f4f4f4',
			'sidebar_section_head_font_color'     => '#f7941d',
			
			'breadcrumb_text_color'			            => '#1e73be',
			'back_navigation_text_color'			    => '#1e73be',
			'grid_search_title_font_color'			    => '#000000',
			'grid_search_background_color'			    => '#ffffff',
			'grid_search_text_input_border_color'		=> '#CCCCCC',
			'grid_search_btn_background_color'			=> '#f7941d',
			'grid_search_btn_border_color'			    => '#F1F1F1',

			'sidebar_search_title_font_color'			=> '#000000',
			'sidebar_search_background_color'			=> '#ffffff',
			'sidebar_search_text_input_border_color'	=> '#CCCCCC',
			'sidebar_search_btn_background_color'		=> '#f7941d',
			'sidebar_search_btn_border_color'			=> '#F1F1F1',

			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf',
			'section_hyperlink_text_on'                 => 'on'
		),

		'theme_grid_demo_7' => array(
			'kb_name'			                        => 'Left Icon Style',
			'theme_desc'			                    => 'Minimal layout with icon on the left.',
			'kb_articles_common_path'			        => 'knowledge-base-53',
			'kb_main_page_layout'			            => 'Grid',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Grid Layout',
			'grid_width'                                => 'elay-full',
			'grid_search_box_input_width'               => '50',

			// Head
			'grid_section_head_padding_bottom'          => '5',
			'grid_section_head_alignment'               => 'left',

			//Icon
			'grid_category_icon_location'               => 'left',// DEPRECATED: category icons
			'grid_category_icon'                        => 'ep_font_icon_pencil',
			'grid_section_icon_size'                    => '50',
			'grid_section_head_icon_color'              => '#56B6C6',
			'grid_section_icon_padding_top'             => '20',
			'grid_section_icon_padding_bottom'          => '20',
			'grid_section_icon_padding_left'            => '20',
			'grid_section_icon_padding_right'           => '0',


			// Title
			'grid_section_head_font_color'              => '#000000',
			'grid_section_cat_name_padding_top'         => '24',
			'grid_section_cat_name_padding_bottom'      => '5',
			'grid_section_cat_name_padding_left'        => '80',
			'grid_section_cat_name_padding_right'       => '0',

			// Description
			'grid_section_desc_text_on'                 => 'on',
			'grid_section_head_description_font_color'  => '#7E8082',
			'grid_section_desc_padding_top'             => '0',
			'grid_section_desc_padding_bottom'          => '0',
			'grid_section_desc_padding_left'            => '80',
			'grid_section_desc_padding_right'           => '0',

			// Section
			'grid_section_border_color'                 => '#CECED2',
			'grid_section_box_shadow'                   => 'section_light_shadow',
			'grid_section_border_radius'                => '0',

			// Body
			'grid_section_body_padding_top'             => '0',
			'grid_section_body_padding_bottom'          => '0',
			'grid_section_body_padding_left'            => '80',
			'grid_section_body_padding_right'           => '0',
			'grid_section_body_alignment'               => 'left',

			'grid_section_box_hover'                    => 'hover-4',
			'grid_section_divider'                      => 'off',
			'grid_article_list_spacing'                 => '5',
			'grid_section_body_text_color'              => '#000000',
			'sidebar_top_categories_collapsed'          => 'off',
			'sidebar_expand_articles_icon'              => 'ep_font_icon_plus',
			'sidebar_section_divider' => 'off',
			'sidebar_article_active_bold' => 'off',
			'sidebar_main_page_intro_text'        => 'Welcome to our Knowledge Base.',

			'breadcrumb_text_color'			            => '#56B6C6',
			'back_navigation_text_color'			    => '#56B6C6',
			'grid_search_title_font_color'			    => '#000000',
			'grid_search_background_color'			    => '#ffffff',
			'grid_search_text_input_border_color'		=> '#CCCCCC',
			'grid_search_btn_background_color'			=> '#56B6C6',
			'grid_search_btn_border_color'			    => '#F1F1F1',
			'sidebar_search_title_font_color'			=> '#000000',
			'sidebar_search_background_color'			=> '#ffffff',
			'sidebar_search_text_input_border_color'	=> '#CCCCCC',
			'sidebar_search_btn_background_color'		=> '#56B6C6',
			'sidebar_search_btn_border_color'			=> '#F1F1F1',
			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf',
			'section_hyperlink_text_on'                 => 'on',

			'sidebar_search_title'			                => 'Support Center',
			'grid_search_title'                             => 'Support Center',
			
			'sidebar_section_head_font_color'     => '#56B6C6',
		),

		// SIDEBAR

		'theme_sidebar_basic' => array(
			'kb_name'			                        => 'Basic',
			'theme_desc'			                    => 'Simple layout',
			'kb_articles_common_path'			        => 'knowledge-base-60',
			'kb_main_page_layout'			            => 'Sidebar',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Sidebar Layout',
			'sidebar_search_title'			            => 'Self Help Documentation',

			'breadcrumb_text_color'			            => '#1e73be',
			'back_navigation_text_color'			    => '#1e73be',
			'search_title_font_color'			        => '#000000',
			'search_background_color'			        => '#ffffff',
			'search_text_input_border_color'			=> '#CCCCCC',
			'search_btn_background_color'			    => '#1168bf',
			'search_btn_border_color'			        => '#F1F1F1',
			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf'
		),

		'theme_sidebar_colapsed' => array(
			'kb_name'			                        => 'Collapsed',
			'theme_desc'			                    => 'All categories are collapsed',
			'kb_articles_common_path'			        => 'knowledge-base-61',
			'kb_main_page_layout'			            => 'Sidebar',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Sidebar Layout',
			'sidebar_top_categories_collapsed'          => 'on',
			'sidebar_show_articles_before_categories'   => 'off',
			'sidebar_section_head_alignment'            => 'left',
			'sidebar_section_head_padding_right'        => '0',
			'sidebar_section_box_shadow'                => 'section_light_shadow',
			'sidebar_section_border_radius'             => '0',
			'sidebar_background_color'                  => '#FFFFFF',
			'sidebar_article_icon_color'                => '#904e95',
			'sidebar_article_active_font_color'         => '#000000',
			'sidebar_article_active_background_color'   => '#f5eaff',
			'sidebar_section_head_font_color'           => '#904e95',
			'sidebar_section_head_background_color'     => '#ffffff',
			'sidebar_section_head_description_font_color' => '#bfdac1',
			'sidebar_section_border_color'              => '#ffffff',
			'sidebar_section_divider_color'             => '#904e95',
			'sidebar_section_category_icon_color'       => '#904e95',
			'sidebar_article_font_color'				=> '#2ea3f2',
			'sidebar_section_category_font_color'		=> '#904e95',

			'breadcrumb_text_color'			            => '#904e95',
			'back_navigation_text_color'			    => '#904e95',
			'search_title_font_color'			        => '#000000',
			'search_background_color'			        => '#ffffff',
			'search_text_input_border_color'			=> '#CCCCCC',
			'search_btn_background_color'			    => '#1168bf',
			'search_btn_border_color'			        => '#F1F1F1',
			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf'
		),

		'theme_sidebar_formal' => array(
			'kb_name'			                        => 'Formal',
			'theme_desc'			                    => 'Structured look',
			'kb_articles_common_path'			        => 'knowledge-base-62',
			'kb_main_page_layout'			            => 'Sidebar',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Sidebar Layout',
			'sidebar_section_head_alignment'            => 'left',
			'sidebar_section_head_padding_right'        => '0',
			'sidebar_section_border_radius'             => '0',
			'sidebar_section_border_width'              => '0',
			'sidebar_section_box_shadow'                => 'no_shadow',
			'sidebar_section_divider'                   => 'off',
			'sidebar_section_body_padding_top'          => '0',
			'sidebar_section_body_padding_bottom'       => '0',
			'sidebar_article_list_margin'               => '20',
			'sidebar_background_color'                  => '#FFFFFF',
			'sidebar_article_font_color'                => '#00c1b6',
			'sidebar_article_icon_color'                => '#136eb5',
			'sidebar_article_active_background_color'   => '#f8f8f8',
			'sidebar_section_head_font_color'           => '#136eb5',
			'sidebar_section_head_background_color'     => '#ffffff',
			'sidebar_section_head_description_font_color' => '#bfdac1',
			'sidebar_section_border_color'              => '#dbdbdb',
			'sidebar_section_divider_color'             => '#00c1b6',
			'sidebar_search_title'			            => 'Support Center',

			'breadcrumb_text_color'			            => '#1e73be',
			'back_navigation_text_color'			    => '#1e73be',
			'search_title_font_color'			        => '#000000',
			'search_background_color'			        => '#ffffff',
			'search_text_input_border_color'			=> '#CCCCCC',
			'search_btn_background_color'			    => '#1168bf',
			'search_btn_border_color'			        => '#F1F1F1',
			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf'
		),

		'theme_sidebar_compact' => array(
			'kb_name'			                        => 'Compact',
			'theme_desc'			                    => 'Compact list of categories and articles',
			'kb_articles_common_path'			        => 'knowledge-base-63',
			'kb_main_page_layout'			            => 'Sidebar',
			'kb_article_page_layout'                    => 'Sidebar',
			'theme_category'                 			=> 'Sidebar Layout',
			'sidebar_side_bar_width'                    => '20',
			'sidebar_section_font_size'                 => 'section_small_font',
			'sidebar_show_articles_before_categories'   => 'off',
			'sidebar_section_head_alignment'            => 'left',
			'sidebar_section_head_padding_right'        => '0',
			'sidebar_section_border_radius'             => '0',
			'sidebar_section_border_width'              => '0',
			'sidebar_section_box_shadow'                => 'no_shadow',
			'sidebar_section_divider'                   => 'off',
			'sidebar_section_body_padding_top'          => '0',
			'sidebar_section_body_padding_bottom'       => '0',
			'sidebar_article_active_bold'               => 'off',
			'sidebar_article_list_spacing'              => '5',
			'sidebar_background_color'                  => '#fbfbfb',
			'sidebar_search_title_font_color'           => '#ffffff',
			'sidebar_search_background_color'           => '#827a74',
			'sidebar_search_text_input_border_color'    => '#F1F1F1',
			'sidebar_article_font_color'                => '#459fed',
			'sidebar_article_icon_color'                => '#f7941d',
			'sidebar_article_active_font_color'         => '#f7941d',
			'sidebar_article_active_background_color'   => '#fbfbfb',
			'sidebar_section_head_font_color'           => '#212121',
			'sidebar_section_head_background_color'     => '#ffffff',
			'sidebar_section_border_color'              => '#dbdbdb',
			'sidebar_section_divider_color'             => '#dadada',
			'sidebar_section_category_font_color'       => '#686868',
			'sidebar_section_category_icon_color'       => '#212121',

			'breadcrumb_text_color'			            => '#1e73be',
			'back_navigation_text_color'			    => '#1e73be',
			'search_title_font_color'			        => '#000000',
			'search_background_color'			        => '#ffffff',
			'search_text_input_border_color'			=> '#CCCCCC',
			'search_btn_background_color'			    => '#1168bf',
			'search_btn_border_color'			        => '#F1F1F1',
			'article_font_color'			            => '#000000',
			'article_icon_color'			            => '#1168bf'
		),

		'theme_sidebar_plain' => array(
			'kb_name'			                            => 'Plain',
			'theme_desc'			                        => 'Simple layout and clean sidebar',
			'kb_articles_common_path'			            => 'knowledge-base-64',
			'kb_main_page_layout'			                => 'Sidebar',
			'kb_article_page_layout'                        => 'Sidebar',
			'theme_category'                 			    => 'Sidebar Layout',
			'sidebar_search_title'			                => 'What are you looking for?',

			'breadcrumb_text_color'			                => '#136eb5',
			'back_navigation_text_color'			        => '#00c1b6',
			'search_title_font_color'			            => '#000000',
			'search_background_color'			            => '#ffffff',
			'search_text_input_border_color'			    => '#CCCCCC',
			'search_btn_background_color'			        => '#1168bf',
			'search_btn_border_color'			            => '#F1F1F1',
			'article_font_color'			                => '#000000',
			'article_icon_color'			                => '#1168bf',

			'sidebar_background_color'                      => '#ffffff',
			'sidebar_section_head_font_color'               => '#136eb5',
			'sidebar_section_head_background_color'         => '#ffffff',
			'sidebar_section_head_description_font_color'   => '#355666',
			'sidebar_section_category_icon_color'           => '#868686',
			'sidebar_section_category_font_color'           => '#868686',
			'sidebar_section_divider_color'                 => '#f0f0f0',
			'sidebar_article_icon_color'                    => '#136eb5',
			'sidebar_article_font_color'                    => '#2ea3f2',
			'sidebar_article_active_font_color'             => '#000000',
			'sidebar_article_active_background_color'       => '#f8f8f8',
			'sidebar_section_border_color'                  => '#f7f7f7',

			'sidebar_section_box_shadow'                    => 'no_shadow',
			'sidebar_section_border_width'                  => '0',
			'sidebar_section_border_radius'                 => '3'
		),
	);
	
}