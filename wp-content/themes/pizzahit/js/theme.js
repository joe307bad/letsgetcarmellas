"use strict";
var myWindow = jQuery(window);

jQuery(function() {

	function gt3_initPieChart() {
		if (jQuery('.module_diagramm').length) {
			jQuery('.chart').each(function(){
				jQuery(this).css({'font-size' : jQuery(this).parents('.skills_list').attr('data-fontsize'), 'line-height' : jQuery(this).parents('.skills_list').attr('data-size')});
				jQuery(this).find('span').css('font-size' , jQuery(this).parents('.skills_list').attr('data-fontsize'));
			});

			if (jQuery(window).width() > 760) {
				var waypoint = new Waypoint({
				  element: document.getElementsByClassName('skill_li'),
				  handler: function(direction) {},
				  offset: 'bottom-in-view'
				});
				waypoint.context.refresh();
				jQuery('.skill_li').waypoint(function(){						
					jQuery('.chart').each(function(){
						jQuery(this).easyPieChart({
							barColor: jQuery(this).parents('ul.skills_list').attr('data-color'),
							trackColor: jQuery(this).parents('ul.skills_list').attr('data-bg'),
							scaleColor: false,
							lineCap: 'square',
							lineWidth: parseInt(jQuery(this).parents('ul.skills_list').attr('data-width')),
							size: parseInt(jQuery(this).parents('ul.skills_list').attr('data-size')),
							animate: 3000
						});
					});
				},{offset: 'bottom-in-view'});
			} else {
				jQuery('.chart').each(function(){
					jQuery(this).easyPieChart({
						barColor: jQuery(this).parents('ul.skills_list').attr('data-color'),
						trackColor: jQuery(this).parents('ul.skills_list').attr('data-bg'),
						scaleColor: false,
						lineCap: 'square',
						lineWidth: parseInt(jQuery(this).parents('ul.skills_list').attr('data-width')),
						size: parseInt(jQuery(this).parents('ul.skills_list').attr('data-size')),
						animate: 3000
					});
				});
			}
		}
	}

	function gt3_initCounter() {
		if (jQuery('.module_counter').length) {
			if (myWindow.width() > 760) {		
				var waypoint = new Waypoint({
				  element: document.getElementsByClassName('shortcode_counter'),
				  handler: function(direction) {},
				  offset: 'bottom-in-view'
				});
				waypoint.context.refresh();

				jQuery('.shortcode_counter').each(function(){	
					if (jQuery(this).offset().top < myWindow.height()) {
						if (!jQuery(this).hasClass('done')) {
							var set_count = jQuery(this).find('.stat_count').attr('data-count');
							jQuery(this).find('.stat_temp').stop().animate({width: set_count}, {duration: 3000, step: function(now) {
									var data = Math.floor(now);
									jQuery(this).parents('.counter_wrapper').find('.stat_count').html(data);
								}
							});	
							jQuery(this).addClass('done');
							jQuery(this).find('.stat_count');
						}							
					} else {
						var cur_this = jQuery(this);
						jQuery(this).waypoint(function(){
							if (!cur_this.hasClass('done')) {
								var set_count = cur_this.find('.stat_count').attr('data-count');
								cur_this.find('.stat_temp').animate({width: set_count}, {duration: 3000, step: function(now) {
										var data = Math.floor(now);
										jQuery(this).parents('.counter_wrapper').find('.stat_count').html(data);
								}
								});	
								cur_this.addClass('done');
								cur_this.find('.stat_count');
							}
						},{offset: 'bottom-in-view'});								
					}														
				});
			} else {
				jQuery('.shortcode_counter').each(function(){							
					var set_count = jQuery(this).find('.stat_count').attr('data-count');
					jQuery(this).find('.stat_temp').animate({width: set_count}, {duration: 3000, step: function(now) {
							var data = Math.floor(now);
							jQuery(this).parents('.counter_wrapper').find('.stat_count').html(data);
					}
					});
					jQuery(this).find('.stat_count');
				},{offset: 'bottom-in-view'});	
			}
		}
	}

	function gt3_SetFullwidthContainer() {
		if (jQuery('.fullwidth_mode').length) {

			if (jQuery('div').hasClass('right-sidebar') || jQuery('div').hasClass('left-sidebar')) {} else {
				jQuery('.fullwidth_mode').css('margin-left', '').
																			 css('margin-right', '').
																			 css('width', '').
																			 css('padding-left', '').
																			 css('padding-right', '');
				var w_width = jQuery(window).width();
				var cont_width = jQuery('.fullwidth_mode').innerWidth();
				var diff_w = w_width - cont_width;

				jQuery('.fullwidth_mode').css('margin-left', '-' + diff_w / 2 + 'px').
																			 css('margin-right', '-' + diff_w / 2 + 'px').
																			 css('width', w_width + 'px').
																			 css('padding-left', '0px').
																			 css('padding-right', '0px');
			}
		}
	}

	function gt3_setSmartCellContentHeight() {
		jQuery('.fullwidth_mode').each(function(){
			var fullwidth_mode = jQuery(this);
			fullwidth_mode.find('.col-xs-12 > .module_wrapper').css('padding-top', '').css('padding-bottom', '');
			fullwidth_mode.find('.fw_wrapinner .row > div').css('height', '');
			var max_height = Math.max.apply(null, fullwidth_mode.find('.fw_wrapinner .row > div').map(function(){ return jQuery(this).height(); }));
			var max_height_wo_images = Math.max.apply(null, fullwidth_mode.find('.fw_wrapinner .row > div').map(function(){ if (!jQuery(this).find('.single_image').length) return jQuery(this).height(); else return 0; }));
			if (max_height - max_height_wo_images > 100 && max_height_wo_images) max_height = max_height_wo_images + 150; else max_height = max_height + 150;
			if (jQuery(window).width() > 768)
				fullwidth_mode.find('.fw_wrapinner .row > div').css('height', max_height);
			fullwidth_mode.find('.fw_wrapinner .row > div.module_single_image').each(function(){
				var bg_img = jQuery(this).find('.single_image > img').attr('src');
				jQuery(this).find('.single_image > img').detach();
				var cur_div = jQuery(this);
				if (bg_img !== undefined) {
					cur_div.css('background', 'url(' + bg_img + ') center center no-repeat').css('background-size', 'cover');	
				}
			});
			fullwidth_mode.find('.fw_wrapinner .row > div').each(function() {
				var padding = (max_height - jQuery(this).find('.module_wrapper').outerHeight())/2;
				if (jQuery(window).width() <= 768 && padding > 100) padding = 100;
				jQuery(this).find('.module_wrapper').css('padding-top', padding)
																						.css('padding-bottom', padding);
			});
		});
	}

	function setBackgroundedImages() {
		jQuery('.background.module_single_image').each(function() {
			var this_module = jQuery(this);

			if (jQuery(window).width() >768) {
				this_module.children('.module_wrapper').css('height', '').css('height', this_module.parent().height()).css('background-image', 'url(' + this_module.find('img').attr('src') + ')');	
			} else {
				this_module.children('.module_wrapper').css('height', 'auto').css('background-image', 'url(' + this_module.find('img').attr('src') + ')');	
			}
			
		});
	}

	function gt3_getVideoContainer(url) {
		var iframe = '',
			youtubeUrl = url.match( /((?:www\.)?youtube\.com|(?:www\.)?youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/ ),
			youtubeShortUrl = url.match(/(?:www\.)?youtu\.be\/([a-zA-Z0-9\-_]+)/),
			vimeoUrl = url.match( /(?:www\.)?vimeo\.com\/([0-9]*)/ );
		if ( youtubeUrl || youtubeShortUrl) {
			if ( youtubeShortUrl ) {
				youtubeUrl = youtubeShortUrl;
			}
			iframe = '<iframe width="100%" height="100%" src="//' + youtubeUrl[1] + '/embed/' + youtubeUrl[2] + '?' + '" allowfullscreen></iframe>';

		} else if ( vimeoUrl ) {
			iframe = '<iframe width="100%" height="100%"  src="//player.vimeo.com/video/' + vimeoUrl[1] + '?' + '" allowFullScreen></iframe>';

		} else {
			iframe = '<iframe width="100%" height="100%" src="' + url + '" allowfullscreen></iframe>';
		}

		return iframe;
	}

	function gt3_getVideo() {
		if (jQuery('.slider_video').length) {
			jQuery('.slider_video').each(function(){
				jQuery(this).html(gt3_getVideoContainer(jQuery(this).attr('data-href')));
			});
		}
	}

	jQuery('.mobile-navigation-toggle').on('click', function(){
		jQuery('.menu_mobile').slideToggle(300);
	});

	if (jQuery('.menu-item-has-children').length) {
		jQuery('.menu-item-has-children').each(function(){
			jQuery(this).find('a').first().after('<span class="toggler_el"></span>');
		});
	}

	jQuery('.toggler_el').on('click', function () {
		jQuery(this).next().slideToggle(300).prev().toggleClass('menu_item_open').parent().toggleClass('opened');
	});

	function gt3_Set404Height() {
		jQuery('.error_404').css('padding-top', '').css('padding-bottom', '');
		var header_h = jQuery('header.gt3_header_type_45').height(),
				footer_h = jQuery('footer').height(),
				cont_h = jQuery('.error_404').outerHeight(),
				window_h = jQuery(window).height(),
				delta = window_h - header_h - footer_h - cont_h - jQuery('#wpadminbar').height();

		if (delta > 0) {
			jQuery('.error_404').css('padding-top', delta / 2).css('padding-bottom', delta / 2 + 45);
		}
		
	}

	function gt3_SetFooterPaddings() {
		if (!jQuery('.error_404').length) {
			jQuery('footer').css('margin-top', '');
			var header_h = jQuery('header').height(),
					footer_h = jQuery('footer').height(),
					cont_h = jQuery('.wrapper > .container').height(),
					window_h = jQuery(window).height(),
					delta = window_h - header_h - footer_h - cont_h - jQuery('#wpadminbar').height();

			if (delta > 0) jQuery('footer').css('margin-top', delta);
		} 
		
	}

	function gt3_initModulesParameters() {
		if (jQuery(window).width() <=991 && jQuery('.sticky_on').length) jQuery('.sticky_on').removeClass('sticky_on').addClass('sticky_is_present');
    if (jQuery(window).width() > 991 && jQuery('.sticky_is_present').length) jQuery('header').addClass('sticky_on').removeClass('sticky_is_present');
		
		gt3_initPieChart();
		gt3_initCounter();
		gt3_SetFullwidthContainer();
		setTimeout(gt3_setSmartCellContentHeight, 500);
		setTimeout(gt3_setSmartCellContentHeight, 1000);
		gt3_SetFooterPaddings();
		jQuery(window).load(function(){
			gt3_setSmartCellContentHeight();
			gt3_Set404Height();
		});
		gt3_getVideo();
		setTimeout(setBackgroundedImages, 500);
		setTimeout(setBackgroundedImages, 1500);
		setTimeout(setModuleContentHeight, 500);
		setTimeout(setModuleDishesPaddings, 500);
		setTimeout(setModuleSliderHeight, 500);
		jQuery(".input-half-container select").trigger('refresh');

		if (jQuery('.blog_listing_item.video').length) {
			jQuery('.blog_listing_item.video').each(function() {
				jQuery(this).find('iframe').css('height', jQuery(this).find('iframe').width() / 1.75 + 'px' );
			});
		}
		if (jQuery('.blog_listing_item.image .slider_wrapper').length) {
			jQuery('.blog_listing_item.image .slider_wrapper').each(function() {
				jQuery(this).css('height', jQuery(this).width() / 1.38 + 'px' );
			});
		}

	}

	//	Video background
	function gt3_video_background() {
		jQuery('.video_bg').each(function () {
			jQuery(this).find('iframe').css({'height': jQuery(this).height() + 'px'});
		});
	}

	// Video background
	if (jQuery('.video_bg').length) {
		jQuery('.play-video').on('click', function(ev) {

			jQuery('.video_bg').each(function() {
				jQuery(this).find('.video_frame').attr('src', jQuery(this).find('.play-video').attr('data-video-url'));
			});

			jQuery('.video_bg img, .video_bg .play-video, .video_bg .video_mask').show();
			jQuery('.video_bg iframe').hide();

			jQuery(this).parent().find(".video_frame")[0].src += "&autoplay=1";
			ev.preventDefault();

			gt3_video_background();
			jQuery(this).parent().find('img').hide();
			jQuery(this).parent().find('iframe').show();
			jQuery(this).parent().find('.play-video').fadeOut();
			jQuery(this).parent().find('.video_mask').fadeOut();

		});
	}

	function setModuleContentHeight() {
		if (jQuery(window).width() > 768) {
			jQuery('.module_team .item').map(function(){
				var item = jQuery(this);
				item.find('.team_content').css('padding-top', '');

				var img_height = item.find('.img_block.team_img').height(),
						descr_height = item.find('.team_content').height();

				if (img_height > descr_height) {
					item.find('.team_content').css('padding-top', (img_height - descr_height)/2);
				}
			});
		}
	}

	// Team
	if (jQuery('.module_team').length) {
		var sl = parseInt(jQuery('.module_team .item_list').attr('data-count')),
				is_vertical = jQuery('.module_team .item_list').attr('data-vertical');			

		if (is_vertical == 'yes') is_vertical = true; else is_vertical = false;
		jQuery('.module_team .item_list').slick({
			slidesToShow: sl,
			slidesToScroll: sl,
			vertical: is_vertical, 
			autoplay: true,
			autoplaySpeed: 4000,
			arrows: false,
			speed: 500,
			dots: true,
			focusOnSelect: true,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		});
		// Team description to center
		setModuleContentHeight();
	}

	// Testimonials
	if (jQuery('.testimonial_wrapper').length) {
		// Info
		jQuery('.testimonials-info').slick({
			fade: true,
			arrows: false,
			dots: false,
			asNavFor: '.testimonials-nav',
			adaptiveHeight: true
		});
		// Navigation
		jQuery('.testimonials-nav').slick({
			slidesToShow: 1,
			asNavFor: '.testimonials-info',
			centerMode: true,
			centerPadding: 0,
			focusOnSelect: true,
			autoplay: true,
			autoplaySpeed: 4000,
			speed: 600,
			arrows: false,
			dots: false,
			variableWidth: true,
			infinite: true
		});
	}

	// Testimonials
	if (jQuery('.module_dishes').length) {
		jQuery('.module_dishes').each(function(i) {
			jQuery(this).find('.col-xs-12.text').find('.dish_counter').text(i + 1);
		})
	}

	// slider
	function setModuleSliderHeight() {
		jQuery('.gallery-slider.slider .slide-wrap').css('height', '');
		jQuery('.gallery-slider.slider .slide-wrap').css('height', 
			Math.max.apply(null, jQuery('.gallery-slider.slider .slide-wrap').map(function(){ 
				return jQuery(this).height(); 
			})));
	}

	if (jQuery('.gallery-slider.slider').length) {
		jQuery('.gallery-slider.slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: false,
			autoplaySpeed: 4000,
			arrows: false,
			speed: 500,
			dots: true,
			focusOnSelect: true,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 1
					}
				}
			]
		});
		// Team description to center
		setModuleSliderHeight();
	}

	// Disable scroll zooming and bind back the click event
  var onMapMouseleaveHandler = function (event) {
    var that = jQuery(this);

    that.on('click', onMapClickHandler);
    that.off('mouseleave', onMapMouseleaveHandler);
    that.find('iframe').css("pointer-events", "none");
  }

  var onMapClickHandler = function (event) {
    var that = jQuery(this);

    // Disable the click handler until the user leaves the map area
    that.off('click', onMapClickHandler);

    // Enable scrolling zoom
    that.find('iframe').css("pointer-events", "auto");

    // Handle the mouse leave event
    that.on('mouseleave', onMapMouseleaveHandler);
  }

  // Enable map zooming with mouse scroll when the user clicks the map
  jQuery('.module_google_map').on('click', onMapClickHandler);

	function setModuleDishesPaddings() {
		jQuery('.module_dishes .col-xs-12').css('height', '');
		jQuery('.module_dishes .col-xs-12.text').each(function(){
			var obj = jQuery(this),
					h = obj.outerHeight();
			obj.siblings('.col-xs-12.col-sm-6').css('height', h + 'px');
		});
	}

	jQuery('.sidepanel .search_form input[type="submit"]').wrap("<div class='submit_wrap'></div>");
	jQuery('.sidepanel .search_form .submit_wrap').on({
	    mouseenter: function(){
	        jQuery('input[name="s"]').addClass('hover');
	    },
	    mouseleave: function(){
	        jQuery('input[name="s"]').removeClass('hover');
	    }
	});

	// prevent default empty links
	jQuery('a[href="#"]').on('click', function(e) {	e.preventDefault();	});
	jQuery(".input-half-container select").selectBox();

	gt3_initModulesParameters();


	jQuery(window).on('resize', function() {
		gt3_initModulesParameters();
		gt3_setSmartCellContentHeight();
		jQuery('header.gt3_header_type_45').css('opacity', '1').css('visibility', 'visible');
		jQuery('header.fixed_header').css('opacity', '').css('visibility', '');
	});

	// revolution slider
	if (jQuery('.rev_slider_presents').length) {
		jQuery('header').addClass('with_slider');
	}

	//Page Scrolling
	jQuery('.header_img').height(jQuery('header').height());

	if (jQuery('.rev_slider_presents').length) {
		jQuery('header').addClass('with_slider');
	}

  jQuery('.gt3_js_bg_url').each(function(){
  	var background_url = jQuery(this).attr('data-background');
  		jQuery(this).css('background', 'url("' + background_url + '") no-repeat center');
  });

	// preloader
	function preImg(imgArray) {
    if (imgArray.length) {
      for (var i = 0; i < imgArray.length; i++) {
        (function (img, src) {
          img.onload = function () {};
          img.src = src;
        } (new Image(), imgArray[i]));
  		}
  		if (!jQuery('.preloader_overlay').hasClass('demo')) {
  			setTimeout(function(){gt3_removePreloader()}, 1000);
  			setTimeout(function(){jQuery('.preloader_overlay').css('display', 'none')}, 2000);
  		} else {
  			setTimeout(function(){gt3_removePreloader()}, 1500);
  			setTimeout(function(){jQuery('.preloader_overlay').css('display', 'none')}, 2500);
  		}
  		
    } else {
      if (!jQuery('.preloader_overlay').hasClass('demo')) {
      	setTimeout(function(){gt3_removePreloader()}, 1000);
      	setTimeout(function(){jQuery('.preloader_overlay').css('display', 'none')}, 2000);
      } else {
      	setTimeout(function(){gt3_removePreloader()}, 1500);
      	setTimeout(function(){jQuery('.preloader_overlay').css('display', 'none')}, 2500);
      }
    }
	}

	function gt3_removePreloader() {
		jQuery('.preloader_overlay').css('opacity', '0');
	}

	var fsImg=[];
	jQuery('img').map(function() {fsImg.push(jQuery(this).attr('src')); });

	if (jQuery('.preloader_overlay').length) {
		preImg(fsImg);
	} else preImg([]);

	// swipebox
	if(jQuery('.swipebox').size() > 0) {
		jQuery('html').addClass('gt3_swipe_box');
		jQuery('.swipebox').swipebox();	
	}

	jQuery(document).on("click", "#swipebox-container .slide.current img", function (e) { 
	  jQuery('#swipebox-next').trigger('click');
	  e.stopPropagation();
	});

	jQuery(document).on("click", "#swipebox-container", function (e) {
	  jQuery('#swipebox-close').trigger('click');
	});
	jQuery('.view_link.link').on('click', function(e){
		if (jQuery(this).find('.prev_button').length) {
			e.preventDefault();
			jQuery(this).css('cursor', 'default');
		}
	});

	// make fixed header
	jQuery('header.fixed_header > .container > .row .header_main_line').html(jQuery('header.gt3_header_type_45 .header_main_line').html());

	jQuery('.fixed_header').css('top', jQuery('#wpadminbar').height());

	var topOfWindow = jQuery(window).scrollTop();
	if (jQuery('.sticky_on').length && topOfWindow >= (jQuery('.gt3_header_type_45 .head_block').outerHeight() + jQuery('#wpadminbar').height() - 80)) {
		jQuery('header.gt3_header_type_45').css('opacity', '0').css('visibility', 'hidden');
		jQuery('header.fixed_header').css('opacity', '1').css('visibility', 'visible');
	}

	jQuery(window).on ('scroll', function() {
		var topOfWindow = jQuery(window).scrollTop();
		if (jQuery('.sticky_on').length && topOfWindow >= (jQuery('.gt3_header_type_45 .head_block').outerHeight() + jQuery('#wpadminbar').height() - 80)) {
			jQuery('header.gt3_header_type_45').css('opacity', '0').css('visibility', 'hidden');
			jQuery('header.fixed_header').css('opacity', '1').css('visibility', 'visible');
		}
		if (jQuery('.sticky_on').length && topOfWindow < (jQuery('.gt3_header_type_45 .head_block').outerHeight() + jQuery('#wpadminbar').height() - 60)) {
			jQuery('header.gt3_header_type_45').css('opacity', '1').css('visibility', 'visible');
			jQuery('header.fixed_header').css('opacity', '').css('visibility', '');
		}
	});

	jQuery('.contactform7_type #mc_mv_EMAIL').attr('placeholder', 'Enter Your Email');
});

function next_slide() {
    var slider = jQuery('.slider_listing'),
        slider_item = jQuery(slider).find('li'),
        current_slide = jQuery(slider).find('.current_slide'),
        current_slide_num = jQuery(current_slide).attr('data-number'),
        slides = jQuery(slider).children(),
        slider_count = slides.length;

    if (current_slide_num < slider_count) {
        jQuery(current_slide).removeClass('current_slide').next().addClass('current_slide');
    } else {
        jQuery(current_slide).removeClass('current_slide');
        jQuery(slider_item).first().addClass('current_slide');
    }
}

function prev_slide() {
    var slider = jQuery('.slider_listing'),
        slider_item = jQuery(slider).find('li'),
        current_slide = jQuery(slider).find('.current_slide'),
        current_slide_num = jQuery(current_slide).attr('data-number');

    if (current_slide_num == '1') {
        jQuery(current_slide).removeClass('current_slide');
        jQuery(slider_item).last().addClass('current_slide');
    } else {
        jQuery(current_slide).removeClass('current_slide').prev().addClass('current_slide');
    }
}

function video_size() {
  jQuery('.pf_output_container').each(function(){
      jQuery(this).find('iframe').css({'height': jQuery(this).width()*9/16 + 'px'});
  });
}

jQuery(document).ready(function($) {
    video_size();
});

jQuery(window).resize(function () {
    video_size();
});

jQuery(document).ready(function() {
	var slider_box = jQuery('.slider_wrapper');

	var slider_box = jQuery('.slider_wrapper'),
	    page_type = slider_box.attr('data-type'),
	    slider_height = slider_box.attr('data-height'),
	    slider = jQuery('.slider_listing'),
	    slider_item = jQuery(slider).find('li'),
	    intervalID;
	if (page_type == 'type_1') {
	    slider_box.height(slider_height+ 'px');
	} else {
	    slider_box.css('height', '100%');
	}

	jQuery(slider_item).first().addClass('current_slide');

	// Next Slide
	jQuery('.next_button').on('click', function(e){
	    next_slide();
	});

	// Prev Slide
	jQuery('.prev_button').on('click', function(e){
	    prev_slide();
	});

	// Autoplay
	intervalID = setInterval(next_slide, 4000);

	jQuery(slider_box).on({
	    mouseenter: function(){
	        clearInterval(intervalID);
	    },
	    mouseleave: function(){
	        intervalID = setInterval(next_slide, 4000);
	    }
	});

});