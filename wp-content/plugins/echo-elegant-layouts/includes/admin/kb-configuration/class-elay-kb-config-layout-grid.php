<?php

/**
 * Lists settings, default values and display of GRID layout.
 *
 * @copyright   Copyright (C) 2018 Echo Plugins
 */
class ELAY_KB_Config_Layout_Grid {

    const LAYOUT_NAME = 'Grid';
    const CATEGORY_LEVELS = 0;

    const DEFAULT_CATEGORY_ICON = 'ep_font_icon_document';

    // styles available for this layout
    const LAYOUT_STYLE_1 = 'No Icons 1';     // No Icons - no descr
    const LAYOUT_STYLE_2 = 'No Icons 2';     // No Icons - descr, no links
    const LAYOUT_STYLE_3 = 'Top Icons 1';     // Top - no desc
    const LAYOUT_STYLE_4 = 'Top Icons 2';     // Top - descr, no links
    const LAYOUT_STYLE_5 = 'Top Icons 3';     // Top - descr, links
    const LAYOUT_STYLE_6 = 'Left Icons 1';     // Left 1 - no descr, no links
    const LAYOUT_STYLE_7 = 'Left Icons 2';     // Left 1 - descr
    const LAYOUT_STYLE_8 = 'Left Icons 3';     // Left 2 - no descr, no links
    const LAYOUT_STYLE_9 = 'Left Icons 4';     // Left 2 - all
    const Demo1   = 'Demo1';     //

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

        $config_specification = array(

            /******************************************************************************
             *
             *  KB Main Layout - Layout and Style
             *
             ******************************************************************************/

            /***  General ***/

            'grid_width' => array(
                'label'       => __( 'Page Width', 'echo-elegant-layouts' ),
                'name'        => 'grid_width',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'elay-boxed' => __( 'Boxed Width', 'echo-elegant-layouts' ),
                    'elay-full' => __( 'Full Width', 'echo-elegant-layouts' ) ),
                'default'     => 'elay-boxed'
            ),
            'grid_section_font_size' => array(
                'label'       => __( 'Relative Text Size', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_font_size',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'section_xsmall_font' => _x( 'Extra Small', 'font size', 'echo-elegant-layouts' ),
                    'section_small_font' => _x( 'Small', 'font size', 'echo-elegant-layouts' ),
                    'section_medium_font' => _x( 'Medium', 'font size', 'echo-elegant-layouts' ),
                    'section_large_font' => _x( 'Large', 'font size', 'echo-elegant-layouts' ) ),
                'default'     => 'section_medium_font'
            ),
            'grid_nof_columns' => array(
                'label'       => __( 'Number of Columns', 'echo-elegant-layouts' ),
                'name'        => 'grid_nof_columns',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array( 'one-col' => '1', 'two-col' => '2', 'three-col' => '3', 'four-col' => '4' ),
                'default'     => 'three-col'
            ),
            'grid_category_icon' => array(
                'label'       => __( 'Category Icon', 'echo-elegant-layouts' ),
                'name'        => 'grid_category_icon',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => ELAY_KB_Core::get_epkbfa_all_icons(),
                'default'     => self::DEFAULT_CATEGORY_ICON
            ),
            'grid_category_icon_location' => array(
                'label'       => __( 'Icons Location/Turn Off', 'echo-elegant-layouts' ),
                'name'        => 'grid_category_icon_location',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'no_icons' => __( 'No Icons', 'echo-elegant-layouts' ),
                    'top' => __( 'Top', 'echo-elegant-layouts' ),
                    'left' => __( 'Left', 'echo-elegant-layouts' ),
                    'right' => __( 'Right', 'echo-elegant-layouts' ),
                    'bottom' => __( 'Bottom', 'echo-elegant-layouts' ),
                ),
                'default'     => 'top'
            ),
            'grid_category_icon_thickness' => array(
                'label'       => __( 'Category Icon Thickness', 'echo-elegant-layouts' ),
                'name'        => 'grid_category_icon_thickness',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'normal'    => __( 'Normal',   'echo-elegant-layouts' ),
                    'bold'    => __( 'Bold',   'echo-elegant-layouts' ),
                ),
                'default'     => 'normal'
            ),
            'grid_section_icon_size' => array(
                'label'       => __( 'Icon Size ( px )', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_icon_size',
                'max'         => '300',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '50'
            ),
            'grid_section_article_count' => array(
                'label'       => __( 'Show Articles Count', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_article_count',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => 'on'
            ),


            /***  Search Box ***/

            'grid_search_layout' => array(
                'label'       => __( 'Layout', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_layout',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'elay-search-form-1' => __( 'Rounded search button is on the right', 'echo-elegant-layouts' ),
                    'elay-search-form-4' => __( 'Squared search Button is on the right', 'echo-elegant-layouts' ),
                    'elay-search-form-2' => __( 'Search button is below', 'echo-elegant-layouts' ),
                    'elay-search-form-3' => __( 'No search button', 'echo-elegant-layouts' ),
                    'elay-search-form-0' => __( 'No search box', 'echo-elegant-layouts' )
                ),
                'default'     => 'elay-search-form-1'
            ),
            'grid_search_input_border_width' => array(
                'label'       => __( 'Border (px)', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_input_border_width',
                'max'         => '10',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '1'
            ),
            'grid_search_box_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_padding_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '50'
            ),
            'grid_search_box_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_padding_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '50'
            ),
            'grid_search_box_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_search_box_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_search_box_margin_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_margin_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_search_box_margin_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_margin_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '40'
            ),
            'grid_search_box_input_width' => array(
                'label'       => __( 'Width (%)', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_input_width',
                'max'         => '100',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '50'
            ),

            /***   Section    ***/

            'grid_section_head_alignment' => array(
                'label'       => __( 'Head Text Alignment', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_alignment',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'left' => __( 'Left', 'echo-elegant-layouts' ),
                    'center' => __( 'Centered', 'echo-elegant-layouts' ),
                    'right' => __( 'Right', 'echo-elegant-layouts' )
                ),
                'default'     => 'center'
            ),
            'grid_section_head_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_padding_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '20'
            ),
            'grid_section_head_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_padding_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '20'
            ),
            'grid_section_head_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_head_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),

            'grid_section_body_alignment' => array(
                'label'       => __( 'Body Text Alignment', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_alignment',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'left' => __( 'Left', 'echo-elegant-layouts' ),
                    'center' => __( 'Centered', 'echo-elegant-layouts' ),
                    'right' => __( 'Right', 'echo-elegant-layouts' )
                ),
                'default'     => 'center'
            ),
            'grid_section_cat_name_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_cat_name_padding_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_cat_name_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_cat_name_padding_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '20'
            ),
            'grid_section_cat_name_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_cat_name_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_cat_name_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_cat_name_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_desc_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_desc_padding_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_desc_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_desc_padding_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '20'
            ),
            'grid_section_desc_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_desc_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_desc_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_desc_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_desc_text_on' => array(
                'label'       => __( 'Description', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_desc_text_on',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => 'off'
            ),


            'grid_section_border_radius' => array(
                'label'       => __( 'Radius', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_border_radius',
                'max'         => '30',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '4'
            ),
            'grid_section_border_width' => array(
                'label'       => __( 'Width', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_border_width',
                'max'         => '10',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '1'
            ),
            'grid_section_box_shadow' => array(
                'label'       => __( 'Article List Shadow', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_box_shadow',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'no_shadow' => __( 'No Shadow', 'echo-elegant-layouts' ),
                    'section_light_shadow' => __( 'Light Shadow', 'echo-elegant-layouts' ),
                    'section_medium_shadow' => __( 'Medium Shadow', 'echo-elegant-layouts' ),
                    'section_bottom_shadow' => __( 'Bottom Shadow', 'echo-elegant-layouts' )
                ),
                'default'     => 'no_shadow'
            ),
            'grid_section_box_hover' => array(
                'label'       => __( 'Hover Effect', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_box_hover',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'no_effect' => __( 'No Effect', 'echo-elegant-layouts'),
                    'hover-1' => __( 'Hover 1: Gives Opacity 70% ', 'echo-elegant-layouts' ),
                    'hover-2' => __( 'Hover 2: Gives Opacity 80% ', 'echo-elegant-layouts' ),
                    'hover-3' => __( 'Hover 3: Gives Opacity 90% ', 'echo-elegant-layouts' ),
                    'hover-4' => __( 'Hover 4: Gives Lightest Grey Background ', 'echo-elegant-layouts' ),
                    'hover-5' => __( 'Hover 5: Gives Lighter Grey Background ', 'echo-elegant-layouts' ),
                ),
                'default'     => 'no_effect'
            ),
            'grid_section_divider' => array(
                'label'       => __( 'Divider', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_divider',
                'type'        => ELAY_Input_Filter::CHECKBOX,
                'default'     => 'on'
            ),
            'grid_section_divider_thickness' => array(
                'label'       => __( 'Divider Thickness (px)', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_divider_thickness',
                'max'         => '10',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '1'
            ),
            'grid_section_box_height_mode' => array(
                'label'       => __( 'Height Mode', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_box_height_mode',
                'type'        => ELAY_Input_Filter::SELECTION,
                'options'     => array(
                    'section_no_height' => __( 'Variable', 'echo-elegant-layouts' ),
                    'section_min_height' => __( 'Minimum', 'echo-elegant-layouts' ),
                    'section_fixed_height' => __( 'Maximum', 'echo-elegant-layouts' )  ),
                'default'     => 'section_no_height'
            ),
            'grid_section_body_height' => array(
                'label'       => __( 'Height', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_height',
                'max'         => '1000',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '350'
            ),
            'grid_section_body_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_padding_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_body_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_padding_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_body_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_body_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_article_list_spacing' => array(
                'label'       => __( 'Spacing', 'echo-elegant-layouts' ),
                'name'        => 'grid_article_list_spacing',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_icon_padding_top' => array(
                'label'       => __( 'Top', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_icon_padding_top',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '20'
            ),
            'grid_section_icon_padding_bottom' => array(
                'label'       => __( 'Bottom', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_icon_padding_bottom',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '20'
            ),
            'grid_section_icon_padding_left' => array(
                'label'       => __( 'Left', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_icon_padding_left',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),
            'grid_section_icon_padding_right' => array(
                'label'       => __( 'Right', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_icon_padding_right',
                'max'         => '200',
                'min'         => '0',
                'type'        => ELAY_Input_Filter::NUMBER,
                'default'     => '0'
            ),

            /******************************************************************************
             *
             *  KB Main Colors - All Colors Settings
             *
             ******************************************************************************/

            /***  Colors -> General  ***/

            'grid_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'grid_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#FFFFFF'
            ),


            /***  Colors -> Search Box  ***/

            'grid_search_title_font_color' => array(
                'label'       => __( 'Title', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_title_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#ffffff'
            ),
            'grid_search_background_color' => array(
                'label'       => __( 'Search Background', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#827a74'
            ),
            'grid_search_text_input_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_text_input_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#FFFFFF'
            ),
            'grid_search_text_input_border_color' => array(
                'label'       => __( 'Border', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_text_input_border_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#FFFFFF'
            ),
            'grid_search_btn_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_btn_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#686868'
            ),
            'grid_search_btn_border_color' => array(
                'label'       => __( 'Border', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_btn_border_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#F1F1F1'
            ),


            /***  Colors -> Articles Listed in Category Box ***/

            'grid_section_head_font_color' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#555555'
            ),
            'grid_section_head_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#FFFFFF'
            ),
            'grid_section_head_description_font_color' => array(
                'label'       => __( 'Category Description', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_description_font_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#B3B3B3'
            ),
            'grid_section_body_background_color' => array(
                'label'       => __( 'Background', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_background_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#FFFFFF'
            ),
            'grid_section_border_color' => array(
                'label'       => __( 'Border', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_border_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#E1E0E0'
            ),
            'grid_section_divider_color' => array(
                'label'       => __( 'Divider', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_divider_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#E1E0E0'
            ),
            'grid_section_head_icon_color' => array(
                'label'       => __( 'Icon', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_head_icon_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#FFFFFF'
            ),
            'grid_section_body_text_color' => array(
                'label'       => __( 'Text', 'echo-elegant-layouts' ),
                'name'        => 'grid_section_body_text_color',
                'size'        => '10',
                'max'         => '7',
                'min'         => '7',
                'type'        => ELAY_Input_Filter::COLOR_HEX,
                'default'     => '#666666'
            ),

            /******************************************************************************
             *
             *  Front-End Text
             *
             ******************************************************************************/

            /***   Search  ***/

            'grid_search_title' => array(
                'label'       => __( 'Search Title', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_title',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'How Can We Help?', 'echo-elegant-layouts' )
            ),
            'grid_search_box_hint' => array(
                'label'       => __( 'Search Hint', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_box_hint',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Search the documentation...', 'echo-elegant-layouts' )
            ),
            'grid_search_button_name' => array(
                'label'       => __( 'Search Button Name', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_button_name',
                'size'        => '25',
                'max'         => '50',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Search', 'echo-elegant-layouts' )
            ),
            'grid_search_results_msg' => array(
                'label'       => __( 'Search Results Message', 'echo-elegant-layouts' ),
                'name'        => 'grid_search_results_msg',
                'size'        => '60',
                'max'         => '100',
                'mandatory' => false,
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Search Results for', 'echo-elegant-layouts' )
            ),
            'grid_no_results_found' => array(
                'label'       => __( 'No Matches Found Text', 'echo-elegant-layouts' ),
                'name'        => 'grid_no_results_found',
                'size'        => '80',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'No matches found', 'echo-elegant-layouts' )
            ),
            'grid_min_search_word_size_msg' => array(
                'label'       => __( 'Minimum Search Word Size Message', 'echo-elegant-layouts' ),
                'name'        => 'grid_min_search_word_size_msg',
                'size'        => '60',
                'max'         => '150',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'Enter a word with at least one character.', 'echo-elegant-layouts' )
            ),


            /***   Categories and Articles ***/

			'grid_category_empty_msg' => array(
				'label'       => __( 'Empty Category Notice', 'echo-elegant-layouts' ),
				'name'        => 'grid_category_empty_msg',
				'size'        => '60',
				'max'         => '150',
				'mandatory' => false,
				'type'        => ELAY_Input_Filter::TEXT,
				'default'     => __( 'Articles coming soon', 'echo-elegant-layouts' )
			),
            'grid_category_link_text' => array(
                'label'       => __( 'Additional Text', 'echo-elegant-layouts' ),
                'name'        => 'grid_category_link_text',
                'size'        => '60',
                'max'         => '200',
                'min'         => '0',
	            'mandatory' => false,
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( '', 'echo-elegant-layouts' )
            ),
            'grid_article_count_text' => array(
                'label'       => __( 'Articles Count Text', 'echo-elegant-layouts' ),
                'name'        => 'grid_article_count_text',
                'size'        => '60',
                'max'         => '200',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'article', 'echo-elegant-layouts' )
            ),
            'grid_article_count_plural_text' => array(
                'label'       => __( 'Articles Count Plural Text', 'echo-elegant-layouts' ),
                'name'        => 'grid_article_count_plural_text',
                'size'        => '60',
                'max'         => '200',
                'min'         => '1',
                'type'        => ELAY_Input_Filter::TEXT,
                'default'     => __( 'articles', 'echo-elegant-layouts' )
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
            ELAY_Utilities::ajax_show_error_die( 'Could not retrieve Elegant Layout configuration (y33).' );
        }

        $kb_config = array_merge($add_on_kb_config, $kb_config);
        $feature_specs = ELAY_KB_Config_Specs::get_fields_specification();
        $form = new ELAY_KB_Config_Elements();

        //Arg1 / Arg2  for text_and_select_fields_horizontal
        $arg1 = $feature_specs['grid_section_body_height'] +    array(
                'value' => $kb_config['grid_section_body_height'],
                'current' => $kb_config['grid_section_body_height'],
                'input_group_class' => 'config-col-6',
                'input_class'       => 'config-col-12'
            );
        $arg2 = $feature_specs['grid_section_box_height_mode'] +    array(
                'value'    => $kb_config['grid_section_box_height_mode'],
                'current'  => $kb_config['grid_section_box_height_mode'],
                'input_group_class' => 'config-col-6',
                'input_class' => 'config-col-12'
            );

        //Advanced Settings
        $arg1_search_box_padding_vertical   = $feature_specs['grid_search_box_padding_top'] + array( 'value' => $kb_config['grid_search_box_padding_top'], 'current' => $kb_config['grid_search_box_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_search_box_padding_vertical   = $feature_specs['grid_search_box_padding_bottom'] + array( 'value' => $kb_config['grid_search_box_padding_bottom'], 'current' => $kb_config['grid_search_box_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_search_box_padding_horizontal = $feature_specs['grid_search_box_padding_left'] + array( 'value' => $kb_config['grid_search_box_padding_left'], 'current' => $kb_config['grid_search_box_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_search_box_padding_horizontal = $feature_specs['grid_search_box_padding_right'] + array( 'value' => $kb_config['grid_search_box_padding_right'], 'current' => $kb_config['grid_search_box_padding_right'], 'text_class' => 'config-col-6' );
        $arg1_search_box_margin_vertical = $feature_specs['grid_search_box_margin_top'] + array( 'value' => $kb_config['grid_search_box_margin_top'], 'current' => $kb_config['grid_search_box_margin_top'], 'text_class' => 'config-col-6' );
        $arg2_search_box_margin_vertical = $feature_specs['grid_search_box_margin_bottom'] + array( 'value' => $kb_config['grid_search_box_margin_bottom'], 'current' => $kb_config['grid_search_box_margin_bottom'], 'text_class' => 'config-col-6' );

        $arg1_box_border = $feature_specs['grid_section_border_radius'] + array( 'value' => $kb_config['grid_section_border_radius'], 'current' => $kb_config['grid_section_border_radius'], 'text_class' => 'config-col-6' );
        $arg2_box_border = $feature_specs['grid_section_border_width'] + array( 'value' => $kb_config['grid_section_border_width'], 'current' => $kb_config['grid_section_border_width'], 'text_class' => 'config-col-6' );

        $arg1_section_head_padding_vertical = $feature_specs['grid_section_head_padding_top'] + array( 'value' => $kb_config['grid_section_head_padding_top'], 'current' => $kb_config['grid_section_head_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_head_padding_vertical = $feature_specs['grid_section_head_padding_bottom'] + array( 'value' => $kb_config['grid_section_head_padding_bottom'], 'current' => $kb_config['grid_section_head_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_head_padding_horizontal = $feature_specs['grid_section_head_padding_left'] + array( 'value' => $kb_config['grid_section_head_padding_left'], 'current' => $kb_config['grid_section_head_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_head_padding_horizontal = $feature_specs['grid_section_head_padding_right'] + array( 'value' => $kb_config['grid_section_head_padding_right'], 'current' => $kb_config['grid_section_head_padding_right'], 'text_class' => 'config-col-6' );

        $arg1_section_body_padding_vertical = $feature_specs['grid_section_body_padding_top'] + array( 'value' => $kb_config['grid_section_body_padding_top'], 'current' => $kb_config['grid_section_body_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_body_padding_vertical = $feature_specs['grid_section_body_padding_bottom'] + array( 'value' => $kb_config['grid_section_body_padding_bottom'], 'current' => $kb_config['grid_section_body_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_body_padding_horizontal = $feature_specs['grid_section_body_padding_left'] + array( 'value' => $kb_config['grid_section_body_padding_left'], 'current' => $kb_config['grid_section_body_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_body_padding_horizontal = $feature_specs['grid_section_body_padding_right'] + array( 'value' => $kb_config['grid_section_body_padding_right'], 'current' => $kb_config['grid_section_body_padding_right'], 'text_class' => 'config-col-6' );

        $arg1_section_cat_name_padding_vertical = $feature_specs['grid_section_cat_name_padding_top'] + array( 'value' => $kb_config['grid_section_cat_name_padding_top'], 'current' => $kb_config['grid_section_cat_name_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_cat_name_padding_vertical = $feature_specs['grid_section_cat_name_padding_bottom'] + array( 'value' => $kb_config['grid_section_cat_name_padding_bottom'], 'current' => $kb_config['grid_section_cat_name_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_cat_name_padding_horizontal = $feature_specs['grid_section_cat_name_padding_left'] + array( 'value' => $kb_config['grid_section_cat_name_padding_left'], 'current' => $kb_config['grid_section_cat_name_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_cat_name_padding_horizontal = $feature_specs['grid_section_cat_name_padding_right'] + array( 'value' => $kb_config['grid_section_cat_name_padding_right'], 'current' => $kb_config['grid_section_cat_name_padding_right'], 'text_class' => 'config-col-6' );

        $arg1_section_icon_padding_vertical = $feature_specs['grid_section_icon_padding_top'] + array( 'value' => $kb_config['grid_section_icon_padding_top'], 'current' => $kb_config['grid_section_icon_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_icon_padding_vertical = $feature_specs['grid_section_icon_padding_bottom'] + array( 'value' => $kb_config['grid_section_icon_padding_bottom'], 'current' => $kb_config['grid_section_icon_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_icon_padding_horizontal = $feature_specs['grid_section_icon_padding_left'] + array( 'value' => $kb_config['grid_section_icon_padding_left'], 'current' => $kb_config['grid_section_icon_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_icon_padding_horizontal = $feature_specs['grid_section_icon_padding_right'] + array( 'value' => $kb_config['grid_section_icon_padding_right'], 'current' => $kb_config['grid_section_icon_padding_right'], 'text_class' => 'config-col-6' );

        $arg1_section_desc_padding_vertical = $feature_specs['grid_section_desc_padding_top'] + array( 'value' => $kb_config['grid_section_desc_padding_top'], 'current' => $kb_config['grid_section_desc_padding_top'], 'text_class' => 'config-col-6' );
        $arg2_section_desc_padding_vertical = $feature_specs['grid_section_desc_padding_bottom'] + array( 'value' => $kb_config['grid_section_desc_padding_bottom'], 'current' => $kb_config['grid_section_desc_padding_bottom'], 'text_class' => 'config-col-6' );
        $arg1_section_desc_padding_horizontal = $feature_specs['grid_section_desc_padding_left'] + array( 'value' => $kb_config['grid_section_desc_padding_left'], 'current' => $kb_config['grid_section_desc_padding_left'], 'text_class' => 'config-col-6' );
        $arg2_section_desc_padding_horizontal = $feature_specs['grid_section_desc_padding_right'] + array( 'value' => $kb_config['grid_section_desc_padding_right'], 'current' => $kb_config['grid_section_desc_padding_right'], 'text_class' => 'config-col-6' );

	    $search_input_input_arg1 = $feature_specs['grid_search_box_input_width'] + array(
			    'value'             => $kb_config['grid_search_box_input_width'],
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-6',
			    'input_class'       => 'config-col-2'

		    );
	    $search_input_input_arg2 = $feature_specs['grid_search_input_border_width'] + array(
			    'value' => $kb_config['grid_search_input_border_width'],
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-6',
			    'input_class'       => 'config-col-2'
		    );


	    $article_spacing_arg2 = $feature_specs['grid_article_list_spacing'] +  array(
			    'value'             => $kb_config['grid_article_list_spacing'],
			    'id'                => 'grid_article_list_spacing',
			    'input_group_class' => 'config-col-12',
			    'label_class'       => 'config-col-5',
			    'input_class'       => 'config-col-3'
		    );

        // SEARCH BOX - Layout
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Search Layout',
            'class'        => 'eckb-mm-mp-links-tuning-searchbox-layout',
            'inputs' => array(
                '0' => $form->dropdown( $feature_specs['grid_search_layout'] + array(
                        'value' => $kb_config['grid_search_layout'],
                        'current' => $kb_config['grid_search_layout'],
                        'label_class' => 'config-col-3',
                        'input_class' => 'config-col-7'
                    ) )
            )
        ), $kb_page_layout);


        // SEARCH BOX - Advanced Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Search Box - Advanced Style',
            'class'        => 'eckb-mm-mp-links-tuning-searchbox-advanced',
            'inputs' => array(
	            '0' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_search_box_padding',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical ,$arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
	            ),
	            '1' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_search_box_margin',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Margin (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
	            ),
	            '2' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'search_box_input_width_group',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             =>__( 'Search Box Input ( % ) ( px )', 'echo-elegant-layouts')
		            ),
		            array( $search_input_input_arg1, $search_input_input_arg2 )
	            ),

         )), $kb_page_layout);

        // CONTENT - Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Content - Style',
            'class'          => 'eckb-mm-mp-links-tuning-content-style',
            'inputs' => array(
                '0' => $form->dropdown( $feature_specs['grid_width'] + array(
                        'value' => $kb_config['grid_width'],
                        'current' => $kb_config['grid_width'],
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-3',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-4'
                    ) ),
                '1' => $form->radio_buttons_horizontal( $feature_specs['grid_nof_columns'] + array(
                        'id'        => 'front-end-columns',
                        'value'     => $kb_config['grid_nof_columns'],
                        'current'   => $kb_config['grid_nof_columns'],
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-5',
                        'input_class'       => 'config-col-6',
                        'radio_class'       => 'config-col-3'
                    ) ),
                '2' => $form->dropdown( $feature_specs['grid_section_font_size'] + array(
                        'value' => $kb_config['grid_section_font_size'],
                        'current' => $kb_config['grid_section_font_size'],
                        'input_group_class' => 'config-col-12',
                        'label_class' => 'config-col-5',
                        'input_class' => 'config-col-4'
                    ) )
        )));

        // CATEGORIES - Style 2
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Categories - Style',
            'class'        => 'eckb-mm-mp-links-tuning-categories-style',
            'inputs' => array(
                '3' => $form->checkbox( $feature_specs['grid_section_desc_text_on'] + array(
                        'value'             => $kb_config['grid_section_desc_text_on'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class' => 'config-col-2'
                    ) ),
                '4' => $form->checkbox( $feature_specs['grid_section_divider'] + array(
                        'value'             => $kb_config['grid_section_divider'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                    ) ),
                '5' => $form->text( $feature_specs['grid_section_divider_thickness'] + array(
                        'value'             => $kb_config['grid_section_divider_thickness'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                    ) ),

                '6' => $form->checkbox( $feature_specs['grid_section_article_count'] + array(
                        'value'             => $kb_config['grid_section_article_count'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                        ) ),
                '7' => $form->dropdown( $feature_specs['grid_category_icon_location'] + array(
                        'value' => $kb_config['grid_category_icon_location'],
                        'current' => $kb_config['grid_category_icon_location'],
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-6'
                    )),
                '8' => $form->text( $feature_specs['grid_section_icon_size'] + array(
                        'value'             => $kb_config['grid_section_icon_size'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-2'
                        ) ),
                '9' => $form->dropdown( $feature_specs['grid_category_icon_thickness'] + array(
                        'value'             => $kb_config['grid_category_icon_thickness'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-3',
                        'input_class'       => 'config-col-7'
                    ) ),
                '10' => $form->text_and_select_fields_horizontal( array(
                        'id'                => 'box_height',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-5',
                        'label'             => __( 'Category Box Height', 'echo-elegant-layouts'),
                        'input_class'       => 'config-col-6',
                    ), $arg1, $arg2 ),
        )));

        // CATEGORIES - Advanced Style
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Categories - Advanced Style',
            'class'        => 'eckb-mm-mp-links-tuning-categories-advanced',
            'inputs' => array(

	                 '0' => $form->dropdown( $feature_specs['grid_section_box_hover'] + array(
			            'value'             => $kb_config['grid_section_box_hover'],
			            'current'           => $kb_config['grid_section_box_hover'],
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
                            'label'             => __( 'Box Border (px)', 'echo-elegant-layouts')
                        ),
                        array( $arg1_box_border, $arg2_box_border )
                    ),
                    '2' => $form->multiple_number_inputs(
                        array(
                            'id'                => 'grid_section_head_padding',
                            'input_group_class' => '',
                            'main_label_class'  => '',
                            'input_class'       => '',
                            'label'             => __( 'Padding (px)', 'echo-elegant-layouts')
                        ),
                        array( $arg1_section_head_padding_vertical, $arg2_section_head_padding_vertical, $arg1_section_head_padding_horizontal, $arg2_section_head_padding_horizontal )
                    ),

            )
        ));

        // CATEGORIES - Advanced - HEAD
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Categories - Advanced - Head',
            'class'        => 'eckb-mm-mp-links-tuning-categories-advanced',
            'inputs' => array(
	            '0' => $form->dropdown( $feature_specs['grid_section_head_alignment'] + array(
			            'value' => $kb_config['grid_section_head_alignment'],
			            'current' => $kb_config['grid_section_head_alignment'],
			            'input_group_class' => 'config-col-12',
			            'label_class'       => 'config-col-5',
			            'input_class'       => 'config-col-3'
		            ) ),
	            '1' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_section_icon_padding',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Icon Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_section_icon_padding_vertical, $arg2_section_icon_padding_vertical, $arg1_section_icon_padding_horizontal, $arg2_section_icon_padding_horizontal )
	            ),
	            '2' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_section_cat_name_padding',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Name Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_section_cat_name_padding_vertical, $arg2_section_cat_name_padding_vertical, $arg1_section_cat_name_padding_horizontal, $arg2_section_cat_name_padding_horizontal )
	            ),
	            '3' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_section_desc_padding',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Description Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_section_desc_padding_vertical, $arg2_section_desc_padding_vertical, $arg1_section_desc_padding_horizontal, $arg2_section_desc_padding_horizontal )
	            ),
            )
        ));

        // CATEGORIES - Advanced - BODY
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Categories - Advanced - Body',
            'class'        => 'eckb-mm-mp-links-tuning-categories-advanced',
            'inputs' => array(
                '0' => $form->dropdown( $feature_specs['grid_section_box_shadow'] + array(
                        'value' => $kb_config['grid_section_box_shadow'],
                        'current' => $kb_config['grid_section_box_shadow'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-6'
                    ) ),
                '1' => $form->dropdown( $feature_specs['grid_section_body_alignment'] + array(
                        'value' => $kb_config['grid_section_body_alignment'],
                        'current' => $kb_config['grid_section_body_alignment'],
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-5',
                        'input_class'       => 'config-col-3'
                    ) ),
	            '2' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_article_list_group',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Text Spacing (px)', 'echo-elegant-layouts')
		            ),
		            array(  $article_spacing_arg2 )
	            ),
	            '3' => $form->multiple_number_inputs(
		            array(
			            'id'                => 'grid_section_body_padding',
			            'input_group_class' => '',
			            'main_label_class'  => '',
			            'input_class'       => '',
			            'label'             => __( 'Padding (px)', 'echo-elegant-layouts')
		            ),
		            array( $arg1_section_body_padding_vertical, $arg2_section_body_padding_vertical, $arg1_section_body_padding_horizontal, $arg2_section_body_padding_horizontal )
	            ),
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
            ELAY_Utilities::ajax_show_error_die( 'Could not retrieve Elegant Layout configuration (y34).' );
        }

        $kb_config = array_merge($add_on_kb_config, $kb_config);
        $form = new ELAY_KB_Config_Elements();

        $arg1_input_text_field = $feature_specs['grid_search_text_input_background_color'] + array( 'value' => $kb_config['grid_search_text_input_background_color'], 'current' => $kb_config['grid_search_text_input_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_input_text_field = $feature_specs['grid_search_text_input_border_color'] + array( 'value' => $kb_config['grid_search_text_input_border_color'], 'current' => $kb_config['grid_search_text_input_border_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

        $arg1_button = $feature_specs['grid_search_btn_background_color'] + array( 'value' => $kb_config['grid_search_btn_background_color'], 'current' => $kb_config['grid_search_btn_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_button = $feature_specs['grid_search_btn_border_color'] + array( 'value' => $kb_config['grid_search_btn_border_color'], 'current' => $kb_config['grid_search_btn_border_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

        $arg1_category_box_heading = $feature_specs['grid_section_head_font_color'] + array( 'value' => $kb_config['grid_section_head_font_color'], 'current' => $kb_config['grid_section_head_font_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
        $arg2_category_box_heading = $feature_specs['grid_section_head_background_color'] + array( 'value' => $kb_config['grid_section_head_background_color'], 'current' => $kb_config['grid_section_head_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );


        // SEARCH BOX - Colors
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Search Box - Colors',
            'class'             => 'eckb-mm-mp-links-tuning-searchbox-colors',
            'inputs' => array(
	            '0' => $form->text( $feature_specs['grid_search_title_font_color'] + array(
                        'value' => $kb_config['grid_search_title_font_color'],
                        'input_group_class' => 'config-col-12',
                        'class'             => 'ekb-color-picker',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-8 ekb-color-picker'
                    ) ),
	            '1' => $form->text( $feature_specs['grid_search_background_color'] + array(
                        'value' => $kb_config['grid_search_background_color'],
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
            'class'             => 'eckb-mm-mp-links-tuning-content-colors',
            'inputs'            => array(
                    '0' => $form->text( $feature_specs['grid_background_color'] + array(
                                'value' => $kb_config['grid_background_color'],
                            'input_group_class' => 'config-col-12',
                            'class'             => 'ekb-color-picker',
                            'label_class'       => 'config-col-4',
                            'input_class'       => 'config-col-8 ekb-color-picker'
                        ) ) )
        ));

        // CATEGORIES - Colors
        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Categories - Colors',
            'class'             => 'eckb-mm-mp-links-tuning-categories-colors',
            'inputs'            => array(
                '0' => $form->text_fields_horizontal( array(
                    'id'                => 'category_box_heading',
                        'input_group_class' => 'config-col-12',
                        'main_label_class'  => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker',
                    'label'                 => __( 'Category Box Heading', 'echo-elegant-layouts')
                ), $arg1_category_box_heading, $arg2_category_box_heading ),
                '1' => $form->text( $feature_specs['grid_section_head_description_font_color'] + array(
                        'value' => $kb_config['grid_section_head_description_font_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '2' => $form->text( $feature_specs['grid_section_head_icon_color'] + array(
                        'value' => $kb_config['grid_section_head_icon_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '3' => $form->text( $feature_specs['grid_section_divider_color'] + array(
                        'value' => $kb_config['grid_section_divider_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '4' => $form->text( $feature_specs['grid_section_body_background_color'] + array(
                        'value' => $kb_config['grid_section_body_background_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '5' => $form->text( $feature_specs['grid_section_body_text_color'] + array(
                        'value' => $kb_config['grid_section_body_text_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) ),
                '6' => $form->text( $feature_specs['grid_section_border_color'] + array(
                        'value' => $kb_config['grid_section_border_color'],
                        'class'             => 'ekb-color-picker',
                        'input_group_class' => 'config-col-12',
                        'label_class'       => 'config-col-4',
                        'input_class'       => 'config-col-7 ekb-color-picker'
                    ) )
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
            ELAY_Utilities::ajax_show_error_die( 'Could not retrieve Elegant Layout configuration (y35).' );
        }

        $kb_config = array_merge($add_on_kb_config, $kb_config);
        $form = new ELAY_KB_Config_Elements();


        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading' => 'Search Box - Text',
            'class'        => 'eckb-mm-mp-links-alltext-text-searchbox eckb-mm-mp-links-tuning-searchbox-text',
            'inputs' => array(
                '0' => $form->text( $feature_specs['grid_search_title'] +
                    array( 'value' => $kb_config['grid_search_title'], 'current' => $kb_config['grid_search_title'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) ),
                '1' => $form->text( $feature_specs['grid_search_box_hint'] +
                    array( 'value' => $kb_config['grid_search_box_hint'], 'current' => $kb_config['grid_search_box_hint'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) ),
                '2' => $form->text( $feature_specs['grid_search_button_name'] +
                    array( 'value' => $kb_config['grid_search_button_name'], 'current' => $kb_config['grid_search_button_name'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
                '3' => $form->text( $feature_specs['grid_search_results_msg'] +
                    array( 'value' => $kb_config['grid_search_results_msg'], 'current' => $kb_config['grid_search_results_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
                '4' => $form->text( $feature_specs['grid_no_results_found'] +
                    array( 'value' => $kb_config['grid_no_results_found'], 'current' => $kb_config['grid_no_results_found'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) ),
                '5' => $form->text( $feature_specs['grid_min_search_word_size_msg'] +
                    array( 'value' => $kb_config['grid_min_search_word_size_msg'], 'current' => $kb_config['grid_min_search_word_size_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'   ) )
            )
        ), $kb_page_layout);

        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Categories - Text',
            'class'             => 'eckb-mm-mp-links-alltext-text-categories eckb-mm-mp-links-tuning-categories-text',
            'inputs' => array(
                '1' => $form->text( $feature_specs['grid_category_empty_msg'] +
                    array( 'value' => $kb_config['grid_category_empty_msg'], 'current' => $kb_config['grid_category_empty_msg'],
                            'input_group_class' => 'config-col-12',
                            'label_class'       => 'config-col-3',
                            'input_class'       => 'config-col-9'       ) ),
                '2' => $form->text( $feature_specs['grid_article_count_text'] +
                                    array( 'value' => $kb_config['grid_article_count_text'], 'current' => $kb_config['grid_article_count_text'],
                                        'input_group_class' => 'config-col-12',
                                        'label_class'       => 'config-col-3',
                                        'input_class'       => 'config-col-9'       ) ),
                '3' => $form->text( $feature_specs['grid_article_count_plural_text'] +
                                    array( 'value' => $kb_config['grid_article_count_plural_text'], 'current' => $kb_config['grid_article_count_plural_text'],
                                        'input_group_class' => 'config-col-12',
                                        'label_class'       => 'config-col-3',
                                        'input_class'       => 'config-col-9'       ) )
            )
        ));

        $form->option_group_filter( $kb_config, $feature_specs, array(
            'option-heading'    => 'Articles - Text',
            'class'             => 'eckb-mm-mp-links-alltext-text-articles eckb-mm-mp-links-tuning-listofarticles-text',
            'inputs' => array(
                '1' => $form->text( $feature_specs['grid_category_link_text'] +
                   array( 'value' => $kb_config['grid_category_link_text'], 'current' => $kb_config['grid_category_link_text'],
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
                return self::color_reset_black_1();
                break;
        }
    }

	/**
	 * DEFAULT for COLOR SETTINGS
	 *
	 * @return array
	 */
	private static function color_demo_1() {

		return array(
			//General
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#FFFFFF', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#FFFFFF', //search_title_font_color
			'grid_search_background_color'               => '#f7941d', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#CCCCCC', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#40474f', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#827a74', //section_head_font_color
			'grid_section_head_background_color'         => '#FFFFFF', //section_head_background_color
			'grid_section_head_description_font_color'   => '#B3B3B3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#f7941d', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#B3B3B3', //article_font_color
			'grid_section_border_color'                  => '#f7941d', //section_border_color
		);
	}
	private static function color_reset_black_1() {

		return array(
			//General
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#DADADA', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#686868', //search_title_font_color
			'grid_search_background_color'               => '#FBFBFB', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#827a74', //section_head_font_color
			'grid_section_head_background_color'         => '#FFFFFF', //section_head_background_color
			'grid_section_head_description_font_color'   => '#B3B3B3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#868686', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#B3B3B3', //article_font_color
			'grid_section_border_color'                  => '#DBDBDB', //section_border_color
		);
	}
	private static function color_reset_black_2() {

		return array(
			//General
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#DADADA', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#000000', //search_title_font_color
			'grid_search_background_color'               => '#F7F7F7', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#CCCCCC', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#8D8B8D', //section_head_font_color
			'grid_section_head_background_color'         => '#F7F7F7', //section_head_background_color
			'grid_section_head_description_font_color'   => '#b3b3b3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#868686', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#F7F7F7', //section_border_color
		);
	}
	private static function color_reset_black_3() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#CDCDCD', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#686868', //search_title_font_color
			'grid_search_background_color'               => '#f1f1f1', //search_background_color
			'grid_search_text_input_background_color'    => '#ffffff', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#525252', //section_head_font_color
			'grid_section_head_background_color'         => '#f1f1f1', //section_head_background_color
			'grid_section_head_description_font_color'   => '#b3b3b3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#868686', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#fdfdfd', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#F7F7F7', //section_border_color
		);
	}
	private static function color_reset_black_4() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#FFFFFF', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#000000', //search_title_font_color
			'grid_search_background_color'               => '#e0e0e0', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#7d7d7d', //section_head_background_color
			'grid_section_head_description_font_color'   => '#b3b3b3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#FFFFFF', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#e0e0e0', //section_body_background_color
			'grid_section_body_text_color'               => '#000000', //article_font_color
			'grid_section_border_color'                  => '#7d7d7d', //section_border_color
		);
	}

	private static function color_reset_red_1() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#DADADA', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#FFFFFF', //search_title_font_color
			'grid_search_background_color'               => '#fb8787', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#af1e1e', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#fb8787', //section_head_font_color
			'grid_section_head_background_color'         => '#FFFFFF', //section_head_background_color
			'grid_section_head_description_font_color'   => '#b3b3b3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#868686', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_red_2() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#DADADA', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#CC0000', //search_title_font_color
			'grid_search_background_color'               => '#f9e5e5', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#CC0000', //section_head_font_color
			'grid_section_head_background_color'         => '#f9e5e5', //section_head_background_color
			'grid_section_head_description_font_color'   => '#e57f7f', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#3f3f3f', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#F7F7F7', //section_border_color
		);
	}
	private static function color_reset_red_3() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#CDCDCD', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#CC0000', //search_title_font_color
			'grid_search_background_color'               => '#f4c6c6', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#CC0000', //section_head_font_color
			'grid_section_head_background_color'         => '#f4c6c6', //section_head_background_color
			'grid_section_head_description_font_color'   => '#e57f7f', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#dd3333', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#fefcfc', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#F7F7F7', //section_border_color
		);
	}
	private static function color_reset_red_4() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#CDCDCD', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#fb6262', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#fb6262', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#ffffff', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#fefcfc', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#F7F7F7', //section_border_color
		);
	}

	private static function color_reset_blue_1() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#CDCDCD', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#53ccfb', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#3093ba', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#53ccfb', //section_head_font_color
			'grid_section_head_background_color'         => '#ffffff', //section_head_background_color
			'grid_section_head_description_font_color'   => '#b3b3b3', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#868686', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_blue_2() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#c5c5c5', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#53ccfb', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#3093ba', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#53ccfb', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#ffffff', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_blue_3() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#c5c5c5', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#11b3f2', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#3093ba', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#11b3f2', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#096abf', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#f1fbff', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_blue_4() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#CDCDCD', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#4398ba', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#FFFFFF', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#F1F1F1', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#4398ba', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#f2f2f2', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#f9f9f9', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#F7F7F7', //section_border_color
		);
	}

	private static function color_reset_green_1() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#CDCDCD', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#bfdac1', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#4a714e', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#4a714e', //section_head_font_color
			'grid_section_head_background_color'         => '#ffffff', //section_head_background_color
			'grid_section_head_description_font_color'   => '#bfdac1', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#868686', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_green_2() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#c5c5c5', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#9cb99f', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#4a714e', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#9cb99f', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#4a7f48', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#FFFFFF', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_green_3() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#c5c5c5', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#769679', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#4a714e', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#769679', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#ffffff', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#edf4ee', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
		);
	}
	private static function color_reset_green_4() {

		return array(
			//Main
			'grid_background_color'                      => '#FFFFFF', //background_color
			'grid_section_divider_color'                 => '#c5c5c5', //section_divider_color

			//Search Box
			'grid_search_title_font_color'               => '#ffffff', //search_title_font_color
			'grid_search_background_color'               => '#628365', //search_background_color
			'grid_search_text_input_background_color'    => '#FFFFFF', //search_text_input_background_color
			'grid_search_text_input_border_color'        => '#DDDDDD', //search_text_input_border_color
			'grid_search_btn_background_color'           => '#686868', //search_btn_background_color
			'grid_search_btn_border_color'               => '#DDDDDD', //search_btn_border_color

			//Category Box: Section Head
			'grid_section_head_font_color'               => '#ffffff', //section_head_font_color
			'grid_section_head_background_color'         => '#628365', //section_head_background_color
			'grid_section_head_description_font_color'   => '#ffffff', //section_head_description_font_color
			'grid_section_head_icon_color'               => '#ffffff', //section_category_icon_color

			//Category Box: Section Body
			'grid_section_body_background_color'         => '#edf4ee', //section_body_background_color
			'grid_section_body_text_color'               => '#b3b3b3', //article_font_color
			'grid_section_border_color'                  => '#dbdbdb', //section_border_color
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
            case self::LAYOUT_STYLE_1:
                return self::get_style_1_set();
            case self::LAYOUT_STYLE_2:
                return self::get_style_2_set();
            case self::LAYOUT_STYLE_3:
                return self::get_style_3_set();
            case self::LAYOUT_STYLE_4:
                return self::get_style_4_set();
            case self::LAYOUT_STYLE_5:
                return self::get_style_5_set();
            case self::LAYOUT_STYLE_6:
                return self::get_style_8_set();
            case self::LAYOUT_STYLE_7:
                return self::get_style_9_set();
            case self::LAYOUT_STYLE_8:
                return self::get_style_6_set();
            case self::LAYOUT_STYLE_9:
                return self::get_style_7_set();
            default:
                return self::get_style_6_set();
                break;
        }
    }

    // No Icons - no descr
    private static function get_style_1_set() {
        return array(

            //Left Icons 2 Icons Option

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'on',

            'grid_category_icon_location'        => 'no_icons',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
            'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
            'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'section_light_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  0,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  0,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  0,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  20,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'center',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  15,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  15,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  0,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  15,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  20,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	     /*   'back_navigation_toggle'         => 'on',
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
	        'back_navigation_padding_right'  => '4', */

        );
    }

    // No Icons - descr - no links
    private static function get_style_2_set() {
        return array(

            //Left Icons 2 Icons Option

            //Page
            'grid_width'                         => 'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   => 'three-col',           //Input: Number of Columns
            'grid_section_font_size'             => 'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'off',

            'grid_category_icon_location'        => 'no_icons',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'section_light_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  0,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  0,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  0,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  20,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'center',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  20,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  20,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  0,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  15,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  20,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	     /*   'back_navigation_toggle'         => 'on',
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
	        'back_navigation_padding_right'  => '4', */

        );
    }

    // Top - no desc - count
    private static function get_style_3_set() {
        return array(

            //Top Icons Option

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'on',

            'grid_category_icon_location'        => 'top',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'section_light_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  4,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  1,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  20,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  20,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  0,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'center',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'off',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  0,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  15,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  0,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  0,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  15,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  0,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	     /*   'back_navigation_toggle'         => 'on',
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
	        'back_navigation_padding_right'  => '4', */

        );
    }

    // Top - descr - no count
    private static function get_style_4_set() {
        return array(

            //Top Icons Option

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'off',

            'grid_category_icon_location'        => 'top',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'no_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  4,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  1,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  20,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  20,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  0,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'center',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  0,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  15,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  0,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  0,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  15,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  0,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

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
	        'back_navigation_padding_right'  => '4', */

        );
    }

    // Top Icons 3: Top - descr - links
    private static function get_style_5_set() {
        return array(

            //Left Icons 2 Icons Option

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'on',

            'grid_category_icon_location'        => 'top',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'section_light_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  0,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  20,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  0,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                   //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'center',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  10,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  10,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  0,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  20,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  20,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	    /*   'back_navigation_toggle'         => 'on',
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
	        'back_navigation_padding_right'  => '4', */

        );
    }

    // Left Icons 3: Title / Cat Description / Article Count / Show all
    private static function get_style_6_set() {
        return array(

            //Left Icons 2 Icons Option

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'on',

            'grid_category_icon_location'        => 'left',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'section_light_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  10,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  0,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  10,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'left',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  10,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  10,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  17,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  60,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  40,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  15,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  0,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	     /*   'back_navigation_toggle'         => 'on',
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

    // Left 2 - all
    private static function get_style_7_set() {
        return array(

            //Left Icons 2 Icons Option

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'off',

            'grid_category_icon_location'        => 'left',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'section_light_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  10,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  0,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  10,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'left',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'on',                  //Input: Divider
            'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  10,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  10,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  60,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  40,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  15,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  20,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

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
	        'back_navigation_padding_right'  => '4', */

        );
    }

    //Left Icons 1: Title / Cat Description / Show all
    private static function get_style_8_set() {
        return array(
            // Left Icons 1

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'off',

            'grid_category_icon_location'        => 'left',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'no_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  10,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  0,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  10,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'left',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'off',                  //Input: Divider
            'grid_section_divider_thickness'     =>  0,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  10,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  15,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  60,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  10,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  60,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'left',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  10,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  70,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	     /*   'back_navigation_toggle'         => 'on',
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
	        'back_navigation_padding_right'  => '4', */
        );
    }

    //Left Icons 2: Title / Cat Description / Article Count / Show all
    private static function get_style_9_set() {
        return array(
            // Left Icons 2

            //Page
            'grid_width'                         =>  'elay-boxed',          //Input: Page Width
            'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
            'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
            'grid_section_article_count'         => 'on',

            'grid_category_icon_location'        => 'left',                 //Input: Icons Location
            'grid_section_icon_size'             => '50',                  //Input: Icon Size
            'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
            'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
            'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

            //Search Box
            'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
	        'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
	        'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

            //Category: Advanced Configuration
            'grid_section_box_shadow'            => 'no_shadow',           //Input: Article List Shadow
            'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
            'grid_section_border_radius'         =>  0,                   //Input: Box Border ( Radius )
            'grid_section_border_width'          =>  0,                   //Input: Box Border ( Width )
            'grid_section_icon_padding_top'      =>  10,                   //Input: Icon Padding Vertical ( Top )
            'grid_section_icon_padding_bottom'   =>  0,                  //Input: Icon Padding Vertical ( Bottom )
            'grid_section_icon_padding_left'     =>  10,                   //Input: Icon Padding Horizontal ( left )
            'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
            'grid_section_head_alignment'        =>  'left',              //Input: Head Text Alignment
            'grid_section_desc_text_on'          =>  'on',                  //Input: Description (on/off)
            'grid_section_divider'               =>  'off',                  //Input: Divider
            'grid_section_divider_thickness'     =>  0,                     //Input: Divider Thickness
            'grid_section_head_padding_top'      =>  10,                    //Input: Padding Vertical ( Top )
            'grid_section_head_padding_bottom'   =>  15,                    //Input: Padding Vertical ( Bottom )
            'grid_section_head_padding_left'     =>  10,                     //Input: Padding Horizontal ( Left )
            'grid_section_head_padding_right'    =>  10,                     //Input: Padding Horizontal ( Right )
            'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
            'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
            'grid_section_cat_name_padding_left'     =>  60,                 //Input: Name Padding ( Left )
            'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
            'grid_section_desc_padding_top'      =>  10,                     //Input: Description Padding ( Top )
            'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
            'grid_section_desc_padding_left'     =>  60,                     //Input: Description Padding ( Left )
            'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
            'grid_section_body_alignment'        =>  'left',              //Input: Body Text Alignment
            'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
            'grid_section_body_padding_top'      =>  10,                     //Input: Padding Vertical ( Top )
            'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
            'grid_section_body_padding_left'     =>  70,                    //Input: Padding Horizontal ( Left )
            'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

	        //Features
	     /*   'back_navigation_toggle'         => 'on',
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
	        'back_navigation_padding_right'  => '4', */
        );
    }

	//Default Installation set Top - no desc - count ( Based on website Demo 6 )
	private static function demo_1_set() {
		return array(

			'templates_for_kb'                              => 'kb_templates',
			'templates_display_main_page_main_title'        => 'off',
			'templates_for_kb_padding_top'                  => 0,
			'templates_for_kb_padding_left'                 => 0,
			'templates_for_kb_padding_right'                => 0,
			'templates_for_kb_margin_top'                   => 0,
			'templates_for_kb_margin_left'                  => 0,
			'templates_for_kb_margin_right'                 => 0,
			'templates_for_kb_article_reset'                => 'off',
			'templates_for_kb_article_defaults'             => 'off',
			'templates_for_kb_article_padding_top'          => 30,
			'templates_for_kb_article_padding_bottom'       => 50,
			'templates_for_kb_article_padding_left'         => 4,
			'templates_for_kb_article_padding_right'        => 4,
			'templates_for_kb_article_margin_top'           => 4,
			'templates_for_kb_article_margin_bottom'        => 50,
			'templates_for_kb_article_margin_left'          => 4,
			'templates_for_kb_article_margin_right'         => 4,
			'templates_for_kb_category_archive_page_style'  => 'eckb-category-archive-style-1',

			'breadcrumb_font_size'                          => 12,
			'back_navigation_font_size'                     => 16,

			//Top Icons Option

			//Page
			'grid_width'                         =>  'elay-full',           //Input: Page Width
			'grid_nof_columns'                   =>  'three-col',           //Input: Number of Columns
			'grid_section_font_size'             =>  'section_medium_font', //Input: Relative Text Size
			'grid_section_article_count'         => 'on',

			'grid_category_icon_location'        => 'top',                 //Input: Icons Location
			'grid_section_icon_size'             => '50',                  //Input: Icon Size
			'grid_category_icon_thickness'       => 'normal',              //Input: Category Icon Thickness
			'grid_section_body_height'           => 350,                   //Input: Category Box Height ( Height ( px ) )
			'grid_section_box_height_mode'       => 'section_no_height',   //Input: Category Box Height ( Height Mode )

			//Search Box
			'grid_search_layout'                 =>  'elay-search-form-1',  //Input: Layout
			'grid_search_box_padding_top'        =>  40,  //Input: Padding Top
			'grid_search_box_padding_bottom'     =>  50,  //Input: Padding Bottom

			//Category: Advanced Configuration
			'grid_section_box_shadow'            => 'no_shadow',           //Input: Article List Shadow
			'grid_section_box_hover'             => 'hover-4',             //Input: Hover Effect
			'grid_section_border_radius'         =>  4,                   //Input: Box Border ( Radius )
			'grid_section_border_width'          =>  1,                   //Input: Box Border ( Width )
			'grid_section_icon_padding_top'      =>  20,                   //Input: Icon Padding Vertical ( Top )
			'grid_section_icon_padding_bottom'   =>  20,                  //Input: Icon Padding Vertical ( Bottom )
			'grid_section_icon_padding_left'     =>  0,                   //Input: Icon Padding Horizontal ( left )
			'grid_section_icon_padding_right'    =>  0,                  //Input: Icon Padding Horizontal ( Right )
			'grid_section_head_alignment'        =>  'center',              //Input: Head Text Alignment
			'grid_section_desc_text_on'          =>  'off',                  //Input: Description (on/off)
			'grid_section_divider'               =>  'off',                  //Input: Divider
			'grid_section_divider_thickness'     =>  1,                     //Input: Divider Thickness
			'grid_section_head_padding_top'      =>  0,                    //Input: Padding Vertical ( Top )
			'grid_section_head_padding_bottom'   =>  15,                    //Input: Padding Vertical ( Bottom )
			'grid_section_head_padding_left'     =>  0,                     //Input: Padding Horizontal ( Left )
			'grid_section_head_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )
			'grid_section_cat_name_padding_top'      =>  0,                 //Input: Name Padding ( Top )
			'grid_section_cat_name_padding_bottom'   =>  0,                  //Input: Name Padding ( Bottom )
			'grid_section_cat_name_padding_left'     =>  0,                 //Input: Name Padding ( Left )
			'grid_section_cat_name_padding_right'    =>  0,                  //Input: Name Padding ( Right )
			'grid_section_desc_padding_top'      =>  15,                     //Input: Description Padding ( Top )
			'grid_section_desc_padding_bottom'   =>  0,                     //Input: Description Padding ( Bottom )
			'grid_section_desc_padding_left'     =>  0,                     //Input: Description Padding ( Left )
			'grid_section_desc_padding_right'    =>  0,                     //Input: Description Padding ( Right )
			'grid_section_body_alignment'        =>  'center',              //Input: Body Text Alignment
			'grid_article_list_spacing'          =>  7,                    //Input: Article List Spacing
			'grid_section_body_padding_top'      =>  0,                     //Input: Padding Vertical ( Top )
			'grid_section_body_padding_bottom'   =>  0,                     //Input: Padding Vertical ( Bottom )
			'grid_section_body_padding_left'     =>  0,                    //Input: Padding Horizontal ( Left )
			'grid_section_body_padding_right'    =>  0,                     //Input: Padding Horizontal ( Right )

			//Features
			/*   'back_navigation_toggle'         => 'on',
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
			   'back_navigation_padding_right'  => '4', */

		);
	}

    /**
     * Return search box Style set based on selected layout
     *
     * @param $style_set
     * @param $layout_name
     * @param $set_name
     *
     * @return array
     */
    public static function get_search_box_style_set( $style_set, $layout_name, $set_name ) {

        if ( $layout_name != self::LAYOUT_NAME ) {
            return $style_set;
        }

        switch( $set_name) {
            case self::SEARCH_BOX_LAYOUT_STYLE_2:
                return self::get_search_box_style_2_set();
                break;
            case self::SEARCH_BOX_LAYOUT_STYLE_3:
                return self::get_search_box_style_3_set();
                break;
            case self::SEARCH_BOX_LAYOUT_STYLE_4:
                return self::get_search_box_style_4_set();
                break;
            case self::SEARCH_BOX_LAYOUT_STYLE_1:
            default:
                return self::get_search_box_style_1_set();
                break;
        }
    }

    private static function get_search_box_style_1_set() {
        return array(

            //Layout
            'grid_search_layout'                 =>  'elay-search-form-1',
            //Padding
            'grid_search_box_padding_top'        =>  40,
            'grid_search_box_padding_bottom'     =>  40,
            'grid_search_box_padding_left'       =>  0,
            'grid_search_box_padding_right'      =>  0,
            //Margin
            'grid_search_box_margin_top'         =>  40,
            'grid_search_box_margin_bottom'      =>  40,
            'grid_search_box_margin_left'        =>  0,
            'grid_search_box_margin_right'       =>  0,
            //Search Input Width
            'grid_search_box_input_width'        =>  50,

            //Search Input Border Width
            'grid_search_input_border_width'     =>  1

        );
    }

    private static function get_search_box_style_2_set() {
        return array(
            //Layout
            'grid_search_layout'                 =>  'elay-search-form-1',
            //Padding
            'grid_search_box_padding_top'        =>  40,
            'grid_search_box_padding_bottom'     =>  40,
            'grid_search_box_padding_left'       =>  0,
            'grid_search_box_padding_right'      =>  0,
            //Margin
            'grid_search_box_margin_top'         =>  40,
            'grid_search_box_margin_bottom'      =>  40,
            'grid_search_box_margin_left'        =>  0,
            'grid_search_box_margin_right'       =>  0,
            //Search Input Width
            'grid_search_box_input_width'        =>  50,

            //Search Input Border Width
            'grid_search_input_border_width'     =>  1
        );
    }

    private static function get_search_box_style_3_set() {
        return array(
            //Layout
            'grid_search_layout'                 =>  'elay-search-form-1',
            //Padding
            'grid_search_box_padding_top'        =>  40,
            'grid_search_box_padding_bottom'     =>  40,
            'grid_search_box_padding_left'       =>  0,
            'grid_search_box_padding_right'      =>  0,
            //Margin
            'grid_search_box_margin_top'         =>  40,
            'grid_search_box_margin_bottom'      =>  40,
            'grid_search_box_margin_left'        =>  0,
            'grid_search_box_margin_right'       =>  0,
            //Search Input Width
            'grid_search_box_input_width'        =>  50,

            //Search Input Border Width
            'grid_search_input_border_width'     =>  1
        );
    }

    private static function get_search_box_style_4_set() {
        return array(
            //Layout
            'grid_search_layout'                 =>  'elay-search-form-1',
            //Padding
            'grid_search_box_padding_top'        =>  40,
            'grid_search_box_padding_bottom'     =>  40,
            'grid_search_box_padding_left'       =>  0,
            'grid_search_box_padding_right'      =>  0,
            //Margin
            'grid_search_box_margin_top'         =>  40,
            'grid_search_box_margin_bottom'      =>  40,
            'grid_search_box_margin_left'        =>  0,
            'grid_search_box_margin_right'       =>  0,
            //Search Input Width
            'grid_search_box_input_width'        =>  50,

            //Search Input Border Width
            'grid_search_input_border_width'     =>  1
        );
    }

    public static function get_specs_defaults( $config_specs ) {
        $default_configuration = array();
        foreach( $config_specs as $key => $spec ) {
            $default = isset($spec['default']) ? $spec['default'] : '';
            $default_configuration += array( $key => $default );
        }
        return $default_configuration;
    }
}
