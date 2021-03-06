<?php

class social_icons_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_social_icon($atts, $content = null) {
			extract( shortcode_atts( array(
			  'bg_color' => '',
			  'color' => '',
			  'icon' => '',
			  'style' => '',
			  'href' => '',
			  'type' => 'type1',
			), $atts ) );
	
			$content = strtr($content, array(
				'<p>'=>'',
				'</p>'=>'',
			));
			if ($href == '') {
				return '<span class="shortcode_social_icon '.$style.' '.$type.'" style="background-color:'.$bg_color.'"><span><i class="'.$icon.'" style="color:'.$color.'"></i></span></span>';
			} else {
				return '<a href="'.$href.'" class="shortcode_social_icon '.$style.' '.$type.'" style="background-color:'.$bg_color.'"><span><i class="'.$icon.'" style="color:'.$color.'"></i></span></a>';
			}
		}
		add_shortcode($shortcodeName, 'shortcode_social_icon');
	}
}

$shortcodeName="social_icon";
#Compile UI for admin panel
#Don't change this line
$compileShortcodeUI = "<div class='whatInsert whatInsert_".$shortcodeName."'>".$defaultUI."</div>";

#Your code
$compileShortcodeUI .= "

<table>
	<tr>
		<td>Address url:</td>
		<td><input style='width:160px;text-align:center;' value='' type='text' class='".$shortcodeName."_href' name='".$shortcodeName."_href'></td>
	</tr>
	<tr>
		<td>Style:</td>
		<td>
		    <select name='".$shortcodeName."_style' class='".$shortcodeName."_type'>";
if (is_array($GLOBALS["pbconfig"]['all_available_social_icons_type'])) {
    foreach ($GLOBALS["pbconfig"]['all_available_social_icons_type'] as $socialType => $socialCaption) {
        $compileShortcodeUI .= "<option value='".$socialType."'>".$socialCaption."</option>";
    }
}
$compileShortcodeUI .= "</select>
		</td>
	</tr>
	</table>
<table class='social_icon_table'>	
	<tr>
		<td>
			<div class='color_label'>Icon color:</div>
		</td>
		<td>
			<div class='color_picker_block'>
				<span class='sharp'>#</span>
				<input type='text' value='#ffffff' name='".$shortcodeName."_fgcolor' maxlength='25' class='cpicker textoption type1 ".$shortcodeName."_fgcolor'>
			</div>
			<div class='clear'></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class='color_label'>Background color:</div>
		</td>
		<td>
			<div class='color_picker_block'>
				<span class='sharp'>#</span>
				<input type='text' value='#b83f3f' name='".$shortcodeName."_fgcolor' maxlength='25' class='cpicker textoption type1 ".$shortcodeName."_bgcolor'>
			</div>
			<div class='clear'></div>
		</td>
	</tr>
</table>
<div class='social_icons all_available_font_icons'>
	Select icon:
	<ul class='icons_list ".$shortcodeName."_icon'>";
        foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
            $compileShortcodeUI .= "<li class='stand_social'><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></li>";
        }		
$compileShortcodeUI .= "
	</ul><div class='clear'></div>
</div>

<script>
	function ".$shortcodeName."_handler() {
	
		/* YOUR CODE HERE */
		
		var color = jQuery('.".$shortcodeName."_fgcolor').val();
		var bg_color = jQuery('.".$shortcodeName."_bgcolor').val();
		var type = jQuery('.".$shortcodeName."_type').val();
		var href = jQuery('.".$shortcodeName."_href').val();
		var icon = jQuery('.".$shortcodeName."_icon').find('li.active i').attr('data-icon-code');
		
		/* END YOUR CODE */

	
		/* COMPILE SHORTCODE LINE */
		var compileline = '[".$shortcodeName." color=\"'+color+'\" type=\"'+type+'\" bg_color=\"'+bg_color+'\" icon=\"'+icon+'\" href=\"'+href+'\"][/".$shortcodeName."]';
				
		/* DO NOT CHANGE THIS LINE */
		jQuery('.whatInsert_".$shortcodeName."').html(compileline);
	}
</script>

";

$social_icon = new social_icons_shortcode();
$social_icon->register_shortcode($shortcodeName);
shortcodesUI::getInstance()->add('social_icon', array("name" => $shortcodeName, "caption" => "Icon", "handler" => $compileShortcodeUI));
unset($compileShortcodeUI);

?>