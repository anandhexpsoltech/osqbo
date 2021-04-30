<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard feature data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Wizard_Search {

	public static function register_search_wizard_hooks() {
		add_action( ELAY_KB_Core::ELAY_SEARCH_WIZARD_MAIN_PAGE_FEATURES, array('ELAY_KB_Wizard_Search', 'add_main_page_features'), 10, 2 );
		add_action( ELAY_KB_Core::ELAY_SEARCH_WIZARD_ARTICLE_PAGE_FEATURES, array('ELAY_KB_Wizard_Search', 'add_article_page_features'), 10, 2 );
	}

	/**
	 * Add text inputs to Wizard Search Main Page
	 *
	 * @param $kb_id
	 */
	public static function add_main_page_features ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		$kb_config = ELAY_KB_Core::get_kb_config( $kb_id );
		// SIDEBAR layout

		if ( $kb_config['article-structure-version'] == 'version-1' ) {
			$sidebar_search_box_collapse_mode = $form->checkbox( $elay_specs['sidebar_search_box_collapse_mode'] + array(
						'value'             => $elay_config['sidebar_search_box_collapse_mode'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class' => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) );
		} else {
			$sidebar_search_box_collapse_mode = '<div class="eckb-wizard-single-checkbox" style="display: none;"><input type="checkbox" name="sidebar_search_box_collapse_mode" value="on" checked="checked"></div>';
		}

		// GRID SEARCH BOX - Layout
		$search_input_input_arg1 = $elay_specs['grid_search_box_input_width'] + array(
				'value'             => $elay_config['grid_search_box_input_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'

			);
		$search_input_input_arg2 = $elay_specs['grid_search_input_border_width'] + array(
				'value' => $elay_config['grid_search_input_border_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'
			);
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Grid Search', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid',
				),
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
				)
			),
			'inputs' => array(
				'0' => $form->dropdown( $elay_specs['grid_search_layout'] + array(
						'value' => $elay_config['grid_search_layout'],
						'current' => $elay_config['grid_search_layout'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-3',
						'input_class' => 'config-col-7',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'search_box_input_width_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group-2',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Search Box Input', 'echo-elegant-layouts' )
					),
					array( $search_input_input_arg1, $search_input_input_arg2 )
				)
			)
		));

		// SIDEBAR SEARCH BOX - Layout
		$search_input_input_arg1 = $elay_specs['sidebar_search_box_input_width'] + array(
				'value'             => $elay_config['sidebar_search_box_input_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'

			);
		$search_input_input_arg2 = $elay_specs['sidebar_search_input_border_width'] + array(
				'value' => $elay_config['sidebar_search_input_border_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'
			);
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Sidebar Search', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Sidebar',
				),
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
				)
			),
			'inputs' => array(
				'0' => $form->dropdown( $elay_specs['sidebar_search_layout'] + array(
						'value' => $elay_config['sidebar_search_layout'],
						'current' => $elay_config['sidebar_search_layout'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-3',
						'input_class' => 'config-col-7',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $sidebar_search_box_collapse_mode,
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'search_box_input_width_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group-2',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Search Box Input', 'echo-elegant-layouts' )
					),
					array( $search_input_input_arg1, $search_input_input_arg2 )
				),
			)
		));
	}

	/**
	 * Add text inputs to Wizard Search Main Page
	 *
	 * @param $kb_id
	 */
	public static function add_article_page_features ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		$kb_config = ELAY_KB_Core::get_kb_config( $kb_id );

		// SIDEBAR layout

		// only article V2 can have search box on article pages
		if ( $kb_config['article-structure-version'] == 'version-1' || $kb_config['kb_main_page_layout'] == 'Sidebar' ) {
			return;
		}

		// SIDEBAR SEARCH BOX - Layout
		$search_input_input_arg1 = $elay_specs['sidebar_search_box_input_width'] + array(
				'value'             => $elay_config['sidebar_search_box_input_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'

			);
		$search_input_input_arg2 = $elay_specs['sidebar_search_input_border_width'] + array(
				'value' => $elay_config['sidebar_search_input_border_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'
			);
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Sidebar Search', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
				)
			),
			'inputs' => array(
				'0' => $form->dropdown( $elay_specs['sidebar_search_layout'] + array(
						'value' => $elay_config['sidebar_search_layout'],
						'current' => $elay_config['sidebar_search_layout'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-3',
						'input_class'       => 'config-col-7',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'search_box_input_width_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group-2',
						'label_class'       => 'config-col-3',
						'input_class'       => 'config-col-7',
						'label'             => __( 'Search Box Input', 'echo-elegant-layouts' )
					),
					array( $search_input_input_arg1, $search_input_input_arg2 )
				),
			)
		));

	}
}