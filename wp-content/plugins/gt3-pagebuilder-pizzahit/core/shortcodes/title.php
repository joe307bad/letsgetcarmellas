<?php

class shortcode_title
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_title($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'heading_alignment' => 'center',
				'subtitle_text' => '',
                'heading_size' => 'h3',
                'heading_color' => '',
                'heading_style' => 'yes',
            ), $atts));

            if (strlen($heading_color) > 0) {
                $custom_color = "color:#" . $heading_color . ";";
            }
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}

            return "<div class='module_wrapper'><div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : 'text_align_'.$heading_alignment) . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.';' : '') . "'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>" . $content . "</" . $heading_size . ">" . $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : ''). "</div></div>";

        }

        add_shortcode($shortcodeName, 'shortcode_title');
    }
}

$shortcodeName = "title";
$shortcode_title = new shortcode_title();
$shortcode_title->register_shortcode($shortcodeName);

?>