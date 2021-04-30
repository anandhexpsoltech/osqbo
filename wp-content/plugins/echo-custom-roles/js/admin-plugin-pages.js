jQuery(document).ready(function($) {

    setup_ajax_in_progress_dialog();


    /*********************************************************************************************
     *********************************************************************************************
     *
     *                MANAGE LICENSE
     *
     * ********************************************************************************************
     ********************************************************************************************/

    var license_form = $('#ekcb-licenses');

    function check_license_status() {
        $('#amcr_license_check').html('');

        var postData = {
            action: 'amcr_handle_license_request',
            command: 'get_license_info'
        };

	    send_ajax_request( 'GET', postData, 'Retrieving license status. Please wait.' );
    }
    if ( $('#eckb_license_tab').hasClass('active') ) {
        check_license_status();
    }

    /* CHECK LICENSE STATUS when user opens the page */
    $('#wpbody').on('click', '#eckb_license_tab', function (e) {
        check_license_status();
    });

    /* SAVE LINK LICENSE; runs for just LINK license field */
    license_form.on('click', '#amcr_save_btn', function (e) {
        e.preventDefault();  // do not submit the form

        var postData = {
            action: 'amcr_handle_license_request',
            amcr_license_key: $('#amcr_license_key').val().trim(),
            _wpnonce_amcr_license_key: $('#_wpnonce_amcr_license_key').val(),
            command: 'save'
        };

	    send_ajax_request( 'POST', postData, 'Saving license...' );
    });

    function send_ajax_request( ajax_type, postData, action_msg ) {

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
                $('#amcr-ajax-in-progress').text(action_msg).dialog('open');
            }
        }).done(function (response) {

            response = ( response ? response : '' );
            if ( response.message || typeof response.output === 'undefined' ) {
                //noinspection JSUnresolvedVariable,JSUnusedAssignment
                msg = response.message ? response.message : amcr_admin_notification('', 'Custom Roles: Error occurred. Please try again later. (L01)', 'error');
                return;
            }

            var output = typeof response.output !== 'undefined' && response.output ? response.output :
                                                                        amcr_admin_notification('', 'Please reload the page and try again (L37).', 'error');
            $('#amcr_license_check').html(output);

        }).fail(function (response, textStatus, error) {
            msg = ( error ? ' [' + error + ']' : 'unknown error' );
            msg = amcr_admin_notification('Custom Roles: Error occurred. Please try again later. (L02)', msg, 'error');
        }).always(function () {

            $('#amcr-ajax-in-progress').dialog('close');
            if ( msg ) {
                $('.eckb-bottom-notice-message').replaceWith(msg);
                $( "html, body" ).animate( {scrollTop: 0}, "slow" );
            }
        });

    }

	/* Dialogs --------------------------------------------------------------------*/

	// SAVE AJAX-IN-PROGRESS DIALOG
	function setup_ajax_in_progress_dialog() {
		$('#amcr-ajax-in-progress').dialog({
			resizable: false,
			height: 70,
			width: 200,
			modal: false,
			autoOpen: false
		}).hide();
	}

	// SHOW INFO MESSAGES
	function amcr_admin_notification( $title, $message , $type ) {
		return '<div class="eckb-bottom-notice-message">' +
			'<div class="contents">' +
			'<span class="' + $type + '">' +
			($title ? '<h4>'+$title+'</h4>' : '' ) +
			($message ? $message : '') +
			'</span>' +
			'</div>' +
			'<div class="amcr-close-notice fa fa-window-close"></div>'+
			'</div>';
	}
});
