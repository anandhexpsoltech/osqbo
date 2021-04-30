<?php

/**
 * Add-on main class.
 */
class EPIE_KB_Export_Ctrl {
	
	public $array_divider = '||***||'; // just random string to divide serialized arrays in the export temp files
	
	public function __construct() {
		// TODO add_action( 'wp_ajax_epie_kb_get_article_ids', array( $this, 'get_article_ids' ) );
		// TODO add_action( 'wp_ajax_epie_kb_export_article_pack', array( $this, 'export_article_pack' ) );
	    // TODO	add_action( 'wp_ajax_epie_kb_export_get_csv', array( $this, 'get_csv' ) );
		// TODO add_action( 'wp_ajax_epie_kb_export_get_json', array( $this, 'get_json' ) );
		add_action( 'wp_ajax_epie_get_export_data', array( $this, 'get_export_data' ) );
		add_action( 'wp_ajax_epie_make_step', array( $this, 'make_step' ) );
	}
	
	// Handle export data and 
	public function get_export_data() {
		
		$default = array(
			'status' => 'success',
			'success' => '',
			'error' => '',
			'file' => ''
		);
		
		$post_data = array();
		parse_str( $_POST['form'], $post_data );
		
		// verify that request is authentic
		if ( ! isset( $_REQUEST['_wpnonce_kb_import_export'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_kb_import_export'], '_wpnonce_kb_import_export' ) ) {
			$response = array(
				'status' => 'error',
				'error' => __( 'Refresh your page', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}

		// retrieve KB ID we are saving
		$kb_id = empty($post_data['kb_id']) ? '' : EPIE_Utilities::sanitize_get_id( $post_data['kb_id'] );
		if ( empty($kb_id) || is_wp_error( $kb_id ) ) {
			
			EPIE_Logging::add_log("Received invalid kb_id when archiving KB", $kb_id );
			$response = array(
				'status' => 'error',
				'error' => __( 'Invalid KB ID', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}

		// we cannot import or export non-default KB if MKB is not active
		if ( $kb_id != EPIE_KB_Core::DEFAULT_KB_ID && ! EPIE_Utilities::is_mkb_enabled() ) {
			
			$response = array(
				'status' => 'error',
				'error' => __( 'Invalid KB choice', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}
		
		// ensure user has correct permissions
		if ( ! current_user_can( 'manage_options' ) ) {

			$response = array(
				'status' => 'error',
				'error' => __( 'Refresh your page (1)', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}
		
		// Access Manager is not supported now 
		if ( EPIE_Utilities::is_amag_on() ) {
			
			$response = array(
				'status' => 'error',
				'error' => __( 'Access Manager is not supported at the moment', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}
		
		/* data example 
			arr[key] = {
				'ids' : [10,15,16],  // FROM new TO old - inverted order! 
				'type' : key, // articles, categories, tags, 
				'text' : 'Articles exported: $count',
				'total' : 20,
				'active' : false // always false from php 
			}
		*/
		
		$data = array();
		
		// add articles
		$articles = get_posts(array(
			'post_type' => EPIE_KB_Handler::get_post_type( $post_data['kb_id'] ),
			'numberposts' => '-1',
			'fields' => 'ids'
		));

		$data['articles'] = array(
			'ids' => $articles,
			'type' => 'articles',
			'text' => __('Articles exported: $count', 'echo-knowledge-base'),
			'total' => count( $articles ),
			'active' => false
		);

		// add categories
		$terms = get_terms( array(
			'taxonomy'      => EPIE_KB_Handler::get_category_taxonomy_name( $post_data['kb_id'] ),
			'hide_empty'    => false,
			'fields'        => 'ids',
			'get'           => 'all'
		) );

		$data['categories'] = array(
			'ids' => $terms,
			'type' => 'categories',
			'text' => __('Categories exported: $count', 'echo-knowledge-base'),
			'total' => count( $terms ),
			'active' => false
		);

		// add tags
		$tags = get_terms( array(
			'taxonomy'      => EPIE_KB_Handler::get_tag_taxonomy_name( $post_data['kb_id'] ),
			'hide_empty'    => false,
			'fields'        => 'ids',
			'get'           => 'all'
		) );

		$data['tags'] = array(
			'ids' => $tags,
			'type' => 'tags',
			'text' => __('Tags exported: $count', 'echo-knowledge-base'),
			'total' => count( $tags ),
			'active' => false
		);

		$data['sequence'] = array(
			'ids' => ['articles', 'categories'],
			'type' => 'sequence',
			'text' => __('Sequence: $count', 'echo-knowledge-base'),
			'total' => 2,
			'active' => false
		);
			
		// add user data
		$description = sanitize_text_field($post_data['description']);
		$tag = empty($post_data['tag']) ? '' : sanitize_text_field($post_data['tag']);
		
		$file_id = time();
		$this->add_meta( $post_data['kb_id'], $file_id, $tag = '', $description = '' );
		
		$response = array(
			'data' => $data, 
			'description' => $description, 
			'tag' => $tag,
			'file_id' => $file_id
		);
		
		wp_die( json_encode( array_merge( $default, $response ) ) );
	}
	
	// make export step 
	public function make_step() {
		
		$default = array(
			'status' => 'success',
			'success' => '',
			'error' => '',
			'file' => ''
		);
		
		// verify that request is authentic
		if ( ! isset( $_REQUEST['_wpnonce_kb_import_export'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_kb_import_export'], '_wpnonce_kb_import_export' ) ) {
			$response = array(
				'status' => 'error',
				'error' => __( 'Refresh your page', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}
		
		// retrieve KB ID we are saving
		$kb_id = empty($_REQUEST['kb_id']) ? '' : EPIE_Utilities::sanitize_get_id( $_REQUEST['kb_id'] );
		if ( empty($kb_id) || is_wp_error( $kb_id ) ) {
			
			EPIE_Logging::add_log("Received invalid kb_id when archiving KB", $kb_id );
			$response = array(
				'status' => 'error',
				'error' => __( 'Invalid KB ID', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}

		// we cannot import or export non-default KB if MKB is not active
		if ( $kb_id != EPIE_KB_Core::DEFAULT_KB_ID && ! EPIE_Utilities::is_mkb_enabled() ) {
			
			$response = array(
				'status' => 'error',
				'error' => __( 'Invalid KB choice', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}
		
		// ensure user has correct permissions
		if ( ! current_user_can( 'manage_options' ) ) {

			$response = array(
				'status' => 'error',
				'error' => __( 'Refresh your page (1)', 'echo-knowledge-base' )
			);
			
			wp_die( json_encode( array_merge( $default, $response ) ) );
		}

		$file_id = sanitize_text_field($_POST['file_id']);
		
		switch ( $_POST['type'] ) {
			case 'articles':
				$response = $this->add_articles( $_POST['ids'], $file_id );
				break;
			case 'categories':
				$response = $this->add_categories( $_POST['kb_id'], $_POST['ids'], $file_id );
				break;
			case 'tags':
				$response = $this->add_tags( $_POST['kb_id'], $_POST['ids'], $file_id );
				break;
			case 'sequence':
				$response = $this->add_sequence( $_POST['kb_id'], $_POST['ids'], $file_id );
				break;
			case 'finish':
				$response = $this->get_export_file_link( $file_id, $_POST['tag'] );
				break;
		}
		
		wp_die( json_encode( array_merge( $default, $response ) ) );
	}
	
	// add metadata 
	public function add_meta ( $kb_id, $file_id, $tag = '', $description = '' ) {
		global $wpdb;
		$meta_data = array();
		
		$meta_data['multisite'] = is_multisite();
		$meta_data['SITE_URL'] = site_url();
		$meta_data['HOME_URL'] = home_url();
		$meta_data['wp_version'] = get_bloginfo( 'version' );
		$meta_data['permalink_structure'] = get_option( 'permalink_structure' );
		
		$theme_data = wp_get_theme();
		$meta_data['active_theme'] = $theme_data->Name . ' ' . $theme_data->Version;
		
		$meta_data['host'] = defined( 'WPE_APIKEY' ) ? "Host: WP Engine" : '<unknown>';
		$meta_data['php_version'] = PHP_VERSION;
		$meta_data['table_prefix'] = $wpdb->prefix;
		
		$plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );
		$kb_plugins = array();
		
		foreach ( $plugins as $plugin_path => $plugin ) {
			// If the plugin isn't active, don't show it.
			if ( ! in_array( $plugin_path, $active_plugins ) ) {
				continue;
			}
			
			if ( in_array($plugin['Name'], array('KB - Article Rating and Feedback','KB - Links Editor','KB - Import Export','KB - Multiple Knowledge Bases','KB - Widgets',
												'Knowledge Base for Documents and FAQs'))) {
				$kb_plugins[] = array(
					'name' => $plugin['Name'],
					'version' => $plugin['Version']
				);
			}
		}
		
		$meta_data['kb_plugins'] = $kb_plugins;
		$meta_data['description'] = $description;
		$meta_data['tag'] = $tag;
		$meta_data['time'] = current_time( 'Y-m-d H:i' ); // because file id is time() when export was started
		$user = wp_get_current_user(); // we are in admin side, so user will exists always
		
		$meta_data['admin_email'] = $user->user_email;
		
		// write to file 
		$file_result = $this->add_data_to_file( $file_id, 'meta', $meta_data );
		
		return array();
	}
	
	// add articles data to file 
	public function add_articles ( $ids, $file_id ) {
		global $wpdb;
		global $wp_query;
		$articles = array();
		
		if ( is_array($ids) ) {
			
			// Fake being in the loop.
			$wp_query->in_the_loop = true;
			$where = 'WHERE ID IN (' . join( ',', $ids ) . ')';
			$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} $where" );
			
			foreach ( $posts as $post ) {
				$article_data = array();
				setup_postdata( $post );
				
				$article_data['title'] = apply_filters( 'the_title_rss', $post->post_title );
				$article_data['content'] = apply_filters( 'the_content_export', $post->post_content );
				$article_data['excerpt'] = apply_filters( 'the_excerpt_export', $post->post_excerpt );
				$article_data['post_id'] = intval( $post->ID );
				$article_data['post_date'] = $post->post_date;
				$article_data['post_date_gmt'] = $post->post_date_gmt;
				$article_data['comment_status'] = $post->comment_status;
				$article_data['ping_status'] = $post->ping_status;
				$article_data['post_name'] = $post->post_name; // slug
				$article_data['status'] = $post->post_status;
				$article_data['post_parent'] = $post->post_parent;
				$article_data['menu_order'] = $post->menu_order;
				$article_data['post_type'] = $post->post_type;
				$article_data['post_password'] = $post->post_password;
				$article_data['is_sticky'] = is_sticky( $post->ID ) ? 1 : 0;
				
				// taxonomies 
				$taxonomies = get_object_taxonomies( $post->post_type );
				
				if ( ! empty( $taxonomies ) ) {
					$article_data['terms'] = array();
					
					$terms = wp_get_object_terms( $post->ID, $taxonomies );
					foreach ( (array) $terms as $term ) {
						
						if ( ! isset( $article_data['terms'][$term->taxonomy] ) ) {
							$article_data['terms'][$term->taxonomy] = array();
						}
						
						$article_data['terms'][$term->taxonomy][] = $term->slug;
					}
				}
				
				// meta fields 
				$postmeta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id = %d", $post->ID ) );
				
				if ($postmeta) {
					$article_data['postmeta'] = array();
					foreach ( $postmeta as $meta ) {
						$article_data['postmeta'][] = array(
							'meta_key' => $meta->meta_key,
							'meta_value' => $meta->meta_value
						);
					}
				}
				
				// comments - standart comments, without rating table 
				$_comments = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved <> 'spam'", $post->ID ) );
				$comments  = array_map( 'get_comment', $_comments );
				
				if ($comments) {
					$article_data['comments'] = array();

					foreach ( $comments as $c ) {
						// comment meta 
						$c_meta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->commentmeta WHERE comment_id = %d", $c->comment_ID ) );
						$commentmeta = array();
						
						if ( $c_meta ) {
							foreach ( $c_meta as $meta ) {
								$commentmeta[] = array(
									'meta_key' => $meta->meta_key,
									'meta_value' => $meta->meta_value,
								);
							}
						}
						
						$article_data['comments'][] = array(
							'comment_ID' => intval( $c->comment_ID ),
							'comment_author' => $c->comment_author,
							'comment_author_email' => $c->comment_author_email,
							'comment_author_url' => $c->comment_author_url,
							'comment_author_IP' => $c->comment_author_IP,
							'comment_date' => $c->comment_date,
							'comment_date_gmt' => $c->comment_date_gmt,
							'comment_content' => $c->comment_content,
							'comment_approved' => $c->comment_approved,
							'comment_type' => $c->comment_type,
							'comment_parent' => intval( $c->comment_parent ),
							'comment_user_id' => intval( $c->user_id ),
							'commentmeta' => $commentmeta,
						);
					}
				}
				
				$articles[] = $article_data;
			}
		}
		
		// write to file 
		$file_result = $this->add_data_to_file( $file_id, 'articles', $articles );
		
		return array();
	}
	
	// add categories data to file 
	public function add_categories ( $kb_id, $ids, $file_id ) {
		global $wpdb;
		$categories = array();
		
		$cats = get_terms( array (
			'taxonomy'      => EPIE_KB_Handler::get_category_taxonomy_name( $kb_id ),
			'hide_empty'    => false, 
			'include'          => $ids
		) );
		
		foreach ( $cats as $c ) {
			$category = array();
			
			$c_meta = array();
			$termmeta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->termmeta WHERE term_id = %d", $c->term_id ) );
			
			if ( $termmeta ) {
				foreach ( $termmeta as $meta ) {
					$c_meta[] = array(
						'meta_key' => $meta->meta_key,
						'meta_value' => $meta->meta_value,
					);
				}
			}
			
			$categories[] = array(
				'term_id' => $c->term_id,
				'category_nicename' => $c->slug,
				'category_parent' => $c->parent ? $c->parent : '',
				'cat_name' => $c->name,
				'category_description' => $c->description,
			);
		}
		
		// write to file 
		$file_result = $this->add_data_to_file( $file_id, 'categories', $categories );
		
		return array();
	}
	
	// add tags data to file 
	public function add_tags ( $kb_id, $ids, $file_id ) {
		global $wpdb;
		$tags = array();
		
		$tags = get_terms( array (
			'taxonomy'      => EPIE_KB_Handler::get_tag_taxonomy_name( $kb_id ),
			'hide_empty'    => false, 
			'include'          => $ids
		) );
		
		foreach ( $tags as $c ) {
			
			$c_meta = array();
			$termmeta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->termmeta WHERE term_id = %d", $c->term_id ) );
			
			if ( $termmeta ) {
				foreach ( $termmeta as $meta ) {
					$c_meta[] = array(
						'meta_key' => $meta->meta_key,
						'meta_value' => $meta->meta_value,
					);
				}
			}
			
			$tags[] = array(
				'term_id' => $c->term_id,
				'category_nicename' => $c->slug,
				'category_parent' => $c->parent ? $tags[ $c->parent ]->slug : '',
				'cat_name' => $c->name,
				'category_description' => $c->description,
			);
		}
		
		// write to file 
		$file_result = $this->add_data_to_file( $file_id, 'tags', $tags );
		
		// Test error: return array('error'=>'something wrong');
		return array();
	}
	
	public function add_sequence ( $kb_id, $ids, $file_id ) {
		$sequence = array();
		
		foreach ( $ids as $seq ) {
			$sequence[$seq] = get_option('epkb_' . $seq . '_sequence_' . $kb_id);
		}
		
		// write to file 
		$file_result = $this->add_data_to_file( $file_id, 'sequence', $sequence );
		
		// Test error: return array('error'=>'something wrong');
		return array();
	}

	// compile all export files to 1 json and return a link 
	public function get_export_file_link ( $file_id, $tag ) {
		
		$export_data = array();
		
		// add meta to data array 
		$export_data['meta'] = $this->get_data_from_file( $file_id, 'meta' );
		
		// clear duplicates and add articles, duplicates can appear if server will cut export process and js will send less number of ids per pack
		$articles = $this->get_data_from_file( $file_id, 'articles' );
		
		if ( $articles ) {
			$export_data['articles'] = array();
			$temp_arr = array();
			
			foreach ( $articles as $article ) {
				if ( ! in_array($article['post_id'], $temp_arr ) ) {
					$export_data['articles'][] = $article;
					$temp_arr[] = $article['post_id'];
				}
			}
		}
		
		// clear duplicates add categories 
		$categories = $this->get_data_from_file( $file_id, 'categories' );
		
		if ( $categories ) {
			$export_data['categories'] = array();
			$temp_arr = array();
			
			foreach ( $categories as $cat ) {
				if ( ! in_array($cat['term_id'], $temp_arr ) ) {
					$export_data['categories'][] = $cat;
					$temp_arr[] = $cat['term_id'];
				}
			}
		}
		
		// clear duplicates add tags 
		$tags = $this->get_data_from_file( $file_id, 'tags' );
		
		if ( $tags ) {
			$export_data['tags'] = array();
			$temp_arr = array();
			
			foreach ( $tags as $tag ) {
				if ( ! in_array($tag['term_id'], $temp_arr ) ) {
					$export_data['tags'][] = $tag;
					$temp_arr[] = $tag['term_id'];
				}
			}
		}
		
		// add sequence 
		$export_data['sequence'] = $this->get_data_from_file( $file_id, 'sequence' );
		
		// add config 
		$export_data['kb_config'] = $this->get_data_from_file( $file_id, 'kb_config' );
		
		// create file 
		$file_path = $this->get_path( $file_id, 'json', $tag );
		
		file_put_contents($file_path, json_encode($export_data));
		$this->clear_old_files();
		
		return array(
			'file' => $this->get_url( $file_id, 'json', $tag ),
			'export' => $export_data
		);
	}
	
	// clear files from the plugin's folder. $json says delete or not json files 
	public function clear_old_files ( $json = false, $file_id = 0 ) {
		// $file_id just in case for the future
		$path = Echo_KB_Import_Export::$plugin_dir . 'export_files/';
		if ( file_exists( $path ) && ! $json ) {
			foreach ( glob ( $path . '*.dat') as $file) {
				unlink($file);
			}
		} elseif ( file_exists( $path ) && $json ) {
			foreach ( glob ( $path . '*') as $file) {
				unlink($file);
			}
		}
		
		return true;
	}
	
	// get file path by id, tag and type 
	public function get_path ( $file_id, $type, $tag = '' ) {
		$path = Echo_KB_Import_Export::$plugin_dir . 'export_files/';
		
		if ($type == 'json') {
			$filename = 'kbexport_' . $tag . date('d_m_Y_H_i', $file_id) . '.json';
		} else {
			$filename = 'kbexport_' . $type . '_' . $file_id . '.dat';
		}
		
		// check folder 
		if (!file_exists($path)) mkdir($path, 0777);
		
		return $path . $filename;
	}
	
	// get file url by id, tag and type. Return false if file is not exist 
	public function get_url ( $file_id, $type, $tag = '' ) {
		
		if (!file_exists( $this->get_path( $file_id, $type, $tag ) )) {
			return false;
		}
		
		$path = Echo_KB_Import_Export::$plugin_url . 'export_files/';
		
		if ($type == 'json') {
			$filename = 'kbexport_' . $tag . date('d_m_Y_H_i', $file_id) . '.json';
		} else {
			$filename = 'kbexport_' . $type . '_' . $file_id . '.dat';
		}

		return $path . $filename;
		
	}

	// add new part of the data array to the DAT file, NOT for json 
	public function add_data_to_file ( $file_id, $type, $data ) {
		$file = $this->get_path ( $file_id, $type );
		return file_put_contents( $file, serialize($data) . $this->array_divider, FILE_APPEND | LOCK_EX );
	}
	
	// get data from DAT file - always array 
	public function get_data_from_file ( $file_id, $type ) {
		$result = array();
		$file = $this->get_path ( $file_id, $type );
		if ( file_exists($file) ) {
			$data = file_get_contents( $file );
			
			if ( $data ) {
				$data = explode ( $this->array_divider, $data );
				
				foreach ( $data as $str ) {
					if ($str) {
						$result = array_merge( $result, unserialize ( $str ) );
					}
				}
			}
		}
		return $result;
	}
}