<?php

class adblock_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_adblock($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'center',
								'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'adblock_bg' => '',
                'button_link' => '',
                'button_text' => '',
                'target' => '_blank',
                'link' => '',
                'heading_style' => 'yes',
			), $atts ) );

      #heading
      $compile .= '<div class="module_wrapper'. (($heading_style == 'yes') ? ' light_mode' : '') .'"><div class="overlay_bg" style="'. ((strlen($adblock_bg) > 0) ? 'background: url(' . aq_resize($adblock_bg, 1170, NULL, true, true, true) . ') center center no-repeat; background-size: cover;' : '') .'"></div><div class="overlay"></div>';
      if (strlen($heading_color)>0) {$custom_color = "color:{$heading_color};";}
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}	
	    if (strlen($heading_text)>0) {
	        $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
	    }

            $compile .= "
			<div class='module_content shortcode_adblock'>
				<div class='adblock_wrapper'>
					<div class='adblock_slogan'>".$content."</div>
					<div class='adblock_link'>" . ((strlen($link)>0) ? "<a class='shortcode_button btn_large btn_type1' target='".$target."' href='".$link."'>". $button_text ."</a>" : "") ."</div>							
				</div>
			</div>
			</div>";
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_adblock');
	}
}

#Shortcode name
$shortcodeName="adblock";
#Register shortcode & set parameters
$adblock = new adblock_shortcode();
$adblock->register_shortcode($shortcodeName);

?>