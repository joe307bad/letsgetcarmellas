;
(function($) {
  "use strict";
  /* SORTING */
  jQuery(function () {
    var $container = jQuery('.sorting_block');

    $container.isotope({
      itemSelector: '.element'
    });

    var $optionSets = jQuery('.optionset'),
      $optionLinks = $optionSets.find('a');

    $optionLinks.on("click", function () {
      var $this = jQuery(this);
      // don't proceed if already selected
      if ($this.parent('li').hasClass('selected')) {
        return false;
      }
      var $optionSet = $this.parents('.optionset');
      $optionSet.find('.selected').removeClass('selected');
      $optionSet.find('.fltr_before').removeClass('fltr_before');
      $optionSet.find('.fltr_after').removeClass('fltr_after');
      $this.parent('li').addClass('selected');
      $this.parent('li').next('li').addClass('fltr_after');
      $this.parent('li').prev('li').addClass('fltr_before');

      // make option object dynamically, i.e. { filter: '.my-filter-class' }
      var options = {},
        key = $optionSet.attr('data-option-key'),
        value = $this.attr('data-option-value');
      // parse 'false' as false boolean
      value = value === 'false' ? false : value;
      options[key] = value;
      if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
        // changes in layout modes need extra logic
        changeLayoutMode($this, options)
      } else {
        // otherwise, apply new options
        $container.isotope(options);
        var sortingtimer = setTimeout(function () {
          jQuery('.sorting_block').isotope('layout');
          clearTimeout(sortingtimer);
        }, 500);
      }
      return false;
    });

    $container.find('img').load(function () {
      $container.isotope('layout');
    });
  });

  jQuery(window).load(function () {
    jQuery('.sorting_block').isotope('layout');
    var sortingtimer = setTimeout(function () {
      jQuery('.sorting_block').isotope('layout');
      clearTimeout(sortingtimer);
    }, 500);
  });
  jQuery(window).resize(function () {
    jQuery('.sorting_block').isotope('layout');
  });

  jQuery.fn.portfolio_addon = function (addon_options) {
      //Set Variables
      var addon_el = jQuery(this),
          addon_base = this,
          img_count = addon_options.items.length,
          img_per_load = addon_options.load_count,
          $newEls = '',
          loaded_object = '',
          $container = jQuery(this);

      jQuery('.load_more_images').on('click', function () {
          $newEls = '';
          loaded_object = '';
          var loaded_images = $container.find('.added').size();
          var now_load = '';
          if ((img_count - loaded_images) > img_per_load) {
              now_load = img_per_load;
          } else {
              now_load = img_count - loaded_images;
          }

          if ((loaded_images + now_load) == img_count) {
              jQuery(this).fadeOut();
              jQuery(this).parent('.align-center').css('display', 'none');
          }

          var i_start = '';
          if (loaded_images < 1) {
              i_start = 1;
          } else {
              i_start = loaded_images + 1;
          }

          if (now_load > 0) {
              if (addon_options.type == 1) {
                for (var i = i_start - 1; i < i_start + now_load - 1; i++) {
                    loaded_object = loaded_object + '<div class="gallery_item element added"><div class="gallery_item_padding"><div class="gallery_item_wrapper">';
                    if (addon_options.items[i].data_media_style == 'image') {
                      loaded_object += '<a class="swipebox" href="' + addon_options.items[i].href + '" title="' + addon_options.items[i].data_title + '">';
                    } else {
                      loaded_object += '<a class="swipebox" rel="' + addon_options.items[i].data_rel + '" href="' + addon_options.items[i].videoid + '" title="' + addon_options.items[i].data_title + '">';
                    } 
                    loaded_object += '<div class="img_block"><img class="img2preload" data-title = "' + addon_options.items[i].data_title + '" data-caption = "' + addon_options.items[i].data_caption + '" data-img="' + addon_options.items[i].data_img + '" src="' + addon_options.items[i].src + '" alt="' + addon_options.items[i].data_alt + '" />';
                    loaded_object += '<div class="gallery_fadder"></div></div></a>';
                    loaded_object += '</div></div></div>';
                }
              }

              $newEls = jQuery(loaded_object);

              $container.isotope('insert', $newEls, function () {
                jQuery(window).load(function () {
                  jQuery('.sorting_block').isotope('layout');
                });
              });
              setTimeout(function () {
                jQuery('.sorting_block').isotope('layout');
              }, 500);
              setTimeout(function () {
                jQuery('.sorting_block').isotope('layout');
              }, 1000);
              setTimeout(function () {
                jQuery('.sorting_block').isotope('layout');
              }, 2000);
              $container.siblings('.align-center').css('display', 'none');
          }

          jQuery('.sorting_block.isotope').addClass('overflow_hidden');

          var overflowtimer = setTimeout(function () {
              jQuery('.sorting_block.isotope').removeClass('overflow_hidden');
              clearTimeout(overflowtimer);
          }, 2000);
          return false;
      });
  }

})(jQuery);