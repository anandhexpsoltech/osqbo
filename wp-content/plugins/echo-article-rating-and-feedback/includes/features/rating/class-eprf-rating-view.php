<?php

/**
 * Display the rating element on the front-end.
 */
class EPRF_Rating_View {

	private static $js_vars_declared = false;

	public function __construct() {
		add_filter( 'eckb-article-meta-container-end-on', array( $this, 'is_show_meta_ratings_on' ), 99 );
		add_action( 'eckb-article-meta-container-end', array( $this, 'show_meta_ratings' ), 99 );

		add_action( 'eckb-article-content-footer', array( $this, 'maybe_show_footer_buttons' ), 99 );
		add_action( 'eckb-article-content-header', array( $this, 'maybe_show_header_buttons' ), 99 );
	}

	/*************************************************************************************
	 *                             META ELEMENTS
	 *************************************************************************************/

	/**
	 * Should the meta data be outputed for given header/footer combination?
	 * @param $data
	 * @return bool
	 */
	public function is_show_meta_ratings_on( $data ) {

		$kb_id          = empty($data['id']) ? EPRF_KB_Config_DB::DEFAULT_KB_ID : $data['id'];
		$kb_config      = empty($data['config']) ? array() : $data['config'];
		$add_on_config  = eprf_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
		$add_on_config  = array_merge($add_on_config, $kb_config);

		$is_on = ! empty($data['output_location']) && $data['output_location'] == $add_on_config['rating_stats_meta'];

		$data['is_meta_container_on'] = ! empty($data['is_meta_container_on']) || $is_on;

		return $data;
	}

	/**
	 * Show only basic statistics for star rating meta
	 * @param $data
	 */
	public function show_meta_ratings( $data ) {

		if ( ( empty($data['article']->ID) && ! isset($data['article']->is_demo) ) || empty($data['config']) ||  is_search() ) {
			return;
		}

		// Get KB and Article Data.
		$kb_id          = empty($data['id']) ? EPRF_KB_Config_DB::DEFAULT_KB_ID : $data['id'];
		$kb_config      = $data['config'];

		$article_id = empty($data['article']->ID) ? 0 : $data['article']->ID;
		$db_handler     = new EPRF_Rating_DB();
		$rating_data = $db_handler->get_article_ratings( $kb_id, $article_id );
        if ( is_wp_error($rating_data) ) {
            return;
        }

		$rating         = EPRF_Utilities_Rating::calculate_article_rating_statistics( $rating_data );
		$add_on_config  = eprf_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
		$add_on_config  = array_merge($add_on_config, $kb_config);

		// should we display the rating stats
		if ( empty($data['output_location']) || $data['output_location'] != $add_on_config['rating_stats_meta'] ) {
			return;
		}

		// Choose Rating mode based on settings. These will output the ratings without the form and click functionality.
		switch ( $add_on_config['rating_mode'] ) {
			case 'eprf-rating-mode-five-stars':
				$this->show_meta_star_rating( $add_on_config, $rating );
				break;
			case 'eprf-rating-mode-like-dislike':
				$this->show_meta_like_dislike( $add_on_config, $rating );
				break;
		}
	}

	/**
	 * Show meta information about article rating
	 * @param $add_on_config
	 * @param $rating
	 */
	function show_meta_star_rating( $add_on_config, $rating ) {

		$color          = 'color:' . $add_on_config['rating_element_color'];
		$inline_style   = 'style="' . $color . '"';		?>

		<div class="eprf-article-meta__star-rating" <?php echo $inline_style; ?>>
			<div class="eprf-article-meta__star-rating__stars"> <?php
				$i = 0;
				while ( $i < 5 ) {
					if ( $rating['average'] >= $i + 1 ) {
						$class = 'epkbfa-star';
					} elseif ( $rating['average'] >= $i + 0.5 ) {
						$class = 'epkbfa-star-half-o';
					} else {
						$class = 'epkbfa-star-o';
					}							?>
				<span class="epkbfa <?php echo $class; ?>" aria-hidden="true"></span><?php
					$i ++;
				}				?>
			</div>

			<div class="eprf-article-meta__star-rating__stars-stats">
				<i class="epkbfa epkbfa-chevron-down eprf-article-meta__statistics-toggle" style="color: <?php echo $add_on_config['rating_dropdown_color']; ?>"></i>
				<div class="eprf-article-meta__statistics">
					<h6><?php echo sprintf(__('%s out of 5 stars', 'echo-article-rating-and-feedback'), $rating['average']); ?></h6>
					<table>	<?php

						$i = 6;
						foreach ( $rating['statistic'] as $key => $value ) {
							if ( $key == 'like' || $key == 'dislike' ) {
								continue;
							}
							$i--;
							if ( isset($add_on_config['rating_stars_text_' . $i]) ) {								 ?>
								<tr>
									<td title="<?php echo $add_on_config['rating_stars_text_' . $i]; ?>"><?php echo $i . ' ' . __('Stars', 'echo-article-rating-and-feedback'); ?></td>
									<td>										<?php
										$percents = ! empty($rating['count']) ? 100 * ( $value / $rating['count'] ) : 0;
										$percents = round($percents, 0); 										?>
										<span class="eprf-stars-module__statistics__stat-wrap"><span class="eprf-stars-module__statistics__stat-wrap__stat-inside" style="width: <?php echo $percents; ?>%; background-color: <?php echo $add_on_config['rating_element_color']; ?>;"></span></span>
									</td>
									<td><?php echo $percents; ?>%</td>
								</tr> <?php
							}
						}       ?>
					</table>
				</div>
			</div>
		</div>      <?php
	}

	/**
	 * Show only basic statistics for like/dislike meta
	 * @param $add_on_config
	 * @param $rating
	 */
	private function show_meta_like_dislike( $add_on_config, $rating ) {

		//This sets the layout where the text is located and if the statisitics are visible.
		$layout = '';
		switch ( $add_on_config['rating_layout'] ) {
			case 'rating_layout_1':
				$layout = 'eprf-like-dislike-module--layout-1';
				break;
			case 'rating_layout_2':
				$layout = 'eprf-like-dislike-module--layout-2';
				break;
		}

		//This sets the icon types.
		$ratingStyle          = '';
		$like_Icon_Type       = '';
		$dislike_Icon_Type    = '';
		$like_text            = '';
		$dislike_text         = '';
		$like_Button_Style    = '';
		$dislike_Button_Style = '';

		switch ( $add_on_config['rating_like_style'] ) {

			// Thumbs Up / Down
			case 'rating_like_style_1':
				$like_Icon_Type    = ' epkbfa-thumbs-up';
				$dislike_Icon_Type = ' epkbfa-thumbs-down';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-1';
				break;
			// Check and Times
			case 'rating_like_style_2':
				$like_Icon_Type    = ' epkbfa-check';
				$dislike_Icon_Type = ' epkbfa-times';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-2';
				break;
			// Arrow Up / Down
			case 'rating_like_style_3':
				$like_Icon_Type    = ' epkbfa-caret-up';
				$dislike_Icon_Type = ' epkbfa-caret-down';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-3';
				break;
			case 'rating_like_style_4':
				$like_Icon_Type    = ' eprf-text';
				$dislike_Icon_Type = ' eprf-text';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-4';
				$like_text         = $add_on_config['rating_like_style_yes_button'];;
				$dislike_text         = $add_on_config['rating_like_style_no_button'];
				$like_Button_Style    = 'style="border-color: ' . $add_on_config['rating_like_color'] . '; color: ' . $add_on_config['rating_like_color'] . ';"';
				$dislike_Button_Style = 'style="border-color: ' . $add_on_config['rating_dislike_color'] . '; color: ' . $add_on_config['rating_dislike_color'] . ';"';
				break;
		}

		$like_stats    = '<span class="eprf-like-count">' . $rating['statistic']['like'] . '</span>';
		$dislike_stats = '<span class="eprf-dislike-count">' . $rating['statistic']['dislike'] . '</span>';		?>

		<div class="eprf-article-meta__like-dislike-rating <?php echo $layout; ?> ">

			<div class="eprf-like-dislike-module__buttons <?php echo $ratingStyle; ?>">

				<span <?php echo $like_Button_Style; ?> class="eprf-rate-like">
					<span class="epkbfa <?php echo $like_Icon_Type; ?>" aria-hidden="true"
					      style="color: <?php echo $add_on_config['rating_like_color']; ?>;"><?php echo $like_text; ?></span>
					<?php echo $like_stats; ?>
				</span>

				<span <?php echo $dislike_Button_Style; ?> class="eprf-rate-dislike">
					<span class="epkbfa <?php echo $dislike_Icon_Type; ?>" aria-hidden="true"
					      style="color: <?php echo $add_on_config['rating_dislike_color']; ?>;"><?php echo $dislike_text; ?></span>
					<?php echo $dislike_stats; ?>
				</span>

			</div>
		</div>    <?php
	}

	/*************************************************************************************
	 *
	 *                             RATING ELEMENTS
	 *
	 *************************************************************************************/

	public function maybe_show_header_buttons( $data ) {
		$this->show_rating_and_form( $data, true );
	}

	public function maybe_show_footer_buttons( $data ) {
		$this->show_rating_and_form( $data, false );
	}

	/**
	 * Show the rating element and feedback form.
	 * @param $data
	 * @param bool|false $isTopHook
	 */
	private function show_rating_and_form( $data, $isTopHook=false ) {

		if ( ( empty($data['article']->ID) && ! isset($data['article']->is_demo) ) || empty($data['config']) ||  is_search() ) {
			return;
		}

		$kb_id = empty($data['id']) ? EPRF_KB_Config_DB::DEFAULT_KB_ID : $data['id'];
		$kb_config = $data['config'];
		$article_id = empty($data['article']->ID) ? 0 : $data['article']->ID;;

		$add_on_config = eprf_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
		$add_on_config = array_merge($add_on_config, $kb_config);

		$isConfiguredTop = empty($add_on_config['rating_element_location']) || ( $add_on_config['rating_element_location'] == 'rating-above-article' );

		// display rating element in the right location
		if ( ( $isTopHook && $isConfiguredTop ) || ( ! $isTopHook && ! $isConfiguredTop ) ) {  // show only once - top or bottom of the page

			// declare JS variables if necessary
			if ( ! self::$js_vars_declared ) {
				self::$js_vars_declared = true; ?>
				<script>
					let eprf_rating_nonce = '<?php echo wp_create_nonce('_wpnonce_user_rating_action_ajax'); ?>';
					let kb_id = <?php echo $kb_id; ?>;
				</script>            <?php
			}

			// based on whether user voted or not we display info
			$db_handler = new EPRF_Rating_DB();
			$did_vote = $db_handler->has_article_user_IP($kb_id, $article_id);
			if ( is_wp_error($did_vote) ) {
				return;
			}

			$did_vote = isset($data['article']->is_demo) ? false : $did_vote;
			$this->show_rating_element($kb_id,  $add_on_config, $article_id, $did_vote );

			// show feedback form if user did not submit feedback yet
			if ( ! $did_vote ) {
				$this->show_feedback_form( $add_on_config );
			}
		}
	}

	/**
	 * Show article buttons on the article footer/header
	 *
	 * @param $kb_id
	 * @param $kb_config
	 * @param $article_id
	 * @param $did_vote
	 */
	public function show_rating_element( $kb_id, $kb_config, $article_id, $did_vote ) {

		if ( empty($kb_config['rating_mode']) ) {
			EPRF_Logging::add_log("Missing add-on config.", $kb_id);
			return;
		}

		// get article rating
		$db_handler = new EPRF_Rating_DB();
		$rating_data = $db_handler->get_article_ratings( $kb_id, $article_id );
		if ( is_wp_error($rating_data) ) {
			return;
		}           		?>

		<section id="eprf-article-buttons-container" class="<?php echo $kb_config['rating_mode']; ?> eprf-afc--reset">			<?php

    		$rating = EPRF_Utilities_Rating::calculate_article_rating_statistics( $rating_data );

			switch ( $kb_config['rating_mode'] ) {
				case 'eprf-rating-mode-five-stars':
					$this->show_rating_stars( $kb_config, $rating, $did_vote, $article_id );
					break;

				case 'eprf-rating-mode-like-dislike':
					$this->show_like_dislike( $kb_config, $rating, $did_vote );
					break;
			}			?>

			<div id="eprf-current-rating" class="eprf-article-buttons__feedback-confirmation" data-loading="<?php _e('Loading...', 'echo-article-rating-and-feedback'); ?>" style="
				color: <?php echo $kb_config['rating_text_color']; ?>;
				font-size: <?php echo $kb_config['rating_text_font_size']; ?>px;
			">
			</div>
		</section>         <?php 
	}

	/**
	 * Show article feedback form
	 *
	 * @param $kb_config
	 */
	private function show_feedback_form( $kb_config ) {     ?>

		<script>
			let eprf_feedback_nonce = '<?php echo wp_create_nonce('_wpnonce_user_comment_action_ajax'); ?>';
		</script>
		<?php 
			$trigger_name = ( 'eprf-rating-mode-like-dislike' == $kb_config['rating_mode'] ) ? $kb_config['rating_feedback_trigger_like'] : $kb_config['rating_feedback_trigger_stars'];
			$trigger_name = str_replace('_', '-', $trigger_name);
		?>
		<section id="eprf-article-feedback-container" class="eprf-afc--reset eprf-article-feedback-container--trigger-<?php echo $trigger_name; ?>" style="
				color: <?php echo $kb_config['rating_text_color']; ?>;
				font-size: <?php echo $kb_config['rating_text_font_size']; ?>px;
			">
			<form class="eprf-leave-feedback-form">			<?php

				if ( ! empty($kb_config['rating_feedback_title']) ) { ?>
					<div class="eprf-article-feedback__title eprf-form-row">
						<h5><?php echo $kb_config['rating_feedback_title']; ?></h5>
					</div>				<?php
				}

				if ( 'on' == $kb_config['rating_feedback_name_prompt'] ) { ?>
					<div class="eprf-article-feedback__name eprf-form-row">
						<label for="eprf-form-name"><?php _e('Name', 'echo-article-rating-and-feedback'); ?></label>
						<input placeholder="Name" type="text" id="eprf-form-name" name="eprf-form-name" required>
					</div>				<?php
				}

				if ( 'on' == $kb_config['rating_feedback_email_prompt'] ) { ?>
					<div class="eprf-article-feedback__email eprf-form-row">
						<label for="eprf-form-email"><?php _e('Email', 'echo-article-rating-and-feedback'); ?></label>
						<input placeholder="Email" type="email" id="eprf-form-email" name="eprf-form-email">
					</div>				<?php
				}   ?>

				<div class="eprf-article-feedback__text eprf-form-row">
					<textarea id="eprf-form-text" name="eprf-form-text" placeholder="<?php echo $kb_config['rating_feedback_description']; ?>" required></textarea>
				</div>

				<div class="eprf-article-feedback__footer">					<?php
					if ( ! empty($kb_config['rating_feedback_support_link_text']) && ! empty($kb_config['rating_feedback_support_link_url']) ) { ?>
						<div class="eprf-article-feedback__support-link eprf-form-row">
							<a href="<?php echo $kb_config['rating_feedback_support_link_url']; ?>" target="_blank"><?php echo $kb_config['rating_feedback_support_link_text']; ?></a>
						</div>				<?php
					}   ?>
					<div class="eprf-article-feedback__submit">
						<button type="submit" style="background-color: <?php echo $kb_config['rating_feedback_button_color']; ?>;" data-submit_text="<?php echo $kb_config['rating_feedback_button_text']; ?>">
							<?php echo $kb_config['rating_feedback_button_text']; ?>
						</button>
					</div>
				</div>

			</form>
		</section>         <?php
	}

	 /**
	 * Show Rating Stars module
	 *
	 * @param $add_on_config - current kb_config
	 * @param $rating
	 * @param $did_user_vote
	 * @param $article_id
	 */
	private function show_rating_stars( $add_on_config, $rating, $did_user_vote, $article_id ) {
		global $pagenow;

		$layout = '';
		switch ( $add_on_config['rating_layout'] ) {
			case 'rating_layout_1':
				$layout = 'eprf-stars-module--layout-1';
				break;
			case 'rating_layout_2':
				$layout = 'eprf-stars-module--layout-2';
				break;
		}

        // show rating text intro show ? do not show if user already voted
		$rating_text = $did_user_vote ? '' : $add_on_config['rating_text_value'];

		// check if article was rated at all and do not show rating if it was not; not if demo article
		$show_stars = true;
		if ( is_admin() && ! empty($article_id) ) {
			$average_rating = EPRF_Utilities::get_postmeta($article_id, 'eprf-article-rating-average', null, false, true );
			if ( is_wp_error($average_rating) || ( $average_rating === null & is_admin() ) ) {
				$show_stars = false;
			}
		}		?>
		
		<div class="eprf-stars-module <?php echo $layout; ?> <?php echo $did_user_vote ? 'eprf-rating--blocked' : ''; ?>">

			<div class="eprf-stars-module__text" style="
				color: <?php echo $add_on_config['rating_text_color']; ?>;
				font-size: <?php echo $add_on_config['rating_text_font_size']; ?>px;
				">
				<?php echo $pagenow == 'post-new.php' || ( $pagenow == 'edit.php' && isset($_GET['page']) && $_GET['page'] !== 'epkb-kb-configuration' ) || ( $pagenow == 'edit.php' && !isset($_GET['page']) ) || $pagenow == 'post.php' ? '' : $rating_text; ?>
			</div>

			<div class="eprf-stars-container"
				style="
					color: <?php echo $add_on_config['rating_element_color']; ?>;
					font-size: <?php echo $add_on_config['rating_element_size']; ?>px;
				"
				data-average="<?php echo $rating['average']; ?>"
			>
				<div class="eprf-stars__inner-background"> <?php
					if ( $show_stars ) {
						$i = 0;
						while ( $i < 5 ) {

							if ( $rating['average'] >= $i + 1 ) {
								$class = 'epkbfa-star';
							} elseif ( $rating['average'] >= $i + 0.5 ) {
								$class = 'epkbfa-star-half-o';
							} else {
								$class = 'epkbfa-star-o';
							}							?>

							<span class="epkbfa <?php echo $class; ?>" aria-hidden="true"></span><?php
							$i ++;
						}
					} else {
						_e('Not rated', 'echo-article-rating-and-feedback');
					}           ?>
				</div>
			</div>  <?php
			
			// show stars if article rated, and if on backend or front-end with stats layout
			if ( $show_stars && ! empty($article_id) || isset( $_GET['wizard-on'] ) ) {   ?>

				<i class="epkbfa epkbfa-chevron-down eprf-show-statistics-toggle" style="color: <?php echo $add_on_config['rating_dropdown_color']; ?>;font-size: <?php echo $add_on_config['rating_element_size']*0.6; ?>px"></i>
				<div class="eprf-stars-module__statistics">
					<h6><?php echo sprintf(__('%s out of 5 stars', 'echo-article-rating-and-feedback'), $rating['average']); ?></h6>
					<table>	<?php

						$i = 6;
						foreach ( $rating['statistic'] as $key => $value ) {

							if ( $key == 'like' || $key == 'dislike' ) {
								continue;
							}

							$i--;
							if ( isset($add_on_config['rating_stars_text_' . $i]) ) {								 ?>
								<tr>
									<td title="<?php echo $add_on_config['rating_stars_text_' . $i]; ?>"><?php echo $i . ' ' . __('Stars', 'echo-article-rating-and-feedback'); ?></td>
									<td>										<?php
										$percents = ! empty($rating['count']) ? 100 * ( $value / $rating['count'] ) : 0;
										$percents = round($percents, 0); 										?>
										<span class="eprf-stars-module__statistics__stat-wrap"><span class="eprf-stars-module__statistics__stat-wrap__stat-inside" style="width: <?php echo $percents; ?>%; background-color: <?php echo $add_on_config['rating_element_color']; ?>;"></span></span>
									</td>
									<td><?php echo $percents; ?>%</td>
								</tr> <?php
							}
						}       ?>

					</table>
				</div>				<?php
			}   ?>

		</div>    <?php
	}

	/**
	 * Show Like/Dislike module
	 *
	 * @param $add_on_config - current kb_config
	 * @param $rating
	 * @param $did_vote
	 */
	private function show_like_dislike( $add_on_config, $rating, $did_vote ) {
		global $pagenow;

		//This sets the layout where the text is located and if the statisitics are visible.
		$layout = '';
		switch ( $add_on_config['rating_layout'] ) {
			case 'rating_layout_1':
				$layout = 'eprf-like-dislike-module--layout-1';
				break;
			case 'rating_layout_2':
				$layout = 'eprf-like-dislike-module--layout-2';
				break;
		}

		//This sets the icon types.
		$ratingStyle          = '';
		$like_Icon_Type       = '';
		$dislike_Icon_Type    = '';
		$like_text            = '';
		$dislike_text         = '';
		$like_Button_Style    = '';
		$dislike_Button_Style = '';

		switch ( $add_on_config['rating_like_style'] ) {

			// Thumbs Up / Down
			case 'rating_like_style_1':
				$like_Icon_Type    = ' epkbfa-thumbs-up';
				$dislike_Icon_Type = ' epkbfa-thumbs-down';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-1';
				break;
			// Check and Times
			case 'rating_like_style_2':
				$like_Icon_Type    = ' epkbfa-check';
				$dislike_Icon_Type = ' epkbfa-times';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-2';
				break;
			// Arrow Up / Down
			case 'rating_like_style_3':
				$like_Icon_Type    = ' epkbfa-caret-up';
				$dislike_Icon_Type = ' epkbfa-caret-down';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-3';
				break;
			case 'rating_like_style_4':
				$like_Icon_Type    = ' eprf-text';
				$dislike_Icon_Type = ' eprf-text';
				$ratingStyle       = 'eprf-like-dislike-module__buttons--style-4';
				$like_text         = $add_on_config['rating_like_style_yes_button'];;
				$dislike_text         = $add_on_config['rating_like_style_no_button'];
				$like_Button_Style    = 'style="border-color: ' . $add_on_config['rating_like_color'] . '; color: ' . $add_on_config['rating_like_color'] . ';"';
				$dislike_Button_Style = 'style="border-color: ' . $add_on_config['rating_dislike_color'] . '; color: ' . $add_on_config['rating_dislike_color'] . ';"';
				break;
		}

		$like_stats    = '<span class="eprf-like-count">' . $rating['statistic']['like'] . '</span>';
		$dislike_stats = '<span class="eprf-dislike-count">' . $rating['statistic']['dislike'] . '</span>';
		$rating_text   = $did_vote ? '' : $add_on_config['rating_text_value']; ?>

		<div
			class="eprf-like-dislike-module <?php echo $layout; ?> <?php echo $did_vote ? 'eprf-rating--blocked' : ''; ?>">

			<div class="eprf-like-dislike-module__text" style="
				color: <?php echo $add_on_config['rating_text_color']; ?>;
				font-size: <?php echo $add_on_config['rating_text_font_size']; ?>px;
				">
				<?php echo $pagenow == 'post-new.php' || ( $pagenow == 'edit.php' && isset($_GET['page']) && $_GET['page'] !== 'epkb-kb-configuration' ) || ( $pagenow == 'edit.php' && !isset($_GET['page']) ) || $pagenow == 'post.php' ? '' : $rating_text; ?>
			</div>

			<div class="eprf-like-dislike-module__buttons <?php echo $ratingStyle; ?>"
			     style="font-size: <?php echo $add_on_config['rating_element_size']; ?>px;">

				<?php $tag = $did_vote ? 'span' : 'button'; ?>
				<<?php echo $tag; ?> <?php echo $like_Button_Style; ?> class="eprf-rate-like">
					<span class="epkbfa <?php echo $like_Icon_Type; ?>" aria-hidden="true"
					      style="color: <?php echo $add_on_config['rating_like_color']; ?>;"><?php echo $like_text; ?></span>
					<?php echo $like_stats; ?>
				</<?php echo $tag; ?>>

				<<?php echo $tag; ?> <?php echo $dislike_Button_Style; ?> class="eprf-rate-dislike">
					<span class="epkbfa <?php echo $dislike_Icon_Type; ?>" aria-hidden="true"
					      style="color: <?php echo $add_on_config['rating_dislike_color']; ?>;"><?php echo $dislike_text; ?></span>
					<?php echo $dislike_stats; ?>
				</<?php echo $tag; ?>>

			</div>
		</div>    <?php
	}
}