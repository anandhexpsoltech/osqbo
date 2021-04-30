<?php

/**
 * Configuration for the front end editor
 */
 
class EPKB_Editor_Common_Config extends EPKB_Editor_Base_Config {

	/**
	 * Help Box zone
	 * @return array
	 */
	public static function help_box_zone() {

		$settings = [

			// Content Tab

			// - FAQs
			'help_box_faqs_title_header'             => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'type' => 'header',
				'content' => __( 'FAQs', 'echo-knowledge-base' ),
			],
			'help_box_faqs_title'                       => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.eckb-help_box__header_faq__title',
				'target_attr' => 'value',
				'text' => '1',
			],
			'help_box_faqs_top_button_title'                       => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.eckb-help_box__header-button-search span',
				'target_attr' => 'value',
				'text' => '1',
			],
			'help_box_faqs_search_placeholder'          => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'reload' => 1,
			],
			'help_box_faqs_read_more_text'              => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
			],

			// - Contact Us
			'help_box_contact_title_header'             => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'type' => 'header',
				'content' => __( 'Contact Us Form', 'echo-knowledge-base' ),
			],
			'help_box_contact_title'                    => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.eckb-help_box__header_contact__title',
				'target_attr' => 'value',
				'text' => '1',
			],
			'help_box_contact_top_button_title'                       => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.eckb-help_box__header-button-contact span',
				'target_attr' => 'value',
				'text' => '1',
			],
			'help_box_contact_name_placeholder'         => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'reload' => 1,
			],
			'help_box_contact_user_email_placeholder'        => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'reload' => 1,
			],
			'help_box_contact_subject_placeholder'      => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'reload' => 1,
			],
			'help_box_contact_comment_placeholder'      => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'reload' => 1,
			],
			'help_box_contact_button_title'             => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.epkb-help_box__contact-form-btn',
				'target_attr' => 'value',
				'text' => '1',
			],
			'help_box_contact_success_message'          => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
			],

			// Style Tab
			'help_box_launcher__header'                 => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Launcher', 'echo-knowledge-base' ),
			],
			'help_box_launcher_background_color'        => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help-box-toggle',
				'style_name' => 'background-color'
			],
			'help_box_launcher_background_hover_color'  => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help-box-toggle:hover',
				'style_name' => 'background-color'
			],
			'help_box_launcher_icon_color'              => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help-box-toggle',
				'style_name' => 'color'
			],
			'help_box_launcher_icon_hover_color'        => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help-box-toggle:hover',
				'style_name' => 'color'
			],

			'help_box_header'                           => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Help Box', 'echo-knowledge-base' ),
			],
			'help_box_background_color'                 => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '#eckb-help-box',
				'style_name' => 'background-color'
			],
			'help_box_text_color'                       => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__body',
				'style_name' => 'color'
			],
			'help_box_text_hover_color'                 => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' =>
					'.eckb-help_box__body .epkb-help_box_cat-item:hover,
					 .eckb-help_box__body .epkb-help_box_article-item:hover
					',
				'style_name' => 'color'
			],

			// - top toggle button
			'help_box_buttons_header'                   => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Top Toggle Button', 'echo-knowledge-base' ),
			],
			'help_box_top_button_color'                     => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-btn',
				'style_name' => 'background-color'
			],
			'help_box_top_button_hover_color'               => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-btn:hover',
				'style_name' => 'background-color'
			],
			'help_box_top_button_text_color'                => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-btn',
				'style_name' => 'color'
			],
			'help_box_top_button_text_hover_color'          => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-btn:hover',
				'style_name' => 'color'
			],

			// - Contact Us submit button
			'help_box_contact_form_header'              => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Contact Form', 'echo-knowledge-base' ),
			],
			'help_box_contact_button_color'             => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.epkb-help_box__contact-form-btn',
				'style_name' => 'background-color'
			],
			'help_box_contact_button_hover_color'       => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.epkb-help_box__contact-form-btn:hover',
				'style_name' => 'background-color'
			],
			'help_box_contact_button_text_color'        => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.epkb-help_box__contact-form-btn',
				'style_name' => 'color'
			],
			'help_box_contact_button_text_hover_color'  => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.epkb-help_box__contact-form-btn:hover',
				'style_name' => 'color'
			],

			'help_box_faqs_read_more_header'            => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Read More Link', 'echo-knowledge-base' ),
			],
			'help_box_faqs_read_more_text_color'        => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.epkb-help_box_article-link',
				'style_name' => 'color'
			],
			'help_box_faqs_read_more_text_hover_color'  => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' =>
					'.epkb-help_box_article-link:hover
					',
				'style_name' => 'color'
			],

			// - back button icon
			'help_box_back_icon_header'              => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Back Button', 'echo-knowledge-base' ),
			],
			'help_box_back_icon_color'                  => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-back-icon',
				'style_name' => 'color'
			],
			'help_box_back_icon_color_hover_color'      => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-back-icon:hover',
				'style_name' => 'color'
			],
			'help_box_back_icon_bg_color'               => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-back-icon',
				'style_name' => 'background-color'
			],
			'help_box_back_icon_bg_color_hover_color'   => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.eckb-help_box__header-back-icon:hover',
				'style_name' => 'background-color'
			],


			// Features Tab
			'help_box_enable' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'help_box_display_mode' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'help_box_logo_image_url' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1
			],
			'help_box_page_ids' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'description' => 'Enter comma separated ids or leave empty to show on all KB pages (more options in the future).',
			],
			'help_box_launcher_when_to_display' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1
			],
			'help_box_faqs_kb' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'help_box_faqs_category_ids' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'description' => 'Enter comma separated category ids.'
			],
			'help_box_contact_submission_email' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
			],

		];

		return [
			'help_box' => [
				'title'     =>  __( 'Help Box', 'echo-knowledge-base' ),
				'classes'   => '#eckb-help-box',
				'settings'  => $settings,
				'disabled_settings' => [
					'help_box_enable' => 'off'
				]
			]];
	}
}