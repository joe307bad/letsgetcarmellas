jQuery(function ($) {
    /*
     Hide/Show tabs
     */
    jQuery('.l-mix-tabs-item').on('click', function () {
        jQuery('.l-mix-tabs-item').removeClass('active');
        jQuery('.mix-tab').hide();

        var data_tabname = jQuery(this).find('.l-mix-tab-title').attr('data-tabname');

        jQuery(this).addClass('active');
        jQuery('.' + data_tabname).show();
        jQuery('#form-tab-id').val(data_tabname);

        return false;
    });

    /*
     Hide/Show tabs
     */
    jQuery('.l-mix-tabs-list li').first().addClass('active');
    jQuery('.mix-tabs .mix-tab').first().show();

    /*
     Autoopen tab in admin
     */
    var admin_tab_now_open = jQuery('#form-tab-id').val();
    if (admin_tab_now_open !== "") {
        jQuery('.l-mix-tabs-item').removeClass('active');
        jQuery('#' + admin_tab_now_open).addClass('active');
        jQuery('.mix-tab').hide();
        jQuery('.' + admin_tab_now_open).show();
    }

    jQuery('.fadeout').delay(2000).fadeOut("slow");

    jQuery('body').append("<div class='shortcodesContainer'></div>");

    // ajax button
    jQuery('.mix_ajax_button').on('click', function () {

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


    jQuery(window).load(function () {

        /* COLOR PICKER */
        jQuery('.cpicker').wpColorPicker();

        /* POST FORMATS */
        var nowpostformat = jQuery('#post-formats-select input:checked').val();
        var nowNEWpostformat = jQuery('.post-format-options a.active').attr("data-wp-format");

        if (nowpostformat == 'image' || nowNEWpostformat == 'image') {
            jQuery('#portslides_sectionid_inner').show();
            jQuery('.wp-admin.post-type-post #pb_section').show();
        }
        if (nowpostformat == 'video') {
            jQuery('#video_sectionid_inner').show();
            jQuery('.wp-admin.post-type-post #pb_section').show();
        }
        if (nowpostformat == 'audio') {
            jQuery('#audio_sectionid_inner').show();
            jQuery('.wp-admin.post-type-post #pb_section').show();
        }
        if (nowpostformat == '0' || nowNEWpostformat == 'standard') {
            jQuery('#default_sectionid_inner').show();
            jQuery('.wp-admin.post-type-post #pb_section').hide();
        }

        /* ON CHANGE */
        /* WP <=3.5 */
        jQuery('#post-formats-select input').on('click', function () {
            jQuery('#portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner').hide();
            var nowclickformat = jQuery(this).val();
            if (nowclickformat == 'image') {
                jQuery('#portslides_sectionid_inner').show();
                jQuery('.wp-admin.post-type-post #pb_section').show();
            }
            if (nowclickformat == 'video') {
                jQuery('#video_sectionid_inner').show();
                jQuery('.wp-admin.post-type-post #pb_section').show();
            }
            if (nowclickformat == 'audio') {
                jQuery('#audio_sectionid_inner').show();
                jQuery('.wp-admin.post-type-post #pb_section').show();
            }
            if (nowclickformat == '0') {
                jQuery('#default_sectionid_inner').show();
                jQuery('.wp-admin.post-type-post #pb_section').hide();
            }
        });
        /* WP >=3.6 */
        jQuery('.post-format-options a').on('click', function () {
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

        jQuery(".cpicker.textoption").each(function (index) {
            var already_selected_color = jQuery(this).val();
            jQuery(this).next().css("background-color", "#" + already_selected_color);
        });

        jQuery('.cpicker.textoption').keyup(function (event) {
            var now_enter_color = jQuery(this).val();
            jQuery(this).next().css("background-color", "#" + now_enter_color);
        });

    });

    jQuery('.cpicker').focus(function () {
        jQuery(this).addClass("focused");
    });

});

function remove_responce_message () {
    jQuery("#wpwrap").css("opacity", "1");
    jQuery(".result_message").remove();
}
