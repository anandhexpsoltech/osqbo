<?php

/**
 *
 * Processes imported KB file.
 *
 */
class EPIE_KB_Import_Processor {

	const IMPORT_CURRENT_KB_ID = "_epkb_import_current_kb_id";
	const IMPORT_ARTICLES_TO_IMPORT = "_epkb_import_articles_to_import";
	const IMPORT_CURRENT_STEP = "_epkb_import_current_step";
	const IMPORT_SELECTED_ROWS = "_epkb_import_selected_rows";
	const IMPORT_PROCESSED_COUNT = "_epkb_import_processed_count";
	const STEP_LENGTH = 20;
	
	public function __construct() {
		add_action( 'wp_ajax_epie_import_kb_content', array( $this, 'import_kb_content' ) );
		add_action( 'wp_ajax_epie_import_steps' , array( $this, 'import_kb_articles' ) );
	}

    /**
     * Import KB articles when user clicks import button.
     */
	public function import_kb_content() {

		// verify that request is authentic $_FILES
		if ( ! isset( $_REQUEST['_wpnonce_kb_import_export'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_kb_import_export'], '_wpnonce_kb_import_export' ) ) {
            wp_die( json_encode( array( 'error' => __( 'Refresh your page', 'echo-kb-import-export' ) ) ) );
		}

        // ensure user has correct permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( json_encode( array( 'error' => __( 'Only administrators can import articles.', 'echo-kb-import-export' ) ) ) );
        }

        if ( EPIE_Utilities::is_amag_on() ) {
            wp_die( json_encode( array( 'error' => __( 'Not yet available for Access Manager.', 'echo-kb-import-export' ) ) ) );
        }

		// retrieve KB ID we are saving
		$kb_id = EPIE_Utilities::get( 'epie_kb_id' );
		if ( empty($kb_id) || is_wp_error( $kb_id ) ) {
			EPIE_Logging::add_log("Received invalid kb_id when importing KB articles", $kb_id );
			wp_die( json_encode( array( 'error' => __( 'Invalid KB ID', 'echo-kb-import-export' ) ) ) );
		}

		// we cannot import or export non-default KB if MKB is not active
		if ( $kb_id != EPIE_KB_Core::DEFAULT_KB_ID && ! EPIE_Utilities::is_multiple_kbs_enabled() ) {
			wp_die( json_encode( array( 'error' => __( 'Multiple KB plugin needs to be active.', 'echo-kb-import-export' ) ) ) );
		}

		delete_transient( self::IMPORT_ARTICLES_TO_IMPORT );
		delete_option( self::IMPORT_CURRENT_STEP );
		delete_option( self::IMPORT_CURRENT_KB_ID );
		delete_option( self::IMPORT_SELECTED_ROWS );
		delete_option( self::IMPORT_PROCESSED_COUNT );
		
		// check the file has correct format
        $result = $this->validate_import_file();
		if  ( is_wp_error($result) ) {
			wp_die( json_encode( array( 'error' => $result->get_error_message() ) ) );
		}

		$fp = fopen($_FILES["file"]["tmp_name"], "r");
		if ( $fp === FALSE ) {
			wp_die( json_encode( array( 'error' => __( 'The file could not be read.', 'echo-kb-import-export' ) ) ) );
		}

		// read CSV Data Into array
        $articles_to_import = $this->parse_csv_data( $fp );
		if ( is_wp_error($articles_to_import) ) {
            fclose($fp);
            wp_die( json_encode( array( 'error' => $articles_to_import->get_error_message() ) ) );
        }

		$import_action = EPIE_Utilities::get( 'import_action' );

		// import articles
		if ( $import_action == 'import_data' ) {
			// save import data 
			EPIE_Utilities::save_wp_option( self::IMPORT_CURRENT_KB_ID, $kb_id, true );
			EPIE_Utilities::save_wp_option( self::IMPORT_CURRENT_STEP, 0, true );
			set_transient( self::IMPORT_ARTICLES_TO_IMPORT, $articles_to_import, HOUR_IN_SECONDS );
			
			$selected_rows = EPIE_Utilities::get( 'selected_rows' );
			$selected_rows = json_decode(stripslashes($selected_rows));
			if ( empty($selected_rows) || ! is_array($selected_rows) ) {
				wp_die( json_encode( array( 'error' => __( 'No articles were selected for import.', 'echo-kb-import-export' ) ) ) );
			}
			
			EPIE_Utilities::save_wp_option( self::IMPORT_SELECTED_ROWS, $selected_rows, true );
			
			self::import_kb_articles();

		// show each article import status
		} else {
			self::prepare_kb_articles_for_import( $kb_id, $articles_to_import );
		}
	}

    /**
     * Check that file can be imported.
     *
     * @return bool|WP_Error
     */
	private function validate_import_file() {

		// Get file extension
		$file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

		// Validate file input to check if it is not empty
		if ( ! file_exists($_FILES["file"]["tmp_name"]) ) {
			return new WP_Error( 'E01', __( 'The file does not exist', 'echo-kb-import-export' ) );
		}

		// Validate file input to check if is with valid extension
		if ( $file_extension != "csv" ) {
            return new WP_Error( 'E01', __( 'The file does not have CSV format.', 'echo-kb-import-export' ) );
		}

		return true;
	}

    /**
     * Parse the actual CSV file
     * @param $fp
     * @return array|WP_Error
     */
	private function parse_csv_data( $fp ) {

        // read CSV header row
        $header = fgetcsv($fp);
        if ( empty($header) ) {
            return new WP_Error( 'E01', __( 'Could not parse CSV header (first row).', 'echo-kb-import-export' ) );
        }
        $header = array_map("strtolower", $header );

		// validate CSV header
        if ( ! in_array('title', $header) && ! in_array('content', $header) ) {
            return new WP_Error( 'E01', __( "Title and Content columns are missing. CSV Header should at least have Title and Content.", 'echo-kb-import-export' ) );
        }

        if ( ! in_array('title', $header) ) {
            return new WP_Error( 'E01', __( 'Title column is missing. CSV Header should at least have Title and Content.', 'echo-kb-import-export' ) );
        }

        if ( ! in_array('content', $header) ) {
            return new WP_Error( 'E01', __( 'Content column is missing. CSV Header should at least have Title and Content', 'echo-kb-import-export' ) );
        }

        // read individual rows
		$row_id = 2;
		$articles_to_import = array();
        while ( ($row = fgetcsv($fp)) !== FALSE ) {

            // read individual columns
            $post = array();
            foreach ( $header as $row_ix => $column_name ) {
                $column_name = trim( $column_name );

                if ( ! isset($row[$row_ix]) ) {
                    return new WP_Error( 'E01',  sprintf(__( 'Column "%s" is missing a value in the row %d.', 'echo-kb-import-export' ), $column_name, $row_id) );
                }

                $post[$column_name] = $row[$row_ix];
            }
            $post['epie_line'] = $row_id++;
            $articles_to_import[] = $post;
        }
        fclose($fp);

        // verify we found any article
        if ( empty($articles_to_import) ) {
            return new WP_Error( 'E01', __( 'No Data Found', 'echo-kb-import-export' ) );
        }

        return $articles_to_import;
    }

    /**
     * Show all articles to be imported and their status so user chooses whether to import each.
     *
     * @param $articles_to_import
     * @param $kb_id
     */
    private function prepare_kb_articles_for_import( $kb_id, $articles_to_import ) {

	    $response_html = '';
	    $nof_articles = 0;

	    // FIRST display all found ERRORS
		$table_header = array( __( 'Line Number', 'echo-kb-import-export' ), __( 'Error Details', 'echo-kb-import-export' ) );
	    $table_rows = array();
		$count_errors = 0;
	    foreach ( $articles_to_import as $key => $post ) {

            $post_title = $this->get_post_title( $post );
            $content = $this->get_post_content( $post );
            $article_categories = $this->get_post_categories( $post );

		    $line_number = $this->get_line_number( $post['epie_line'] );

		    $result = $this->validate_title( $post_title );
			if ( ! empty($result) ) {
				$count_errors++;
				$table_rows[] = array( $line_number, $result );
				unset($articles_to_import[$key]);
				continue;
			}

		    $result = $this->validate_content( $content );
		    if ( ! empty($result) ) {
			    $count_errors++;
			    $table_rows[] = array( $line_number, $result );
			    unset($articles_to_import[$key]);
			    continue;
		    }

		    $result = $this->validate_categories( $kb_id, $article_categories );
		    if ( ! empty($result) ) {
			    $count_errors++;
			    $table_rows[] = array( $line_number, $result );
			    unset($articles_to_import[$key]);
			    continue;
		    }
	    }

	    if ( $count_errors > 0 ) {
		    $response_html .= $this->output_table( 'Errors Found', 'List of all rows that could not be parsed and that will not be imported unless fixed.', $table_header, $table_rows, 'error' );
	    }

	    // SECOND display all overwritten articles
	    $table_header = array( __( 'Action', 'echo-kb-import-export' ), __( 'Line Number', 'echo-kb-import-export' ), __( 'Article Link', 'echo-kb-import-export' ), __( 'Categories', 'echo-kb-import-export' ), __( 'Article Title', 'echo-kb-import-export' ) );
	    $table_rows = array();
	    $count_overwrite = 0;
	    foreach ( $articles_to_import as $key => $post ) {

            $post_title = $this->get_post_title( $post );
            $article_categories = $this->get_post_categories( $post );

		    $post_title = substr($post_title, 0, 100) . ( strlen($post_title) > 100 ? '...' : '' );

		    $category_list = $this->get_categories_list( $article_categories );

		    $line_number = $this->get_line_number($post['epie_line']);

		    $found_article_id = post_exists( $post_title, '', '', EPIE_KB_Handler::KB_POST_TYPE_PREFIX . $kb_id );
		    if ( ! $found_article_id ) {
		    	continue;
		    }

		    unset($articles_to_import[$key]);
		    $count_overwrite++;
		    $input_box = "<input type='checkbox' name='csv_row' value='" . $post['epie_line'] . "' checked>";
		    $article_link = ' <a href="' . get_permalink($found_article_id) . '" target="_blank"><i class="epkbfa epkbfa-external-link"></i></a>';
		    $table_rows[] = array( $input_box, $line_number, $article_link, $category_list, $post_title );
            $nof_articles++;
	    }

	    if ( $count_overwrite > 0 ) {
		    $response_html .= $this->output_table( 'Overwrite Articles',  __( 'Lists all rows that represent existing articles. Articles title, content and categories will be overwritten and article status set to Draft.',  'echo-kb-import-export' ), $table_header, $table_rows, 'override' );
	    }

	    // THIRD display all new articles
	    $table_header = array( __( 'Action', 'echo-kb-import-export' ), __( 'Line Number', 'echo-kb-import-export' ), __( 'Categories', 'echo-kb-import-export' ), __( 'Article Title', 'echo-kb-import-export' ) );
	    $table_rows = array();
	    $count_overwrite = 0;
	    foreach ( $articles_to_import as $post ) {

            $post_title = $this->get_post_title( $post );
		    $post_title = substr($post_title, 0, 100) . ( strlen($post_title) > 100 ? '...' : '' );
		    $line_number = $this->get_line_number($post['epie_line']);

            $article_categories = $this->get_post_categories( $post );
		    $category_list = $this->get_categories_list( $article_categories );

		    $found_article_id = post_exists( $post_title, '', '', EPIE_KB_Handler::KB_POST_TYPE_PREFIX . $kb_id );
		    if ( $found_article_id ) {
			    continue;
		    }

		    $count_overwrite++;
		    $input_box = "<input type='checkbox' name='csv_row' value='" . $post['epie_line'] . "' checked>";
		    $table_rows[] = array( $input_box, $line_number, $category_list, $post_title );
            $nof_articles++;
	    }


	    if ( $count_overwrite > 0 ) {
		    $response_html .= $this->output_table( 'New Articles', __( 'Lists articles that will be created (as Draft) with given categories assigned.', 'echo-kb-import-export' ), $table_header, $table_rows, 'new' );
	    }

	    $output_message = $this->output_success( __( 'Articles prepared for import', 'echo-kb-import-export' ), $nof_articles . __( ' valid articles found', 'echo-kb-import-export' ) );

	    wp_die( json_encode( array( 'success' => $output_message, 'response_html' => $response_html ) ) );
    }

    private function get_line_number( $row_id ) {
    	return '<span>' . sprintf( __( 'Line %d', 'echo-kb-import-export' ), $row_id ) . '</span>';
    }

    private function get_categories_list( $categories_names ) {

    	if ( empty($categories_names) )  {
    		return '';
	    }

	    $categories_names = explode(',', $categories_names);
	    $html             = '<div class="epie-dsl__article-list__body__info epkbfa epkbfa-info-circle"><div class="epie-dsl__article-list__body__info__data"><ul>';
    	foreach( $categories_names as $category_name ) {
    		if ( empty($category_name) ) {
    			continue;
		    }
			$html .= '<li>' . $category_name . '</li>';
        }

        $html .= '</ul></div></div>';

        return $html;
    }

	/**
	 * Output HTML table with details.
	 *
	 * @param $title
	 * @param $description
	 * @param $table_header
	 * @param $table_rows
	 * @param $type
	 *
	 * @return string
	 */
    private function output_table( $title, $description, $table_header, $table_rows, $type ) {

    	$table_class = $type == 'error' ? 'epie-dsl__article-list--error-articles' : ( $type == 'override' ? 'epie-dsl__article-list--overwrite-articles' : 'epie-dsl__article-list--new-articles' );

	    $response_html = '<div class="epie-dsl__article-list-container ' . $table_class . '">';

	    $response_html .= '<h4>' . $title . '</h4>';
	    $response_html .= '<p>' . $description . '</p>';

	    // output header
	    $response_html .= '<section class="epie-dsl__article-list__header">';
	    $response_html .= '<div class="epie-admin-row">';
	    foreach( $table_header as $table_header_item ) {
		    $response_html .= '<span>' . $table_header_item . '</span>';
	    }
	    $response_html .= '</div>';
	    $response_html .= '</section>';

	    // display the body
	    $response_html .= '<section class="epie-dsl__article-list__body">';

	    foreach ( $table_rows as $rows ) {
		    $response_html .= '<div class="epie-admin-row">';
		    foreach($rows as $index => $row) {
			    $response_html .= '<span>' .$row . '</span>';
		    }
		    $response_html .= '</div>';

	    }
	    $response_html .= '</section>';

	    $response_html .= '</div>';

	    return $response_html;
    }

    /**
     * Import selected articles.
     */
	public function import_kb_articles( ) {
		global $eckb_kb_id;

        kses_init_filters();  // Always filter imported data with kses
		
		$kb_id = EPIE_Utilities::get_wp_option( self::IMPORT_CURRENT_KB_ID, 0 );
		if ( empty($kb_id) ) {
			EPIE_Logging::add_log("Received invalid kb_id when importing KB articles", $kb_id );
			wp_die( json_encode( array( 'error' => __( 'Invalid KB ID', 'echo-kb-import-export' ) ) ) );
		}
		$eckb_kb_id = $kb_id;
		
		$articles_to_import = EPIE_Utilities::get_wp_option( '_transient_' . self::IMPORT_ARTICLES_TO_IMPORT, array() );
		$kb_taxonomy_name = EPIE_KB_Handler::get_category_taxonomy_name( $kb_id );

		$selected_rows = EPIE_Utilities::get_wp_option( self::IMPORT_SELECTED_ROWS, array(), true );
		$total_rows = count($selected_rows);
		if ( empty($total_rows) ) {
			wp_die( json_encode( array( 'error' => __( 'Total number of selected rows is empty.', 'echo-kb-import-export' ) ) ) );
		}

		// calculate and save the next step
		$current_step = EPIE_Utilities::get_wp_option( self::IMPORT_CURRENT_STEP, null );
		if ( $current_step === null ) {
			EPIE_Logging::add_log("Received invalid kb_id when importing KB articles", $kb_id );
			wp_die( json_encode( array( 'error' => 'Error IM03' ) ) );
		}

		$current_row_ix = $current_step * self::STEP_LENGTH;
		$current_step++;
		EPIE_Utilities::save_wp_option( self::IMPORT_CURRENT_STEP, $current_step, true );

		$processed_articles_count = EPIE_Utilities::get_wp_option( self::IMPORT_PROCESSED_COUNT, 0 );

		// is the import complete?
		if ( $current_row_ix + 1 >= count($articles_to_import) ) {

			$output_message = $this->output_success( __( 'Import completed successfully', 'echo-kb-import-export' ), $processed_articles_count . __( ' KB Articles Inserted', 'echo-kb-import-export' ) );

			delete_transient( self::IMPORT_ARTICLES_TO_IMPORT );
			delete_option( self::IMPORT_CURRENT_STEP );
			delete_option( self::IMPORT_CURRENT_KB_ID );
			delete_option( self::IMPORT_SELECTED_ROWS );
			delete_option( self::IMPORT_PROCESSED_COUNT );

			wp_die( json_encode( array(	'success' => $output_message, 'inserted' => $processed_articles_count ) ) );
		}

		// continue with import of articles
		$added_category_names = array();
		while ( $current_row_ix < $current_step * self::STEP_LENGTH && $current_row_ix < $total_rows ) {

			if ( ! isset($articles_to_import[$current_row_ix]) || ! is_array($articles_to_import[$current_row_ix]) ) {
				wp_die( json_encode( array( 'error' => __( 'missing article line', 'echo-kb-import-export' ) . $current_row_ix ) ) );
			}

			$post = $articles_to_import[$current_row_ix];
			$current_row_ix++;

			// only processed selected articles
			if ( ! isset($post['epie_line']) || ! in_array( $post['epie_line'], $selected_rows ) ) {
				continue;
			}

			$post_title = $this->get_post_title( $post );
			$content = $this->get_post_content( $post );
			$article_categories = $this->get_post_categories( $post );

			$result = $this->validate_title( $post_title );
			if ( ! empty($result) ) {
				wp_die( json_encode( array( 'error' => $result . __( ' at Line', 'echo-kb-import-export' ) . $post['epie_line'] ) ) );
			}

			$result = $this->validate_content( $content );
			if ( ! empty($result) ) {
				wp_die( json_encode( array( 'error' => $result . __( ' at Line', 'echo-kb-import-export' ) . $post['epie_line'] ) ) );
			}

			$result = $this->validate_categories( $kb_id, $article_categories );
			if ( ! empty($result) ) {
				wp_die( json_encode( array( 'error' => $result . __( ' at Line', 'echo-kb-import-export' ) . $post['epie_line'] ) ) );
			}

			$found_article = post_exists( $post_title, '', '', EPIE_KB_Handler::KB_POST_TYPE_PREFIX . $kb_id );

			// insert or update the post into the database
			if ( $found_article ) {
				$kb_post_id = wp_update_post( array(
					"ID"         	=> $found_article,
					"post_title" 	=> $post_title,
					"post_content" 	=> $content,
					"post_type" 	=> EPIE_KB_Handler::KB_POST_TYPE_PREFIX . $kb_id,
					'post_status'   => 'draft'
				));

			} else {
				$kb_post_id = wp_insert_post( array(
					"post_title" 	=> $post_title,
					"post_content" 	=> $content,
					"post_type" 	=> EPIE_KB_Handler::KB_POST_TYPE_PREFIX . $kb_id,
					'post_status'   => 'draft'
				));
			}

			if ( is_wp_error($kb_post_id) || empty($kb_post_id) ) {
				//there was an error in the post insertion/updation
				$kb_post_id = is_wp_error($kb_post_id) ? $kb_post_id : new WP_Error('empty post id');
				wp_die( json_encode( array( 'error' => __( 'Error occurred when importing Article: "' . substr($post_title, 0, 100) . '" at Line ' . $post['epie_line'] . ', details: ' . $kb_post_id->get_error_message(), 'echo-kb-import-export' ) ) ) );
			}

			// retrieve categories to assign
			$article_categories = trim($article_categories);
			$article_categories = empty($article_categories) ? array('') : explode(',', $article_categories);
			$added_category_names = array_unique ( array_merge($added_category_names, $article_categories) );

			// update article categories
			$result = wp_set_object_terms( $kb_post_id, $article_categories, $kb_taxonomy_name );
			if ( is_wp_error($result) ) {
				wp_die( json_encode( array( 'error' => __( 'Error occurred when adding category to an article: "' . substr($post_title, 0, 100) . '" at Line ' . $post['epie_line'] . ', details: ' . $result->get_error_message(), 'echo-kb-import-export' ) ) ) );
			}

			// increase count of imported
			$result = EPIE_Utilities::save_wp_option( self::IMPORT_PROCESSED_COUNT, ++$processed_articles_count, true );
			if ( is_wp_error($result) ) {
				wp_die( json_encode( array( 'error' => __( 'Could not save processed article count: "' . substr($post_title, 0, 100) . '" at Line ' . $post['epie_line'] . ', details: ' . $result->get_error_message(), 'echo-kb-import-export' ) ) ) );
			}
		}

		// update article and category sequence
		$result = EPIE_KB_Core::update_categories_sequence();
		if ( is_wp_error($result) ) {
			wp_die( json_encode( array( 'error' => 'IE35' ) ) );
		}

		/* foreach( $added_category_names as $added_category_name ) {
			$term_info = term_exists( $added_category_name, $kb_taxonomy_name );
			if ( empty($term_info['term_id']) ) {
				wp_die( json_encode( array( 'error' => 'IE34: ' . $added_category_name ) ) );
			}

			$result = EPIE_KB_Core::update_categories_sequence( $term_info['term_id'] );
			if ( is_wp_error($result) ) {
				wp_die( json_encode( array( 'error' => 'IE36 for ' . $term_info['term_id'] ) ) );
			}
		} */

		$progress = ( $processed_articles_count / $total_rows ) * 100;
		wp_die( json_encode( array(	'process_message' => sprintf( __( 'Processed %d articles out of %d...', 'echo-kb-import-export' ), $processed_articles_count, $total_rows ), 'progress' => $progress, 'processed' => $processed_articles_count, 'fr' => $current_row_ix, 'step' => $current_step )) );
	}

	private function get_post_title( $post ) {
        return sanitize_text_field( empty($post['title']) ? '' : $post['title'] );
    }

    private function get_post_content( $post ) {
        return wp_kses_post( empty($post['content']) ? '' : $post['content'] );
    }

    private function get_post_categories( $post ) {
	    $category_names = empty($post['categories']) ? '' : $post['categories'];
	    $category_names = wp_unslash( $category_names );
        return sanitize_text_field( $category_names );
    }

	private function validate_title( $post_title ) {
		if ( empty($post_title) ) {
			return __( 'Title is empty.', 'echo-kb-import-export' );
		}
		return '';
	}

	private function validate_content( $post_content ) {
		return '';
	}

    /**
     * Validate categories and return message on ERROR.
     * @param $kb_id
     * @param $article_categories
     * @return string
     */
	private function validate_categories( $kb_id, $article_categories ) {

		$article_categories = trim($article_categories);
		if ( empty($article_categories) ) {
			return '';
		}

		$categories = explode(',', $article_categories);
		if ( empty($categories) || ! is_array($categories) ) {
			return __( 'Could not parse categories.', 'echo-kb-import-export' );
		}

		$missing_categories = '';
		foreach( $categories as $category_name ) {
			$result = term_exists( $category_name, EPIE_KB_Handler::get_category_taxonomy_name( $kb_id ) );
			if ( empty($result) ) {
				$missing_categories .= ( empty($missing_categories) ? '' : ', ' ) . $category_name;
			}
		}

		/* if ( ! empty($missing_categories) ) {
			return __( 'Could not find these KB categories: ' . $missing_categories, 'echo-kb-import-export' );
		} */

		return '';
	}

	private function output_success( $message1, $message2 ) {
		return '
		<div class="epie-export-progress__row epie-export-progress__row--finished">
			<div class="epie-export__icon"><i class="epkbfa epkbfa-check-circle"></i></div>
			<div class="epie-export__title">' . $message1 . '</div>
		</div>
		<div class="epie-export-progress__row epie-export-progress__row--finished">
			<div class="epie-export__icon"><i class="epkbfa epkbfa-check-circle"></i></div>
			<div class="epie-export__title">' . $message2 . '</div>
		</div>';
	}

}