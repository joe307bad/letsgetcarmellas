<?php

function get_pb_parser($modules)
{
  global $lineWidth; $compile = "";
  if (!is_array($modules)) {$modules=array();}
  $allModulesCount = count($modules);
  $normalModulesCount = 0;
  $allModulesICounter = 0;
  $normalModulesICounter = 0;

  #Count normal modules
  foreach ($modules as $module_key => $module) {
    if ($module['name']!=="bg_start" && $module['name']!=="bg_end") {
      $normalModulesCount++;
    }
  }

  foreach ($modules as $module_key => $module) {
    $allModulesICounter++;
    if ($module['name']=="bg_start" || $module['name']=="bg_end") {
      if ($module['name']=="bg_start") {
        $GLOBALS['showOnlyOneTimeJS']['fw_block'] = "
        <script>
          function fw_block() {
            if (jQuery('div').hasClass('right-sidebar') || jQuery('div').hasClass('left-sidebar')) {} else {
              jQuery('.module_line_trigger').each(function(){
                  var fw_block = jQuery(this);
                  var fw_block_parent = fw_block.parent().width();
                  var fw_site_width = jQuery(window).width();
                  var fw_contentarea_site_width_diff = fw_site_width - fw_block_parent;
                  if (!(fw_block).hasClass('fullwidth_mode'))
                  fw_block.css('margin-left', '-'+fw_contentarea_site_width_diff/2+'px').css('width', fw_site_width+'px').children().css('padding-left', fw_contentarea_site_width_diff/2+'px').css('padding-right', fw_contentarea_site_width_diff/2+'px');
                  if (fw_block.attr('data-option') == 'paralax') fw_block.css('background-attachment', 'fixed!important');
                jQuery('.module_google_map .fw_wrapinner, .module_wall .fw_wrapinner').css('padding-left', '0px').css('padding-right', '0px');
              });
              
            }
          }
          jQuery(document).ready(function() {
            jQuery('.module_line_trigger').wrapInner('<div class=\"fw_wrapinner\"></div>');
            fw_block();
          });
          jQuery(window).resize(function(){
            fw_block();
          });
        </script>
        ";
        $gt3_bg_image_position = ' left-center-background ';
        if (isset($module['bg_image_position']))
          if ($module['bg_image_position'] == 'right') $gt3_bg_image_position = ' right-center-background '; else if ($module['bg_image_position'] == 'center') $gt3_bg_image_position = ' center-background ';
        $compile .= '<div class="module_line_trigger ' . $module['properties'] . ' '.((isset($module['fullwidth_mode']) && $module['fullwidth_mode'] == "yes") ? ' fullwidth_mode ' : '').$gt3_bg_image_position.(isset($module['custom_class']) ? $module['custom_class'] : '').'" data-option="'.$module['properties'].'" style= "background: '.((strlen($module['bg_color'])>0) ? "".$module['bg_color'] : '').' '.((strlen($module['bg_image'])>0) ? "url('".$module['bg_image']."')" : '').' '.((strlen($module['properties']) == "stretch") ? 'no-repeat' : 'repeat').' 0 0; padding-top:'.$module['padding_top'].'; margin-bottom:'.$module['padding_bottom'].';">';
      }
      if ($module['name']=="bg_end") {
        // if ($lineWidth<1) {
        //   $compile .= '</div><!-- bg_end here -->';
        // }
        $compile .= '</div><!-- module_line_trigger -->';
        $lineWidth = 1;
      }
    }
    else {
      $normalModulesICounter++;

      #GET SIZE
      if ($module['size'] == "block_1_4") {
        $outputClass = "col-xs-12 col-sm-3";
      }
      if ($module['size'] == "block_1_3") {
        $outputClass = "col-xs-12 col-sm-4";
      }
      if ($module['size'] == "block_1_2") {
        $outputClass = "col-xs-12 col-sm-6";
      }
      if ($module['size'] == "block_2_3") {
        $outputClass = "col-xs-12 col-sm-8";
      }
      if ($module['size'] == "block_3_4") {
        $outputClass = "col-xs-12 col-sm-9";
      }
      if ($module['size'] == "block_1_1") {
        $outputClass = "col-xs-12";
      }

      if ($normalModulesICounter == 1 || $lineWidth >= 1) {
        $lineWidth = 0;
        $compile .= "<div class='row'>";
      }
			
      #open main module container
      $compile .= "<div style='padding-bottom:{$module['padding_bottom']};' class='{$outputClass} ".(($normalModulesICounter==1) ? "first-module" : "")." module_number_{$normalModulesICounter} module_cont ".(isset($module['custom_class']) ? $module['custom_class'] . ' ' : '').((isset($module['heading_alignment']) && $module['heading_alignment'] == "center") ? 'center_title' : '')." module_{$module['name']}'>";

      ################################################################################################
      #######################################            #############################################
      ####################################### CASE START #############################################
      #######################################            #############################################
      ################################################################################################
      switch ($module['name']) {

        #NEW MODULE
        case "title":
          $compile .= do_shortcode("[title
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."'          
          ]".$module["heading_text"]."[/title]");
          break;
        #BREAK

        #NEW MODULE
        case "text_area":
          $compile .= do_shortcode("[textarea
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          ]".$module["text"]."[/textarea]");
          break;
        #BREAK

        #NEW MODULE
        case "menu":
          $compile .= do_shortcode("[menu
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."'
          heading_style='".$module["heading_style"]."'
          menu_view_type='" . $module["menu_view_type"] . "'
          menu_type='" . $module["menu_type"] . "'
          prod_cat='" . $module["prod_cat"] . "'
          prod_ids='" . $module["prod_ids"] . "'
          ][/menu]");
          break;
        #BREAK

        #NEW MODULE
        case "html":
          $compile .= do_shortcode("[textarea
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          module='html'
          ]".$module["html"]."[/textarea]");
          break;
        #BREAK

        #NEW MODULE
        case "javascript":
          $compile .= do_shortcode("[textarea
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          module='html'
          ]".$module["html"]."[/textarea]");
          break;
        #BREAK

        #NEW MODULE
        case "layer_slider":
          $compile .= do_shortcode("[textarea
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          module='html'
          ]".$module["html"]."[/textarea]");
          break;
        #BREAK

        #NEW MODULE
        case "content":
          #heading
          if (strlen($heading_text)>0) {
            $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code ."</div>";
          }
          $compile .= "<div class='module_content'>";
          $compile .= str_replace("\r", "<br />", get_the_content(__('Read more!', 'gt3_builder')));

          $compile .= "</div>";
          global $gt3_contentAlreadyPrinted;
          $gt3_contentAlreadyPrinted = true;
          break;
        #BREAK

        #NEW MODULE
        case "google_map":
          $compile .= do_shortcode("[textarea
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          module='map'
          ]".$module["map"]."[/textarea]");
          break;
        #BREAK

        #NEW MODULE
        case "social_share":
          $compile .= do_shortcode("[social_share
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          ][/social_share]");
          break;
        #BREAK

        #NEW MODULE
        case "testimonial":

          $compile_cpt_ids = array();

          if (isset($module["cpt_ids"]) && (is_array($module["cpt_ids"]))) {
            foreach ($module["cpt_ids"] as $testkey => $testvalue) {
              array_push($compile_cpt_ids, $testkey);
            }
          }

          $compile .= do_shortcode("[testimonials
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          cpt_ids='".implode(",", $compile_cpt_ids)."'
          sorting_type='".$module["sorting_type"]."'
          ][/testimonials]");
          break;
        #BREAK

        #NEW MODULE
          case "single_image":
          $compile .= do_shortcode("[singleimage
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          singleimage_url='".$module["singleimage_url"]."'
           ][/singleimage]");
          break;
        #BREAK

        #NEW MODULE
        case "video":
          $compile .= do_shortcode("[video
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          w='100%'
          h='".$module["video_height"]."'
          video_url='".$module["video_url"]."'
          video_cover_image='".$module["video_cover_image"]."'
          ][/video]");
          break;
        #BREAK

        #NEW MODULE
        case "divider":
          $compile .= do_shortcode("[divider
          divider_color='".$module["divider_color"]."'
          ][/divider]");
          break;
        #BREAK

        #NEW MODULE
        case "gallery":
					if (isset($module["selected_gallery"])) {
						$selected_gallery = $module["selected_gallery"];
					} else {
						$selected_gallery = '';
					}

          if (isset($module["fullwidth_gallery"])) {
            $fullwidth_gallery = $module["fullwidth_gallery"];
          } else {
            $fullwidth_gallery = 'no';
          }
					
          $compile .= do_shortcode("[show_gallery
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          preview_thumbs_format='".$module["preview_thumbs_format"]."'
          fullwidth_gallery = '".$module["fullwidth_gallery"]."'
          galleryid='".$selected_gallery."'
          images_in_a_row='".$module["images_in_a_row"]."'
          ][/show_gallery]");
          break;
        #BREAK

        #NEW MODULE
        case "team":
          $compile_cpt_ids = array();

          if (isset($module["cpt_ids"]) && (is_array($module["cpt_ids"]))) {
            foreach ($module["cpt_ids"] as $testkey => $testvalue) {
              array_push($compile_cpt_ids, $testkey);
            }
          }

          $compile .= do_shortcode("[ourteam
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          items_per_line='".$module["items_per_line"]."'
          vertical='".$module["vertical"]."'
          order='".$module["order"]."'
          cpt_ids='".implode(",", $compile_cpt_ids)."'][/ourteam]");
          break;
        #BREAK

        #NEW MODULE
        case "accordion":

            if (!isset($accompile)) {$accompile='';}

            if (is_array($module["module_items"])) {
                foreach ($module["module_items"] as $acckey => $acc_item) {
                    $accompile .= "[accordion_item title='".$acc_item['title']."' expanded_state='".$acc_item['expanded_state']."']".$acc_item['description']."[/accordion_item]";
                }
            }
            $compile .= do_shortcode("[accordion_shortcode
            heading_text='".$module["heading_text"]."'
            heading_alignment='".$module["heading_alignment"]."'
            heading_size='".$module["heading_size"]."'
            subtitle_text='".$module["subtitle_text"]."' 
            heading_style='".$module["heading_style"]."' 
            ]".$accompile."[/accordion_shortcode]");
            unset($accompile);
            break;
        #BREAK

        #NEW MODULE
        case "classes":

            if (!isset($clcompile)) {$clcompile='';}

            if (is_array($module["module_items"])) {
                foreach ($module["module_items"] as $clckey => $cl_item) {
                    $clcompile .= "[classes_item title='".$cl_item['title']."']".$cl_item['description']."[/classes_item]";
                }
            }
            $compile .= do_shortcode("[classes_shortcode
            heading_text='".$module["heading_text"]."'
            heading_alignment='".$module["heading_alignment"]."'
            heading_size='".$module["heading_size"]."'
            subtitle_text='".$module["subtitle_text"]."' 
            heading_style='".$module["heading_style"]."' 
            ]".$clcompile."[/classes_shortcode]");
            unset($clcompile);

            break;
        #BREAK

        #NEW MODULE
        case "feature_posts":
          $compile_cats = array();

          if (isset($module["selected_categories"]) && (is_array($module["selected_categories"]))) {
            foreach ($module["selected_categories"] as $catkey => $catvalue) {
              array_push($compile_cats, $catkey);
            }
          }

          $compile_cats = implode(",", $compile_cats);

          $compile .= do_shortcode("[feature_posts
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          number_of_posts='".$module["number_of_posts"]."'
          posts_per_line='".$module["posts_per_line"]."'
          selected_categories='".$compile_cats."'
          sorting_type='".$module["sorting_type"]."'
          [/feature_posts]");
          break;
        #BREAK

        #NEW MODULE
        case "iconboxes":
          $compile .= do_shortcode("[iconbox
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          icon_type='".$module["icon_type"]."'
          target='".$module["target"]."'
          link='".$module["link"]."'
          iconbox_heading='".$module["iconbox_heading"]."'
          ]".$module["iconbox_text"]."[/iconbox]");
          break;
        #BREAK

        #NEW MODULE
        case "adblock":
          $compile .= do_shortcode("[adblock
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          button_text='".$module["button_text"]."' 
          adblock_bg='".$module["adblock_bg"]."' 
          target='".$module["target"]."'
          link='".$module["link"]."'
          ]".$module["adblock_slogan"]."[/adblock]");
          break;
        #BREAK

        #NEW MODULE
        case "imageboxes":
          $compile .= do_shortcode("[imagebox
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          imagebox_imageurl='".$module["imagebox_imageurl"]."'
          imagebox_image_width='".$module["imagebox_image_width"]."'
          imagebox_image_height='".$module["imagebox_image_height"]."'
          target='".$module["target"]."'
          link='".$module["link"]."'
          imagebox_heading='".$module["imagebox_heading"]."'
          ]".$module["imagebox_text"]."[/imagebox]");
          break;
        #BREAK

        #NEW MODULE
        case "dishes":
          $compile .= do_shortcode("[dishes
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          dish_imageurl='".$module["dish_imageurl"]."'
          dish_category='".$module["dish_category"]."'
          dish_title='".$module["dish_title"]."'
          target='".$module["target"]."'
          orientation='".$module["orientation"]."'
          link='".$module["link"]."'
          ]".$module["dish_description"]."[/dishes]");
          break;
        #BREAK

        #NEW MODULE
        case "counter":
          $compile .= do_shortcode("[counter
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
					stat_title='".$module["stat_title"]."'
          ]".$module["stat_count"]."[/counter]");
          break;
        #BREAK

        #NEW MODULE
        case "blockquote":
          $compile .= do_shortcode("[blockquote
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          quote_type='".$module["quote_type"]."'
          author_name='".$module["author_name"]."'
          ]".$module["quote_text"]."[/blockquote]");
          break;
        #BREAK

        #NEW MODULE
        case "price_table":

          if (!isset($tempcompile)) {$tempcompile='';}

          if (isset($module["module_items"]) && is_array($module["module_items"])) {
            $price_items_number = count($module["module_items"]);
            $thiswidth = 100/$price_items_number;
            foreach ($module["module_items"] as $key => $thisitem) {

              if (isset($thisitem['price_features']) && is_array($thisitem['price_features'])) {
                $price_features = implode("||-||", $thisitem['price_features']);
              } else {
                $price_features = '';
              }

              $tempcompile .= "[pricetable_item block_name='".esc_attr($thisitem['block_name'])."' block_price='".esc_attr($thisitem['block_price'])."' block_currency='".esc_attr($thisitem['block_currency'])."' block_period='".esc_attr($thisitem['block_period'])."' price_features='".esc_attr($price_features)."' block_link='".esc_attr($thisitem['block_link'])."' get_it_now_caption='".esc_attr($thisitem['get_it_now_caption'])."' most_popular='".esc_attr($thisitem['most_popular'])."' width='".esc_attr($thiswidth)."'][/pricetable_item]";
            }
          }
          $compile .= do_shortcode("[pricetable
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          price_items_number='".$price_items_number."'
          ]".$tempcompile."[/pricetable]");
          unset($tempcompile, $price_features);
          break;
        #BREAK

        #NEW MODULE
        case "timetable":

          if (!isset($tempcompile)) {$tempcompile='';}

          if (isset($module["module_items"]) && is_array($module["module_items"])) {
            foreach ($module["module_items"] as $key => $thisitem) {
              $tempcompile .= "[timetable_item time_interval='".esc_attr($thisitem['time_interval'])."' monday_timetable='".esc_attr($thisitem['monday_timetable'])."' tuesday_timetable='".esc_attr($thisitem['tuesday_timetable'])."' wednesday_timetable='".esc_attr($thisitem['wednesday_timetable'])."' thursday_timetable='".esc_attr($thisitem['thursday_timetable'])."' friday_timetable='".esc_attr($thisitem['friday_timetable'])."' friday_timetable='".esc_attr($thisitem['friday_timetable'])."' saturday_timetable='".esc_attr($thisitem['saturday_timetable'])."' sunday_timetable='".esc_attr($thisitem['sunday_timetable'])."'][/timetable_item]";
            }
          }
          $compile .= do_shortcode("[timetable
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          ]".$tempcompile."[/timetable]");
          unset($tempcompile);
          break;
        #BREAK

        #NEW MODULE
        case "blog":
          $compile_cat_ids = array();

          if (isset($module["cat_ids"]) && (is_array($module["cat_ids"]))) {
            foreach ($module["cat_ids"] as $testkey => $testvalue) {
              array_push($compile_cat_ids, $testkey);
            }
          }
          $compile .= do_shortcode("[blog
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          posts_per_page='".$module["posts_per_page"]."'
          posts_per_line='".$module["posts_per_line"]."'
          cat_ids='".implode(",", $compile_cat_ids)."'
          ][/blog]");
          break;
        #BREAK

        #NEW MODULE
        case "partners":

          $compile_cpt_ids = array();

          if (isset($module["cpt_ids"]) && (is_array($module["cpt_ids"]))) {
            foreach ($module["cpt_ids"] as $testkey => $testvalue) {
              array_push($compile_cpt_ids, $testkey);
            }
          }

          $compile .= do_shortcode("[partners
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          partners_in_line='".$module["partners_in_line"]."'
          cpt_ids='".implode(",", $compile_cpt_ids)."'
          ][/partners]");
          break;
        #BREAK

        #NEW MODULE
        case "contact_info":
          $compile .= do_shortcode("[contacts
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
					show_bg='". $module["show_bg"] ."'
					contact_list='". $module["contact_list"] ."'
          module_id='".$module_key."'
          ][/contacts]");
          break;
        #BREAK

        #NEW MODULE
        case "diagramm":
          if (!isset($diagcompile)) {$diagcompile='';}
          if (isset($module["module_items"]) && is_array($module["module_items"])) {
            $diag_items_number = count($module["module_items"]);
            $diag_width = 100/count($module["module_items"]);
            
            foreach ($module["module_items"] as $diagkey => $diag_item) {
              $diagcompile .= "[diagramm_item diag_width='".$diag_width."' percent='".$diag_item['percent']."' diag_title='".$diag_item['title']."']".$diag_item['description']."[/diagramm_item]";
            }
          }
          $compile .= do_shortcode("[diagramm
          diagram_bg='".$module["diagram_bg"]."'
          diagram_color='".$module["diagram_color"]."'
          bar_width='".$module["bar_width"]."'
          heading_text='".$module["heading_text"]."'
          heading_alignment='".$module["heading_alignment"]."'
          heading_size='".$module["heading_size"]."'
          subtitle_text='".$module["subtitle_text"]."' 
          heading_style='".$module["heading_style"]."' 
          ]".$diagcompile."[/diagramm]");
          unset($diagcompile);
          break;
        #BREAK


      }
      ################################################################################################
      ########################################      ##############################################
      ######################################## CASE END ##############################################
      ########################################      ##############################################
      ################################################################################################

      #Close main module container

      $compile .= "</div>";

      #If this is last module - close
      if ($normalModulesICounter == $normalModulesCount) {
        $compile .= "</div>";
        continue;
      }

      if ($module['size'] == "block_1_4") {
        $lineWidth += 1/4;
      }
      if ($module['size'] == "block_1_3") {
        $lineWidth += 1/3;
      }
      if ($module['size'] == "block_1_2") {
        $lineWidth += 1/2;
      }
      if ($module['size'] == "block_2_3") {
        $lineWidth += 2/3;
      }
      if ($module['size'] == "block_3_4") {
        $lineWidth += 3/4;
      }
      if ($module['size'] == "block_1_1") {
        $lineWidth += 1;
      }

      #$compile .= CLEAR IF ITS A NEW LINE
      if ($lineWidth >= 1) {
        $compile .= "</div>";
      }
    }
  }

  return $compile;
}

?>