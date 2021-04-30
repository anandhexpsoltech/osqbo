<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display the Advanced Search Box
 *
 */
class ASEA_Search_Box_View {

    public function __construct() {
        add_action( 'eckb_advanced_search_box', array( $this, 'display_advanced_search_structure' ) );
	    add_action( 'asea_search_background_image', array( $this, 'display_background_image' ) );
	    add_action( 'asea_search_gradient_background', array( $this, 'display_gradient' ) );
	    add_action( 'asea_search_pattern_image', array( $this, 'display_pattern_image' ) );
	    add_action( 'asea_sub_section_1_1_content', array( $this, 'display_h1_title' ) );
	    add_action( 'asea_sub_section_1_1_content', array( $this, 'display_paragraph_description_below_title' ) );
        add_action( 'asea_sub_section_1_2_content', array( $this, 'display_search_input_and_results_box' ) );
	    add_action( 'asea_sub_section_1_3_content', array( $this, 'display_paragraph_description_below_input' ) );
        add_action( 'asea_section_1_styles', array( $this, 'asea_section_1_styles' ) );
        add_action( 'asea_search_container_style_tags', array( $this, 'asea_search_container_style_tags' ) );
		add_action( 'eckb_after_theme_preview', array( $this, 'asea_search_container_style_tags' ), 10, 2 );
	    add_action( 'eckb_doc_search_container_after', array( $this, 'search_toggle' ) );
	    add_action( 'eckb_doc_search_container_classes', array( $this, 'eckb_doc_search_container_classes' ) );
    }

	/**
	 * Display the main layout structure of the Advanced Search.
	 * Hooks are positioned within the Advanced Search layout so that HTML elements can be displayed in different order.
	 * Layout has 3 Main sections and each section will have 5 sub sections to hook into.
	 * There is one hook after the whole search boxes for future use.
	 *
	 * @param array $kb_config Current active KB settings.
	 *
	 */
	public function display_advanced_search_structure( $kb_config ) {
		global $eckb_is_kb_main_page;

		// add ASEA configuration
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_config['id'] );
		if ( is_wp_error($asea_config) ) {
			return;
		}

		$kb_config = array_merge($asea_config, $kb_config);

		//If Setting to set the search box to be hidden , return since we don't need to run the remaining code.
		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_visibility' ) === 'asea-visibility-search-form-2' ) {
			return;
		}

		$main_page_indicator = empty($eckb_is_kb_main_page) ? '' : 'eckb_search_on_main_page';  ?>

		<!-------- ASEA Main Container ----------->
		<div id="asea-doc-search-container" class="asea-loading <?php echo $main_page_indicator . ' '; do_action('eckb_doc_search_container_classes', $kb_config ); ?>" style="opacity:0;">

			<?php do_action('asea_search_container_style_tags', $kb_config ); ?>

			<!-------- ASEA Search Container # 1 ----------------->
			<section id="asea-section-1" <?php do_action('asea_section_1_styles', $kb_config ); ?>>

				<!-------- ASEA Background Image Container ------>
				<div id="asea-search-background-image-1" <?php do_action('asea_search_background_image', $kb_config ); ?>></div>

				<!-------- ASEA Gradient Container -------------->
				<div id="asea-search-gradient-1" <?php do_action('asea_search_gradient_background', $kb_config ); ?>></div>

				<!-------- ASEA Pattern Container --------------->
				<div id="asea-search-pattern-1"  <?php do_action('asea_search_pattern_image', $kb_config ); ?>></div>

				<!-------- ASEA Sub Section Container 1-1 --------------->
				<section id="asea-sub-section-1-1"><?php do_action('asea_sub_section_1_1_content', $kb_config ); ?></section>

				<!-------- ASEA Sub Section Container 1-2 --------------->
				<section id="asea-sub-section-1-2"><?php do_action('asea_sub_section_1_2_content', $kb_config ); ?></section>

				<!-------- ASEA Sub Section Container 1-3 --------------->
				<section id="asea-sub-section-1-3"><?php do_action('asea_sub_section_1_3_content', $kb_config ); ?></section>

				<!-------- ASEA Sub Section Container 1-4 --------------->
				<section id="asea-sub-section-1-4"><?php do_action('asea_sub_section_1_4_content', $kb_config ); ?></section>

				<!-------- ASEA Sub Section Container 1-5 --------------->
				<section id="asea-sub-section-1-5"><?php do_action('asea_sub_section_1_5_content', $kb_config ); ?></section>

			</section>

		</div>		<?php

		do_action('eckb_doc_search_container_after', $kb_config );
	}

	/**
 * Display Background Image
 * @param $kb_config
 */
	public function display_background_image( $kb_config ) {

		$background_image_url = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_image_url' );
		$background_image_url = trim($background_image_url);
		if ( ! empty($background_image_url) ) {
			echo 'style="';
			echo 'background-image: url(' . $background_image_url . ');';
			echo 'background-position-x:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_image_position_x' ) . ';';
			echo 'background-position-y:'. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_image_position_y' ) . ';';
			echo '"';
		}
	}

	/**
	 * Display Gradient
	 * @param $kb_config
	 */
	public function display_gradient( $kb_config ) {

		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_gradient_toggle' ) == 'on' ) {
			echo 'style="';
			echo 'background: linear-gradient(' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_gradient_degree' ) . 'deg,' .
			     ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_gradient_from_color' ) . ' 0%,' .
				 ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_gradient_to_color' ) . ' 100% );';
			echo 'opacity:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_gradient_opacity' ) . ';';
			echo '"';
		}
	}

	/**
	 * Display Background Pattern Image
	 * @param $kb_config
	 */
	public function display_pattern_image( $kb_config ) {

		$background_pattern_image_url = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_pattern_image_url' );
		$background_pattern_image_url = trim($background_pattern_image_url);
		if ( ! empty($background_pattern_image_url) ) {
			echo 'style="';
			echo 'background-image: url(' . $background_pattern_image_url . ');';
			echo 'background-position-x:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_pattern_image_position_x' ) . ';';
			echo 'background-position-y:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_pattern_image_position_y' ) . ';';
			echo 'opacity:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_pattern_image_opacity' ) . ';';
			echo '"';
		}
	}

	/**
	 * Display H1 title
	 * @param $kb_config
	 */
	public function display_h1_title( $kb_config ) {

		//Inline Styles ----------------------------------/
		$h1_style  = 'style="';
			$h1_style .= 'color:' .             ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_font_color') . ';';
			$h1_style .= 'font-size:' .         ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_font_size') . 'px;';
			$h1_style .= 'font-weight:' .       ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_font_weight') . ';';
			$h1_style .= 'padding-bottom:' .    ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_padding_bottom') . 'px;';

		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_text_shadow_toggle') == 'on' ) {
			$h1_style .= 'text-shadow:'
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_text_shadow_x_offset') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_text_shadow_y_offset') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_text_shadow_blur') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_font_shadow_color') . '; '
			;
		}
		$h1_style .= '"';

		$search_title = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title' );
		$search_title = trim($search_title);

		$background_color = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_background_color');
		$title_font_color = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_font_color');
		if ( $background_color == $title_font_color ) {
			$search_title = '';                             ?>
			<div style='padding-top: 40px;'></div>     <?php
		}

		// user can specify tag for search title
		$title_tag =  ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_tag');
		if ( ! empty($search_title) || isset( $_GET['wizard-text-on'] ) ) { ?>
			<<?php echo $title_tag; ?> id="asea-search-title"<?php echo $h1_style; ?>> <?php echo wp_kses_post( $search_title ); ?></<?php echo $title_tag; ?>>	<?php
		}
	}

	/**
	 * Display Paragraph Description 1
	 * @param $kb_config
	 */
	public function display_paragraph_description_below_title( $kb_config ) {

		//Get Input Width Value so that the description matches in length.
		$search_input_width = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_font_width' );

		//Inline Styles ----------------------------------/
		$desc_style  = 'style="';
		$desc_style .= 'color:' .             ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_title_font_color') . ';';
		$desc_style .= 'font-size:' .         ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_font_size') . 'px;';
		$desc_style .= 'padding-top:' .    ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_padding_top') . 'px;';
		$desc_style .= 'padding-bottom:' .    ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_padding_bottom') . 'px;';
		$desc_style .= 'width:' .    $search_input_width . '%;';

		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_text_shadow_toggle') == 'on' ) {
			$desc_style .= 'text-shadow:'
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_text_shadow_x_offset') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_text_shadow_y_offset') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_text_shadow_blur') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title_font_shadow_color') . '; '
			;
		}
		$desc_style .= '"';

		$below_title_text = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_title' );
		$below_title_text = trim($below_title_text);
		if ( ! empty($below_title_text) || ! empty ($_POST['epkb-wizard-demo-data']) ) {     ?>
			<p id="asea-search-description-1" class="<?php if ( empty($below_title_text) ) echo 'asea-search-description--empty'; ?>" <?php echo $desc_style; ?>> <?php echo wp_kses_post( $below_title_text ); ?></p>  <?php
		}
	}

	/**
	 * Display Paragraph Description 2
	 * @param $kb_config
	 */
	public function display_paragraph_description_below_input( $kb_config ) {

		//Get Input Width Value so that the description matches in length.
		$search_input_width = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_font_width' );

		$style3 = $this->get_inline_style( $kb_config, '
							color:: advanced_search_*_title_font_color,
							font-size:: advanced_search_*_description_below_input_font_size,	
							padding-top:: advanced_search_*_description_below_input_padding_top,	
							padding-bottom:: advanced_search_*_description_below_input_padding_bottom,	
							width:' . $search_input_width . '%
		');
		
		$style3_demo = $this->get_inline_style( $kb_config, '
							color:: advanced_search_*_title_font_color,
							font-size:: advanced_search_*_description_below_input_font_size,	
		');
		
		$below_input_text = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_description_below_input' );
		$below_input_text = trim($below_input_text);
	/*	$below_input_text = empty($below_input_text) && ! empty($_POST['epkb-wizard-demo-data']) ? '<a href="https://www.echoknowledgebase.com/documentation/" target="_blank" ' . $style3_demo . ' >Documentation</a> | '.
		                                                             '<a href="https://www.echoknowledgebase.com/blog/" target="_blank" ' . $style3_demo . ' >Blog</a> | ' .
		                                                             '<a href="https://www.echoknowledgebase.com/demo-1-knowledge-base-basic-layout/" target="_blank" ' . $style3_demo . ' >Demos</a> | ' .
		                                                             '<a href="https://www.echoknowledgebase.com/contact-us/" target="_blank" ' . $style3_demo . ' >Support</a>' : $below_input_text; */
		if ( ! empty($below_input_text) || ! empty($_POST['epkb-wizard-demo-data']) ) {     ?>
			<p id="asea-search-description-2" class="<?php if ( empty($below_input_text) ) echo 'asea-search-description--empty'; ?>" <?php echo $style3; ?>> <?php echo wp_kses_post( $below_input_text ); ?></p>	<?php
		}
	}

	/**
	 * Display Search Input and Results
	 * @param $kb_config
	 */
	public function display_search_input_and_results_box( $kb_config ) {    ?>

		<script>
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		</script>   <?php

		$search_filter = empty($kb_config['search_multiple_kbs']) ? ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_toggle') : 'off';

		//Search Box container style  ---------------------------------------------------------------------------------/
		$search_box_style = 'style="';
		$search_box_style .= 'border-width:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_border_width') . 'px;';
		$search_box_style .= 'border-radius:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_radius') . 'px;';
		$search_box_style .= 'font-size:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_font_size') . 'px;';
		$search_box_style .= 'border-color:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_text_input_border_color') . ';';
		$search_box_style .= 'background-color:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_text_input_background_color') . ';';
		$search_box_style .= 'background:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_text_input_background_color') . ';';
		$search_box_style .= 'padding-left:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_left') . 'px;';
		$search_box_style .= 'padding-right:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_right') . 'px;';
		$search_box_style .= 'border-style: solid;';

		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_shadow_rgba') ) {
			$search_box_style .= 'box-shadow:'
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_shadow_x_offset') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_shadow_y_offset') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_shadow_blur') . 'px '
				. ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_shadow_spread') . 'px '.
				'rgba(' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_shadow_rgba') .')
			;';
		}
		$search_box_style .= '"';

		//Input Box Styles --------------------------------------------------------------------------------------------/
		$input_style  = 'style="';
		$input_style .= 'padding-top:' .    ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_top') .    'px;';
		$input_style .= 'padding-bottom:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_bottom') . 'px;';

		// We need to compensate for the search and loading icons spacing to the left and right
		// If the Search Icon is active
		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_search_icon_placement' ) != 'none' ) {
			//Get the font size of the input box which will tell us how big the icon size is.
			$search_icon_size = intval( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_font_size' ) ) + 5;
			$search_icon_placement = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_search_icon_placement' );
			$input_style .= 'padding-'.$search_icon_placement.':' . $search_icon_size . 'px;';
		}

		// If loading icon is on the left we need to add some spacing between the text and the loading icon.
		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_loading_icon_placement' ) == 'left' ) {
			//Get the font size of the input box which will tell us how big the icon size is.
			$loading_icon_size = intval( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_font_size' ) ) + 5;
			$input_style .= 'padding-left:' . $loading_icon_size . 'px;';
		}


		//Search Results CSS / Styles ---------------------------------------------------------------------------------/
		echo '<style>';
			echo '  #asea-doc-search-container #asea_search_form #asea_search_results ul li a .eckb-article-title,
					#asea-doc-search-container #asea_search_form #asea_search_results ul li a .eckb-article-title .eckb-article-title-icon,
					#asea-doc-search-container #asea_search_form #asea_search_results #asea-all-search-results a
			{ font-size:'.ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_search_results_article_font_size' ) .'px; }';
		echo '</style>';

		$input_style .= '"';

		$class1 = $this->get_css_class( $kb_config, 'asea-search, : advanced_search_*_layout' );

		$search_input_width = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_input_width' );
		$form_style = $this->get_inline_style($kb_config, 'width:' . $search_input_width . '%' );		

		$search_dropdown_width = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_dropdown_width' );
		$search_dropdown_style = $this->get_inline_style($kb_config, 'max-width:' . $search_dropdown_width . 'px' );

		$category_level = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_category_level' );

		$kb_ids = empty($kb_config['search_multiple_kbs']) ? $kb_config['id'] : $kb_config['search_multiple_kbs'];  ?>


		<div id="asea-doc-search-box-container">

			<form id="asea_search_form" <?php echo $form_style . ' ' . $class1; ?> method="get" action="">

				<!----- Search Box ------>
				<div class="asea-search-box" <?php echo $search_box_style; ?>>
					<input type="text" <?php echo $input_style; ?> id="asea_advanced_search_terms" name="asea_search_terms" value="" placeholder="<?php echo esc_attr( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_hint') ); ?>" />
					<input type="hidden" id="asea_kb_id" value="<?php echo $kb_ids; ?>"/>					<?php

					// If the search filter is on, we need to move some elements so that they can be aligned properly via CSS.
					if ( $search_filter == 'on' ) {

						// If the Search Icon is located on the left it needs to be outputted here for alignment reasons with CSS.
						if( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_search_icon_placement' ) == 'left' ) {
							$this->asea_search_icon( $kb_config );
						}

						// If the loading Icon is located on the left it needs to be outputted here for alignment reasons with CSS.
						if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_loading_icon_placement' ) == 'left' ) {
							$this->asea_loading_spinner( $kb_config );
						}

						$this->asea_search_filter_icon( $kb_config );

					} else {
						// If no search filter is active then proceed with regular setup.
						$this->asea_loading_spinner( $kb_config );
						$this->asea_search_icon( $kb_config );
					}					 ?>
				</div>

				<!----- Search Box filter ------>
				<div class="asea-search-filter-container <?php echo $category_level; ?>" <?php echo $search_dropdown_style; ?>>

					<fieldset>
						<legend><?php _e('Filter by Categories', 'echo-advanced-search'); ?></legend>
						<span id="asea-search-filter-clear-results"><?php _e('Clear Results', 'echo-advanced-search'); ?></span>						<?php

						$kb_taxonomy = ASEA_KB_Handler::get_category_taxonomy_name( $kb_config['id'] );
						$args = array(
							'taxonomy'      => $kb_taxonomy,
							'orderby'       => 'name',
							'order'         => 'ASC',
							'hide_empty'    => false,
							'hierarchical'  => 1,
							'parent' 		=> 0
						);
						$selected_categories = get_categories($args); 

						//Category Level settings  ?>
						 <div class="asea-filter-category-options-container">	
						 	<ul>						 	<?php

							foreach( $selected_categories as $selected_category ) {
							
								$args = array(
									'taxonomy'      => $kb_taxonomy,
									'orderby'       => 'name',
									'order'         => 'ASC',
									'hide_empty'    => false,
									'hierarchical'  =>1,
									'parent' => $selected_category->term_id
								);
								$child_categories = get_categories($args); 								?>

								<li>
								<div class="asea-filter-option">
										<label>
											<input class="asea-filter-option-input" name="cat-<?php echo $selected_category->term_id; ?>" type="checkbox" value="<?php echo $selected_category->term_id; ?>">
											<span class="asea-filter-option-label"><?php echo $selected_category->name; ?></span>
										</label>
								</div>								<?php

								if ( $child_categories ) { 									?>
                                    <ul class='children' style='margin-left:20px;list-style:none;display: none;'> <?php
                                        foreach( $child_categories as $child_category ) { ?>
                                            <li>
                                                <div class="asea-filter-option">
                                                    <label>
                                                        <input class="asea-filter-option-input" name="cat-<?php echo $child_category->term_id; ?>" type="checkbox" value="<?php echo $child_category->term_id; ?>">
                                                        <span class="asea-filter-option-label"><?php echo $child_category->name; ?></span>
                                                    </label>
                                                </div>
                                            </li>   <?php
							        	}   ?>
							        </ul>								<?php
							    } ?>

								</li>								<?php

							}   ?>

							</ul>
						</div>
					</fieldset>
				</div>

				<!----- Search Box Results ------>
				<div id="asea_search_results"></div>

			</form>

		</div>		<?php
	}

	/**
	 * Adds a loading spinner when user enters text into the text input to indicate something is loading.
	 * @param $kb_config
	 */
	public function asea_loading_spinner( $kb_config ) {
		//Loading Icon CSS / Styles -----------------------------------------------------------------------------------/
		$loading_icon_class = 'asea-loading-icon-' .  ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_loading_icon_placement' );

		//Set the Spacing from the edge of the input box based on padding
		if ( $loading_icon_class == 'asea-loading-icon-right' ) {
			$icon_position = 'right';
		} elseif ( $loading_icon_class == 'asea-loading-icon-left' ) {
			$icon_position = 'left';
		} else {
			$icon_position = 'right';
		}

		$spacing = ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_'.$icon_position);
		$loading_icon_style  = 'style="';
		$loading_icon_style .= $icon_position.':' .$spacing. 'px;';
		$loading_icon_style .= '"';		?>

		<div class="loading-spinner <?php echo $loading_icon_class; ?>" <?php echo $loading_icon_style; ?>></div>	<?php
	}

	/**
	 * Adds a Search Icon before or after the input text.
	 * @param $kb_config
	 */
	public function asea_search_icon( $kb_config ) {

		//Search Icon CSS / Styles ------------------------------------------------------------------------------------/
		$search_icon_class = 'asea-search-icon-' .  ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_search_icon_placement' );

		//Set the Spacing from the edge of the input box based on padding
		if ( $search_icon_class == 'asea-search-icon-right' ) {
			$search_icon_position = 'right';
		} elseif ( $search_icon_class == 'asea-search-icon-left' ) {
			$search_icon_position = 'left';
		} else {
			$search_icon_position = 'right';
		}

		$search_icon_spacing =  ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_' . $search_icon_position );
		$search_icon_style  = 'style="';
		$search_icon_style .= 'font-size:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_font_size' ) . 'px;';
		$search_icon_style .= $search_icon_position.':' .$search_icon_spacing. 'px;';
		$search_icon_style .= '"';		?>

		<div class="asea-search-icon epkbfa epkbfa-search <?php echo $search_icon_class; ?>" <?php echo $search_icon_style; ?>></div>	<?php
	}

	/**
	 * Adds a box with text and drop down icon into the text input box
	 * @param $kb_config
	 */
	public function asea_search_filter_icon( $kb_config ) {

		//Filter-icon Icon CSS / Styles
		$filter_icon_style  = 'style="';
		$filter_icon_style .= 'font-size:'          . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_font_size' ) . 'px;';
		$filter_icon_style .= 'padding-right:'      . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_right') . 'px;';
		$filter_icon_style .= 'padding-left:'       . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_left') . 'px;';
		$filter_icon_style .= 'padding-top:'        . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_top') . 'px;';
		$filter_icon_style .= 'padding-bottom:'     . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_padding_bottom') . 'px;';
		$filter_icon_style .= 'color:'              . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_box_font_color') . ';';
		$filter_icon_style .= 'background-color:'   . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_box_background_color') . ';';
		$filter_icon_style .= '"';		?>

		<div class="asea-search-filter-icon-container" <?php echo $filter_icon_style; ?>>			<?php

			//If the Search Icon is located on the left it needs to be outputted here for alignment reasons with CSS.
			if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_search_icon_placement' ) == 'right' ) {
				$this->asea_search_icon( $kb_config );
			}

			//If the loading Icon is located on the left it needs to be outputted here for alignment reasons with CSS.
			if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_input_box_loading_icon_placement' ) == 'right' ) {
				$this->asea_loading_spinner( $kb_config );
			}

			if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_indicator_text') ){ ?>
				<span class="asea-search-filter-text"><?php echo ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_filter_indicator_text'); ?></span>			<?php
			}   ?>

			<span class="asea-search-filter-icon epkbfa epkbfa-chevron-down"></span>
		</div>	<?php
	}

	/**
	 * Adds Style tags inside main container to handle config settings that require direct targets of HTML tags that cannot be done with inline or css classes.
	 * @param $kb_config
	 */
	public function asea_search_container_style_tags( $kb_config, $prefix = '' ) {
		echo '<style>';
			echo $prefix . ' #asea-doc-search-container #asea-section-1 a { color:' . ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_link_font_color') . ' }';
		echo '</style>';
	}

	/**
	 * Display Search Container #1 Style
	 * @param $kb_config
	 */
	public function asea_section_1_styles( $kb_config ) {

		echo $this->get_inline_style( $kb_config,
					'background-color:: advanced_search_*_background_color,
					 padding-top:: advanced_search_*_box_padding_top,
					 padding-right:: advanced_search_*_box_padding_right,
					 padding-bottom:: advanced_search_*_box_padding_bottom,
					 padding-left:: advanced_search_*_box_padding_left,
					 margin-top::   advanced_search_*_box_margin_top,
					 margin-bottom:: advanced_search_*_box_margin_bottom,
			 ');
	}

	public function eckb_doc_search_container_classes( $kb_config ) {
		echo ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_visibility' ) . ' ';
	}

	/**
	 * Output inline CSS style based on configuration.
	 *
	 * @param $kb_config
	 * @param string $styles A list of Configuration Setting styles
	 *
	 * @return string
	 */
	private function get_inline_style( $kb_config, $styles) {
		$styles = str_replace('*', ASEA_Search_Utilities::get_search_index( $kb_config ), $styles);
		return ASEA_Utilities::get_inline_style( $styles, $kb_config );
	}

	/**
	 * Output CSS classes based on configuration.
	 *
	 * @param $kb_config
	 * @param $classes
	 *
	 * @return string
	 */
	public function get_css_class( $kb_config, $classes ) {
		$classes = str_replace('*', ASEA_Search_Utilities::get_search_index( $kb_config ), $classes);
		return ASEA_Utilities::get_css_class( $classes, $kb_config );
	}

	//Add Search Toggle on Sidebar template for Advanced Search
	public function search_toggle( $kb_config ) {
		if ( ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_box_visibility' ) === 'asea-visibility-search-form-3' ) {    	?>
			<div class="asea-search-toggle">
				<span class="asea-search-icon epkbfa epkbfa-search"></span>
			</div>		<?php
		}
	}
}
