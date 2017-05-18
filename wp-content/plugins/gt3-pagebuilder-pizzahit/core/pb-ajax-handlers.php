<?php
#Get media for postid
add_action('wp_ajax_get_media_for_postid', 'get_media_for_postid');
if (!function_exists('get_media_for_postid')) {
    function get_media_for_postid()
    {
        if (current_user_can('manage_options')) {
            $postid = $_POST['post_id'];
            $page = $_POST['page'];
            $media_for_this_post = get_media_for_this_post($postid, $page);
            if (is_array($media_for_this_post) && count($media_for_this_post) > 0) {
                echo get_media_html($media_for_this_post, "small");
            } else {
                echo "no_items";
            }
        }

        die();
    }
}


#Get module html
add_action('wp_ajax_get_module_html', 'get_module_html');
if (!function_exists('get_module_html')) {
    function get_module_html()
    {
        if (current_user_can('manage_options')) {
            $module_caption = esc_attr($_POST['module_caption']);
            $module_name = esc_attr($_POST['module_name']);
            $postid = $_POST['postid_for_module'];
            $tinymce_activation_class = $_POST['tinymce_activation_class'];
            $module_size = "block_1_4";
            $size_caption = "1/4";

            if ($module_name == "bg_start" || $module_name == "bg_end") {
                $module_size = "block_1_1";
                $size_caption = "1/1";
            }

            echo get_pb_module($module_name, $module_caption, get_unused_id(), "", $module_size, $size_caption, $tinymce_activation_class);

        }
        die();
    }
}

#Upload images
add_action('wp_ajax_mix_ajax_post_action', 'mix_ajax_callback');
if (!function_exists('mix_ajax_callback')) {
    function mix_ajax_callback()
    {
        if (current_user_can('manage_options')) {
            $save_type = $_POST['type'];

            if ($save_type == 'upload') {

                $clickedID = $_POST['data'];
                $filename = $_FILES[$clickedID];
                $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

                $override['test_form'] = false;
                $override['action'] = 'wp_handle_upload';
                $uploaded_file = wp_handle_upload($filename, $override);
                $upload_tracking[] = $clickedID;
                gt3pb_update_option($clickedID, $uploaded_file['url']);
                if (!empty($uploaded_file['error'])) {
                    echo 'Upload Error: ' . $uploaded_file['error'];
                } else {
                    echo $uploaded_file['url'];
                }
            }
        } 

        die();
    }
}

#Compile ShortcodesUI and push it
add_action('wp_ajax_getshortcodesUI', 'prefix_ajax_getshortcodesUI');
if (!function_exists('prefix_ajax_getshortcodesUI')) {
    function prefix_ajax_getshortcodesUI()
    {
        $shortcodesUI = shortcodesUI::getInstance()->getCompile();

        echo "<div class='select_shortcode_cont'><div class='select_shortcode_label'>Select shortcode:</div> <div class='select_shortcode_dropdown'><select name='select_shortcode' class='select_shortcode'>";
        if (is_array($shortcodesUI)) {
            foreach ($shortcodesUI as $array) {
                echo "<option value='" . $array['name'] . "'>" . ((isset($array['caption']) && strlen($array['caption'])>0) ? $array['caption'] : $array['name']) . "</option>";
            }
        }
        echo "</select></div><div class='clear'></div></div>";

        if (is_array($shortcodesUI)) {
            foreach ($shortcodesUI as $array) {
                echo "
                <div shortcodename='" . $array['name'] . "' class='shortcodeitem " . $array['name'] . "'>
                    <div class='handler_body'>" . $array['handler'] . "</div>                    
					<div class='shortcode_insert_button'><button class='insertshortcode button button-primary button-small'>".__('Insert', 'gt3_builder')."</button><div class='clear'></div></div>					
                </div>				
                ";
            }
        }
        ?>

        <script>
            jQuery('.shortcodeitem:first').show();
        </script>

        <?php

        die();
    }
}


#Get unused ID
add_action('wp_ajax_get_unused_id_ajax', 'get_unused_id_ajax');
if (!function_exists('get_unused_id_ajax')) {
    function get_unused_id_ajax()
    {
        $lastid = gt3pb_get_option("last_slide_id");
        if ($lastid < 3) {
            $lastid = 2;
        }
        $lastid++;

        echo $lastid;

        gt3pb_update_option("last_slide_id", $lastid);

        die();
    }
}

#Get unused ID
add_action('wp_ajax_gt3_generate_inserted_media_to_slider', 'gt3_generate_inserted_media_to_slider');
if (!function_exists('gt3_generate_inserted_media_to_slider')) {
    function gt3_generate_inserted_media_to_slider()
    {
        if (current_user_can('manage_options')) {
            $type = esc_attr($_POST['type']); #v1 = gallery, v2 = post_formats
            $itemsIDs = esc_attr($_POST['itemsIDs']);
            $settings_type = esc_attr($_POST['settings_type']);

            $array = explode(',', $itemsIDs);

            if (is_array($array)) {
                foreach ($array as $tempid => $attach_id) {

                    $lastid = 'id_' . (time() . mt_rand(9000, 9999) . '');

                    $lastid = gt3pb_get_option("last_slide_id");
                    if ($lastid < 3) {
                        $lastid = 2;
                    }
                    $lastid++;

                    gt3pb_update_option("last_slide_id", $lastid);

                    $featured_image = wp_get_attachment_image_src($attach_id, 'large');

                    #For gallery
                    if ($type == "v1") {
                    echo '
                    <li>
                        <div class="img-item item-with-settings append_animation">
                            <input type="hidden" name="pagebuilder[sliders][' . $settings_type . '][slides][' . $lastid . '][attach_id]" value="' . $attach_id . '">
                            <input type="hidden" name="pagebuilder[sliders][' . $settings_type . '][slides][' . $lastid . '][slide_type]" value="image">
                            <div class="img-preview">
                                <img src="' . aq_resize($featured_image[0], "156", "106", true, true, true) . '" alt="">
                                <div class="hover-container">
                                    <div class="inter_x"></div>
                                    <div class="inter_drag"></div>
                                    <div class="inter_edit"></div>
                                </div>
                            </div>
                            <div class="edit_popup">
                                <h2>Image Settings</h2>
                                <span class="edit_popup_close"></span>
                                <div class="this-option img-in-slider">
                                    <div class="padding-cont">
                                        <div class="fl w9">
                                            <h4>Title</h4>
                                            <input name="pagebuilder[sliders][' . $settings_type . '][slides][' . $lastid . '][title][value]" type="text" value="" class="textoption type1">
                                        </div>
                                        <div class="right_block fl w1">
                                            <h4>color</h4>
                                            <div class="color_picker_block">
                                                <span class="sharp">#</span>
                                                <input type="text" value="" name="pagebuilder[sliders][' . $settings_type . '][slides][' . $lastid . '][title][color]" maxlength="25" class="medium cpicker textoption type1">
                                                
                                            </div>
                                        </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hr_double"></div>
                                <div class="padding-cont">
                                    <div class="fl w9">
                                        <h4>Caption</h4>
                                        <textarea name="pagebuilder[sliders][' . $settings_type . '][slides][' . $lastid . '][caption][value]" type="text" class="textoption type1 big"></textarea>
                                    </div>
                                    <div class="right_block fl w1">
                                        <h4>color</h4>
                                        <div class="color_picker_block">
                                            <span class="sharp">#</span>
                                            <input type="text" value="" name="pagebuilder[sliders][' . $settings_type . '][slides][' . $lastid . '][caption][color]" maxlength="25" class="medium cpicker textoption type1">
                                            
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="padding-cont">
                                <input type="button" value="Done" class="done-btn green-btn" name="ignore_this_button">
                                <div class="clear"></div>
                            </div>
                        </div>
                        </div>
                    </li>
                    ';
                    }

                    #For post formats
                    if ($type == "v2") {
                    echo '
                        <div class="img-item style_small">
                            <div class="img-preview">
                                <img src="' . aq_resize($featured_image[0], "62", "62", true, true, true) . '" data-full-url="'.$featured_image[0].'" data-thumb-url="' . aq_resize($featured_image[0], "156", "106", true, true, true) . '" alt="" class="previmg">
                                <div class="hover-container"></div>
                                <div class="deldel-container"></div>
                            </div>
                            <input type="hidden" name="pagebuilder[post-formats][images][' . $lastid . '][attach_id]" value="' . $attach_id . '">
                        </div>
                    ';
                    }
                }
            }
        }

        die();
    }
}

add_action('wp_ajax_gt3_generate_60x60_media', 'gt3_generate_60x60_media');
if (!function_exists('gt3_generate_60x60_media')) {
    function gt3_generate_60x60_media() {
        if (current_user_can('manage_options')) {
            $url = esc_attr($_POST['url']);
            echo aq_resize($url, "60", "60", true, true, true) ;
        }

        die();
    }
}

// --------extended version start --------

add_action('wp_ajax_gt3_save_template', 'gt3_save_template');
if (!function_exists('gt3_save_template')) {
    function gt3_save_template() {
        if (current_user_can('manage_options')) {
            $serialize_string = stripslashes($_POST['serialize_string']);
            $template_name = stripslashes($_POST['name']);

            $tmp_array = array();
            foreach (json_decode($serialize_string, true) as $key => $value) {
                if (strpos($value['name'], 'pagebuilder[') !== false)
                    $tmp_array[$value['name']] = $value['value'];
            };
            $builder_templates = get_option("builder_templates");
            $builder_templates[$template_name] = json_encode($tmp_array);
            update_option("builder_templates", $builder_templates);
        }

        die();
    }
}

add_action('wp_ajax_gt3_load_template', 'gt3_load_template');
if (!function_exists('gt3_load_template')) {
    function gt3_load_template() {
        if (current_user_can('manage_options')) {
            // $serialize_string = stripslashes($_POST['serialize_string']);
            $template_name = stripslashes($_POST['name']);
            $id = stripslashes($_POST['post_id']);
            $builder_templates = get_option("builder_templates");
            $current_template = json_decode($builder_templates[$template_name], true);

            $gt3_theme_pagebuilder = get_plugin_pagebuilder($id);
            unset($gt3_theme_pagebuilder);

            if (!is_array($gt3_theme_pagebuilder)) {
              $gt3_theme_pagebuilder = array();
            }

            $pattern = '/\[(.*?)\]/';
            foreach ($current_template as $key => $value) {
              $founded = preg_match_all($pattern, $key, $matches); 
              
              gt3_get_match_array($gt3_theme_pagebuilder, $matches[1], $value);
            }

            update_theme_pagebuilder($id, "pagebuilder", $gt3_theme_pagebuilder);
        }

        die();
    }
}

add_action('wp_ajax_gt3_delete_template', 'gt3_delete_template');
if (!function_exists('gt3_delete_template')) {
    function gt3_delete_template() {
        if (current_user_can('manage_options')) {
            $template_name = stripslashes($_POST['name']);
            $builder_templates = get_option("builder_templates");
            unset($builder_templates[$template_name]);
            update_option("builder_templates", $builder_templates);
        }

        die();
    }
}

add_action('wp_ajax_gt3_copy_block_to_clipboard', 'gt3_copy_block_to_clipboard');
if (!function_exists('gt3_copy_block_to_clipboard')) {
    function gt3_copy_block_to_clipboard() {
        if (current_user_can('manage_options')) {
            $serialize_string = stripslashes($_POST['serialize_string']);
            $key_id = stripslashes($_POST['key']);

            $tmp_array = array();
            foreach (json_decode($serialize_string, true) as $key => $value) {
                if (strpos($value['name'], 'pagebuilder[modules]['.$key_id.']') !== false)
                    $tmp_array[$value['name']] = $value['value'];
            };

            update_option("builder_clipboard", json_encode($tmp_array));
        }

        die();
    }
}

add_action('wp_ajax_gt3_paste_block_from_clipboard', 'gt3_paste_block_from_clipboard');
if (!function_exists('gt3_paste_block_from_clipboard')) {
    function gt3_paste_block_from_clipboard() {
        $tinymce_activation_class = $_POST['tinymce_activation_class'];
        $id = stripslashes($_POST['post_id']);
        $tmp_array = get_plugin_pagebuilder($id);

        if (current_user_can('manage_options')) {
            $clip = get_option("builder_clipboard");
            if ($clip != false) {
              $clip2 = '';
              $pattern = '/\[(id_\d*?)\]/';
              foreach (json_decode($clip, true) as $key => $value) {
                $clip2 .= $key . ',';
              };
              $founded = preg_match_all($pattern, $clip2, $matches); 
              $res = array_unique($matches[0]);
              foreach ($res as $key => $value) {
                $clip = str_replace($value, '[' . get_unused_id() . ']', $clip);
              }

              $pattern = '/\[(.*?)\]/';
              foreach (json_decode($clip, true) as $key => $value) {
                $founded = preg_match_all($pattern, $key, $matches); 
                gt3_get_match_array($tmp_array, $matches[1], $value);
              };
              $key_id = $matches[1][1];

              $module_caption = $tmp_array['modules'][$key_id]['caption'];
              $module_name = $tmp_array['modules'][$key_id]['name'];
              $module_size = $tmp_array['modules'][$key_id]['size'];
              $size_caption = str_replace('_', '/', str_replace('block_', '', $module_size));

              update_theme_pagebuilder($id, "pagebuilder", $tmp_array);

              echo get_pb_module($module_name, $module_caption, $key_id, $tmp_array, $module_size, $size_caption, $tinymce_activation_class);
            }
        }

        die();
    }
}

add_action('wp_ajax_gt3_duplicate_block', 'gt3_duplicate_block');
if (!function_exists('gt3_duplicate_block')) {
    function gt3_duplicate_block() {
        $tinymce_activation_class = $_POST['tinymce_activation_class'];
        $id = stripslashes($_POST['post_id']);
        $serialize_string = stripslashes($_POST['serialize_string']);
        $key_id = stripslashes($_POST['key']);

        if (current_user_can('manage_options')) {
            $tmp_array = array();
            $builder_array = array();
            foreach (json_decode($serialize_string, true) as $key => $value) {
                if (strpos($value['name'], 'pagebuilder[modules]['.$key_id.']') !== false)
                    $tmp_array[$value['name']] = $value['value'];
            };

            $clip = $tmp_array;
            $clip2 = '';
            $pattern = '/\[(id_\d*?)\]/';
            foreach ($clip as $key => $value) {
               $clip2 .= $key . ',';
            };
            
            $founded = preg_match_all($pattern, $clip2, $matches); 
            $clip = json_encode($clip);
            $res = array_unique($matches[0]);
            foreach ($res as $key => $value) {
              $clip = str_replace($value, '[' . get_unused_id() . ']', $clip);
            }       

            $pattern = '/\[(.*?)\]/';
            foreach (json_decode($clip) as $key => $value) {
              $founded = preg_match_all($pattern, $key, $matches); 
                gt3_get_match_array($builder_array, $matches[1], $value);
            };
            $key_id = $matches[1][1];
            $module_caption = $builder_array['modules'][$key_id]['caption'];
            $module_name = $builder_array['modules'][$key_id]['name'];
            $module_size = $builder_array['modules'][$key_id]['size'];
            $size_caption = str_replace('_', '/', str_replace('block_', '', $module_size));

            echo get_pb_module($module_name, $module_caption, $key_id, $builder_array, $module_size, $size_caption, $tinymce_activation_class);
        }

        die();
    }
}

// --------extended version end --------

?>