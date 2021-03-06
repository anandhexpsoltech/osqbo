<?php

/**
 *  Outputs the Grid Layout for knowledge base main page.
 *
 *
 * @copyright   Copyright (C) 2018 Plugins
 */
class ELAY_Layout_Grid extends ELAY_Layout {

	public function __construct() {
		add_filter( ELAY_KB_Core::ELAY_KB_GRID_LAYOUT_OUTPUT, array( $this, 'get_layout_output'), 10, 4 );
	}

	/**
	 * Output the Layout
	 *
	 * @param $kb_config
	 * @param $is_builder_on
	 * @param $article_seq
	 * @param $categories_seq
	 */
	public function get_layout_output( $kb_config, $is_builder_on, $article_seq, $categories_seq ) {
		$this->display_kb_page( $kb_config, $is_builder_on, $article_seq, $categories_seq );
		if ( empty($this->category_seq_data) && empty($this->articles_seq_data) ) {
			echo __( 'This Knowledge Base is not set up.', 'echo-knowledge-base' );
			return;
		}
		$this->generate_kb_main_page();
	}

	/**
	 * Generate content of the KB main page
	*/
	public function generate_kb_main_page() {

		if ( class_exists('AMGR_Access_Utilities', false) ) {
			$kb_groups_set = AMGR_Access_Utilities::get_main_page_group_sets( $this->kb_id, $this->category_seq_data, $this->articles_seq_data );
			if ( $kb_groups_set === null || ( empty($kb_groups_set['categories_seq_data']) && empty($kb_groups_set['articles_seq_data']) ) ) {
				echo AMGR_Access_Reject::reject_user_access( $this->kb_id );
				return;
			}

			$this->category_seq_data = $kb_groups_set['categories_seq_data'];
			$this->articles_seq_data = $kb_groups_set['articles_seq_data'];
		}

		$class2 = $this->get_css_class( '::grid_width' );		?>

		<div id="elay-grid-layout-page-container" class="elay-css-full-reset elay-grid-template">
			<div <?php echo $class2; ?>>  <?php

				//  KB Search form
				$this->get_search_form();

				//  KB Layout
				$style1 = $this->get_inline_style( 'background-color:: grid_background_color' );				?>
				<div id="elay-content-container" <?php echo $style1; ?> >

					<!--  Main Page Content -->
					<div class="elay-section-container">
						<?php $this->display_main_page_content(); ?>
					</div>

				</div>

			</div>
		</div>   <?php
	}

	/**
	 * Display KB main page content
	 */
	private function display_main_page_content() {
		
		if ( ELAY_Utilities::post('ep'.'kb-wizard-demo-data', false, false) ) {
			$demo_data = ELAY_KB_Core::get_category_demo_data( 'Grid', $this->kb_config );
			$categories_icons = $demo_data['category_icons'];
		} else {
			$categories_icons = ELAY_Utilities::get_kb_option( $this->kb_config['id'], ELAY_KB_Core::ELAY_CATEGORIES_ICONS, array(), true );
		}
		
		$class1 = $this->get_css_class( ' ::grid_nof_columns, ::grid_section_font_size, eckb-categories-list' );

		// store links that already were used to add seq_no in the url
		$links_array = array(); ?>

		<div <?php echo $class1; ?> > <?php

		/** DISPLAY CATEGORIES */
		foreach ( $this->category_seq_data as $box_category_id => $box_categories ) {

			// if category link is to Category Archive page is on or not
			if ( $this->kb_config['section_hyperlink_text_on'] != 'on' ) {
				// determine link for each category - use the first top category article or KB root if one not found
				$link_url = self::get_box_category_link( $box_category_id );
			} else {
				$link_url = get_term_link( $box_category_id, ELAY_KB_Handler::get_category_taxonomy_name( $this->kb_config['id']) );
				$link_url  = is_wp_error( $link_url ) ? '' : $link_url;
			}

            // Grab the Styling for the links.
			$link_class = $this->get_css_class('::grid_section_box_hover');
			$link_style = $this->get_inline_style('color:: grid_section_body_text_color');

			$category_name = isset($this->articles_seq_data[$box_category_id][0]) ? $this->articles_seq_data[$box_category_id][0] : '';
			if ( empty($category_name) ) {
				continue;
			}

			if ( $this->is_builder_on ) {
				$this->display_section( $box_category_id, $categories_icons, $category_name );
			} else {

				// detect already added links
				$links_counts = array_count_values( $links_array );
				if ( ! empty($link_url) ) {
					$links_array[] = $link_url;
				}
				if ( isset( $links_counts[$link_url] ) ) {
					$link_url = add_query_arg( 'seq_no', $links_counts[$link_url] + 1, $link_url );
				}

				echo '<a href="' . esc_url( $link_url ) . '" ' . $link_class . ' ' . $link_style . '>';
				$this->display_section( $box_category_id, $categories_icons, $category_name );
				echo '</a>';
			}

		}       ?>

		</div>      <?php
	}

	private function display_section( $box_category_id, $categories_icons, $category_name ) {

	    //SECTION MAIN CONTAINER
		$head_text_align = 'elay-text-'.$this->kb_config['grid_section_head_alignment'];
		$class0 = $this->get_css_class('::grid_section_box_shadow, elay-top-category-box '  );
		$style0 = $this->get_inline_style(
				'border-radius:: grid_section_border_radius,
				 border-width:: grid_section_border_width,
				 border-color:: grid_section_border_color, 
				 background-color:: grid_section_body_background_color, border-style: solid'
		);

        //SECTION HEAD
		$section_min_height = $this->kb_config['grid_section_icon_size'] + ( $this->kb_config['grid_section_icon_padding_top'] * 2);
		$class_section_head = $this->get_css_class( 'section-head, '. $head_text_align . ($this->kb_config['grid_section_divider'] == 'on' ? ', section_divider' : '' ) );
		$style_section_head = $this->get_inline_style(
				'border-bottom-width:: grid_section_divider_thickness,
				background-color:: grid_section_head_background_color,
				border-top-left-radius:: grid_section_border_radius,
				border-top-right-radius:: grid_section_border_radius,
				border-bottom-color:: grid_section_divider_color,
				padding-top:: grid_section_head_padding_top,
				padding-bottom:: grid_section_head_padding_bottom,
				padding-left:: grid_section_head_padding_left,
				padding-right:: grid_section_head_padding_right,
				min-height:' . $section_min_height . 'px'
		);
		$icon_styles = $this->get_inline_style('font-size:: grid_section_icon_size,
		                padding-top::    grid_section_icon_padding_top,
					    padding-bottom:: grid_section_icon_padding_bottom,
					    padding-left::   grid_section_icon_padding_left,
					    padding-right::  grid_section_icon_padding_right,
					    color::grid_section_head_icon_color,
					    font-weight::grid_category_icon_thickness
		');
		$image_wrap_styles = $this->get_inline_style( '
						padding-top::    grid_section_icon_padding_top,
					    padding-bottom:: grid_section_icon_padding_bottom,
					    padding-left::   grid_section_icon_padding_left,
					    padding-right::  grid_section_icon_padding_right,
		');	
		
		$image_styles = $this->get_inline_style( 'max-height:: grid_section_icon_size');	
		
		// Setup Category Icon 2
		$category_icon = ELAY_KB_Core::get_category_icon( $box_category_id, $categories_icons );

		$icon_placement = ( $this->kb_config['grid_category_icon_location'] == 'right' ) ? 'display:inline-block' : '';
		$category_name_style = $this->get_inline_style(
			'color:: grid_section_head_font_color,
				 text-align:: grid_section_head_alignment,
				  padding-top::     grid_section_cat_name_padding_top,
				  padding-right::   grid_section_cat_name_padding_right,
				  padding-bottom::  grid_section_cat_name_padding_bottom,
				  padding-left::    grid_section_cat_name_padding_left,
				 ' . $icon_placement
		);
		$description_style = $this->get_inline_style(
			'color:: grid_section_head_description_font_color,
				  text-align:: grid_section_head_alignment,
				  padding-top::grid_section_desc_padding_top,
				  padding-right::grid_section_desc_padding_right,
				  padding-bottom::grid_section_desc_padding_bottom,
				  padding-left::grid_section_desc_padding_left, '
		);
		$category_desc = isset($this->articles_seq_data[$box_category_id][1]) && $this->kb_config['grid_section_desc_text_on'] == 'on' ? $this->articles_seq_data[$box_category_id][1] : '';

        //SECTION BODY
		$style5 = 'border-bottom-width:: grid_section_border_width,
					padding-top::    grid_section_body_padding_top,
					padding-bottom:: grid_section_body_padding_bottom,
					padding-left::   grid_section_body_padding_left,
					padding-right::  grid_section_body_padding_right, ';

		if ( $this->kb_config['grid_section_box_height_mode'] == 'section_min_height' ) {
			$style5 .= 'min-height:: grid_section_body_height';
		} else if ( $this->kb_config['grid_section_box_height_mode'] == 'section_fixed_height' ) {
			$style5 .= 'overflow: auto, height:: grid_section_body_height';
		}

		$box_category_data = $this->is_builder_on ? 'data-kb-category-id=' . $box_category_id . ' data-kb-type=category ' : '';
        $body_text_align = 'elay-text-' . $this->kb_config['grid_section_body_alignment'];
        $elay_body_class = $this->get_css_class( 'elay-section-body, ' . $body_text_align );
		$body_text_style = $this->get_inline_style(	'padding-top::grid_article_list_spacing, padding-bottom::grid_article_list_spacing' );        ?>

        <!-- SECTION MAIN CONTAINER -->
		<section <?php echo $class0 . ' ' . $style0; ?> >

            <!-- SECTION HEAD -->
			<div <?php echo $class_section_head . ' ' . $style_section_head; ?> >                        <?php

				// Category Icon Left / Top
				if ( ! empty($category_icon['type']) && ( $this->kb_config['grid_category_icon_location'] == 'left' || $this->kb_config['grid_category_icon_location'] == 'top' ) ) {

					if ( $category_icon['type'] == 'image' ) { ?>
						<span class="elay-icon-elem elay-icon-elem--image <?php echo 'elay-icon-' . $this->kb_config['grid_category_icon_location']; ?>" <?php echo $image_wrap_styles; ?>>
							<img src="<?php echo $category_icon['image_thumbnail_url']; ?>"<?php echo $image_styles; ?>>
						</span>					<?php
					} else { ?>
						<span class="elay-icon-elem epkbfa <?php echo $category_icon['name'] . ' elay-icon-' . $this->kb_config['grid_category_icon_location']; ?>" <?php echo $icon_styles; ?>></span>					<?php
					}

				}				?>

				<h3 class="elay-grid-category-name"	<?php echo $box_category_data . ' ' . $category_name_style; ?> >
                    <?php echo $category_name;    ?>
				</h3>                <?php

				// Category Icon Right / Bottom
				if ( ! empty($category_icon['type']) && ( $this->kb_config['grid_category_icon_location'] == 'right' || $this->kb_config['grid_category_icon_location'] == 'bottom') ) {

					if ( $category_icon['type'] == 'image' ) { ?>
						<span class="elay-icon-elem elay-icon-elem--image <?php echo 'elay-icon-' . $this->kb_config['grid_category_icon_location']; ?>" <?php echo $image_wrap_styles; ?>>
							<img src="<?php echo $category_icon['image_thumbnail_url']; ?>" <?php echo $image_styles; ?>>
						</span>					<?php
					} else  { ?>
						<span class="elay-icon-elem epkbfa <?php echo $category_icon['name'] . ' elay-icon-' . $this->kb_config['grid_category_icon_location']; ?>" <?php echo $icon_styles; ?>></span>					<?php
					}

				}

				if ( $category_desc ) {     ?>
					<p class="elay-grid-category-desc" <?php echo $description_style; ?> >
						<?php echo $category_desc; ?>
					</p>						<?php
				}       ?>

			</div>
            <!-- /SECTION HEAD -->

            <!-- SECTION BODY -->
			<div <?php echo $elay_body_class; ?> <?php echo $this->get_inline_style( $style5 ); ?> > <?php

				$nof_articles = $this->get_articles_count( $box_category_id );
				if ( $this->kb_config['grid_section_article_count'] == 'on' && $nof_articles > 0 ) {
					$count_text = $nof_articles == 1 ? $this->kb_config['grid_article_count_text'] : $this->kb_config['grid_article_count_plural_text'];
					$plural_class = $nof_articles == 1 ? 'single' : 'plural';
					echo '<p ' . $body_text_style . '>' . $nof_articles . ' <span class="elay_grid_count_text--' . $plural_class . '">' . $count_text . '</span></p>';
				}

				// if category has no articles then should empty message instead of link
				if ( $nof_articles === 0 ) {
					echo '<p ' . $body_text_style . ' class="elay_grid_empty_msg">' . $this->kb_config['grid_category_empty_msg'] . '</p>';
				} else {
					echo '<p ' . $body_text_style . ' class="elay_grid_link_text">' . $this->kb_config['grid_category_link_text'] . '</p>';
				}           ?>

			</div>
            <!-- /SECTION BODY -->

		</section><!-- /SECTION MAIN CONTAINER -->      <?php
	}

	/**
	 * Return first article of given category or empty if category or sub-categores have no article
	 *
	 * @param $box_category_id
	 * @return string
	 */
	private function get_box_category_link( $box_category_id ) {

		$post_id = '';
		if ( isset($this->category_seq_data[$box_category_id]) ) {
			$category_seq_data = array( $box_category_id => $this->category_seq_data[$box_category_id] );
			$post_id = $this->get_first_article( $category_seq_data, $this->articles_seq_data, 3 );
		}

		if ( empty($post_id) ) {
			return '';
		}

		$url = get_permalink( $post_id );

		return empty($url) || is_wp_error( $url ) ? '' : $url;
	}
	
	private function get_articles_count( $box_category_id ) {

		$count = 0;

		if ( empty($this->articles_seq_data[$box_category_id]) ) {
			return $count;
		} else {
			$count += count($this->articles_seq_data[$box_category_id]) - 2;
		}

		foreach ( $this->category_seq_data[$box_category_id] as $sub_category_id => $sub_sub_categories ) {

			if ( ! empty($this->articles_seq_data[$sub_category_id]) ) {
				$count += count($this->articles_seq_data[$sub_category_id]) - 2;
			}

			foreach ( $sub_sub_categories as $sub_sub_category_id => $unused) {

				if ( ! empty( $this->articles_seq_data[ $sub_sub_category_id ] ) ) {
					$count += count( $this->articles_seq_data[ $sub_sub_category_id ] ) - 2;
				}
			}
		}
		
		return $count;
	}

    /**
     * Display first article when user loads the KB Main Page the first time without article slug
     *
     * @param $category_seq_data
     * @param $articles_seq_data
     * @param int $level
     * @return null|int - return post id or null
     */
    private function get_first_article( $category_seq_data, $articles_seq_data, $level=2 ) {

        $post = null;

        // find it on the first level
        foreach( $category_seq_data as $category_id => $sub_categories ) {
            if ( ! empty($articles_seq_data[$category_id]) ) {
                $keys = array_keys($articles_seq_data[$category_id]);
                if ( ! empty($keys[2]) && ELAY_Utilities::is_positive_int( $keys[2] ) ) {
                    return $keys[2];
                }
            }

            if ( $level < 2 ) {
                continue;
            }

            // find it on the second level
            foreach( $sub_categories as $sub_category_id => $sub_sub_categories ) {
                if ( ! empty( $articles_seq_data[ $sub_category_id ] ) ) {
                    $keys = array_keys( $articles_seq_data[ $sub_category_id ] );
                    if ( ! empty( $keys[2] ) && ELAY_Utilities::is_positive_int( $keys[2] ) ) {
                        return $keys[2];
                    }
                }

                if ( $level < 3 ) {
                    continue;
                }

                // find it on the third level
                foreach( $sub_sub_categories as $sub_sub_category_id => $sub_sub_sub_categories ) {
                    if ( ! empty( $articles_seq_data[ $sub_sub_category_id ] ) ) {
                        $keys = array_keys( $articles_seq_data[ $sub_sub_category_id ] );
                        if ( ! empty( $keys[2] ) && ELAY_Utilities::is_positive_int( $keys[2] ) ) {
                            return $keys[2];
                        }
                    }
                }
            }
        }

        return $post;
    }
}