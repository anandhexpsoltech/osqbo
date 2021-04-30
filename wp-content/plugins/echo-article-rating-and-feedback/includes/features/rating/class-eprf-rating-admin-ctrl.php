<?php  // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Process back-end hooks.
 */
class EPRF_Rating_Admin_Cntrl {

    public function __construct() {
       add_action( 'delete_post', array($this, 'before_delete_article') );
    }
	
	// delete article statistics 
	public function before_delete_article( $article_id ) {

		$article = EPRF_Utilities::get_kb_post_secure( $article_id );
		if ( empty($article) ) {
			return;
		}

		$kb_id = EPRF_Utilities::get_kb_id( $article );
		if ( empty($kb_id) ) {
			return;
		}

		$db_handler = new EPRF_Rating_DB();
		$db_handler->delete_article_rating( $kb_id, $article_id, false );
	}
}