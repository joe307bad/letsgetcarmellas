<?php

class lister
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_list($atts, $content = null)
        {
            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'type' => "type1",
                'heading_style' => 'yes',
            ), $atts));

            $content = strtr($content, array(
                '<p>' => '',
                '</p>' => '',
            ));
            $ulol = "ul";

            if ($type == "ordered") {
                $ulol = "ol";
            }

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

            $compile .= '
            <!--list-->
                <' . $ulol . ' class="' . $type . '">' . do_shortcode($content) . '</' . $ulol . '>
            <!--//list-->
			';
            $compile .= '</div>';
            return $compile;
        }
        add_shortcode($shortcodeName, 'shortcode_list');
    }
}

#Shortcode name
$shortcodeName = "list";

#Compile UI for admin panel
#Don't change this line
global $compileShortcodeUI;
$compileShortcodeUI .= "<div class='whatInsert whatInsert_" . $shortcodeName . "'>" . $defaultUI . "</div>";

#Your code
$compileShortcodeUI .= "
Type: 
<select name='" . $shortcodeName . "_type' class='" . $shortcodeName . "_type'>";

if (is_array($GLOBALS["pbconfig"]['all_available_custom_list_types'])) {
    foreach ($GLOBALS["pbconfig"]['all_available_custom_list_types'] as $value => $caption) {
        $compileShortcodeUI .= "<option value='{$value}'>{$caption}</option>";
    }
}

$compileShortcodeUI .= "</select>

<script>
	function " . $shortcodeName . "_handler() {
	
		/* YOUR CODE HERE */
		var type = jQuery('." . $shortcodeName . "_type').val();
		
		/* END YOUR CODE */
	
		/* COMPILE SHORTCODE LINE */
		var compileline = '[" . $shortcodeName . " type=\"'+type+'\"][li]Some text here[/li][li]Some text here[/li][li]Some text here[/li][/" . $shortcodeName . "]';
				
		/* DO NOT CHANGE THIS LINE */
		jQuery('.whatInsert_" . $shortcodeName . "').html(compileline);
	}
</script>

";

#Register shortcode & set parameters
$shortcode_list = new lister();
$shortcode_list->register_shortcode($shortcodeName);

#for li
class li
{
    public function register_shortcode($name)
    {
        function shortcode_li($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'type' => "type1",
            ), $atts));

            $content = strtr($content, array(
                '<p>' => '',
                '</p>' => '',
            ));

            $compile = '
		        <li>' . do_shortcode($content) . '</li>
			';

            return $compile;
        }
        add_shortcode($name, 'shortcode_li');
    }
}

#Register shortcode & set parameters
$li = new li();
$li->register_shortcode("li");

?>