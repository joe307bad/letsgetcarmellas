<?php

class show_gallery {

  public function register_shortcode($shortcodeName) {
    function shortcode_show_gallery($atts, $content = null) {
      
      wp_enqueue_script('gt3_swipebox_js', get_template_directory_uri() . '/js/jquery.swipebox.js', array(), false, false);

      $compile = "";
      if (!isset($imgCounter)) $imgCounter = 0;

      extract( shortcode_atts( array(
        'heading_alignment' => 'center',
        'subtitle_text' => '',
        'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
        'heading_color' => '',
        'heading_text' => '',
        'preview_thumbs_format' => 'rectangle',
        'images_in_a_row' => '4',
        'width' => $GLOBALS["pbconfig"]['gallery_module_default_width'],
        'height' => $GLOBALS["pbconfig"]['gallery_module_default_height'],
        'galleryid' => '',
        'fullwidth_gallery' => 'no',
        'heading_style' => 'yes',
      ), $atts ) );

      if ($preview_thumbs_format == "masonry") {
        wp_enqueue_script('isotope_js', GT3PBPLUGINROOTURL . 'js/jquery.isotope.min.js', array(), false, false);
        wp_enqueue_script('sorting_js', GT3PBPLUGINROOTURL . 'js/sorting.js', array(), false, false);
      }

      if ($preview_thumbs_format == "slider") {
        wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, true);
      }

      $items_set = array();
      $uniqid = mt_rand(0, 9999);

      switch($images_in_a_row) {
        case '1':
          if ($preview_thumbs_format == "square") {
            $width = "1170px";
            $height = "1170px";
          } else if ($preview_thumbs_format == "rectangle") {
            $width = "1170px";
            $height = "886px";
          } else {
             $width = "1170px";
             $height = NULL; 
          }
          $rowClass = "images_in_a_row_1";
          break;
          
        case '2':
          if ($preview_thumbs_format == "square") {
            $width = "810px";
            $height = "810px";
          } else if ($preview_thumbs_format == "rectangle") {
            $width = "810px";
            $height = "614px";
          } else {
            $width = "810px";
            $height = NULL;
          }
          $rowClass = "images_in_a_row_2";
          break;

        case '3':
          if ($preview_thumbs_format == "square") {
            $width = "810px";
            $height = "810px";
          } else if ($preview_thumbs_format == "rectangle") {
            $width = "810px";
            $height = "614px";
          } else {
            $width = "810px";
            $height = NULL;
          }
          $rowClass = "images_in_a_row_3";
          break;

        case '4':
          if ($preview_thumbs_format == "square") {
            $width = "540px";
            $height = "540px";
          } else if ($preview_thumbs_format == "rectangle") {
            $width = "540px";
            $height = "409px";
          } else {
            $width = "540px";
            $height = NULL;
          }
          $rowClass = "images_in_a_row_4";
          break;

        case 'fw':
          if ($preview_thumbs_format == "square") {
            $width = "540px";
            $height = "540px";
          } else if ($preview_thumbs_format == "rectangle") {
            $width = "540px";
            $height = "409px";
          } else {
            $width = "540px";
            $height = NULL;
          }
          $rowClass = "fw_gallery";
          break;
      }

      #heading
      $compile .= '<div class="module_wrapper ' . (($fullwidth_gallery == 'yes') ? 'fullwidth_mode' : '') .' ">';
      if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
      if (strlen($subtitle_text) > 0) {
        $subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
      } else {
        $subtitle_code = "";
      }       
      
      if (strlen($heading_text)>0) {
        $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
      }
      if ($preview_thumbs_format != 'slider') {
        $compile .= "<div class='dm_lightbox_only sorting_block list-of-images galid-".$uniqid.' '.$rowClass. (($preview_thumbs_format == "masonry") ? ' sorting_block': '') . "'>";

        $galleryPageBuilder = get_plugin_pagebuilder($galleryid);

        if (isset($galleryPageBuilder['sliders']['fullscreen']['slides']) && is_array($galleryPageBuilder['sliders']['fullscreen']['slides'])) {
          foreach ($galleryPageBuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {

            $all_views[$imageid] = (isset($all_views[$imageid]) ? $all_views[$imageid] : 0)+1;

            if (isset($image['title']['value']) && strlen($image['title']['value'])>0) {
              $photoTitle = $image['title']['value'];
            } else {
              $photoTitle = '';
            }
            $photoAlt = get_post_meta($image['attach_id'], '_wp_attachment_image_alt', true);
            if (isset($image['caption']['value']) && strlen($image['caption']['value'])>0) {$photoCaption  = $image['caption']['value'];} else {$photoCaption = "";}
              if (isset($image['title']['color']) && strlen($image['title']['color'])>0) {$titleColor  = $image['title']['color'];} else {$titleColor = "";}
              if (isset($image['caption']['color']) && strlen($image['caption']['color'])>0) {$captionColor  = $image['caption']['color'];} else {$captionColor = "";}            

            $imgCounter ++;
              $compile .= '
              <div class="gallery_item' . (($preview_thumbs_format == "masonry") ? ' element': '') . '">
                <div class="gallery_item_padding">
                  <div class="gallery_item_wrapper">';
                  $img4work = wp_get_attachment_image_src($image["attach_id"], 'original');

                  if ($image['slide_type'] == 'image') {                
                    $img_width = $img4work[1];
                    $img_height = $img4work[2];
                    $img_ratio = $img_width/$img_height;
                    $compile .= '<a class="swipebox" href="'. $img4work[0] .'" title="'. esc_attr($photoTitle) .'">';
                  } else  {
                    $set_rel = '';
                    #YOUTUBE
                    $is_youtube = substr_count($image['src'], "youtu");   
                    if ($is_youtube > 0) {
                      $set_rel = 'youtube';
                      $videoid = substr(strstr($image['title']['value'], "="), 1);           
                      $compile .= '<a class="swipebox" rel="'. $set_rel .'" href="'. $image['src'] .'" title="'. esc_attr($photoTitle) .'">';
                    }
                    #VIMEO
                    $is_vimeo = substr_count($image['src'], "vimeo");
                    if ($is_vimeo > 0) {
                      $set_rel = 'vimeo';
                      $videoid = substr(strstr($image['title']['value'], "m/"), 2);
                      $compile .= '<a class="swipebox" rel="'. $set_rel .'" href="'. $image['src'] .'" title="'. esc_attr($photoTitle).'">';
                    }
                  }
                  $compile .= '<div class="img_block"><img class="img2preload" data-title = "'. esc_attr($photoTitle) .'" data-caption = "'. esc_attr($photoCaption) .'"  data-title-color = "'. esc_attr($titleColor) .'" data-caption-color = "'. esc_attr($captionColor) .'"  data-img="'. wp_get_attachment_url($image['attach_id']) .'" src="'. aq_resize(wp_get_attachment_url($image['attach_id']), $width, $height, true, true, true) .'" alt="'. esc_attr($photoAlt) .'" />';
                                
                        $compile .= '
                        <div class="gallery_fadder"></div>';                      
                      $compile .= '</div>
                    </a>
                  </div>
                </div>
              </div>
              '; 
            unset($photoTitleOutput, $photoCaption);
          }
          gt3pb_update_option("views", $all_views);
        }

        $compile .= "
        <div class='clear'></div>
        </div>
        ";    
        } else {
         //slider
          $compile .= "<div class='gallery-slider ". $preview_thumbs_format ."'>";
          if ($fullwidth_gallery == 'yes') {
            $width = '1920px';
            $height = '1230px';
          } else {
            $width = '1750px';
            $height = '1125px';
          }

          $galleryPageBuilder = get_plugin_pagebuilder($galleryid);

          if (isset($galleryPageBuilder['sliders']['fullscreen']['slides']) && is_array($galleryPageBuilder['sliders']['fullscreen']['slides'])) {
            foreach ($galleryPageBuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {
              $all_views[$imageid] = (isset($all_views[$imageid]) ? $all_views[$imageid] : 0)+1;
              $imgCounter ++;
              $compile .= '<div class="slide-wrap">';
                if ($image['slide_type'] == 'image') {                
                   $compile .= '<img src="'. aq_resize(wp_get_attachment_url($image['attach_id']), $width, $height, true, true, true) .'" alt="" />';
                } else if ($image['slide_type'] == 'video') {
                  $compile .= '<div class="slider_video" data-href="'. $image['src'] .'"></div>';

                }
              $compile .= '</div>' ;
            }
          }
          $compile .= '</div><div class="clear"></div>';
        }
      
           
      $compile .= '</div>';   
      return $compile;
      
    }
    add_shortcode($shortcodeName, 'shortcode_show_gallery');
  }
}

#Shortcode name
$shortcodeName="show_gallery";
$shortcode_show_gallery = new show_gallery();
$shortcode_show_gallery->register_shortcode($shortcodeName);

?>