<?php

class feature_posts
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_feature_posts($atts, $content = null)
        {

        $compile = '';

        extract(shortcode_atts(array(
            'heading_alignment' => 'center',
						'subtitle_text' => '',
            'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
            'heading_color' => '',
            'heading_text' => '',
            'number_of_posts' => $GLOBALS["pbconfig"]['featured_posts_default_number_of_posts'],
            'posts_per_line' => '3',
		        'is_single' => 'no',
            'selected_categories' => '',
            'sorting_type' => "new",
            'heading_style' => 'yes',
        ), $atts));

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

      #sort converter
      switch ($sorting_type) {
          case "new":
              $sort_type = "post_date";
              break;
          case "random":
              $sort_type = "rand";
              break;
      }

			$show_likes = gt3_get_theme_option("post_likes");			
            $compile .= '
        <div class="featured_items clearfix">
          <div class="items' . $posts_per_line . ' featured_posts" data-count="' . $posts_per_line . '">';
			if ($is_single == 'no') {
                $compile .= '<ul class="item_list">';
			} else {
				$compile .= '<ul class="single_type_list likes_'. $show_likes .'">';
			}

            $gt3_wp_query = new WP_Query();
            $args = array(
                'posts_per_page' => $number_of_posts,
                'post_type' => 'post',
                'post_status' => 'publish',
                'cat' => $selected_categories,
                'orderby' => $sort_type,
                'order' => 'DESC'
            );

            $gt3_wp_query->query($args);

            while ($gt3_wp_query->have_posts()) : $gt3_wp_query->the_post();
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
								$featured_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
								$comments_num = '' . get_comments_number(get_the_ID()) . '';
									
								if ($comments_num == 1) {
									$comments_text = '' . esc_html__('comment', 'gt3_builder') . '';
								} else {
									$comments_text = '' . esc_html__('comments', 'gt3_builder') . '';
								}

								if(get_the_category()) $categories = get_the_category();
								$post_categ = '';
								$separator = ', ';
								if ($categories) {						
									foreach($categories as $category) {
										$post_categ = $post_categ .'<a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a>, ';
									}
								}
								$post_categ = substr($post_categ,0,-2);

                if (strlen($featured_image[0]) > 0) {
                    $featured_image_url = aq_resize($featured_image[0], "830", "800", true, true, true);
                    $full_image_url = $featured_image[0];
                    $featured_image_full = '
										<div class="img_block wrapped_img">
											<a href="' . get_permalink(get_the_ID()) . '"><img alt="'. $featured_alt .'" src="' . $featured_image_url . '" /></a>
										</div>';
                } else {
									$featured_image_full = '';
                }

                $post = get_post();
					$compile .= '
						<li>
							<div class="item">
								' . $featured_image_full . '
								<div class="item_wrapper">
									<div class="featured_items_body">
									    <h6><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h6>
										<div class="post-meta">
											<span class="post_date">
											    ' . get_the_time(get_option( 'date_format' )) . '
                                            </span>
										</div>
										<div class="featured_item_content">
										   ' . substr(get_the_excerpt(), 0, 150) . '
										</div>
                                        <a class="shortcode_button btn_small btn_type1" href="' . get_permalink(get_the_ID()) . '">' . esc_html__('Read more', 'gt3_builder') . '</a>
									</div>
									
								</div>
							</div>
						</li>
					';
				$featured_image_url = '';
            endwhile;
			wp_reset_postdata();

            $compile .= '
                </ul>
            </div>
        </div>
        ';
            wp_reset_postdata();
            $compile .= '</div>';
            return $compile;

        }

        add_shortcode($shortcodeName, 'shortcode_feature_posts');
    }
}

#Shortcode name
$shortcodeName = "feature_posts";
$shortcode_feature_posts = new feature_posts();
$shortcode_feature_posts->register_shortcode($shortcodeName);
?>