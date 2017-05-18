<?php

class singleimage_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_singleimage($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',   
                'heading_alignment' => 'center',           
                'singleimage_url' => '',	
                'heading_style' => 'yes',			
			), $atts ) );

      #heading
      $compile .= '<div class="module_wrapper">';
      if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}		
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }
			
			$compile .= "
				<div class='single_image'>								
					".((strlen($singleimage_url)>0) ? "<img src='" . $singleimage_url . "' alt=''>" : "") . "														
				</div>
				";
						
			$compile .= '</div>';
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_singleimage');
	}
}

#Shortcode name
$shortcodeName="singleimage";
#Register shortcode & set parameters
$singleimage = new singleimage_shortcode();
$singleimage->register_shortcode($shortcodeName);

?>