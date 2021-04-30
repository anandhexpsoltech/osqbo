<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handle search query.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class ASEA_Search_Box_Query {

	const MAX_KEY_WORDS = 5;

	var $articles_total = 0;
	var $tags_total = 0;
	var $is_wpml_enabled = false;

	/**
	 * Display the article link in KB Search
	 *
	 * @param $kb_id
	 * @param $filtered_user_input
	 * @param $user_category_ids
	 * @param int $batch_size
	 * @param int $results_page_num
	 *
	 * @return array|false
	 */
	public function kb_search_articles( $kb_id, $filtered_user_input, $user_category_ids, $batch_size, $results_page_num=0 ) {

		$this->is_wpml_enabled = ASEA_Utilities::is_wpml_enabled_addon( $kb_id );

		// get individual search keywords;
		$search_keywords = $this->get_search_keywords( $filtered_user_input );

		// if Access Manager is enabled, ensure only categories that user can access are visible
		if ( ! empty($user_category_ids) && ASEA_Utilities::is_amag_on()) {

			$user_selected_categories = array();
			foreach( $user_category_ids as $user_category_id ) {
				$user_selected_category = ASEA_Utilities::get_kb_category_unfiltered( $kb_id, $user_category_id );
				if ( ! empty($user_selected_category) ) {
					$user_selected_categories[] = $user_selected_category;
				}
			}

			$user_category_ids = array();
			$user_filtered_categories = ASEA_KB_Core::filter_user_categories( $user_selected_categories );
			foreach($user_filtered_categories as $user_filtered_category) {
				$user_category_ids[] = $user_filtered_category->term_id;
			}
		}

		// count number of articles
		$articles_total = $this->search_articles( $kb_id, $filtered_user_input, $user_category_ids, $search_keywords, true );
		if ( $articles_total === false ) {
			return false;
		}
		$this->articles_total = $articles_total;

		// find from
		$results_page_num = empty($results_page_num) || $results_page_num < 0 ? 1 : $results_page_num;
		$results_from = ($results_page_num - 1) * $batch_size;
		$results_from = ( $results_from < 0 ) ? 0 : $results_from;

		// search KB Articles if any left
		$article_result = array();
		$articles_left = $articles_total - $results_from;
		if ( $articles_left > 0 ) {
			$article_limit = $articles_left > $batch_size ? $batch_size : $articles_left;
			$article_result = $this->search_articles( $kb_id, $filtered_user_input, $user_category_ids, $search_keywords, false, $results_from, $article_limit );
			if ( $article_result === false ) {
				return false;
			}
		}

		// search Tags if any left
		$tag_result = array();
		if ( $batch_size > $articles_left ) {
			$tag_limit = $articles_left > 0 ? $batch_size - $articles_left : $batch_size;
			$tag_results_from = $articles_left > 0 ? 0 : ( $results_from - $articles_total );
			$tag_result = $this->search_tags( $kb_id, $filtered_user_input, $user_category_ids, $tag_results_from, $tag_limit );
			if ( $tag_result === false ) {
				return false;
			}
		}

		// combine article and tag searches
		$search_result = $article_result;
		$article_result_ids = array();
		foreach( $article_result as $article_record ) {
			$article_result_ids[] = $article_record->ID;
		}
		$this->tags_total = 0;
		foreach( $tag_result as $tag_record ) {
			if ( ! in_array($tag_record->ID, $article_result_ids) ) {
				$search_result[] = $tag_record;
				$article_result_ids[] = $tag_record->ID;
				$this->tags_total++;
			}
		}

		// add empty element if found more than batch size of search results
		if ( count($search_result) > $batch_size ) {
			$search_result = array_splice($search_result, 0, $batch_size);
			$search_result = array_merge($search_result, array(''));
		}

		return $search_result;
	}

	/**
	 * Create a custom query to search articles. Return either total or list of articles.
	 *
	 * @param $kb_id
	 * @param $filtered_user_input
	 * @param $user_category_ids
	 * @param $search_keywords
	 * @param $return_total
	 * @param int $results_from
	 * @param int $initial_limit
	 *
	 * @return array|false|int
	 */
	private function search_articles( $kb_id, $filtered_user_input, $user_category_ids, $search_keywords, $return_total, $results_from=0, $initial_limit=0 ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		$post_tbl = $wpdb->prefix . 'posts';
		$post_meta_tbl = $wpdb->prefix . 'postmeta';
		$kb_post_type  = ASEA_KB_Handler::get_post_type( $kb_id );

		$return_total_orig = $return_total;
		$return_total = ASEA_Utilities::is_amag_on() || $this->is_wpml_enabled ? false : $return_total;

		$select = " SELECT " . ( $return_total ? ' COUNT(DISTINCT wp.ID) ' : " wp.* " );
		$from = " FROM $post_tbl wp " . ( self::is_kb_lk_active() ? " LEFT JOIN $post_meta_tbl wpp ON ( wp.ID = wpp.post_id ) " : '' );
		if ( ! empty($user_category_ids) ) {
			$from .= "INNER JOIN {$wpdb->prefix}term_relationships tr ON wp.ID = tr.object_id
					  INNER JOIN {$wpdb->prefix}terms t ON t.term_id = tr.term_taxonomy_id ";
		}
		$search_query_prep = $this->process_search_keywords( $search_keywords );
		$search_sql = $search_query_prep['search_sql'];

		// POST STATUS
		$where_post_status = ASEA_Utilities::is_amag_on() ? " ( wp.post_status = 'publish' OR wp.post_status = 'private' ) " :
															" wp.post_status = 'publish' ";

		/* TODO when core can handle private posts
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$where_post_status .= current_user_can( 'read_private_posts' ) ?
									" OR wp.post_status = 'private' " :
									" OR ( wp.post_author = $user_id AND wp.post_status = 'private' ) ";
		} */
		$where = " WHERE $search_sql AND (wp.post_type = '{$kb_post_type}') AND ( $where_post_status ) ";
		
		// check if categories is selected, search only in selected categories
		if ( ! empty($user_category_ids) ) {
			$where .= ' AND (t.term_id in (' . implode($user_category_ids, ',') . ')) ';
		}

		$group_by = $return_total || ! self::is_kb_lk_active() ? '' : " GROUP BY wp.ID  ";

		$order_by = $this->assemble_order_by( $filtered_user_input, count($search_keywords), $search_query_prep['order_by_search_title'] );
		$order_by = " $order_by, wp.post_date DESC ";
		$order_by = $return_total ? '' : $order_by;

		$limit = $return_total || ASEA_Utilities::is_amag_on() || $this->is_wpml_enabled ? '' : " LIMIT " . $results_from . ', ' . $initial_limit;

		$sql = $select . $from . $where . $group_by . $order_by . $limit;
		if ( $return_total ) {
			$search_result = $wpdb->get_var( $sql );
		} else {
			$search_result = $wpdb->get_results( $sql );
		}

		// DEBUG is ON
		/* $is_debug_on = ASEA_Utilities::get_wp_option( ASEA_KB_Core::ASEA_KB_DEBUG, false );
		if ( $is_debug_on ) {
			error_log( ' Filtered user input: ' . $filtered_user_input );
			error_log( ' Search keywords: ' . ASEA_Utilities::get_variable_string($search_keywords) );
			error_log( ' SQL query: ' . $sql );
			error_log( ' Search result: ' . ASEA_Utilities::get_variable_string( $search_result ) );
		} */

		// check if error occurred
		if ( ! empty($wpdb->last_error) || $search_result === null ) {
			ASEA_Logging::add_log( "DB failure: " . $wpdb->last_error );
			return false;
		}

		// WPML filter language
		if ( $this->is_wpml_enabled ) {

			$articles_seq_data = ASEA_Utilities::get_kb_option( $kb_id, ASEA_KB_Core::ASEA_ARTICLES_SEQUENCE, array(), true );
			$articles_seq_data = ASEA_KB_Core::apply_article_language_filter( $articles_seq_data );

			$articles_filtered = array();
			foreach( $articles_seq_data as $category_id => $articles_array ) {

				$ix = 0;
				foreach( $articles_array as $article_id => $article_title ) {
					if ( $ix ++ < 2 ) {
						continue;
					}
					$articles_filtered[] = $article_id;
				}
			}

			$new_result = array();
			foreach( $search_result as $post ) {
				if ( in_array($post->ID, $articles_filtered) ) {
					$new_result[] = $post;
				}
			}
			$search_result = $new_result;
		}

		// if Access Manager enabled then filter returned articles
		if ( ASEA_Utilities::is_amag_on()) {
			$search_result = ASEA_KB_Core::foundPosts( $search_result );
		}

		// if we just need count then return it
		if ( $this->is_wpml_enabled || ASEA_Utilities::is_amag_on() ) {
			return isset($search_result) && is_array($search_result) ? ( $return_total_orig ? count($search_result) : array_splice($search_result, $results_from, $initial_limit) ) : false;
		}

		return isset($search_result) && is_array($search_result) ? $search_result : ( $return_total_orig ? $search_result : false );
	}

	/**
	 * Create search SQL based on individual search keywords.
	 * TODO FUTURE: more than 6 keywords -> take first 6 instead of sentence?
	 *
	 * @param $search_keywords
	 *
	 * @return array
	 */
	private function process_search_keywords( $search_keywords ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		$search_sql = '';

		// create LIKE for each search keyword
		$and = '';
		$order_by_search_title = array();
		foreach ( $search_keywords as $search_keyword ) {
			$search_like = '%' . $wpdb->esc_like( $search_keyword ) . '%';

			$order_by_search_title[] = $wpdb->prepare( "wp.post_title LIKE %s", $search_like );

			if ( self::is_kb_lk_active() ) {
				$search_sql .= $wpdb->prepare( " {$and} ( (wp.post_title LIKE %s) OR (wp.post_excerpt LIKE %s) OR (wp.post_content LIKE %s) " .
				                               " OR ( wpp.meta_key = 'kb" . "lk_search_terms' AND wpp.meta_value LIKE %s ) ) ",
											$search_like, $search_like, $search_like, $search_like );
			} else {
				$search_sql .= $wpdb->prepare( " {$and} ( (wp.post_title LIKE %s) OR (wp.post_excerpt LIKE %s) OR (wp.post_content LIKE %s) ) ",
											$search_like, $search_like, $search_like );
			}

			$and = 'AND';
		}

		/* we want to show password protected articles in the search
		if ( ! empty( $search_sql ) && ! is_user_logged_in() ) {
			$search_sql .= " AND (wp.post_password = '') ";
		} */

		return array( 'search_sql' => $search_sql, 'order_by_search_title' => $order_by_search_title );
	}

	/**
	 * Create Order By SQL.
	 * TODO FUTURE: more than 6 keywords -> take first 6 instead of sentence?
	 *
	 * @param $filtered_user_input
	 * @param $search_keywords_count
	 * @param $order_by_search_title
	 *
	 * @return string
	 */
	private function assemble_order_by( $filtered_user_input, $search_keywords_count, $order_by_search_title ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		// for single search keyword return simple order by
		if ( $search_keywords_count < 2 ) {
			return ' ORDER BY ' . reset( $order_by_search_title ) . ' DESC';
		}

		$like = '%' . $wpdb->esc_like( $filtered_user_input ) . '%';
		$search_order_by = '';

		// first try exact match to search phrase
		$search_order_by .= $wpdb->prepare( "WHEN wp.post_title LIKE %s THEN 1 ", $like );

		// try AND and OR for up to 5 keywords
		$num_keywords = count( $order_by_search_title );
		if ( $num_keywords <= self::MAX_KEY_WORDS ) {
			$search_order_by .= 'WHEN ' . implode( ' AND ', $order_by_search_title ) . ' THEN 2 ';
			if ( $num_keywords > 1 ) {
				$search_order_by .= 'WHEN ' . implode( ' OR ', $order_by_search_title ) . ' THEN 3 ';
			}
		}

		// also try to match full phrase in excerpt and content
		$search_order_by .= $wpdb->prepare( "WHEN wp.post_excerpt LIKE %s THEN 4 ", $like );
		$search_order_by .= $wpdb->prepare( "WHEN wp.post_content LIKE %s THEN 5 ", $like );

		$search_order_by = 'ORDER BY (CASE ' . $search_order_by . 'ELSE 6 END) ';

		return $search_order_by;

	 /* "(CASE WHEN post_title LIKE '{}test1 test2{}' THEN 1
       WHEN post_title LIKE '{}test1{}' AND post_title LIKE '{}test2{}' THEN 2
	   WHEN post_title LIKE '{}test1{}' OR post_title LIKE '{}test2{}' THEN 3
	   WHEN post_excerpt LIKE '{}test1 test2{}' THEN 4
	   WHEN post_content LIKE '{}test1 test2{}' THEN 5
	   ELSE 6 END)" */
	}

	/**
	 * Search KB Tags in Articles against search keywords.
	 *
	 * @param $kb_id
	 * @param $filtered_user_input = all keywords + individual keywords to search
	 * @param $user_category_ids
	 * @param int $results_from
	 * @param int $limit
	 *
	 * @return array|false
	 */
	private function search_tags( $kb_id, $filtered_user_input, $user_category_ids, $results_from=0, $limit=0 ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		// get individual search keywords WITHOUT stop words
		$tags_search_keywords_no_filler = $this->get_search_keywords( $filtered_user_input, false );

		// get individual search keywords but keep stop words
		$tags_search_keywords = $this->get_search_keywords( $filtered_user_input );

		// get individual search keywords
		$kb_tag_taxonomy = ASEA_KB_Handler::get_tag_taxonomy_name( $kb_id );
		$kb_category_taxonomy = ASEA_KB_Handler::get_category_taxonomy_name( $kb_id );

		// add 2-words combinations after stop word filter
		$additional_two_keywords = array();
		for ( $i = 1; $i < count( $tags_search_keywords ); $i++ ) {
			$additional_two_keywords[] = $tags_search_keywords[$i-1] . ' ' . $tags_search_keywords[$i];
		}

		// add 3-words combinations after stop word filter
		$additional_three_keywords = array();
		for ( $i = 2; $i < count( $tags_search_keywords ); $i++ ) {
			$additional_three_keywords[] = $tags_search_keywords[$i-2] . ' ' . $tags_search_keywords[$i-1] . ' ' . $tags_search_keywords[$i];
		}

		// finally add two and three word combination to search for
		$tags_search_keywords = array_merge($additional_two_keywords, $tags_search_keywords);
		$tags_search_keywords = array_merge($additional_three_keywords, $tags_search_keywords);

		// add 2-words combinations WITHOUT filler
		$additional_two_keywords = array();
		for ( $i = 1; $i < count( $tags_search_keywords_no_filler ); $i++ ) {
			$additional_two_keywords[] = $tags_search_keywords_no_filler[$i-1] . ' ' . $tags_search_keywords_no_filler[$i];
		}

		// add 3-words combinations WITHOUT filler
		$additional_three_keywords = array();
		for ( $i = 2; $i < count( $tags_search_keywords_no_filler ); $i++ ) {
			$additional_three_keywords[] = $tags_search_keywords_no_filler[$i-2] . ' ' . $tags_search_keywords_no_filler[$i-1] . ' ' . $tags_search_keywords_no_filler[$i];
		}

		// finally add two and three word combination to search for
		$tags_search_keywords = array_merge($additional_two_keywords, $tags_search_keywords);
		$tags_search_keywords = array_merge($additional_three_keywords, $tags_search_keywords);

		// find articles that match at least one search keyword
		$limit = " LIMIT " . $results_from . ', ' . $limit;

		$count_condition = ASEA_Utilities::is_amag_on() ? '' : 'AND count > 0';

		// check if categories is selected, search only in selected categories
		$where = "WHERE taxonomy = '$kb_tag_taxonomy' " . $count_condition . " ) terms ON terms.term_id = t.term_id AND name = %s ";
		if ( ! empty($user_category_ids) ) {
			$where = "WHERE (taxonomy = '$kb_tag_taxonomy' OR taxonomy = '$kb_category_taxonomy') " . $count_condition . " ) terms ON (terms.term_id = t.term_id AND name = %s AND t.term_id in (" . implode($user_category_ids,',') . ") )";
		}
		
        $where .= ASEA_Utilities::is_amag_on() ? " AND ( p.post_status = 'publish' OR p.post_status = 'private' ) " : " AND p.post_status = 'publish' ";

		// DEBUG is ON
		/* $is_debug_on = ASEA_Utilities::get_wp_option( ASEA_KB_Core::ASEA_KB_DEBUG, false );
		if ( $is_debug_on ) {
			error_log( ' TAGS Filtered user input: ' . $filtered_user_input );
		} */

		$search_result = array();
		foreach ( $tags_search_keywords as $search_keyword ) {

			$sql = "SELECT " . ' * ' . "
				FROM {$wpdb->prefix}posts p
					INNER JOIN {$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
					INNER JOIN {$wpdb->prefix}terms t ON t.term_id = tr.term_taxonomy_id
					INNER JOIN (SELECT term_id
								FROM {$wpdb->prefix}term_taxonomy " .
			                    $where . $limit;

			$sql = $wpdb->prepare( $sql, $search_keyword );

			$result = $wpdb->get_results( $sql );
			if ( ! empty($wpdb->last_error) || $result === null ) {
				ASEA_Logging::add_log( "DB failure: " . $wpdb->last_error );
				return false;
			}

			/* if ( $is_debug_on ) {
				ASEA_Logging::add_log( ' TAGS SQL query: ' . $sql );
				ASEA_Logging::add_log( ' Search result: ' . ASEA_Utilities::get_variable_string( $result ) );
			} */

			$search_result = array_merge( $search_result, $result );
		}

		if ( $this->is_wpml_enabled ) {
			// do not return articles that do not belong to the current language
			$current_article_ids = ASEA_Utilities::is_wpml_article_active( $search_result, true );
			foreach( $search_result as $key => $item ) {
				if ( ! in_array($item->ID, $current_article_ids) ) {
					unset($search_result[$key]);
				}
			}
		}

		// if Access Manager enabled then filter returned articles
		if ( ASEA_Utilities::is_amag_on()) {
			$search_result = ASEA_KB_Core::foundPosts( $search_result );
		}

		return $search_result;
	}

	/**
	 * Retrieve individual search keywords (keywords) or keep them together as sentence if too long
	 *
	 * @param $search_keywords_input
	 * @param bool $filter_stop_words
	 * @return array
	 */
	public function get_search_keywords( $search_keywords_input, $filter_stop_words=true ) {

		$filtered_search_keywords = array( $search_keywords_input );
		if ( preg_match_all( '/".*?("|$)|((?<=[\t ",+])|^)[^\t ",+]+/', $search_keywords_input, $matches ) ) {

			// Filter stop words
			$filtered_search_keywords = array();
			foreach ( $matches[0] as $keyword ) {

				$keyword = urldecode($keyword);
				$keyword = preg_match( '/^".+"$/', $keyword ) ? trim( $keyword, "\"'" ) : trim( $keyword, "\"' " );

				// filter stop words
				if ( $filter_stop_words && in_array( strtolower($keyword), $this->stop_words(), true ) ) {
					continue;
				}

				$filtered_search_keywords[] = $keyword;
			}
			
			// consider search keywords a sentence if it is too long or contains stop words
			if ( empty($filtered_search_keywords) || count($filtered_search_keywords) > self::MAX_KEY_WORDS ) {
				$filtered_search_keywords = array( $search_keywords_input );
			}
		}

		return $filtered_search_keywords;
	}

	/**
	 * Words that should not be matched in search as they are fillers rather than actual keywords
	 */
	private function stop_words() {

		/* translators: This is a comma-separated list of very common words that should be excluded from a search,
		 * like a, an, and the. These are usually called "stopwords". You should not simply translate these individual
		 * words into your language. Instead, look for and provide commonly accepted stopwords in your language.
		 */
	        // TODO	$words = explode( ',', _x( 'about,an,are,as,at,be,by,com,for,from,how,in,is,it,of,on,or,that,the,this,to,was,what,when,where,who,will,with,www',
			//'Comma-separated list of search stopwords in your language' ) );
		// TODO translate?

		return array( "a", "an", "about", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although",
			"always","among", "amongst", "amount",  "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around",
			"back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides",
			"between", "beyond", "both", "bottom","but", "by", "can", "cannot", "cant", "could", "couldnt", "cry", "describe", "detail",
			"done", "down", "due", "during", "each", "either", "else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every",
			"everyone", "everything", "everywhere", "except", "few", "fill", "find", "for", "former", "formerly",
			"found", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "hence", "her", "here", "hereafter", "hereby",
			"herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred",  "inc", "indeed", "interest", "into",
			"its", "itself", "keep", "last", "latter", "latterly", "least", "less", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more",
			"moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nobody",
			"none", "noone", "nor", "not", "nothing", "now", "nowhere", "off", "often","once", "one", "only", "onto", "other", "others", "otherwise",
			"our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems",
			"serious", "several", "she", "should", "show", "side", "since", "sincere",  "some", "somehow", "someone", "something", "sometime",
			"sometimes", "somewhere", "still", "such", "system", "take", "than", "that", "the", "their", "them", "themselves", "then", "there", "thereafter",
			"thereby", "therefore", "therein", "thereupon", "these", "they",  "thin", "this", "those", "though", "through", "throughout", "thru",
			"thus", "to", "together", "too", "top", "toward", "towards", "under", "until","upon",  "very", "via", "was", "we",
			"well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether",
			"which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours",
			"yourself", "yourselves", "the" );
	}

	/**
	 * Filter user input.
	 * @param $user_input
	 * @return String
	 */
	public static function filter_user_input( $user_input ) {
		$filtered_user_input = html_entity_decode( $user_input );
		$filtered_user_input = stripslashes( $filtered_user_input );
		//$filtered_user_input = preg_replace("/[^[:alnum:][:space:][-][']]/u", '', $filtered_user_input);
		$filtered_user_input = str_replace( array( "\r", "\n" ), '', $filtered_user_input );
		$filtered_user_input = sanitize_text_field( $filtered_user_input );
		$filtered_user_input = empty($filtered_user_input) || !is_string($filtered_user_input) ? '' : $filtered_user_input;
		return $filtered_user_input;
	}

	private static function is_kb_lk_active() {
		return defined( 'KB'.'LK_PLUGIN_NAME' );
	}

	public static function get_search_results_list_size( $kb_id ) {
		$kb_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return ASEA_Search_Utilities::get_search_kb_config( $kb_config, 'advanced_search_*_results_page_size' );
	}
}
