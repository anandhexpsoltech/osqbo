<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Advanced KB configuration
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPRF_KB_Config_Advanced {

	public static function register__hooks() {
		add_action( EPRF_KB_Core::EPRF_ADVANCED_CONFIG_AFTER_ARTICLE_PAGE, array('EPRF_KB_Config_Advanced', 'add_article_page_advanced'), 10, 2 );
	}

	/**
	 * Add text inputs to advanced Main Page
	 *
	 * @param $kb_id
	 * @param $kb_config
	 */
	public static function add_article_page_advanced ( $kb_id, $kb_config ) {
		$form = new EPRF_KB_Config_Elements();
		$eprf_specs = EPRF_KB_Config_Specs::get_fields_specification();
		$eprf_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading' => 'Rating and Feedback',
			'class'        => 'eckb-mm-mp-links-tuning-categories-advanced eckb-mm-ap-links-tuning-categories-advanced eckb-wizard-accordion__body',
			'inputs' => array(
				'0' => $form->text( $eprf_specs['rating_element_size'] + array(
						'value'             => $eprf_config['rating_element_size'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-5'
					) ),
				'1' => $form->text( $eprf_specs['rating_text_font_size'] + array(
						'value'             => $eprf_config['rating_text_font_size'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-5'
					) ),
				
			)
		));

	}

}
