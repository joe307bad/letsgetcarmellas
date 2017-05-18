<?php

#diagramm_item
function diagramm_item($atts, $content = null)
{
    if (!isset($compile)) {$compile='';}

    extract(shortcode_atts(array(
        'heading_alignment' => 'left',
        'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
        'heading_color' => '',
        'heading_text' => '',
				'diag_width' => '',
				'diag_title' => '',
        'percent' => '10',
        'heading_style' => 'yes',
    ), $atts));

    wp_enqueue_script('gt3_waypoint_js', get_template_directory_uri() . '/js/waypoint.js', array(), false, false);
    wp_enqueue_script('gt3_chart_js', get_template_directory_uri() . '/js/chart.js', array(), false, false);

    $compile .= '<li class="skill_li" style="width:'.$diag_width.'%"><div class="skill_wrapper"><div class="skill_item"><div class="chart_wrapper"><div class="chart" data-percent="'.$percent.'"><span class="percent">'.$percent.'</span><span>%</span></div></div><div class="skill_content"><h6>'.$diag_title.'</h6><div class="skill_descr">'.$content.'</div></div></div></div></li>';
	
    return $compile;
}

add_shortcode('diagramm_item', 'diagramm_item');

class diagramm_shortcode
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_diagramm_shortcode($atts, $content = null)
        {
            if (!isset($compile)) {$compile='';}

            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
				'diagram_bg' => '#e5e5e5',
				'diagram_color' => '#f9593a',
				'bar_width' => '5px',
				'diagram_size' => '130px',
				'percent_size' => '25px',				
                'title' => '',
                'expanded_state' => '',
                'heading_style' => 'yes',
                'subtitle_text' => 'no',
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

            $compile .= "
                <div class='shortcode_diagramm_shortcode diagramm'><ul class='skills_list' data-bg='".$diagram_bg."' data-color='".$diagram_color."' data-width='".$bar_width."' data-size='".$diagram_size."' data-fontsize='".$percent_size."'>" . do_shortcode($content) . "</ul><div class='clear'></div></div>
			";

						$compile .= '</div>';
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_diagramm_shortcode');
    }
}


#Shortcode name
$shortcodeName = "diagramm";
$diagramm_shortcode = new diagramm_shortcode();
$diagramm_shortcode->register_shortcode($shortcodeName);

?>