<?php

defined( 'ABSPATH' ) || exit();

/**
 * Display the Help Box
 */
class EPKB_Help_Box_View {

	public function __construct() {
		// add_action( 'wp_footer', array( $this, 'output_help_box'), 1, 2 );
	}

	public static function output_help_box() {
		global $eckb_kb_id;

		$settings = epkb_get_instance()->settings_obj->get_settings_or_default();
		$enable_help_box = $settings['help_box_enable'];
		$help_box_display_mode = $settings['help_box_display_mode'];

		// do not show Help Box if both FAQs and Contact are disabled
		if ( $enable_help_box == 'off' ) {
			return;
		}

		$kb_id = epkb_get_instance()->settings_obj->get_value( 'help_box_faqs_kb', EPKB_KB_Config_DB::DEFAULT_KB_ID );
		$kb_id = EPKB_Utilities::sanitize_kb_id( $kb_id );

		$is_editor_on = EPKB_Utilities::get( 'epkb-editor-page-loaded' ) == '1';

		// show we display the Help Box?
		$page_id = get_the_ID();
		if ( $page_id === false ) {
			return;
		}
		$pages_to_display_on = $settings['help_box_page_ids'];

		// If Empty then display help box only on ALL KB / KB Article pages
		if ( empty($eckb_kb_id) && empty($pages_to_display_on) ) {
			return;
		}
		
		if ( ! $is_editor_on && ! empty($pages_to_display_on) && ! in_array( $page_id, array_map('trim', explode(',', $pages_to_display_on)) ) ) {
			return;
		} ?>

		<script>
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		</script> <?php
		do_action( 'epkb_enqueue_font_scripts');
		do_action( 'epkb_enqueue_help_box_scripts');  ?>

		<div id="eckb-help-box" style="display:none;">

			<!-- HEADER CONTAINER -->
			<div class="eckb-help_box__header">
				<div class="eckb-help_box__header-top">
					<div class="eckb-help_box__header-left">
						<span class="eckb-help_box__header-back-icon epkbfa epkbfa-chevron-left" ></span><?php
					if ( $settings['help_box_logo_image_url'] != '' ) {	?>
						<div class="eckb-help_box__header-logo">
							<img class="eckb-help_box__kb_icon" src="<?php echo $settings['help_box_logo_image_url']; ?>">
						</div> <?php
					} ?>
					</div>
					<div class="eckb-help_box__header-button"><?php
						if ( $help_box_display_mode != 'faqs' ) {	?>
							<span class="eckb-help_box__header-button-contact eckb-help_box__header-btn"><span><?php echo $settings['help_box_contact_top_button_title']; ?></span> <i class="epkbfa epkbfa-comment"></i></span> <?php
						}
						if ( $help_box_display_mode != 'contact' ) {	?>
						<span class="eckb-help_box__header-button-search eckb-help_box__header-btn"><i class="epkbfa epkbfa-search"></i> <span><?php echo $settings['help_box_faqs_top_button_title']; ?></span></span> <?php
						} ?>
					</div>
				</div>
				<h2 class="eckb-help_box__header__title"> <?php
					if ( $help_box_display_mode != 'contact' ) {	?>
						<span class="eckb-help_box__header_faq__title"><?php echo $settings['help_box_faqs_title']; ?></span> <?php
					}
					if ( $help_box_display_mode != 'faqs' ) {	?>
						<span class="eckb-help_box__header_contact__title"><?php echo $settings['help_box_contact_title']; ?></span> <?php
					}
					?>
				</h2>
			</div>

			<!-- BODY CONTAINER -->
			<div class="eckb-help_box__body"> <?php
				if ( $help_box_display_mode != 'contact' ) {	?>
					<div class="eckb-help_box__search">
						<?php self::display_search_input_and_results_box( $kb_id, $settings ); //TODO - kb_id ?>
					</div> <?php
				}
				if ( $help_box_display_mode != 'faqs' ) {	?>
					<div class="eckb-help_box__contact">
						<?php self::display_contact_box( $settings ); ?>
					</div> <?php
				} ?>

			</div>

			<!-- FOOTER CONTAINER -->
			<div id="eckb-help_box__footer">
				<?php echo __( 'Powered By', 'echo-knowledge-base' ); ?>
				<img class="eckb-help_box__kb_icon" src="<?php echo Echo_Knowledge_Base::$plugin_url . 'img/kb-icon.png'; ?>">
				<a href="https://www.echoknowledgebase.com/" target="_blank"><?php echo __( 'Echo Knowledge Base', 'echo-knowledge-base' ); ?></a>
			</div>
		</div>
		<div class="eckb-help-box-toggle eckb-help-box-toggle__<?php echo $settings['help_box_launcher_when_to_display']; ?>" style="display:none;">
			<i class="epkbfa epkbfa-comments-o"></i>
		</div>
		<style id="help-box-styles">
			#eckb-help-box {
				background-color: <?php echo $settings['help_box_background_color']; ?>;
			}

			/* Launcher */
			.eckb-help-box-toggle {
				background-color: <?php echo $settings['help_box_launcher_background_color']; ?>;
			}
			.eckb-help-box-toggle:hover {
				background-color: <?php echo $settings['help_box_launcher_background_hover_color']; ?>;
			}
			.eckb-help-box-toggle {
				color: <?php echo $settings['help_box_launcher_icon_color']; ?>;
			}
			.eckb-help-box-toggle:hover {
				color: <?php echo $settings['help_box_launcher_icon_hover_color']; ?>;
			}

			/* General*/
			.eckb-help_box__body {
				color: <?php echo $settings['help_box_text_color']; ?>;
			}
			.eckb-help_box__body .epkb-help_box_cat-item:hover {
				color: <?php echo $settings['help_box_text_hover_color']; ?>;
			}
			.eckb-help_box__body .epkb-help_box_article-item:hover {
				color: <?php echo $settings['help_box_text_hover_color']; ?>;
			}

			/* Back Navigation */
			.eckb-help_box__header .eckb-help_box__header-back-icon {
				background-color: <?php echo $settings['help_box_back_icon_bg_color']; ?>;
				color: <?php echo $settings['help_box_back_icon_color']; ?>;
			}
			.eckb-help_box__header .eckb-help_box__header-back-icon:hover {
				background-color: <?php echo $settings['help_box_back_icon_bg_color_hover_color']; ?>;
				color: <?php echo $settings['help_box_back_icon_color_hover_color']; ?>;
			}

			/* Read More */
			.eckb-help_box__body .epkb-help_box_article-link {
				color: <?php echo $settings['help_box_faqs_read_more_text_color']; ?>;
			}
			.eckb-help_box__body .epkb-help_box_article-link:hover {
				color: <?php echo $settings['help_box_faqs_read_more_text_hover_color']; ?>;
			}

			/* Header Toggle Button */
			.eckb-help_box__header-btn {
				background-color: <?php echo $settings['help_box_top_button_color']; ?>;
				color: <?php echo $settings['help_box_top_button_text_color']; ?>;
			}
			.eckb-help_box__header-btn:hover {
				background-color: <?php echo $settings['help_box_top_button_hover_color']; ?>;
				color: <?php echo $settings['help_box_top_button_text_hover_color']; ?>;
			}

			/* Contact Form */
			.epkb-help_box__contact-form-btn {
				background-color: <?php echo $settings['help_box_contact_button_color']; ?>!important;
				color: <?php echo $settings['help_box_contact_button_text_color']; ?>!important;
			}
			.epkb-help_box__contact-form-btn:hover {
				background-color: <?php echo $settings['help_box_contact_button_hover_color']; ?>!important;
				color: <?php echo $settings['help_box_contact_button_text_hover_color']; ?>!important;
			}

		</style>	<?php
	}

	/**
	 * Display Search Input and Results
	 *
	 * @param $kb_id
	 * @param $settings
	 */
	private static function display_search_input_and_results_box( $kb_id, $settings ) {    ?>

		<div id="epkb-help_box__search-box-container">

			<!----- Search Box ------>
			<div class="epkb-help_box__search-box">
				<form id="epkb-help_box__search-form"  method="post" action="" onSubmit="return false;">
					<input type="text" id="epkb-help_box__search-terms" name="epkb-help_box__search-terms" value="" placeholder="<?php echo $settings['help_box_faqs_search_placeholder']; ?>" data-kb-id="<?php echo $kb_id; ?>" />
				</form>
			</div>

			<!----- Search Box Results ------>
			<div class="epkb-help_box__search_results_container">
				<div id="epkb-help_box__search_results" class="epkb-help_box__search_step" data-step="1"></div>

				<div id="epkb-help_box__cat" class="epkb-help_box__search_step epkb-help_box__search_step_active" data-step="2"></div>

				<div id="epkb-help_box__cat-article" class="epkb-help_box__search_step" data-step="3"></div>

				<div id="epkb-help_box__search_results-cat-article-details" class="epkb-help_box__search_step" data-step="4"></div>

				<div class="eckb-help_box__loading-spinner"></div>
			</div>
		</div>		<?php
	}

	/**
	 * Display Contact Box
	 * @param $settings
	 */
	private static function display_contact_box( $settings ) {    ?>

		<div id="epkb-help_box__contact-box-container">
			<form id="epkb-help_box__contact-form" method="post" enctype="multipart/form-data">				<?php
				wp_nonce_field( '_epkb_help_box_contact_form_nonce' );				?>
				<input type="hidden" name="action" value="epkb_help_box_contact" />
				<div id="epkb-help_box__contact-form-body">

					<div class="epkb-help_box__contact-form-field">
						<input name="user_first_name" type="text" value="" required  id="epkb-help_box__contact-form-user_first_name" placeholder="<?php echo $settings['help_box_contact_name_placeholder']; ?>">
					</div>

					<div class="epkb-help_box__contact-form-field">
						<input name="email" type="email" value="" required id="epkb-help_box__contact-form-email" placeholder="<?php echo $settings['help_box_contact_user_email_placeholder']; ?>">
					</div>

					<div class="epkb-help_box__contact-form-field">
						<input name="subject" type="text" value="" required id="epkb-help_box__contact-form-subject" placeholder="<?php echo $settings['help_box_contact_subject_placeholder']; ?>">
					</div>

					<div class="epkb-help_box__contact-form-field">
						<textarea name="comment" required id="epkb-help_box__contact-form-comment" placeholder="<?php echo $settings['help_box_contact_comment_placeholder']; ?>"></textarea>
					</div>

					<div class="epkb-help_box__contact-form-btn-wrap">
						<input type="submit" name="submit" value="<?php echo $settings['help_box_contact_button_title']; ?>" class="epkb-help_box__contact-form-btn">
					</div>

					<div class="epkb-help_box__contact-form-response"></div>
				</div>
			</form>
			<div class="eckb-help_box__loading-spinner"></div>
		</div>		<?php
	}

}