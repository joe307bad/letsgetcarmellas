//Select Image
jQuery(document).on("click", ".gt3_select_image_from_media", function (event) {
  var gt3_select_image_from_media_this = jQuery(this);
  event.preventDefault();

  var gt3_file_frame = wp.media.frames.file_frame = wp.media({
    title: 'Select Images',
    button: {
      text: 'Select'
    },
    multiple: false,
    library: {
      type: 'image'
    }
  });

  gt3_file_frame.on('select', function () {
    var gt3_image_attachment = gt3_file_frame.state().get('selection').first().toJSON();
    gt3_select_image_from_media_this.prev().val(gt3_image_attachment.url);
    gt3_select_image_from_media_this.next().next().find("img").remove();
    gt3_select_image_from_media_this.next().next().html("<img src='"+gt3_image_attachment.url+"' alt=''>");
  });

  gt3_file_frame.open();
});

//Remove Image
jQuery(document).on("click", ".gt3_image_from_media_remove", function (event) {
  jQuery(this).prev().prev().val("");
  jQuery(this).next().find("img").fadeOut();
});

var gt3AddImgStrip_container;
jQuery(function ($) {

  /* SIDEBAR MANAGER */
  jQuery(document).on('click', '.admin_create_new_sidebar_btn', function () {
    var sidebar_name = jQuery(this).parents('.add_new_sidebar').find('.admin_create_new_sidebar').val();
    if (sidebar_name == "") {
      alert("Sidebar must be named");
      return false;
    }
    jQuery(this).parents('.admin_mix-tab-control').find('.admin_sidebars_list').append('<div class="admin_sidebar_item"><input type="hidden" name="theme_sidebars[]" value="' + sidebar_name + '"><span class="admin_sidebar_name admin_visual_style1">' + sidebar_name + '</span><input type="button" class="admin_delete_this_sidebar admin_img_button cross" name="delete_this_sidebar" value="X"></div>');
    jQuery(this).parents('.add_new_sidebar').find('.create_new_sidebar').val("");
  });
  jQuery(document).on('click', '.admin_delete_this_sidebar', function () {
    var agree = confirm("Are you sure?");
    if (!agree)
      return false;
    jQuery(this).parents('.admin_sidebar_item').remove();
  });
  /* END SIDEBAR MANAGER */


  /*
   Hide/Show tabs
   */
  jQuery('.admin_l-mix-tabs-item').on('click', function(){
    jQuery('.admin_l-mix-tabs-item').removeClass('active');
    jQuery('.admin_mix-tab').hide();

    var data_tabname = jQuery(this).find('.admin_l-mix-tab-title').attr('data-tabname');

    jQuery(this).addClass('active');
    jQuery('.' + data_tabname).show();
    jQuery('#form-tab-id').val(data_tabname);

    return false;
  });

  /*
   Hide/Show tabs
   */
  jQuery('.admin_l-mix-tabs-list li').first().addClass('active');
  jQuery('.admin_mix-tabs .admin_mix-tab').first().show();

  /*
   Autoopen tab in admin
   */
  var admin_tab_now_open = jQuery('#form-tab-id').val();
  if (admin_tab_now_open !== "") {
    jQuery('.admin_l-mix-tabs-item').removeClass('active');
    jQuery('#' + admin_tab_now_open).addClass('active');
    jQuery('.admin_mix-tab').hide();
    jQuery('.' + admin_tab_now_open).show();
  }

  jQuery('.fadeout').delay(2000).fadeOut("slow");


  // ajax button
  jQuery('.admin_mix_ajax_button').on('click', function(){

    var $this = jQuery(this),
      $loader = $this.next(),
      $msgs = $loader.next(),
      id = $this.data('id'),
      _confirm = $this.data('confirm') || true,
      data = window.ajaxButtonData[id];

    if (_confirm) {
      if (!confirm('Are you sure?')) {
        return false;
      }
      ;
    }
    ;

    $loader.show();
    jQuery.post(admin_ajax, data, function (data) {
      $loader.hide();
    }, 'json');

    return false;
  });

  jQuery(document).on('keyup', '.itemTitle', function () {
    var thistitle = jQuery(this).val();
    jQuery(this).parents(".thisitem").find(".echotitle").html(thistitle);
  });

  jQuery(document).on('keyup', '.price_feature .expanded_text1', function () {
    var thistitle = jQuery(this).val();
    jQuery(this).parents(".price_feature").find(".option_title").html(thistitle);
  });

  jQuery(document).on("click", ".deleteThisSlide", function () {

    var temp = jQuery(this).parents(".mainPageSliderItem").find("li");

    jQuery(this).parents("li").remove();

    var tempi = -1;
    temp.each(function (index) {
      jQuery(this).find(".itemorder").val(tempi);
      tempi = tempi + 1;
    });

  });

  jQuery(document).on("click", ".editThisSlide", function () {
    jQuery(this).parents(".thisitem").find(".hiddenArea").fadeToggle();
  });

  jQuery(document).on("click", ".uploadImg", function () {
    formfield = jQuery('.uploadImg').attr('name');
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    window.thisUploadButton = jQuery(this);

    window.send_to_editor = function (html) {			
      imgurl = jQuery('img', html).attr('src');
      thisUploadButton.parents(".fr").find(".itemImage").val(imgurl);
      tb_remove();
    }

    return false;
  });

  jQuery(document).on("click", ".gt3UploadImg", function () {
    formfield = jQuery(this).attr('name');
    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    window.thisUploadButton = jQuery(this);

    window.send_to_editor = function (html) {
      imgurl = jQuery('img', html).attr('src');
      thisUploadButton.val(imgurl);
      tb_remove();
    }

    return false;
  });


  jQuery(window).load(function () {
    jQuery('.cpicker').wpColorPicker();

    /* POST FORMATS */
    /* list of all containers: #portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner */
    var nowpostformat = jQuery('#post-formats-select input:checked').val();
    var nowNEWpostformat = jQuery('.post-format-options a.active').attr("data-wp-format");

    if (nowpostformat == 'image' || nowNEWpostformat == 'image') {
      jQuery('#portslides_sectionid_inner').show();
    }
    if (nowpostformat == 'video') {
      jQuery('#video_sectionid_inner').show();
    }
    if (nowpostformat == 'audio') {
      jQuery('#audio_sectionid_inner').show();
    }
    if (nowpostformat == '0' || nowNEWpostformat == 'standard') {
      jQuery('#default_sectionid_inner').show();
    }

    /* ON CHANGE */
    /* WP <=3.5 */
    jQuery('#post-formats-select input').on('click', function(){
      jQuery('#portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner').hide();
      var nowclickformat = jQuery(this).val();
      if (nowclickformat == 'image') {
        jQuery('#portslides_sectionid_inner').show();
      }
      if (nowclickformat == 'audio') {
        jQuery('#audio_sectionid_inner').show();
      }
      if (nowclickformat == 'video') {
        jQuery('#video_sectionid_inner').show();
      }
      if (nowclickformat == '0') {
        jQuery('#default_sectionid_inner').show();
      }
    });
    /* WP >=3.6 */
    jQuery('.post-format-options a').on('click', function(){
      jQuery('#portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner').hide();
      var nowclickformat = jQuery(this).attr("data-wp-format");
      if (nowclickformat == 'image') {
        jQuery('#portslides_sectionid_inner').show();
      }
      if (nowclickformat == 'standard') {
        jQuery('#default_sectionid_inner').show();
      }
    });

    /* Show tab on start */
    if (jQuery("#form-tab-id").val() == "") {
      jQuery("#form-tab-id").val(jQuery(".l-mix-tabs-list li.active a").attr("data-tabname"))
    }

    jQuery(".cpicker.admin_textoption").each(function (index) {
      var already_selected_color = jQuery(this).val();
      jQuery(this).next().css("background-color", "#" + already_selected_color);
    });

    jQuery('.cpicker.admin_textoption').keyup(function (event) {
      var now_enter_color = jQuery(this).val();
      jQuery(this).next().css("background-color", "#" + now_enter_color);
    });

  });

  jQuery('.cpicker').focus(function () {
    jQuery(this).addClass("focused");
  });

  /* SELECT BOX */
  jQuery(".admin_newselect").selectBox();
  /* END SELECT BOX */

  jQuery(document).ready(function () {
		jQuery('.custom_select_img_preview').on('click', function(){
			jQuery(this).find('img').remove();
			jQuery('.custom_select_img_attachid').val('');
		});
		
		if (jQuery('.sidebar_layout').val() == 'none') {
			jQuery('.sidebar_none').slideUp(1);
		}
		if (jQuery('.sidebar_layout').val() == 'default') {
			if (jQuery('.select_sidebar').hasClass('sidebar_none')) {
				jQuery('.sidebar_none').slideUp(1);
			}			
		}
		
		jQuery('.sidebar_layout').change(function(){
			if (jQuery(this).val() == 'no-sidebar') {
				jQuery('.select_sidebar').stop().slideUp(300);
			} else {
				jQuery('.select_sidebar').stop().slideDown(300);
			}
			if (jQuery(this).val() == 'default') {
				if (jQuery('.select_sidebar').hasClass('sidebar_none')) {
					jQuery('.select_sidebar').stop().slideUp(300);
				} else {
					jQuery('.select_sidebar').stop().slideDown(300);
				}
			}
		});

		if (jQuery('.page_layout').val() == 'clean') {
			jQuery('.boxed_options').slideUp(1);
		}
		if (jQuery('.page_layout').val() == 'default') {
			if (jQuery('.boxed_options').hasClass('no_boxed')) {
				jQuery('.boxed_options').slideUp(1);
			}			
		}

		jQuery('.page_layout').change(function(){
			if (jQuery(this).val() == 'clean') {
				jQuery('.boxed_options').stop().slideUp(300);
			} else {
				jQuery('.boxed_options').stop().slideDown(300);
			}
			if (jQuery(this).val() == 'default') {
				if (jQuery('.boxed_options').hasClass('no_boxed')) {
					jQuery('.boxed_options').stop().slideUp(300);
				} else {
					jQuery('.boxed_options').stop().slideDown(300);
				}
			}
		});
		
    jQuery('select.fontselector').change(function () {
      var newval = jQuery(this).val();

      var customfontstatus = "disabled";

      if(fontsarray.length>0){
        for ( keyVar in fontsarray ) {
          if (newval==fontsarray[keyVar]) {
            customfontstatus = "enabled";
          }
        }
      }

      if (customfontstatus!=="enabled") {
        newval_font = newval.replace(new RegExp(" ", 'g'), "+");
        if (newval_font !== "Arial" && newval_font !== "Verdana" && newval_font !== "Times New Roman" && newval_font !== "Helvetica" && newval_font !== "Courier New" && newval_font !== "Tahoma") {
          jQuery("head").append("<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=" + newval_font + "'>");
        }
        jQuery(this).parents(".admin_input").find(".font_preview").css("font-family", newval);
      } else {
        jQuery(this).parents(".admin_input").find(".font_preview").css("font-family", newval);
      }
    });

    jQuery("select.fontselector").each(function(){
      jQuery(this).triggerHandler("change");
    })


  });

});

function remove_responce_message () {
  jQuery("#wpwrap").css("opacity", "1");
  jQuery(".result_message").remove();
}

function gt3_show_admin_pop(gt3_message_text, gt3_message_type) {
  // Success - gt3_message_type = 'info_message'
  // Error - gt3_message_type = 'error_message'
  jQuery(".gt3_result_message").remove();
  jQuery("body").removeClass('active_message_popup').addClass('active_message_popup');
  jQuery("body").append("<div class='gt3_result_message "+gt3_message_type+"'>"+gt3_message_text+"</div>");
  var messagetimer = setTimeout(function(){
    jQuery(".gt3_result_message").fadeOut();
    jQuery("body").removeClass('active_message_popup');
    clearTimeout(messagetimer);
  }, 3000);
}

jQuery(document).ready(function($) {

    jQuery(".admin_page_settings").submit(function (event) {
      event.preventDefault();
      var admin_page_settings = jQuery(this);
      jQuery.post(gt3_admin_ajax_url, {
        action: 'gt3_save_admin_options',
        serialize_string: JSON.stringify(admin_page_settings.serializeArray())
      }, function (response) {
        var gt3_saved_response = JSON.parse(response);
        gt3_show_admin_pop('<b>DONE! You\'ve successfully saved the changes.</b>', 'info_message');
      });
    });

    jQuery(".admin_reset_settings").on("click", function() {
      var agree = confirm("Are you sure?");
      if (!agree) {return false;}
      jQuery.post(ajaxurl, { action:'gt3_reset_admin_settings' }, function(response) {
        window.location.reload();
      });
      return false;
    });
	
  jQuery(".add-new-strip").on('click', function(){
    var data = {
      action:'get_unused_id_ajax'
    };
    var striproottag = jQuery(this);
    waiting_state_start();

    jQuery.post(ajaxurl, data, function (response) {
			
      striproottag.parents(".gt3settings_box_content").find(".append_items").append('<li class="strip_block"><div class="sort_drug strip_head">Strip item</div><div class="strip_block_container"><input type="text" placeholder="Title" name="pagebuilder[strips][' + response + '][striptitle1]" value="" class="strip_input"><input type="text" placeholder="Caption" name="pagebuilder[strips][' + response + '][striptitle2]" value="" class="strip_input"><input type="text" placeholder="Link" name="pagebuilder[strips][' + response + '][link]" value="" class="strip_input"><span class="remove_strip">[x]</span><div class="gt3_stripeimg_block"><span class="gt3AddImgStrip">Add Image</span><input type="hidden" class="gt3_img_attachid" name="pagebuilder[strips][' + response + '][attachid]" value=""><span class="gt3_img_preview_block"><img src="" alt="" class="gt3_img_preview"/></span></div></div></li>');			
      jQuery('.strip_cont .append_items').sortable({ placeholder:'ui-state-highlight', handle:'.sort_drug' });
			jQuery(".strip_select").selectBox();
      jQuery('.strip_cont .append_items').sortable({ placeholder:'ui-state-highlight', handle:'.sort_drug' });

			jQuery('.gt3AddImgStrip').on('click', function(){
				gt3AddImgStrip_container = jQuery(this).parent(".gt3_stripeimg_block");  

				if ( file_frame ) {
					file_frame.open();
					return;
				}

				file_frame = wp.media.frames.file_frame = wp.media({
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false
				});

				file_frame.on( 'select', function() {
					attachment = file_frame.state().get('selection').first().toJSON();
					gt3AddImgStrip_container.find(".gt3_img_attachid").val(attachment.id);
					gt3AddImgStrip_container.find(".gt3_img_preview_block").html("<img src='"+attachment.url+"' alt=''>");
				});

				file_frame.open();
			});
			
			reactivate_color_picker();			
      waiting_state_end();
    });
		
  });

  jQuery('.strip_cont .append_items').sortable({ placeholder:'ui-state-highlight', handle:'.sort_drug' });

  jQuery(document).on('click', '.remove_strip', function () {
    jQuery(this).parents("li").remove();
  });	

	var file_frame;
	jQuery('.add_image_from_wordpress_library_popup').on('click', function( event ){
		var custom_select_select_image = jQuery(this).parents(".boxed_options");
		event.preventDefault();

		if ( file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			custom_select_select_image.find(".custom_select_img_attachid").val(attachment.id);
			custom_select_select_image.find(".custom_select_img_preview").html("<img src='"+attachment.url+"' alt=''>");
		});

		file_frame.open();
	});
	jQuery('.gt3AddImg').on('click', function( event ){
		var gt3_custom_select_select_image = jQuery(this).parents(".gt3_stripeimg_block");	
		event.preventDefault();

		if ( file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			gt3_custom_select_select_image.find(".gt3_img_attachid").val(attachment.id);
			gt3_custom_select_select_image.find(".gt3_img_preview_block").html("<img src='"+attachment.url+"' alt=''>");
		});

		file_frame.open();
	});
	jQuery('.gt3AddImgStrip').on('click', function(){
		gt3AddImgStrip_container = jQuery(this).parent(".gt3_stripeimg_block");  

		if ( file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			gt3AddImgStrip_container.find(".gt3_img_attachid").val(attachment.id);
			gt3AddImgStrip_container.find(".gt3_img_preview_block").html("<img src='"+attachment.url+"' alt=''>");
		});

		file_frame.open();
	});

	jQuery('.gt3_img_preview_block img').on('click', function(event){	
		gt3AddImgStrip_container = jQuery(this).parents(".gt3_stripeimg_block");
		event.preventDefault();

		if ( file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			gt3AddImgStrip_container.find(".gt3_img_attachid").val(attachment.id);
			gt3AddImgStrip_container.find(".gt3_img_preview_block").html("<img src='"+attachment.url+"' alt=''>");
		});

		file_frame.open();
	});

	var file_frame_new;
	jQuery('.select_attach_id_from_media_library').on('click', function( event ){
		var select_image_root = jQuery(this).parents(".select_image_root");
		event.preventDefault();

		if ( file_frame_new ) {
			file_frame_new.open();
			return;
		}

		file_frame_new = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false
		});

		file_frame_new.on( 'select', function() {
			attachment = file_frame_new.state().get('selection').first().toJSON();
			select_image_root.find(".select_img_attachid").val(attachment.id);
			select_image_root.find(".select_img_preview").html("<img src='"+attachment.url+"' alt=''>");
		});

		file_frame_new.open();
	});

    /* Menu Module */
    var menu_select = jQuery('.select_menu_type_area .newselect');

    jQuery(menu_select).each(function(){
        var menu_type = jQuery(this).attr('value');

        if (menu_type == 'type1') {
            jQuery(this).parent().parent().parent().parent().find('.select_products_ids_area').slideUp(800);
        } else {
            jQuery(this).parent().parent().parent().parent().find('.select_product_category_area').slideUp(800);
            jQuery(this).parent().parent().parent().parent().find('.select_products_ids_area').slideDown(800);
        }
    });

    jQuery(menu_select).change(function(){
        var menu_type = jQuery(this).attr('value');

        if (menu_type == 'type2') {
            jQuery(this).parent().parent().parent().parent().find('.select_product_category_area').slideUp(800);
            jQuery(this).parent().parent().parent().parent().find('.select_products_ids_area').slideDown(800);
        } else {
            jQuery(this).parent().parent().parent().parent().find('.select_product_category_area').slideDown(800);
            jQuery(this).parent().parent().parent().parent().find('.select_products_ids_area').slideUp(800);
        }
    });

});

function add_menu_item() {
	jQuery('.field-css-classes').each(function(){
		if(jQuery(this).find('.show_menu_icon').size() > 0) {} else {
			jQuery(this).find('label').before('<label class="choose_icon_label">Choose menu icon:</label><div class="show_menu_icon" data-id="'+jQuery(this).find('input.edit-menu-item-classes').attr('id')+'"><i class="icon-file-text"></i></div>');
			jQuery(this).find('.edit-menu-item-classes').val('icon-file-text');
		}
	});			
}

/* SAVING ADMIN SETTINGS WITH AJAX */
jQuery("document").ready(function($) {
    jQuery(".plugin_page_settings .admin_save_all").on('click', function () {
        jQuery("#wpwrap").css("opacity", "0.5");
        var data = jQuery(".plugin_page_settings").serialize();
        jQuery.post(ajaxurl, { action:'save_pb_settings', json_string:data }, function(response) {
            jQuery("body").append("<div class='result_message'>"+response+"</div>");
            setTimeout(remove_responce_message , 2000);
        });
        return false;
    });
    jQuery(".plugin_page_settings .reset_settings").on('click', function () {
        var agree = confirm("Are you sure?");
        if (!agree)
            return false;
        jQuery("#wpwrap").css("opacity", "0.5");
        jQuery.post(ajaxurl, { action:'reset_pb_settings' }, function(response) {
            jQuery("body").append("<div class='result_message'>"+response+"</div>");
            setTimeout(remove_responce_message , 2000);
            window.location.reload();
        });
        return false;
    });
});