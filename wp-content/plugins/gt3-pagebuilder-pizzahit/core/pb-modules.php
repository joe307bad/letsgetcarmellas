<?php

$thisThemeName = wp_get_theme()->get( 'Name' );

/* PB MODULES */
$modules['accordion']['name'] = "accordion";
$modules['accordion']['caption'] = "Accordion";
$modules['accordion']['help'] = __("Add simple accordion style with collapsible components.", "gt3_builder");

$modules['adblock']['name'] = "adblock";
$modules['adblock']['caption'] = "Ad Block";
$modules['adblock']['help'] = __("Add Advertisment Block.", "gt3_builder");

$modules['blog']['name'] = "blog";
$modules['blog']['caption'] = "Blog";
$modules['blog']['help'] = __("Display standard style blog to the page.", "gt3_builder");

$modules['content']['name'] = "content";
$modules['content']['caption'] = "Content";
$modules['content']['help'] = __("Display entire content available in the visual editor.", "gt3_builder");

$modules['bg_start']['name'] = "bg_start";
$modules['bg_start']['caption'] = "Background Start";
$modules['bg_start']['help'] = __("Add background image, color, pattern to the modules area.", "gt3_builder");

$modules['bg_end']['name'] = "bg_end";
$modules['bg_end']['caption'] = "Background End";
$modules['bg_end']['help'] = __("Add closing tag for \"Background Start\" module.", "gt3_builder");

$modules['dishes']['name'] = "dishes";
$modules['dishes']['caption'] = "Dishes";
$modules['dishes']['help'] = __("Add dishes presentation.", "gt3_builder");

$modules['divider']['name'] = "divider";
$modules['divider']['caption'] = "Divider";
$modules['divider']['help'] = __("Add divider to separate module blocks.", "gt3_builder");

$modules['feature_posts']['name'] = "feature_posts";
$modules['feature_posts']['caption'] = "Blog Posts";
$modules['feature_posts']['help'] = __("Display blog posts from different categories.", "gt3_builder");

$modules['gallery']['name'] = "gallery";
$modules['gallery']['caption'] = "Gallery";
$modules['gallery']['help'] = __("Display gallery from existing gallery list.", "gt3_builder");

$modules['google_map']['name'] = "google_map";
$modules['google_map']['caption'] = "Google Map";
$modules['google_map']['help'] = __("Add simple google map.", "gt3_builder");

$modules['html']['name'] = "html";
$modules['html']['caption'] = "HTML";
$modules['html']['help'] = __("Add any HTML code or shortcode to display on the page.", "gt3_builder");

$modules['title']['name'] = "title";
$modules['title']['caption'] = "Heading";
$modules['title']['help'] = __("Add simple heading.", "gt3_builder");

$modules['iconboxes']['name'] = "iconboxes";
$modules['iconboxes']['caption'] = "Icon Box";
$modules['iconboxes']['help'] = __("Add content block with the icon.", "gt3_builder");

$modules['imageboxes']['name'] = "imageboxes";
$modules['imageboxes']['caption'] = "Image Box";
$modules['imageboxes']['help'] = __("Add content block with the image.", "gt3_builder");

$modules['javascript']['name'] = "javascript";
$modules['javascript']['caption'] = "Javascript";
$modules['javascript']['help'] = __("Add javascript code to run on the page.", "gt3_builder");

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('woocommerce/woocommerce.php')) {
    $modules['menu']['name'] = "menu";
    $modules['menu']['caption'] = "Menu";
    $modules['menu']['help'] = __("Add menu on page.", "gt3_builder");
}

$modules['diagramm']['name'] = "diagramm";
$modules['diagramm']['caption'] = "Progress Bar";
$modules['diagramm']['help'] = __("Add advanced and flexible progress bar.", "gt3_builder");

$modules['single_image']['name'] = "single_image";
$modules['single_image']['caption'] = "Single Image";
$modules['single_image']['help'] = __("Add single_image.", "gt3_builder");

$modules['slider']['name'] = "layer_slider";
$modules['slider']['caption'] = "Shortcode";
$modules['slider']['help'] = __("Add any plugin that uses shortcodes.", "gt3_builder");

$modules['team']['name'] = "team";
$modules['team']['caption'] = "Team";
$modules['team']['help'] = __("Display selected team members from existing list.", "gt3_builder");

$modules['testimonial']['name'] = "testimonial";
$modules['testimonial']['caption'] = "Testimonials";
$modules['testimonial']['help'] = __("Display the selected testimonials from existing list.", "gt3_builder");

$modules['text_area']['name'] = "text_area";
$modules['text_area']['caption'] = "Text Area";
$modules['text_area']['help'] = __("Add simple text area.", "gt3_builder");

$modules['video']['name'] = "video";
$modules['video']['caption'] = "Video";
$modules['video']['help'] = __("Add vimeo or youtube video.", "gt3_builder");
/* END PB MODULES */

require_once("get-module-settings.php");

function get_pb_module($module_name, $module_caption, $moduleid, $gt3_theme_pagebuilder, $module_size, $size_caption, $tinymce_activation_class = "")
{

  $thisThemeName = wp_get_theme()->get( 'Name' );

  if (!isset($compile)) {
    $compile = '';
  }

  if (strlen($module_size) < 1) {
    $module_size = "block_1_4";
  }
  if (strlen($size_caption) < 1) {
    $size_caption = "1/4";
  }
  if (!is_array($gt3_theme_pagebuilder)) {
    $gt3_theme_pagebuilder = array();
    $pb_module_size_now = $GLOBALS["pbconfig"]['default_heading_in_module'];
  } else {
    $pb_module_size_now = (isset($gt3_theme_pagebuilder['modules'][$moduleid]['heading_size']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['heading_size'] : '');
  }

  #--------extended version start (change your block) -----
  $all_items_before_html = "<li class='module-cont item-with-settings {$module_size}'><input type='hidden' value='{$module_size}' name='pagebuilder[modules][$moduleid][size]' class='current_size'><input type='hidden' value='{$module_name}' name='pagebuilder[modules][$moduleid][name]' class='module_name'><input type='hidden' value='{$module_caption}' name='pagebuilder[modules][$moduleid][caption]' class='module_caption'><input type='hidden' value='{$moduleid}' name='pagebuilder[modules][$moduleid][key]' class='module_key'><div class='innerpadding'><div class='top'><div class='caption'><span class='module-name'>{$module_caption}</span></div><div class='controls'><div class='dragger box-with-icon'><i class='fa fa-arrows-alt' aria-hidden='true'></i><div class='border-right'></div><div class='border-left'></div><div class='control-element'></div></div><div class='edit box-with-icon'><i class='fa fa-pencil-square-o' aria-hidden='true'></i><div class='border-right'></div><div class='border-left'></div><div class='control-element'></div></div></div><div class='text-catch'></div></div><div class='bottom'><div class='left box-with-icon'><i class='fa fa-long-arrow-left' aria-hidden='true'></i><div class='control-element'></div></div><div class='size-caption box-with-icon'><div class='control-element'><span>{$size_caption}</span></div></div><div class='right box-with-icon'><i class='fa fa-long-arrow-right' aria-hidden='true'></i><div class='control-element'></div></div><div class='delete box-with-icon'><i class='fa fa-times' aria-hidden='true'></i><div class='border-right'></div><div class='border-left'></div><div class='control-element'>
</div></div>";

  if (isset($GLOBALS['pbconfig']['extended_mode']) && $GLOBALS['pbconfig']['extended_mode'] == 'on') {
    $all_items_before_html.= "
    <div class='copy-duplicate box-with-icon'><i class='fa fa-files-o' aria-hidden='true'></i><div class='border-right'></div><div class='border-left'></div><div class='control-element'></div>
    </div>
    <div class='copy-duplicate-wrap'>
      <div class='triangle1'></div>
      <div class='triangle2'></div>
      <div class='ultimate_module_duplicate'>Duplicate Module</div>
      <div class='ultimate_module_copy'>Copy to Clipboard</div>
    </div>
    ";
  }

#--------extended version end -----
  $all_items_before_html .= "</div></div><div class='edit_popup'>";
  $all_items_after_html = "</div></li>";

  $compile .= $all_items_before_html;

###########################################################################################
##################################### TOGGLE MODULE START #################################
###########################################################################################
  if ($module_name == "toggle") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='fl'>
      <div class='heading line_option visual_style1 small_type hovered clickable add_new_toggle_section'>
        <div class='option_title text-shadow1'>".__('Add new item', 'gt3_builder')."</div>
        <div class='some-element cross'></div>
        <div class='pre_toggler'></div>
      </div>
    </div>
    <div class='fr desc_pop text-shadow1'>

    </div>
    <div class='clear'></div>
  </div>
  <div class='pb-popup-white-bg'>
    <div class='padding-cont pt25'>
      <ul class='sections'>";
    if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['module_items']) && is_array($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'])) {
      foreach ($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'] as $itemid => $item) {
        $compile .= "
        <li class='section'>
          <div class='heading line_option visual_style1 big_type'>
            <div class='option_title text-shadow1'>{$item['title']}</div>
            <div class='some-element clickable edit hovered'></div>
            <div class='pre_toggler'></div>
            <div class='some-element movable move hovered'></div>
            <div class='pre_toggler'></div>
            <div class='some-element clickable delete hovered'></div>
            <div class='pre_toggler'></div>
          </div>
          <div class='clear'></div>
          <div class='hide_area'>
            <div class='some-padding'>
              <input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][title]' value='{$item['title']}'>
              <textarea class='expanded_text1 type2 mt tinytextarea' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][description]'>{$item['description']}</textarea>
            </div>
            <div class='expanded_state_cont'>
              <span class='text-shadow1'>" . __('Expanded', 'gt3_builder') . "</span>
            " . toggle_radio_yes_no("pagebuilder[modules][$moduleid][module_items][{$itemid}][expanded_state]", $item['expanded_state'], 'no', 'toggles_expanded_toggle') . "
            </div>
          </div>
        </li>
        ";
      }
    }
    $compile .= "</ul>
      <div class='clear'></div>
    </div>
  </div>
  <div class='dbg'></div>
  <div class='padding-cont'>
  
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################# BLOCKQUOTE MODULE START #################################
###########################################################################################
  if ($module_name == "blockquote") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>

  " . get_module_settings_part_textarea($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], "Quote text", "quote_text") . "

  " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], "Quote type", "quote_type", "200px", $GLOBALS["pbconfig"]['all_available_quote_types']) . "

  " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], "Author", "author_name", "100%", "left") . "
  " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
    <div class='clear'></div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
####################################### FEEDBACK FORM #####################################
###########################################################################################
  if ($module_name == "feedback_form") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  <div style='margin-bottom:20px;'></div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################## GALLERY MODULE START ###################################
###########################################################################################
  if ($module_name == "gallery") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='enter_option_row'>
      <h5>" . __('Select gallery', 'gt3_builder') . "</h5>
      <select name='pagebuilder[modules][$moduleid][selected_gallery]' class='newselect' style='width:300px;'>";

    /* GET ALL GALL'S FOR SELECT */
    if (isset($gt3_wp_query)) {
      $temp = $gt3_wp_query;
    }
    $gt3_wp_query = null;
    $gt3_wp_query = new WP_Query();
    $args = array(
      'post_type' => 'gallery',
      'posts_per_page' => -1,
    );

    $compilegal = "";

    $gt3_wp_query->query($args);
    while ($gt3_wp_query->have_posts()) : $gt3_wp_query->the_post();

      if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['selected_gallery']) && $gt3_theme_pagebuilder['modules'][$moduleid]['selected_gallery'] == get_the_ID()) {
        $selectedstate = "selected='selected'";
      } else {
        $selectedstate = "";
      }

      $compilegal .= "<option value='" . get_the_ID() . "' {$selectedstate}>" . get_the_title() . "</option>";

    endwhile;

    $compile .= $compilegal;

    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['image_width'])) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['image_width'] = $GLOBALS["pbconfig"]['gallery_module_default_width'];
    }

    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['image_height'])) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['image_height'] = $GLOBALS["pbconfig"]['gallery_module_default_height'];
    }

    $compile .= "
      </select>
      <div class='clear'></div>
    </div>
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __('Thumbs format preview', 'gt3_builder'), "preview_thumbs_format", "100px", array("rectangle" => "Rectangle", "square" => "Square", "masonry" => "Masonry", 'slider' => 'Slider')) . "
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __('Images in a row', 'gt3_builder'), "images_in_a_row", "100px", $GLOBALS["pbconfig"]['gallery_images_in_a_row']) . "
    <div class='mb20'>
      <h5>" . __('Fullwidth', 'gt3_builder') . ":</h5>
      " . toggle_radio_yes_no("pagebuilder[modules][$moduleid][fullwidth_gallery]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['fullwidth_gallery']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['fullwidth_gallery'] : 'no'), "") . "
    </div><div class='clear'></div>
    
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>

  " . get_module_settings_part_done_btn() . "
</div>
    <script>gt3_checkSlider();</script>";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################ CONTACT INFO MODULE START ################################
###########################################################################################

  if ($module_name == "contact_info") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
		<div class='gt3_floated_option diagram_bg_wrapper contact_list_toggler'>
			<h5>" . __('Show Background', 'gt3_builder') . ":</h5>
			" . toggle_radio_yes_no("pagebuilder[modules][$moduleid][show_bg]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['show_bg']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['show_bg'] : 'yes'), "show_bg") . "
		</div>		
		<div class='gt3_floated_option diagram_bg_wrapper'>
			<h5>" . __('Contact List', 'gt3_builder') . ":</h5>
			" . toggle_radio_yes_no("pagebuilder[modules][$moduleid][contact_list]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['contact_list']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['contact_list'] : 'no'), "contact_list_toggler") . "
		</div>
		<div class='clear'></div>
		<br/>		
    " . get_module_settings_part_any_icons($gt3_theme_pagebuilder, $moduleid, __('Select icons', 'gt3_builder'), "contact_info_icons") . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################## SINGLEIMAGE MODULE START #################################
###########################################################################################

  if ($module_name == "single_image") {

  /* START POPUP HTML */

    $compile .= "

  <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>

  <div class='pop_scrollable_area'>
      " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
      <div class='padding-cont'>
         " . get_module_settings_part_media_attach_id_upload($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Select Image", "gt3_builder"), "singleimage_url") . "   
         " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
          <div class='clear'></div>
      </div>
      " . get_module_settings_part_done_btn() . "
  </div> ";
  /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
#################################### BLOG MODULE START ####################################
###########################################################################################
  if ($module_name == "blog") {

    if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_page']) && strlen($gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_page']) < 1) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_page'] = $GLOBALS["pbconfig"]['blog_default_posts_per_page'];
    }

    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Posts per page", 'gt3_builder'), "posts_per_page", "100px", "center", $GLOBALS["pbconfig"]['blog_default_posts_per_page']) . "
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Items per line", "gt3_builder"), "posts_per_line", "100px", $GLOBALS["pbconfig"]['available_posts_per_line']) . "
    <div class='checkbox_wrapper'>" . get_module_settings_part_categories($gt3_theme_pagebuilder, $moduleid, __("Categories", 'gt3_builder'), "cat_ids", "post") . "</div>" . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################ LAYER SLIDER MODULE START ################################
###########################################################################################
  if ($module_name == "layer_slider") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_textarea_without_tiny($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Shortcode", "gt3_builder"), "html") . "
    <div class='example'>".__("You can add any slider(plugin) that uses shortcodes. Please copy/paste the slider plugin shortcode to the content area above and click \"Done\".", "gt3_builder")."</div>
  </div>
  <div class='padding-cont' style='padding-top:0;'>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "</div>" . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################## PARTNERS MODULE START ##################################
###########################################################################################
  if ($module_name == "partners") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='checkbox_wrapper'>" . get_module_settings_part_cpts($gt3_theme_pagebuilder, $moduleid, __("Select partners", "gt3_builder"), "cpt_ids", "partners") . "</div>
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Items per line", "gt3_builder"), "partners_in_line", "100px", "center") . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "</div>" . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################### FEATURED POSTS START ##################################
###########################################################################################
  if ($module_name == "feature_posts") {

    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['number_of_posts'])) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['number_of_posts'] = $GLOBALS["pbconfig"]['featured_posts_default_number_of_posts'];
    }

    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_line'])) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_line'] = $GLOBALS["pbconfig"]['featured_posts_default_posts_per_line'];
    }

    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Number of posts", "gt3_builder"), "number_of_posts", "100px", "center") . "
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Items per line", "gt3_builder"), "posts_per_line", "100px", $GLOBALS["pbconfig"]['available_posts_per_line']) . "
    <div class='checkbox_wrapper'>" . get_module_settings_part_categories($gt3_theme_pagebuilder, $moduleid, __("Categories", "gt3_builder"), "selected_categories", "post") . "</div>
    " . get_module_settings_part_select($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Sorting type", "gt3_builder"), "sorting_type", "200px", $GLOBALS["pbconfig"]['featured_posts_available_sorting_type']) .get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "</div>" . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################### DIVIDER MODULE START ##################################
###########################################################################################
  if ($module_name == "divider") {

    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  <div class='padding-cont'>
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], "Divider type", "divider_color", "200px", $GLOBALS["pbconfig"]['all_available_dividers']) . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "<div class='clear'></div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
#################################### VIDEO MODULE START ###################################
###########################################################################################
  if ($module_name == "video") {

    if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['video_height']) && strlen($gt3_theme_pagebuilder['modules'][$moduleid]['video_height']) < 1) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['video_height'] = $GLOBALS["pbconfig"]['default_video_height'];
    }

    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='example'>" . __('Examples:<br>Youtube - http://www.youtube.com/watch?v=6v2L2UGZJAM<br>Vimeo - http://vimeo.com/47989207', 'gt3_builder') . "</div>
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Video url", "gt3_builder"), "video_url", "100%", "left") . "
    " . get_module_settings_part_media_attach_id_upload($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Video cover image", "gt3_builder"), "video_cover_image") . " 
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Video height", "gt3_builder"), "video_height", "100px", "center", $GLOBALS["pbconfig"]['default_video_height']) . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

  ###########################################################################################
  ########################################## DIAGRAMM #######################################
  ###########################################################################################
  if ($module_name == "diagramm") {
          /* START POPUP HTML */
          $compile .= "
  <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
  <div class='pop_scrollable_area'>
      " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
      <div class='padding-cont diagram_admin'>
      <div class='gt3_floated_option diagram_bg_wrapper'><h5>" . __('Bar Background', 'gt3_builder') . ":</h5>" . colorpicker_block("pagebuilder[modules][$moduleid][diagram_bg]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['diagram_bg']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['diagram_bg'] : '#e5e5e5')) . "</div>
      <div class='gt3_floated_option diagram_bg_wrapper'><h5>" . __('Bar Color', 'gt3_builder') . ":</h5>" . colorpicker_block("pagebuilder[modules][$moduleid][diagram_color]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['diagram_color']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['diagram_color'] : '#dd3601')) . "</div>
      <div class='gt3_floated_option'>" . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __('Bar height:', 'gt3_builder'), "bar_width", "95px", "left", "5px") . "</div>
      <div class='clear'></div>
    
          <div class='fl'>
              <div class='heading line_option visual_style1 small_type hovered clickable add_new_diagramm_section'>
                  <div class='option_title text-shadow1'>".__('Add new item', 'gt3_builder')."</div>
                  <div class='some-element cross'></div>
                  <div class='pre_toggler'></div>
              </div>
          </div>
          <div class='fr desc_pop text-shadow1'>

          </div>
          <div class='clear'></div>
      </div>
      <div class='pb-popup-white-bg'>
          <div class='padding-cont pt25'>
              <ul class='sections accordion'>";
          if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['module_items']) && is_array($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'])) {
              foreach ($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'] as $itemid => $item) {
                  $compile .= "
                  <li class='section'>
                      <div class='heading line_option visual_style1 big_type'>
                          <div class='option_title text-shadow1'>{$item['title']}</div>
                          <div class='some-element clickable edit hovered'></div>
                          <div class='pre_toggler'></div>
                          <div class='some-element movable move hovered'></div>
                          <div class='pre_toggler'></div>
                          <div class='some-element clickable delete hovered'></div>
                          <div class='pre_toggler'></div>
                      </div>
                      <div class='clear'></div>
                      <div class='hide_area'>
                          <div class='some-padding'>
                              <input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][title]' value='{$item['title']}'> " . __('Percent', 'gt3_builder') . ": <input type='text' class='expanded_text1 type1 skill_percent' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][percent]' style='width:88px; text-align: center; margin-right: 2px; float: right;' value='{$item['percent']}'><input type='text' class='expanded_text1 type1 skill_description' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][description]' value='{$item['description']}'>
                          </div>
                      </div>
                  </li>
                  ";
              }
          }
          $compile .= "</ul>
              <div class='clear'></div>
          </div>
      </div>
      <div class='dbg'></div>
      <div class='padding-cont'>
          " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
      </div>
      " . get_module_settings_part_done_btn() . "
  </div>
          ";
          /* END POPUP HTML */
      }
  #MODULE END

###########################################################################################
#################################### TEAM MODULE START ####################################
###########################################################################################
  if ($module_name == "team") {

    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['number_of_workers']) || $gt3_theme_pagebuilder['modules'][$moduleid]['number_of_workers'] < 1) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['number_of_workers'] = $GLOBALS["pbconfig"]['team_default_numbers'];
    }

    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_line']) || $gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_line'] < 1) {
      $gt3_theme_pagebuilder['modules'][$moduleid]['posts_per_line'] = 4;
    }

    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
  <div class='checkbox_wrapper'>" . get_module_settings_part_cpts($gt3_theme_pagebuilder, $moduleid, __("Select team members", "gt3_builder"), "cpt_ids", "team") . "</div>
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __('Items per line', 'gt3_builder'), "items_per_line", "100px", array("1" => "1", "2" => "2")) . "
    <h5>" . __('Vertical Align', 'gt3_builder') . ":</h5>
    " . toggle_radio_yes_no("pagebuilder[modules][$moduleid][vertical]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['vertical']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['vertical'] : 'no'), "") . "
    <div class='mb20'></div>
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Order type", "gt3_builder"), "order", "200px", array("ASC" => "Ascending", "DESC" => "Descending")) . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "

  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
############################### TESTIMONIALS MODULE START #################################
###########################################################################################
  if ($module_name == "testimonial") {

    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='checkbox_wrapper'>" . get_module_settings_part_cpts($gt3_theme_pagebuilder, $moduleid, __("Select testimonials", "gt3_builder"), "cpt_ids", "testimonials") . "</div>
    " . get_module_settings_part_select($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Sorting type", "gt3_builder"), "sorting_type", "200px", $GLOBALS["pbconfig"]['all_available_testimonial_sorting_type']) . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################## TEXT AREA MODULE START #################################
###########################################################################################
  if ($module_name == "text_area") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_textarea($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Text", "gt3_builder"), "text", $tinymce_activation_class) . "
    <div class='example'>" . __('You can use any HTML tags and shortcodes that are available in this plugin.', 'gt3_builder') . "</div>
  </div>
  <div class='padding-cont' style='padding-top:0;'>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

######################################################################################
################################## MENU MODULE START #################################
######################################################################################
    if ($module_name == 'menu') {
        /* START POPUP HTML */
        $compile .= "
            <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
            <div class='pop_scrollable_area'>
                " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
                <div class='padding-cont'>
                    <div class='select_menu_view_type_area'>
                        " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("View Type", "gt3_builder"), "menu_view_type", "200px", array("1" => "Type 1", "2" => "Type 2", "3" => "Type 3")) . "
                    </div>
                    <div class='select_menu_type_area'>
                        " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Menu Type", "gt3_builder"), "menu_type", "200px", array("type1" => "By Categories", "type2" => "By IDs")) . "
                    </div>
                    <div class='select_product_category_area'>
                        " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Products Category", "gt3_builder"), "prod_cat", "200px", gt3_get_parameters_array('product')) . "
                    </div>
                    <div class='select_products_ids_area'>
                        " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Enter Products IDs", "gt3_builder"), "prod_ids", "100%", "left") . "
                    </div>
                </div>
                <div class='padding-cont' style='padding-top:0;'>
                    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
                </div>
                " . get_module_settings_part_done_btn() . "
            </div>
        ";
        /* END POPUP HTML */
    }
#MODULE END


###########################################################################################
##################################### HTML MODULE START ###################################
###########################################################################################
  if ($module_name == "html") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_textarea_without_tiny($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("HTML", "gt3_builder"), "html") . "
    <div class='example'>" . __('You can use HTML tags and shortcodes.', 'gt3_builder') . "</div>" . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
############################### JAVASCRIPT MODULE START ###################################
###########################################################################################
  if ($module_name == "javascript") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_textarea_without_tiny($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Javascript", "gt3_builder"), "html") . "
    <div class='example'>" . __('You can use Javascript and shortcodes.', 'gt3_builder') . "</div>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
###################################### BG START MODULE ####################################
###########################################################################################

  if ($module_name == "bg_start") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  <div class='padding-cont'>
		" . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Please set the custom top padding before the modules.", "gt3_builder"), "padding_top", "115px", "center", "40px") . "
    <div class='bg_start_style'>" . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Properties", "gt3_builder"), "properties", "200px", array("stretch" => "Stretch", "pattern" => "Pattern", "paralax" => "Paralax")) . "</div>
    " . get_module_settings_part_media_attach_id_upload($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Background image", "gt3_builder"), "bg_image") . "  
    <div class='bg_start_style'>" . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Background Position", "gt3_builder"), "bg_image_position", "200px", array("center" => "Center", "" => "Left", "right" => "Right")) . "</div>
    <div class='enter_option_row'>
      <h5>" . __('Background color', 'gt3_builder') . "</h5>
      " . colorpicker_block("pagebuilder[modules][$moduleid][bg_color]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['bg_color']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['bg_color'] : '#f8f8f8')) . "
      <div class='clear'></div>
    </div>
    <div class='mb20'>
      <h5>" . __('Fullwidth Smart Cells Mode', 'gt3_builder') . ":</h5>
      " . toggle_radio_yes_no("pagebuilder[modules][$moduleid][fullwidth_mode]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['fullwidth_mode']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['fullwidth_mode'] : 'no'), "") . "
    </div><div class='clear'></div>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
####################################### BG END MODULE #####################################
###########################################################################################
  if ($module_name == "bg_end") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  <div class='padding-cont'>
    <div class='enter_option_row'>
      The \"Background End\" module is integral part of \"Background Start\" module. Those modules can not work separately.
    </div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################## GOOGLE MAP MODULE START ################################
###########################################################################################
  if ($module_name == "google_map") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_textarea_without_tiny($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Google map code", "gt3_builder"), "map") . "
    <div class='example'>
      " . __('Example:', 'gt3_builder') . "<br>
      &lt;iframe width='100%' height='395' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='http://maps.google.ca/maps?f=q&source=s_q&hl=en&geocode=&q=New+York&sll=49.891235,-97.15369&sspn=47.259509,86.923828&ie=UTF8&hq=&hnear=New+York,+United+States&ll=40.714867,-74.005537&spn=0.019517,0.018797&z=14&iwloc=near&output=embed'&gt;&lt;/iframe&gt;
    <br><br>
      " . __("Code from <a href='https://maps.google.com/' target='_blank'>Google maps</a>", 'gt3_builder') . "
    </div>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
#################################### CONTENT MODULE START #################################
###########################################################################################
  if ($module_name == "content") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='enter_option_row'>
      " . __('This module will display the entire content of the standard wordpress visual editor. Please note that you can use this module only once on the page.', 'gt3_builder') . "
    </div>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################# SOCIAL SHARE MODULE START ###############################
###########################################################################################
  if ($module_name == "social_share") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    <div class='enter_option_row'>
      " . __('This module displays the social sharing buttons.', 'gt3_builder') . "
    </div>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
###################################### TITLE MODULE START #################################
###########################################################################################
  if ($module_name == "title") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
##################################### ACCORDION MODULE START ##############################
###########################################################################################
      if ($module_name == "accordion") {
          /* START POPUP HTML */
          $compile .= "
  <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
  <div class='pop_scrollable_area'>
      " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
      <div class='padding-cont'>
          <div class='fl'>
              <div class='heading line_option visual_style1 small_type hovered clickable add_new_accordion_section'>
                  <div class='option_title text-shadow1'>".__('Add new item', 'gt3_builder')."</div>
                  <div class='some-element cross'></div>
                  <div class='pre_toggler'></div>
              </div>
          </div>
          <div class='fr desc_pop text-shadow1'>

          </div>
          <div class='clear'></div>
      </div>
      <div class='pb-popup-white-bg'>
          <div class='padding-cont pt25'>
              <ul class='sections accordion'>";
          if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['module_items']) && is_array($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'])) {
              foreach ($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'] as $itemid => $item) {
                  $compile .= "
                  <li class='section'>
                      <div class='heading line_option visual_style1 big_type'>
                          <div class='option_title text-shadow1'>{$item['title']}</div>
                          <div class='some-element clickable edit hovered'></div>
                          <div class='pre_toggler'></div>
                          <div class='some-element movable move hovered'></div>
                          <div class='pre_toggler'></div>
                          <div class='some-element clickable delete hovered'></div>
                          <div class='pre_toggler'></div>
                      </div>
                      <div class='clear'></div>
                      <div class='hide_area'>
                          <div class='some-padding'>
                              <input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][title]' value='{$item['title']}'>
                              <textarea class='expanded_text1 type2 mt tinytextarea' id='".$tinymce_activation_class."' name='pagebuilder[modules][$moduleid][module_items][{$itemid}][description]'>{$item['description']}</textarea>
                          </div>
                          <div class='expanded_state_cont'>
                              <span class='text-shadow1'>" . __('Expanded', 'gt3_builder') . "</span>
                          " . toggle_radio_yes_no("pagebuilder[modules][$moduleid][module_items][{$itemid}][expanded_state]", $item['expanded_state'], 'no', 'accordion_expanded_toggle') . "
                          </div>
                      </div>
                  </li>
                  ";
              }
          }
          $compile .= "</ul>
              <div class='clear'></div>
          </div>
      </div>
      <div class='dbg'></div>
      <div class='padding-cont'>
      
          " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
      </div>
      " . get_module_settings_part_done_btn() . "
  </div>
          ";
          /* END POPUP HTML */
      }
  #MODULE END

###########################################################################################
################################## ADBLOCK MODULE START #################################
###########################################################################################
  if ($module_name == "adblock") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Slogan", "gt3_builder"), "adblock_slogan", "100%", "left") . "
    " . get_module_settings_part_media_attach_id_upload($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Background Image", "gt3_builder"), "adblock_bg") . "  
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Button text", "gt3_builder"), "button_text", "100%", "left") . "
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Link", "gt3_builder"), "link", "100%", "left") . "
     " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Target", "gt3_builder"), "target", "200px", array("_blank" => "Blank", "_self" => "Self")) . "
     
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
    <div class='clear'></div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################## ICONBOXES MODULE START #################################
###########################################################################################
  if ($module_name == "iconboxes") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_icons($gt3_theme_pagebuilder, $moduleid, "Select icon", "icon_type") . "
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Iconbox heading", "gt3_builder"), "iconbox_heading", "100%", "left") . "
    " . get_module_settings_part_textarea($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Iconbox text", "gt3_builder"), "iconbox_text", $tinymce_activation_class) . "
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Link", "gt3_builder"), "link", "100%", "left") . "
     " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Target", "gt3_builder"), "target", "200px", array("_blank" => "Blank", "_self" => "Self")) . "
     
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
    <div class='clear'></div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END


###########################################################################################
################################## IMAGEBOXES MODULE START #################################
###########################################################################################
  if ($module_name == "imageboxes") {
      /* START POPUP HTML */
      $compile .= "
  <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
  <div class='pop_scrollable_area'>
    " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
    <div class='padding-cont'>
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Imagebox heading", "gt3_builder"), "imagebox_heading", "100%", "left") . "
      " . get_module_settings_part_textarea($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Imagebox text", "gt3_builder"), "imagebox_text", $tinymce_activation_class) . "
      " . get_module_settings_part_media_attach_id_upload($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Select Image", "gt3_builder"), "imagebox_imageurl") . "  
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Imagebox image width, px", "gt3_builder"), "imagebox_image_width", "60px", "left") . "
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Imagebox image height, px", "gt3_builder"), "imagebox_image_height", "60px", "left") . "
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Link", "gt3_builder"), "link", "100%", "left") . "
       " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Target", "gt3_builder"), "target", "200px", array("_blank" => "Blank", "_self" => "Self")) . "
       
      " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
      <div class='clear'></div>
    </div>
    " . get_module_settings_part_done_btn() . "
  </div>
      ";
      /* END POPUP HTML */
    }
  #MODULE END

###########################################################################################
################################## counter MODULE START #################################
###########################################################################################
  if ($module_name == "counter") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Counter count", "gt3_builder"), "stat_count", "100%", "left") . "	
		" . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Counter title", "gt3_builder"), "stat_title", "100%", "left") . "
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
    <div class='clear'></div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################ CUSTOM LIST MODULE START #################################
###########################################################################################
  if ($module_name == "custom_list") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class='padding-cont'>
    " . get_module_settings_part_add_list_ability($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Add new list item", "gt3_builder")) . "
    " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("List type", "gt3_builder"), "list_type", "200px", $GLOBALS["pbconfig"]['all_available_custom_list_types']) . "
    
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
    <div class='clear'></div>
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################ PRICE TABLE MODULE START #################################
###########################################################################################
  if ($module_name == "price_table") {
    /* START POPUP HTML */
    $compile .= "
<h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
<div class='pop_scrollable_area'>
  " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
  <div class=''>
    <div class='rows_must_be_here'>
      <div class='padding-cont'>
      <input type='hidden' value='{$moduleid}' class='moduleid' name='moduleid'>
      <div class='heading line_option visual_style1 small_type hovered clickable add_new_price_block'>
        <div class='option_title text-shadow1'>" . __('Add price item', 'gt3_builder') . "</div>
        <div class='some-element cross'></div>
        <div class='pre_toggler'></div>
      </div>
      <div class='clear'></div>
      </div>
      <div class='pb-popup-white-bg'>
      <div class='padding-cont'>
      <ul class='sections row-list' style='margin-top:7px !important;'>";
    if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['module_items']) && is_array($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'])) {
      foreach ($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'] as $itemid => $item) {
        $compile .= "

        <li class='section'>
          <div class='heading line_option visual_style1 big_type'>
            <div class='option_title text-shadow1'>".((isset($item['block_name']) && strlen($item['block_name'])>0) ? $item['block_name'] : "&nbsp;")."</div>
            <div class='some-element clickable edit hovered'></div>
            <div class='pre_toggler'></div>
            <div class='some-element movable move hovered'></div>
            <div class='pre_toggler'></div>
            <div class='some-element clickable delete hovered'></div>
            <div class='pre_toggler'></div>
          </div>
          <div class='clear'></div>
          <div class='hide_area'>
            <div class='some-padding'>
              <div class='caption'>" . __('Name', 'gt3_builder') . "</div>
              <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][block_name]' value='".esc_attr($item['block_name'])."'>
							<div class='price_area'>
								<div class='price_area1'>
									<div class='caption'>" . __('Currency', 'gt3_builder') . "</div>
									<input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][block_currency]' value='".esc_attr($item['block_currency'])."'>
								</div>
								<div class='price_area2'>
									<div class='caption'>" . __('Price', 'gt3_builder') . "</div>
									<input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][block_price]' value='".esc_attr($item['block_price'])."'>
								</div>
							</div>
              <div class='caption'>" . __('Description', 'gt3_builder') . "</div>
              <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][block_period]' value='".esc_attr($item['block_period'])."'>
              
              <div class='caption'>" . __('"Get it now" Link', 'gt3_builder') . "</div>
              <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][block_link]' value='{$item['block_link']}'>
              <div class='caption'>" . __('"Get it now" caption', 'gt3_builder') . "</div>
              <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][get_it_now_caption]' value='".esc_attr($item['get_it_now_caption'])."'>
              <div class='caption' style='float:left; margin-top: 13px; margin-right: 15px;'>" . __('Most popular', 'gt3_builder') . "</div>

              " . toggle_radio_yes_no("pagebuilder[modules][$moduleid][module_items][$itemid][most_popular]", $item['most_popular'], "no", "most_popular") . "

              <div class='clear'></div>
            </div>
          </div>
        </li>

      ";
      }
    }
    $compile .= "
      </ul>
      <div class='clear'></div>
    </div>
    <div class='dbg'></div>
    </div>
    </div>
    <div class='clear'></div>
    </div>
    <div class='padding-cont'>
    
    " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
  </div>
  " . get_module_settings_part_done_btn() . "
</div>
    ";
    /* END POPUP HTML */
  }
#MODULE END

###########################################################################################
################################ DISHES MODULE START #################################
###########################################################################################
  if ($module_name == "dishes") {
      /* START POPUP HTML */
      $compile .= "
  <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
  <div class='pop_scrollable_area'>
    " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
    <div class='padding-cont'>
      " . get_module_settings_part_media_attach_id_upload($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Select Image", "gt3_builder"), "dish_imageurl") . "  
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Dish Category", "gt3_builder"), "dish_category", "100%", "left") . "
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Dish Title", "gt3_builder"), "dish_title", "100%", "left") . "
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Dish Description", "gt3_builder"), "dish_description", "100%", "left") . "
      " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Module orientation", "gt3_builder"), "orientation", "200px", array("rtl" => "RTL", "ltr" => "LTR")) . "
      " . get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Link", "gt3_builder"), "link", "100%", "left") . "
      " . get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"], __("Target", "gt3_builder"), "target", "200px", array("_blank" => "Blank", "_self" => "Self")) . "
       
      " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
      <div class='clear'></div>
    </div>
    " . get_module_settings_part_done_btn() . "
  </div>
      ";
      /* END POPUP HTML */
    }

#MODULE END


  ###########################################################################################
  ################################ TIMETABLE MODULE START #################################
  ###########################################################################################
    if ($module_name == "timetable") {
      /* START POPUP HTML */
      $compile .= "
  <h2>{$module_caption} settings</h2><span class='edit_popup_close'></span>
  <div class='pop_scrollable_area'>
    " . get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $GLOBALS["pbconfig"]) . "
    <div class=''>
      <div class='rows_must_be_here'>
        <div class='padding-cont'>
        <input type='hidden' value='{$moduleid}' class='moduleid' name='moduleid'>
        <div class='heading line_option visual_style1 small_type hovered clickable add_new_timetable_block'>
          <div class='option_title text-shadow1'>" . __('Add time interval', 'gt3_builder') . "</div>
          <div class='some-element cross'></div>
          <div class='pre_toggler'></div>
        </div>
        <div class='clear'></div>
        </div>
        <div class='pb-popup-white-bg'>
        <div class='padding-cont'>
        <ul class='sections row-list' style='margin-top:7px !important;'>";
      if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['module_items']) && is_array($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'])) {
        foreach ($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'] as $itemid => $item) {
          $compile .= "

          <li class='section'>
            <div class='heading line_option visual_style1 big_type'>
              <div class='option_title text-shadow1'>".((isset($item['time_interval']) && strlen($item['time_interval'])>0) ? $item['time_interval'] : "&nbsp;")."</div>
              <div class='some-element clickable edit hovered'></div>
              <div class='pre_toggler'></div>
              <div class='some-element movable move hovered'></div>
              <div class='pre_toggler'></div>
              <div class='some-element clickable delete hovered'></div>
              <div class='pre_toggler'></div>
            </div>
            <div class='clear'></div>
            <div class='hide_area'>
              <div class='some-padding'>
                <div class='caption'>" . __('Time interval', 'gt3_builder') . "</div>
                <input class='expanded_text type3 section_name' name='pagebuilder[modules][$moduleid][module_items][$itemid][time_interval]' value='".esc_attr($item['time_interval'])."'>
                <div class='caption'>" . __('Monday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][monday_timetable]' value='".esc_attr($item['monday_timetable'])."'>
                <div class='caption'>" . __('Tuesday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][tuesday_timetable]' value='".esc_attr($item['tuesday_timetable'])."'>
                <div class='caption'>" . __('Wednesday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][wednesday_timetable]' value='".esc_attr($item['wednesday_timetable'])."'>
                <div class='caption'>" . __('Thursday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][thursday_timetable]' value='".esc_attr($item['thursday_timetable'])."'>
                <div class='caption'>" . __('Friday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][friday_timetable]' value='".esc_attr($item['friday_timetable'])."'>
                <div class='caption'>" . __('Saturday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][saturday_timetable]' value='".esc_attr($item['saturday_timetable'])."'>
                <div class='caption'>" . __('Sunday', 'gt3_builder') . "</div>
                <input class='expanded_text type3' name='pagebuilder[modules][$moduleid][module_items][$itemid][sunday_timetable]' value='".esc_attr($item['sunday_timetable'])."'>

                <div class='clear'></div>
              </div>
            </div>
          </li>

        ";
        }
      }
      $compile .= "
        </ul>
        <div class='clear'></div>
      </div>
      <div class='dbg'></div>
      </div>
      </div>
      <div class='clear'></div>
      </div>
      <div class='padding-cont'>
      
      " . get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid) . "
    </div>
    " . get_module_settings_part_done_btn() . "
  </div>
      ";
      /* END POPUP HTML */
    }
  #MODULE END


  $compile .= $all_items_after_html;
  return $compile;
}

?>