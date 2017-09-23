<?php

if (!isset($content_width)) $content_width = 940;

function gt3_get_theme_pagebuilder($postid, $args = array())
{
	$gt3_theme_pagebuilder = get_post_meta($postid, "pagebuilder", true);
	if (!is_array($gt3_theme_pagebuilder))
	{
		$gt3_theme_pagebuilder = array();
	}

	if (!isset($gt3_theme_pagebuilder['settings']['show_content_area']))
	{
		$gt3_theme_pagebuilder['settings']['show_content_area'] = "yes";
	}
	if (!isset($gt3_theme_pagebuilder['settings']['show_page_title']))
	{
		$gt3_theme_pagebuilder['settings']['show_page_title'] = "yes";
	}
	if (isset($args['not_prepare_sidebars']) && $args['not_prepare_sidebars'] == "true")
	{

	} else
	{
		if (!isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) || $gt3_theme_pagebuilder['settings']['layout-sidebars'] == "default")
		{
			$gt3_theme_pagebuilder['settings']['layout-sidebars'] = gt3_get_theme_option("default_sidebar_layout");
		}
	}

	return $gt3_theme_pagebuilder;
}

function gt3_get_theme_sidebars_for_admin()
{
	$theme_sidebars = gt3_get_theme_option("theme_sidebars");
	if (!is_array($theme_sidebars))
	{
		$theme_sidebars = array();
	}

	return $theme_sidebars;
}

/*Work with options*/
if (!function_exists('gt3pb_get_option'))
{
	function gt3pb_get_option($optionname, $defaultValue = "")
	{
		$returnedValue = get_option("gt3pb_" . $optionname, $defaultValue);

		if (gettype($returnedValue) == "string")
		{
			return stripslashes($returnedValue);
		} else
		{
			return $returnedValue;
		}
	}
}

if (!function_exists('gt3pb_delete_option'))
{
	function gt3pb_delete_option($optionname)
	{
		return delete_option("gt3pb_" . $optionname);
	}
}

if (!function_exists('gt3pb_update_option'))
{
	function gt3pb_update_option($optionname, $optionvalue)
	{
		if (update_option("gt3pb_" . $optionname, $optionvalue))
		{
			return true;
		}
	}
}

if (!function_exists('gt3_get_pf_type_output')) {
  function gt3_get_pf_type_output($args)
  {
    $compile = "";
    extract($args);

    $gt3_theme_featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');

    if (isset($pf)) {

      if (isset($fw_post) && $fw_post == true) {$pf = "text"; $height = null;}

      /* Image */
      if ($pf == 'image') {
        $compile .= "<div class='pf_output_container'>";

        $page_type = 'type_1';
        if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == 'no-sidebar') {
            $slider_width = 1170;
        } else {
            $slider_width = 830;
        }

        if (isset($gt3_theme_pagebuilder['post-formats']['slider_height']) && $gt3_theme_pagebuilder['post-formats']['slider_height'] !== '') {
            if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == 'no-sidebar') {
                $slider_height = $gt3_theme_pagebuilder['post-formats']['slider_height'];
            } else {
                $slider_height = ($gt3_theme_pagebuilder['post-formats']['slider_height']) / 1.41;
            }
        } else {
            if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == 'no-sidebar') {
                $slider_height = 846;
            } else {
                $slider_height = 600;
            }
        }

        if (isset($gt3_theme_pagebuilder['post-formats']['images']) && is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
          $compile .= '
            <div class="slider_wrapper" data-height="'.$slider_height.'" data-type="'.$page_type.'">
              <div class="post_overlay"></div>
              <ul class="slider_listing">
          ';

          $i = 1;

          if (is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
            foreach ($gt3_theme_pagebuilder['post-formats']['images'] as $imgid => $img) {
              $compile .= '

                <li class="gt3_js_bg_url" data-number="' . $i . '" data-background="' . esc_url(aq_resize(wp_get_attachment_url($img['attach_id']), $slider_width, $slider_height, true, true, true)) . '"></li>
              ';

              $i++;
            }
          }

          if (count($gt3_theme_pagebuilder['post-formats']['images']) > '1') {
            $compile .= '
              </ul>
              <div class="prev_button"></div>
              <div class="next_button"></div>
            </div>
            ';
          } else {
            $compile .= '
              </ul>
            </div>
            ';
          }

        } else {
          $attachment_ID = get_post_thumbnail_id(get_the_ID());

          if (isset($attachment_ID) && $attachment_ID !== '') {
            $array = wp_get_attachment_metadata($attachment_ID);

            $width = $array['width'];
            $height = $array['height'];

            if (($width / $height) > 1) {
              $compile .= "
              <img src='" . esc_url(aq_resize($gt3_theme_featured_image[0], 1170, 846, true, true, true)) . "' alt='' />
            ";
            } else {
              $compile .= "
              <img src='" . aq_resize($gt3_theme_featured_image[0], true, true, true) . "' alt='' />
            ";
            }
          }
        }
      }
      /* Video */
      elseif ($pf == 'video') {
        $compile .= "<div class='pf_output_container'>";

        $uniqid = mt_rand(0, 9999);
        global $gt3_YTApiLoaded, $gt3_allYTVideos;
        if (empty($gt3_YTApiLoaded)) {
          $gt3_YTApiLoaded = false;
        }
        if (empty($gt3_allYTVideos)) {
          $gt3_allYTVideos = array();
        }

        $video_url = ((isset($gt3_theme_pagebuilder['post-formats']['videourl']) && strlen($gt3_theme_pagebuilder['post-formats']['videourl']) > 0) ? $gt3_theme_pagebuilder['post-formats']['videourl'] : "");
        if (isset($gt3_theme_pagebuilder['post-formats']['video_height']) && $gt3_theme_pagebuilder['post-formats']['video_height'] !== '') {
          $video_height = $gt3_theme_pagebuilder['post-formats']['video_height'];
        } else {
            if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == 'no-sidebar') {
                $video_height = 670;
            } else {
                $video_height = 480;
            }

        }

        #YOUTUBE
        $is_youtube = substr_count($video_url, "youtu");
        if ($is_youtube > 0) {
          $videoid = substr(strstr($video_url, "="), 1);
          $compile .= "
            <iframe height=\"" . $video_height . "\" src=\"https://www.youtube.com/embed/" . $videoid . "?autoplay=0\" allowfullscreen></iframe>
          ";
        }

        #VIMEO
        $is_vimeo = substr_count($video_url, "vimeo");
        if ($is_vimeo > 0) {
          $videoid = substr(strstr($video_url, "m/"), 2);
          $compile .= "
            <iframe src=\"http://player.vimeo.com/video/" . $videoid . "\" height=\"" . $video_height . "\" allowFullScreen></iframe>
          ";
        }
      }
      /* Standard */
      else {
        $compile .= "
          <div class='pf_output_container'>
        ";

        $attachment_ID = get_post_thumbnail_id(get_the_ID());

        if (isset($attachment_ID) && $attachment_ID !== '') {
          $array = wp_get_attachment_metadata($attachment_ID);

          $width = $array['width'];
          $height = $array['height'];

          if (($width / $height) > 1) {
            $compile .= "
              <img src='" . aq_resize($gt3_theme_featured_image[0], 1200, 870, true, true, true) . "' alt='' />
            ";
          } else {
            $compile .= "
              <img src='" . aq_resize($gt3_theme_featured_image[0], true, true, true) . "' alt='' />
            ";
          }
        }
      }
        $compile .= "
          </div><!-- pf_output_container -->
        ";
    }

    return $compile;
  }
}

function gt3pb_get_plugin_pagebuilder($postid)
{
  $gt3_theme_pagebuilder = get_post_meta($postid, "pagebuilder", true);
  if (!is_array($gt3_theme_pagebuilder)) {
    $gt3_theme_pagebuilder = array();
  }

  if (!isset($gt3_theme_pagebuilder['settings']['show_content_area'])) {
    $gt3_theme_pagebuilder['settings']['show_content_area'] = "yes";
  }
  if (!isset($gt3_theme_pagebuilder['settings']['show_page_title'])) {
    $gt3_theme_pagebuilder['settings']['show_page_title'] = "yes";
  }

  array_walk_recursive($gt3_theme_pagebuilder, 'stripslashes_in_array');

  return $gt3_theme_pagebuilder;
}

if (!function_exists('gt3_get_theme_option')) {
  function gt3_get_theme_option($optionname, $defaultValue = null)
  {
  $gt3_options = get_option(GT3_THEMESHORT . "gt3_options");

  if (isset($gt3_options[$optionname])) {
    if (gettype($gt3_options[$optionname]) == "string") {
    return stripslashes($gt3_options[$optionname]);
    } else {
    return $gt3_options[$optionname];
    }
  } else {
    return $defaultValue;
  }
  }
}

function gt3_the_theme_option($optionname, $beforeoutput = "", $afteroutput = "")
{
	$returnedValue = get_option(GT3_THEMESHORT . $optionname);

	if (strlen($returnedValue) > 0)
	{
		echo $beforeoutput . stripslashes($returnedValue) . $afteroutput;
	}
}

function gt3_get_if_strlen($str, $beforeoutput = "", $afteroutput = "")
{
	if (strlen($str) > 0)
	{
		return $beforeoutput . $str . $afteroutput;
	}
}

if (!function_exists('gt3_delete_theme_option')) {
  function gt3_delete_theme_option($optionname)
  {
  $gt3_options = get_option(GT3_THEMESHORT . "gt3_options", array());
  if (isset($gt3_options[$optionname])) {
    unset($gt3_options[$optionname]);
  }

  if (update_option(GT3_THEMESHORT . "gt3_options", $gt3_options)) {
    return true;
  }
  }
}

if (!function_exists('gt3_update_theme_option')) {
  function gt3_update_theme_option($optionname, $optionvalue)
  {
  $gt3_options = get_option(GT3_THEMESHORT . "gt3_options", array());
  $gt3_options[$optionname] = $optionvalue;

  if (update_option(GT3_THEMESHORT . "gt3_options", $gt3_options)) {
    return true;
  }
  }
}

function gt3_messagebox($actionmessage)
{
	$compile = "<div class='admin_message_box fadeout'>" . $actionmessage . "</div>";
	return $compile;
}

function gt3_theme_comment($comment, $args, $depth)
{
	$max_depth_comment = $args['max_depth'];
	if ($max_depth_comment > 4)
	{
		$max_depth_comment = 4;
	}
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  <div id="comment-<?php comment_ID(); ?>" class="stand_comment">
    <div class="commentava wrapped_img">
      <?php echo get_avatar($comment->comment_author_email, 70); ?>

    </div>
    <div class="thiscommentbody">
    	<div class="comment_author"><h6><?php printf('%s', get_comment_author_link()) ?> <?php edit_comment_link('(Edit)', '  ', '') ?></h6></div>
    	<div class="comment_meta post-meta">
    	  <span class="comment_date"><?php printf('%1$s', get_comment_date(get_option( 'date_format' ))) ?></span>
    	</div>
      <div class="comment_content">
      	<div class="comment_box">
            <?php if ($comment->comment_approved == '0') : ?>
            <p><em><?php esc_html_e('Your comment is awaiting moderation.', 'pizzahit'); ?></em></p>
            <?php endif; ?>
            <?php comment_text() ?>
        </div>
        <span class="reply_button"><?php comment_reply_link(array_merge($args, array('before' => ' <span class="comments">', 'after' => '</span>', 'depth' => $depth, 'reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__("Reply", "pizzahit") . '', 'max_depth' => $max_depth_comment))) ?></span>
      </div><!-- .comment_content -->
      
    </div>
  </div>
<?php
}

#Custom paging
if (!function_exists('gt3_get_theme_pagination')) {
  function gt3_get_theme_pagination($range = 5, $type = "")
  {
  if ($type == "show_in_shortcodes") {
    global $paged, $gt3_wp_query_in_shortcodes;
    $wp_query = $gt3_wp_query_in_shortcodes;
  } else if ($type == "show_in_blog_listing") {
    global $paged, $gt3_wp_listing_query;
    $wp_query = $gt3_wp_listing_query;
  } else {
    global $paged, $wp_query;
  }

  if (empty($paged)) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
  }

  $compile = '';

  $max_page = $wp_query->max_num_pages;
  if ($max_page > 1) {
    $compile .= '<ul class="pagerblock text-center">';
  }

  if ($max_page > 1) {
    if (!$paged) {
    $paged = 1;
    }
    if ($max_page > $range) {
    if ($paged < $range) {
      for ($i = 1; $i <= ($range + 1); $i++) {
      $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
      if ($i == $paged) $compile .= " class='current'";
      $compile .= ">$i</a></li>";
      }
    } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
      for ($i = $max_page - $range; $i <= $max_page; $i++) {
      $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
      if ($i == $paged) $compile .= " class='current'";
      $compile .= ">$i</a></li>";
      }
    } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
      for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); $i++) {
      $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
      if ($i == $paged) $compile .= " class='current'";
      $compile .= ">$i</a></li>";
      }
    }
    } else {
    for ($i = 1; $i <= $max_page; $i++) {
      $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
      if ($i == $paged) $compile .= " class='current'";
      $compile .= ">$i</a></li>";
    }
    }
  }

  if ($max_page > 1) {
    $compile .= '</ul>';
  }

		return $compile;
  }
}

if (!function_exists('gt3_get_header_end')) {
  function gt3_get_header_end($postid) {
    $gt3_theme_pagebuilder = get_post_meta($postid, "pagebuilder", true);
    if (!is_array($gt3_theme_pagebuilder)) {
      $gt3_theme_pagebuilder = array();
    }
		$gt3_theme_featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
		if (isset($gt3_theme_pagebuilder['page_settings']['fw_featured']) && $gt3_theme_pagebuilder['page_settings']['fw_featured'] == 'on') {
			$fw_featured = true;
		} else {
			$fw_featured = false;
		}
		if(!empty($gt3_theme_featured_image) && $fw_featured == true) { ?>
			<div class="fw_page_featured_image_wrapper">
				<img class="fw_page_featured_image_wrapper" src="<?php echo esc_url(aq_resize($gt3_theme_featured_image[0], "1920", "570", true, true, true)); ?>" alt="">
			</div>
			<div class="site_wrapper fadeOnLoad">
				<div class="main_wrapper with_fw_image">
		<?php } else { ?>
			<div class="site_wrapper fadeOnLoad">
				<div class="main_wrapper">
		<?php }		
	}
}

if (!function_exists('gt3_get_highlight_search_results')) {
	function gt3_get_highlight_search_results($search_string, $exc_oryg) {
	  $result_string = array();
	  $exc = strtolower($exc_oryg);
	  $result_string = array();
	  while (strpos($exc, $search_string) !== false) {
	  array_push($result_string, substr($exc_oryg, 0, strpos($exc, $search_string))."<span class='founded'>".substr($exc_oryg, strpos($exc, $search_string), strlen($search_string))."</span>");
	  $exc_oryg = substr($exc_oryg, strpos($exc, $search_string) + strlen($search_string));
	  $exc = substr($exc, strpos($exc, $search_string) + strlen($search_string));
	  }
	  array_push($result_string, $exc_oryg);
	  $exc = '';
	  foreach($result_string as $res) $exc .= $res;

	  return $exc;
	}
}

function gt3_the_pb_custom_bg_and_color($gt3_theme_pagebuilder, $args = array())
{
	if ((isset($gt3_theme_pagebuilder['page_settings']['page_layout']['img']['attachid']) && $gt3_theme_pagebuilder['page_settings']['page_layout']['img']['attachid'] !== '') || (isset($gt3_theme_pagebuilder['page_settings']['page_layout']['color']['hash']) && $gt3_theme_pagebuilder['page_settings']['page_layout']['color']['hash'] !== ''))
	{
		$bgimg_url = wp_get_attachment_url($gt3_theme_pagebuilder['page_settings']['page_layout']['img']['attachid']);
		$bgcolor_hash = $gt3_theme_pagebuilder['page_settings']['page_layout']['color']['hash'];
	} else
	{
		if (get_page_template_slug() !== "page-gallery-grid.php" && get_page_template_slug() !== "page-gallery-masonry.php")
		{
			$bgimg_url = gt3_get_theme_option("bg_img");
			$bgcolor_hash = gt3_get_theme_option("default_bg_color");
		}
	}
	if (isset($args['classes_for_body']) && $args['classes_for_body'] == true)
	{
		return "page_with_custom_background_image";
	} else
	{
		if (!isset ($bgimg_url)) $bgimg_url = '';
		if (!isset ($bgcolor_hash)) $bgcolor_hash = '';
		echo '<div class="custom_bg img_bg" style="background-image: url(\'' . $bgimg_url . '\'); background-color:#' . $bgcolor_hash . ';"></div>';
	}
	return true;
}

if (!function_exists('gt3_get_default_pb_settings'))
{
	function gt3_get_default_pb_settings()
	{
		$gt3_theme_pagebuilder['settings']['layout-sidebars'] = gt3_get_theme_option("default_sidebar_layout");
		$gt3_theme_pagebuilder['settings']['left-sidebar'] = "Default";
		$gt3_theme_pagebuilder['settings']['right-sidebar'] = "Default";
		$gt3_theme_pagebuilder['settings']['bg_image']['status'] = gt3_get_theme_option("show_bg_img_by_default");
		$gt3_theme_pagebuilder['settings']['bg_image']['src'] = gt3_get_theme_option("bg_img");
		$gt3_theme_pagebuilder['settings']['custom_color']['status'] = gt3_get_theme_option("show_bg_color_by_default");
		$gt3_theme_pagebuilder['settings']['custom_color']['value'] = gt3_get_theme_option("default_bg_color");
		$gt3_theme_pagebuilder['settings']['bg_image']['type'] = gt3_get_theme_option("default_bg_img_position");

		return $gt3_theme_pagebuilder;
	}
}

if (!function_exists('gt3_HexToRGB'))
{
	function gt3_HexToRGB($hex = "ffffff")
	{
		$color = array();
		if (strlen($hex) < 1)
		{
			$hex = "ffffff";
		}

		if (strlen($hex) == 3)
		{
      return hexdec(substr($hex, 0, 1) . $r) . "," . hexdec(substr($hex, 1, 1) . $g) . "," . hexdec(substr($hex, 2, 1) . $b);
		} else if (strlen($hex) == 6)
			{
        return hexdec(substr($hex, 0, 2)) . "," . hexdec(substr($hex, 2, 2)) . "," . hexdec(substr($hex, 4, 2));
			}

		
	}
}

if (!function_exists('gt3_smarty_modifier_truncate'))
{
	function gt3_smarty_modifier_truncate($string, $length = 80, $etc = '... ',
		$break_words = false, $middle = false)
	{
		if ($length == 0)
			return '';

		if (mb_strlen($string, 'utf8') > $length)
		{
			$length -= mb_strlen($etc, 'utf8');
			if (!$break_words && !$middle)
			{
				$string = preg_replace('/\s+\S+\s*$/su', '', mb_substr($string, 0, $length + 1, 'utf8'));
			}
			if (!$middle)
			{
				return mb_substr($string, 0, $length, 'utf8') . $etc;
			} else
			{
				return mb_substr($string, 0, $length / 2, 'utf8') . $etc . mb_substr($string, -$length / 2, utf8);
			}
		} else
		{
			return $string;
		}
	}
}

function gt3_show_social_icons($array)
{
  $compile = "";
  foreach ($array as $key => $value) {
  if (strlen(gt3_get_theme_option($value['uniqid'])) > 0) {
    $compile .= "<li><a target='" . $value['target'] . "' href='" . gt3_get_theme_option($value['uniqid']) . "' title='" . $value['title'] . "'><i class='fa fa-" . $value['class'] . "'></i></a></li>";
  }
  }
  $compile .= "";
  if (is_array($array) && count($array) > 0) {
  return $compile;
  } else {
  return "";
  }
}

add_filter('the_password_form', 'custom_password_form');
function custom_password_form()
{
	global $post;
	$label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
	$o = '<form class="protected-post-form" action="' . esc_url(get_option('siteurl')) . '/wp-login.php?action=postpass" method="post">
	<input name="post_password" id="' . $label . '" type="password" size="20" placeholder="'.esc_attr__("Password", 'pizzahit') .'/><input type="submit" name="Submit" value="' . esc_attr__("Submit", 'pizzahit') . '" />
	<div class="pp_notify">' . esc_html__("To view it please enter your password", 'pizzahit') . '</div>
	</form>
	';
	return $o;
}

function gt3_change_pw_text($content)
{
	if (gt3_get_theme_option("demo_server") == "true")
	{
		$content = str_replace(
			esc_html__("To view it please enter your password", 'pizzahit'),
			esc_html__("To view it please enter your password (Hint:12345)", 'pizzahit'),
			$content);
		return $content;
	} else
	{
		return $content;
	}
}

add_filter('the_content', 'gt3_change_pw_text');

function gt3_get_field_media_and_attach_id($name, $attach_id, $previewW = "200px", $previewH = null, $classname = "")
{
	return "<div class='select_image_root " . $classname . "'>
    <input type='hidden' name='" . $name . "' value='" . $attach_id . "' class='select_img_attachid'>
    <h4>". esc_html__('Please select image to display as a featured one', 'pizzahit')."</h4>
    <div class='select_img_preview'><img src='" . ($attach_id > 0 ? esc_url(aq_resize(wp_get_attachment_url($attach_id), $previewW, $previewH, true, true, true)) : "") . "' alt=''></div>
    <input type='button' class='button button-secondary button-large select_attach_id_from_media_library' value='Select'>
  </div>";
}

require_once( __DIR__ . '/custom-product-types.php');

function gt3_showJSInFooter()
{
	if (isset($GLOBALS['showOnlyOneTimeJS']) && is_array($GLOBALS['showOnlyOneTimeJS']))
	{
		foreach ($GLOBALS['showOnlyOneTimeJS'] as $id => $js)
		{
			echo $js;
		}
	}
}

add_action('wp_footer', 'gt3_showJSInFooter');

function is_gt3_builder_active()
{
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if (is_plugin_active('gt3-pagebuilder-pizzahit/gt3_builder.php'))
	{
		return true;
	} else
	{
		return false;
	}
}

function gt3_theme_slug_setup()
{
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'gt3_theme_slug_setup' );

if ( ! function_exists( '_wp_render_title_tag' ) )
{
	function theme_slug_render_title()
	{
?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
  <?php
	}
	add_action( 'wp_head', 'theme_slug_render_title' );
}

require_once get_template_directory() . "/core/loader.php";

if (!function_exists('gt3_get_logo'))
{
	function gt3_get_logo()
	{
		return '
		<a href="'.esc_url(home_url('/')).'" class="logo_link">
			<img src="'.gt3_get_theme_option("logo_retina").'" alt="" width="'.gt3_get_theme_option("logo_standart_width").'" height="'.gt3_get_theme_option("logo_standart_height").'" class="logo_def">
		</a>
		';
	}
}

if (!function_exists('gt3_get_search_form'))
{
	function gt3_get_search_form()
	{
		return '
		<div class="searchblock">
			<i class="fa fa-search gt3-show-search"></i>
			<div class="search-pop-cont">
				<form name="search_form" method="get" action="'. esc_url( home_url( '/' ) ).'" class="search_form">
					<input type="text" name="s" value="" placeholder="'. esc_attr('Search the site...', 'pizzahit') .'" title="'. esc_attr('Search the site...', 'pizzahit') .'" class="field_search">
				</form>
			</div>
		</div>
		';
	}
}

if (!function_exists('gt3_get_dynamic_sidebar'))
{
	function gt3_get_dynamic_sidebar($index = 1)
	{
		$sidebar_contents = "";
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();
		return $sidebar_contents;
	}
}

if (!function_exists('gt3_get_sidemenu'))
{
	function gt3_get_sidemenu()
	{
		return '
		<div class="gt3_sidemenu_cont">
			<div class="gt3_sidemenu_padding">
				'. gt3_get_dynamic_sidebar("Side Menu") .'
			</div>
		</div>
		';
	}
}

if (!function_exists('gt3_select_image_from_media_button')) {
  function gt3_select_image_from_media_button($fieldname, $fieldvalue, $button_caption, $default_value)
  {
  if (wp_get_attachment_url($fieldvalue)) {
    $compile = '<input class="gt3_image_selected_id" name="' . $fieldname . '" type="hidden" value="' . $fieldvalue . '" />';
    $compile .= '<input type="button" name="button_caption1" class="gt3_admin_button gt3_select_image_from_media" value="' . $button_caption . '">';
    $compile .= '<input type="button" name="button_caption2" class="gt3_admin_button gt3_admin_danger_btn gt3_image_from_media_remove" value="Remove">';
    $compile .= '<a class="admin_selected_image" href="' . wp_get_attachment_url($fieldvalue) . '" target="_blank"><img src="' . wp_get_attachment_url($fieldvalue) . '" alt="" /></a>';
  } else {
    $compile = '<input class="gt3_image_selected_id" name="' . $fieldname . '" type="hidden" value="' . $default_value . '" />';
    $compile .= '<input type="button" name="button_caption1" class="gt3_admin_button gt3_select_image_from_media" value="' . $button_caption . '">';
    $compile .= '<input type="button" name="button_caption2" class="gt3_admin_button gt3_admin_danger_btn gt3_image_from_media_remove" value="Remove">';
    $compile .= '<a class="admin_selected_image" href="' . $default_value . '" target="_blank"><img src="' . $default_value . '" alt="" /></a>';
  }
  return $compile;
  }
}

if (!function_exists('gt3_get_header'))
{
	function gt3_get_header()
	{
		if (gt3_get_theme_option("show_preloader") == 'on') {
        echo '
        <div class="preloader_overlay'.((gt3_get_theme_option("demo_server") == true) ? ' demo': '').'">
          <div class="custom_preloader_cont">
            <img src="' . gt3_get_theme_option("preloader_img") . '" alt="" />
          </div>
        </div>
      ';
    }

		echo '<header class="gt3_header_type_'.GT3_HEADER_TYPE.' ' . (gt3_get_theme_option("header_style")) . '"><div class="container">';

    if (GT3_HEADER_TYPE == 45)
    {
        echo '
            <div class="row head_block">
                <div class="header_top_line">
                  <div class="col-xs-12 col-sm-4 header_contacts">';
                    if (gt3_get_theme_option("contacts_area_left_header") == 'enabled') {
                      echo '<span><strong>' . esc_html("Free Call ", "pizzahit") . '</strong>'.  gt3_get_theme_option("phone_number") . '</span>
                    <span>' . gt3_get_theme_option("contact_address") . '</span>';
                    }
                  echo '
                  </div>
                  <div class="col-xs-12 col-sm-4 header_logo">
                  ' . gt3_get_logo() . '
                  </div>
                  <div class="col-xs-12 col-sm-4 header_timetable">';
                    if (gt3_get_theme_option("timetable_area_right_header") == 'enabled') {
                      echo '<span>' . gt3_get_theme_option("timetable_title") . '</span>
                    <span>' . gt3_get_theme_option("timetable_text") . '</span>';
                    }
                    echo '
                  </div>
                </div>
                <div class="header_main_line">
                    <div class="mobile-navigation-toggle">
                        <div class="toggle-box">
                            <div class="toggle-inner"></div>
                        </div><!-- toggle-box -->
                    </div><!-- mobile-navigation-toggle -->
                    <div class="logo">
                        ' . gt3_get_logo() . '
                    </div><!-- logo -->';
                    if (has_nav_menu('main_menu')) {
                        wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false)));
                    }
                    ?>
                    <?php
                    // Header Cart
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    if (is_plugin_active('woocommerce/woocommerce.php')) {
                    ?>
                      <div class="header_cart_content">
                        <a class="shortcode_button btn_large btn_type1" target="_blank" href="#">Order Now</a>
                      </div>
                    <?php
                      // Header Cart End
                    }
                    ?>

        <?php echo '
                </div><!-- header_main_line -->
            </div><!-- head_block -->
        ';
    }

		echo '
				<div class="menu_mobile">
					<div class="container-fluid">
					    <div class="row">
        ';
                            wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false)));
          echo '
                        </div><!-- row -->
                    </div><!-- container-fluid -->
                </div><!-- menu_mobile -->
			</div></header>
      <header class="fixed_header">
        <div class="container">
          <div class="row head_block">
            <div class="header_main_line">
            </div>
          </div>
        </div>
      </header>
      <div class="empty_block"></div>';

		if (GT3_HEADER_TYPE == 4 || GT3_HEADER_TYPE == 6 || GT3_HEADER_TYPE == 10 || GT3_HEADER_TYPE == 12 || GT3_HEADER_TYPE == 15 || GT3_HEADER_TYPE == 20 || GT3_HEADER_TYPE == 22 || GT3_HEADER_TYPE == 25 || GT3_HEADER_TYPE == 28 || GT3_HEADER_TYPE == 30 || GT3_HEADER_TYPE == 32 || GT3_HEADER_TYPE == 34 || GT3_HEADER_TYPE == 40 || GT3_HEADER_TYPE == 42)
		{
			echo gt3_get_sidemenu();
		}
	}
}

if (!function_exists('gt3_get_footer'))
{
	function gt3_get_footer()
	{
    # Type 1




    if (GT3_FOOTER_TYPE == 15)	{
      $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
			echo '
				<footer class="gt3_footer_type_' . GT3_FOOTER_TYPE . '">';
                    if(is_plugin_active("instagram-feed/instagram-feed.php")) {
                        if (isset($gt3_theme_pagebuilder['settings']['show_instagram_area']) && $gt3_theme_pagebuilder['settings']['show_instagram_area'] != 'no') {
                            if (strlen(gt3_get_theme_option("footer_instagram_feed_shortcode")) > 0) {
                              echo '
                                <div class="instagram_cont">
                                  ' . do_shortcode(esc_attr(gt3_get_theme_option("footer_instagram_feed_shortcode"))) . '
                                </div>
                              ';
                            }
                        }
                    }

                    echo '
					<div class="container">
						<div class="row text_align_center">
							<div class="circle_socials">
								<ul>' . gt3_show_social_icons(array(     
                                  array(
                                  "uniqid" => "social_facebook",
                                  "class" => "facebook-square",
                                  "title" => "Facebook",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_pinterest",
                                  "class" => "pinterest",
                                  "title" => "Pinterest",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_gplus",
                                  "class" => "google-plus",
                                  "title" => "Google",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_dribbble",
                                  "class" => "dribbble",
                                  "title" => "Dribbble",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_twitter",
                                  "class" => "twitter",
                                  "title" => "Twitter",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_instagram",
                                  "class" => "instagram",
                                  "title" => "Instagram",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_youtube",
                                  "class" => "youtube-square",
                                  "title" => "Youtube",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_tumblr",
                                  "class" => "tumblr",
                                  "title" => "Tumblr",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_linked",
                                  "class" => "linkedin",
                                  "title" => "Linked In",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_vimeo",
                                  "class" => "vimeo",
                                  "title" => "Vimeo",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_delicious",
                                  "class" => "delicious",
                                  "title" => "Delicious",
                                  "target" => "_blank",
                                  ),
                                  array(
                                  "uniqid" => "social_flickr",
                                  "class" => "flickr",
                                  "title" => "Flickr",
                                  "target" => "_blank",
                                  )
                                  )) . '
                                </ul>
							</div>
							<div class="footer_manu">';
                                if (has_nav_menu('footer')) {
                                    wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer_menu', 'depth' => '1', 'walker' => new gt3_menu_walker($showtitles = false)));
                                }
                                echo '
							</div>
							<div class="footer_copyright_text">
								' . esc_html(gt3_get_theme_option("footer_line_1")) . '
							</div>
						</div>
					</div>
				</footer>
            ';
		}

	}
}

if (!function_exists('gt3_has_site_icon')) {
  function gt3_has_site_icon() {
    if (function_exists('has_site_icon') && has_site_icon()) {
      ?>
      <link rel="shortcut icon" href="<?php echo aq_resize(esc_url(get_site_icon_url()), "32", "32", true, true, true); ?>"
            type="image/x-icon">
      <link rel="apple-touch-icon" href="<?php echo aq_resize(esc_url(get_site_icon_url()), "57", "57", true, true, true); ?>">
      <link rel="apple-touch-icon" sizes="72x72"
            href="<?php echo aq_resize(esc_url(get_site_icon_url()), "72", "72", true, true, true); ?>">
      <link rel="apple-touch-icon" sizes="114x114"
            href="<?php echo aq_resize(esc_url(get_site_icon_url()), "114", "114", true, true, true); ?>">
    <?php
    } else {
      ?>
      <link rel="shortcut icon" href="<?php echo esc_url(gt3_get_theme_option('favicon')); ?>" type="image/x-icon">
      <link rel="apple-touch-icon" href="<?php echo esc_url(gt3_get_theme_option('apple_touch_57')); ?>">
      <link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url(gt3_get_theme_option('apple_touch_72')); ?>">
      <link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url(gt3_get_theme_option('apple_touch_114')); ?>">
    <?php
    }
  }
}

add_action('wp_head','gt3_wp_head');
function gt3_wp_head() {
  echo gt3_get_if_strlen(gt3_get_theme_option("custom_css"), "<style>", "</style>") . gt3_get_if_strlen(gt3_get_theme_option("code_before_head"));
		echo '  
  <script type="text/javascript">
    var gt3_ajaxurl = "' . admin_url('admin-ajax.php') . '";
  </script>
  ';
}

#WOOCOMMERCE
// Woocommerce Related Products (Redefine woocommerce_output_related_products())
function woocommerce_output_related_products()
{
  $args = array(
    'posts_per_page' => gt3_get_theme_option("woo_related_products"),
    'orderby' => 'date'
  );

  woocommerce_related_products($args);
}

// Woocommerce add to list categories
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_meta');

// Woocommerce products per page (9)
add_filter('loop_shop_per_page', create_function('$cols', 'return gt3_get_theme_option("woo_shop_items_per_page");'), 20);

// Woocommerce Header cart
function gt3_header_add_to_cart_fragment( $fragments ) {

  ob_start();

  ?><a class="gt3-cart-contents total_price" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart', 'pizzahit' ); ?>">
    <i class="fa fa-shopping-cart"></i>
    <?php echo WC()->cart->get_cart_total(); ?> <span class="gt3_header_cart_items">(<?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'pizzahit' ), WC()->cart->get_cart_contents_count() ); ?>)</span>
  </a><?php

  $fragments['a.gt3-cart-contents'] = ob_get_clean();

  return $fragments;
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  add_filter( 'woocommerce_add_to_cart_fragments', 'gt3_header_add_to_cart_fragment' );
}
// Woocommerce Header cart end

add_theme_support('woocommerce');

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_shop_loop', 'gt3_get_shop_pagination', 10);

function gt3_get_shop_pagination() {
	echo gt3_get_theme_pagination();
}

remove_action('woocommerce_before_main_content', 'woocommerce_show_page_title');

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'gt3_categories_in_shop_listing', 15);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 20);
function gt3_categories_in_shop_listing()
{
    global $post, $product;

    $cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );

    // $product->get_categories( ' / ', '<span class="posted_in"></span>' )
    // wc_get_product_category_list( $product->get_id(), ' / ', '<span class="posted_in"></span>', '' )

    //echo "<div class='product_category'>" . wc_get_product_category_list( $product->get_id(), ' / ', '<span class="posted_in"></span>', '' ) . "</div>";
}

remove_filter('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
add_action('gt3_archive_description', 'woocommerce_product_archive_description', 10);

add_filter('woocommerce_show_page_title', function (){return false;});

add_filter( 'woocommerce_get_catalog_ordering_args', 'gt3_custom_woocommerce_get_catalog_ordering_args' );
function gt3_custom_woocommerce_get_catalog_ordering_args($args)
{
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ('random_list' == $orderby_value) {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
    return $args;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'gt3_custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'gt3_custom_woocommerce_catalog_orderby' );
function gt3_custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['random_list'] = esc_html__('Sort by Date', 'pizzahit');
    return $sortby;
}

add_action( 'woocommerce_product_options_pricing', 'gt3_custom_product_field' );
function gt3_custom_product_field() {
    woocommerce_wp_text_input( array( 'id' => 'custom_field', 'class' => 'short', 'label' => esc_attr( 'Best offer', 'pizzahit' ) . '' ) );
    woocommerce_wp_text_input( array( 'id' => 'ingredients_field', 'class' => 'short', 'label' => esc_attr( 'Ingredients', 'pizzahit' ) . '' ) );
}

add_action( 'save_post', 'gt3_custom_field_save_product' );
function gt3_custom_field_save_product( $product_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( isset( $_POST['custom_field'] ) ) {
        update_post_meta( $product_id, 'custom_field', $_POST['custom_field'] );
    }
    if (isset( $_POST['ingredients_field'])) {
        update_post_meta( $product_id, 'ingredients_field', $_POST['ingredients_field'] );
    }
}

add_action( 'woocommerce_after_shop_loop_item_title', 'gt3_custom_field_show', 10);
function gt3_custom_field_show() {
    global $product;

    if ( $product->get_type() <> 'variable' ) {
        $custom_field = get_post_meta( $product->get_id(), 'custom_field', true );

        if (isset($custom_field) && $custom_field !== '') {
            echo '
                <div class="custom_field_cont">
                    <span>' . $custom_field . '</span>
                </div>
            ';
        }
    }
}

add_action( 'woocommerce_after_shop_loop_item_title', 'gt3_ingredients_field_show', 15);
function gt3_ingredients_field_show() {
    global $product;

    if ($product->get_type() <> 'variable') {
        $ingredients = get_post_meta( $product->get_id(), 'ingredients_field', true );

        if (isset($ingredients) && $ingredients !== '') {
            echo '
                <div class="ingredients_cont">
                    <span>' . $ingredients . '</span>
                </div>
            ';
        }
    }
}

remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// gt3_update_theme_option("demo_server", "true");

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

































