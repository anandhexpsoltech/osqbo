<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard search data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ASEA_KB_Wizard_Search {

	public static function register_search_wizard_hooks() {
		add_action( ASEA_KB_Core::ASEA_SEARCH_WIZARD_AFTER_MAIN_PAGE, array('ASEA_KB_Wizard_Search', 'add_main_page_search') );
		add_action( ASEA_KB_Core::ASEA_SEARCH_WIZARD_AFTER_ARTICLE_PAGE, array('ASEA_KB_Wizard_Search', 'add_article_page_search') );
		add_filter( ASEA_KB_Core::ASEA_SEARCH_WIZARD_MAIN_PAGE_CLASSES, array('ASEA_KB_Wizard_Search', 'filter_main_page_class') );
		add_action( ASEA_KB_Core::ASEA_SEARCH_WIZARD_MAIN_PAGE_BEFORE_PREVIEW, array('ASEA_KB_Wizard_Search', 'add_presets') );
	}

	/**
	 * Add text inputs to Wizard Text Main Page
	 * @param $kb_id
	 */
	public static function add_main_page_search ( $kb_id ) {
		$form = new ASEA_KB_Config_Elements();
		$asea_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		$ix = 'mp';

		$arg1_search_box_padding_vertical   = $asea_specs['advanced_search_' . $ix . '_box_padding_top'] + array( 
			'value' => $asea_config['advanced_search_' . $ix . '_box_padding_top'], 
			'current' => $asea_config['advanced_search_' . $ix . '_box_padding_top'], 
			'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-section-1',
				'style_name' => 'padding-top',
				'postfix' => 'px'
			)
		);
		$arg2_search_box_padding_vertical   = $asea_specs['advanced_search_' . $ix . '_box_padding_bottom'] + array( 
			'value' => $asea_config['advanced_search_' . $ix . '_box_padding_bottom'], 
			'current' => $asea_config['advanced_search_' . $ix . '_box_padding_bottom'], 
			'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-section-1',
				'style_name' => 'padding-bottom',
				'postfix' => 'px'
			)
		);
		$arg1_search_box_padding_horizontal = $asea_specs['advanced_search_' . $ix . '_box_padding_left'] + array( 
			'value' => $asea_config['advanced_search_' . $ix . '_box_padding_left'], 
			'current' => $asea_config['advanced_search_' . $ix . '_box_padding_left'], 
			'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-section-1',
				'style_name' => 'padding-left',
				'postfix' => 'px'
			)
		);
		$arg2_search_box_padding_horizontal = $asea_specs['advanced_search_' . $ix . '_box_padding_right'] + array( 
			'value' => $asea_config['advanced_search_' . $ix . '_box_padding_right'], 
			'current' => $asea_config['advanced_search_' . $ix . '_box_padding_right'], 
			'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-section-1',
				'style_name' => 'padding-right',
				'postfix' => 'px'
			)
		);

		$arg1_search_box_margin_vertical = $asea_specs['advanced_search_' . $ix . '_box_margin_top'] + array( 
			'value' => $asea_config['advanced_search_' . $ix . '_box_margin_top'], 
			'current' => $asea_config['advanced_search_' . $ix . '_box_margin_top'], 
			'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-section-1',
				'style_name' => 'margin-top',
				'postfix' => 'px'
			)
		);
		$arg2_search_box_margin_vertical = $asea_specs['advanced_search_' . $ix . '_box_margin_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_margin_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_box_margin_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-section-1',
				'style_name' => 'margin-bottom',
				'postfix' => 'px'
			) );

		//Search Box Container ---------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Advanced Search Box', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(
				'0' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_box_visibility'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_box_visibility'],
						'current' => $asea_config['advanced_search_' . $ix . '_box_visibility'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-6',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_padding',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding( px )', 'echo-advanced-search' ),
					),
					array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical ,$arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
				),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_margin',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Margin( px )', 'echo-advanced-search' ),
					),
					array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
				),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_box_font_width'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_box_font_width'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-1',
							'style_name' => 'width',
							'postfix' => '%'
						)
					) ),
			)));


		$arg1_search_description_below_title_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_title_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_top'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-1',
				'style_name' => 'padding-top',
				'postfix' => 'px'
			)  );
		$arg2_search_description_below_title_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_title_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-1',
				'style_name' => 'padding-bottom',
				'postfix' => 'px'
			) );

		$arg1_search_description_below_input_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_input_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_top'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-2',
				'style_name' => 'padding-top',
				'postfix' => 'px'
			) );
		$arg2_search_description_below_input_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_input_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-2',
				'style_name' => 'padding-bottom',
				'postfix' => 'px'
			) );


		$arg1_title_text_shadow         = $asea_specs['advanced_search_' . $ix . '_title_text_shadow_x_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_x_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_title_text_shadow         = $asea_specs['advanced_search_' . $ix . '_title_text_shadow_y_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_y_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_title_text_shadow         = $asea_specs['advanced_search_' . $ix . '_title_text_shadow_blur'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_blur'], 'current' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_blur'], 'text_class' => 'config-col-6' );

		$arg1_description_below_title_shadow         = $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_description_below_title_shadow         = $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_description_below_title_shadow         = $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'], 'text_class' => 'config-col-6' );


		// Search Title ---------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Search Title', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_title_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_title_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-title',
							'style_name' => 'font-size',
							'postfix' => 'px'
						)
					) ),
				'1' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_title_font_weight'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_title_font_weight'],
						'current' => $asea_config['advanced_search_' . $ix . '_title_font_weight'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-title',
							'style_name' => 'font-weight',
						)
					)),
				'2' => $form->text( $asea_specs['advanced_search_' . $ix . '_title_padding_bottom'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_title_padding_bottom'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-title',
							'style_name' => 'padding-bottom',
							'postfix' => 'px'
						)
					) ),
				'3' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_text_title_shadow_position_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Text Shadow', 'echo-advanced-search' ),
						'data' => array(
							'preview' => 1
						)
					),
					array( $arg1_title_text_shadow, $arg2_title_text_shadow, $arg3_title_text_shadow )
				),
				'4' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_title_text_shadow_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_title_text_shadow_toggle'],
						'id'                => 'advanced_search_' . $ix . '_title_text_shadow_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),

				//Title Tag settings
				'5' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_title_tag'] + array(
					'value' => $asea_config['advanced_search_' . $ix . '_title_tag'],
					'current' => $asea_config['advanced_search_' . $ix . '_title_tag'],
					'input_group_class' => 'eckb-wizard-single-dropdown',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-4',
					'data' => array(
						'example_image'     =>      '[asea]search-wizard/search-title-tag.jpg',
						'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-title',
						'preview' => 1
					)
				)),

			)
		));

		// Description Below Search Title -------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Description Below Search Title', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends'        => array(
				'hide_when' => array(
					'advanced_search_' . $ix . '_description_below_title' => '', 
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_description_below_title_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_description_below_title_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-1',
							'style_name' => 'font-size',
							'postfix' => 'px'
						) 
					) ),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_title_padding',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding( px )', 'echo-advanced-search' )
					),
					array( $arg1_search_description_below_title_padding_vertical, $arg2_search_description_below_title_padding_vertical )
				),
				'3' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_title_shadow_position_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Text Shadow', 'echo-advanced-search' )
					),
					array( $arg1_description_below_title_shadow, $arg2_description_below_title_shadow ,$arg3_description_below_title_shadow )
				),
				'4' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_toggle'],
						'id'                => 'advanced_search_' . $ix . '_description_below_title_text_shadow_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
			)
		));

		$arg1_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_x_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_x_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_y_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_y_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_blur'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_blur'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_blur'], 'text_class' => 'config-col-6' );
		$arg4_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_spread'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_spread'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_spread'], 'text_class' => 'config-col-6' );

		$arg1_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_top'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-main-page-preview #asea_advanced_search_terms',
			'style_name' => 'padding-top',
			'postfix' => 'px'
		));
		$arg2_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_bottom'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-main-page-preview #asea_advanced_search_terms',
			'style_name' => 'padding-bottom',
			'postfix' => 'px'
		) );
		$arg3_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_left'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_left'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_left'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-main-page-preview .asea-search-box',
			'style_name' => 'padding-left',
			'postfix' => 'px'
		) );
		$arg4_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_right'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_right'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_right'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-main-page-preview .asea-search-box',
			'style_name' => 'padding-right',
			'postfix' => 'px'
		) );

		$search_input_input_arg1 = $asea_specs['advanced_search_' . $ix . '_box_input_width'] + array(
				'value'             => $asea_config['advanced_search_' . $ix . '_box_input_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-main-page-preview #asea_search_form',
					'style_name' => 'width',
					'postfix' => '%'
				)
			);
		$search_input_input_arg2 = $asea_specs['advanced_search_' . $ix . '_input_border_width'] + array(
				'value' => $asea_config['advanced_search_' . $ix . '_input_border_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-main-page-preview .asea-search-box',
					'style_name' => 'border-width',
					'postfix' => 'px'
				)
			);
		$search_input_input_arg3 = $asea_specs['advanced_search_' . $ix . '_input_box_radius'] + array(
				'value'             => $asea_config['advanced_search_' . $ix . '_input_box_radius'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-main-page-preview .asea-search-box',
					'style_name' => 'border-radius',
					'postfix' => 'px'
				)
			);
		$search_input_input_arg4 = $asea_specs['advanced_search_' . $ix . '_input_box_font_size'] + array(
				'value'             => $asea_config['advanced_search_' . $ix . '_input_box_font_size'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-main-page-preview .asea-search-box',
					'style_name' => 'font-size',
					'postfix' => 'px'
				)
			);

		// Search Input ---------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Search Input', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(

				'0' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_input_width_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Search Box Input', 'echo-advanced-search' )
					),
					array( $search_input_input_arg1, $search_input_input_arg2, $search_input_input_arg3, $search_input_input_arg4 )
				),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_input_padding_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding ( px )', 'echo-advanced-search' )
					),
					array( $arg1_search_input_padding_shadow, $arg2_search_input_padding_shadow ,$arg3_search_input_padding_shadow, $arg4_search_input_padding_shadow )
				),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_input_box_shadow_position_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Box Shadow Position', 'echo-advanced-search' ),
						'data' => array(
							'preview' => 1
						)
					),
					array( $arg1_search_input_box_shadow, $arg2_search_input_box_shadow ,$arg3_search_input_box_shadow, $arg4_search_input_box_shadow )
				),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_input_box_shadow_rgba'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_input_box_shadow_rgba'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'4' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_input_box_search_icon_placement'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_input_box_search_icon_placement'],
						'current' => $asea_config['advanced_search_' . $ix . '_input_box_search_icon_placement'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					)),
				'5' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_input_box_loading_icon_placement'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_input_box_loading_icon_placement'],
						'current' => $asea_config['advanced_search_' . $ix . '_input_box_loading_icon_placement'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					)),
			)
		));

		// Description Below Search Input -------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Description Below Search Input', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends'        => array(
				'hide_when' => array(
					'advanced_search_' . $ix . '_description_below_input' => '', 
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_description_below_input_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_description_below_input_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-main-page-preview #asea-search-description-2',
							'style_name' => 'font-size',
							'postfix' => 'px'
						)
					) ),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_input_padding',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding( px )', 'echo-advanced-search' )
					),
					array( $arg1_search_description_below_input_padding_vertical, $arg2_search_description_below_input_padding_vertical )
				),
			)
		));

		//Search Results -----------------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Search Results', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(
				'0' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_filter_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_filter_toggle'],
						'id'                => 'advanced_search_' . $ix . '_filter_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/search-results-search-filter.jpg'

						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_' . $ix . '_auto_complete_wait'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_auto_complete_wait'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/search-results-auto-complete.jpg'
						)
					) ),
				'2' => $form->text( $asea_specs['advanced_search_' . $ix . '_results_list_size'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_results_list_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/size-of-search-results-list.jpg'
						)
					) ),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_results_page_size'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_results_page_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/size-of-search-results-page.jpg'
						)
					) ),
				'4' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_show_top_category'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_show_top_category'],
						'id'                => 'advanced_search_' . $ix . '_show_top_category',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/show-category.jpg'
						)
					) ),
				'5' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_box_results_style'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_box_results_style'],
						'id'                => 'advanced_search_' . $ix . '_box_results_style',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/search-results-colors.jpg'
						)
					) ),
				'6' => $form->text( $asea_specs['advanced_search_' . $ix . '_search_results_article_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_search_results_article_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/search-results-font-size.jpg'
						)
					) ),
				
				//Dropdown Width settings
				'7' => $form->text( $asea_specs['advanced_search_' . $ix . '_filter_dropdown_width'] + array(
					'value'             => $asea_config['advanced_search_' . $ix . '_filter_dropdown_width'],
					'input_group_class' => 'eckb-wizard-single-text',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-4',
					'data' => array(
						'example_image'     =>      '[asea]search-wizard/search-results-dropdown-width-filter.jpg',
						'style_name' => 'width',
						'postfix' => 'px'
					)
				) ),	

				//Category Level settings
				'8' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_filter_category_level'] + array(
					'value' => $asea_config['advanced_search_' . $ix . '_filter_category_level'],
					'current' => $asea_config['advanced_search_' . $ix . '_filter_category_level'],
					'input_group_class' => 'eckb-wizard-single-dropdown',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-4',
					'data' => array(
						'example_image'     =>      '[asea]search-wizard/search-results-category-level.jpg',
					)
				)),
				
			)
		));
 
		//Background Image -------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Background Image', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_image_url'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_image_url'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-12',
						'input_class'       => 'config-col-12',
						'data' => array(
							'preview' => 1,
						)
					) ),
				'1' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_image_position_x'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_image_position_x'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_image_position_x'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-main-page-preview #asea-search-background-image-1',
							'style_name' => 'background-position-x',
						)
					)),
				'2' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_image_position_y'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_image_position_y'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_image_position_y'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-main-page-preview #asea-search-background-image-1',
							'style_name' => 'background-position-y',
						)
					)),


			)
		));
		//Background Pattern Image -----------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Background Pattern Image', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_url'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_pattern_image_url'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-12',
						'input_class'       => 'config-col-12',
						'data' => array(
							'preview'     =>      1
						)
					) ),
				'1' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_position_x'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_x'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_x'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-main-page-preview #asea-search-pattern-1',
							'style_name' => 'background-position-x',
						)
					)),
				'2' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_position_y'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_y'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_y'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-main-page-preview #asea-search-pattern-1',
							'style_name' => 'background-position-y',
						)
					)),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_opacity'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_opacity'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-2',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-main-page-preview #asea-search-pattern-1',
							'style_name' => 'opacity',
						)
					) ),


			)
		));
		//Background Gradient ----------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Background Gradient', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_gradient_degree'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_gradient_degree'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_gradient_opacity'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_gradient_opacity'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_background_gradient_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_gradient_toggle'],
						'id'                => 'advanced_search_' . $ix . '_background_gradient_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'preview' => 1
						)
					) ),
			)
		));

	}
	
	/**
	 * Add text inputs to Wizard Text Article Page
	 * @param $kb_id
	 */
	public static function add_article_page_search ( $kb_id ) {
		$form = new ASEA_KB_Config_Elements();
		
		$asea_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		$ix = 'ap';

		$arg1_search_box_padding_vertical   = $asea_specs['advanced_search_' . $ix . '_box_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_box_padding_top'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-section-1',
				'style_name' => 'padding-top',
				'postfix' => 'px'
			) );
		$arg2_search_box_padding_vertical   = $asea_specs['advanced_search_' . $ix . '_box_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_box_padding_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-section-1',
				'style_name' => 'padding-bottom',
				'postfix' => 'px'
			) );
		$arg1_search_box_padding_horizontal = $asea_specs['advanced_search_' . $ix . '_box_padding_left'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_padding_left'], 'current' => $asea_config['advanced_search_' . $ix . '_box_padding_left'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-section-1',
				'style_name' => 'padding-left',
				'postfix' => 'px'
			) );
		$arg2_search_box_padding_horizontal = $asea_specs['advanced_search_' . $ix . '_box_padding_right'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_padding_right'], 'current' => $asea_config['advanced_search_' . $ix . '_box_padding_right'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-section-1',
				'style_name' => 'padding-right',
				'postfix' => 'px'
			) );

		$arg1_search_box_margin_vertical = $asea_specs['advanced_search_' . $ix . '_box_margin_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_margin_top'], 'current' => $asea_config['advanced_search_' . $ix . '_box_margin_top'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-section-1',
				'style_name' => 'margin-top',
				'postfix' => 'px'
			) );
		$arg2_search_box_margin_vertical = $asea_specs['advanced_search_' . $ix . '_box_margin_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_box_margin_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_box_margin_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-section-1',
				'style_name' => 'margin-bottom',
				'postfix' => 'px'
			) );

		//Search Box Container ---------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Advanced Search Box', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(
				'0' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_box_visibility'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_box_visibility'],
						'current' => $asea_config['advanced_search_' . $ix . '_box_visibility'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-6',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_padding',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding( px )', 'echo-advanced-search' ),
					),
					array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical ,$arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
				),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_margin',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Margin( px )', 'echo-advanced-search' ),
					),
					array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
				),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_box_font_width'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_box_font_width'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-1',
							'style_name' => 'width',
							'postfix' => '%'
						)
					) ),
			)));


		$arg1_search_description_below_title_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_title_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_top'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-1',
				'style_name' => 'padding-top',
				'postfix' => 'px'
			)  );
		$arg2_search_description_below_title_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_title_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_padding_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-1',
				'style_name' => 'padding-bottom',
				'postfix' => 'px'
			) );

		$arg1_search_description_below_input_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_input_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_top'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-2',
				'style_name' => 'padding-top',
				'postfix' => 'px'
			)  );
		$arg2_search_description_below_input_padding_vertical = $asea_specs['advanced_search_' . $ix . '_description_below_input_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_input_padding_bottom'], 'text_class' => 'config-col-6',
			'data' => array(
				'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-2',
				'style_name' => 'padding-bottom',
				'postfix' => 'px'
			)  );


		$arg1_title_text_shadow         = $asea_specs['advanced_search_' . $ix . '_title_text_shadow_x_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_x_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_title_text_shadow         = $asea_specs['advanced_search_' . $ix . '_title_text_shadow_y_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_y_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_title_text_shadow         = $asea_specs['advanced_search_' . $ix . '_title_text_shadow_blur'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_blur'], 'current' => $asea_config['advanced_search_' . $ix . '_title_text_shadow_blur'], 'text_class' => 'config-col-6' );

		$arg1_description_below_title_shadow         = $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_description_below_title_shadow         = $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_description_below_title_shadow         = $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'], 'current' => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'], 'text_class' => 'config-col-6' );


		// Search Title ---------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Search Title', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_title_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_title_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-title',
							'style_name' => 'font-size',
							'postfix' => 'px'
						)
					) ),
				'1' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_title_font_weight'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_title_font_weight'],
						'current' => $asea_config['advanced_search_' . $ix . '_title_font_weight'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-title',
							'style_name' => 'font-weight',
						)
					)),
				'2' => $form->text( $asea_specs['advanced_search_' . $ix . '_title_padding_bottom'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_title_padding_bottom'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-title',
							'style_name' => 'padding-bottom',
							'postfix' => 'px'
						)
					) ),
				'3' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_text_title_shadow_position_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Text Shadow', 'echo-advanced-search' ),
						'data' => array(
							'preview' => '1'
						)
					),
					array( $arg1_title_text_shadow, $arg2_title_text_shadow, $arg3_title_text_shadow )
				),
				'4' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_title_text_shadow_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_title_text_shadow_toggle'],
						'id'                => 'advanced_search_' . $ix . '_title_text_shadow_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => '1'
						)
					) ),
				//Title Tag settings
				'5' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_title_tag'] + array(
					'value' => $asea_config['advanced_search_' . $ix . '_title_tag'],
					'current' => $asea_config['advanced_search_' . $ix . '_title_tag'],
					'input_group_class' => 'eckb-wizard-single-dropdown',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-4',
					'data' => array(
						'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-title',
						'preview' => 1
					)
				)),


			)
		));

		// Description Below Search Title -------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Description Below Search Title', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends'        => array(
				'hide_when' => array(
					'advanced_search_' . $ix . '_description_below_title' => '', 
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_description_below_title_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_description_below_title_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-1',
							'style_name' => 'font-size',
							'postfix' => 'px'
						) 
					) ),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_title_padding',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding( px )', 'echo-advanced-search' )
					),
					array( $arg1_search_description_below_title_padding_vertical, $arg2_search_description_below_title_padding_vertical )
				),
				'3' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_title_shadow_position_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Text Shadow', 'echo-advanced-search' ),
						'data'   => array(
							'preview' => 1
						)
					),
					array( $arg1_description_below_title_shadow, $arg2_description_below_title_shadow ,$arg3_description_below_title_shadow )
				),
				'4' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_description_below_title_text_shadow_toggle'],
						'id'                => 'advanced_search_' . $ix . '_description_below_title_text_shadow_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
			)
		));

		$arg1_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_x_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_x_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_y_offset'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_y_offset'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_blur'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_blur'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_blur'], 'text_class' => 'config-col-6' );
		$arg4_search_input_box_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_shadow_spread'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_spread'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_shadow_spread'], 'text_class' => 'config-col-6' );

		$arg1_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_top'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_top'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_top'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-article-page-preview #asea_advanced_search_terms',
			'style_name' => 'padding-top',
			'postfix' => 'px'
		) );
		$arg2_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_bottom'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_bottom'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_bottom'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-article-page-preview #asea_advanced_search_terms',
			'style_name' => 'padding-bottom',
			'postfix' => 'px'
		) );
		$arg3_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_left'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_left'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_left'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-article-page-preview .asea-search-box',
			'style_name' => 'padding-left',
			'postfix' => 'px'
		) );
		$arg4_search_input_padding_shadow   = $asea_specs['advanced_search_' . $ix . '_input_box_padding_right'] + array( 'value' => $asea_config['advanced_search_' . $ix . '_input_box_padding_right'], 'current' => $asea_config['advanced_search_' . $ix . '_input_box_padding_right'], 'text_class' => 'config-col-6',
		'data' => array(
			'target_selector' => '.epkb-wizard-search-article-page-preview .asea-search-box',
			'style_name' => 'padding-right',
			'postfix' => 'px'
		) );

		$search_input_input_arg1 = $asea_specs['advanced_search_' . $ix . '_box_input_width'] + array(
				'value'             => $asea_config['advanced_search_' . $ix . '_box_input_width'],
				'input_group_class' => 'eckb-wizard-single-text',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-article-page-preview #asea_search_form',
					'style_name' => 'width',
					'postfix' => '%'
				)

			);
		$search_input_input_arg2 = $asea_specs['advanced_search_' . $ix . '_input_border_width'] + array(
				'value' => $asea_config['advanced_search_' . $ix . '_input_border_width'],
				'input_group_class' => 'eckb-wizard-single-text',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-article-page-preview .asea-search-box',
					'style_name' => 'border-width',
					'postfix' => 'px'
				)
			);
		$search_input_input_arg3 = $asea_specs['advanced_search_' . $ix . '_input_box_radius'] + array(
				'value'             => $asea_config['advanced_search_' . $ix . '_input_box_radius'],
				'input_group_class' => 'eckb-wizard-single-text',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-article-page-preview .asea-search-box',
					'style_name' => 'border-radius',
					'postfix' => 'px'
				)

			);
		$search_input_input_arg4 = $asea_specs['advanced_search_' . $ix . '_input_box_font_size'] + array(
				'value'             => $asea_config['advanced_search_' . $ix . '_input_box_font_size'],
				'input_group_class' => 'eckb-wizard-single-text',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2',
				'data' => array(
					'target_selector' => '.epkb-wizard-search-article-page-preview .asea-search-box',
					'style_name' => 'font-size',
					'postfix' => 'px'
				)

			);

		// Search Input  ---------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Search Input', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_input_width_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Search Box Input', 'echo-advanced-search' )
					),
					array( $search_input_input_arg1, $search_input_input_arg2, $search_input_input_arg3, $search_input_input_arg4 )
				),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_input_padding_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding ( px )', 'echo-advanced-search' )
					),
					array( $arg1_search_input_padding_shadow, $arg2_search_input_padding_shadow ,$arg3_search_input_padding_shadow, $arg4_search_input_padding_shadow )
				),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_input_box_shadow_position_group',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Box Shadow Position', 'echo-advanced-search' ),
						'data' => array(
							'preview' => 1
						)
					),
					array( $arg1_search_input_box_shadow, $arg2_search_input_box_shadow ,$arg3_search_input_box_shadow, $arg4_search_input_box_shadow )
				),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_input_box_shadow_rgba'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_input_box_shadow_rgba'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'4' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_input_box_search_icon_placement'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_input_box_search_icon_placement'],
						'current' => $asea_config['advanced_search_' . $ix . '_input_box_search_icon_placement'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					)),
				'5' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_input_box_loading_icon_placement'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_input_box_loading_icon_placement'],
						'current' => $asea_config['advanced_search_' . $ix . '_input_box_loading_icon_placement'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					)),
			)
		));

		// Description Below Search Input -------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Description Below Search Input', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends'        => array(
				'hide_when' => array(
					'advanced_search_' . $ix . '_description_below_input' => '',
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_description_below_input_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_description_below_input_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector' => '.epkb-wizard-search-article-page-preview #asea-search-description-2',
							'style_name' => 'font-size',
							'postfix' => 'px'
						)
					) ),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_input_padding',
						'input_group_class' => 'eckb-wizard-multiple-number-group',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => __( 'Padding( px )', 'echo-advanced-search' )
					),
					array( $arg1_search_description_below_input_padding_vertical, $arg2_search_description_below_input_padding_vertical )
				),
			)
		));

		// Search Results -----------------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Search Results', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(
				'0' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_filter_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_filter_toggle'],
						'id'                => 'advanced_search_' . $ix . '_filter_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
//							'example_image'     =>      '[asea]search-wizard/filter.png'
							'example_image'     =>      '[asea]search-wizard/wizard-screenshot-no-image-available.jpg'
						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_' . $ix . '_auto_complete_wait'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_auto_complete_wait'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/search-results-auto-complete.jpg'
						)
					) ),
				'2' => $form->text( $asea_specs['advanced_search_' . $ix . '_results_list_size'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_results_list_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/size-of-search-results-list.jpg'
						)
					) ),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_results_page_size'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_results_page_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/size-of-search-results-page.jpg'
						)
					) ),
				'4' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_show_top_category'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_show_top_category'],
						'id'                => 'advanced_search_' . $ix . '_show_top_category',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/show-category.jpg'
						)
					) ),
				'5' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_box_results_style'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_box_results_style'],
						'id'                => 'advanced_search_' . $ix . '_box_results_style',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'example_image'     =>      '[asea]search-wizard/wizard-screenshot-no-image-available.jpg'
						)
					) ),
				'6' => $form->text( $asea_specs['advanced_search_' . $ix . '_search_results_article_font_size'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_search_results_article_font_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
//							'example_image'     =>      '[asea]search-wizard/search-result-font-size.png'
							'example_image'     =>      '[asea]search-wizard/wizard-screenshot-no-image-available.jpg'
						)
					) ),
				//Dropdown Width settings
				'7' => $form->text( $asea_specs['advanced_search_' . $ix . '_filter_dropdown_width'] + array(
					'value'             => $asea_config['advanced_search_' . $ix . '_filter_dropdown_width'],
					'input_group_class' => 'eckb-wizard-single-text',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-4',
					'data' => array(
						//'example_image'     =>      '[asea]search-wizard/search-results-dropdown-width.jpg',
						'style_name' => 'width',
						'postfix' => 'px'
					)
				) ),
			
				//Category Level settings
				'8' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_filter_category_level'] + array(
					'value' => $asea_config['advanced_search_' . $ix . '_filter_category_level'],
					'current' => $asea_config['advanced_search_' . $ix . '_filter_category_level'],
					'input_group_class' => 'eckb-wizard-single-dropdown',
					'label_class'       => 'config-col-5',
					'input_class'       => 'config-col-4',
					'data' => array(
						//'example_image'     =>      '[asea]search-wizard/search-results-category-level.jpg',
					)
				)),

			)
		));

		//Background Image -------------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Background Image', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_image_url'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_image_url'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-12',
						'input_class'       => 'config-col-12',
						'data' => array(
							'preview'     =>      1,
						)
					) ),
				'1' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_image_position_x'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_image_position_x'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_image_position_x'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-article-page-preview #asea-search-background-image-1',
							'style_name' => 'background-position-x',
						)
					)),
				'2' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_image_position_y'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_image_position_y'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_image_position_y'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-article-page-preview #asea-search-background-image-1',
							'style_name' => 'background-position-y',
						)
					)),


			)
		));
		//Background Pattern Image -----------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Background Pattern Image', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_url'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_pattern_image_url'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-12',
						'input_class'       => 'config-col-12',
						'data' => array(
							'preview'     =>     1
						)
					) ),
				'1' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_position_x'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_x'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_x'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-article-page-preview #asea-search-pattern-1',
							'style_name' => 'background-position-x',
						)
					)),
				'2' => $form->dropdown( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_position_y'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_y'],
						'current' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_position_y'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-article-page-preview #asea-search-pattern-1',
							'style_name' => 'background-position-y',
						)
					)),
				'3' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_pattern_image_opacity'] + array(
						'value' => $asea_config['advanced_search_' . $ix . '_background_pattern_image_opacity'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-2',
						'data' => array(
							'target_selector'     =>      '.epkb-wizard-search-article-page-preview #asea-search-pattern-1',
							'style_name' => 'opacity',
						)
					) ),


			)
		));
		//Background Gradient ----------------------------------------------/
		$form->option_group_wizard( $asea_specs, array(
			'option-heading' => __( 'Background Gradient', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-search eckb-wizard-accordion__body',
			'depends' => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Sidebar|Categories'
				)
			),
			'inputs' => array(

				'0' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_gradient_degree'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_gradient_degree'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_' . $ix . '_background_gradient_opacity'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_gradient_opacity'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->checkbox( $asea_specs['advanced_search_' . $ix . '_background_gradient_toggle'] + array(
						'value'             => $asea_config['advanced_search_' . $ix . '_background_gradient_toggle'],
						'id'                => 'advanced_search_' . $ix . '_background_gradient_toggle',
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'preview' => 1
						)
					) ),


			)
		));
	}

	/**
	 * Function will add to the first search page a class to make 3 col template from 2 col
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	public static function filter_main_page_class( $classes ) {
		$classes .= 'asea-active';
		return $classes;
	}
	
	/**
	 * Add presets as in the Themes wizard 
	 */
	public static function add_presets() { 
		$preset_names = ASEA_KB_Config_Styles::get_advanced_search_box_style_names();	?>
		<div class="epkb-wizard-color-preset-container">
			<ul>
				<li id="epkb-wc-preset-0" class="epkb-wcp-tab epkb-preset-button epkb-wcp-current-settings" data-colors="<?php echo ASEA_KB_Core::get_theme_data( 'current' ); ?>">
					<div class="epkb-wcp-current-settings__icon epkbfa epkbfa-cog"></div>
					<div class="epkb-wcp-current-settings__name"><?php _e( 'Current Theme', 'echo-knowledge-base' ); ?></div>
				</li>	<?php 
					$i = 1;
					
					foreach ( $preset_names as $preset_key => $preset_name ) { ?>
						<li id="epkb-wc-preset-<?php echo $i; ?>" class="epkb-wcp-tab epkb-preset-button" data-colors="<?php echo htmlspecialchars( json_encode( ASEA_KB_Config_Styles::get_advanced_search_box_style_set( array(), 'mp', $preset_key ) + ASEA_KB_Config_Styles::get_advanced_search_box_style_set( array(), 'ap', $preset_key ) ), ENT_QUOTES, 'UTF-8' ); ?>"><?php echo $preset_name; ?></li> <?php
					} ?>
				
			</ul>
		</div><?php 
	}

}