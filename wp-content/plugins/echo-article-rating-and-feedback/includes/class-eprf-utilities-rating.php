<?php  

/**
 * Various utility functions only for EPRF plugin
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPRF_Utilities_Rating {

	/**
	 * Given all ratings for given article, calculate related statistics.
	 *
	 * @param $data
	 * @return array
	 */
	public static function calculate_article_rating_statistics( $data ) {
		
		$statistic = array(
			'rating-5' => 0,
			'rating-4' => 0,
			'rating-3' => 0,
			'rating-2' => 0,
			'rating-1' => 0,
			'like'     => 0,
			'dislike'  => 0,
		);
		
		$rates_total = 0;
		
		foreach ( $data as $item ) {
			$rates_total += $item->rating_value;

			$ix = floor($item->rating_value);
			
			if ($ix == 0) {
				$ix = 1;
			}
			
			if ( ! isset($statistic['rating-' . $ix]) ) {
				continue;
			}

			$statistic['rating-' . $ix]++;
			
			if ( $item->rating_value < 3 ) {
				$statistic['dislike']++;
			}
			
			if ( $item->rating_value > 3 ) {
				$statistic['like']++;
			}
			
			if ( $item->rating_value == 3 ) {
				// we do not count this right now: $statistic['dislike']++;
				$statistic['like']++;
			}
			
		}
		
		$average = empty($data) ? 0 : round($rates_total / count($data), 1);

		$result = array(
						'total' => $rates_total,
						'average' => $average,
						'count' => count($data),
						'statistic' => $statistic
					);
					
		return $result;
	}

	/**
	 * Calculate article popularity based on the following formulate:
	 *          rating (WR) = (v / (v+m)) x R + (m / (v+m)) x C
	 *
	 * @param $kb_id
	 * @param $article_id
	 *
	 * @return float|WP_Error
	 */
	public static function calculate_article_popularity( $kb_id, $article_id ) {

		// average rating of the article
		$R = EPRF_Utilities::get_postmeta($article_id, 'eprf-article-rating-average', 0, false, true );
		if ( is_wp_error($R) ) {
			return $R;
		}

		// number of votes for the article
		$db = new EPRF_Rating_DB();
		$v = $db->get_count_rows_range( $kb_id, 'post_id', $article_id, $article_id );   // TODO need dates?
		
		// get list of the article_ids of all articles
		$article_ids = get_posts( array(
			'post_type' => EPRF_KB_Handler::get_post_type( $kb_id ),
			'numberposts ' => -1,
			'fields' => 'article_ids',
			'no_found_rows' => true
		) );

		$options = EPRF_Utilities::get_postmeta_multiple( $article_ids, 'eprf-article-rating-average', array() );

		$meta = array();
		foreach ( $options as $option ) {
			$meta[] = (float)$option->meta_value;
		}
		
		// average of all article averages
		$m = 1;     // TODO: parameter to tune
		$C = array_sum( $meta ) / count( $article_ids );
		$average = ($v / ( $v + $m ) ) * $R + ( $m / ( $v + $m ) ) * $C;

		return $average;
	}

	/**
	 * Retrieve user IP address if possible.
	 *
	 * @return string
	 */
	public static function get_ip_address() {

		$ip_params = array( 'HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' );
		foreach ( $ip_params as $ip_param ) {
			if ( ! empty($_SERVER[$ip_param]) ) {
				foreach ( explode( ',', $_SERVER[$ip_param] ) as $ip ) {
					$ip = trim( $ip );

					// validate IP address
					if ( filter_var( $ip, FILTER_VALIDATE_IP ) !== false ) {
						return esc_attr( $ip );
					}
				}
			}
		}

		return '';
	}
}
