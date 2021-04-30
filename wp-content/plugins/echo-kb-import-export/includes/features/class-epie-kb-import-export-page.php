<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display Manage KBs page
 *
 * @copyright   Copyright (C) 2020, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPIE_KB_Import_Export_Page {
	
	var $kb_config = array();

	public function __construct() {

		$kb_id = EPIE_KB_Core::get_current_kb_id();
		if ( empty($kb_id) ) {
			// TODO show error
			return;
		}

		add_action( 'eckb_manage_content_import_tab_body', array( $this, 'display_import_articles_section' ), 11, 2);
	}

	/**
	 * Display Import of articles section
	 * @param $kb_id
	 */
	public function display_import_articles_section( $kb_id ) {

		$current_kb_id = EPIE_KB_Core::get_current_kb_id();
		if ( empty($current_kb_id) ) {
			return;
		}

		// only output current KB import form
		if ( $kb_id != $current_kb_id ) {
			return;
		}		?>

			<div class="epie-admin-info-box">

				<div class="epie-content epie-content--active" id="epie-content-import">

					<div class="epie-admin-info-box__header">
						<div class="epie-admin-info-box__header__icon epkbfa epkbfa-download"></div>
						<div class="epie-admin-info-box__header__title"><?php _e('Import KB Content', 'echo-kb-import-export'); ?></div>

					</div>

					<div class="epie-admin-info-box__body">
						<div class="epie-form-field-intruction-wrap">
							<p>This import will create or update the following KB content:</p>
							<ul>
								<li>KB Articles.</li>
								<li>KB Categories.</li>
								<li>KB Tags.</li>
							</ul>
						</div>
						<div class="epie-import-content-form"><?php

							$kb_config = EPIE_KB_Core::get_kb_config( $kb_id );
							if ( is_wp_error($kb_config) ) {
								echo 'error DB';
								return;
							}

							if ( EPIE_Utilities::is_kb_archived( $kb_config['status'] ) ) {
                                echo '<p>' . __('This Knowledge Base is Archived. Activate the KB before importing articles.', 'echo-kb-import-export') . '</p>';

							} else if (	EPIE_Utilities_Export::can_export() ) {                       	?>

								<div class="epie-import-steps-container">
									<div class="epie-import-steps__single-step epie-import-steps__single-step--active" id="epie-step-1">
										Step 1: Setup
									</div>
									<div class="epie-import-steps__single-step" id="epie-step-2">
										Step 2: Review
									</div>
									<div class="epie-import-steps__single-step" id="epie-step-3">
										Step 3: Import
									</div>
								</div>

								<form id="import-main-form">
									<div class="epie-form-field-intruction-wrap">
										<p><?php _e('Instructions:', 'echo-kb-import-export'); ?></p>
										<ul>
											<li>Test import on your staging or test site before importing KB articles in production.</li>
											<li>Always back up your database before starting the import.</li>
											<li>Test how well the import works with your page builder.</li>
											<li>Ensure that you are importing articles into the correct KB.</li>
											<li>Read our documentation about import <a href="https://www.echoknowledgebase.com/documentation/import-articles/" target="_blank">here</a>.</li>
										</ul>
									</div>
									<div class="epie-form-field-wrap">
										<label class="epie-form-label">
											<span class="epie-form-label__text"><?php _e('Choose File:', 'echo-kb-import-export'); ?>*</span>
											<input class="epie-form-label__input epie-form-label__input--text" type="file" name="import_file" required>
										</label>									<?php

										if ( EPIE_Utilities::is_multiple_kbs_enabled() ) { ?>
											<label class="epie-form-label">
											I want to import articles into KB:&nbsp;&nbsp;&nbsp;
												<input class="epie-form-label__input epie-form-label__input--checkbox" type="checkbox" name="kb_name" required>
												<span class="epie-form-label__checkbox"><?php echo $kb_config['kb_name']; ?></span>
											</label>									<?php
										} ?>
									</div>
									<div class="epie-progress" data-start="<?php _e('Reading articles...', 'echo-kb-import-export'); ?>">
										<h3>Import Status </h3>
										<div class="epie-progress__bar ">
											<div style="width:0%;"></div>
										</div>
										<div class="epie-progress__log">
										</div>
									</div>
									<div class="epie-data-status-log">

									</div>
									<div class="epie-form-label" id="export-form-button-wrap">
										<a class="epie-form-label__input epie-form-label__input--info  epie-aibb-btn epie-aibb-btn--blue" href="<?php echo esc_url( admin_url('edit.php?post_type=' . EPIE_KB_Handler::get_post_type( $kb_id )) ); ?>"
										   target="blank" style="display: none;" id="kb_post_link" ><?php _e('View All Articles', 'echo-kb-import-export'); ?></a>
										<input id="epie-submit-prepare-action" class="epie-form-label__input epie-form-label__input--submit epie-aibb-btn epie-aibb-btn--blue" type="submit" value="<?php _e('Prepare Articles for Import', 'echo-kb-import-export'); ?>">
										<input id="epie-submit-import-action" style="display: none;" class="epie-form-label__input epie-form-label__input--submit epie-aibb-btn epie-aibb-btn--blue" type="submit" value="<?php _e('Import Articles', 'echo-kb-import-export'); ?>">
									</div>
									<input id="epie-submit-start-over-action" style="display: none;" class="epie-form-label__input epie-form-label__input--submit epie-aibb-btn epie-aibb-btn--yellow" type="submit" name="start-over" value="<?php _e('Start Over', 'echo-kb-import-export'); ?>">
									<input id="epie-cancel-action" style="display: none;" class="epie-form-label__input epie-form-label__input--submit epie-aibb-btn epie-aibb-btn--red" type="submit" name="start-over" value="<?php _e('Cancel', 'echo-kb-import-export'); ?>">

									<input type="hidden" name="epie_kb_id" value="<?php echo $kb_id; ?>">
									<input type="hidden" id="_wpnonce_kb_import_export" name="_wpnonce_kb_import_export" value="<?php echo wp_create_nonce( '_wpnonce_kb_import_export' ) ?>"/>
									<input type="hidden" id="import_action" name="import_action" value="prepare-kb-import"/>

								</form> <?php
							} else {
								echo '<p>' . __('Only users with administrative privilege can import data', 'echo-kb-import-export') . '</p>';
							} ?>
						</div>
					</div>
				</div>

			</div>		<?php
	}
}

