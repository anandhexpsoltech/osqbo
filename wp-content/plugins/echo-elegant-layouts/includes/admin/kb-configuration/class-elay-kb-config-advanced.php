<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Advanced KB configuration
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Config_Advanced {

	public static function register__hooks() {
		add_action( ELAY_KB_Core::ELAY_ADVANCED_CONFIG_AFTER_MAIN_PAGE, array('ELAY_KB_Config_Advanced', 'add_main_page_advanced'), 10, 2 );
		add_action( ELAY_KB_Core::ELAY_ADVANCED_CONFIG_AFTER_ARTICLE_PAGE, array('ELAY_KB_Config_Advanced', 'add_article_page_advanced'), 10, 2 );
	}

	/**
	 * Add text inputs to advanced Main Page
	 *
	 * @param $kb_id
	 * @param $kb_config
	 */
	public static function add_main_page_advanced( $kb_id, $kb_config ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// GRID layout
		if ( $kb_config['kb_main_page_layout'] == 'Grid' ) {

			if ( ! ELAY_Utilities::is_advanced_search_enabled( $kb_config ) ) {

				//SEARCH
				$arg1_search_box_padding_vertical   = $elay_specs['grid_search_box_padding_top'] + array( 'value' => $elay_config['grid_search_box_padding_top'], 'current' => $elay_config['grid_search_box_padding_top'], 'text_class' => 'config-col-6' );
				$arg2_search_box_padding_vertical   = $elay_specs['grid_search_box_padding_bottom'] + array( 'value' => $elay_config['grid_search_box_padding_bottom'], 'current' => $elay_config['grid_search_box_padding_bottom'], 'text_class' => 'config-col-6' );
				$arg1_search_box_padding_horizontal = $elay_specs['grid_search_box_padding_left'] + array( 'value' => $elay_config['grid_search_box_padding_left'], 'current' => $elay_config['grid_search_box_padding_left'], 'text_class' => 'config-col-6' );
				$arg2_search_box_padding_horizontal = $elay_specs['grid_search_box_padding_right'] + array( 'value' => $elay_config['grid_search_box_padding_right'], 'current' => $elay_config['grid_search_box_padding_right'], 'text_class' => 'config-col-6' );
				$arg1_search_box_margin_vertical = $elay_specs['grid_search_box_margin_top'] + array( 'value' => $elay_config['grid_search_box_margin_top'], 'current' => $elay_config['grid_search_box_margin_top'], 'text_class' => 'config-col-6' );
				$arg2_search_box_margin_vertical = $elay_specs['grid_search_box_margin_bottom'] + array( 'value' => $elay_config['grid_search_box_margin_bottom'], 'current' => $elay_config['grid_search_box_margin_bottom'], 'text_class' => 'config-col-6' );

				$form->option_group_wizard( $elay_specs, array(
					'option-heading'    => __( 'Grid Search', 'echo-elegant-layouts'),
					'class'             => 'eckb-config-advanced eckb-wizard-accordion__body',
					'inputs'            => array(
						'0' => $form->multiple_number_inputs(
							array(
								'id'                => 'grid_search_box_padding',
								'input_group_class' => '',
								'main_label_class'  => '',
								'input_class'       => '',
								'label'             => __( 'Padding( px )', 'echo-elegant-layouts' )
							),
							array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical ,$arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
						),
						'1' => $form->multiple_number_inputs(
							array(
								'id'                => 'grid_search_box_margin',
								'input_group_class' => '',
								'main_label_class'  => '',
								'input_class'       => '',
								'label'             => __( 'Margin( px )', 'echo-elegant-layouts' )
							),
							array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
						),

					)
				));
			}
			
			// GRID CATEGORIES
			$arg1_box_border = $elay_specs['grid_section_border_radius'] + array( 'value' => $elay_config['grid_section_border_radius'], 'current' => $elay_config['grid_section_border_radius'], 'text_class' => 'config-col-6' );
			$arg2_box_border = $elay_specs['grid_section_border_width'] + array( 'value' => $elay_config['grid_section_border_width'], 'current' => $elay_config['grid_section_border_width'], 'text_class' => 'config-col-6' );

			$arg1_section_head_padding_vertical = $elay_specs['grid_section_head_padding_top'] + array( 'value' => $elay_config['grid_section_head_padding_top'], 'current' => $elay_config['grid_section_head_padding_top'], 'text_class' => 'config-col-6' );
			$arg2_section_head_padding_vertical = $elay_specs['grid_section_head_padding_bottom'] + array( 'value' => $elay_config['grid_section_head_padding_bottom'], 'current' => $elay_config['grid_section_head_padding_bottom'], 'text_class' => 'config-col-6' );
			$arg1_section_head_padding_horizontal = $elay_specs['grid_section_head_padding_left'] + array( 'value' => $elay_config['grid_section_head_padding_left'], 'current' => $elay_config['grid_section_head_padding_left'], 'text_class' => 'config-col-6' );
			$arg2_section_head_padding_horizontal = $elay_specs['grid_section_head_padding_right'] + array( 'value' => $elay_config['grid_section_head_padding_right'], 'current' => $elay_config['grid_section_head_padding_right'], 'text_class' => 'config-col-6' );

			$arg1_section_body_padding_vertical = $elay_specs['grid_section_body_padding_top'] + array( 'value' => $elay_config['grid_section_body_padding_top'], 'current' => $elay_config['grid_section_body_padding_top'], 'text_class' => 'config-col-6' );
			$arg2_section_body_padding_vertical = $elay_specs['grid_section_body_padding_bottom'] + array( 'value' => $elay_config['grid_section_body_padding_bottom'], 'current' => $elay_config['grid_section_body_padding_bottom'], 'text_class' => 'config-col-6' );
			$arg1_section_body_padding_horizontal = $elay_specs['grid_section_body_padding_left'] + array( 'value' => $elay_config['grid_section_body_padding_left'], 'current' => $elay_config['grid_section_body_padding_left'], 'text_class' => 'config-col-6' );
			$arg2_section_body_padding_horizontal = $elay_specs['grid_section_body_padding_right'] + array( 'value' => $elay_config['grid_section_body_padding_right'], 'current' => $elay_config['grid_section_body_padding_right'], 'text_class' => 'config-col-6' );

			$arg1_section_cat_name_padding_vertical = $elay_specs['grid_section_cat_name_padding_top'] + array( 'value' => $elay_config['grid_section_cat_name_padding_top'], 'current' => $elay_config['grid_section_cat_name_padding_top'], 'text_class' => 'config-col-6' );
			$arg2_section_cat_name_padding_vertical = $elay_specs['grid_section_cat_name_padding_bottom'] + array( 'value' => $elay_config['grid_section_cat_name_padding_bottom'], 'current' => $elay_config['grid_section_cat_name_padding_bottom'], 'text_class' => 'config-col-6' );
			$arg1_section_cat_name_padding_horizontal = $elay_specs['grid_section_cat_name_padding_left'] + array( 'value' => $elay_config['grid_section_cat_name_padding_left'], 'current' => $elay_config['grid_section_cat_name_padding_left'], 'text_class' => 'config-col-6' );
			$arg2_section_cat_name_padding_horizontal = $elay_specs['grid_section_cat_name_padding_right'] + array( 'value' => $elay_config['grid_section_cat_name_padding_right'], 'current' => $elay_config['grid_section_cat_name_padding_right'], 'text_class' => 'config-col-6' );

			$arg1_section_icon_padding_vertical = $elay_specs['grid_section_icon_padding_top'] + array( 'value' => $elay_config['grid_section_icon_padding_top'], 'current' => $elay_config['grid_section_icon_padding_top'], 'text_class' => 'config-col-6' );
			$arg2_section_icon_padding_vertical = $elay_specs['grid_section_icon_padding_bottom'] + array( 'value' => $elay_config['grid_section_icon_padding_bottom'], 'current' => $elay_config['grid_section_icon_padding_bottom'], 'text_class' => 'config-col-6' );
			$arg1_section_icon_padding_horizontal = $elay_specs['grid_section_icon_padding_left'] + array( 'value' => $elay_config['grid_section_icon_padding_left'], 'current' => $elay_config['grid_section_icon_padding_left'], 'text_class' => 'config-col-6' );
			$arg2_section_icon_padding_horizontal = $elay_specs['grid_section_icon_padding_right'] + array( 'value' => $elay_config['grid_section_icon_padding_right'], 'current' => $elay_config['grid_section_icon_padding_right'], 'text_class' => 'config-col-6' );

			$arg1_section_desc_padding_vertical = $elay_specs['grid_section_desc_padding_top'] + array( 'value' => $elay_config['grid_section_desc_padding_top'], 'current' => $elay_config['grid_section_desc_padding_top'], 'text_class' => 'config-col-6' );
			$arg2_section_desc_padding_vertical = $elay_specs['grid_section_desc_padding_bottom'] + array( 'value' => $elay_config['grid_section_desc_padding_bottom'], 'current' => $elay_config['grid_section_desc_padding_bottom'], 'text_class' => 'config-col-6' );
			$arg1_section_desc_padding_horizontal = $elay_specs['grid_section_desc_padding_left'] + array( 'value' => $elay_config['grid_section_desc_padding_left'], 'current' => $elay_config['grid_section_desc_padding_left'], 'text_class' => 'config-col-6' );
			$arg2_section_desc_padding_horizontal = $elay_specs['grid_section_desc_padding_right'] + array( 'value' => $elay_config['grid_section_desc_padding_right'], 'current' => $elay_config['grid_section_desc_padding_right'], 'text_class' => 'config-col-6' );

			$form->option_group_wizard( $elay_specs, array(
				'option-heading'    => __( 'Grid Categories', 'echo-elegant-layouts'),
				'class'             => 'eckb-config-advanced eckb-wizard-accordion__body',
				'inputs'            => array(
					'0' => $form->dropdown( $elay_specs['grid_section_box_hover'] + array(
							'value'             => $elay_config['grid_section_box_hover'],
							'current'           => $elay_config['grid_section_box_hover'],
							'input_group_class' => 'config-col-12',
							'label_class'       => 'config-col-5',
							'input_class'       => 'config-col-6'
						) ),
					'1' => $form->multiple_number_inputs(
						array(
							'id'                => 'box_border',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Box Border( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_box_border, $arg2_box_border )
					),
					'2' => $form->multiple_number_inputs(
						array(
							'id'                => 'grid_section_head_padding',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Padding( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_section_head_padding_vertical, $arg2_section_head_padding_vertical, $arg1_section_head_padding_horizontal, $arg2_section_head_padding_horizontal )
					),
					'4' => $form->multiple_number_inputs(
						array(
							'id'                => 'grid_section_icon_padding',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Icon Padding ( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_section_icon_padding_vertical, $arg2_section_icon_padding_vertical, $arg1_section_icon_padding_horizontal, $arg2_section_icon_padding_horizontal )
					),
					'5' => $form->multiple_number_inputs(
						array(
							'id'                => 'grid_section_cat_name_padding',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Name Padding ( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_section_cat_name_padding_vertical, $arg2_section_cat_name_padding_vertical, $arg1_section_cat_name_padding_horizontal, $arg2_section_cat_name_padding_horizontal )
					),
					'6' => $form->multiple_number_inputs(
						array(
							'id'                => 'grid_section_desc_padding',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Description Padding ( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_section_desc_padding_vertical, $arg2_section_desc_padding_vertical, $arg1_section_desc_padding_horizontal, $arg2_section_desc_padding_horizontal )
					),
					'7' => $form->dropdown( $elay_specs['grid_section_box_shadow'] + array(
							'value' => $elay_config['grid_section_box_shadow'],
							'current' => $elay_config['grid_section_box_shadow'],
							'input_group_class' => 'config-col-12',
							'label_class'       => 'config-col-5',
							'input_class'       => 'config-col-6'
						) ),
					
					'9' => $form->checkbox( $elay_specs['grid_section_divider'] + array(
							'value'             => $elay_config['grid_section_divider'],
							'input_group_class' => 'config-col-12',
							'label_class'       => 'config-col-5',
							'input_class'       => 'config-col-2'
						) ),
					'10' => $form->text( $elay_specs['grid_section_divider_thickness'] + array(
							'value'             => $elay_config['grid_section_divider_thickness'],
							'input_group_class' => 'config-col-12',
							'label_class'       => 'config-col-5',
							'input_class'       => 'config-col-2'
						) ),
					'11' => $form->multiple_number_inputs(
						array(
							'id'                => 'grid_section_body_padding',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Padding ( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_section_body_padding_vertical, $arg2_section_body_padding_vertical, $arg1_section_body_padding_horizontal, $arg2_section_body_padding_horizontal )
					),
				)
			));
		
		}
	}

	/**
	 * Add text inputs to advanced Main Page
	 *
	 * @param $kb_id
	 * @param $kb_config
	 */
	public static function add_article_page_advanced ( $kb_id, $kb_config ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// SIDEBAR layout
		if ( $kb_config['kb_main_page_layout'] == 'Sidebar' ) {

			if ( ! ELAY_Utilities::is_advanced_search_enabled( $kb_config ) ) {

				//SEARCH
				$arg1_search_box_padding_vertical   = $elay_specs['sidebar_search_box_padding_top'] + array( 'value' => $elay_config['sidebar_search_box_padding_top'], 'current' => $elay_config['sidebar_search_box_padding_top'], 'text_class' => 'config-col-6' );
				$arg2_search_box_padding_vertical   = $elay_specs['sidebar_search_box_padding_bottom'] + array( 'value' => $elay_config['sidebar_search_box_padding_bottom'], 'current' => $elay_config['sidebar_search_box_padding_bottom'], 'text_class' => 'config-col-6' );
				$arg1_search_box_padding_horizontal = $elay_specs['sidebar_search_box_padding_left'] + array( 'value' => $elay_config['sidebar_search_box_padding_left'], 'current' => $elay_config['sidebar_search_box_padding_left'], 'text_class' => 'config-col-6' );
				$arg2_search_box_padding_horizontal = $elay_specs['sidebar_search_box_padding_right'] + array( 'value' => $elay_config['sidebar_search_box_padding_right'], 'current' => $elay_config['sidebar_search_box_padding_right'], 'text_class' => 'config-col-6' );
				$arg1_search_box_margin_vertical = $elay_specs['sidebar_search_box_margin_top'] + array( 'value' => $elay_config['sidebar_search_box_margin_top'], 'current' => $elay_config['sidebar_search_box_margin_top'], 'text_class' => 'config-col-6' );
				$arg2_search_box_margin_vertical = $elay_specs['sidebar_search_box_margin_bottom'] + array( 'value' => $elay_config['sidebar_search_box_margin_bottom'], 'current' => $elay_config['sidebar_search_box_margin_bottom'], 'text_class' => 'config-col-6' );

				$form->option_group_wizard( $elay_specs, array(
					'option-heading'    => __( 'Sidebar Search', 'echo-elegant-layouts'),
					'class'             => 'eckb-config-advanced eckb-wizard-accordion__body',
					'inputs'            => array(
						'0' => $form->multiple_number_inputs(
							array(
								'id'                => 'sidebar_search_box_padding',
								'input_group_class' => '',
								'main_label_class'  => '',
								'input_class'       => '',
								'label'             => __( 'Padding( px )', 'echo-elegant-layouts' )
							),
							array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical ,$arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
						),
						'1' => $form->multiple_number_inputs(
							array(
								'id'                => 'sidebar_search_box_margin',
								'input_group_class' => '',
								'main_label_class'  => '',
								'input_class'       => '',
								'label'             => __( 'Margin( px )', 'echo-elegant-layouts' )
							),
							array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
						),
						'3' => $form->checkbox( $elay_specs['sidebar_search_box_results_style'] + array(
								'value'             => $elay_config['sidebar_search_box_results_style'],
								'id'                => 'sidebar_search_box_results_style',
								'input_group_class' => 'config-col-12',
								'label_class'       => 'config-col-5',
								'input_class'       => 'config-col-2'
							) ),
					)
				));
			}

			// LIST OF ARTICLES - Advanced Style
			$arg1_section_body_padding_vertical = $elay_specs['sidebar_section_body_padding_top'] + array( 'value' => $elay_config['sidebar_section_body_padding_top'], 'current' => $elay_config['sidebar_section_body_padding_top'], 'text_class' => 'config-col-6' );
			$arg2_section_body_padding_vertical = $elay_specs['sidebar_section_body_padding_bottom'] + array( 'value' => $elay_config['sidebar_section_body_padding_bottom'], 'current' => $elay_config['sidebar_section_body_padding_bottom'], 'text_class' => 'config-col-6' );
			$arg1_section_body_padding_horizontal = $elay_specs['sidebar_section_body_padding_left'] + array( 'value' => $elay_config['sidebar_section_body_padding_left'], 'current' => $elay_config['sidebar_section_body_padding_left'], 'text_class' => 'config-col-6' );
			$arg2_section_body_padding_horizontal = $elay_specs['sidebar_section_body_padding_right'] + array( 'value' => $elay_config['sidebar_section_body_padding_right'], 'current' => $elay_config['sidebar_section_body_padding_right'], 'text_class' => 'config-col-6' );
			$article_spacing_arg1 = $elay_specs['sidebar_article_list_margin'] +  array(
					'value'             => $elay_config['sidebar_article_list_margin'],
					'id'                => 'sidebar_article_list_margin',
					'input_group_class' => 'config-col-12',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-3'
				);
			$article_spacing_arg2 = $elay_specs['sidebar_article_list_spacing'] +  array(
					'value'             => $elay_config['sidebar_article_list_spacing'],
					'id'                => 'sidebar_article_list_spacing',
					'input_group_class' => 'config-col-12',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-3'
				);

			$form->option_group_wizard( $elay_specs, array(
				'option-heading'    =>__( 'Sidebar Articles', 'echo-elegant-layouts'),
				'class'             => 'eckb-config-advanced eckb-wizard-accordion__body',
				'inputs' => array(

					'0' => $form->multiple_number_inputs(
						array(
							'id'                => 'sidebar_article_group',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Article Spacing ( px )', 'echo-elegant-layouts' )
						),
						array( $article_spacing_arg1, $article_spacing_arg2 )
					),

					'1' => $form->checkbox( $elay_specs['sidebar_article_underline'] + array(
							'value' => $elay_config['sidebar_article_underline'],
							'id'                => 'sidebar_article_underline',
							'input_group_class' => 'config-col-12',
							'label_class'       => 'config-col-5',
							'input_class'       => 'config-col-2'
						) ),
					'2' => $form->checkbox( $elay_specs['sidebar_article_active_bold'] + array(
							'value' => $elay_config['sidebar_article_active_bold'],
							'id'                => 'sidebar_article_active_bold',
							'input_group_class' => 'config-col-12',
							'label_class'       => 'config-col-5',
							'input_class'       => 'config-col-2'
						) ),
					'3' => $form->multiple_number_inputs(
						array(
							'id'                => 'sidebar_section_body_padding_group',
							'input_group_class' => '',
							'main_label_class'  => '',
							'input_class'       => '',
							'label'             => __( 'Padding ( px )', 'echo-elegant-layouts' )
						),
						array( $arg1_section_body_padding_vertical, $arg2_section_body_padding_vertical, $arg1_section_body_padding_horizontal, $arg2_section_body_padding_horizontal )
					)
				)
			));
		}


		// CATEGORIES - Advanced Style
		$arg1_section_head_padding_vertical = $elay_specs['sidebar_section_head_padding_top'] + array( 'value' => $elay_config['sidebar_section_head_padding_top'], 'current' => $elay_config['sidebar_section_head_padding_top'], 'text_class' => 'config-col-6' );
		$arg2_section_head_padding_vertical = $elay_specs['sidebar_section_head_padding_bottom'] + array( 'value' => $elay_config['sidebar_section_head_padding_bottom'], 'current' => $elay_config['sidebar_section_head_padding_bottom'], 'text_class' => 'config-col-6' );
		$arg1_section_head_padding_horizontal = $elay_specs['sidebar_section_head_padding_left'] + array( 'value' => $elay_config['sidebar_section_head_padding_left'], 'current' => $elay_config['sidebar_section_head_padding_left'], 'text_class' => 'config-col-6' );
		$arg2_section_head_padding_horizontal = $elay_specs['sidebar_section_head_padding_right'] + array( 'value' => $elay_config['sidebar_section_head_padding_right'], 'current' => $elay_config['sidebar_section_head_padding_right'], 'text_class' => 'config-col-6' );
		$arg1_box_border = $elay_specs['sidebar_section_border_radius'] + array( 'value' => $elay_config['sidebar_section_border_radius'], 'current' => $elay_config['sidebar_section_border_radius'], 'text_class' => 'config-col-6' );
		$arg2_box_border = $elay_specs['sidebar_section_border_width'] + array( 'value' => $elay_config['sidebar_section_border_width'], 'current' => $elay_config['sidebar_section_border_width'], 'text_class' => 'config-col-6' );
		
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Sidebar Categories', 'echo-elegant-layouts'),
			'class'        => 'eckb-mm-mp-links-tuning-categories-advanced eckb-mm-ap-links-tuning-categories-advanced eckb-wizard-accordion__body',
			'inputs' => array(
				'0' => $form->multiple_number_inputs(
					array(
						'id'                => 'sidebar_section_head_padding_group',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Category Heading Padding ( px )', 'echo-elegant-layouts' )
					),
					array( $arg1_section_head_padding_vertical, $arg2_section_head_padding_vertical, $arg1_section_head_padding_horizontal, $arg2_section_head_padding_horizontal  )
				),
				'1' => $form->dropdown( $elay_specs['sidebar_section_box_shadow'] + array(
						'value' => $elay_config['sidebar_section_box_shadow'],
						'current' => $elay_config['sidebar_section_box_shadow'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6'
					) ),

				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'box_border',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Box Border ( px )', 'echo-elegant-layouts' )
					),
					array( $arg1_box_border, $arg2_box_border )
				)
			)
		));

	}

}
