<?php

/**
 * Lists settings, default values and display of SIDEBAR layout.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ELAY_KB_Config_Layout_Sidebar {

    const LAYOUT_NAME = 'Sidebar'; // do NOT change
	const NO_LAYOUT_NAME = 'Article';
    const CATEGORY_LEVELS = 3;

    // styles available for this layout
    const LAYOUT_STYLE_1 = 'Basic';
    const LAYOUT_STYLE_2 = 'Boxed';
    const LAYOUT_STYLE_3 = 'Accordion';
    const Demo1          = 'Demo1';

    // search box styles available for this layout
    const SEARCH_BOX_LAYOUT_STYLE_1 = 'Basic';
    const SEARCH_BOX_LAYOUT_STYLE_2 = 'todo1';
    const SEARCH_BOX_LAYOUT_STYLE_3 = 'todo2';
    const SEARCH_BOX_LAYOUT_STYLE_4 = 'todo4';


    /**
     * Defines KB configuration for this theme.
     * ALL FIELDS ARE MANDATORY by default ( otherwise use 'mandatory' => 'false' )
     *
     * @return array with both basic and theme-specific configuration
     */
    public static function get_fields_specification() {


	    $default_style = self::get_style_2_set();
	    $default_color = self::color_reset_black_3();


        $config_specification = array(

            /******************************************************************************
             *
             *  Main or Article Page - Layout and Style
             *
             ******************************************************************************/

            /***  Main or Article Page -> General ***/

            'sidebar_side_bar_width' => array(
                'label'       => __( 'Sidebar Width ( % )', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_side_bar_width',
                'max'         => '35',
                'min'         => '15',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_side_bar_width']
            ),
            'sidebar_side_bar_height_mode' => array(
                'label'       => __( 'Height Mode', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_side_bar_height_mode',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'side_bar_no_height' => __( 'Variable', 'echo-elegant-layouts' ),
                    'side_bar_fixed_height' => __( 'Fixed (Scrollbar)', 'echo-elegant-layouts' ) ),
                'default'     => $default_style['sidebar_side_bar_height_mode']
            ),
            'sidebar_side_bar_height' => array(
                'label'       => __( 'Height ( px )', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_side_bar_height',
                'max'         => '1000',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_side_bar_height']
            ),
            'sidebar_scroll_bar' => array(
                'label'       => __( 'Scroll Bar style', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_scroll_bar',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'slim_scrollbar'    => _x( 'Slim','echo-elegant-layouts' ),
                    'default_scrollbar' => _x( 'Default', 'echo-elegant-layouts' ) ),
                'default'     => $default_style['sidebar_scroll_bar']
            ),
            'sidebar_section_font_size' => array(
                'label'       => __( 'Relative Text Size', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_font_size',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'section_xsmall_font' => _x( 'Extra Small', 'font size', 'echo-elegant-layouts' ),
                    'section_small_font' => _x( 'Small', 'font size', 'echo-elegant-layouts' ),
                    'section_medium_font' => _x( 'Medium', 'font size', 'echo-elegant-layouts' ),
                    'section_large_font' => _x( 'Large', 'font size', 'echo-elegant-layouts' ) ),
                'default'     => $default_style['sidebar_section_font_size']
            ),
            'sidebar_top_categories_collapsed' => array(
                        'label'       => __( 'Top Categories Collapsed', 'echo-elegant-layouts' ),
                        'name'        => 'sidebar_top_categories_collapsed',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => $default_style['sidebar_top_categories_collapsed']
                ),
            'sidebar_nof_articles_displayed' => array(
                'label'       => __( 'Number of Articles Listed', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_nof_articles_displayed',
                'max'         => '200',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_nof_articles_displayed'],
            ),
            'sidebar_show_articles_before_categories' => array(
                'label'       => __( 'Show Articles', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_show_articles_before_categories',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'on' => __( 'Before Categories', 'echo-elegant-layouts' ),
                    'off' => __( 'After Categories', 'echo-elegant-layouts' ),
                ),
                'default'     => $default_style['sidebar_show_articles_before_categories']
            ),
            'sidebar_expand_articles_icon' => array(
                'label'       => __( 'Icon to Expand/Collapse Articles', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_expand_articles_icon',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array( 'ep_font_icon_plus_box' => _x( 'Plus Box', 'icon type', 'echo-elegant-layouts' ),
                                        'ep_font_icon_plus' => _x( 'Plus Sign', 'icon type', 'echo-elegant-layouts' ),
                                        'ep_font_icon_right_arrow' => _x( 'Arrow Triangle', 'icon type', 'echo-elegant-layouts' ),
                                        'ep_font_icon_arrow_carrot_right' => _x( 'Arrow Caret', 'icon type', 'echo-elegant-layouts' ),
                                        'ep_font_icon_arrow_carrot_right_circle' => _x( 'Arrow Caret 2', 'icon type', 'echo-elegant-layouts' ),
                                        'ep_font_icon_folder_add' => _x( 'Folder', 'icon type', 'echo-elegant-layouts' ) ),
                'default'     => $default_style['sidebar_expand_articles_icon']
            ),

            /***  Main or Article Page -> Search Box ***/

            'sidebar_search_layout' => array(
                'label'       => __( 'Layout', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_layout',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'elay-search-form-1' => __( 'Rounded search button is on the right', 'echo-elegant-layouts' ),
                    'elay-search-form-4' => __( 'Squared search Button is on the right', 'echo-elegant-layouts' ),
                    'elay-search-form-2' => __( 'Search button is below', 'echo-elegant-layouts' ),
                    'elay-search-form-3' => __( 'No search button', 'echo-elegant-layouts' ),
                    'elay-search-form-0' => __( 'No search box', 'echo-elegant-layouts' )
                ),
                'default'     => $default_style['sidebar_search_layout']
            ),
			'sidebar_search_box_collapse_mode' => array(
		        'label'       => __( 'Collapse mode: Always Open', 'echo-elegant-layouts' ),
		        'name'        => 'sidebar_search_box_collapse_mode',
		        'type'        => ELAY_Input_Filter::CHECKBOX,
		        'default'     => $default_style['sidebar_search_box_collapse_mode']
	        ),
            'sidebar_search_input_border_width' => array(
                'label'       => __( 'Border (px)', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_input_border_width',
                'max'         => '10',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_input_border_width']
            ),
            'sidebar_search_box_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_padding_top',
                'max'         => '100',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_padding_top']
            ),
            'sidebar_search_box_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_padding_bottom',
                'max'         => '100',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_padding_bottom']
            ),
            'sidebar_search_box_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_padding_left']
            ),
            'sidebar_search_box_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_padding_right']
            ),
            'sidebar_search_box_margin_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_margin_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_margin_top']
            ),
            'sidebar_search_box_margin_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_margin_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_margin_bottom']
            ),
            'sidebar_search_box_input_width' => array(
                'label'       => __( 'Width (%)', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_input_width',
                'max'         => '100',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_search_box_input_width']
            ),
	        'sidebar_search_box_results_style' => array(
		        'label'       => __( 'Search Results: Match Article Colors', 'echo-elegant-layouts' ),
		        'name'        => 'sidebar_search_box_results_style',
		        'type'        => ELAY_Input_Filter::CHECKBOX,
		        'default'     => $default_style['sidebar_search_box_results_style']
	        ),


	        /***   Main or Article Page -> Articles Listed in Sub-Category ***/

            'sidebar_section_head_alignment' => array(
                'label'       => __( 'Head Text Alignment', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_alignment',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'left' => __( 'Left', 'echo-elegant-layouts' ),
                    'center' => __( 'Centered', 'echo-elegant-layouts' ),
                    'right' => __( 'Right', 'echo-elegant-layouts' )
                ),
                'default'     => $default_style['sidebar_section_head_alignment']
            ),
            'sidebar_section_head_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_padding_top',
                'max'         => '20',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_head_padding_top']
            ),
            'sidebar_section_head_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_padding_bottom',
                'max'         => '20',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_head_padding_bottom']
            ),
            'sidebar_section_head_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_padding_left',
                'max'         => '20',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_head_padding_left']
            ),
            'sidebar_section_head_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_padding_right',
                'max'         => '20',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_head_padding_right']
            ),
            'sidebar_section_desc_text_on' => array(
                'label'       => __( 'Description', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_desc_text_on',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => $default_style['sidebar_section_desc_text_on']
            ),
            'sidebar_section_border_radius' => array(
                'label'       => __( 'Radius', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_border_radius',
                'max'         => '30',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_border_radius']
            ),
            'sidebar_section_border_width' => array(
                'label'       => __( 'Width', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_border_width',
                'max'         => '10',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_border_width']
            ),
            'sidebar_section_box_shadow' => array(
                'label'       => __( 'Article List Shadow', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_box_shadow',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'no_shadow' => __( 'No Shadow', 'echo-elegant-layouts' ),
                    'section_light_shadow' => __( 'Light Shadow', 'echo-elegant-layouts' ),
                    'section_medium_shadow' => __( 'Medium Shadow', 'echo-elegant-layouts' ),
                    'section_bottom_shadow' => __( 'Bottom Shadow', 'echo-elegant-layouts' )
                ),
                'default'     => $default_style['sidebar_section_box_shadow']
            ),
            'sidebar_section_divider' => array(
                'label'       => __( 'Article List Divider', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_divider',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => $default_style['sidebar_section_divider']
            ),
            'sidebar_section_divider_thickness' => array(
                'label'       => __( 'Divider Thickness ( px )', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_divider_thickness',
                'max'         => '10',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_divider_thickness']
            ),
            'sidebar_section_box_height_mode' => array(
                'label'       => __( 'Height Mode', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_box_height_mode',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'section_no_height' => __( 'Variable', 'echo-elegant-layouts' ),
                    'section_min_height' => __( 'Minimum', 'echo-elegant-layouts' ),
                    'section_fixed_height' => __( 'Maximum', 'echo-elegant-layouts' )  ),
                'default'     => $default_style['sidebar_section_box_height_mode']
            ),
            'sidebar_section_body_height' => array(
                'label'       => __( 'Height ( px )', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_body_height',
                'max'         => '1000',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_body_height']
            ),
            'sidebar_section_body_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_body_padding_top',
                'max'         => '50',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_body_padding_top']
            ),
            'sidebar_section_body_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_body_padding_bottom',
                'max'         => '50',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_body_padding_bottom']
            ),
            'sidebar_section_body_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_body_padding_left',
                'max'         => '50',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_body_padding_left']
            ),
            'sidebar_section_body_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_body_padding_right',
                'max'         => '50',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_section_body_padding_right']
            ),
            'sidebar_article_underline' => array(
                'label'       => __( 'Article Underline Hover', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_underline',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => $default_style['sidebar_article_underline']
            ),
	        'sidebar_article_active_bold' => array(
		        'label'       => __( 'Article Active Bold', 'echo-elegant-layouts' ),
		        'name'        => 'sidebar_article_active_bold',
		        'type'        => ELAY_Input_Filter::CHECKBOX,
		        'default'     => $default_style['sidebar_article_active_bold']
	        ),
            'sidebar_article_list_margin' => array(
                'label'       => __( 'Indentation', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_list_margin',
                'max'         => '50',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_article_list_margin']
            ),
            'sidebar_article_list_spacing' => array(
                'label'       => __( 'Between', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_list_spacing',
                'max'         => '50',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => $default_style['sidebar_article_list_spacing']
            ),


            /******************************************************************************
             *
             *  Main or Article Page - All Colors Settings
             *
             ******************************************************************************/

            /***  Main or Article Page -> Colors -> General  ***/

            'sidebar_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_background_color' ]
            ),


            /***  Main or Article Page -> Colors -> Search Box  ***/

            'sidebar_search_title_font_color' => array(
                'label'       => __( 'Title', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_title_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_search_title_font_color' ]
            ),
            'sidebar_search_background_color' => array(
                'label'       => __( 'Search Background', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_search_background_color' ]
            ),
            'sidebar_search_text_input_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_text_input_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_search_text_input_background_color' ]
            ),
            'sidebar_search_text_input_border_color' => array(
                'label'       => __( 'Border', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_text_input_border_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_search_text_input_border_color' ]
            ),
            'sidebar_search_btn_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_btn_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_search_btn_background_color' ]
            ),
            'sidebar_search_btn_border_color' => array(
                'label'       => __( 'Border', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_btn_border_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_search_btn_border_color' ]
            ),


            /***  Main or Article Page -> Colors -> Articles Listed in Category Box ***/

            'sidebar_article_font_color' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_article_font_color' ]
            ),
            'sidebar_article_icon_color' => array(
                'label'       => __( 'Icon', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_icon_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_article_icon_color' ]
            ),
            'sidebar_article_active_font_color' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_active_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_article_active_font_color' ]
            ),
            'sidebar_article_active_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_article_active_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_article_active_background_color' ]
            ),
            'sidebar_section_head_font_color' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_head_font_color' ]
            ),
            'sidebar_section_head_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_head_background_color' ]
            ),
            'sidebar_section_head_description_font_color' => array(
                'label'       => __( 'Category Description', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_head_description_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_head_description_font_color' ]
            ),
            'sidebar_section_border_color' => array(
                'label'       => __( 'Border', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_border_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_border_color' ]
            ),
            'sidebar_section_divider_color' => array(
                'label'       => __( 'Article List Divider', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_divider_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_divider_color' ]
            ),
            'sidebar_section_category_font_color' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_category_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_category_font_color' ]
            ),
            'sidebar_section_category_icon_color' => array(
                'label'       => __( 'Icon', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_section_category_icon_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => $default_color[ 'sidebar_section_category_icon_color' ]
            ),


            /***  Main Page -> Text ***/

            'sidebar_main_page_intro_text' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_main_page_intro_text',
                'size'        => '500',
                'max'         => '4000',
                'min'         => '1',
                'mandatory'   => false,
                'type'        => ELAY_Input_Filter::WP_EDITOR,
                'default'     => __( '
                        <h2>Welcome to our Knowledge Base.</h2>
                        <h3 style="color: red;"><strong>To edit this welcome text go to the Text Wizard</strong></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. Sed nisi lacus sed viverra tellus in hac habitasse platea. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Eleifend donec pretium vulputate sapien nec. Neque aliquam vestibulum morbi blandit cursus risus. Ultrices dui sapien eget mi proin sed. Massa massa ultricies mi quis hendrerit dolor. Ullamcorper malesuada proin libero nunc consequat interdum varius sit. Risus feugiat in ante metus dictum at tempor. Massa sapien faucibus et molestie ac feugiat sed lectus vestibulum. Risus nullam eget felis eget nunc lobortis. Malesuada nunc vel risus commodo viverra. Amet commodo nulla facilisi nullam. Vel risus commodo viverra maecenas accumsan lacus vel facilisis volutpat. Urna condimentum mattis pellentesque id nibh. Aliquam purus sit amet luctus. Vestibulum lorem sed risus ultricies.</p>', 'echo-elegant-layouts' )
            ),

            /******************************************************************************
             *
             *  Main or Article Page -> Front-End Text
             *
             ******************************************************************************/

            'sidebar_search_title' => array(
                'label'       => __( 'Search Title', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_title',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'How Can We Help?', 'echo-elegant-layouts' )
            ),
            'sidebar_search_box_hint' => array(
                'label'       => __( 'Search Hint', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_box_hint',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Search the documentation...', 'echo-elegant-layouts' )
            ),
            'sidebar_search_button_name' => array(
                'label'       => __( 'Search Button Name', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_button_name',
                'size'        => '25',
                'max'         => '50',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Search', 'echo-elegant-layouts' )
            ),
            'sidebar_search_results_msg' => array(
                'label'       => __( 'Search Results Message', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_search_results_msg',
                'size'        => '60',
                'max'         => '150',
                'mandatory' => false,
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Search Results for', 'echo-elegant-layouts' )
            ),
            'sidebar_no_results_found' => array(
                'label'       => __( 'No Matches Found Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_no_results_found',
                'size'        => '80',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'No matches found', 'echo-elegant-layouts' )
            ),
            'sidebar_min_search_word_size_msg' => array(
                'label'       => __( 'Minimum Search Word Size Message', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_min_search_word_size_msg',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Enter a word with at least one character.', 'echo-elegant-layouts' )
            ),
            'sidebar_category_empty_msg' => array(
                'label'       => __( 'Empty Category Notice', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_category_empty_msg',
                'size'        => '60',
                'max'         => '150',
                'mandatory' => false,
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Articles coming soon', 'echo-elegant-layouts' )
            ),
            'sidebar_collapse_articles_msg' => array(
                'label'       => __( 'Collapse Articles Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_collapse_articles_msg',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Collapse Articles', 'echo-elegant-layouts' )
            ),
            'sidebar_show_all_articles_msg' => array(
                'label'       => __( 'Show All Articles Text', 'echo-elegant-layouts' ),
                'name'        => 'sidebar_show_all_articles_msg',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Show all articles', 'echo-elegant-layouts' )
            )
        );

        return $config_specification;
    }

    /**
     * Return HTML for settings controlling the Layout style
     *
     * @param $kb_page_layout
     * @param $kb_config
     * @return String $kb_main_page_layout
     */
    public static function get_kb_config_style( $kb_page_layout, $kb_config ) {

        if ( $kb_page_layout != self::LAYOUT_NAME ) {
            return $kb_page_layout;
        }

        $add_on_kb_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_config['id'] );
        if ( is_wp_error( $add_on_kb_config ) ) {
            ELAY_Utilities::ajax_show_error_die( 'Could not retrieve Elegant Layout configuration (y43).' );
        }

        $kb_config = array_merge($add_on_kb_config, $kb_config);
        $feature_specs = ELAY_KB_Config_Specs::get_fields_specification();
        $form = new ELAY_KB_Config_Elements();

        //Arg1 / Arg2  for text_and_select_fields_horizontal
        $arg1 = $feature_specs['sidebar_section_body_height'] + array( 'value' => $kb_config['sidebar_section_body_height'], 'current' => $kb_config['sidebar_section_body_height'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12' );
        $arg2 = $feature_specs['sidebar_section_box_height_mode'] + array( 'value' => $kb_config['sidebar_section_box_height_mode'], 'current'  => $kb_config['sidebar_section_box_height_mode'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12' );

        //Advanced Settings
        $arg1_search_box_padding_vertical   = $feature_specs['sidebar_search_box_padding_top'] + array( 'value' => $kb_config['sidebar_search_box_padding_top'], 'current' => $kb_config['sidebar_search_box_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_search_box_padding_vertical   = $feature_specs['sidebar_search_box_padding_bottom'] + array( 'value' => $kb_config['sidebar_search_box_padding_bottom'], 'current' => $kb_config['sidebar_search_box_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_search_box_padding_horizontal = $feature_specs['sidebar_search_box_padding_left'] + array( 'value' => $kb_config['sidebar_search_box_padding_left'], 'current' => $kb_config['sidebar_search_box_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_search_box_padding_horizontal = $feature_specs['sidebar_search_box_padding_right'] + array( 'value' => $kb_config['sidebar_search_box_padding_right'], 'current' => $kb_config['sidebar_search_box_padding_right'], 'text_class' => 'config-col-6' );
        $arg1_search_box_margin_vertical = $feature_specs['sidebar_search_box_margin_top'] + array( 'value' => $kb_config['sidebar_search_box_margin_top'], 'current' => $kb_config['sidebar_search_box_margin_top'], 'text_class' => 'config-col-6' );
        $arg2_search_box_margin_vertical = $feature_specs['sidebar_search_box_margin_bottom'] + array( 'value' => $kb_config['sidebar_search_box_margin_bottom'], 'current' => $kb_config['sidebar_search_box_margin_bottom'], 'text_class' => 'config-col-6' );

        $arg1_box_border = $feature_specs['sidebar_section_border_radius'] + array( 'value' => $kb_config['sidebar_section_border_radius'], 'current' => $kb_config['sidebar_section_border_radius'], 'text_class' => 'config-col-6' );
        $arg2_box_border = $feature_specs['sidebar_section_border_width'] + array( 'value' => $kb_config['sidebar_section_border_width'], 'current' => $kb_config['sidebar_section_border_width'], 'text_class' => 'config-col-6' );

	    $arg1_section_head_padding_vertical = $feature_specs['sidebar_section_head_padding_top'] + array( 'value' => $kb_config['sidebar_section_head_padding_top'], 'current' => $kb_config['sidebar_section_head_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_head_padding_vertical = $feature_specs['sidebar_section_head_padding_bottom'] + array( 'value' => $kb_config['sidebar_section_head_padding_bottom'], 'current' => $kb_config['sidebar_section_head_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_head_padding_horizontal = $feature_specs['sidebar_section_head_padding_left'] + array( 'value' => $kb_config['sidebar_section_head_padding_left'], 'current' => $kb_config['sidebar_section_head_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_head_padding_horizontal = $feature_specs['sidebar_section_head_padding_right'] + array( 'value' => $kb_config['sidebar_section_head_padding_right'], 'current' => $kb_config['sidebar_section_head_padding_right'], 'text_class' => 'config-col-6' );

        $arg1_section_body_padding_vertical = $feature_specs['sidebar_section_body_padding_top'] + array( 'value' => $kb_config['sidebar_section_body_padding_top'], 'current' => $kb_config['sidebar_section_body_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_body_padding_vertical = $feature_specs['sidebar_section_body_padding_bottom'] + array( 'value' => $kb_config['sidebar_section_body_padding_bottom'], 'current' => $kb_config['sidebar_section_body_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_body_padding_horizontal = $feature_specs['sidebar_section_body_padding_left'] + array( 'value' => $kb_config['sidebar_section_body_padding_left'], 'current' => $kb_config['sidebar_section_body_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_body_padding_horizontal = $feature_specs['sidebar_section_body_padding_right'] + array( 'value' => $kb_config['sidebar_section_body_padding_right'], 'current' => $kb_config['sidebar_section_body_padding_right'], 'text_class' => 'config-col-6' );

        $sidebar_height_arg1 = $feature_specs['sidebar_side_bar_height'] +  array( 'value' => $kb_config['sidebar_side_bar_height'], 'current' => $kb_config['sidebar_side_bar_height'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12' );
        $sidebar_height_arg2 = $feature_specs['sidebar_side_bar_height_mode'] + array( 'value'    => $kb_config['sidebar_side_bar_height_mode'], 'current'  => $kb_config['sidebar_side_bar_height_mode'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12' );

	    $search_input_input_arg1 = $feature_specs['sidebar_search_box_input_width'] + array(
			    'value'             => $kb_config['sidebar_search_box_input_width'],
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-6',
			    'input_class'       => 'config-col-2'

		    );
	    $search_input_input_arg2 = $feature_specs['sidebar_search_input_border_width'] + array(
			    'value' => $kb_config['sidebar_search_input_border_width'],
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-6',
			    'input_class'       => 'config-col-2'
		    );

	    $article_spacing_arg1 = $feature_specs['sidebar_article_list_margin'] +  array(
			    'value'             => $kb_config['sidebar_article_list_margin'],
			    'id'                => 'sidebar_article_list_margin',
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-5',
			    'input_class'       => 'config-col-3'
		    );
	    $article_spacing_arg2 = $feature_specs['sidebar_article_list_spacing'] +  array(
			    'value'             => $kb_config['sidebar_article_list_spacing'],
			    'id'                => 'sidebar_article_list_spacing',
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-5',
			    'input_class'       => 'config-col-3'
		    );

        // SEACH BOX - Layout
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Search Layout',
            'class'        => 'eckb-mm-mp-links-tuning-searchbox-layout eckb-mm-ap-links-tuning-searchbox-layout',
            'inputs' => array(
                '0' => $form->dropdown( $feature_specs['sidebar_search_layout'] + array(
                        'value' => $kb_config['sidebar_search_layout'],
                        'current' => $kb_config['sidebar_search_layout'],
                        'label_class' => 'config-col-3',
                        'input_class' => 'config-col-7'
                    ) )
            )
        ), $kb_page_layout);

        // SEACH BOX - Advanced Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Search Box - Advanced Style',
            'class'        => 'eckb-mm-mp-links-tuning-searchbox-advanced eckb-mm-ap-links-tuning-searchbox-advanced',
            'inputs' => array(

	            '0' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'sidebar_search_box_padding',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical, $arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
	            ),
	            '1' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'sidebar_search_box_margin',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Margin (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
	            ),
	            '2' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'sidebar_search_box_input_width_group',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Search Box Input', 'echo-elegant-layouts')
		            ),
		            array( $search_input_input_arg1, $search_input_input_arg2 )
	            ),
	            '3' => $form->checkbox( $feature_specs['sidebar_search_box_results_style'] + array(
			            'value'             => $kb_config['sidebar_search_box_results_style'],
			            'id'                => 'sidebar_search_box_results_style',
			            'input_group_class' => 'config-col-12',
			            'label_class'       => 'config-col-5',
			            'input_class'       => 'config-col-2'
		            ) ),
				'4' => $form->checkbox( $feature_specs['sidebar_search_box_collapse_mode'] + array(
			            'value'             => $kb_config['sidebar_search_box_collapse_mode'],
			            'id'                => 'sidebar_search_box_collapse_mode',
			            'input_group_class' => 'config-col-12',
			            'label_class'       => 'config-col-5',
			            'input_class'       => 'config-col-2'
		            ) ),

         )), $kb_page_layout);

        // CONTENT - Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Content - Style',
            'class'        => 'eckb-mm-mp-links-tuning-content-style eckb-mm-ap-links-tuning-content-style',
            'inputs' => array(
                '0' => $form->text( $feature_specs['sidebar_side_bar_width'] + array(
                        'value' => $kb_config['sidebar_side_bar_width'],
                        'current' => $kb_config['sidebar_side_bar_width'],
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-3',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-4'
                    ) ),
                '1' => $form->text_and_select_fields_horizontal( array(
                        'id'                => 'sidebar_height',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-5',
                        'label'             => __( 'Overall Sidebar Height', 'echo-elegant-layouts'),
                        'input_class'       => 'config-col-8',
                    )
                    , $sidebar_height_arg1, $sidebar_height_arg2 ),
                '2' => $form->dropdown( $feature_specs['sidebar_scroll_bar'] + array(
                        'value' => $kb_config['sidebar_scroll_bar'],
                        'current' => $kb_config['sidebar_scroll_bar'],
                        'input_group_class' => 'config-col-12',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-4'
                    ) ),
                '3' => $form->dropdown( $feature_specs['sidebar_section_font_size'] + array(
                        'value' => $kb_config['sidebar_section_font_size'],
                        'current' => $kb_config['sidebar_section_font_size'],
                        'input_group_class' => 'config-col-12',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-4'
                    ) ),
        )));

        // LIST OF ARTICLES - Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'List of Articles - Style',
            'class'        => 'eckb-mm-mp-links-tuning-listofarticles-style eckb-mm-ap-links-tuning-listofarticles-style',
            'inputs' => array(
                '0' => $form->text( $feature_specs['sidebar_nof_articles_displayed'] + array(
                        'value' => $kb_config['sidebar_nof_articles_displayed'],
                        'input_group_class' => 'config-col-12',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-2'
                    ) ),
                '1' => $form->radio_buttons_vertical( $feature_specs['sidebar_show_articles_before_categories'] + array(
                        'value'     => $kb_config['sidebar_show_articles_before_categories'],
                        'current'   => $kb_config['sidebar_show_articles_before_categories'],
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-8',
                        'radio_class'       => 'config-col-12'
                    ) ),
                '2' => $form->dropdown( $feature_specs['sidebar_expand_articles_icon'] + array(
                        'value' => $kb_config['sidebar_expand_articles_icon'],
                        'current' => $kb_config['sidebar_expand_articles_icon'],
                        'input_group_class' => 'config-col-12',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-4'
                    ) ),
                '3' => $form->text_and_select_fields_horizontal( array(
                        'id'                => 'list_height',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-5',
                        'label'             => __( 'Articles List Height', 'echo-elegant-layouts'),
                        'input_class'       => 'config-col-6',
                    ), $arg1, $arg2 )
            )
        ));

        // LIST OF ARTICLES - Advanced Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'List of Articles - Advanced Style',
            'class'        => 'eckb-mm-mp-links-tuning-listofarticles-advanced eckb-mm-ap-links-tuning-listofarticles-advanced',
            'inputs' => array(

	            '0' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'sidebar_article_group',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Article Spacing (px)', 'echo-elegant-layouts')
		            ),
		            array( $article_spacing_arg1, $article_spacing_arg2 )
	            ),

                '1' => $form->checkbox( $feature_specs['sidebar_article_underline'] + array(
                        'value' => $kb_config['sidebar_article_underline'],
                        'id'                => 'sidebar_article_underline',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                    ) ),
	            '2' => $form->checkbox( $feature_specs['sidebar_article_active_bold'] + array(
			            'value' => $kb_config['sidebar_article_active_bold'],
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
			            'label'             => __( 'Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_section_body_padding_vertical, $arg2_section_body_padding_vertical, $arg1_section_body_padding_horizontal, $arg2_section_body_padding_horizontal )
	            )
            )
        ));

        // CATEGORIES - Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Categories - Style',
            'class'        => 'eckb-mm-mp-links-tuning-categories-style eckb-mm-ap-links-tuning-categories-style',
            'inputs' => array(
				'0' => $form->checkbox( $feature_specs['sidebar_top_categories_collapsed'] + array(
                        'value'             => $kb_config['sidebar_top_categories_collapsed'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                    ) ),
                '1' => $form->checkbox( $feature_specs['sidebar_section_desc_text_on'] + array(
                        'value'             => $kb_config['sidebar_section_desc_text_on'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                    ) ),
                '2' => $form->dropdown( $feature_specs['sidebar_section_head_alignment'] + array(
                        'value' => $kb_config['sidebar_section_head_alignment'],
                        'current' => $kb_config['sidebar_section_head_alignment'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-3'
                        ) ),
                '3' => $form->checkbox( $feature_specs['sidebar_section_divider'] + array(
                        'value'             => $kb_config['sidebar_section_divider'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                        ) ),
                '4' => $form->text( $feature_specs['sidebar_section_divider_thickness'] + array(
                        'value'             => $kb_config['sidebar_section_divider_thickness'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                    ) ),
            )
        ));

        // CATEGORIES - Advanced Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Categories - Advanced Style',
            'class'        => 'eckb-mm-mp-links-tuning-categories-advanced eckb-mm-ap-links-tuning-categories-advanced',
            'inputs' => array(
	            '0' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'sidebar_section_head_padding_group',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_section_head_padding_vertical, $arg2_section_head_padding_vertical, $arg1_section_head_padding_horizontal, $arg2_section_head_padding_horizontal  )
	            ),
                '1' => $form->dropdown( $feature_specs['sidebar_section_box_shadow'] + array(
                        'value' => $kb_config['sidebar_section_box_shadow'],
                        'current' => $kb_config['sidebar_section_box_shadow'],
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
			            'label'             => __( 'Box Border (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_box_border, $arg2_box_border )
	            )
            )
        ));

        // TUNING - TEXT
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Text',
            'class'        => 'eckb-mm-mp-links-tuning-content-text',
            'inputs' => array(
                '0' => $form->wp_editor(
                    array(
                        'id'                => 'sidebar_main_page_intro_text',
                        'value'             => $kb_config['sidebar_main_page_intro_text'],
                        'input_group_class' => '',
                        'main_label_class'  => '',
                        'input_class'       => '',
                        'label'             => __( 'Introductory Text for the Sidebar Main Page', 'echo-elegant-layouts')
                    ), true
                )
            )
        ));

        return $kb_page_layout;
    }

    /**
     * Return HTML for settings controlling the Layout colors
     *
     * @param $kb_page_layout
     * @param $kb_config
     * @return String $kb_main_page_layout
     */
    public static function get_kb_config_colors( $kb_page_layout, $kb_config ) {

        if ( $kb_page_layout != self::LAYOUT_NAME ) {
            return $kb_page_layout;
        }

        $feature_specs = ELAY_KB_Config_Specs::get_fields_specification();
        $add_on_kb_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_config['id'] );
        if ( is_wp_error( $add_on_kb_config ) ) {
            ELAY_Utilities::ajax_show_error_die( 'Could not retrieve Elegant Layout configuration (y44).' );
        }

        $kb_config = array_merge($add_on_kb_config, $kb_config);
        $form = new ELAY_KB_Config_Elements();


        $arg1_input_text_field = $feature_specs['sidebar_search_text_input_background_color'] + array( 'value' => $kb_config['sidebar_search_text_input_background_color'], 'current' => $kb_config['sidebar_search_text_input_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_input_text_field = $feature_specs['sidebar_search_text_input_border_color'] + array( 'value' => $kb_config['sidebar_search_text_input_border_color'], 'current' => $kb_config['sidebar_search_text_input_border_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg1_button = $feature_specs['sidebar_search_btn_background_color'] + array( 'value' => $kb_config['sidebar_search_btn_background_color'], 'current' => $kb_config['sidebar_search_btn_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_button = $feature_specs['sidebar_search_btn_border_color'] + array( 'value' => $kb_config['sidebar_search_btn_border_color'], 'current' => $kb_config['sidebar_search_btn_border_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

        $arg1_category_box_heading = $feature_specs['sidebar_section_head_font_color'] + array( 'value' => $kb_config['sidebar_section_head_font_color'], 'current' => $kb_config['sidebar_section_head_font_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_category_box_heading = $feature_specs['sidebar_section_head_background_color'] + array( 'value' => $kb_config['sidebar_section_head_background_color'], 'current' => $kb_config['sidebar_section_head_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

        $arg1_sub_category = $feature_specs['sidebar_section_category_font_color'] + array( 'value' => $kb_config['sidebar_section_category_font_color'], 'current' => $kb_config['sidebar_section_category_font_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_sub_category = $feature_specs['sidebar_section_category_icon_color'] + array( 'value' => $kb_config['sidebar_section_category_icon_color'], 'current' => $kb_config['sidebar_section_category_icon_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

        $arg1_articles = $feature_specs['sidebar_article_font_color'] + array( 'value' => $kb_config['sidebar_article_font_color'], 'current' => $kb_config['sidebar_article_font_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_articles = $feature_specs['sidebar_article_icon_color'] + array( 'value' => $kb_config['sidebar_article_icon_color'], 'current' => $kb_config['sidebar_article_icon_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

	    $arg1_active_articles = $feature_specs['sidebar_article_active_font_color'] + array( 'value' => $kb_config['sidebar_article_active_font_color'], 'current' => $kb_config['sidebar_article_active_font_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
	    $arg2_active_articles = $feature_specs['sidebar_article_active_background_color'] + array( 'value' => $kb_config['sidebar_article_active_background_color'], 'current' => $kb_config['sidebar_article_active_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );


	    // SEARCH BOX - Colors
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Search Box - Colors',
            'class'             => 'eckb-mm-mp-links-tuning-searchbox-colors eckb-mm-ap-links-tuning-searchbox-colors',
            'inputs' => array(
                '0' => $form->text( $feature_specs['sidebar_search_title_font_color'] + array(
                        'value' => $kb_config['sidebar_search_title_font_color'],
                        'input_group_class' => 'config-col-12',
                        'class'             => 'ekb-color-picker',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-8 ekb-color-picker'
                    ) ),
                '1' => $form->text( $feature_specs['sidebar_search_background_color'] + array(
                        'value' => $kb_config['sidebar_search_background_color'],
                        'input_group_class' => 'config-col-12',
                        'class'             => 'ekb-color-picker',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-8 ekb-color-picker'
                    ) ),
                '2' => $form->text_fields_horizontal( array(
                        'id'                => 'input_text_field',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker',
                        'label'             => __( 'Input Text Field', 'echo-elegant-layouts')
                ), $arg1_input_text_field, $arg2_input_text_field ),
                '3' => $form->text_fields_horizontal( array(
                        'id'                => 'button',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker',
                        'label'             => __( 'Button', 'echo-elegant-layouts')
                ), $arg1_button, $arg2_button ) )
        ), $kb_page_layout);

        // CONTENT - Colors
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Content - Colors',
            'class'             => 'eckb-mm-mp-links-tuning-content-colors eckb-mm-ap-links-tuning-content-colors',
            'inputs'            => array(
                '0' => $form->text( $feature_specs['sidebar_background_color'] + array(
                            'value'             => $kb_config['sidebar_background_color'],
                            'input_group_class' => 'config-col-12',
                            'class'             => 'ekb-color-picker',
                            'label_class'       => 'config-col-4',
                            'input_class'       => 'config-col-8 ekb-color-picker'
                        ) ) )
        ));

        // LIST OF ARTICLES - Colors
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'List of Articles - Colors',
            'class'             => 'eckb-mm-mp-links-tuning-listofarticles-colors eckb-mm-ap-links-tuning-listofarticles-colors',
            'inputs'            => array(
                '0' => $form->text_fields_horizontal( array(
                        'id'                => 'articles',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker',
                        'label'             => __( 'Articles', 'echo-elegant-layouts')
                ), $arg1_articles, $arg2_articles ),
	            '1' => $form->text_fields_horizontal( array(
		            'id'                => 'active_article',
		            'input_group_class' => 'config-col-12',
		            'main_label_class'  => 'config-col-4',
		            'input_class'       => 'config-col-7 ekb-color-picker',
		            'label'             => __( 'Active Article', 'echo-elegant-layouts')
	            ), $arg1_active_articles, $arg2_active_articles )
            )
        ));

        // CATEGORIES - Colors
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Categories - Colors',
            'class'             => 'eckb-mm-mp-links-tuning-categories-colors eckb-mm-ap-links-tuning-categories-colors',
            'inputs'            => array(
                '0' => $form->text_fields_horizontal( array(
                        'id'                => 'sub_category',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker',
                        'label'             => __( 'Sub-category', 'echo-elegant-layouts')
                ), $arg1_sub_category, $arg2_sub_category ),
				'1' => $form->text( $feature_specs['sidebar_section_divider_color'] + array(
                        'value' => $kb_config['sidebar_section_divider_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '2' => $form->text_fields_horizontal( array(
                        'id'                => 'category_box_heading',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker',
                        'label'             => __( 'Category Box Heading', 'echo-elegant-layouts')
                    ), $arg1_category_box_heading, $arg2_category_box_heading ),
                '3' => $form->text( $feature_specs['sidebar_section_head_description_font_color'] + array(
                        'value'             => $kb_config['sidebar_section_head_description_font_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '4' => $form->text( $feature_specs['sidebar_section_border_color'] + array(
                        'value' => $kb_config['sidebar_section_border_color'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
            )
        ));

        return $kb_page_layout;
    }

    /**
     * Return HTML for settings controlling the Layout Text
     *
     * @param $kb_page_layout
     * @param $kb_config
     * @return String $kb_page_layout
     */
    public static function get_kb_config_text( $kb_page_layout, $kb_config ) {

        if ( $kb_page_layout != self::LAYOUT_NAME ) {
            return $kb_page_layout;
        }

        $feature_specs = ELAY_KB_Config_Specs::get_fields_specification();
        $add_on_kb_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_config['id'] );
        if ( is_wp_error( $add_on_kb_config ) ) {
            ELAY_Utilities::ajax_show_error_die( 'Could not retrieve Elegant Layout configuration (y45).' );
        }

        $kb_config = array_merge($add_on_kb_config, $kb_config);
        $form = new ELAY_KB_Config_Elements();


        // SEARCH BOX - Text
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Search Box - Text',
            'class'        => 'eckb-mm-mp-links-alltext-text-searchbox eckb-mm-mp-links-tuning-searchbox-text eckb-mm-ap-links-alltext-text-searchbox eckb-mm-ap-links-tuning-searchbox-text',
            'inputs' => array(
                '0' => $form->text( $feature_specs['sidebar_search_title'] +
                    array( 'value' => $kb_config['sidebar_search_title'], 'current' => $kb_config['sidebar_search_title'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) ),
                '1' => $form->text( $feature_specs['sidebar_search_box_hint'] +
                    array( 'value' => $kb_config['sidebar_search_box_hint'], 'current' => $kb_config['sidebar_search_box_hint'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) ),
                '2' => $form->text( $feature_specs['sidebar_search_button_name'] +
                    array( 'value' => $kb_config['sidebar_search_button_name'], 'current' => $kb_config['sidebar_search_button_name'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
                '3' => $form->text( $feature_specs['sidebar_search_results_msg'] +
                    array( 'value' => $kb_config['sidebar_search_results_msg'], 'current' => $kb_config['sidebar_search_results_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
                '4' => $form->text( $feature_specs['sidebar_no_results_found'] +
                    array( 'value' => $kb_config['sidebar_no_results_found'], 'current' => $kb_config['sidebar_no_results_found'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) ),
                '5' => $form->text( $feature_specs['sidebar_min_search_word_size_msg'] +
                    array( 'value' => $kb_config['sidebar_min_search_word_size_msg'], 'current' => $kb_config['sidebar_min_search_word_size_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) )
            )
        ), $kb_page_layout);

        // Categories - Text
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Categories - Text',
            'class'             => 'eckb-mm-mp-links-alltext-text-categories eckb-mm-mp-links-tuning-categories-text eckb-mm-ap-links-alltext-text-categories eckb-mm-ap-links-tuning-categories-text',
            'inputs' => array(
                '0' => $form->text( $feature_specs['sidebar_category_empty_msg'] +
                    array( 'value' => $kb_config['sidebar_category_empty_msg'], 'current' => $kb_config['sidebar_category_empty_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
            )
        ));

        // Articles - Text
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Articles - Text',
            'class'             => 'eckb-mm-mp-links-alltext-text-articles eckb-mm-mp-links-tuning-listofarticles-text eckb-mm-ap-links-alltext-text-articles eckb-mm-ap-links-tuning-listofarticles-text',
            'inputs' => array(
                '1' => $form->text( $feature_specs['sidebar_collapse_articles_msg'] +
                    array( 'value' => $kb_config['sidebar_collapse_articles_msg'], 'current' => $kb_config['sidebar_collapse_articles_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
                '2' => $form->text( $feature_specs['sidebar_show_all_articles_msg']
                    + array( 'value' => $kb_config['sidebar_show_all_articles_msg'], 'current' => $kb_config['sidebar_show_all_articles_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) )
            )
        ));

        return $kb_page_layout;
    }

    /**
     * Return colors set based on selected layout and colors
     *
     * @param $colors_set
     * @param $layout_name
     * @param $set_name
     *
     * @return array
     */
    public static function get_colors_set( $colors_set, $layout_name, $set_name ) {

        if ( $layout_name != self::LAYOUT_NAME ) {
            return $colors_set;
        }

        switch( $set_name ) {
	        case 'demo_1':
		        return self::color_demo_1();
		        break;
            case 'black-white1':
                return self::color_reset_black_1();
                break;
            case 'black-white2':
                return self::color_reset_black_2();
                break;
            case 'black-white3':
                return self::color_reset_black_3();
                break;
            case 'black-white4':
                return self::color_reset_black_4();
                break;
            case 'blue1':
                return self::color_reset_blue_1();
                break;
            case 'blue2':
                return self::color_reset_blue_2();
                break;
            case 'blue3':
                return self::color_reset_blue_3();
                break;
            case 'blue4':
                return self::color_reset_blue_4();
                break;
            case 'green1':
                return self::color_reset_green_1();
                break;
            case 'green2':
                return self::color_reset_green_2();
                break;
            case 'green3':
                return self::color_reset_green_3();
                break;
            case 'green4':
                return self::color_reset_green_4();
                break;
            case 'red1':
                return self::color_reset_red_1();
                break;
            case 'red2':
                return self::color_reset_red_2();
                break;
            case 'red3':
                return self::color_reset_red_3();
                break;
            case 'red4':
                return self::color_reset_red_4();
                break;
            default:
                return self::color_reset_black_3();
                break;
        }
    }
	private static function color_demo_1() {

		//Note: Comments beside value are from Basic color resets.
		return array( //Orange f7941d

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'                      =>  '#fbfbfb', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#212121', //search_title_font_color
			'sidebar_search_background_color'               =>  '#f7941d', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#40474f', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#459fed', //article_font_color
			'sidebar_article_icon_color'                    =>  '#f7941d', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#f7941d',
			'sidebar_article_active_background_color'       =>  '#fbfbfb',
			'sidebar_section_head_font_color'               =>  '#212121', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#fbfbfb', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#B3B3B3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#DBDBDB', //section_border_color
			'sidebar_section_divider_color'                 =>  '#DADADA', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#212121', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#212121', //section_category_icon_color

		);
	}

	private static function color_reset_black_1() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#686868', //search_title_font_color
			'sidebar_search_background_color'               =>  '#FBFBFB', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#B3B3B3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#B3B3B3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#525252', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#FFFFFF', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#B3B3B3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#DBDBDB', //section_border_color
			'sidebar_section_divider_color'                 =>  '#DADADA', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_black_2() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#000000', //search_title_font_color
			'sidebar_search_background_color'               =>  '#F7F7F7', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#CCCCCC', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#B3B3B3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#B3B3B3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#8D8B8D', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#F7F7F7', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#b3b3b3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#F7F7F7', //section_border_color
			'sidebar_section_divider_color'                 =>  '#CDCDCD', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_black_3() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#fdfdfd', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#686868', //search_title_font_color
			'sidebar_search_background_color'               =>  '#F1F1F1', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#525252', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#525252', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#f1f1f1', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#b3b3b3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#F7F7F7', //section_border_color
			'sidebar_section_divider_color'                 =>  '#CDCDCD', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_black_4() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#000000', //search_title_font_color
			'sidebar_search_background_color'               =>  '#e0e0e0', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#000000', //article_font_color
			'sidebar_article_icon_color'                    =>  '#525252', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#7d7d7d', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#b3b3b3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#7d7d7d', //section_border_color
			'sidebar_section_divider_color'                 =>  '#FFFFFF', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#000000', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}

	private static function color_reset_red_1() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#fb8787', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#af1e1e', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#fb8787', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#FFFFFF', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#b3b3b3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#c5c5c5', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_red_2() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#CC0000', //search_title_font_color
			'sidebar_search_background_color'               =>  '#f9e5e5', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#CC0000', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#f9e5e5', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#e57f7f', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#F7F7F7', //section_border_color
			'sidebar_section_divider_color'                 =>  '#CDCDCD', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_red_3() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#CC0000', //search_title_font_color
			'sidebar_search_background_color'               =>  '#f4c6c6', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#CC0000', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#f4c6c6', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#e57f7f', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#F7F7F7', //section_border_color
			'sidebar_section_divider_color'                 =>  '#CDCDCD', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_red_4() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#ffffff', //search_title_font_color
			'sidebar_search_background_color'               =>  '#fb6262', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#fb6262', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#F7F7F7', //section_border_color
			'sidebar_section_divider_color'                 =>  '#CDCDCD', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}

	private static function color_reset_blue_1() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#ffffff', //search_title_font_color
			'sidebar_search_background_color'               =>  '#53ccfb', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#3093ba', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#53ccfb', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#ffffff', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#b3b3b3', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#c5c5c5', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_blue_2() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#ffffff', //search_title_font_color
			'sidebar_search_background_color'               =>  '#53ccfb', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#3093ba', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#53ccfb', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#FFFFFF', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_blue_3() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#11b3f2', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#3093ba', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#11b3f2', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#376491', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_blue_4() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#4398ba', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#FFFFFF', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#F1F1F1', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#4398ba', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#F7F7F7', //section_border_color
			'sidebar_section_divider_color'                 =>  '#CDCDCD', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}

	private static function color_reset_green_1() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#bfdac1', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#4a714e', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#4a714e', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#ffffff', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#bfdac1', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#c5c5c5', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_green_2() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#9cb99f', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#4a714e', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#9cb99f', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#c5c5c5', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_green_3() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#769679', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#4a714e', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#769679', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#c5c5c5', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}
	private static function color_reset_green_4() {

    	//Note: Comments beside value are from Basic color resets.
		return array(

			//Main or Article Page - All Colors Settings
			'sidebar_background_color'              =>  '#FFFFFF', //section_body_background_color

			//Main or Article Page -> Colors -> Search Box
			'sidebar_search_title_font_color'               =>  '#FFFFFF', //search_title_font_color
			'sidebar_search_background_color'               =>  '#628365', //search_background_color
			'sidebar_search_text_input_background_color'    =>  '#FFFFFF', //search_text_input_background_color
			'sidebar_search_text_input_border_color'        =>  '#DDDDDD', //search_text_input_border_color
			'sidebar_search_btn_background_color'           =>  '#686868', //search_btn_background_color
			'sidebar_search_btn_border_color'               =>  '#DDDDDD', //search_btn_border_color

			//Main or Article Page -> Colors -> Articles Listed in Category Box
			'sidebar_article_font_color'                    =>  '#b3b3b3', //article_font_color
			'sidebar_article_icon_color'                    =>  '#b3b3b3', //article_icon_color
			'sidebar_article_active_font_color'             =>  '#000000',
			'sidebar_article_active_background_color'       =>  '#e8e8e8',
			'sidebar_section_head_font_color'               =>  '#ffffff', //section_head_font_color
			'sidebar_section_head_background_color'         =>  '#628365', //section_head_background_color
			'sidebar_section_head_description_font_color'   =>  '#ffffff', //section_head_description_font_color
			'sidebar_section_border_color'                  =>  '#dbdbdb', //section_border_color
			'sidebar_section_divider_color'                 =>  '#c5c5c5', //section_divider_color
			'sidebar_section_category_font_color'           =>  '#868686', //section_category_font_color
			'sidebar_section_category_icon_color'           =>  '#868686', //section_category_icon_color

		);
	}

    /**
     * Return Style set based on selected layout
     *
     * @param $style_set
     * @param $layout_name
     * @param $set_name
     *
     * @return array
     */
    public static function get_style_set( $style_set, $layout_name, $set_name ) {

        if ( $layout_name != self::LAYOUT_NAME ) {
            return $style_set;
        }

        switch( $set_name) {
	        case self::Demo1:
		        return self::demo_1_set();
            case self::LAYOUT_STYLE_2:
                return self::get_style_2_set();
                break;
            case self::LAYOUT_STYLE_3:
                return self::get_style_3_set();
                break;
            case self::LAYOUT_STYLE_1:
            default:
                return self::get_style_1_set();
                break;
        }
    }
	private static function demo_1_set() {//Basic
		return array(
			//General
			'sidebar_side_bar_width'                =>  '25',
			'sidebar_section_font_size'             =>  'section_medium_font',
			'sidebar_nof_articles_displayed'        =>  15,
            'sidebar_show_articles_before_categories' => 'off',
            'sidebar_expand_articles_icon'          =>  'ep_font_icon_arrow_carrot_right',
			'sidebar_section_body_height'           =>  350,
			'sidebar_section_box_height_mode'       =>  'section_no_height',

			//Search Box
			'sidebar_search_layout'                 =>  'elay-search-form-1',
			'sidebar_search_input_border_width'     =>  1,
			'sidebar_search_box_padding_top'        =>  50,
			'sidebar_search_box_padding_bottom'     =>  50,
			'sidebar_search_box_margin_bottom'      =>  0,

			//Advanced Configuration

			// - Section
			'sidebar_section_box_shadow'            =>  'no_shadow',
			'sidebar_section_border_width'          =>  '0',
			'sidebar_section_border_radius'         =>  '0',

			// - Section Head
			'sidebar_section_head_alignment'        =>  'left',
			'sidebar_section_divider'               =>  'off',
			'sidebar_section_divider_thickness'     =>  1,
			'sidebar_section_head_padding_top'      =>  8,
			'sidebar_section_head_padding_bottom'   =>  8,
			'sidebar_section_head_padding_left'     =>  8,
			'sidebar_section_head_padding_right'    =>  0,

			// - Section Body
			'sidebar_article_list_margin'           =>  10,
			'sidebar_article_list_spacing'          =>  5,
			'sidebar_article_underline'     =>  'off',
			'sidebar_section_body_padding_top'      =>  0,
			'sidebar_section_body_padding_bottom'   =>  0,
			'sidebar_section_body_padding_left'     =>  0,
			'sidebar_section_body_padding_right'    =>  5,

			//Features
			/*    'back_navigation_toggle'         => 'on',
				'back_navigation_mode'           => 'navigate_browser_back',
				'back_navigation_text_color'     => '#666666',
				'back_navigation_bg_color'       => '#ffffff',
				'back_navigation_border_color'   => '#dcdcdc',
				'back_navigation_font_size'      => '16',
				'back_navigation_border'         => 'solid',
				'back_navigation_border_radius'  => '3',
				'back_navigation_border_width'   => '1',
				'back_navigation_margin_top'     => '4',
				'back_navigation_margin_bottom'  => '4',
				'back_navigation_margin_left'    => '4',
				'back_navigation_margin_right'   => '4',
				'back_navigation_padding_top'    => '4',
				'back_navigation_padding_bottom' => '4',
				'back_navigation_padding_left'   => '4',
				'back_navigation_padding_right'  => '4',  */

		);
	}

    private static function get_style_1_set() {//Basic
        return array(
            //General
            'sidebar_side_bar_width'                =>  '25',
            'sidebar_section_font_size'             =>  'section_medium_font',
            'sidebar_nof_articles_displayed'        =>  15,
            'sidebar_show_articles_before_categories' => 'off',
            'sidebar_expand_articles_icon'          =>  'ep_font_icon_arrow_carrot_right',
            'sidebar_section_body_height'           =>  350,
            'sidebar_section_box_height_mode'       =>  'section_no_height',

            //Search Box
            'sidebar_search_layout'                 =>  'elay-search-form-1',
            'sidebar_search_input_border_width'     =>  1,
            'sidebar_search_box_padding_top'        =>  50,
            'sidebar_search_box_padding_bottom'     =>  50,

            //Advanced Configuration

            // - Section
            'sidebar_section_box_shadow'            =>  'no_shadow',
            'sidebar_section_border_width'          =>  '0',
            'sidebar_section_border_radius'         =>  '0',

            // - Section Head
            'sidebar_section_head_alignment'        =>  'left',
            'sidebar_section_divider'               =>  'off',
            'sidebar_section_divider_thickness'     =>  1,
            'sidebar_section_head_padding_top'      =>  8,
            'sidebar_section_head_padding_bottom'   =>  8,
            'sidebar_section_head_padding_left'     =>  8,
            'sidebar_section_head_padding_right'    =>  0,

            // - Section Body
            'sidebar_article_list_margin'           =>  20,
            'sidebar_article_list_spacing'          =>  8,
            'sidebar_article_underline'     =>  'off',
            'sidebar_section_body_padding_top'      =>  0,
            'sidebar_section_body_padding_bottom'   =>  0,
            'sidebar_section_body_padding_left'     =>  0,
            'sidebar_section_body_padding_right'    =>  5,

	        //Features
	    /*    'back_navigation_toggle'         => 'on',
	        'back_navigation_mode'           => 'navigate_browser_back',
	        'back_navigation_text_color'     => '#666666',
	        'back_navigation_bg_color'       => '#ffffff',
	        'back_navigation_border_color'   => '#dcdcdc',
	        'back_navigation_font_size'      => '16',
	        'back_navigation_border'         => 'solid',
	        'back_navigation_border_radius'  => '3',
	        'back_navigation_border_width'   => '1',
	        'back_navigation_margin_top'     => '4',
	        'back_navigation_margin_bottom'  => '4',
	        'back_navigation_margin_left'    => '4',
	        'back_navigation_margin_right'   => '4',
	        'back_navigation_padding_top'    => '4',
	        'back_navigation_padding_bottom' => '4',
	        'back_navigation_padding_left'   => '4',
	        'back_navigation_padding_right'  => '4',  */

        );
    }

    private static function get_style_2_set() {//Boxed
        return array(

            //Main or Article Page -> General
            'sidebar_side_bar_width'                =>  '25',
            'sidebar_side_bar_height_mode'          => 'side_bar_no_height',
            'sidebar_side_bar_height'               => '350',
            'sidebar_scroll_bar'                    => 'slim_scrollbar',
	        'sidebar_section_font_size'             =>  'section_medium_font',
	        'sidebar_top_categories_collapsed'      =>  'off',
	        'sidebar_nof_articles_displayed'        =>  15,
            'sidebar_show_articles_before_categories' => 'off',
	        'sidebar_expand_articles_icon'          =>  'ep_font_icon_arrow_carrot_right',

            //Main or Article Page -> Search Box
	        'sidebar_search_layout'                 =>  'elay-search-form-1',
	        'sidebar_search_input_border_width'     =>  1,
	        'sidebar_search_box_padding_top'        =>  50,
	        'sidebar_search_box_padding_bottom'     =>  50,
	        'sidebar_search_box_padding_left'       =>  0,
	        'sidebar_search_box_padding_right'      =>  0,
	        'sidebar_search_box_margin_top'         =>  0,
	        'sidebar_search_box_margin_bottom'      =>  40,
	        'sidebar_search_box_input_width'        =>  50,
	        'sidebar_search_box_results_style'      =>  'off',
			'sidebar_search_box_collapse_mode'   => 'off',

			//Main or Article Page -> Articles Listed in Sub-Category
	        'sidebar_section_head_alignment'        =>  'left',
	        'sidebar_section_head_padding_top'      =>  8,
	        'sidebar_section_head_padding_bottom'   =>  8,
	        'sidebar_section_head_padding_left'     =>  8,
	        'sidebar_section_head_padding_right'    =>  8,
	        'sidebar_section_desc_text_on'          =>  'off',
	        'sidebar_section_border_radius'         =>  5,
	        'sidebar_section_border_width'          =>  1,
	        'sidebar_section_box_shadow'            =>  'section_medium_shadow',
	        'sidebar_section_divider'               =>  'on',
	        'sidebar_section_divider_thickness'     =>  1,
	        'sidebar_section_box_height_mode'       =>  'section_no_height',
	        'sidebar_section_body_height'           =>  350,
	        'sidebar_section_body_padding_top'      =>  8,
	        'sidebar_section_body_padding_bottom'   =>  10,
	        'sidebar_section_body_padding_left'     =>  0,
	        'sidebar_section_body_padding_right'    =>  5,
	        'sidebar_article_underline'             =>  'off',
	        'sidebar_article_active_bold'           =>  'on',
	        'sidebar_article_list_margin'           =>  10,
	        'sidebar_article_list_spacing'          =>  8,

            // - Section Body

	        //Features
	    /*    'back_navigation_toggle'         => 'on',
	        'back_navigation_mode'           => 'navigate_browser_back',
	        'back_navigation_text_color'     => '#666666',
	        'back_navigation_bg_color'       => '#ffffff',
	        'back_navigation_border_color'   => '#dcdcdc',
	        'back_navigation_font_size'      => '16',
	        'back_navigation_border'         => 'solid',
	        'back_navigation_border_radius'  => '3',
	        'back_navigation_border_width'   => '1',
	        'back_navigation_margin_top'     => '4',
	        'back_navigation_margin_bottom'  => '4',
	        'back_navigation_margin_left'    => '4',
	        'back_navigation_margin_right'   => '4',
	        'back_navigation_padding_top'    => '4',
	        'back_navigation_padding_bottom' => '4',
	        'back_navigation_padding_left'   => '4',
	        'back_navigation_padding_right'  => '4',   */
        );
    }

    //Not used
    private static function get_style_3_set() {//
        return array(
            //Articles Listed In Category Box
            //General
            'sidebar_side_bar_width'                =>  '25',
            'sidebar_section_font_size'             =>  'section_medium_font',
            'sidebar_nof_articles_displayed'        =>  15,
            'sidebar_show_articles_before_categories' => 'off',
            'sidebar_expand_articles_icon'          =>  'ep_font_icon_arrow_carrot_right',
            'sidebar_section_body_height'           =>  350,
            'sidebar_section_box_height_mode'       =>  'section_no_height',
            'sidebar_top_categories_collapsed'      =>  'on',

            //Search Box
            'sidebar_search_layout'                 =>  'elay-search-form-1',
            'sidebar_search_input_border_width'     =>  1,
            'sidebar_search_box_padding_top'        =>  50,
            'sidebar_search_box_padding_bottom'     =>  50,

            //Advanced Configuration

            // - Section
            'sidebar_section_box_shadow'            =>  'section_medium_shadow',
            'sidebar_section_border_width'          =>  '1',
            'sidebar_section_border_radius'         =>  '5',

            // - Section Head
            'sidebar_section_head_alignment'        =>  'left',
            'sidebar_section_divider'               =>  'on',
            'sidebar_section_divider_thickness'     =>  1,
            'sidebar_section_head_padding_top'      =>  8,
            'sidebar_section_head_padding_bottom'   =>  8,
            'sidebar_section_head_padding_left'     =>  8,
            'sidebar_section_head_padding_right'    =>  0,

            // - Section Body
            'sidebar_article_list_margin'           =>  10,
            'sidebar_article_list_spacing'          =>  8,
            'sidebar_article_underline'     =>  'off',
            'sidebar_section_body_padding_top'      =>  8,
            'sidebar_section_body_padding_bottom'   =>  10,
            'sidebar_section_body_padding_left'     =>  0,
            'sidebar_section_body_padding_right'    =>  5,

	        //Features
	    /*    'back_navigation_toggle'         => 'on',
	        'back_navigation_mode'           => 'navigate_browser_back',
	        'back_navigation_text_color'     => '#666666',
	        'back_navigation_bg_color'       => '#ffffff',
	        'back_navigation_border_color'   => '#dcdcdc',
	        'back_navigation_font_size'      => '16',
	        'back_navigation_border'         => 'solid',
	        'back_navigation_border_radius'  => '3',
	        'back_navigation_border_width'   => '1',
	        'back_navigation_margin_top'     => '4',
	        'back_navigation_margin_bottom'  => '4',
	        'back_navigation_margin_left'    => '4',
	        'back_navigation_margin_right'   => '4',
	        'back_navigation_padding_top'    => '4',
	        'back_navigation_padding_bottom' => '4',
	        'back_navigation_padding_left'   => '4',
	        'back_navigation_padding_right'  => '4',   */
        );
    }

    /**
     * Return default values from given specification.
     * @param $config_specs
     * @return array
     */
    public static function get_specs_defaults( $config_specs ) {
        $default_configuration = array();
        foreach( $config_specs as $key => $spec ) {
            $default = isset($spec['default']) ? $spec['default'] : '';
            $default_configuration += array( $key => $default );
        }
        return $default_configuration;
    }
}
