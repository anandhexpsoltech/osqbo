"use strict"
jQuery(document).ready(function($) {

	setup_ajax_in_progress_dialog();

	/*********************************************************************************************
	 *********************************************************************************************
	 *
	 *                NEW DIALOG BOXES
	 *
	 * ********************************************************************************************
	 ********************************************************************************************/

	function epieSendAjaxRequest(ajax_type, postData, action_msg, handler ) {

		let errorTitle = 'Error Occurred';
		let errorMessage = '';
		let result = '';
		let ajaxResponse = '';

		$.ajax({
			type: ajax_type,
			dataType: 'json',
			data: postData,
			url: ajaxurl,
			beforeSend: function (xhr)
			{
				loadingDialog( action_msg );
			}
		}).done(function (response) {

			ajaxResponse = ( response ? response : '' );
			if ( ajaxResponse.error || ajaxResponse.status !== 'success' ) {
				errorTitle = ajaxResponse.title ? ajaxResponse.title : errorTitle;
				errorMessage = ajaxResponse.message ? ajaxResponse.message : 'Please try again later. (L01)';
			} else {
				result = ajaxResponse.result ? ajaxResponse.result : '';
			}

		}).fail(function (response, textStatus, error) {
			errorMessage = ( error ? ' [' + error + ']' : 'unknown error' );
		}).always(function () {

			if ( errorMessage !== '' ) {
				centerStatusDialog(errorTitle, errorMessage, 'error' );
				return;
			}

			bottomNoticeMessage( 'Completed', 'success' );

			if ( handler ) {
				handler(result);
				return;
			}
		});
	}

	// Info / Dialogs -------------------------------------------------------------------------------------------------/
	// Dialog Box Confirmation Close
	$( '.epie-admin-dbc__close' ).on( 'click', function(){
		$( '.epie-admin-dialog-box-confirmation' ).hide();
		$( '.epie-admin-dialog-box-info' ).remove();
	});
	$( '.epie-admin-dbc__footer__cancel' ).on( 'click', function(){
		$( '.epie-admin-dialog-box-confirmation' ).hide();
		$( '.epie-admin-dialog-box-info' ).remove();
	});

	// Dialog Box Form Close
	$( '.epie-tm-dbf__close' ).on( 'click', function(){
		$( '.epie-tm-dialog-box-form' ).hide();
	});
	$( '.epie-tm-dbf__footer__cancel' ).on( 'click', function(){
		$( '.epie-tm-dialog-box-form' ).hide();
	});
	function hide_all_dialogs(){
		$( '.epie-tm-dialog-box-form' ).hide();
		$( '.epie-admin-dialog-box-confirmation' ).hide();
		$( '.epie-admin-dialog-box-info' ).remove();
	}


	/**
	  * Displays a small Message at the bottom left hand corner of page and fades away after 3 seconds.
	  *
	  * This is good for quick messages like Successful load or Saved changes etc...
	  *
	  * @param  String    message    Optional    Message output from database or settings.
	  * @param  String    type       Type of message ( success, error, danger, attention ) These will just affect the color.
	  *
	  * Outputs: Removes old dialogs and adds the HTML to the end of the Template div.
	  *
	  */
	function bottomNoticeMessage( message , type ) {

		// Remove any old dialogs.
		if ( $( '.epie-admin-dialog-box-status' ).hasClass( 'epie-admin-dialog-box-status--success')){
			$( '.epie-admin-dialog-box-status' ).remove();
		}
		if ( $( '.epie-admin-dialog-box-status' ).hasClass( 'epie-admin-dialog-box-status--info')){
			$( '.epie-admin-dialog-box-status' ).remove();
		}

		// $( '.epie-admin-dialog-box-status' ).remove();
		$( '.epie-admin-dialog-box-loading' ).remove();

		let output = '<div class="epie-bottom-notice-message epie-bottom-notice-message--' + type + '">' +

				(message ? message : '') +

				'</div>';

		//Add message output at the end of Body Tag
		$('body' ).append( output );

		setTimeout(function(){
			$( '.epie-bottom-notice-message' ).addClass('fadeOutDown');
		}, 3000)

	}

	/**
	  * Displays a Center Dialog box with a loading icon and text.
	  *
	  * This should only be used for indicating users that loading is in progress, nothing else.
	  *
	  * @param  String    message    Optional    Message output from database or settings.
	  *
	  * Outputs: Removes old dialogs and adds the HTML to the end body tag
	  *
	  */
	function loadingDialog( message ){

		// Remove any old dialogs.
		$( '.epie-admin-dialog-box-status' ).remove();

		let output = '<div class="epie-admin-dialog-box-loading">' +

					//<-- Header -->
				'<div class="epie-admin-dbl__header">' +
				'<div class="epie-admin-dbl-icon epie epie-hourglass-half"></div>'+
				(message ? '<h4>' + message + '</h4>' : '' ) +
				'</div>'+
				'</div>';

		//Add message output at the end of Body Tag
		$( 'body' ).append( output );
	}

	/**
	  * Displays a Center Dialog box with an icon and text.
	 *
	  * This is good for Warning Messages or messages that are more detailed and require the user to see it more promptly.
	  * Warning / Error messages will not disappear and will require the user to close the box.
	  *
	  * @param  String    title      Optional    Title of message.
	  * @param  String    message    Optional    Message output from database or settings.
	  * @param  String    type       Type of message ( success, error, danger, attention ) These will affect the color and icon and close button.
	  *
	  * Outputs: Removes old dialogs and adds the HTML to the end of the Template div.
	  *
	  */
	function centerStatusDialog( title, message, type ){

		// Remove any old dialogs.
		$( '.epie-admin-dialog-box-status' ).remove();
		$( '.epie-admin-dialog-box-loading' ).remove();

		// Icon type
		let icon = '';
		switch(type) {
			case 'success':
				icon = 'epie-check';
				break;
			case 'info':
				icon = 'epie-info';
				break;
			case 'warning':
				icon = 'epie-exclamation-triangle';
				break;
			case 'error':
				icon = 'epie-exclamation';
				break;
			default:
			// code block
		}

		//Close button ( If error )
		let footer ='';
		if( type === 'error' || type === 'warning' ) {
			footer = '<div class="epie-admin-dbs__footer">' +
					'<div class="epie-admin-dbs__footer__close">Close</div>' +
					'</div>';
		}

		let output = '<div class="epie-admin-dialog-box-status epie-admin-dialog-box-status--' + type + '">' +

					//<-- Header -->
				'<div class="epie-admin-dbs__header">' +
				'<div class="epie-dbs-icon epie ' + icon + '"></div>'+
				(title ? '<h4>' + title + '</h4>' : '' ) +
				'</div>' +

					//<-- Body -->
				'<div class="epie-admin-dbs__body">' +
				(message ? message : '') +
				'</div>' +

					//<-- Footer -->
				footer +

				'</div>';

		//Add message output at the end body tag
		$('body' ).append( output );

		$( '.epie-admin-dbs__footer__close' ).on('click', function () {
			$( '.epie-admin-dialog-box-status' ).remove();
		})
	}

	
	/**
	  * Displays a Center Dialog box with a buttons yes/now.
	 *
	  * This is good for Warning Messages or messages that are more detailed and require the user to see it more promptly.
	  * Warning / Error messages will not disappear and will require the user to close the box.
	  *
	  * @param  String    title      Optional    Title of message.
	  * @param  String    message    Optional    Message output from database or settings.
	  * @param  String    callback function name       
	  * @param  Any       callback function arguments
	  *
	  * Outputs: Removes old dialogs and adds the HTML to the end of the Template div.
	  *
	  */
	function centerConfirmationDialog( title, message, confirmCallback, confirmData ){

		// Remove any old dialogs.
		$( '.epie-admin-dialog-box-status' ).remove();
		$( '.epie-admin-dialog-box-loading' ).remove();
		$( '.epie-admin-dialog-box-confirmation' ).remove();
		$( '.epie-admin-dialog-box-info' ).remove();
		//Buttons 
		let footer = `
			<div class="epie-admin-dbc__footer">
				<div class="epie-admin-dbc__footer__accept">
					<span class="epie-admin-dbc__footer__accept__btn epie-dbc__footer__accept--success">${epie_vars.msg_yes}</span>
				</div>
				<div class="epie-admin-dbc__footer__cancel">
					<span class="epie-admin-dbc__footer__cancel__btn">${epie_vars.msg_no}</span>
				</div>
			</div>
		`;

		let output = '<div class="epie-admin-dialog-box-confirmation">' +

					//<-- Header -->
				'<div class="epie-admin-dbc__header">' +
				(title ? '<h4>' + title + '</h4>' : '' ) +
				'</div>' +

					//<-- Body -->
				'<div class="epie-admin-dbc__body">' +
				(message ? message : '') +
				'</div>' +

					//<-- Footer -->
				footer +

				'</div>';

		//Add message output at the end body tag
		$('body' ).append( output );

		$( '.epie-admin-dbc__footer__cancel__btn' ).on('click', function () {
			$( '.epie-admin-dialog-box-confirmation' ).remove();
		});
		
		if ( typeof confirmCallback == 'function' ) {
			$( '.epie-admin-dbc__footer__accept__btn' ).on('click', function(){
				confirmCallback(confirmData);
				$( '.epie-admin-dialog-box-confirmation' ).remove();
			});
			
		}
	}
	
	
	/**
	  * Displays a Center Dialog info box with a button ok.
	 *
	  * This is good for Warning Messages or messages that are more detailed and require the user to see it more promptly.
	  * Warning / Error messages will not disappear and will require the user to close the box.
	  *
	  * @param  String    title      Optional    Title of message.
	  * @param  String    message    Optional    Message output from database or settings.
	  * @param  String    function name callback
	  * @param  Any       callback function argument
	  * Outputs: Removes old dialogs and adds the HTML to the end of the Template div.
	  *
	  */
	function centerInfoDialog( title, message, confirmCallback, confirmData ){

		// Remove any old dialogs.
		$( '.epie-admin-dialog-box-status' ).remove();
		$( '.epie-admin-dialog-box-loading' ).remove();
		$( '.epie-admin-dialog-box-confirmation' ).remove();
		$( '.epie-admin-dialog-box-info' ).remove();
		//Buttons 
		let footer = `
			<div class="epie-admin-dbc__footer">
				<div class="epie-admin-dbc__footer__accept">
					<span class="epie-admin-dbc__footer__accept__btn epie-dbc__footer__accept--success">${epie_vars.msg_ok}</span>
				</div>
			</div>
		`;

		let output = '<div class="epie-admin-dialog-box-info">' +

					//<-- Header -->
				'<div class="epie-admin-dbc__header">' +
				(title ? '<h4>' + title + '</h4>' : '' ) +
				'</div>' +

					//<-- Body -->
				'<div class="epie-admin-dbc__body">' +
				(message ? message : '') +
				'</div>' +

					//<-- Footer -->
				footer +

				'</div>';

		//Add message output at the end body tag
		$('body').append( output );
		
		// any click will close this popup 
		$('body').one( 'click', function(){
			
			if ( typeof confirmCallback == 'function' ) {
				confirmCallback(confirmData);
			}
			
			$( '.epie-admin-dialog-box-info' ).remove();
		} );
	}

	/*********************************************************************************************
	 *********************************************************************************************
	 *
	 *                MANAGE LICENSE
	 *
	 * ********************************************************************************************
	 ********************************************************************************************/

	let license_form = $('#ekcb-licenses');

	function check_license_status() {
		$('#epie_license_check').html('');

		let postData = {
			action: 'epie_handle_license_request',
			command: 'get_license_info'
		};

		send_request( 'GET', postData, 'Retrieving license status. Please wait.' );
	}
	if ( $('#eckb_license_tab').hasClass('active') ) {
		check_license_status();
	}

	/* CHECK LICENSE STATUS when user opens the page */
	$('#wpbody').on('click', '#eckb_license_tab', function (e) {
		check_license_status();
	});

	/* SAVE EPIE LICENSE; runs for just EPIE license field */
	license_form.on('click', '#epie_save_btn', function (e) {
		e.preventDefault();  // do not submit the form

		let postData = {
			action: 'epie_handle_license_request',
			epie_license_key: $('#epie_license_key').val().trim(),
			_wpnonce_epie_license_key: $('#_wpnonce_epie_license_key').val(),
			command: 'save'
		};

		send_request( 'POST', postData, 'Saving license...' );
	});

	function send_request( ajax_type, postData, action_msg ) {

		let msg;

		$('.eckb-top-notice-message').html('');

		$.ajax({
			type: ajax_type,
			dataType: 'json',
			data: postData,
			url: ajaxurl,
			beforeSend: function (xhr)
			{
				//noinspection JSUnresolvedVariable
				epie_loading_Dialog( 'show', action_msg );
			}
		}).done(function (response) {

			response = ( response ? response : '' );
			if ( response.message || typeof response.output === 'undefined' ) {
				//noinspection JSUnresolvedVariable,JSUnusedAssignment
				msg = response.message ? response.message : epie_admin_notification('', 'KB Import Export: Error occurred. Please try again later. (L01)', 'error');
				return;
			}

			let output = typeof response.output !== 'undefined' && response.output ? response.output :
				epie_admin_notification('', 'Please reload the page and try again (L37).', 'error');
			$('#epie_license_check').html(output);

		}).fail(function (response, textStatus, error) {
			msg = ( error ? ' [' + error + ']' : 'unknown error' );
			msg = epie_admin_notification('KB Import Export: Error occurred. Please try again later. (L02)', msg, 'error');
		}).always(function () {

			epie_loading_Dialog( 'remove', '' );
			if ( msg ) {
				$('.eckb-top-notice-message').replaceWith(msg);
				$( "html, body" ).animate( {scrollTop: 0}, "slow" );
			}
		});

	}

	/**
	 * Displays a Center Dialog box with a loading icon and text.
	 *
	 * This should only be used for indicating users that loading or saving or processing is in progress, nothing else.
	 * This code is used in these files, any changes here must be done to the following files.
	 *   - admin-plugin-pages.js
	 *   - admin-kb-config-scripts.js
	 *   - admin-kb-wizard-script.js
	 *
	 * @param  {string}    displayType     Show or hide Dialog initially. ( show, remove )
	 * @param  {string}    message         Optional    Message output from database or settings.
	 *
	 * @return {html}                      Removes old dialogs and adds the HTML to the end body tag with optional message.
	 *
	 */
	function epie_loading_Dialog( displayType, message ){

		if( displayType === 'show' ){

			let output =
				'<div class="epkb-admin-dialog-box-loading">' +

				//<-- Header -->
				'<div class="epkb-admin-dbl__header">' +
				'<div class="epkb-admin-dbl-icon epkbfa epkbfa-hourglass-half"></div>'+
				(message ? '<div class="epkb-admin-text">' + message + '</div>' : '' ) +
				'</div>'+

				'</div>' +
				'<div class="epkb-admin-dialog-box-overlay"></div>';

			//Add message output at the end of Body Tag
			$( 'body' ).append( output );
		}else if( displayType === 'remove' ){

			// Remove loading dialogs.
			$( '.epkb-admin-dialog-box-loading' ).remove();
			$( '.epkb-admin-dialog-box-overlay' ).remove();
		}

	}

	/* Dialogs --------------------------------------------------------------------*/

	// SAVE AJAX-IN-PROGRESS DIALOG
	function setup_ajax_in_progress_dialog() {
		$('#epie-ajax-in-progress').dialog({
			resizable: false,
			height: 70,
			width: 200,
			modal: false,
			autoOpen: false
		}).hide();
	}

	// SHOW INFO MESSAGES
	function epie_admin_notification( $title, $message , $type ) {
		return '<div class="eckb-top-notice-message">' +
			'<div class="contents">' +
			'<span class="' + $type + '">' +
			($title ? '<h4>'+$title+'</h4>' : '' ) +
			($message ? $message : '') +
			'</span>' +
			'</div>' +
			'</div>';
	}


	/*********************************************************************************************
	 *********************************************************************************************
	 *
	 *                EXPORT ARTICLES
	 *
	 * ********************************************************************************************
	 ********************************************************************************************/

	// ajax export 
	let epie_article_ids = []; // storage for ids, if we want to allow reload of the page - we can use local storage  pop 
	
	// data store for export. In future can be in local storage and use for "background" export on any tab
	// data item: { 'ids', 'type', 'text', 'total', 'active' }  
	let epie_export_data = {
		'data': {}, // items like articles, categories, etc
		'info': {
			'items_per_request': 5, // TODO in future: Use this to find how much per 1 time can handle user's server
			'success': '', // text of the error
			'error': '', // text of the error
			'in_progress': false, // status of export - started or no, bool
			'file': '', // file link 
			'file_id': '' // file id on the server 
		},
		'user_data': {}
	};
	
	// update view of the progress table 
	function epie_update_export_progress_view( form ) {
		
		let html = '';
		let total_count = 0;
		let current_count = 0;
		
		if ( epie_export_data.info.success ) {
			html += `
				<div class="epie-export-progress__row epie-export-progress__row--success">
					<div class="epie-export__title">${epie_export_data.info.success}</div>
					<div class="epie-export__icon"><i class="epkbfa epkbfa-check-circle"></i></div>
				</div>
			`;
			form.find('.epie-progress__bar div').css({
				'width' : '100%'
			});

			if ( epie_export_data.info.file ) {
				form.find('#export_file_link').attr( 'href', epie_export_data.info.file );
				form.find('#export_file_link').show();
			} else {
				form.find('#export_file_link').hide();
			}
		}
		
		if ( epie_export_data.info.error ) {
			html += `
				<div class="epie-export-progress__row epie-export-progress__row--error">
					<div class="epie-export__title">${epie_export_data.info.error}</div>
					<div class="epie-export__icon"><i class="epkbfa epkbfa-exclamation-circle"></i></div>
				</div>
			`;
			$('#epie-content-export .epie-progress__bar').hide();
		}
		form.find('.epie-progress__log').html(html);
		
	}
	

	function epie_get_export_data( form ) {
		let postData = {
			_wpnonce_kb_import_export: form.find('#_wpnonce_kb_import_export').val(),
			action: 'epie_get_export_data',
			form: form.serialize()
		};

		let title = form.find('.epie-progress').data('start');

		var html = `
					<div class="epie-export-progress__row epie-export-progress__row--in-progress">
						<div class="epie-export__title">${title}</div>
						<div class="epie-export__icon"><i class="epkbfa epkbfa-spinner"></i></div>
					</div>`;

		form.find('.epie-progress__log').html(html);

		$.ajax({
			type: 'POST',
			dataType: 'json',
			data: postData,
			url: ajaxurl,
			beforeSend: function (xhr) {
				form.find('.epie-progress').show();
			}
		}).done(function (response) {
			
			if (response.error) {
				epie_export_data.info.error = response.error;
				epie_update_export_progress_view( form );
			} else if ( response.success ) {
				epie_export_data.info.success = response.success;
				epie_export_data.info.file = response.file;
				epie_update_export_progress_view( form );
				//epie_run_export( form );

			}
		});
	}

	

	
	// data is an array of the objects [{},{}] where each object have THE SAME items names in the same order: {title: '', content: '', ... } like an array of the associated arrays
	function createCSVLinkFromObject(data) {
		
		if (typeof data !== 'object') return '';
		let csvRows = [];
		let csvTitle = []; 
		
		for (let title in data[0]) {
			csvTitle.push(title);
		}
		
		csvRows.push(csvTitle.join(','));
		
		data.forEach(function(item){
			let row = [];
			
			for (let title in item) {
				let filteredTitle = item[title];
				
				// filter " 
				filteredTitle = filteredTitle.replace(new RegExp('"', 'g'), '""');
				
				// filter breaklines and ,
				filteredTitle = '"' + filteredTitle + '"';
				
				// filter to use in url 
				filteredTitle = encodeURI(filteredTitle);
				
				row.push(filteredTitle);
			}
			
			csvRows.push(row.join(','));
		});
		
		let csvString = 'data:attachment/csv,' + csvRows.join("%0A");
		return csvString;
	}

	// run export 
	$( '#export-main-form' ).submit( function(e) {
		e.preventDefault();
		var form = $( this );
		// Run progress bar 
		form.find( '.epie-progress' ).show();

		// Get data
		epie_get_export_data( form );
	});
	
	/* Tabs changing */
	$('.epie-top-panel__button').click(function(){
		$('.epie-top-panel__button').removeClass('epie-top-panel__button--active');
		$(this).addClass('epie-top-panel__button--active');
		
		$('.epie-content').removeClass('epie-content--active');
		$($(this).data('target')).addClass('epie-content--active');
	});


	/*********************************************************************************************
	 *********************************************************************************************
	 *
	 *                IMPORT ARTICLES
	 *
	 * ********************************************************************************************
	 ********************************************************************************************/
	
	let importedArticlesCount = 0;
	let importedRecursionMaxLength = 1000;
	let importCancelProcess = false;
	
	$('.epie-import-content-form form').submit(function(e){
		e.preventDefault();
		importCancelProcess = false;
		
		let form = $(this);
		if ( e.originalEvent.submitter.id == 'epie-submit-start-over-action' ) {
			import_start_over( form );
			return;
		}

		const file = form.find('input[name=import_file]')[0].files[0];
		const reader = new FileReader();
		let interval = null;

		reader.readAsText(file, "UTF-8");

		reader.onload = function (evt) {
			form.find('input[name="import_file"]').prop("disabled", true);

			// Assign top class to Row container so that import has full with of the container.
			form.parents( '.epkb-admin-row' ).addClass( 'epie-admin-row--import-kb-articles' );

			let msg = '';
			let data = new FormData();
			data.append('file', form.find('input[name=import_file]')[0].files[0]);
			data.append('_wpnonce_kb_import_export', form.find('#_wpnonce_kb_import_export').val());
			data.append('epie_kb_id', form.find('input[name=epie_kb_id]').val());
			data.append('import_action', form.find('input[name=import_action]').val());
			data.append('action', 'epie_import_kb_content');

			// FIRST prepare for import
			if ( form.find('input[name=import_action]').val() == "prepare-kb-import" ) {

				form.find('#epie-submit-prepare-action').hide();
				form.find('#kb_post_link').hide();
				form.parent().find('.epie-import-steps__single-step').removeClass('epie-import-steps__single-step--active');
				form.parent().find('#epie-step-2').addClass('epie-import-steps__single-step--active');
				form.find('.epie-form-field-wrap').hide();
				form.find('.epie-form-field-intruction-wrap').hide();
				form.parent().parent().find('.epie-form-field-intruction-wrap').hide();
				start_progress_bar( form );
				
				
				// SECOND import the data
			} else if ( form.find('input[name=import_action]').val() == "import_data" ) {

				form.find('#epie-submit-import-action').hide();
				form.find('#epie-submit-start-over-action').hide();
				form.parent().find('.epie-import-steps__single-step').removeClass('epie-import-steps__single-step--active');
				form.parent().find('#epie-step-3').addClass('epie-import-steps__single-step--active');
				let selected_array = [];
				form.find('input[name=csv_row]:checked').each(function(){
					selected_array.push($(this).val());
				});

				data.append('selected_rows', JSON.stringify(selected_array));

				importedRecursionMaxLength = 1000;
				
				form.find('.epie-progress__bar').addClass('epie-progress__bar-in-progress');
				start_progress_bar( form );
				form.find('.epie-progress__log .epie-export-progress__row--in-progress .epie-export__title').html(`
					${epie_vars.msg_0_imported} ${selected_array.length}...
				`);
				
			} else {
				return;
			}

			form.find('.epie-progress').show();
			form.find('.epie-progress__bar div').css({
				'width' : '0%'
			});
			form.find('.epie-data-status-log').html('');

			$.ajax({
				_wpnonce_kb_import_export: $(this).find('#_wpnonce_kb_import_export').val(),
				type: 'POST',
				dataType: 'json',
				data: data,
				url: ajaxurl,
				processData: false,
				contentType: false,
				beforeSend: function (xhr) {
					if ( form.find('input[name=import_action]').val() == "import_data" ) {
						$('#epie-cancel-action').show();
					}
				}
			}).done(function (response) {

				response = ( response ? response : '' );
				if ( response == '' || (response.success === 'undefined' && response.error === 'undefined' && response.process_message === 'undefined') ) {
					//noinspection JSUnresolvedVariable,JSUnusedAssignment
					msg = response.message ? response.message : epie_admin_notification('', epie_vars.msg_admin_error_l01, 'error');
					form.find('.epie-data-status-log').html(msg);
					return;
				}

				// step successfully completed
				if ( response.success != undefined && response.success != '' && form.find('input[name=import_action]').val() == "prepare-kb-import" ) {

					form.find('.epie-progress__log').html(response.success);
					form.find('.epie-data-status-log').html(response.response_html);
				
					form.find('.epie-progress__bar div').css({
						'width' : '100%'
					});
					
					form.find('input[name=import_action]').val( "import_data" );
					form.find('input[name="import_file"]').prop("disabled", true);
					form.find('#epie-submit-prepare-action').hide();
					form.find('#epie-submit-import-action').show();
					form.find('#epie-submit-start-over-action').show();

					// error occurred
				} else if( form.find('input[name=import_action]').val() == "import_data" ) {
					epie_run_import_response( response, form ) 
				} else {

					form.find('#epie-submit-start-over-action').show();

					form.find('.epie-progress__log').html(`
					<div class="epie-export-progress__row epie-export-progress__row--error">
						<div class="epie-export__icon"><i class="epkbfa epkbfa-exclamation-circle"></i></div>
						<div class="epie-export__title">${response.error}</div>
					</div>
				`);

				}
				
				if ( typeof response.inserted !== 'undefined' && response.inserted ) {
					importedArticlesCount = response.inserted;
				}
			}).fail(function (response, textStatus, error) {
				msg = ( error ? ' [' + error + ']' : 'unknown error' );
				msg = epie_admin_notification('', epie_vars.msg_admin_error_l012, 'error');
				form.find('.epie-data-status-log').html(msg);
			});
		};

		reader.onerror = function (err) {
			// read error caught here

			//console.log(err.target.error);
			form.find('input[name=import_file]').val('');
			import_start_over( form );
			form.find('.epie-progress').show();
			form.find('.epie-progress__log').html(`
					<div class="epie-export-progress__row epie-export-progress__row--error">
						<div class="epie-export__icon"><i class="epkbfa epkbfa-exclamation-circle"></i></div>
						<div class="epie-export__title">Your CSV file has changed. Please reselect the file and start again.</div>
					</div>
				`);
			console.log(err);
			return;
		}
	});

	function import_start_over( form ){
		importedArticlesCount = 0;
		start_progress_bar( form );
		form.find('.epie-data-status-log').html('');
		form.find('#kb_post_link').hide();
		form.find('input[name=import_file]').val('');
		form.find('input[name="import_file"]').prop("disabled", false);
		//form.find('.epie-form-label__input--submit').hide();
		form.find('#epie-submit-prepare-action').show();
		form.find('#epie-submit-import-action').hide();
		form.find('#epie-submit-start-over-action').hide();
		form.find('.epie-progress').hide();
		form.find('input[name=import_action]').val("prepare-kb-import");
		form.parent().find('.epie-import-steps__single-step').removeClass('epie-import-steps__single-step--active');
		form.parent().find('#epie-step-1').addClass('epie-import-steps__single-step--active');
		form.find('.epie-form-field-wrap').show();
		form.find('.epie-form-field-intruction-wrap').show();
		form.find('.epie-form-field-intruction-wrap').show();
		form.parent().parent().find('.epie-form-field-intruction-wrap').show();
		form.find('.epie-progress__bar').removeClass('epie-progress__bar-in-progress');
		if ( typeof interval !== 'undefined' ){
			clearInterval(interval);
		}
	}

	function epie_run_import( form ){
		
		importedRecursionMaxLength--;
		
		let postData = {
			action: 'epie_import_steps',
		};

		$.ajax({
			type: 'POST',
			dataType: 'json',
			data: postData,
			url: ajaxurl,
			beforeSend: function (xhr) {
				// update progress view

			}
		}).done(function (response) {
			
			epie_run_import_response( response, form ) ;
		});

	}
	
	function epie_run_import_response( response, form ) {
		
		if ( importCancelProcess && typeof response.processed !== 'undefined' ) {
			importCancelProcess = false;
			setTimeout(function(){
				centerInfoDialog( epie_vars.msg_content_import, epie_vars.msg_imported_articles + response.processed, import_start_over, form );
			}, 100); // need to have time for changing message
			return;
		}
		
		if ( typeof response == 'object' && typeof response.error !== 'undefined' ) {
			form.find('#epie-submit-start-over-action').show();
			$('#epie-cancel-action').hide();
			
			form.find('.epie-progress__log').html(`
				<div class="epie-export-progress__row epie-export-progress__row--error">
					<div class="epie-export__icon"><i class="epkbfa epkbfa-exclamation-circle"></i></div>
					<div class="epie-export__title">${response.error}</div>
				</div>
			`);
				
			return;
		}
			
		if ( response != null && response.success != undefined && response.success != '' ) {
			form.find('.epie-progress__bar div').css({
				'width' : '100%'
			});
			
			$('#epie-cancel-action').hide();
			
			form.find('.epie-progress__log').html(response.success);
			form.find('.epie-data-status-log').html(response.response_html);
			form.find('.epie-progress__bar').removeClass('epie-progress__bar-in-progress');
			form.find('input[name=import_action]').val( "prepare-kb-import" );
			form.find('#kb_post_link').show();
			form.find('input[name="import_file"]').prop("disabled", false);
			form.find('.epie-form-label__input--submit').hide(); 
			form.find('#epie-submit-import-action').hide();
			form.find('#epie-submit-start-over-action').show();
			importedArticlesCount = response.inserted;
				
			return;
		}
			
		// no errors, have next step 
		if ( response != null && response.process_message != undefined && response.process_message != '' ) {
			form.find('.epie-progress__log .epie-export-progress__row--in-progress .epie-export__title').html(`
				${response.process_message}
			`);
			form.find('.epie-progress__bar-in-progress div').css({
				'width' : response.progress+'%'
			});
				
			importedArticlesCount = response.processed;
		}
				
		if ( importedRecursionMaxLength  ) {
			epie_run_import( form );
		} else {
			form.find('#epie-submit-start-over-action').show();

			form.find('.epie-progress__log').html(`
				<div class="epie-export-progress__row epie-export-progress__row--error">
					<div class="epie-export__icon"><i class="epkbfa epkbfa-exclamation-circle"></i></div>
					<div class="epie-export__title">The import file is too big.</div>
				</div>
			`);
		}
			
	}

	function start_progress_bar( form ) {
		let progress_text = form.find('.epie-progress').data('start');

		form.find('.epie-progress__log').html(`
			<div class="epie-export-progress__row epie-export-progress__row--in-progress">
				<div class="epie-export__title">${progress_text}</div>
				<div class="epie-export__icon"><i class="epkbfa epkbfa-spinner"></i></div>
			</div>
		`);

	}
	
	$('#epie-cancel-action').click(function(){
		importCancelProcess = true;
		$('body').find('.epie-export__title').html( epie_vars.msg_stop_import );
		$(this).hide();
		return false;
	});
});
