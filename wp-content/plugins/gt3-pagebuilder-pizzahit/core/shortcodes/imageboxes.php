<?php

class imagebox_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_imagebox($atts, $content = null) {

      if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'center',
								'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'imagebox_heading' => '',
                'button_link' => '',
                'button_text' => '',
                'target' => '_blank',
                'link' => '',
                'imagebox_imageurl' => '',
                'imagebox_image_width' => '',
                'imagebox_image_height' => '',
                'heading_style' => 'yes',
			), $atts ) );

      #heading
      $compile .= '<div class="module_wrapper">';
      if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}

      if (!$imagebox_image_width) $imagebox_image_width = "60";
      if (!$imagebox_image_height) $imagebox_image_height = "60";
			if (strlen($imagebox_imageurl) > 0) {
				$imagebox_image_code = "<img src='". aq_resize($imagebox_imageurl, $imagebox_image_width*2, $imagebox_image_height*2, true, true, true) ."' alt='' style='width:" . $imagebox_image_width . "px; height:" . $imagebox_image_height . "px;'/>";
			} else {
				$imagebox_image_code = "";
			}		
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}	
			
	    if (strlen($heading_text)>0) {
	        $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
	    }

            $compile .= "
			<div class='module_content shortcode_imagebox'>
				".((strlen($link)>0) ? "<a target='".$target."' href='".$link."'>" : "")."			
				<div class='imagebox_wrapper'>" . $imagebox_image_code . (strlen($imagebox_heading) ? "<h6 class='imagebox_title'>" . $imagebox_heading. "</h6>" : "") . "				
					<div class='imagebox_body'>						
						".$content."
					</div>					
				</div>
				".((strlen($link)>0) ? "</a>" : "")."
			</div>
			";
			$compile .= '</div>';
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_imagebox');
	}
}

#Shortcode name
$shortcodeName="imagebox";
#Register shortcode & set parameters
$imagebox = new imagebox_shortcode();
$imagebox->register_shortcode($shortcodeName);

?>