<?php

class counter_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_counter($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'center',
				        'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
				        'stat_title' => '',
				        'heading_style' => 'yes',
			), $atts ) );

			wp_enqueue_script('gt3_waypoint_js', get_template_directory_uri() . '/js/waypoint.js', array(), false, false);

      #heading
      $compile .= '<div class="module_wrapper">';
      if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}				
      if (strlen($heading_text)>0) {
          $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
      }

            $compile .= "		
			<div class='module_content shortcode_counter'>
				<div class='counter_wrapper'>
					<div class='counter_content'>
						<div class='counter_title_wrapper'><h5 class='counter_title'>".$stat_title."</h5></div>
						<div class='stat_count_wrapper'>						
							<h3 class='stat_count' data-count='".$content."'>0</h3>
						</div>
						<div class='counter_body'>							
							<div class='stat_temp'></div>
						</div>
					</div>
				</div>
			</div>
			";

			$compile .= '</div>';
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_counter');
	}
}

#Shortcode name
$shortcodeName="counter";
#Register shortcode & set parameters
$counter = new counter_shortcode();
$counter->register_shortcode($shortcodeName);

?>