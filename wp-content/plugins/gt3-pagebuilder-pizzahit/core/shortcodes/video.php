<?php

class video_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_video($atts, $content = null) {
            if (!isset($compile)) {$compile='';}
			extract( shortcode_atts( array(
                'heading_alignment' => 'center',
				        'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'video_url' => '',
                'w' => '',
                'h' => $GLOBALS["pbconfig"]['default_video_height'],
                'heading_style' => 'yes',
                'video_cover_image' => '',
			), $atts ) );

            $uniqid = mt_rand(0, 9999);
            global $gt3_YTApiLoaded, $gt3_allYTVideos;
            if (empty($gt3_YTApiLoaded)) {$gt3_YTApiLoaded = false;}
            if (empty($gt3_allYTVideos)) {$gt3_allYTVideos = array();}

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

      if (strlen($video_cover_image)>0) {
				$compile .= '<div class="video_bg" style="height:'. $h .'; background-image:url('. aq_resize($video_cover_image, 1170, NULL, true, true, true) .');"><div class="overlay"></div>';
				
				#YOUTUBE
				$is_youtube = substr_count($video_url, "youtu");
				if ($is_youtube > 0) {
					$videoid = substr(strstr($video_url, "="), 1);
					$compile .= "<span class='video_mask'></span><a class='play-video' href='#' data-video-url='http://www.youtube.com/embed/". $videoid ."?rel=0'>" . __('Play Video', 'gt3_builder') . "</a><iframe class='video_frame' src='http://www.youtube.com/embed/". $videoid ."?rel=0' allowfullscreen></iframe>";
				}

				#VIMEO
				$is_vimeo = substr_count($video_url, "vimeo");
				if ($is_vimeo > 0) {
					$videoid = substr(strstr($video_url, "m/"), 2);
					$compile .= "<span class='video_mask'></span><a class='play-video' href='#' data-video-url='https://player.vimeo.com/video/". $videoid . "?rel=0'>" . __('Play Video', 'gt3_builder') . "</a><iframe class='video_frame' src='https://player.vimeo.com/video/". $videoid ."?rel=0' allowfullscreen></iframe>";
				}			
				
				$compile .= '</div>';	
            } else {
				$compile .= '<div class="wrapped_video" style=" width:' . $w .'; height:' . $h .'">';

				#YOUTUBE
				$is_youtube = substr_count($video_url, "youtu");
				if ($is_youtube > 0) {
					$videoid = substr(strstr($video_url, "="), 1);
					$compile .= "<iframe src='http://www.youtube.com/embed/". $videoid ."?rel=0' allowfullscreen></iframe>";
				}

				#VIMEO
				$is_vimeo = substr_count($video_url, "vimeo");
				if ($is_vimeo > 0) {
					$videoid = substr(strstr($video_url, "m/"), 2);
					$compile .= "<iframe src='https://player.vimeo.com/video/". $videoid ."?rel=0' allowfullscreen></iframe>";
				}
			}

      $compile .= '</div></div>';

			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_video');
	}
}

#Shortcode name
$shortcodeName="video";

#Compile UI for admin panel
#Don't change this line
$compileShortcodeUI = "<div class='whatInsert whatInsert_".$shortcodeName."'>".$defaultUI."</div>";

#Your code
$compileShortcodeUI .= "
<table>
	<tr>
		<td>Container width:</td>
		<td><input value='150px' type='text' class='".$shortcodeName."_width' name='".$shortcodeName."_width'></td>
	</tr>
	<tr>
		<td>Container height:</td>
		<td><input value='150px' type='text' class='".$shortcodeName."_height' name='".$shortcodeName."_height'></td>
	</tr>
	<tr>
		<td>Video url:</td>
		<td><input value='' type='text' class='".$shortcodeName."_video' name='".$shortcodeName."_video'><br />
			<div class='shortcode_video_example'>".esc_html__('Examples:','gt3_builder')."<br />
			".esc_html__('Youtube','gt3_builder')." - http://www.youtube.com/watch?v=6v2L2UGZJAM<br />
			".esc_html__('Vimeo','gt3_builder')." - http://vimeo.com/47989207</div>
		</td>
	</tr>
	<tr>
		<td>Float:</td>
		<td>
		    <select style='' name='".$shortcodeName."_float' class='".$shortcodeName."_float'>
                <option value='left'>Left</option>
                <option value='right'>Right</option>
                <option value='right'>None</option>
            </select>
		</td>
	</tr>
</table>

<script>
	function ".$shortcodeName."_handler() {

		/* YOUR CODE HERE */

		var video_width = jQuery('.".$shortcodeName."_width').val();
		var video_height = jQuery('.".$shortcodeName."_height').val();
		var video_url = jQuery('.".$shortcodeName."_video').val();
		var float = jQuery('.".$shortcodeName."_float').val();

		/* END YOUR CODE */

		/* COMPILE SHORTCODE LINE */
		var compileline = '[".$shortcodeName." w=\"'+video_width+'\" h=\"'+video_height+'\" video_url=\"'+video_url+'\" float=\"'+float+'\"][/".$shortcodeName."]';

		/* DO NOT CHANGE THIS LINE */
		jQuery('.whatInsert_".$shortcodeName."').html(compileline);
	}
</script>

";

$video = new video_shortcode();
$video->register_shortcode($shortcodeName);
shortcodesUI::getInstance()->add('video', array("name" => $shortcodeName, "caption" => "Video", "handler" => $compileShortcodeUI));
unset($compileShortcodeUI);

?>