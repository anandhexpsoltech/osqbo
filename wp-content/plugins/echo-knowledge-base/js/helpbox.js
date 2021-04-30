jQuery(document).ready(function($) {
	if( $( '.eckb-help-box-toggle__right_away' ).length ) {
		jQuery('.eckb-help-box-toggle__right_away').show();
	}

	if( $( '.eckb-help-box-toggle__after_delay' ).length ) {
		setTimeout(function () {
			jQuery('.eckb-help-box-toggle__after_delay').show();
		}, 1000);
	}

	/********************************************************************
	 *                      Category Box On Launch
	 ********************************************************************/

	function load_category() {

		var postData = {
			action: 'epkb_help_box_get_category_list',
		};

		var msg = '';
		var category_list = '';
		var article_list = '';

		$.ajax({
			type: 'POST',
			dataType: 'json',
			data: postData,
			url: ajaxurl,
			beforeSend: function (xhr)
			{
				add_spinner();
			}

		}).done(function (response)
		{
			response = ( response ? response : '' );

			remove_spinner();

			if ( response.error || response.status !== 'success') {
				//noinspection JSUnresolvedVariable
				msg = epkb_vars.msg_try_again;
			} else {
				category_list = response.category_list;
				article_list = response.article_list;
			}

		}).fail(function (response, textStatus, error)
		{
			//noinspection JSUnresolvedVariable
			msg = epkb_vars.msg_try_again + '. [' + ( error ? error : epkb_vars.unknown_error ) + ']';

		}).always(function ()
		{
			remove_spinner();

			if ( msg ) {
				$( '#epkb-help_box__cat' ).html( msg );
			}
			else {
				$( '#epkb-help_box__cat' ).html( category_list );
				$( '#epkb-help_box__cat-article' ).html( article_list );

			}

		});
	}


	/********************************************************************
	 *                      Category Box
	 ********************************************************************/

	// Category Click
	$( 'body' ).on( 'click', '.epkb-help_box_cat-item', function( e ) {
		e.preventDefault();

		if ( $(this).data('category') === '' ) {
			return;
		}

		let category = $(this).data('category');

		$( '.epkb-help_box__search-box' ).hide();
		$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
		$( '#epkb-help_box__cat-article' ).addClass('epkb-help_box__search_step_active');
		$( '#epkb-help_box__cat-article .epkb-help_box_article-box' ).hide();
		$( '#epkb-help_box__cat-article .epkb-help_box_article-box[data-category='+category+']' ).show();

		show_back();
	});


	/********************************************************************
	 *                      Article Box
	 ********************************************************************/

	// Category Click
	$( 'body' ).on( 'click', '.epkb-help_box_article-item', function( e ) {
		e.preventDefault();

		if ( $(this).data('kb-article-id') === '' ) {
			return;
		}

		var postData = {
			action: 'epkb_help_box_article_detail',
			article_id: $(this).data('kb-article-id'),
			type: $(this).data('type'),
		};

		var msg = '';

		$.ajax({
			type: 'POST',
			dataType: 'json',
			data: postData,
			url: ajaxurl,
			beforeSend: function (xhr)
			{
				add_spinner();
			}

		}).done(function (response)
		{
			response = ( response ? response : '' );

			remove_spinner();

			if ( response.error || response.status !== 'success') {
				//noinspection JSUnresolvedVariable
				msg = epkb_vars.msg_try_again;
			} else {
				msg = response.search_result;
			}

		}).fail(function (response, textStatus, error)
		{
			//noinspection JSUnresolvedVariable
			msg = epkb_vars.msg_try_again + '. [' + ( error ? error : epkb_vars.unknown_error ) + ']';

		}).always(function ()
		{
			remove_spinner();

			if ( msg ) {
				$( '.epkb-help_box__search-box' ).hide();
				$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
				$( '#epkb-help_box__search_results-cat-article-details' ).addClass('epkb-help_box__search_step_active');
				$( '#epkb-help_box__search_results-cat-article-details' ).html( msg );

				show_back();
			}

		});
	});


	/********************************************************************
	 *                      Search Box
	 ********************************************************************/
	$( 'body' ).on( 'input', '#epkb-help_box__search-terms', function() {
		let $term = $( this ).val();
		if ( $term.length >= 3 ) {  // will cause search to be invoked by this
			help_box_live_search( $( this ), 500 );
		}
	});


	// cleanup search if search keywords deleted or length < 3
	$("#epkb-help_box__search-terms").keyup(function (event) {
		if (!$( this ).val() || $( this ).val().length < 3) {
			$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
			$( '#epkb-help_box__cat' ).addClass('epkb-help_box__search_step_active');

		}
	});

	function help_box_live_search( $input, $delay ) {
		let $this_input = $input,
			$search_value = $this_input.val(),
			$kb_id = $this_input.data( 'kb-id' );

		setTimeout( function(){
			if ( $search_value === $this_input.val() ) {
				var postData = {
					action: 'epkb_help_box_search_kb',
					search_terms: $search_value,
				};
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: ajaxurl,
					data: postData,
					beforeSend: function (data) {
						add_spinner();
					}
				}).done(function (response)
				{
					response = ( response ? response : '' );

					remove_spinner();

					if ( response.error || response.status !== 'success') {
						//noinspection JSUnresolvedVariable
						msg = epkb_vars.msg_try_again;
					} else {
						msg = response.search_result;
					}

				}).fail(function (response, textStatus, error)
				{
					//noinspection JSUnresolvedVariable
					msg = epkb_vars.msg_try_again + '. [' + ( error ? error : epkb_vars.unknown_error ) + ']';

				}).always(function ()
				{
					remove_spinner();

					if ( msg ) {

						$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
						$( '#epkb-help_box__search_results' ).addClass('epkb-help_box__search_step_active');
						$( '#epkb-help_box__search_results' ).html( msg );

						show_logo();
					}

				});
			}
		}, $delay );
	}

	/********************************************************************
	 *                      Help Box Toggle
	 ********************************************************************/
	$(".eckb-help-box-toggle").on('click', function(){

		var $icon = $(this).find('i');
		//If Parameter Icon exists
		if( $icon.hasClass( 'epkbfa-comments-o' ) ){

			if( ! $( '.epkb-help_box_categories' ).length && $( '.eckb-help_box__search' ).length ) {
				load_category();
			}

			$icon.removeClass( 'epkbfa-comments-o' );
			$icon.addClass( 'epkbfa-close' );

			// HIDE/SHOW Required div

			if( $( '.eckb-help_box__search' ).length ) {
				$( '.eckb-help_box__search' ).show();
				$( '.eckb-help_box__contact' ).hide();
				$( '.eckb-help_box__header-button-contact' ).show();
				$( '.eckb-help_box__header-button-search' ).hide();
				$( '.eckb-help_box__header_faq__title' ).show();
				$( '.eckb-help_box__header_contact__title' ).hide();

			}
			else {
				$( '.eckb-help_box__contact' ).show();
				$( '.eckb-help_box__header-button-contact' ).hide();
				$( '.eckb-help_box__header_faq__title' ).hide();
				$( '.eckb-help_box__header_contact__title' ).show();
			}

			$( '.epkb-help_box__search-box' ).show();
			$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
			$( '#epkb-help_box__cat' ).addClass('epkb-help_box__search_step_active');

			$('#eckb-help-box').show();
			show_logo();

		} else {
			$icon.removeClass( 'epkbfa-close' );
			$icon.addClass( 'epkbfa-comments-o' );
			$('#eckb-help-box').hide();

		}
	});

	function add_spinner( contact = false ) {
		if ( contact ) {
			$('#epkb-help_box__contact-box-container').addClass('epkb-help_box__loading');
		}
		else {
			$( '.epkb-help_box__search_results_container' ).addClass( 'epkb-help_box__loading' );
		}
		$( '.eckb-help_box__loading-spinner' ).show();
	}

	function remove_spinner( contact = false ) {
		if ( contact ) {
			$( '#epkb-help_box__contact-box-container' ).removeClass( 'epkb-help_box__loading' );
		}
		else {
			$('.epkb-help_box__search_results_container').removeClass('epkb-help_box__loading');

		}

		$( '.eckb-help_box__loading-spinner' ).hide();
	}

	/********************************************************************
	 *                      Help Box Header Events
	 ********************************************************************/
	$(".eckb-help_box__header-button-contact").on('click', function() {
		$( this ).hide();
		$( '.eckb-help_box__search' ).hide();
		$( '.eckb-help_box__contact' ).show();
		$( '.eckb-help_box__header-button-search' ).show();
		$( '.eckb-help_box__header_faq__title' ).hide();
		$( '.eckb-help_box__header_contact__title' ).show();
		show_logo();

	});

	$(".eckb-help_box__header-button-search").on('click', function() {
		$( this ).hide();
		$( '.eckb-help_box__search' ).show();
		$( '.eckb-help_box__contact' ).hide();
		$( '.epkb-help_box__search-box' ).show();
		$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
		$( '#epkb-help_box__cat' ).addClass('epkb-help_box__search_step_active');
		$( '.eckb-help_box__header-button-contact' ).show();
		$( '.eckb-help_box__header_faq__title' ).show();
		$( '.eckb-help_box__header_contact__title' ).hide();
		show_logo();
	});

	$( ".eckb-help_box__header-back-icon" ).on('click', function() {

		let current = $( '.epkb-help_box__search_step_active' ).data('step');
		let back = ( current - 1 ) == 0 ? 2 : ( current - 1 ); // default active step : 2

		if( current == 4 && $('.epkb-help_box_type_search').length ) {
			back = 1; // Back 1 for search article
		}

		if ( back == 1 || back == 2 ) {
			show_logo();
			$( '.epkb-help_box__search-box' ).show();
		}
		$( '.epkb-help_box__search_step' ).removeClass('epkb-help_box__search_step_active');
		$( '.epkb-help_box__search_step[data-step='+back+']' ).addClass('epkb-help_box__search_step_active');

	});

	function show_back() {
		$( ".eckb-help_box__header-back-icon" ).show();
		$( ".eckb-help_box__header-logo" ).hide();
	}

	function show_logo() {
		$( ".eckb-help_box__header-back-icon" ).hide();
		$( ".eckb-help_box__header-logo" ).show();
	}

	/********************************************************************
	 *                      Contact Box
	 ********************************************************************/

	$(document).on('submit', '#epkb-help_box__contact-form', function(event){
		event.preventDefault();

		if( !jQuery("#eckb-help-box").is(":visible") ){
			return;
		}
		if( !jQuery(".eckb-help_box__contact").is(":visible") ){
			return;
		}
		let $form = $(this);
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: $form.serialize(),
			beforeSend: function (xhr) {
				add_spinner(true);
			}
		}).done(function (response) {
			// success message
			if ( typeof response.success !== 'undefined' && response.success == false ) {
				$('.epkb-help_box__contact-form-response').html( response.data );
			} else if ( typeof response.success !== 'undefined' && response.success == true ) {
				$('.epkb-help_box__contact-form-response').html( response.data );
			} else {
				// something went wrong
				$('.epkb-help_box__contact-form-response').html( epkb_vars.msg_try_again );
			}
		}).fail(function (response, textStatus, error) {
			// something went wrong
			$('.epkb-help_box__contact-form-response').html( epkb_vars.msg_try_again );
		}).always(function () {
			remove_spinner(true);
		});
	});

});