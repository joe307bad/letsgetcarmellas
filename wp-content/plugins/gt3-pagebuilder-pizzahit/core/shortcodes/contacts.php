<?php

class contacts_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_contacts($atts, $content = null) {
            if (!isset($compile)) {$compile='';}
			extract( shortcode_atts( array(
                'heading_alignment' => 'center',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
				'icon_bg' => '#eeeeee',
				'icon_color' => '#505050',
				'show_bg' => 'yes',
				'contact_list' => 'no',
                'module_id' => '',
                'heading_style' => 'yes',
			), $atts ) );
			if ($contact_list == 'yes') {
				$contact_list_class = 'is_contact_list';
			} else {
				$contact_list_class = '';
			}
            $gt3_theme_pagebuilder = get_plugin_pagebuilder(get_the_ID());

            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}			
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code .  (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }

            if (is_array($gt3_theme_pagebuilder['modules'][$module_id]['contact_info_icons'])) {
                $compile .= "<ul class='contact_info_list ". $show_bg ." ". $contact_list_class ."'>";
                foreach ($gt3_theme_pagebuilder['modules'][$module_id]['contact_info_icons'] as $key => $value) {
                    if ($value['link'] != '') {
                        $contact_content = '<div class="contact_info_text"><a href="'.$value['link'].'">'.$value['name'].'</a></div>';
                    } else {
                        $contact_content = '<div class="contact_info_text">'.$value['name'].'</div>';
                    }
                    $compile .= "<li class='contact_info_item'><div class='contact_info_wrapper'><span class='contact_info_icon' style=><i style='color:#".$value['fcolor']."' class='".$value['data-icon-code']."'></i></span>".$contact_content."</div></li>";
                }
                $compile .= "</ul>";
            }
            $compile .= '</div>';
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_contacts');  
	}
}

#Shortcode name
$shortcodeName="contacts";
#Register shortcode & set parameters
$contacts = new contacts_shortcode();
$contacts->register_shortcode($shortcodeName);

?>