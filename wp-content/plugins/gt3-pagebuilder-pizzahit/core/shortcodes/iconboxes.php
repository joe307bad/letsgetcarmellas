<?php

class iconbox_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_iconbox($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'center',
								'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'iconbox_heading' => '',
                'button_link' => '',
                'button_text' => '',
                'icon_type' => '',
                'style' => 'horizontal',
                'target' => '_blank',
                'link' => '',
                'heading_style' => 'yes',
			), $atts ) );

      #heading
      $compile .= '<div class="module_wrapper">';
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
			<div class='module_content shortcode_iconbox'>
				".((strlen($link)>0) ? "<a target='".$target."' href='".$link."'>" : "")."			
				<div class='iconbox_wrapper'>
					<span class='ico'><i class='fa ".$icon_type."'></i></span><h5 class='iconbox_title'>".$iconbox_heading."</h5>
					<div class='iconbox_body'>						
						".$content."
					</div>					
				</div>
				".((strlen($link)>0) ? "</a>" : "")."
			</div>
			";
			$compile .= '</div>';
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_iconbox');
	}
}

#Shortcode name
$shortcodeName="iconbox";
#Register shortcode & set parameters
$iconbox = new iconbox_shortcode();
$iconbox->register_shortcode($shortcodeName);

?>