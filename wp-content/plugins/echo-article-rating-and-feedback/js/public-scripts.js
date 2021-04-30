jQuery(document).ready(function($) {

	// like = 5 (like) or 0 (dislike)
	// send ajax to change article rating id db
	function update_post_rating(rating_value) {

		var postData = {
            action: 'eprf-update-rating',
			kb_id: eprf_vars.kb_id,
            article_id: $('.kb-article-id').prop('id'),
            rating_value: rating_value,
			_wpnonce_user_rating_action_ajax: eprf_vars.eprf_rating_nonce
        };

		// loader
		 $.ajax({
            type: 'GET',
            dataType: 'json',
            data: postData,
            url: eprf_vars.ajaxurl,
            beforeSend: function (xhr)
            {
				//$('#eprf-current-rating').html($('#eprf-current-rating').data('recording your vote'));
            }

        }).done(function (response) {
			$('#eprf-current-rating').html(response.message);

			// open feedback form if need
			if (rating_value < 5 && $('.eprf-article-feedback-container--trigger-negative-five').length) {
				$(document.body).trigger('open_article_feedback_form');
			}

			if (rating_value < 4 && $('.eprf-article-feedback-container--trigger-negative-four').length) {
				$(document.body).trigger('open_article_feedback_form');
			}

			if (rating_value < 4 && $('.eprf-article-feedback-container--trigger-dislike').length) {
				$(document.body).trigger('open_article_feedback_form');
			}

			if ($('.eprf-stars-container').length) {
				$('.eprf-stars-container').data('average', rating_value).trigger('update_view');
				$('.eprf-stars-container').addClass('disabled');
			}

			// update ratings
			if (response.rating !== undefined) {
				if ($('.eprf-like-dislike-module__buttons').length && response.rating.statistic) {
					$('.eprf-like-count').text(response.rating.statistic.like);
					$('.eprf-dislike-count').text(response.rating.statistic.dislike);
				}
			}

			$('body').find('.eprf-stars-container.disabled').css({'cursor':'default'});
			$('.epkbfa-star').click(false);

			$('body').find('.eprf-like-dislike-module__buttons .eprf-rate-like, .eprf-like-dislike-module__buttons .eprf-rate-dislike').css({'cursor':'default'});
			$('body').find('.eprf-like-dislike-module__buttons .eprf-rate-like, .eprf-like-dislike-module__buttons .eprf-rate-dislike').click(false);
			$('.eprf-like-dislike-module').addClass('eprf-rating--blocked');

        }).fail(function (response, textStatus, error) {
            //noinspection JSUnresolvedVariable
            msg = eprf_vars.msg_try_again + '. [' + ( error ? error : eprf_vars.unknown_error ) + ']';
        });
	}

	// handlers for like/dislike mode
	$('.eprf-like-dislike-module:not(.eprf-rating--blocked) .eprf-rate-like').click(function(){
		if (!$(this).closest('.eprf-like-dislike-module').hasClass('eprf-rating--blocked')) {
			update_post_rating(5);
		}
		return false;
	});

	$('.eprf-like-dislike-module:not(.eprf-rating--blocked) .eprf-rate-dislike').click(function(){
		if (!$(this).closest('.eprf-like-dislike-module').hasClass('eprf-rating--blocked')) {
			update_post_rating(1);
		}
		return false;
	});

	function showStatistics() {
		var stars = $('.eprf-stars-container');

		var stars_top; // relative position of the bottom-middle point of the stars block
		var stars_left; // relative position of the bottom-middle point of the stars block

		stars_top = stars.position().top + stars.height();
		stars_left = stars.position().left + stars.width()/2;

		var statistisc = $('.eprf-stars-module .eprf-stars-module__statistics');

		statistisc.css({
			'left' : (stars_left - statistisc.width()/2) + 'px',
			'top' : (stars_top + 5) + 'px'
		});
	}

	$(document.body).on('click', '.eprf-show-statistics-toggle', showStatistics);
	$(document.body).on('click', '.eprf-show-statistics-toggle', function(){
		let element = $('.eprf-stars-module .eprf-stars-module__statistics');
		element.toggle();
		if ( $(element).is(":visible") ) {
			eprfHideOnClickOutside(element.selector);
		}
	});

	// Toggle Meta Statistics for stars.
	$(document.body).on('click', '.eprf-article-meta__statistics-toggle', function(){
		let element = $( this ).parent().find( '.eprf-article-meta__statistics' );
		element.toggle();
		if ( $(element).is(":visible") ) {
			eprfHideOnClickOutside(element.selector);
		}
	});

	// open form trigger
	$(document.body).on('open_article_feedback_form', function(){
		if ($('.eprf-article-feedback-container--trigger-negative-four').length) {
			$('.eprf-article-feedback-container--trigger-negative-four').slideDown();
		} else if ($('.eprf-article-feedback-container--trigger-negative-five').length) {
			$('.eprf-article-feedback-container--trigger-negative-five').slideDown();
		} else if ($('.eprf-article-feedback-container--trigger-dislike').length) {
			$('.eprf-article-feedback-container--trigger-dislike').slideDown();
		} else {
			$('.eprf-form-row').slideDown();
		}

		$('#eprf-article-feedback-container button').text($('#eprf-article-feedback-container button').data('submit_text')).addClass('openned');
	});

	// trigger 'Button "Send Feedback"'
	$(document.body).on('click', '.eprf-trigger-button button', function(){
		if (!$(this).hasClass('openned')) {
			$(document.body).trigger('open_article_feedback_form');
			return false;
		}
	});

	// send feedback form
	$('.eprf-leave-feedback-form').submit(function(){
		var postData = {
            action: 'eprf-add-comment',
			kb_id: eprf_vars.kb_id,
            article_id: $('.kb-article-id').prop('id'),
			_wpnonce_user_comment_action_ajax: eprf_feedback_nonce,
			name: '',
			email: '',
			comment: ''
        };

		if($('#eprf-form-name').length) postData.name = $('#eprf-form-name').val();
		if($('#eprf-form-email').length) postData.email = $('#eprf-form-email').val();
		if($('#eprf-form-text').length) postData.comment = $('#eprf-form-text').val();

		// loader
		 $.ajax({
            type: 'GET',
            dataType: 'json',
            data: postData,
            url: eprf_vars.ajaxurl,
            beforeSend: function (xhr)
            {
				$('#eprf-current-rating').html( '<div class="eprf-article-buttons__feedback-confirmation__loading"><div class="eprf-article-buttons__feedback-confirmation__loading__icon epkbfa epkbfa-spinner"></div> '+$('#eprf-current-rating').data('loading') + '</div>' );
            }

        }).done(function (response) {
			$('#eprf-current-rating').html(response.message);
			$('#eprf-article-feedback-container').slideUp();
        }).fail(function (response, textStatus, error) {
            //noinspection JSUnresolvedVariable
            msg = eprf_vars.msg_try_again + '. [' + ( error ? error : eprf_vars.unknown_error ) + ']';
        });
		return false;
	});

	// flex stars
	function redraw_stars($el, val) {
		$el.find('.eprf-stars__top-lay').hide();

		$el.find('.eprf-stars__inner-background .epkbfa').removeClass('epkbfa-star').removeClass('epkbfa-star-o').removeClass('epkbfa-star-half-o');

		$i = 0;
		$el.find('.eprf-stars__inner-background .epkbfa').each(function(){
			if (val >= $i+1) {
				$(this).addClass('epkbfa-star').removeClass('epkbfa-star-o').removeClass('epkbfa-star-half-o');
			} else if (val >= $i+0.5) {
				$(this).removeClass('epkbfa-star').removeClass('epkbfa-star-o').addClass('epkbfa-star-half-o');
			} else {
				$(this).removeClass('epkbfa-star').addClass('epkbfa-star-o').removeClass('epkbfa-star-half-o');
			}
			$i++;
		});
	}

	$(document.body).on('update_view mouseout', '.eprf-stars-container', function(e){
		if (!$(this).hasClass('disabled')) {
			var percentX = $(this).data('average');
			redraw_stars($(this), percentX)
		}
	});

	$(document.body).on('mousemove', '.eprf-stars-container', function(e){
		if (!$(this).hasClass('disabled') && $(this).closest('.eprf-rating--blocked').length == 0) {
			var percentX = Math.round(((e.pageX - $(this).offset().left) / $(this).width()) * 10) / 2;
			redraw_stars($(this), percentX)
		}
	});

	$(document.body).on('click', '.eprf-stars-container', function(e){
		if (!$(this).hasClass('disabled') && $(this).closest('.eprf-rating--blocked').length == 0) {
			var percentX = Math.round(((e.pageX - $(this).offset().left) / $(this).width()) * 10) / 2;
			$(this).data('average', percentX).trigger('update_view');
			update_post_rating(percentX);
		}
	});


	if ($('.eprf-stars-container').length) {
		$('.eprf-stars-container').trigger('update_view');
	}

	// hide dialog/popup after user clicks outside of it
	function eprfHideOnClickOutside(selector) {
		const outsideClickListener = (event) => {
			$target = $(event.target);
			if (!$target.closest(selector).length && ! $target.context.className.endsWith('statistics-toggle') && $(selector).is(':visible')) {
				$(selector).hide();
				removeClickListener();
			}
		};

		const removeClickListener = () => {
			document.removeEventListener('click', outsideClickListener)
		};

		document.addEventListener('click', outsideClickListener)
	}
});
