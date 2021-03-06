<?php  if ( ! defined( 'ABSPATH' ) ) exit;

class ELAY_KB_Config_Layouts {

	public function __construct( $register_layout_name=false ) {
		if ( $register_layout_name ) {
			add_filter( ELAY_KB_Core::ELAY_KB_LAYOUT_NAMES, array( 'ELAY_KB_Config_Layouts', 'get_main_page_layout_name_value' ) );
			add_filter( ELAY_KB_Core::ELAY_KB_ARTICLE_PAGE_LAYOUT_NAMES, array( 'ELAY_KB_Config_Layouts', 'get_article_page_layout_names' ) );
			add_filter( ELAY_KB_Core::ELAY_KB_STYLE_NAMES, array( 'ELAY_KB_Config_Layouts', 'get_style_names' ) );
			add_filter( ELAY_KB_Core::ELAY_KB_LAYOUT_MAPPING, array( 'ELAY_KB_Config_Layouts', 'get_layout_mapping' ) );
			add_filter( ELAY_KB_Core::ELAY_KB_MAX_LAYOUT_LEVEL, array( 'ELAY_KB_Config_Layouts', 'get_max_layout_level') );
			add_filter( ELAY_KB_Core::ELAY_KB_LAYOUT_INFO_MESSAGE, array( 'ELAY_KB_Config_Layouts', 'get_layout_info_message') );
		} else {
			add_action( ELAY_KB_Core::ELAY_KB_REGISTER_KB_CONFIG_HOOKS, array( 'ELAY_KB_Config_Layouts', 'register_kb_config_hooks' ) );
		}
		
		ELAY_KB_Wizard::register_all_wizard_hooks();

		ELAY_KB_Config_Advanced::register__hooks();
	}
	
	/**
	 * Get all known Main Page layouts for this add-ons
	 *
	 * @param $core_layouts
	 * @return array layout names for this add-on
	 */
	public static function get_main_page_layout_name_value( $core_layouts ) {
		return array_merge( $core_layouts, array(
							ELAY_KB_Config_Layout_Grid::LAYOUT_NAME    =>  __( ELAY_KB_Config_Layout_Grid::LAYOUT_NAME, 'echo-knowledge-base' ),
		                    ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME =>  __( ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME, 'echo-knowledge-base' ) ) );
	}

	/**
	 * Does given layout show articles as well?
	 *
	 * @param $layout
	 * @return true if this Main Page layout displayes articles as well
	 */
	public static function is_main_page_displaying_sidebar( $layout ) {
		return in_array( $layout, array(ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME) );
	}

	/**
	 * Get all layouts that shows article on the KB Main Page
	 *
	 * @param $layout
	 * @return true if this Article Page layout displayes some kind of layout
	 */
	public static function is_article_page_displaying_sidebar( $layout ) {
		return  in_array( $layout, array(ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME) );
	}

	/**
	 * Get all known Article Page layouts for this add-on
	 *
	 * @param $core_layouts
	 * @return array all Page 2 layouts
	 */
	public static function get_article_page_layout_names( $core_layouts ) {
		return array_merge( $core_layouts, array( ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME    => ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME,
		                                          ELAY_KB_Config_Layout_Sidebar::NO_LAYOUT_NAME => ELAY_KB_Config_Layout_Sidebar::NO_LAYOUT_NAME  ) );
	}

	public static function get_style_names() {
		return array( ELAY_KB_Config_Layout_Grid::LAYOUT_NAME => array(
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_1 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_1,
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_2 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_2,
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_3 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_3,
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_4 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_4,
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_5 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_5,
		                    ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_6 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_6,
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_7 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_7,
		                    ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_8 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_8,
							ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_9 => ELAY_KB_Config_Layout_Grid::LAYOUT_STYLE_9
						),
		              ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME => array(
			                ELAY_KB_Config_Layout_Sidebar::LAYOUT_STYLE_1 => ELAY_KB_Config_Layout_Sidebar::LAYOUT_STYLE_1,
		                    ELAY_KB_Config_Layout_Sidebar::LAYOUT_STYLE_2 => ELAY_KB_Config_Layout_Sidebar::LAYOUT_STYLE_2,
		                    ELAY_KB_Config_Layout_Sidebar::LAYOUT_STYLE_3 => ELAY_KB_Config_Layout_Sidebar::LAYOUT_STYLE_3 )
						);
	}

	/**
	 * Mapping from Main Page to Article Page
	 *
	 * @param $core_layouts
	 * @return array all defined layout mapping
	 */
	public static function get_layout_mapping( $core_layouts ) {
		return array_merge( $core_layouts, array(
								array( 'Basic' => ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ),
								array( 'Tabs' => ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ),
								array( ELAY_KB_Config_Layout_Grid::LAYOUT_NAME => ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ),
								array( ELAY_KB_Config_Layout_Grid::LAYOUT_NAME => ELAY_KB_Config_Layout_Sidebar::NO_LAYOUT_NAME ),
								array( ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME => ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME )
							) );
	}

	/**
	 * Register Elegant Layouts for KB Config page
	 */
	public static function register_kb_config_hooks() {

		// Sidebar Layout might need WP Editor so include it in non-Ajax way (loading WP Editor with Ajax is problematic)
		add_action( 'eckb_additional_output', array( 'ELAY_KB_Config_Layouts', 'get_wp_editor' ), 99 );

		// register GRID LAYOUT
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_STYLE_SETTINGS, array( 'ELAY_KB_Config_Layout_Grid', 'get_kb_config_style' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_COLORS_SETTINGS, array( 'ELAY_KB_Config_Layout_Grid', 'get_kb_config_colors' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_TEXT_SETTINGS, array( 'ELAY_KB_Config_Layout_Grid', 'get_kb_config_text' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_COLORS_SET, array( 'ELAY_KB_Config_Layout_Grid', 'get_colors_set' ), 10, 3 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_STYLE_SET, array( 'ELAY_KB_Config_Layout_Grid', 'get_style_set' ), 10, 3 );

		// register SIDEBAR LAYOUT
		// Main Page
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_STYLE_SETTINGS, array( 'ELAY_KB_Config_Layout_Sidebar',	'get_kb_config_style' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_COLORS_SETTINGS, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_kb_config_colors' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_TEXT_SETTINGS, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_kb_config_text' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_COLORS_SET, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_colors_set' ), 10, 3 );
		add_filter( ELAY_KB_Core::ELAY_KB_MAIN_PAGE_STYLE_SET, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_style_set' ), 10, 3 );

		// Article Page
		add_filter( ELAY_KB_Core::ELAY_ARTICLE_PAGE_STYLE_SETTINGS, array( 'ELAY_KB_Config_Layout_Sidebar',	'get_kb_config_style' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_ARTICLE_PAGE_COLORS_SETTINGS, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_kb_config_colors' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_ARTICLE_PAGE_TEXT_SETTINGS, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_kb_config_text' ), 10, 2 );
		add_filter( ELAY_KB_Core::ELAY_ARTICLE_PAGE_COLORS_SET, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_colors_set' ), 10, 3 );
		add_filter( ELAY_KB_Core::ELAY_ARTICLE_PAGE_STYLE_SET, array( 'ELAY_KB_Config_Layout_Sidebar', 'get_style_set' ), 10, 3 );
	}

	/**
	 * Display WP Editor for a configuration field hidden so that it can be displayed on request in a non-JQuery dialog.
	 *
	 * @param $kb_config
	 */
	public static function get_wp_editor( $kb_config ) {

		// do not run on Ajax
		if ( empty($_REQUEST['form']) ) {

			$intro_text = elay_get_instance()->kb_config_obj->get_value( $kb_config['id'], 'sidebar_main_page_intro_text', '' );

			$args = array(
				'id'                => 'sidebar_main_page_intro_text',
				'value'             => $intro_text,
				'input_group_class' => '',
				'main_label_class'  => '',
				'input_class'       => '',
				'label'             => 'Introductory Text for Main Page'
			);
			
			echo '<div id="eckb-hidden-wp-editor-container" style="display:none;">';
				echo '<div class="eckb-wp-editor-title">Introductory Text for the Sidebar Main Page</div>';
				ELAY_KB_Config_Elements::get_wp_editor( $args );
				echo '<div id="eckb-popup-ok-button" class="eckb-wp-editor-update">OK</div>';
				echo '<div id="eckb-popup-cancel-button" class="eckb-wp-editor-update">Cancel</div>';
			echo '</div>';
		}
	}
	
	public static function get_max_layout_level( $layout ) {
		if ( $layout === ELAY_KB_Config_Layout_Grid::LAYOUT_NAME ) {
			return ELAY_KB_Config_Layout_Grid::CATEGORY_LEVELS;
		}
		if ( $layout === ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ) {
			return ELAY_KB_Config_Layout_Sidebar::CATEGORY_LEVELS;
		}

		return $layout;
	}

	public static function get_layout_info_message( $output ) {
		return '<li><strong>Sidebar Layout</strong> ??? shows left sidebar that lists categories, sub-categories and articles.</li>
				<li><strong>Grid Layout</strong> ??? displays top level categories in rows and columns with an optional icon and a link to corresponding documentation.</li>';
	}
}
