;
(function($) {
  "use strict";
  /* SORTING */
  jQuery(function () {
    var $container = jQuery('.gt3pg_sorting_block');

    $container.isotope({
      itemSelector: '.gt3pg_element'
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
          jQuery('.gt3pg_sorting_block').isotope('layout');
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
    jQuery('.gt3pg_sorting_block').isotope('layout');
    var sortingtimer = setTimeout(function () {
      jQuery('.gt3pg_sorting_block').isotope('layout');
      clearTimeout(sortingtimer);
    }, 500);
  });
  jQuery(window).resize(function () {
    jQuery('.gt3pg_sorting_block').isotope('layout');
  });

})(jQuery);