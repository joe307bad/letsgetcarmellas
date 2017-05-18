<?php

class blog_shortcode
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_blog($atts, $content = null)
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
                'posts_per_page' => '10',
                'posts_per_line' => '3',
				'view_type' => '',
                'masonry' => 'no',
                'cat_ids' => 'all',
                'heading_style' => 'yes',
            ), $atts));
			
			$masonry_width = 100/$posts_per_line;
			
      #heading
      $compile .= '<div class="module_wrapper">';
      if (strlen($heading_color) > 0) {
          $custom_color = "color:#{$heading_color};";
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

            global $wp_query_in_shortcodes, $paged;

            if (empty($paged)) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            }

            $wp_query_in_shortcodes = new WP_Query();
            $args = array(
                'post_type' => 'post',
                'paged' => $paged,
                'posts_per_page' => $posts_per_page,
            );

            if ($cat_ids !== "all" && $cat_ids !== "") {
                $args['cat'] = $cat_ids;
            }

            $compile .= '
            <div class="blog_listing_cont items_' . $posts_per_line . '">
                <div class="blog_listing_wrapper isotope clearfix">
            ';

            $wp_query_in_shortcodes->query($args);
            while ($wp_query_in_shortcodes->have_posts()) : $wp_query_in_shortcodes->the_post();                
                $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);

                if(get_the_category()) $categories = get_the_category();
                $post_categ = '';
                $post_categ_compile = '';
                $separator = ', ';
                if ($categories) {
                    foreach($categories as $category) {
                        $post_categ = $post_categ .'<a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a>'.$separator;
                    }
                    $post_categ_compile = trim($post_categ, ', ');
                }

                if(get_the_tags() !== '') {
                    $posttags = get_the_tags();

                }
                if ($posttags) {
                    $post_tags = '';
                    $post_tags_compile = '<span class="preview_meta_tags">';
                    foreach($posttags as $tag) {
                        $post_tags = $post_tags . '<a href="?tag='.$tag->slug.'">'.$tag->name .'</a>'. ', ';
                    }
                    $post_tags_compile .= ' '.trim($post_tags, ', ').'</span>';
                } else {
                    $post_tags_compile = '';
                }

                $pf = get_post_format();
                if ($pf == "image" || $pf == "video") {
                    $pf_class = $pf;
                } else {
                    $pf_class = 'standart';
                }

                $wp_get_attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');

                if (strlen($wp_get_attachment_url)) {
                    $gt3_featured_image_url = aq_resize($wp_get_attachment_url, 800, 600, true, true, true);
                    $featured_image = '<img alt="" src="' . $gt3_featured_image_url . '" />';
                } else {
                    $featured_image = '';
                }
                $comments_num = '' . get_comments_number(get_the_ID()) . '';

             	if ($comments_num == 1) {
             		$comments_text = '' . esc_html__('comment', 'gt3_builder') . '';
             	} else {
             		$comments_text = '' . esc_html__('comments', 'gt3_builder') . '';
             	}

                $compile .= '
                <div class="blog_listing_item ' . $pf . '">
                    <div class="featured_item mb50">';
                    if (strlen($wp_get_attachment_url)) {
                        $compile .= '
                        <div class="img_block">
                            <a href="' . get_permalink(get_the_ID()) . '" class="view_link link">' . gt3_get_pf_type_output(array("pf" => $pf, "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder)) . '
                            </a>
                        </div>';
                    }

                    $compile .= '
                        <div class="featured_item_descr' . ((strlen($wp_get_attachment_url)) ? ' image_presents' : '') . '">
                            <h3 class="headings"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h3>
                            <div class="post-meta">
                                <a href="' . get_permalink(get_the_ID()) . '"><span class="post_date">
                                    ' . get_the_time(get_option( 'date_format' )) . '
                                </span></a>
                                /
                                <span class="post_author">
                                    ' . esc_html__('by', 'gt3_builder')  . '
                                    <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author_meta('display_name')) . '</a>
                                </span>';
                                if ($post_categ_compile != '') $compile .='
                                /
                                <span class="post_category">' . esc_html__('in ', 'gt3_builder') .
                                    trim($post_categ, ', ') . '
                                </span>';
                                if ($post_tags_compile != '') $compile .='
                                /
                                <span class="post_category">
                                    ' . trim($post_tags_compile, ', ') . '
                                </span>';
                            $compile .='
                            </div>
                            <div class="featured_item_content">
                               ' . get_the_excerpt() . '
                            </div>
                            <a class="shortcode_button btn_normal btn_type1" href="' . get_permalink(get_the_ID()) . '">' . esc_html__('Read more', 'gt3_builder') . '</a>
                        </div>
                    </div>
                </div>';
            endwhile;

            $compile .= '
                </div><!-- blog_listing_wrapper -->
                <div class="post_divider_wrapper">
                    <div class="post_divider"></div>
                </div>
            ';

            $compile .= get_plugin_pagination("5", "show_in_shortcodes");
			
            wp_reset_postdata();

            $compile .= '</div></div>';
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_blog');
    }
}

#Shortcode name
$shortcodeName = "blog";
$blog = new blog_shortcode();
$blog->register_shortcode($shortcodeName);

?>