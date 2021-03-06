<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handle advanced search of Knowledge Base
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ASEA_Search_Box_cntrl {

	public function __construct() {
		add_action( 'wp_ajax_asea-advanced-search-kb', array($this, 'main_search_kb') );
		add_action( 'wp_ajax_nopriv_asea-advanced-search-kb', array($this, 'main_search_kb') );
		add_action( 'wp_ajax_asea_handle_reset_request', array( $this, 'handle_reset_analytics_button' ) );
	}

	/***
	 * Main search function 
	 */
	public function main_search_kb() {
		global $eckb_is_kb_main_page;

		$kb_id_text = ASEA_Utilities::get('asea_kb_id');
		$kb_ids = explode(",", $kb_id_text );
		$search_result = '';

		// search multiple KBs
        if ( count($kb_ids) > 1 ) {

	        $eckb_is_kb_main_page = true;
	        $first_kb = empty($kb_ids[0]) ? ASEA_KB_Config_DB::DEFAULT_KB_ID : $kb_ids[0];

            // combine results
            foreach ($kb_ids as $kb_id) {
                $search_result .= self::search_kb( $kb_id, 'mkb', $first_kb );
            }

            // show message if no result found in all kbs
            if ( empty($search_result) ) {
                $asea_config = asea_get_instance()->kb_config_obj->get_kb_config_or_default( ASEA_KB_Config_DB::DEFAULT_KB_ID );
                $search_result = '<div class="asea-no-results-found-msg">' . ASEA_Search_Utilities::get_search_kb_config( $asea_config, 'advanced_search_*_no_results_found' ) . '</div>';
            }

        // single KB search
        } else {
			$search_result = self::search_kb( $kb_id_text, '', $kb_id_text );
		}

		wp_die( json_encode( array( 'status' => 'success', 'search_result' => $search_result ) ) );
	}

	/**
	 * Process AJAX search request
	 *
	 * @param $kb_id
	 * @param string $search_type
	 * @param int $first_kb
	 *
	 * @return string
	 */
	public function search_kb( $kb_id, $search_type='', $first_kb=1 ) {

		// we don't need nonce and permission check here

        $kb_id = ASEA_Utilities::sanitize_get_id( $kb_id );
		if ( is_wp_error( $kb_id ) ) {
			wp_die( json_encode( array( 'status' => 'success', 'search_result' => esc_html__( 'Error occurred. Please try again later.', 'echo-advanced-search' ) ) ) );
		}

		// first KB configuration
		$first_kb_config = ASEA_KB_Core::get_kb_config( $first_kb );
		if ( is_wp_error($first_kb_config) ) {
			wp_die( json_encode( array( 'status' => 'success', 'search_result' => esc_html__( 'Error occurred (x4). Please try again later.', 'echo-advanced-search' ) ) ) );
		}
		$first_asea_config = asea_get_instance()->kb_config_obj->get_kb_config_or_default( $first_kb );
		$first_kb_config = array_merge($first_asea_config, $first_kb_config);

		// current KB configuration
		$current_kb_config = ASEA_KB_Core::get_kb_config( $kb_id );
		if ( is_wp_error($current_kb_config) ) {
			wp_die( json_encode( array( 'status' => 'success', 'search_result' => esc_html__( 'Error occurred (x4). Please try again later.', 'echo-advanced-search' ) ) ) );
		}
		$current_asea_config = asea_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
		$current_kb_config = array_merge($current_asea_config, $current_kb_config);

		// remove question marks
		$user_input = ASEA_Utilities::get( 'search_words' );
		$user_input = stripslashes($user_input);
		$filtered_user_input = ASEA_Search_Box_Query::filter_user_input( $user_input);
		
		//get selected categories
		$user_category_ids = ASEA_Utilities::get( 'search_categories' );
		$user_category_ids = stripslashes($user_category_ids);
		$user_category_ids = ASEA_Search_Box_Query::filter_user_input( $user_category_ids);
		$user_category_ids = empty($user_category_ids) ? array() : explode(",", $user_category_ids);

		/** If Category Level Top Then search in selected top category & it's sub category  */
		$category_level = ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_filter_category_level' );
		if ( $category_level == 'top' ) {
			// Add child categories to the array 
			foreach ( $user_category_ids as $category_id ) {

				$children = get_terms( array(
					'taxonomy' => ASEA_KB_Handler::get_category_taxonomy_name( $kb_id ),
					'child_of' => $category_id,
					'fields' => 'ids'
				) );

				if ( is_wp_error( $children ) || empty( $children ) || ! is_array( $children ) ) {
					continue;
				}

				$user_category_ids = array_merge( $user_category_ids, $children );
			}
		
			// maybe we have duplicates 
			$user_category_ids = array_unique( $user_category_ids );
		}

		
		// require minimum size of search word(s)
		if ( empty($filtered_user_input) ) {
			wp_die( json_encode( array( 'status' => 'success', 'search_result' => '<div class="asea-min-search-word-size-msg">' .
                                 esc_html( ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_no_results_found' ) ) . '</div>' ) ) );
		}

		// ensure that links have https if the current schema is https
		set_current_screen('front');

		// search for given keyword(s)
		$search_db = new ASEA_Search_Box_Query();

		// get individual search keywords;
		$search_keywords = $search_db->get_search_keywords( $filtered_user_input );

		$found_posts = $search_db->kb_search_articles( $kb_id, $filtered_user_input, $user_category_ids, self::get_search_results_list_size( $first_kb ) );
		if ( $found_posts === false ) {

			$search_result = __('Error occurred (532).', 'echo-advanced-search' );

		} else 	if ( empty($found_posts) ) {

			if ( $search_type == 'mkb' ) {
				$search_result = '';
			} else {
				$search_result = '<div class="asea-no-results-found-msg">' . ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_no_results_found' ) . '</div>';
			}

			ASEA_Search_Logging::add_search_log( $user_input, $search_keywords, 0, ( $search_type == 'mkb' ? 'search-shortcode' : 'kb-main-page' ), $kb_id );

		} else {

			$search_total = $search_db->articles_total + $search_db->tags_total;

			// before returning, record the search for future analytics
			ASEA_Search_Logging::add_search_log( $user_input, $search_keywords, $search_total, ( $search_type == 'mkb' ? 'search-shortcode' : 'kb-main-page' ), $kb_id );

			$search_result = $this->get_search_results_dropdown( $kb_id, $first_kb_config, $current_kb_config, $filtered_user_input, $found_posts, $search_total, $user_category_ids );
		}

		// for MKB search show KB name at the top
		if ( $search_type == 'mkb' && ! empty($search_result) ) {
			$search_result = "<span class='eckb-kb-title'>" . $current_kb_config['kb_name'] . "</span>" . $search_result;
		}

		// we are done here
		return $search_result;
	}

	/**
	 * Display list of search results in drop down.
	 *
	 * @param $kb_id
	 * @param $first_kb_config
	 * @param $current_kb_config
	 * @param $search_terms
	 * @param $found_posts
	 * @param $search_total
	 * @param $user_category_ids
	 *
	 * @return string
	 */
	private function get_search_results_dropdown( $kb_id, $first_kb_config, $current_kb_config, $search_terms, $found_posts, $search_total, $user_category_ids ) {

		$search_result = '<ul>';

		$title_style = '';
		$icon_style  = '';
		$new_tab  = '';
		if ( ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_box_results_style' ) == 'on' ) {
			$title_style = ASEA_Utilities::get_inline_style( 'color:: article_font_color' , $first_kb_config);
			$icon_style = ASEA_Utilities::get_inline_style( 'color:: article_icon_color' , $first_kb_config);
		}

		// display one line for each search found_posts
		$all_result = '';
		foreach( $found_posts as $post ) {

			// get article URL
			$article_url = get_permalink( $post->ID );
			if ( empty( $article_url ) || is_wp_error( $article_url ) ) {
				continue;
			}

			// linked articles have their own icon
			$article_title_icon = 'ep_font_icon_document';
			if ( has_filter( 'eckb_single_article_filter' ) ) {
				$article_title_icon = apply_filters( 'eckb_article_icon_filter', $article_title_icon, $post->ID );
				$article_title_icon = empty( $article_title_icon ) ? 'epkbfa-file-text-o' : $article_title_icon;
			}
			// linked articles have open in new tab option
			if ( class_exists( 'KBLK_Utilities' ) ) {
				$link_editor_config = KBLK_Utilities::get_postmeta( $post->ID, 'kblk-link-editor-data', array(), true );
				$new_tab = empty( $link_editor_config['open-new-tab'] ) ? '' : 'target="_blank"';
			}

			// show top category in search results if ON
			$top_category_element = '';
			if ( ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_show_top_category' ) == 'on' ) {

				// Access Manager: user can always see top category of article they have access to
				$article_categories = ASEA_Utilities::get_article_categories_unfiltered( $kb_id, $post->ID );
				$found_category_id = empty($article_categories) || empty($article_categories[0]->term_id) ? 0 : $article_categories[0]->term_id;

				// find the top category name
				$counter = 0;
				$article_category_names = array();
				while ( ! empty($found_category_id) && $counter < 4 ) {

					$found_category = ASEA_Utilities::get_kb_category_unfiltered( $kb_id, $found_category_id );
					if ( empty($found_category->name) ) {
						break;
					}

					$counter++;
					$article_category_names[] = $found_category->name;

					// do we already have top level category?
					$found_category_id = empty($found_category->parent) ? 0 : $found_category->parent;
				}

				$article_category_names = array_reverse( $article_category_names );

				$search_result_category_color = ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_search_result_category_color' );
				$category_name_style = ASEA_Utilities::get_inline_style( 'color:'.$search_result_category_color , $first_kb_config);
				// use array splice etc. to get top 3 categories

				$top_category_element = ' <span class="eckb-article-title-category">';

				$first = true;
				foreach ( $article_category_names as $category_name ) {
					
					if ( ! $first ) {
						$top_category_element .= '<span class="eckb-article-title-category-name-separator"> / </span>';
					}
					
					$first = false;

					$top_category_element .= '<span class="eckb-article-title-category-name"  ' . $category_name_style . '>'. esc_html($category_name).'</span>';
				}

				$top_category_element .= '</span>';
			}

			$search_result .=
				'<li>' .
					'<a href="' .  esc_url( $article_url ) . '" class="asea-ajax-search" data-kb-article-id="' . $post->ID . '" ' . $new_tab . ' >' .
					'<span class="eckb-article-title" ' . $title_style . '>' .
						'<i class="eckb-article-title-icon epkbfa ' . esc_attr($article_title_icon) . '" ' . $icon_style . '></i>' .
				        '<span class="eckb-article-title-text">' . esc_html($post->post_title) . '</span>' .
							$top_category_element .
					'</span>' .
					'</a>' .
				'</li>';
		}

		// empty post indicates premature end - show link to search page
		if ( $search_total > count($found_posts) ) {

			// prepare link to search results page
			$searchpage_url = '#';
			$permalink = ASEA_KB_Handler::get_first_kb_main_page_url( $current_kb_config );
			if ( ! empty($permalink) ) {
				$user_category_ids_url = count($user_category_ids) > 0 ? '&' .  __( 'category', 'echo-advanced-search' ) . '=' . urlencode(implode('|', $user_category_ids)) : '';
				$searchpage_url = add_query_arg( array( _x('kb-search', 'used when searching', 'echo-advanced-search') => urlencode($search_terms) ), $permalink ) . $user_category_ids_url;
			}

			$all_result = '<div id="asea-all-search-results">' .
			                '<a href="' . esc_url($searchpage_url) . '" >' .
			                esc_html( ASEA_Search_Utilities::get_search_kb_config( $first_kb_config, 'advanced_search_*_more_results_found' ) ) . ' (' . esc_html($search_total) . ')</a>' .
			              '</div>';
		}

		$search_result .= '</ul>';

		$search_result .= $all_result;

		return $search_result;
	}

	public static function get_search_results_list_size( $kb_id ) {
		$kb_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_results_list_size' );
	}
	
	/**
	 * AJAX reset analytics fuction - delete ALL data for analytics from DB
	 *
	*/
	public function handle_reset_analytics_button() {

		// verify that request is authentic
		if ( empty( $_POST['_wpnonce_asea_search_analytics'] ) || ! wp_verify_nonce( $_POST['_wpnonce_asea_search_analytics'], '_wpnonce_asea_search_analytics' ) ) {
			ASEA_Utilities::ajax_show_error_die( __( 'First refresh your page', 'echo-advanced-search' ) );
		}

		// ensure user has correct permissions
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			ASEA_Utilities::ajax_show_error_die( __( 'You do not have permission to edit this knowledge base', 'echo-advanced-search' ) );
		}
		
		$kb_id = ASEA_Utilities::post( 'kb_id', null );
		if ( empty($kb_id) )  {
			ASEA_Utilities::ajax_show_error_die( __( 'Missing KB ID', 'echo-advanced-search' ) );
		}

		$db = new ASEA_Search_DB();
		$db->delete_analytics_data( $kb_id );

		wp_die( json_encode( array( 'message' => __( 'Advanced Search statistics was deleted', 'echo-advanced-search' ), 'error' => 'false' ) ) );
	}
}
