<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display search analytics
 *
 */
class ASEA_Analytics_View {

    public function __construct() {

	    add_action( 'eckb_analytics_navigation_bar', array( $this, 'display_navigation_button' ) );
	    add_action( 'eckb_analytics_content', array( $this, 'add_analytics_content' ) );
	    add_action( 'eckb_add_container_classes', array( $this, 'add_top_container_class' ) );

	    // TODO add_action( 'wp_ajax_asea_handle_search_analytics', array( $this, 'handle_search_analytics' ) );
	    // TODO add_action( 'wp_ajax_nopriv_asea_handle_search_analytics', array( $this, 'user_not_logged_in' ) );
    }

	/**
	 * Add SEARCH DATA button to end of Top navigation
	 */
	public function display_navigation_button() {           ?>
		<!--  SEARCH PAGE BUTTON -->
		<div class="eckb-nav-section">
			<div class="page-icon-container">
				<p><?php _e( 'Search Data', 'echo-advanced-search' ); ?></p>
				<div class="page-icon epkbfa epkbfa-search" id="asea-search-data"></div>
			</div>
		</div>	<?php
	}

	/**
	 * Called by KB Core to display Advanced Search analytics content.
	 * @param $kb_id
	 */
	public function add_analytics_content( $kb_id ) {

		// POPULAR SEARCHES

		$db_handler = new ASEA_Search_DB();
		$most_popular_list = $db_handler->get_most_popular_searches( $kb_id, '2000-01-01 00:00:00', '2100-01-01 00:00:00', 100 );
		if ( $most_popular_list === null ) {
			echo "Error (12)";
			return;
		}

		$most_popular_searches = array();
		foreach( $most_popular_list as $most_popular_search ) {
			$search_formatted = $this->bold_used_search_keywords( $most_popular_search->user_input, $most_popular_search->search_keywords );
			$most_popular_searches[] = array( $search_formatted, $most_popular_search->times );
		}


		// NO RESULTS SEARCHES

		$no_results_list= $db_handler->get_no_results_searches( $kb_id, '2000-01-01 00:00:00', '2100-01-01 00:00:00', 100 );
		if ( $no_results_list === null ) {
			echo "Error (12)";
			return;
		}

		$no_results_searches = array();
		foreach( $no_results_list as $no_results_search ) {
			$search_formatted = $this->bold_used_search_keywords( $no_results_search->user_input, $no_results_search->search_keywords );
			$no_results_searches[] = array( $search_formatted, $no_results_search->times );
		}


		// TOTAL SEARCH COUNT
		$total_search_count = $db_handler->get_search_count( $kb_id, '2000-01-01 00:00:00', '2100-01-01 00:00:00' );
		$stats_data['total_searches'] = array( 'Total Searches', $total_search_count );

		// TOTAL NO RESULTS SEARCH COUNT
		$total_search_count = $db_handler->get_no_result_search_count( $kb_id, '2000-01-01 00:00:00', '2100-01-01 00:00:00' );
		$stats_data['total_no_results_searches'] = array( 'Total No Results Searches', $total_search_count );

		?>

		<div class="eckb-config-content" id="asea-search-data-content">

			<!-- ROW 1 --------------------------------------------------->
			<div class="eckb-row-4-col">
				<?php // TODO $this->display_search_date_range(); ?>
			</div>


			<!-- ROW 2 --------------------------------------------------->
			<div class="eckb-row-2-col">
				<?php $this->pie_chart_search_data_box( 'Popular Searches', $most_popular_searches, 'asea-popular-searches-data', 'No searches were recorded.' ); ?>
				<?php $this->pie_chart_search_data_box( 'No Results Searches', $no_results_searches, 'asea-no-result-popular-searches-data', 'No empty searches found.' ); ?>
			</div>

			<!-- ROW 3 --------------------------------------------------->
			<div class="eckb-row-3-col">
				<?php $this->statistics_data_box( 'Overall Statistics', $stats_data, 'statistics-searches-data' ); ?>
			</div>

			<!-- ROW 4 --------------------------------------------------->
			<div class="eckb-row-3-col">
				<?php $this->display_search_reset_button( $kb_id ); ?>
			</div>

		</div>    <?php
	}

	/**
	 * Displays a Pie Chart Box with a list on the left and a pie chart on the right.
	 * The Chart is created using Chart.js and called in from our admin-plugins.js file then targets the container ID.
	 *
	 * @param  string $title Top Title of the container box.
	 * @param  array $data Multi-dimensional array containing a list of Words and their counts.
	 * @param  string $id The id of the container and chart id. JS is used to target it to create the chart.
	 * @param string $empty_message
	 */
	private function pie_chart_search_data_box( $title, $data, $id, $empty_message='' ) {   ?>

		<section class="asea-pie-chart-container" id="<?php echo $id; ?>">
			<!-- Header ------------------->
			<div class="asea-pie-chart-header">
				<h4><?php echo $title; ?></h4>
				<i class="asea-pie-chart-cog epkbfa epkbfa-cog" aria-hidden="true"></i>
			</div>

			<!-- Body ------------------->
			<div class="asea-pie-chart-body">
				<div class="asea-pie-chart-left-col">
					<ul class="asea-pie-data-list">			<?php
						if ( empty($data) ) {
							echo $empty_message;
						} else {
							$i = 1;
							foreach ( $data as $word ) {    ?>
								<li class="<?php echo $i++ <= 10 ? 'asea-first-10' : 'asea-after-10'; ?>">
									<span class="asea-circle epkbfa epkbfa-circle"></span>
									<span class="asea-pie-chart-word"><?php echo stripslashes($word[0]); ?></span>
									<span class="asea-pie-chart-count"><?php echo esc_html($word[1]); ?></span>
								</li>                <?php
							}
						}       ?>
					</ul>
					<!--<div id="chart-legends"></div>-->
				</div>
				<div class="asea-pie-chart-right-col">

					<div id="asea-pie-chart" style="height: 225px">
						<canvas id="<?php echo $id; ?>-chart"></canvas>
					</div>

				</div>
			</div>
		</section>	<?php
	}

	/**
	 * Displays overall statistics in numbers.
	 *
	 * @param  string   $title  Top Title of the container box.
	 * @param  array    $stats_data   Multi-dimensional array containing a list of Words and their counts.
	 * @param  string   $id     The id of the container.
	 */
	private function statistics_data_box( $title, $stats_data, $id ) {      ?>
		<section class="asea-statistics-container" id="<?php echo $id; ?>">
			<!-- Header ------------------->
			<div class="asea-statistics-header">
				<h4><?php echo $title; ?></h4>
				<i class="asea-statistics-cog epkbfa epkbfa-cog" aria-hidden="true"></i>
			</div>
			<!-- Body ------------------->
			<div class="asea-statistics-body">

				<ul class="asea-statistics-list">	<?php
					foreach( $stats_data as $type => $data ) {     ?>
						<li>
							<span class="asea-statistics-word"><?php echo $data[0]; ?></span>
							<span class="asea-statistics-count"><?php echo $data[1]; ?></span>
						</li>					<?php
					}   ?>
				</ul>
			</div>
		</section>	<?php
	}

	private function display_search_date_range() {  ?>
		<div id="reportrange">
            <i class="epkbfa epkbfa-calendar"></i>&nbsp;<span></span><i class="epkbfa epkbfa-caret-down"></i>
		</div>  <?php
	}

	private function bold_used_search_keywords( $user_input, $search_keywords ) {

		if ( empty($user_input) || empty($search_keywords) ) {
			return 'error';
		}

		$words = explode(' ', $user_input);
		$search_keywords = explode(' ', $search_keywords);
		$output = '';
		$first_word = true;
		foreach( $words as $word ) {
			$output .= ($first_word ? '' : ' ') . ( in_array($word, $search_keywords) ? '<strong>' . esc_html($word) . '</strong>' : esc_html($word) );
			$first_word = false;
		}

		return $output;
	}

	/**
	 * Show a button which will delete all search analytics
	 * @param $kb_id
	 */
	private function display_search_reset_button( $kb_id ) { ?>
		<section class="asea-reset-container">

			<div id="asea-reset-analytics-button" class="asea-reset-body">
				<input type="hidden" id="_wpnonce_asea_search_analytics" name="_wpnonce_asea_search_analytics" value="<?php echo wp_create_nonce( "_wpnonce_asea_search_analytics" ); ?>"/>
				<input type="hidden" id="asea_reset_analytics_kb_id" name="asea_reset_analytics_kb_id" value="<?php echo $kb_id; ?>"/>
				<a href="" class="asea-reset-analytics">
					<?php _e('Delete Search Analytics', 'echo-advanced-search' ); ?>
					<span class="epkbfa epkbfa-undo" aria-hidden="true"></span>
				</a>
			</div>  <?php

			// Confirm Deletion of Search Data Dialog Box.
			ASEA_Utilities::dialog_box_form( array(
				'id'            => 'asea-reset-search-data',
				'title'         => 'Delete Search Data',
				'body'          => 'Are you sure you want to delete all search data? Backup your database if in doubt.',
				'accept_label'  => 'Delete Data',
				'accept_type'   => 'error',
			) );			?>

		</section> <?php
	}

	/**
	 * TODO: SEARCH DATA TABLE =====================================================================================
	 */

	// FUTURE TODO
	/**
	 * AJAX: Return search report based on entered dates.
	 */
	public function handle_search_analytics() {

		// verify that request is authentic
		if ( empty( $_REQUEST['_wpnonce_asea_search_analytics'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_asea_search_analytics'], '_wpnonce_asea_search_analytics' ) ) {
			ASEA_Utilities::ajax_show_error_die( __( 'First refresh your page', 'echo-advanced-search' ) );
		}

		// ensure user has correct permissions
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			ASEA_Utilities::ajax_show_error_die( __( 'You do not have permission to edit this knowledge base', 'echo-advanced-search' ) );
		}

		$kb_id = ASEA_Utilities::post( 'kb_id', ASEA_KB_Config_DB::DEFAULT_KB_ID );
		$start_date = ASEA_Utilities::post('start_date', date_i18n('Y-m-d'));
		$end_date = ASEA_Utilities::post( 'end_date', date_i18n('Y-m-d') );
		$filtered_search_data = $this->display_search_results_table( $kb_id, $start_date, $end_date );

		wp_die( json_encode( array( 'output' => $filtered_search_data, $type='success') ) );
	}

	public function user_not_logged_in() {
		ASEA_Utilities::ajax_show_error_die( '<p>' . __( 'You are not logged in. Refresh your page and log in', 'echo-advanced-search' ) . '.</p>', __( 'Cannot save your changes', 'echo-advanced-search' ) );
	}

	/**
	 * Adds asea-analytics-container string to top of Analytics page.
	 *
	 * Description: So that we can keep the prefix separate in CSS. This allows Dave to use ASEA only
	 * for the top container without affecting core.
	 *
	 */
	public function add_top_container_class(){
		echo 'asea-analytics-container';
	}

	/**
	 * Display analytics for searches.
	 * @param $kb_id
	 */
	private function display_search_analytics( $kb_id ) {

		$this->display_search_date_range();

		//echo $this->display_search_results_table( $kb_id, '9999-01-01', '9999-01-01' );

		echo '<input type="hidden" id="_wpnonce_asea_search_analytics" name="_wpnonce_asea_search_analytics" value="' . wp_create_nonce( "_wpnonce_asea_search_analytics" ) . '"/>';

		$analytics_start_date = ASEA_Utilities::get_wp_option( 'asea_analytics_start_date', 'unknown' );
		echo 'Search analytics recorded since ' . $analytics_start_date . "<br/>";
		echo 'Current storage limit: up to ' . ASEA_Search_Logging::MAX_NOF_LOGS_STORED . ' search records stored.' . "<br/>";
		echo 'Current search drop-down limit: up to ' . ASEA_Search_Box_cntrl::get_search_results_list_size( $kb_id ) . ' search records shown.' . "<br/>";
	}

	private function display_search_results_table( $kb_id, $from_date, $to_date ) {

		$search_data = self::get_data_range( $kb_id, $from_date, $to_date );

		$output = '
			<table id="asea_datatable" class="display" style="width:100%;">
		        <thead>
		            <tr>
		                <th>Date</th>
		                <th>Search Text</th>
		                <th>Number of Articles Found</th>
		                <th>Articles Found</th>
		            </tr>
		        </thead>
				<tbody>';

		$kb_config = ASEA_KB_Core::get_kb_config( $kb_id );
		if ( is_wp_error($kb_config) ) {
			$output .= 'error occurred (432)';
			return $output;
		}

		$main_page_url = ASEA_KB_Handler::get_first_kb_main_page_url( $kb_config );
		foreach( $search_data as $search_attempt ) {
			$search_date = empty($search_attempt['date'] ) ? 'N/A' : $search_attempt['date'];
			$user_input = empty($search_attempt['user_input']) ? '<unknown>' : stripslashes($search_attempt['user_input']);
			$filtered_user_input = ASEA_Search_Box_DB::filter_user_input( $user_input);
			$results_count = empty($search_attempt['count']) ? 'N/A' : $search_attempt['count'];

			$output .= '
				<tr>
	                <td>' . $search_date . '</td>
	                <td>' . $user_input . '</td>
	                <td>' . $results_count . '</td>
	                <td><a href="' .  esc_url( $main_page_url . '?' . _x('kb-search', 'used when searching', 'echo-advanced-search') . '=' . urlencode($filtered_user_input) ) . '" target="_blank">Search Results</a></td>
	            </tr>';
		}

		$output .= '</tbody>
		    </table>';

		return $output;
	}

	/**
	 * Get data from given range.
	 *
	 * @param $kb_id
	 * @param $start_date
	 * @param $end_date
	 *
	 * @return array
	 */
	private static function get_data_range( $kb_id, $start_date, $end_date) {

		$search_data = array(); // TODO ASEA_Search_Box_DB::get_logs( $kb_id );
		$filtered_search_data = array();
		foreach( $search_data as $search_attempt ) {
			$attempt_date = ASEA_Utilities::get_formatted_datetime_string($search_attempt['date'], 'Y-m-d');

			if ( $attempt_date >= $start_date && $attempt_date <= $end_date ) {
				$filtered_search_data[] = $search_attempt;
			}
		}

		return $filtered_search_data;
	}

}