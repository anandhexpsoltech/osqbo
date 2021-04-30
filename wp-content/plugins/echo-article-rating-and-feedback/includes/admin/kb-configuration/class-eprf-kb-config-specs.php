<?php

/**
 * Lists all KB configuration settings and adds filter to get configuration from add-ons.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class EPRF_KB_Config_Specs {

	private static $cached_specs = array();

	/**
	 * Defines how KB configuration fields will be displayed, initialized and validated/sanitized
	 *
	 * ALL FIELDS ARE MANDATORY by default ( otherwise use 'mandatory' => false )
	 *
	 * @return array with KB config specification
	 */
	public static function get_fields_specification() {

		// retrieve settings if already cached
		if ( ! empty(self::$cached_specs) && is_array(self::$cached_specs) ) {
			return self::$cached_specs;
		}

		// get all configuration
		$config_specification = array(

			// RATING ELEMENT
			'rating_mode'                 => array(
					'label'       => __( 'Mode', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_mode',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     => array(
							'eprf-rating-mode-five-stars' => __( '5 Stars' ),
							'eprf-rating-mode-like-dislike' => __( 'Like / Dislike' ),
					),
					'default'     => 'eprf-rating-mode-five-stars'
			),
			'rating_element_color'               => array(
					'label'       => __( 'Rating Element', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_element_color',
					'size'        => '10',
					'max'         => '7',
					'min'         => '7',
					'type'        => EPRF_Input_Filter::COLOR_HEX,
					'default'     => '#1e73be'
			),
			'rating_like_color'               => array(
					'label'       => __( 'Button Up ', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_like_color',
					'size'        => '10',
					'max'         => '7',
					'min'         => '7',
					'type'        => EPRF_Input_Filter::COLOR_HEX,
					'default'     => '#81d742'
			),
			'rating_dislike_color'               => array(
					'label'       => __( 'Button Down', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_dislike_color',
					'size'        => '10',
					'max'         => '7',
					'min'         => '7',
					'type'        => EPRF_Input_Filter::COLOR_HEX,
					'default'     => '#dd3333'
			),
			'rating_element_size'                => array(
					'label'       => __( 'Rating Element Size', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_element_size',
					'max'         => '50',
					'min'         => '1',
					'type'        => EPRF_Input_Filter::NUMBER,
					'default'     => 30
			),
			'rating_stars_text_1' => array(
					'label'       => __( 'Text 1 Star', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_stars_text_1',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Unusable Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_2' => array(
					'label'       => __( 'Text 2 Stars', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_stars_text_2',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Poor Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_3' => array(
					'label'       => __( 'Text 3 Stars', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_stars_text_3',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'OK Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_4' => array(
					'label'       => __( 'Text 4 Stars', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_stars_text_4',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Good Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_5' => array(
					'label'       => __( 'Text 5 Stars', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_stars_text_5',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Excellent Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_like_style'   => array(
					'label'       => __( 'Like/Dislike Style', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_like_style',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     =>
							array(
									'rating_like_style_1'          => 'Thumbs Up / Down',
									'rating_like_style_2'          => 'Check / Cross',
									'rating_like_style_3'          => 'Arrow Up / Down',
									'rating_like_style_4'         => 'Buttons',
							),
					'default'     => 'rating_like_style_1',
			),
			'rating_like_style_yes_button' => array(
					'label'       => __( 'Button Positive Text', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_like_style_yes_button',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Yes', 'echo-article-rating-and-feedback' )
			),
			'rating_like_style_no_button' => array(
					'label'       => __( 'Button Negative Text', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_like_style_no_button',
					'size'        => '30',
					'max'         => '50',
					'min'         => '0',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'No', 'echo-article-rating-and-feedback' )
			),


			// RATING LAYOUT
			'rating_layout'                 => array(
					'label'       => __( 'Rating Layout', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_layout',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     =>
							array(
									'rating_layout_1'          => 'Text beside Rating Element',
									'rating_layout_2'          => 'Text above Rating Element',
									//'rating_layout_3'          => 'Text beside Rating Element beside Statistics',
									//'rating_layout_4'          => 'Text above Rating Element beside Statistics',
							),
					'default'     => 'rating_layout_1',
			),
			'rating_stats_meta' => array(
					'label'       => __( 'Rating Meta Information', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_stats_meta',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     => array(
							'none'   => __( 'Not Displayed', 'echo-article-rating-and-feedback' ),
							'top'    => __( 'Show Above Article', 'echo-article-rating-and-feedback' ),
							'bottom' => __( 'Show Below Article', 'echo-article-rating-and-feedback' )
					),
					'default'     => 'top'
			),

			// TEXT above rating
			'rating_text_value'   => array(
					'label'       => __( 'Rating Instructions', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_text_value',
					'size'        => '50',
					'max'         => '200',
					'min'         => '1',
					'mandatory'   => false,
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Was this article helpful?', 'echo-article-rating-and-feedback' )
			),
			/* 'rating_after_vote_text' => array(
					'label'       => __( 'Rating Information', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_after_vote_text',
					'size'        => '50',
					'max'         => '200',
					'min'         => '1',
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( '', 'echo-article-rating-and-feedback' )
			), */
			'rating_element_location'                 => array(
					'label'       => __( 'Location of Rating', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_element_location',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     => array(
							'rating-above-article' => __( 'Above the Article' ),
							'rating-below-article' => __( 'Below the Article' ),
					),
					'default'     => 'rating-below-article'
			),
			'rating_text_color'               => array(
					'label'       => __( 'Text', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_text_color',
					'size'        => '10',
					'max'         => '7',
					'min'         => '7',
					'type'        => EPRF_Input_Filter::COLOR_HEX,
					'default'     => '#000000'
			),
			'rating_dropdown_color'               => array(
					'label'       => __( 'Stats Drop-Down', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_dropdown_color',
					'size'        => '10',
					'max'         => '7',
					'min'         => '7',
					'type'        => EPRF_Input_Filter::COLOR_HEX,
					'default'     => '#1e73be'
			),
			'rating_text_font_size'                => array(
					'label'       => __( 'Text Font Size ( px )', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_text_font_size',
					'max'         => '50',
					'min'         => '1',
					'type'        => EPRF_Input_Filter::NUMBER,
					'default'     => 16
			),

			// RATING CONFIRMATION
			'rating_confirmation_positive' => array(
					'label'       => __( 'Show message after user voted.', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_confirmation_positive',
					'size'        => '50',
					'max'         => '200',
					'min'         => '0',
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Your vote has been submitted. Thanks!', 'echo-article-rating-and-feedback' )
			),
			'rating_confirmation_negative' => array(
					'label'       => __( 'Show message if user voted twice.', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_confirmation_negative',
					'size'        => '50',
					'max'         => '200',
					'min'         => '0',
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'We already received your feedback.', 'echo-article-rating-and-feedback' )
			),

			// ARTICLE FEEDBACK OPRIONS
			'rating_feedback_title' => array(
					'label'       => __( 'Form Title', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_title',
					'type'        => EPRF_Input_Filter::TEXT,
					'max'         => '200',
					'min'         => '0',
					'default'     => __( 'How can we improve this article?', 'echo-article-rating-and-feedback' ),
			),
			'rating_feedback_name_prompt' => array(
					'label'       => __( 'Show the Name Field?', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_name_prompt',
					'type'        => EPRF_Input_Filter::CHECKBOX,
					'default'     => 'on'
			),
			'rating_feedback_email_prompt' => array(
					'label'       => __( 'Show the Email Field?', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_email_prompt',
					'type'        => EPRF_Input_Filter::CHECKBOX,
					'default'     => 'on'
			),
			'rating_feedback_description' => array(
					'label'       => __( 'Description Hint for the User', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_description',
					'type'        => EPRF_Input_Filter::TEXT,
					'max'         => '200',
					'min'         => '0',
					'default'     => '',
					'mandatory'   => false
			),
			'rating_feedback_support_link_text' => array(
					'label'       => __( 'Text for Support URL Link', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_support_link_text',
					'type'        => EPRF_Input_Filter::TEXT,
					'max'         => '200',
					'min'         => '0',
					'default'     => 'Need help?',
					'mandatory'   => false
			),
			'rating_feedback_support_link_url' => array(
					'label'       => __( 'Support Link URL', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_support_link_url',
					'type'        => EPRF_Input_Filter::TEXT,
					'max'         => '200',
					'min'         => '0',
					'default'     => '',
					'mandatory'   => false
			),
			'rating_feedback_button_color' => array(
					'label'       => __( 'Submit Button', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_button_color',
					'size'        => '10',
					'max'         => '7',
					'min'         => '7',
					'type'        => EPRF_Input_Filter::COLOR_HEX,
					'default'     => '#000000'
			),
			'rating_feedback_button_text' => array(
					'label'       => __( 'Submit Button Text', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_button_text',
					'type'        => EPRF_Input_Filter::TEXT,
					'default'     => __( 'Submit', 'echo-article-rating-and-feedback' ),
			),
			'rating_feedback_trigger_stars' => array(
					'label'       => __( 'When Does the Feedback Form Becomes Visible?', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_trigger_stars',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     => array(
							'never' => __( 'Never', 'echo-article-rating-and-feedback' ),
							'negative-four' => __( 'If user votes less than 4 stars', 'echo-article-rating-and-feedback' ),
							'negative-five' => __( 'If user votes less than 5 stars', 'echo-article-rating-and-feedback' ),
							'user-votes' => __( 'If user votes', 'echo-article-rating-and-feedback' ),
							'always' => __( 'Always', 'echo-article-rating-and-feedback' ),
					),
					'default'     => 'negative-four'
			),
			'rating_feedback_trigger_like' => array(
					'label'       => __( 'When Does the Feedback Form Becomes Visible?', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_feedback_trigger_like',
					'type'        => EPRF_Input_Filter::SELECTION,
					'options'     => array(
							'never' => __( 'Never', 'echo-article-rating-and-feedback' ),
							'dislike' => __( 'If user votes down', 'echo-article-rating-and-feedback' ),
							'always' => __( 'Always', 'echo-article-rating-and-feedback' ),
					),
					'default'     => 'dislike'
			),
		);

		self::$cached_specs = $config_specification;

		return self::$cached_specs;
	}

	/**
	 * Get KB default configuration
	 *
	 * @return array contains default values for KB configuration
	 */
	public static function get_default_kb_config() {
		$config_specs = self::get_fields_specification();

		$configuration = array();
		foreach( $config_specs as $key => $spec ) {
			$default = isset($spec['default']) ? $spec['default'] : '';
			$configuration += array( $key => $default );
		}

		return $configuration;
	}

	/**
	 * Get names of all configuration items for KB configuration
	 * @return array
	 */
	public static function get_specs_item_names() {
		return array_keys( self::get_fields_specification() );
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
