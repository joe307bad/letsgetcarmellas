"use strict";

var menu_type;

jQuery(document).ready(function() {

	var window_w = jQuery(window).width();

	jQuery('.gt3_side_menu_trigger').on("click", function(){
		jQuery(this).toggleClass('active');
	});
	jQuery('.gt3_side_menu_trigger').on("click", function(){
		jQuery('html').toggleClass('active_sidemenu');
	});

    // Nav Menu Widget
    jQuery('.widget_nav_menu .menu-item-has-children a').on('click', function(){
        jQuery(this).toggleClass('open_item').next().slideToggle(300);
    });

	if (window_w <= 991) {
		menu_type = 'mobile';
	} else {
		menu_type = 'fullwidth';
	}
	
	jQuery('.top_button_circle').on('click', function(){
		jQuery("html:not(:animated), body:not(:animated)").animate({ scrollTop: 0}, 300 );
		return false;
	});

	jQuery('.top_button_square').on('click', function(){
		jQuery("html:not(:animated), body:not(:animated)").animate({ scrollTop: 0}, 300 );
		return false;
	});
});

jQuery(window).resize(function(){
	var window_width = jQuery(window).width();
	if (window_width <=991 && menu_type == 'fullwidth') {
		jQuery('body').css('overflow', 'hidden');
		jQuery('header').css('top', '0');
		menu_type = 'mobile';
	} else if (window_width > 991 && menu_type == 'mobile') {
		jQuery('.menu_mobile').css('display', '');
		jQuery('body').css('overflow', '');
		menu_type = 'fullwidth';
	}
});

jQuery(window).load(function(){
    var window_width = jQuery(window).width(),
        window_height = jQuery(window).height();

    // Parallax
    if (window_width > 1025 && jQuery('.paralax').size() > 0) {
        var $window = jQuery(window);
        jQuery('.paralax').each(function () {
            var $bgobj = jQuery(this); // assigning the object
            jQuery(window).on('scroll', function () {
                var yPos = ($bgobj.offset().top - $window.scrollTop()) / 2;
                var coords = '50% ' + yPos + 'px';
                $bgobj.css({'background-position': coords});
            });
        });
    }

    jQuery('.single-post .share_cont').on({
        mouseenter: function() {
            jQuery(this).addClass('opened');
        },

        mouseleave: function() {
            jQuery(this).removeClass('opened');
        }
    });

	jQuery('.menu a[href="#"]').on('click', function(e){
		e.preventDefault();
	});

    if (window_width < 768) {
        jQuery('.slider_wrapper').css('height', window_height);
    }

    jQuery('.isotope').isotope({
        layoutMode: 'fitRows'
    });

});

jQuery(window).resize(function(){
    var window_width = jQuery(window).width(),
        window_height = jQuery(window).height();

    if (window_width < 768) {
        jQuery('.slider_wrapper').css('height', window_height);
    }
});