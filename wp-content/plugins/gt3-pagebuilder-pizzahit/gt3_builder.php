<?php
/*
Plugin Name: GT3 Page Builder (For Pizza HIT Theme Only)
Plugin URI: http://www.gt3themes.com/
Description: GT3 Page Builder is a powerful WordPress plugin that allows you to create the unlimited number of custom page layouts in WordPress themes. This special drag and drop plugin will save your time when building the pages.
Version: 1.0
Author: GT3 Themes
Author URI: http://www.gt3themes.com/
*/
 
define('GT3PBPLUGINROOTURL', plugins_url('/', __FILE__));
define('GT3PBPLUGINPATH', plugin_dir_path(__FILE__));
define('PBIMGURL', GT3PBPLUGINROOTURL . "img/");

add_action('plugins_loaded', 'gt3pb_locale');
function gt3pb_locale()
{
  load_plugin_textdomain('gt3_builder', false, dirname( plugin_basename( __FILE__ ) ) . '/core/languages/');
}

/*Load files*/
require_once(GT3PBPLUGINPATH . "core/loader.php");

#SAVE
add_action('save_post', 'save_postdata');

#REGISTER PAGE BUILDER
add_action('add_meta_boxes', 'add_custom_box');
function add_custom_box()
{
  if (is_array($GLOBALS["pbconfig"]['page_builder_enable_for_posts'])) {
    foreach ($GLOBALS["pbconfig"]['page_builder_enable_for_posts'] as $post_type) {
      add_meta_box(
        'pb_section',
        __('GT3 Page Builder', 'gt3_builder'),
        'pagebuilder_inner_custom_box',
        $post_type
      );
    }
  }
}

#--------extended version (1) start -----
function gt3_get_match_array(&$data, $key, $value) {
  $key = (array)$key;
  $needData = &$data;
  for ($i = 0; $i < count($key) - 1; $i++) {        
    $needData = &$needData[$key[$i]];    
  }
  $needData[$key[$i]] = $value;
}

#--------extended version (1) end -------
 
function pagebuilder_inner_custom_box($post)
{
  isset($_POST['tinymce_activation_class']) ? $tinymce_activation_class = $_POST['tinymce_activation_class'] : $tinymce_activation_class = '';
  $now_post_type = get_post_type();

  wp_nonce_field(null, 'pagebuilder_noncename');
  $gt3_theme_pagebuilder = get_plugin_pagebuilder($post->ID);
  if (!is_array($gt3_theme_pagebuilder)) {
    $gt3_theme_pagebuilder = array();
  }

  global $modules;

#get all sidebars
  $media_for_this_post = get_media_for_this_post(get_the_ID());
  $js_for_pb = "
  <script>
    var post_id = " . get_the_ID() . ";
    var show_img_media_library_page = 1;
  </script>";

  echo $js_for_pb;
  echo "
<!-- popup background -->
<div class='popup-bg'></div>
<div class='waiting-bg'><div class='waiting-bg-img'></div></div>
";
#START BUILDER AREA
  if (in_array($now_post_type, $GLOBALS["pbconfig"]['pb_modules_enabled_for'])) {
    echo "
<div class='pb-cont page-builder-container bbg'>
  <div class='padding-cont main_descr'>" . __("You can use this drag and drop page builder to create unlimited custom page layouts. It is too simple, just click any module below, adjust your own settings and preview the page. That's all.", "gt3_builder") . "</div>
  <div>
    <div class='hideable-content'>
      <div class='padding-cont'>
        <div class='available-modules-cont'>
          " . get_html_all_available_pb_modules($modules) . "
        </div>
        <div class='clear'></div>
      </div>";

#--------extended version (2) start -----

        if (isset($GLOBALS['pbconfig']['extended_mode']) && $GLOBALS['pbconfig']['extended_mode'] == 'on') {

          $exists_templates = get_option("builder_templates");
          if ($exists_templates == false) {
            update_option("builder_templates", array());
            $exists_templates = array();
          } 

          $templates_string = '';
          foreach ($exists_templates as $name => $value) {
            $templates_string .= $name . ',';
          }
          $templates_string = rtrim($templates_string, ',');

          echo "
          <div class='padding-cont main_descr_2'>" . __("The \"Template\" feature allows you to save the entire content of the page as a template and then to load it on any newly created pages.", "gt3_builder") . "
          </div>
          <div class='padding-cont templates_block'>
            <div title='" . esc_attr('Save whole page content into template') . "' class='text-shadow1 visual_style1 tiptip save_pb_template'>
               <span class='module-name'>" . __('Save Template', 'gt3_builder') . "</span>
            </div>
            <div title='" . __('Load whole page content from template', 'gt3_builder') . "' class='text-shadow1 visual_style1 tiptip load_pb_template'>
               <span class='module-name'>" . __('Load Template', 'gt3_builder') . "</span>
            </div>
            <div title='" . __('Delete template permanently', 'gt3_builder') . "' class='text-shadow1 visual_style1 tiptip delete_pb_template'>
               <span class='module-name'>" . __('Delete Template', 'gt3_builder') . "</span>
            </div>
            <div title='" . __('Paste content from clipboard', 'gt3_builder') . "' class='text-shadow1 tiptip paste_from_clipboard'>
               <span class='module-name'>" . __('Paste from Clipboard', 'gt3_builder') . "</span>
            </div>
            <div class='clear'></div>
            <div class='form_manage_templates'>
              <div class='form_save_template'>
                <label>
                  <span>" . __('Template Name: ', 'gt3_builder') . "</span>
                  <input type='text' name='saved_template_name' class='textoption type1' data-templates='".$templates_string."'>
                </label>
                <input name='save_template_submit' class='green-btn-type2 save_template_submit' value='Save' type='submit'>
                <div class='clear'></div>
              </div>
              
              <div class='form_load_template'>
                <span>" . __('Template Name: ', 'gt3_builder') . "</span>
                <div class='select_wrapper'>
                  <select type='text' name='load_template_name' class='newselect'>";
                  foreach ($exists_templates as $key => $value) {
                    echo "<option value='".$key."'>".$key."</option>";
                  }
                  echo "
                  </select>
                </div>
                <input name='load_template_submit' class='green-btn-type2 load_template_submit' value='Load' type='submit'>
                <div class='clear'></div>
              </div>

              <div class='form_delete_template'>
                <span>" . __('Template Name: ', 'gt3_builder') . "</span>
                <div class='select_wrapper'>
                  <select type='text' name='delete_template_name' class='newselect'>";
                  foreach ($exists_templates as $key => $value) {
                    echo "<option value='".$key."'>".$key."</option>";
                  }
                  echo "
                  </select>
                </div>
                <input name='delete_template_submit' class='green-btn-type2 delete_template_submit' value='Delete' type='submit'>
                <div class='clear'></div>
              </div>
              
            </div>
            
            <div class='clear'></div>
          </div>";
        }

# -------extended version (2) end -------

    echo "
      <div class='pb-list-active-modules'>
        <div class='padding-cont'>
          <ul class='sortable-modules'>
          ";

    if (isset($gt3_theme_pagebuilder['modules']) && is_array($gt3_theme_pagebuilder['modules'])) {
      foreach ($gt3_theme_pagebuilder['modules'] as $moduleid => $module) {
        if ($module['size'] == "block_1_4") {
          $size_caption = "1/4";
        }
        if ($module['size'] == "block_1_3") {
          $size_caption = "1/3";
        }
        if ($module['size'] == "block_1_2") {
          $size_caption = "1/2";
        }
        if ($module['size'] == "block_2_3") {
          $size_caption = "2/3";
        }
        if ($module['size'] == "block_3_4") {
          $size_caption = "3/4";
        }
        if ($module['size'] == "block_1_1") {
          $size_caption = "1/1";
        }
        echo get_pb_module($module['name'], $module['caption'], $moduleid, $gt3_theme_pagebuilder, $module['size'], $size_caption, $tinymce_activation_class);
      }
    }

    echo "
          </ul>
          <div class='clear'></div>
        </div>
      </div>
    </div>
  </div>
</div>
";
  }
#END BUILDER AREA


#Subtitle
    if ($now_post_type == "page" || $now_post_type == "port") {
        echo "
        <div id='page_subtitle' class='pt_" . $now_post_type . "' style='padding: 20px 18px 18px 18px; font-size: 12px;'>
            <div>
                <div>
                    <h2>Page Subtitle (You may use HTML tags)</h2>
                </div>
                <div>
                    <textarea style='height: 80px; width: 100%;' class='medium textoption' name='pagebuilder[page_settings][page_subtitle]'>" . (isset($gt3_theme_pagebuilder['page_settings']['page_subtitle']) ? $gt3_theme_pagebuilder['page_settings']['page_subtitle'] : "") . "</textarea>
                </div>
            </div>

            <h2 style='padding-top: 10px; padding-bottom: 5px;'>" . __('Page Title  Alignment:', 'gt3_builder') . "</h2>
            <select name='pagebuilder[page_settings][page_title_alignment]' class='admin_newselect'>";
        $gt3_options = array("center" => "Center", "left" => "Left", "right" => "Right");
        foreach ($gt3_options as $var_data => $var_caption) {
            echo "<option " . ((isset($gt3_theme_pagebuilder['page_settings']['page_title_alignment']) && $gt3_theme_pagebuilder['page_settings']['page_title_alignment'] == $var_data) ? 'selected="selected"' : '') . " value='" . $var_data . "'>" . $var_caption . "</option>";
        }
        echo "
            </select>

            <h2 style='padding-top: 10px; padding-bottom: 5px;'>" . __('Page Subtitle  Alignment:', 'gt3_builder') . "</h2>
            <select name='pagebuilder[page_settings][page_subtitle_alignment]' class='admin_newselect'>";
        $gt3_options = array("center" => "Center", "left" => "Left", "right" => "Right");
        foreach ($gt3_options as $var_data => $var_caption) {
            echo "<option " . ((isset($gt3_theme_pagebuilder['page_settings']['page_subtitle_alignment']) && $gt3_theme_pagebuilder['page_settings']['page_subtitle_alignment'] == $var_data) ? 'selected="selected"' : '') . " value='" . $var_data . "'>" . $var_caption . "</option>";
        }
        echo "
            </select>

            <h2 style='padding-top: 10px; padding-bottom: 5px;'>" . __('Text Divider:', 'gt3_builder') . "</h2>
            <select name='pagebuilder[page_settings][title_divider]' class='admin_newselect'>";
        $gt3_options = array("show" => "Show", "hide" => "Hide");
        foreach ($gt3_options as $var_data => $var_caption) {
            echo "<option " . ((isset($gt3_theme_pagebuilder['page_settings']['title_divider']) && $gt3_theme_pagebuilder['page_settings']['title_divider'] == $var_data) ? 'selected="selected"' : '') . " value='" . $var_data . "'>" . $var_caption . "</option>";
        }
        echo "
            </select>
        </div>
        ";
    }


#POSTFORMATS FOR POST. VISIBLE ONLY ON GT3 THEMES.
  if (GT3THEME_INSTALLED == true && $now_post_type == "post") {
    echo "
<div class='pb-cont page-settings-container'>
  <div class='pb10'>
    <div class='hideable-content'>
      <div class='post-formats-container'>
        <!-- Video post format -->
        <div id='video_sectionid_inner'>
          <h2>Post Format Video URL:</h2>
          <input type='text' class='medium textoption type1' name='pagebuilder[post-formats][videourl]' value='" . (isset($gt3_theme_pagebuilder['post-formats']['videourl']) ? $gt3_theme_pagebuilder['post-formats']['videourl'] : "") . "'>
          <div class='example'>Examples:<br>Youtube - http://www.youtube.com/watch?v=6v2L2UGZJAM<br>Vimeo - http://vimeo.com/47989207</div>

          <div class='container_height_section mt20'>
            <div class='hleft mediasettings_type'>" . esc_html__('Video height, px:', 'insquare') . "</div>
            <div class='hright'>
                <input id='video_height' type='text' class='medium textoption type1' name='pagebuilder[post-formats][video_height]' value='" . (isset($gt3_theme_pagebuilder['post-formats']['video_height']) ? $gt3_theme_pagebuilder['post-formats']['video_height'] : "540") . "' style='width:70px;text-align:center;'>
            </div>
            <div class='clear height10'></div>
          </div>
        </div>
				<!-- Audio post format -->
        <div id='audio_sectionid_inner'>
          <h2>Post Format Audio Code:</h2>";
					echo '<textarea class="enter_text1 audio_textarea" name="pagebuilder[post-formats][audiourl]">'. (isset($gt3_theme_pagebuilder['post-formats']['audiourl']) ? $gt3_theme_pagebuilder['post-formats']['audiourl'] : "") .'</textarea>';
					
          echo "
          <div class='example'>Examples:<br>
						&lt;iframe src='https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/141816093&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true' width='100%' height='166' frameborder='no' scrolling='no'&gt;&lt;/iframe&gt;
					</div>
        </div>				
        <!-- Image post format -->
        <div id='portslides_sectionid_inner'>
          <div class='portslides_sectionid_title'><h2>Slider Images</h2></div>
          <div class='selected-images-for-pf'>
            " . get_selected_pf_images_for_admin($gt3_theme_pagebuilder) . "
          </div>
					<hr class='img_seperator'>
          <div class='available-images-for-pf available_media'>
            <div class='ajax_cont'>
              " . get_media_html($media_for_this_post, "small") . "
            </div>
            <div class='for_post_fomrats img-item style_small add_image_to_sliders_available_media cboxElement'>
              <div class='img-preview'>
                <img alt='' src='" . PBIMGURL . "/add_image.png'>
              </div>
            </div><!-- .img-item -->
          </div>
					<input type='hidden' name='settings_type' value='fullscreen' class='settings_type'>					
        </div>
      </div>
      <div class='clear'></div>
    </div>
  </div>
</div>";
}


#GALLERY AREA
  if ($now_post_type == "gallery") {
    echo "
    <!-- FULLSCREEN SLIDER SETTINGS -->
        <div class='padding-cont  stand-s pt_" . $now_post_type . "'>
          <div class='bg_or_slider_option slider_type active'>
            <input type='hidden' name='settings_type' value='fullscreen' class='settings_type'>
            <div class='hideable-area'>
              <div class='padding-cont help text-shadow2'></div>
              <div class='padding-cont' style='padding-bottom:11px;'>
                <div class='selected_media'>
                  <div class='append_block'>
                     <ul class='sortable-img-items'>
                       " . get_slider_items("fullscreen", (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['slides']) ? $gt3_theme_pagebuilder['sliders']['fullscreen']['slides'] : '')) . "
                     </ul>
                  </div>
                  <div class='clear'></div>
                </div>
              </div>
              <div style='' class='hr_double style2'></div>
              <div class='padding-cont' style='padding-top:12px;'>
								<div class='gt3settings_box no-margin'>									
									<div class='gt3settings_box_title'><h2>" . __('Gallery Options', 'gt3_builder') . "</h2></div>
									<div class='gt3settings_box_content'>
										<div class='available_media'>
											<div class='ajax_cont'>
												" . get_media_html($media_for_this_post, "small") . "
											</div>
											<div class='img-item style_small add_image_to_sliders_available_media cboxElement'>
												<div class='img-preview'>
													<img alt='' src='" . PBIMGURL . "/add_image.png'>
												</div>
											</div><!-- .img-item -->
											<div class='img-item style_small add_video_slider'>
												<div class='img-preview'>
													<img alt='' class='previmg' data-full-url='" . PBIMGURL . "/video_item.png' src='" . PBIMGURL . "/add_video.png'>
												</div>
											</div><!-- .img-item -->
											<div class='clear'></div>
										</div>
									</div>";

								echo "</div>
              </div>
            </div>
          </div>
				<style>
					/*.preview_img_video_cont .select_image_root {display:none!important}*/
									
					/*.this-option .padding-cont:last-child,*/
					.this-option .hr_double,
					.this-option .right_block,
					.custom_select_bcarea.title_bcarea {
						display:none!important;
					}
					.this-option .w9 {
						width:720px!important;
					}
				</style>
        <!-- END SETTINGS -->";
  }

#TESTIMONIALS AREA
  if ($now_post_type == "testimonials") {
    echo "
      <!-- TESTIMONIALS SETTINGS -->
      <div class='padding-cont pt_" . $now_post_type . "'>

      <div class='testimonials_cont'>
        <div class='append_items'>
          <label for='testimonials_author' class='label_type1'>" . __('Author:', 'gt3_builder') . "</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['testimonials']['testimonials_author']) ? $gt3_theme_pagebuilder['page_settings']['testimonials']['testimonials_author'] : '') . "' id='testimonials_author' name='pagebuilder[page_settings][testimonials][testimonials_author]' class='testimonials_author itt_type1'><br>
          <label for='testimonials_position' class='label_type1'>" . __('Occupation:', 'gt3_builder') . "</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['testimonials']['company']) ? $gt3_theme_pagebuilder['page_settings']['testimonials']['company'] : '') . "' id='testimonials_company' name='pagebuilder[page_settings][testimonials][company]' class='testimonials_company itt_type1'>
        </div>
      </div>

      </div>
      <!-- END SETTINGS -->";
  }

// index

  if ($now_post_type == "page") {
    echo "<div class='pb-cont page-settings-container'>
      <div class='pb10'>
        <div class='hideable-content'>
          <div class='post-formats-container'>
            <div class='rev_slider_shortcode_style'>
              <h2>Revolution Slider Shortcode:</h2>
              <input type='text' class='medium textoption type1' name='pagebuilder[rev_slider_shortcode]' value='" . (isset($gt3_theme_pagebuilder['rev_slider_shortcode']) ? $gt3_theme_pagebuilder['rev_slider_shortcode'] : "") . "'>
              <div class='example'>Examples:<br>[rev_slider alias=\"Home-Slider\"]</div>
            </div>
          </div>
          <div class='clear'></div>
        </div>
      </div>
    </div>";
  }

#TEAM AREA
  if ($now_post_type == "team") {
    echo "
      <!-- TEAM SETTINGS -->
      <div class='padding-cont pt_" . $now_post_type . "'>

      <div class='partners_cont gt3settings_box'>
				<div class='gt3settings_box_title'><h2>Advanced Options</h2></div>
				<div class='gt3settings_box_content'>
					<div class='append_items'>
						<label for='position_link' class='label_type1'>Position:</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['team']['position']) ? $gt3_theme_pagebuilder['page_settings']['team']['position'] : '') . "' id='position_link' name='pagebuilder[page_settings][team][position]' class='position_link itt_type1'>
						<div>
							<div class='hleft' style='vertical-align:top;'>" . __('Social Icons', 'gt3_builder') . "</div>
							<div class='hright'>
								<div class='added_icons sortable_icons_list team_icons'>";

    if (isset($gt3_theme_pagebuilder['page_settings']['icons']) && is_array($gt3_theme_pagebuilder['page_settings']['icons'])) {
      foreach ($gt3_theme_pagebuilder['page_settings']['icons'] as $key => $value) {
        echo "
					<div class='stand_iconsweet ui-state-default '>
						<span class='stand_icon-container'><i class='stand_icon " . $value['data-icon-code'] . "'></i></span>
						<input type='hidden' name='pagebuilder[page_settings][icons][" . $key . "][data-icon-code]' value='" . $value['data-icon-code'] . "'>
						<input class='icon_name' type='text' name='pagebuilder[page_settings][icons][" . $key . "][name]' value='" . $value['name'] . "' placeholder='" . __('Give Some Name', 'gt3_builder') . "'>
						<input class='icon_link' type='text' name='pagebuilder[page_settings][icons][" . $key . "][link]' value='" . $value['link'] . "' placeholder='" . __('Give Some Link', 'gt3_builder') . "'>
						<input class='cpicker' type='text' name='pagebuilder[page_settings][icons][" . $key . "][fcolor]' value='" . $value['fcolor'] . "' placeholder='" . __('Background Color', 'gt3_builder') . "'>			
						<div style='width: 190px;' class='caption'>
							<h2>" . __('Open in New Window:', 'gt3_builder') . "</h2>
						</div>
						<div class='radio_selector'>
							" . toggle_radio_on_off('pagebuilder[page_settings][icons][' . $key . '][target]', (isset($gt3_theme_pagebuilder['page_settings']['icons'][$key]['target']) ? $gt3_theme_pagebuilder['page_settings']['icons'][$key]['target'] : ''), 'on') . "
						</div>
						<span class='remove_me'><i class='stand_icon icon-times'></i></span>
					</div>";
      }
    }
    echo "
								</div>
								<div class='social_list_for_select_team'>";
    foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
      echo "<div class='stand_social'><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></div>";
    }
    echo "
								</div>
							</div>
						</div>						
					</div>
					
				</div>
      </div>
      </div>
      <!-- END SETTINGS -->";
  }

# WOOCOMMERCE PRODUCT
if ($now_post_type == 'product') {
    echo "
        <style>
            .select_sidebar {
                display: none;
            }
        </style>
    ";
}

#JS FOR AJAX UPLOADER
  ?>
  <script type="text/javascript">

    function reactivate_ajax_image_upload() {
      var admin_ajax = '<?php echo admin_url("admin-ajax.php"); ?>';
      jQuery('.btn_upload_image').each(function () {
        var clickedObject = jQuery(this);
        var clickedID = jQuery(this).attr('id');
        new AjaxUpload(clickedID, {
          action: '<?php echo admin_url("admin-ajax.php"); ?>',
          name: clickedID, // File upload name
          data: { // Additional data to send
            action: 'mix_ajax_post_action',
            type: 'upload',
            data: clickedID },
          autoSubmit: true, // Submit file after selection
          responseType: false,
          onChange: function (file, extension) {
          },
          onSubmit: function (file, extension) {
            clickedObject.text('Uploading'); // change button text, when user selects file
            this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
            interval = window.setInterval(function () {
              var text = clickedObject.text();
              if (text.length < 13) {
                clickedObject.text(text + '.');
              }
              else {
                clickedObject.text('Uploading');
              }
            }, 200);
          },
          onComplete: function (file, response) {

            window.clearInterval(interval);
            clickedObject.text('Upload Image');
            this.enable(); // enable upload button

            // If there was an error
            if (response.search('Upload Error') > -1) {
              var buildReturn = '<span class="upload-error">' + response + '</span>';
              jQuery(".upload-error").remove();
              clickedObject.parent().after(buildReturn);

            }
            else {
              var buildReturn = '<a href="' + response + '" class="uploaded-image" target="_blank"><img class="hide option-image" id="image_' + clickedID + '" src="' + response + '" alt="" /></a>';

              jQuery(".upload-error").remove();
              jQuery("#image_" + clickedID).remove();
              clickedObject.parent().next().after(buildReturn);
              jQuery('img#image_' + clickedID).fadeIn();
              clickedObject.next('span').fadeIn();
              clickedObject.parent().prev('input').val(response);
            }
          }
        });
      });
    }

    jQuery(document).ready(function () {
      reactivate_ajax_image_upload();
    });
  </script>
  <?php #END JS FOR AJAX UPLOADER ?>

<?php
#DEVELOPER CONSOLE
  if (gt3pb_get_option("dev_console") == "true") {
    echo "<pre style='color:#000000;'>";
    print_r($gt3_theme_pagebuilder);
    echo "</pre>";
  }

}

#START SAVE MODULE
function save_postdata($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  #CHECK PERMISSIONS
  if (!current_user_can('edit_post', $post_id))
    return;

  #START SAVING
  if (!isset($_POST['pagebuilder'])) {
    $pbsavedata = array();
  } else {
    $pbsavedata = $_POST['pagebuilder'];
    update_theme_pagebuilder($post_id, "pagebuilder", $pbsavedata);
  }
}

?>