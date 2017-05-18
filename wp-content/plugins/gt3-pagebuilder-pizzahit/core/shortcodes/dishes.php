<?php

class dishes_shortcode {

    public function register_shortcode($shortcodeName) {
        function shortcode_dishes($atts, $content = null) {

      if (!isset($compile)) {$compile='';}

            extract( shortcode_atts( array(
                'heading_alignment' => 'center',
                                'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'target' => '_blank',
                'link' => '',
                'dish_imageurl' => '',
                'dish_category' => '',
                'dish_title' => '',
                'orientation' => 'rtl',
                'heading_style' => 'yes',
            ), $atts ) );

        #heading
        $compile .= '<div class="module_wrapper">';

        if (strlen($dish_imageurl) > 0) {
            $dish_image_code = "<a class='dish_img' target='". $target ."' href='". $link . "'><div class='dish_img_wrap'><div class='dish_image_inner_wrap' style='background-image: url(".aq_resize($dish_imageurl, "750", "565", true, true, true).")'></div></div></a>";
        } else {
            $dish_image_code = "";
        }       
        if (strlen($subtitle_text) > 0) {
            $subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
        } else {
            $subtitle_code = "";
        }   
            
        if (strlen($heading_text)>0) {
            $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
        }
          
          $left_part = "<div class='category'><span class='dish_counter'></span><h6>". $dish_category ."</h6></div><h5><a href='" . $link . "'>" . $dish_title . "</a></h5><p>" . $content . "</p><a class='dish_link' target='". $target ."' href='". $link . "'></a>";
          $right_part = $dish_image_code;

          $compile .= "
          <div class='module_content shortcode_dishes'>
            <div class='row'>";
              if ($orientation == 'rtl') $compile .= "
                <div class='col-xs-12 col-sm-5 text'>" .
                  $left_part
                . "</div>
                <div class='col-xs-12 col-sm-1'></div>
                <div class='col-xs-12 col-sm-6'>" .
                  $right_part
                . "</div>
                "; else $compile .= "
                <div class='col-xs-12 col-sm-6'>" .
                  $right_part
                . "</div>
                <div class='col-xs-12 col-sm-1'></div>
                <div class='col-xs-12 col-sm-5 text with-margin'>" .
                  $left_part
                . "</div>
                ";

              $compile .= "
            </div>
          </div>
          ";
          $compile .= '</div>';
          return $compile;
        }
        add_shortcode($shortcodeName, 'shortcode_dishes');
    }
}

#Shortcode name
$shortcodeName="dishes";
#Register shortcode & set parameters
$dishes = new dishes_shortcode();
$dishes->register_shortcode($shortcodeName);

?>