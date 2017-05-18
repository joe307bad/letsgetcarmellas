<?php

class timetable
{

  public function register_shortcode($shortcodeName)
  {
    function shortcode_timetable($atts, $content = null)
    {

      $compile = '';

      extract(shortcode_atts(array(
        'heading_alignment' => 'center',
				'subtitle_text' => '',
        'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
        'heading_color' => '',
        'heading_text' => '',
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

      $compile .= '<div class="module_timetable timetable_wrapper"><div class="timetable normal"><div class="tr">
        <div class="th"><div>Time</div></div>
        <div class="th"><div>Monday</div></div>
        <div class="th"><div>Tuesday</div></div>
        <div class="th"><div>Wednesday</div></div>
        <div class="th"><div>Thursday</div></div>
        <div class="th"><div>Friday</div></div>
        <div class="th"><div>Saturday</div></div>
        <div class="th"><div>Sunday</div></div>
      <div class="clear"></div></div>' . do_shortcode($content) . '</div></div>';
      $compile .= '</div>';

      return $compile;

    }

    add_shortcode($shortcodeName, 'shortcode_timetable');
  }
}

#Shortcode name
$shortcodeName = "timetable";
$shortcode_timetable = new timetable();
$shortcode_timetable->register_shortcode($shortcodeName);

#for timetable_item
class timetable_item
{
  public function register_shortcode($name)
  {
    function shortcode_timetable_item($atts, $content = null)
    {
      extract(shortcode_atts(array(
        'time_interval' => '',
        'monday_timetable' => '',
        'tuesday_timetable' => '',
        'wednesday_timetable' => "",
        'thursday_timetable' => "",
				'friday_timetable' => "",
        'saturday_timetable' => "",
        'sunday_timetable' => "",
      ), $atts));

      $compile = '';
      $compile .= '
        <div class="tr">
          <div class="td"><div>'. $time_interval .'</div></div>
          <div class="td"><div>'. $monday_timetable .'</div></div>
          <div class="td"><div>'. $tuesday_timetable .'</div></div>
          <div class="td"><div>'. $wednesday_timetable .'</div></div>
          <div class="td"><div>'. $thursday_timetable .'</div></div>
          <div class="td"><div>'. $friday_timetable .'</div></div>
          <div class="td"><div>'. $saturday_timetable .'</div></div>
          <div class="td"><div>'. $sunday_timetable .'</div></div>
        <div class="clear"></div></div>';

      return $compile;

    }
    add_shortcode($name, 'shortcode_timetable_item');
  }
}

$timetable_item = new timetable_item();
$timetable_item->register_shortcode("timetable_item");

?>