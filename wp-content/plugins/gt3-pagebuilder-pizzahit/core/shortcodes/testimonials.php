<?php

class testimonials_shortcode
{
  public function register_shortcode($shortcodeName)
  {
    function shortcode_testimonials($atts, $content = null)
    {
      wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, true);

      if (!isset($compile)) {$compile='';}

      extract(shortcode_atts(array(
        'heading_alignment' => 'center',
				'subtitle_text' => '',
        'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
        'heading_color' => '',
        'heading_text' => '',
        'cpt_ids' => '0',
        'sorting_type' => "new",
        'heading_style' => 'yes',
      ), $atts));

      $testimonials_in_line = 5;

      if ($testimonials_in_line < 1) {$testimonials_in_line = 1;}
			$testimonial_width = (100/$testimonials_in_line);
			
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

      #sort converter
      switch ($sorting_type) {
        case "new":
          $sort_type = "post_date";
          break;
        case "random":
          $sort_type = "rand";
          break;
      }

      if (strlen($cpt_ids) > 0 && $cpt_ids !== "0") {
        $cpt_ids = explode(",", $cpt_ids);
      }

      $args = array(
                'post_type' => "testimonials",
                'orderby' => $sort_type,
                'post__in' => $cpt_ids,
                'post_status' => 'publish');

      $posts = get_posts($args);

      $compile .= "<div class='testimonial_wrapper text-center'>";     

            if (is_array($posts)) {
        $compile .= "<!-- testimonials slick info --><div class='testimonials-info'>";
        foreach ($posts as $post) {
          $compile .= "<div class='slide_wrap'><div class='slick_testim_info'><p>" . $post->post_content . "</p></div></div>";
        } 
        $compile .= "</div><!-- //testimonials slick info --><!-- testimonials slick thumbs --><div class='testimonials-nav'>";
        
        foreach ($posts as $post) {
                    $gt3_theme_pagebuilder = get_post_meta($post->ID, "pagebuilder", true);
          $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                    $testimonials_author = $gt3_theme_pagebuilder['page_settings']['testimonials']['testimonials_author'];
                    $testimonials_company = $gt3_theme_pagebuilder['page_settings']['testimonials']['company'];
          $featured_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
          
                    $compile .= "                            
            <div class='nav_item_wrap'>
              <div class='testimonial_item'>
                ".(strlen($featured_image[0])>0 ? "<div class='author_thumb'><img alt='". $featured_alt ."' src='".aq_resize($featured_image[0], "140", "140", true, true, true)."' /></div>" : "")."
                <div class='testimonial_nav_info'>
                  <h6>{$testimonials_author}</h6>
                  <span>{$testimonials_company}</span>
                </div>
              </div>
            </div>
          ";
                }
        
        $compile .= "</div><!-- //testimonials slick thumbs -->";               
            }

            $compile .= "</div></div>";

            return $compile;

    }

    add_shortcode($shortcodeName, 'shortcode_testimonials');
  }
}

#Shortcode name
$shortcodeName = "testimonials";
$testimonials = new testimonials_shortcode();
$testimonials->register_shortcode($shortcodeName);

?>