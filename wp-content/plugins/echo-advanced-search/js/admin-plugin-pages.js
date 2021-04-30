jQuery(document).ready(function($) {

    setup_ajax_in_progress_dialog();


	/*********************************************************************************************
	 *********************************************************************************************
	 *
	 *                ANALYTICS - RANGE  (http://www.daterangepicker.com/#usage)
	 *                ANALYTICS - TABLE  (https://datatables.net/examples/basic_init/zero_configuration.html)
	 *
	 * ********************************************************************************************
	 ********************************************************************************************/

	//	if ( jQuery('#asea-search-analytics-button').closest('.eckb-nav-section').hasClass('asea-active-nav') && $('#asea_datatable').length ) {
	if ( $('#asea_datatable').length ) {
        $('#asea_datatable').DataTable();

        var start = moment().subtract(7, 'days');
		var end = moment();

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			maxDate: end,
			maxSpan: {
				"months": 12
			},
			autoUpdateInput: false,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, function(start, end, label) {
			asea_get_search_data(start, end, label);
		});

		/* $('input[name="reportrange"]').on('apply.daterangepicker', function(ev, picker) {
		}); */

		/* $('input[name="reportrange"]').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		}); */

		// handle user range request
		function asea_get_search_data( start, end, label ) {
			$('#reportrange span').html(' &nbsp;&nbsp;<strong>' + label + '</strong>' + ': &nbsp;&nbsp;' + start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY') + '&nbsp;&nbsp;&nbsp;');

			var postData = {
				action: 'asea_handle_search_analytics',
				kb_id: $('#eckb_kb_id').val(),
				start_date: start.format('YYYY-MM-DD'),
				end_date: end.format('YYYY-MM-DD'),
				_wpnonce_asea_search_analytics: $('#_wpnonce_asea_search_analytics').val()
			};

			send_request( 'POST', postData, 'Getting data...', asea_admin_search_data_handler );
		}

		// initial state
		asea_get_search_data( start, end, 'Last 7 days' );
	}

	function asea_admin_search_data_handler( output ) {
		$('#asea_datatable').html(output);
	}


    /*********************************************************************************************
     *********************************************************************************************
     *
     *                MANAGE LICENSE
     *
     * ********************************************************************************************
     ********************************************************************************************/

    var license_form = $('#ekcb-licenses');

    function check_license_status() {
        $('#asea_license_check').html('');

        var postData = {
            action: 'asea_handle_license_request',
            command: 'get_license_info'
        };

        send_request( 'GET', postData, 'Retrieving license status. Please wait.', asea_admin_license_status_handler );
    }
    if ( $('#eckb_license_tab').hasClass('active') ) {
        check_license_status();
    }

    /* CHECK LICENSE STATUS when user opens the page */
    $('#wpbody').on('click', '#eckb_license_tab', function (e) {
        check_license_status();
    });

    /* SAVE LINK LICENSE; runs for just this plugin license field */
    license_form.on('click', '#asea_save_btn', function (e) {
        e.preventDefault();  // do not submit the form

        var postData = {
            action: 'asea_handle_license_request',
            asea_license_key: $('#asea_license_key').val().trim(),
            _wpnonce_asea_license_key: $('#_wpnonce_asea_license_key').val(),
            command: 'save'
        };

        send_request( 'POST', postData, 'Saving license...', asea_admin_license_status_handler );
    });

    function asea_admin_license_status_handler( output ) {
		  $('#asea_license_check').html(output);
	  }


	/*********************************************************************************************
	 *********************************************************************************************
	 *
	 *                OTHER
	 *
	 * ********************************************************************************************
	 ********************************************************************************************/

    function send_request( ajax_type, postData, action_msg, handler ) {

        var msg;

        $('.eckb-top-notice-message').html('');

        $.ajax({
            type: ajax_type,
            dataType: 'json',
            data: postData,
            url: ajaxurl,
            beforeSend: function (xhr)
            {
                //noinspection JSUnresolvedVariable
	            asea_loading_Dialog( 'show', action_msg );

            }
        }).done(function (response) {

            response = ( response ? response : '' );
            if ( response.message || typeof response.output === 'undefined' ) {
                //noinspection JSUnresolvedVariable,JSUnusedAssignment
                msg = response.message ? response.message : asea_admin_notification('', 'Advanced Search: Error occurred. Please try again later. (L01)', 'error');
                return;
            }

            var output = typeof response.output !== 'undefined' && response.output ? response.output :
                                                                        asea_admin_notification('', 'Please reload the page and try again (L37).', 'error');
	        handler( output );

        }).fail(function (response, textStatus, error) {
            msg = ( error ? ' [' + error + ']' : 'unknown error' );
            msg = asea_admin_notification('Advanced Search: Error occurred. Please try again later. (L02)', msg, 'error');
        }).always(function () {

	        asea_loading_Dialog( 'remove', '' );
            if ( msg ) {
                $('.eckb-top-notice-message').replaceWith(msg);
                $( "html, body" ).animate( {scrollTop: 0}, "slow" );
            }
        });
    }


    /* Dialogs --------------------------------------------------------------------*/

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
	 
	function asea_loading_Dialog( displayType, message ){

		if( displayType === 'show' ){

			var output =
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



	// SAVE AJAX-IN-PROGRESS DIALOG
    function setup_ajax_in_progress_dialog() {
        $('#asea-ajax-in-progress').dialog({
            resizable: false,
            height: 70,
            width: 200,
            modal: false,
            autoOpen: false
        }).hide();
    }

    // SHOW INFO MESSAGES
    function asea_admin_notification( $title, $message , $type ) {
        return '<div class="eckb-top-notice-message">' +
            '<div class="contents">' +
            '<span class="' + $type + '">' +
            ($title ? '<h4>'+$title+'</h4>' : '' ) +
            ($message ? $message : '') +
            '</span>' +
            '</div>' +
            '</div>';
    }

	//Sidebar Advanced Search Toggle
	$( '#wpbody-content' ).on( 'click', '.asea-search-toggle', function (){
		
		$(this).closest('.epkb-wc-step-panel').find('.asea-advanced-search-container, .elay-advanced-search-container').slideToggle();
	});
});
