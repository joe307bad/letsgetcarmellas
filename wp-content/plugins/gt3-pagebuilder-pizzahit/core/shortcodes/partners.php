<?php

class partners_shortcode
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_partners($atts, $content = null)
        {
            if (!isset($compile)) {
                $compile = '';
            }

            extract(shortcode_atts(array(
                'heading_alignment' => 'center',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'cpt_ids' => '0',
                'partners_in_line' => 1,
                'url' => '',
                'heading_style' => 'yes',
            ), $atts));

            if ($partners_in_line < 1) {
                $partners_in_line = 1;
            }
            $item_width = (100 / $partners_in_line);
            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($heading_color) > 0) {
                $custom_color = "color:{$heading_color};";
            } else {
                $custom_color = '';
            }
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}			
			
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }

            $gt3_wp_query = new WP_Query();

            if (strlen($cpt_ids) > 0 && $cpt_ids !== "0") {
                $cpt_ids = explode(",", $cpt_ids);
            }

            if (is_array($cpt_ids) && count($cpt_ids) > 0) {
                $args = array(
                    'post_type' => 'partners',
                    'post__in' => $cpt_ids,
                    'posts_per_page' => -1,
                    'order' => 'DESC'
                );
            } else {
                $args = array(
                    'post_type' => 'partners',
                    'posts_per_page' => -1,
                    'order' => 'DESC'
                );
            }

            $gt3_wp_query->query($args);

            $compile .= '<div class="module_content sponsors_works items-' . $partners_in_line . '"><ul>';
            while ($gt3_wp_query->have_posts()) : $gt3_wp_query->the_post();
                $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
				$featured_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
				
                if (strlen($featured_image[0]) > 0) {
                    $featured_image_url = $featured_image[0];
                } else {
                    $featured_image_url = "";
                }

                $partners_url = (isset($gt3_theme_pagebuilder['page_settings']['partners']['partners_link']) ? $gt3_theme_pagebuilder['page_settings']['partners']['partners_link'] : "");

                $compile .= '
                <li style="width:' . $item_width . '%">
					<div class="item_wrapper">
						<div class="item">
							' . (strlen($partners_url) > 0 ? "<a href='{$partners_url}' target='_blank'>" : "") . '<img src="' . $featured_image_url . '" alt="'. $featured_alt .'" title="' . get_the_title() . '" />' . (strlen($partners_url) > 0 ? "</a>" : "") . '</div>
					</div>
                </li>

            ';
            endwhile;

            $compile .= '</ul></div>';

            wp_reset_postdata();

            $compile .= '</div>';
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_partners');
    }
}


#Shortcode name
$shortcodeName = "partners";
$partners = new partners_shortcode();
$partners->register_shortcode($shortcodeName);

?>