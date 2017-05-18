<?php

#Upload images
add_action('wp_ajax_mix_ajax_post_action', 'mix_theme_upload_images');
function mix_theme_upload_images()
{
    if (current_user_can('manage_options')) {
        $save_type = $_POST['type'];

        if ($save_type == 'upload') {

            $clickedID = esc_attr($_POST['data']);
            $filename = $_FILES[$clickedID];
            $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

            $override['test_form'] = false;
            $override['action'] = 'wp_handle_upload';
            $uploaded_file = wp_handle_upload($filename, $override);
            $upload_tracking[] = $clickedID;
            gt3_update_theme_option($clickedID, $uploaded_file['url']);
            if (!empty($uploaded_file['error'])) {
                echo 'Upload Error: ' . $uploaded_file['error'];
            } else {
                echo esc_url($uploaded_file['url']);
            }
        }
    }

    die();
}

#Upload images
add_action('wp_ajax_gt3_get_blog_posts', 'gt3_get_blog_posts');
add_action('wp_ajax_nopriv_gt3_get_blog_posts', 'gt3_get_blog_posts');
function gt3_get_blog_posts()
{
    $setPad = esc_attr($_REQUEST['set_pad']);
    if ($_REQUEST['template_name'] == "fw_blog_template") {
        $wp_query_get_blog_posts = new WP_Query();
        $args = array(
            'post_type' => esc_attr($_REQUEST['post_type']),
            'offset' => absint($_REQUEST['posts_already_showed']),
            'post_status' => 'publish',
            'cat' => esc_attr($_REQUEST['categories']),
            'posts_per_page' => absint($_REQUEST['posts_count'])
        );
        $wp_query_get_blog_posts->query($args);
        while ($wp_query_get_blog_posts->have_posts()) : $wp_query_get_blog_posts->the_post();
            $pf = get_post_format();
            if ($pf == "image" || $pf == "video") {
                $pf_class = $pf;
            } else {
                $pf_class = 'standart';
            }

            $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);

            if (get_the_category()) $categories = get_the_category();
            $post_categ = '';
            $separator = ', ';
            if ($categories) {
                foreach ($categories as $category) {
                    $post_categ = $post_categ . '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . $separator;
                }
            }

            ?>
            <div <?php post_class("blogpost_preview_fw newLoaded anim_el loading"); ?>>
                <div class="fw_preview_wrapper featured_items">
                    <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="fs_blog_loadmore"></a>

                    <div class="fs_img_block wrapped_img">
                        <?php if (get_post_format() !== 'video' && get_post_format() !== 'audio') {
                            echo '<a href="' . get_permalink() . '"></a>';
                        } ?>
                        <?php echo gt3_get_pf_type_output(array("pf" => get_post_format(), "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder, "width" => '585', "height" => '', "fw_post" => true)); ?>
                    </div>
                    <div class="fs_blog_top <?php echo $pf_class ?>">
                        <h6 class="fs_blog_title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                        </h6>

                        <div class="featured_items_meta">
                            <span><?php echo trim($post_categ, ', ') ?></span>
                            <span class="preview_meta_data"><?php echo get_the_time("F d, Y") ?></span>
                            <span><a
                                    href="<?php echo get_comments_link() ?>"><?php echo get_comments_number(get_the_ID());
                                    esc_html_e(' comments', 'pizzahit') ?></a></span>
                        </div>
                    </div>
                    <div class="fs_blog_content">
                        <?php
                        $post = get_post();
                        $post_excerpt = ((strlen($post->post_excerpt) > 0) ? smarty_modifier_truncate($post->post_excerpt, 170, "") : smarty_modifier_truncate(get_the_content(), 170, ""));
                        $post_excerpt .= '. <a href="' . get_permalink() . '" class="fs_read_more">' . esc_html__('Read more', 'pizzahit') . ' <i class="icon-angle-right"></i></a>';
                        echo $post_excerpt;
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile;
		wp_reset_postdata();
    }
    die();
}

#Get last slide ID
add_action('wp_ajax_get_unused_id_ajax', 'get_unused_id_ajax');
if (!function_exists('get_unused_id_ajax')) {
    function get_unused_id_ajax()
    {
        $lastid = gt3_get_theme_option("last_slide_id");
        if ($lastid < 3) {
            $lastid = 2;
        }
        $lastid++;

        $mystring = esc_url(home_url('/'));
        $findme = 'gt3themes';
        $pos = strpos($mystring, $findme);

        if ($pos === false) {
            echo $lastid;
        } else {
            echo str_replace(array("/", "-", "_"), "", substr(wp_get_theme()->get('ThemeURI'), -4, 3)) . date("d") . date("m") . $lastid;
        }

        gt3_update_theme_option("last_slide_id", $lastid);

        die();
    }
}


add_action('wp_ajax_add_like_post', 'gt3_add_like_post');
add_action('wp_ajax_nopriv_add_like_post', 'gt3_add_like_post');
function gt3_add_like_post()
{
    $post_id = absint($_POST['post_id']);
    $post_likes = (get_post_meta($post_id, "post_likes", true) > 0 ? get_post_meta($post_id, "post_likes", true) : "0");
    $new_likes = absint($post_likes) + 1;
    update_post_meta($post_id, "post_likes", $new_likes);
    echo $new_likes;
    die();
}

#Load gallery works
add_action('wp_ajax_get_gallery_works', 'get_gallery_works');
add_action('wp_ajax_nopriv_get_gallery_works', 'get_gallery_works');
if (!function_exists('get_gallery_works')) {
    function get_gallery_works()
    {
        $openID = absint($_POST['current_id']);
        $pagebuilder = gt3_get_theme_pagebuilder($openID);
		$slider_compile = '';
		$slide_num = 1;
        ?>        
            <?php if (isset($pagebuilder['sliders']['fullscreen']['slides']) && is_array($pagebuilder['sliders']['fullscreen']['slides'])) {
                    foreach ($pagebuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {
                        $uniqid = mt_rand(0, 9999);
                        if (isset($image['title']['value']) && strlen($image['title']['value'])>0) {$photoTitle = $image['title']['value'];} else {$photoTitle = "";}
                        if (isset($image['caption']['value']) && strlen($image['caption']['value'])>0) {$photoCaption  = $image['caption']['value'];} else {$photoCaption = "";}						
						
                        if ($image['slide_type'] == 'image') {
							$src_type = 'image';
							$src = wp_get_attachment_url($image['attach_id']);
                        } else if ($image['slide_type'] == 'video') {
                            #YOUTUBE							
                            $is_youtube = substr_count($image['src'], "youtu");
                            if ($is_youtube > 0) {
								$src_type = 'youtube';
								$src = substr(strstr($image['src'], "="), 1);
                            }
                            #VIMEO
                            $is_vimeo = substr_count($image['src'], "vimeo");
                            if ($is_vimeo > 0) {								
								$src_type = 'vimeo';
								$src = substr(strstr($image['src'], "m/"), 2);
							}
                        }            
							$slider_compile .= '<li class="ajax_slide as_slide'. $slide_num .'" data-title="'. $photoTitle .'" data-caption="'. $photoCaption .'" data-type="'. $src_type .'" data-src="'. $src .'" data-count="'. $slide_num .'"></li>';
						$slide_num++;
                	}
				} else { 
					$slider_compile .= '<li class="ajax_slide empty"><h2>'. esc_html__('No Images', 'pizzahit') .'</h2></li>';
				} ?>
        <?php
        echo $slider_compile;
		die();
    }
}

add_action( 'wp_ajax_gt3_add_aq_resized_image', 'gt3_add_aq_resized_image' );
add_action( 'wp_ajax_nopriv_gt3_add_aq_resized_image', 'gt3_add_aq_resized_image' );
if (!function_exists('gt3_add_aq_resized_image')) {
    function gt3_add_aq_resized_image() {
        $url = ($_POST['url']);

        $w = absint($_POST['img_w']);
        $h = absint($_POST['img_h']);
        echo aq_resize($url, $w, $h, true, true, true) ;
        die();
    }
}

add_action('wp_ajax_gt3_save_admin_options', 'gt3_save_admin_options');
function gt3_save_admin_options()
{
    if (current_user_can('manage_options')) {
        $response = array();
        $gt3_options = get_option(GT3_THEMESHORT . "gt3_options", array());
        $serialize_string = stripslashes($_POST['serialize_string']);

        $theme_sidebars = array();

        foreach (json_decode($serialize_string, true) as $key => $value) {
            $gt3_options[$value['name']] = $value['value'];
            $pos = strpos($value['name'], 'theme_sidebars');
            if ($pos === false) {
            } else {
                $theme_sidebars[] = $value['value'];
            }
        };

        if (update_option(GT3_THEMESHORT . "gt3_options", $gt3_options)) {
            $response['save_status'] = "saved";
        } else {
            $response['save_status'] = "nothing_changed";
        }

        gt3_delete_theme_option("theme_sidebars");
        gt3_update_theme_option("theme_sidebars", $theme_sidebars);

        echo json_encode($response);
    }

    die();
}

add_action('wp_ajax_gt3_reset_admin_settings', 'gt3_reset_admin_settings');
function gt3_reset_admin_settings()
{
    if (current_user_can('manage_options')) {
        delete_option(GT3_THEMESHORT . "gt3_options");

        echo '<div>Done!</div>';
    }

    die();
}

add_action('wp_ajax_gt3_edit_menu_settings', 'gt3_edit_menu_settings');
function gt3_edit_menu_settings()
{
    if (current_user_can('manage_options')) {
        $gt3_menu_edited_id = absint($_POST['gt3_menu_edited_id']);
        $gt3_menu_edited_depth = absint($_POST['gt3_menu_edited_depth']);
        $gt3_select_icon_ultimate = get_post_meta($gt3_menu_edited_id, 'gt3_select_icon_ultimate', true);
        $gt3_megamenu_status = get_post_meta($gt3_menu_edited_id, 'gt3_megamenu_status', true);
        $gt3_megamenu_columns = get_post_meta($gt3_menu_edited_id, 'gt3_megamenu_columns', true);

        echo '<div class="gt3_edit_menu_settings_popup">';
        echo '
    <input type="hidden" name="gt3_menu_edited_id" class="gt3_menu_edited_id" value="' . $gt3_menu_edited_id . '">
    <input type="hidden" name="gt3_menu_edited_depth" class="gt3_menu_edited_depth" value="' . $gt3_menu_edited_depth . '">
    ';

        $temp_mt_rand = mt_rand(1000, 2000);

        echo '
        <div class="gt3_select_menu_icon_container" style="' . ($gt3_menu_edited_depth > 0 ? '' : 'display:none;') . '">
            <div>Icon: <span class="gt3_remove_this_icon">[clear]</span></div>
            <div style="margin-top: 5px; position: relative;">
                <input type="text" class="gt3_input gt3_select_icon_ultimate" value="'.((isset($gt3_select_icon_ultimate) && strlen($gt3_select_icon_ultimate) > 0) ? $gt3_select_icon_ultimate : '').'">
                <i class="gt3_preview_icon '.((isset($gt3_select_icon_ultimate) && strlen($gt3_select_icon_ultimate) > 0) ? $gt3_select_icon_ultimate : '').'"></i>
            </div>
        </div>
        ';

        echo '
        <div class="" style="' . ($gt3_menu_edited_depth == 0 ? '' : 'display:none;') . '">
            <div style="margin-top: 5px;">
                <input id="idrand_'.$temp_mt_rand.'" type="checkbox" class="gt3_megamenu_status" '.((isset($gt3_megamenu_status) && $gt3_megamenu_status == 'enabled') ? 'checked' : '').'>
                <label for="idrand_'.$temp_mt_rand.'">' . esc_html__('Mega Menu', 'pizzahit') . '</label>
            </div>
        </div>
        ';

        echo '
        <div style="' . ($gt3_menu_edited_depth == 0 ? '' : 'display:none;') . 'margin-top: 10px;">
            <div>Columns:</div>
            <div style="margin-top:5px;">
                <select class="gt3_megamenu_columns" name="gt3_megamenu_columns">
                    <option value="3" '.((isset($gt3_megamenu_columns) && $gt3_megamenu_columns == '3') ? 'selected' : '').'>3</option>
                    <option value="4" '.((isset($gt3_megamenu_columns) && $gt3_megamenu_columns == '4') ? 'selected' : '').'>4</option>
                    <option value="5" '.((isset($gt3_megamenu_columns) && $gt3_megamenu_columns == '5') ? 'selected' : '').'>5</option>
                </select>
            </div>
        </div>
        ';

        echo '
        <input type="button" style="margin-top:15px;" class="button gt3_save_menu_settings" name="gt3_save_menu_settings" value="' . esc_html__('Save Settings', 'pizzahit') . '">
    ';

        echo '</div>';
    }

    die();
}

add_action('wp_ajax_gt3_save_menu_settings', 'gt3_save_menu_settings');
function gt3_save_menu_settings()
{
    if (current_user_can('manage_options')) {
        $gt3_menu_edited_id = absint($_POST['gt3_menu_edited_id']);
        $gt3_menu_edited_depth = absint($_POST['gt3_menu_edited_depth']);
        $gt3_megamenu_columns = absint($_POST['gt3_megamenu_columns']);
        $gt3_select_icon_ultimate = esc_attr($_POST['gt3_select_icon_ultimate']);
        $gt3_megamenu_status = (isset($_POST['gt3_megamenu_status']) && esc_attr($_POST['gt3_megamenu_status']) == "checked" ? "enabled" : 'disabled');

        update_post_meta($gt3_menu_edited_id, 'gt3_select_icon_ultimate', $gt3_select_icon_ultimate);
        update_post_meta($gt3_menu_edited_id, 'gt3_megamenu_status', $gt3_megamenu_status);
        update_post_meta($gt3_menu_edited_id, 'gt3_megamenu_columns', $gt3_megamenu_columns);
    }

    die();
}