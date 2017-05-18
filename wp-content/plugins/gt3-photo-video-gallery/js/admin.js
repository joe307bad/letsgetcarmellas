jQuery(function() {
	"use strict";
	jQuery(document).ready(function($){
		if (jQuery(".gt3pg-border-type").val() == "on") jQuery(".border-setting").show(); else jQuery(".border-setting").hide();
		  jQuery(".gt3pg-border-type").on("change", function(){
		    if(jQuery(".gt3pg-border-type").val() == "on") jQuery(".border-setting").show(); else jQuery(".border-setting").hide(); });
		  jQuery('input[name="gt3pg_color_picker"]').wpColorPicker();
		  jQuery('.gt3pg_admin_save_all').on("mouseover", function() {
		    if (jQuery('input[name="gt3pg_color_picker"]').val() != "undefined") jQuery('input[name="gt3pg_border_col"]').val(jQuery('input[name="gt3pg_color_picker"]').val()).trigger("change").trigger("input").trigger("focus").trigger("blur");
		  });
	});
	
	jQuery(".gt3pg_admin_reset_settings").on("click", function() {
	  var agree = confirm("Are you sure?");
	  if (!agree) {return false;}
	  jQuery.post(ajaxurl, { action:'gt3_reset_gt3pg_settings' }, function(response) {
	    window.location.reload(true);
	  });
	  return false;
	});

	// Popup
	function gt3pg_show_admin_pop(gt3_message_text, gt3_message_type) {
		// Success - gt3_message_type = 'info_message'
		// Error - gt3_message_type = 'error_message'
		jQuery(".gt3pg_result_message").remove();
		jQuery("body").removeClass('active_message_popup').addClass('active_message_popup');
		jQuery("body").append("<div class='gt3pg_result_message "+gt3_message_type+"'>"+gt3_message_text+"</div>");
		var messagetimer = setTimeout(function(){
			jQuery(".gt3pg_result_message").fadeOut();
			jQuery("body").removeClass('active_message_popup');
			clearTimeout(messagetimer);
		}, 3000);
	}

  jQuery(".gt3pg_page_settings").submit(function (event) {
    event.preventDefault();
    var gt3pg_page_settings = jQuery(this);
    jQuery.post(gt3pg_admin_ajax_url, {
      action: 'gt3_save_gt3pg_options',
      serialize_string: JSON.stringify(gt3pg_page_settings.serializeArray())
    }, function (response) {
      var gt3pg_saved_response = JSON.parse(response);
			gt3pg_show_admin_pop('<b>DONE! You\'ve successfully saved the changes.</b>', 'info_message');
    });
  });

  jQuery(".gt3pg_admin_mix-container2 select").selectBox();

})
 
 