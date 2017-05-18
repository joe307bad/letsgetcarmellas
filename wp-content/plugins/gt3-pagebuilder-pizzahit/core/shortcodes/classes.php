<?php

#classes_item
function classes_item($atts, $content = null)
{
    $compile = '';

    extract(shortcode_atts(array(
        'heading_alignment' => 'center',
        'subtitle_text' => '',
        'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
        'heading_color' => '',
        'heading_text' => '',
        'title' => '',
        'expanded_state' => '',
        'heading_style' => 'no',
    ), $atts));

    $compile .= "<div class='classes_box'><span class='dropcaps'></span><h5>" . $title . "</h5><div class='shortcode_classes_item_body'>" . $content . "</div></div>";

    return $compile;
}

add_shortcode('classes_item', 'classes_item');


class classes_shortcode
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_classes_shortcode($atts, $content = null)
        {
            $compile = '';

            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'title' => '',
                'expanded_state' => '',
                'heading_style' => 'yes',
            ), $atts));

            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($heading_color) > 0) {
                $custom_color = "color:{$heading_color};";
            }
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }

            $compile .= "<div class='shortcode_classes_shortcode class'>" . do_shortcode($content) . "</div>";
            $compile .= '</div>';
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_classes_shortcode');
    }
}

#Shortcode name
$shortcodeName = "classes_shortcode";
$classes_shortcode = new classes_shortcode();
$classes_shortcode->register_shortcode($shortcodeName);
?>