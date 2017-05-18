<?php

class ourteam
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_ourteam($atts, $content = null)
        {
            wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, true);

            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'center',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'order' => 'ASC',
                'cpt_ids' => '0',
                'items_per_line' => '1',
                'heading_style' => 'yes',
                'vertical' => 'no',
            ), $atts));

            if ($items_per_line < 1) {
                $items_per_line = 1;
            }
            $item_width = (100 / $items_per_line);

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

            $compile .= '
        <div class="team_slider">
            <div class="carouselslider teamslider items' . $items_per_line . ' '. (isset($vertical) && $vertical=='yes'? 'vertical' : 'horisontal') .' " data-count="' . $items_per_line . '">
            	<ul class="item_list" data-count="' . $items_per_line . '" data-vertical="' . $vertical . '">';

            $gt3_wp_query = new WP_Query();

            if (strlen($cpt_ids) > 0 && $cpt_ids !== "0") {
                $cpt_ids = explode(",", $cpt_ids);
            }

            if (is_array($cpt_ids) && count($cpt_ids) > 0) {
                $args = array(
                    'post_type' => 'team',
                    'post__in' => $cpt_ids,
                    'order' => $order,
					'posts_per_page' => -1
                );
            } else {
                $args = array(
                    'post_type' => 'team',
                    'order' => $order,
					'posts_per_page' => -1
                );
            }

            $gt3_wp_query->query($args);
            $i = 0; 
            while ($gt3_wp_query->have_posts()) : $gt3_wp_query->the_post();
                $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
                $position = $gt3_theme_pagebuilder['page_settings']['team']['position'];
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
				$featured_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);	
                		
                $compile .= '
					<li class="team_item" style="width:' . $item_width . '%">
						<div class="item_wrapper">
							<div class="item">
								<div class="img_block team_img">';
                if (has_post_thumbnail()) {
                    $compile .= '<a href="' . get_permalink(get_the_ID()) . '"><img src="' . aq_resize($featured_image[0], "400", "400", true, true, true) . '" alt="'. $featured_alt .'" /></a>';
                }
                $compile .= '
								</div>
								<div class="team_content">
									<div class="team_title">
										<h5><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h5>
										<div class="op">' . $position . '</div>
									</div>
									<div class="team_desc">' . ((strlen(get_the_excerpt()) > 0) ? get_the_excerpt() : get_the_content()) . '</div>';
					if (isset($gt3_theme_pagebuilder['page_settings']['icons']) ? $socicons = $gt3_theme_pagebuilder['page_settings']['icons'] : $socicons = false);
					if (is_array($socicons)) {
						$compile .= '<div class="team_icons_wrapper featured_items_meta">';
						foreach ($socicons as $key => $value) {
							if (isset($value['target']) && $value['target'] == 'on') {
								$target = "_blank";
							} else {
								$target = "_self";
							}

							if ($value['link'] == '') $value['link'] = '#';
							$compile .= '<a target="' . $target . '" href="'.$value['link'].'" class="teamlink" title="'.$value['name'].'" style="color:'.$value['fcolor'].'!important;"><i class="'.$value['data-icon-code'].'"></i></a>';
						}
						$compile .= '</div>';
					}

					$compile .= '</div>
							</div>
						</div>
                    </li>
				';
                $i++;
                // if ($i % $items_per_line == 0) $compile.= '<div class="clear"></div>';

            endwhile;
            wp_reset_postdata();

            $compile .= '</ul>
             </div>
             <div class="clear"></div>
        </div>
        <div class="clear"></div>';
        $compile .= '</div>';
        return $compile;
        }
        add_shortcode($shortcodeName, 'shortcode_ourteam');
    }
}

#Shortcode name
$shortcodeName = "ourteam";
$shortcode_ourteam = new ourteam();
$shortcode_ourteam->register_shortcode($shortcodeName);

?>