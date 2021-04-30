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
		//add_action( 'wp_ajax_epie_make_step', array( $this, 'make_step' ) );
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

		$data = array();
		$exported_articles = array();
		// add articles
		$articles = get_posts(array(
			'post_type' => EPIE_KB_Handler::get_post_type( $post_data['kb_id'] ),
			'numberposts' => '-1',
		));


		foreach ($articles as $article) {
			$categories = get_the_terms( $article->ID, EPIE_KB_Handler::get_category_taxonomy_name( $post_data['kb_id'] ) );
			$cats = array();
			if (!empty($categories)) {
				foreach ($categories as $category) {
					$cats[] = $category->name;
				}
			}

			$post_tags = get_the_terms( $article->ID, EPIE_KB_Handler::get_tag_taxonomy_name( $post_data['kb_id'] ) );
			$tags = array();
			if (!empty($post_tags)) {
				foreach ($post_tags as $tag) {
					$tags[] = $tag->name;
				}
			}
			$data['title'] = get_the_title($article->ID);
			$data['content'] = apply_filters('the_content', get_post_field('post_content', $article->ID));
			$data['category'] = $cats;
			$data['tags'] = $tags;
			$exported_articles[$article->ID] = $data;
		}

		$file_id = time();
		$this->add_data_to_file( $file_id, $exported_articles );

		$response = array(
			'success' => __( 'Export Done...', 'echo-knowledge-base' ),
			'file' => $this->get_url ( $file_id ),
		);
		wp_die( json_encode( array_merge( $default, $response ) ) );
	}
	

	// get file path by id
	public function get_path ( $file_id ) {
		$path = Echo_KB_Import_Export::$plugin_dir . 'export_files/';
		$filename = 'kbexport_articles_' . $file_id . '.csv';
		// check folder 
		if (!file_exists($path)) mkdir($path, 0777);
		return $path . $filename;
	}
	
	// get file url by id. Return false if file is not exist
	public function get_url ( $file_id ) {
		
		if (!file_exists( $this->get_path( $file_id ) )) {
			return false;
		}
		$path = Echo_KB_Import_Export::$plugin_url . 'export_files/';
		$filename = 'kbexport_articles_' . $file_id . '.csv';
		return $path . $filename;
	}

	// add new part of the data array to the DAT file, NOT for json 
	public function add_data_to_file ( $file_id, $exported_data )
	{
		$file = $this->get_path($file_id);
		$fp = fopen($file, 'w');
		fputcsv($fp, array('Title', 'Content', 'Categories', 'Tags'));
		foreach ($exported_data as $data) {
			fputcsv($fp, array($data['title'], $data['content'], implode(",", $data['category']), implode(",", $data['tags'])));
		}
		fclose($fp);

	}
	

}