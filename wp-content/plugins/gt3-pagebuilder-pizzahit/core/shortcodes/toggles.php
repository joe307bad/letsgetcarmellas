<?php

#toggles_item
function toggles_item($atts, $content = null) {

	global $toggtemmpi;
    if (!isset($compile)) {$compile='';}

	extract( shortcode_atts( array(
        'heading_alignment' => 'center',
		'subtitle_text' => '',
        'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
        'heading_color' => '',
        'heading_text' => '',
        'title' => '',
        'expanded_state' => '',
        'heading_style' => 'yes',
	), $atts ) );


		$compile .= "<div class='accordion_box'><h6 data-count='".$toggtemmpi."' class='shortcode_toggles_item_title expanded_" . $expanded_state . "'>".$title."<span class='ico'></span></h6><div class='shortcode_toggles_item_body'><div class='ip'>".do_shortcode($content)."</div></div></div>";

        $toggtemmpi++;
        return $compile;
	}
add_shortcode('toggles_item', 'toggles_item');


class toggles_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_toggles_shortcode($atts, $content = null) {

            $compile='';

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'title' => '',
                'heading_style' => 'no',
			), $atts ) );

            $toggtemmpi = 1;

            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}			
			
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }

			$compile .= "<div class='shortcode_toggles_shortcode toggles'>".do_shortcode($content)."</div>";

            $GLOBALS['showOnlyOneTimeJS']['toggles_accordion'] = "
            <script>
                jQuery(document).ready(function($) {
                    jQuery('.shortcode_accordion_item_title').on('click',function(){
                        if (!jQuery(this).hasClass('state-active')) {
                            jQuery(this).parents('.shortcode_accordion_shortcode').find('.shortcode_accordion_item_body').slideUp('fast',function(){
								content_update();
							});
                            jQuery(this).next().slideToggle('fast',function(){
								content_update();
							});
                            jQuery(this).parents('.shortcode_accordion_shortcode').find('.state-active').removeClass('state-active');
                            jQuery(this).addClass('state-active');
                        }
                    });
                    jQuery('.shortcode_toggles_item_title').on('click',function(){
                        jQuery(this).next().slideToggle('fast',function(){
							content_update();
						});
                        jQuery(this).toggleClass('state-active');
                    });

                    jQuery('.shortcode_accordion_item_title.expanded_yes, .shortcode_toggles_item_title.expanded_yes').each(function( index ) {
                        jQuery(this).next().slideDown('fast',function(){
							content_update();
						});
                        jQuery(this).addClass('state-active');
                    });
                });
            </script>
            ";

            $compile .= '</div>';
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_toggles_shortcode');
	}
}

#Shortcode name
$shortcodeName="toggles_shortcode";
$toggles_shortcode = new toggles_shortcode();
$toggles_shortcode->register_shortcode($shortcodeName);

?>