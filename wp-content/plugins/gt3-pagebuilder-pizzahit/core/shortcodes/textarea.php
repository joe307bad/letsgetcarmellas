<?php

class textarea {

	public function register_shortcode($shortcodeName) {
		function shortcode_textarea($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
              'heading_alignment' => 'center',
			  'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
			  'heading_color' => '',
              'subtitle_text' => '',
			  'heading_text' => '',
			  'module' => '',
			  'text' => '',
              'heading_style' => 'yes',
			), $atts ) );

            
            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($subtitle_text) > 0) {
                $subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
            } else {
                $subtitle_code = "";
            }   
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
			    $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }


            if ($module=="map") {
                $compile .= "
                <div class='module_content'>
                        ".do_shortcode($content)."
                </div>";
            } elseif ($module=="html") {
                $compile .= "
                <div class='module_content'>
                    ".do_shortcode($content)."
                </div>";
            } elseif ($module=="js") {
                $compile .= "
                <div class='module_content'>
                    ".do_shortcode($content)."
                </div>";
            }
            else {
                $compile .= "
                <div class='module_content'>
                    ".do_shortcode($content)."
                </div>";
            }

            $compile .= '</div>';

            return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_textarea');
	}
}

#Shortcode name
$shortcodeName="textarea";
$shortcode_textarea = new textarea();
$shortcode_textarea->register_shortcode($shortcodeName);

?>