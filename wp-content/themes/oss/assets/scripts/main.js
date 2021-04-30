/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.

  function checkScroll() {
    if ($(window).scrollTop() > 300) {
      $('body').addClass('scrolled--top');
    } else {
      $('body').removeClass('scrolled--top');
    }
  }

  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        $('.menu-toggle').click(function(e) {
          e.preventDefault();
          if ($(this).hasClass('menu-open')) {
            $(this).removeClass('menu-open');
            $('body').removeClass('show--menu');
          } else {
            $(this).addClass('menu-open');
            $('body').addClass('show--menu');
          }
        });

        $('.menu--overlay').click(function(e) {
          e.preventDefault();
          $('.menu-toggle').removeClass('menu-open');
          $('body').removeClass('show--menu');
        });

        $('.call--demo-li > a').click(function(e) {
          e.preventDefault();
          $('#start-now-form').slideDown(250);
          $('html, body').animate({
            scrollTop : 0
          }, 300);
        });

        $('.call-c-modal').click(function(e) {
          e.preventDefault();
          $('#start-now-form').slideDown(250);
          $('html, body').animate({
            scrollTop : 0
          }, 300);
        });

        $('.close--demo-form').click(function(e) {
          e.preventDefault();
          $('#start-now-form').slideUp(250);
        });

        $(document).on('click', '.play--vid', function(e) {
          e.preventDefault();

          $('#video-modal').modal('show');
          $('#video-modal .modal-content').html('<div class="modal-header"><h5 class="modal-title">Loading</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div></div>');

          var data = {
            'action': 'get_video',
            'vid_id': $(this).data('video')
          };

          $.post(ajaxurl, data, function(response) {
            if (response !== '') {
              if (response.indexOf('<div class="no-more-posts"></div>') === -1) {
                $('#video-modal .modal-content').html(response);
              } else {
                $('#video-modal .modal-content').html('<div class="modal-header"><h5 class="modal-title">Error, please try again</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              }
            }
          });
        });

        $(window).on('scroll resize', function() {
          checkScroll();
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
        checkScroll();

        if (window.matchMedia('(min-width: 992px)').matches) {
          new WOW().init();
        }
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page

        $('.carousel').carousel({
          interval : false
        });

        $('#carousel--sol').on('slid.bs.carousel', function () {
          var currentIndex = $('#carousel--sol .carousel-item.active').index();
          $('.nav--sol.active').removeClass('active');
          $('#sol-nav--' + currentIndex).addClass('active');
        });

        $('#carousel--testimonials').on('slid.bs.carousel', function () {
          var currentIndex = $('#carousel--testimonials .carousel-item.active').index();
          $('.nav--testim.active').removeClass('active');
          $('#testim-nav--' + currentIndex).addClass('active');
        });

        $('#carousel--training-videos').on('slid.bs.carousel', function () {
          var currentIndex = $('#carousel--training-videos .carousel-item.active').index();
          $('.nav--train.active').removeClass('active');
          $('#train-nav--' + currentIndex).addClass('active');
        });
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    'page_template_template_product_solutions_php': {
      init: function() {
        var optionsDefault = {
          infiniteLoop: false,
          minSlides: 1,
          maxSlides: 7,
          slideWidth: 150,
          slideMargin: 10,
          prevSelector: $('.previous-bx-slide'),
          nextSelector: $('.next-bx-slide'),
          nextText: '',
          prevText: '',
          pager: false,
          controls: true,
        };

        var prod_slider = $('.bxslider').bxSlider(optionsDefault);

        $('#go-to-slide').on('change', function() {
          prod_slider.goToSlide($(this).val());
          console.log(prod_slider.getCurrentSlide());
          console.log(prod_slider.getSlideCount());
        });

        $('.sol--load').click(function(e) {
          e.preventDefault();
          $('.sol--load.active').removeClass('active');
          $(this).addClass('active');

          $('#main-sol-container').html('<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>');

          var data = {
            'action': 'get_sol',
            'sol_id': $(this).data('sol')
          };

          $.post(ajaxurl, data, function(response) {
            if (response !== '') {
              if (response.indexOf('<div class="no-more-posts"></div>') === -1) {
                $('#main-sol-container').html(response);
              } else {
                $('#main-sol-container').html('<h5 class="error-title">An error has occured while trying to retrieve the content, please try again</h5>');
              }
            } else {
              $('#main-sol-container').html('<h5 class="error-title">An error has occured while trying to retrieve the content, please try again</h5>');
            }
          });
        });

        if (window.show_sol === 0) {
          $('.bxslider li:first-child .sol--load').click();
        } else {
          // $('.sol--load[data-sol="' + window.show_sol + '"]').first().click();
          var controlSol = $('.sol--load[data-sol="' + window.show_sol + '"]').first().get(0);
          controlSol.click();
          if (window.matchMedia('(min-width: 768px)').matches) {
            var controlSolParent = $('.sol--load[data-sol="' + window.show_sol + '"]').first().parent('li');
            var goToSlideNum = Math.floor(($('.bxslider li').index(controlSolParent) + 1)/($('.bx-viewport').width() / 160));
            prod_slider.goToSlide(goToSlideNum);
            setTimeout(function() {
              $('body, html').animate({
                scrollTop : $('#product-solutions').offset().top
              }, 250);
            }, 100);
          }
        }

        $(document).on('click', '.read-more-sol', function(e) {
          e.preventDefault();
          $(this).remove();
          $('.read-more-sol-content').slideDown(300);
        });
      }
    },
    'page_template_template_support_php': {
      init: function() {
        $('.carousel').carousel({
          interval : false
        });

        $('#carousel--training-videos').on('slid.bs.carousel', function () {
          var currentIndex = $('#carousel--training-videos .carousel-item.active').index();
          $('.nav--train.active').removeClass('active');
          $('#train-nav--' + currentIndex).addClass('active');
        });

        $('.faq-header').click(function(e) {
          e.preventDefault();
          $(this).blur();
          if ($(this).hasClass('active')) {
            $(this).siblings('.content--faq-single').slideUp(250);
            $(this).removeClass('active');
          } else {
            $(this).siblings('.content--faq-single').slideDown(250);
            $(this).addClass('active');
          }
        });

        if (window.location.hash && window.matchMedia('(min-width: 992px)').matches) {
          var hash = window.location.hash;
          if ($(hash).length) {
            $(hash + ' > .faq-header').click();
            if (window.matchMedia('(min-width: 992px)').matches) {
              setTimeout(function() {
                $('html, body').scrollTop($(hash).offset().top - 140);
              }, 120);
            }
          }
        }
      }
    },
    'blog': {
      init: function() {

        var posts_page = 2;

        $('.load-more-posts').click(function(e) {
          e.preventDefault();

          $('.load-more-posts-btn-container').hide();
          $('.loading-container').show();

          var data = {
            'action': 'get_posts',
            'posts_page': posts_page,
            'posts_per_page': $(this).data('ppp')
          };

          $.post(ajaxurl, data, function(response) {
            $('.loading-container').hide();
            if (response !== '') {
              $('.all-bp-load-container').append(response);
            }
            if (response.indexOf('<div class="no-more-posts"></div>') === -1) {
              $('.load-more-posts-btn-container').show();
            }
            ++posts_page;
          });
        });
      }
    },
    // About us page, note the change from about-us to about_us.
    'page_template_template_about_php': {
      init: function() {
        $('.read-more-team-link').click(function(e) {
          e.preventDefault();
          $(this).parent().parent().siblings('.team-full-content').slideDown(250);
          $(this).parent().parent().hide();
        });
      }
    },
    'page_template_template_contact_php': {
      init: function() {
        var lat = $('#map-canvas').data('lat');
        var lng = $('#map-canvas').data('lng');
        var pinTitle = $('#map-canvas').data('address');
        var pos = new google.maps.LatLng(lat, lng);
        // var mapStyles = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}];

        var mapOptions = {
          zoom: 14,
          center: pos,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          scrollwheel: true
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var marker = new google.maps.Marker({
          position: pos,
          map: map,
          title: pinTitle
        });

        $(window).resize(function() {
          map.panTo(pos);
        });
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
