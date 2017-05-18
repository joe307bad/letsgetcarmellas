<?php

/*
Plugin Name: GT3 Photo & Video Gallery
Plugin URI: http://gt3themes.com/
Description: This powerful plugin lets you extend the functionality of the default WordPress gallery. You can easily customize the look and feel of the photo or video gallery.
Version: 1.6.1
Author: GT3 Themes
Author URI: http://gt3themes.com/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('GT3PG_PLUGINNAME', 'GT3 Photo & Video Gallery');
define('GT3PG_PLUGINSHORT', 'gt3_photo_gallery');
define('GT3PG_JSURL', plugins_url('js/', __FILE__));
define('GT3PG_IMGURL', plugins_url('img/', __FILE__));
define('GT3PG_CSSURL', plugins_url('css/', __FILE__));
define('GT3PG_PLUGINROOTURL', plugins_url('', __FILE__));
define('GT3PG_PLUGINPATH', plugin_dir_path(__FILE__));

/*Load files*/
require_once(GT3PG_PLUGINPATH . "core/loader.php");
register_activation_hook(  __FILE__, 'activationHook' );

#Load textdomain
add_action('plugins_loaded', 'gt3pg_locale');

function gt3pg_locale()
{
	load_plugin_textdomain('gt3pg', false, dirname(plugin_basename(__FILE__)) . '/core/languages/');
}

#Register Admin CSS and JS
function gt3pg_register_admin_css_js()
{
	#CSS (Admin)
	wp_enqueue_style('gt3pg_admin_css', GT3PG_CSSURL . 'admin.css');
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style('selectBox_css', GT3PG_CSSURL . 'jquery.selectBox.css');

	#JS (Admin)
	wp_enqueue_script("jquery");
	wp_enqueue_script('gt3pg_admin_js', GT3PG_JSURL . 'admin.js', array('jquery'));
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script('selectBox_js', GT3PG_JSURL . 'jquery.selectBox.js');
}
add_action('admin_init', 'gt3pg_register_admin_css_js');

function gt3pg_enqueue_media() {
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'gt3pg_enqueue_media' );

#Register Front CSS and JS
function gt3pg_register_front_css_js()
{

	#CSS (Front)
	wp_enqueue_style('gt3pg_css', GT3PG_CSSURL . 'gt3pg.css');

	#JS (Front)
	wp_enqueue_script("jquery");
	wp_enqueue_script('gt3pg_swipebox_js', GT3PG_JSURL . 'jquery.swipebox.js', array(), false, true);
	wp_enqueue_script('gt3pg_js', GT3PG_JSURL . 'gt3pg.js', array(), false, true);
	
}
add_action( 'wp_enqueue_scripts', 'gt3pg_register_front_css_js' );

function gt3pg_page_welcome_set_redirect() {
	set_transient( '_gt3pg_page_welcome_redirect', 1, 30 );
}

function activationHook() {
	do_action( 'gt3pg_activation_hook' );
}

function gt3pg_page_welcome_redirect() {
	$redirect = get_transient( '_gt3pg_page_welcome_redirect' );
	delete_transient( '_gt3pg_page_welcome_redirect' );
	$redirect && wp_redirect( admin_url( 'admin.php?page=' . GT3PG_PLUGINSHORT . '_options' ) );
}

// Enables redirect on activation.
add_action( 'gt3pg_activation_hook', 'gt3pg_page_welcome_set_redirect' );
add_action( 'admin_init', 'gt3pg_page_welcome_redirect' );

function gt3pg_add_admin_page()
{
	global $gt3_photo_gallery_defaults, $gt3_photo_gallery;

	$photo_gallery = gt3pg_get_option("photo_gallery");
	if ($photo_gallery == false) 
		gt3pg_update_option("photo_gallery", $gt3_photo_gallery_defaults); else
		$gt3_photo_gallery = $photo_gallery;

	unset($photo_gallery);

	add_menu_page('GT3 Gallery', 'GT3 Gallery', 'administrator', GT3PG_PLUGINSHORT . '_options', 'gt3pg_plugin_options', false, '210');
}
add_action('admin_menu', 'gt3pg_add_admin_page');

function gt3pg_plugin_options()
{
	global $gt3_photo_gallery_defaults, $gt3_photo_gallery;

	$photo_gallery = gt3pg_get_option("photo_gallery");
	if ($photo_gallery == false) 
		gt3pg_update_option("photo_gallery", $gt3_photo_gallery_defaults); else
		$gt3_photo_gallery = $photo_gallery;

	unset($photo_gallery);

	$plugin_info = get_plugin_data(__FILE__);
	$theme_list = (array) gt3_banner_addon ();

	$output= '
	<script>
     var gt3pg_admin_ajax_url = "' . admin_url("admin-ajax.php") . '";
  </script>
	<div class="gt3pg_admin_wrap">
	<div class="gt3pg_inner_wrap">
		<form action="" method="post" class="gt3pg_page_settings" >
			<div class="gt3pg_main_line">
				<div class="gt3pg_themename">
					'.str_replace('3', '<span class="digit">3</span>', GT3PG_PLUGINNAME . ' ' . __('Settings', 'gt3pg')).'
					<span class="gt3pg_theme_ver">'. __($plugin_info['Version'], 'gt3pg') .'</span>
				</div>
				<div class="gt3pg_links">
          <a href="http://gt3themes.com/contact/" target="_blank">Need Help?</a>
        </div>
        <div class="clear"></div>
			</div>
			<div class="gt3pg_admin_mix-container2">
				<div class="gt3pg_admin_mix-tabs type2">
					<div class="gt3pg_admin_mix-tabs-inner">
						<div class="gt3pg_admin_head_caption">
					    <div class="gt3pg_innerpadding with_text">
					      This plugin lets you extend the functionality of the default WordPress gallery. To make the changes, please use the settings below. Once you\'ve chosen the right parameters, please click <strong>"Save Settings"</strong> button.
					    </div>
						</div>
						<div class="gt3pg_admin_head_buttons">
					    <div class="gt3pg_innerpadding">
				        <div class="gt3pg_theme_settings_submit_cont">
				          <input type="button" name="gt3pg_reset_theme_settings" class="gt3pg_admin_reset_settings gt3pg_admin_button gt3pg_admin_danger_btn" value="Reset Settings" />
				          <input type="submit" name="gt3pg_submit_theme_settings" class="gt3pg_admin_save_all gt3pg_admin_button gt3pg_admin_ok_btn" value="Save Settings" />
				        </div>
					    </div>
						</div>
						<div class="clear"></div>
						<div class="gt3pg_admin_mix-tab-content">
							<div class="gt3pg_admin_mix-tab-controls">
								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting ">
											<h2 class="gt3pg_option_heading">' . __("Link Image To", "gt3pg") . '</h2>
											<p>' . __("You may use this option to choose where to link your image to.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
												<select class="link-to" name="gt3pg_link_to">
													<option value="post" ' . ((isset($gt3_photo_gallery['gt3pg_link_to']) && $gt3_photo_gallery['gt3pg_link_to'] == "post") ? 'selected="selected"' : '') . '>' . __("Attachment Page", "gt3pg") .'
													</option>
													<option value="file" ' . ((isset($gt3_photo_gallery['gt3pg_link_to']) && $gt3_photo_gallery['gt3pg_link_to'] == "file") ? 'selected="selected"' : '') . '>' . __("Lightbox", "gt3pg") .'
													</option>
													<option value="none" ' . ((isset($gt3_photo_gallery['gt3pg_link_to']) && $gt3_photo_gallery['gt3pg_link_to'] == "none") ? 'selected="selected"' : '') . '>' . __("None", "gt3pg").'
													</option>
												</select>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .  __("Image Size", "gt3pg") . '</h2>
											<p>' .  __('Please select the proper image size to display in the content.', 'gt3pg') . '</p>
											<div class="gt3pg_admin_input">
							        <select class="size" name="gt3pg_size">';

							  $size_names = apply_filters( "image_size_names_choose", array("thumbnail" => __( "Thumbnail", "gt3pg" ), "medium" => __( "Medium", "gt3pg" ), "large" => __( "Large", "gt3pg" ), "full" => __( "Full Size", "gt3pg" ),) );
							  foreach ( $size_names as $size => $label ) {
							  	$output.= '<option value="' . $size . '"' . ((isset($gt3_photo_gallery['gt3pg_size']) && $gt3_photo_gallery['gt3pg_size'] == $size) ? 'selected="selected"' : '') . '>' . __( $label, "gt3pg" ) . '
							    </option>';
							  }
							        $output.= '</select>
							        </div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .  __("Columns", "gt3pg") . '</h2>
											<p>' .  __("You have an option to display from one up to nine image columns.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<select class="columns" name="gt3pg_columns">';
								for ( $i = 1; $i <= 9; $i++ ) {
									$output.= '<option value="' . $i . '"' . ((isset($gt3_photo_gallery['gt3pg_columns']) && $gt3_photo_gallery['gt3pg_columns'] == $i) ? 'selected="selected"' : '') . '>' . __( $i, "gt3pg" ) . '
							    </option>';
								}
											$output.= '</select>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .  __("Random Order", "gt3pg") . '</h2>
											<p>' .  __("Display the images by default or randomly.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<select class="gt3pg_rand_order" name="gt3pg_rand_order">
												<option value="on" ' . ((isset($gt3_photo_gallery['gt3pg_rand_order']) && $gt3_photo_gallery['gt3pg_rand_order'] == "on") ? 'selected="selected"' : '') . '>' . __("On", "gt3pg") .'
												</option>
												<option value="off" ' . ((isset($gt3_photo_gallery['gt3pg_rand_order']) && $gt3_photo_gallery['gt3pg_rand_order'] == "off") ? 'selected="selected"' : '') . '>' . __("Off", "gt3pg") .'
												</option>
											</select>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .  __("Margin, px", "gt3pg") . '</h2>
											<p>' .  __("You can add margins to the images. Please note that they are in pixels.", "gt3pg") . '</p>
											<div class="admin_input">
											<input class="short-input" name="gt3pg_margin"  type="text" ' . ((isset($gt3_photo_gallery['gt3pg_margin'])) ? 'value='. $gt3_photo_gallery['gt3pg_margin'] : '') . ' />
										</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .  __("Thumbnail Type", "gt3pg") . '</h2>
											<p>' .  __("You can select different types to display images thumbnails.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<select class="thumbnail-type" name="gt3pg_thumbnail_type">
												<option value="square" ' . ((isset($gt3_photo_gallery['gt3pg_thumbnail_type']) && $gt3_photo_gallery['gt3pg_thumbnail_type'] == "square") ? 'selected="selected"' : '') . '>' . __("Square", "gt3pg") .'
												</option>
												<option value="rectangle" ' . ((isset($gt3_photo_gallery['gt3pg_thumbnail_type']) && $gt3_photo_gallery['gt3pg_thumbnail_type'] == "rectangle") ? 'selected="selected"' : '') . '>' . __("Rectangle", "gt3pg") .'
												</option>
												<option value="circle" ' . ((isset($gt3_photo_gallery['gt3pg_thumbnail_type']) && $gt3_photo_gallery['gt3pg_thumbnail_type'] == "circle") ? 'selected="selected"' : '') . '>' . __("Circle", "gt3pg") .'
												</option>
												<option value="masonry" ' . ((isset($gt3_photo_gallery['gt3pg_thumbnail_type']) && $gt3_photo_gallery['gt3pg_thumbnail_type'] == "masonry") ? 'selected="selected"' : '') . '>' . __("Masonry", "gt3pg") .'
												</option>
											</select>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .   __("Corners Type", "gt3pg") . '</h2>
											<p>' .  __("You can choose either right angle or rounded individually.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<select class="thumbnail-type" name="gt3pg_corner_type">
												<option value="standard" ' . ((isset($gt3_photo_gallery['gt3pg_corner_type']) && $gt3_photo_gallery['gt3pg_corner_type'] == "standard") ? 'selected="selected"' : '') . '>' . __("Standard", "gt3pg") .'
												</option>
												<option value="rounded" ' . ((isset($gt3_photo_gallery['gt3pg_corner_type']) && $gt3_photo_gallery['gt3pg_corner_type'] == "rounded") ? 'selected="selected"' : '') . '>' . __("Rounded", "gt3pg") .'
												</option>
											</select>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .   __("Image Border", "gt3pg") . '</h2>
											<p>' .  __("You can either display or hide the image border.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<select class="gt3pg-border-type" name="gt3pg_border">
												<option value="on" ' . ((isset($gt3_photo_gallery['gt3pg_border']) && $gt3_photo_gallery['gt3pg_border'] == "on") ? 'selected="selected"' : '') . '>' . __("On", "gt3pg") .'
												</option>
												<option value="off" ' . ((isset($gt3_photo_gallery['gt3pg_border']) && $gt3_photo_gallery['gt3pg_border'] == "off") ? 'selected="selected"' : '') . '>' . __("Off", "gt3pg") .'
												</option>
											</select>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting border-setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' .   __("Border Size, px", "gt3pg") . '</h2>
											<p>' .  __("Add border size to the image in pixels.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<input class="short-input" name="gt3pg_border_size"  type="text" ' . ((isset($gt3_photo_gallery['gt3pg_border_size'])) ? 'value='. $gt3_photo_gallery['gt3pg_border_size'] : '') . ' />
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting border-setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' . __("Border Padding, px", "gt3pg") . '</h2>
											<p>' .  __("Add border padding to the image in pixels.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<input class="short-input" name="gt3pg_border_padding"  type="text" ' . ((isset($gt3_photo_gallery['gt3pg_border_padding'])) ? 'value='. $gt3_photo_gallery['gt3pg_border_padding'] : '') . ' />
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting border-setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' . __("Border Color, px", "gt3pg") . '</h2>
											<p>' .  __("Select the desired border color.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input">
											<input name="gt3pg_color_picker"  type="text" ' . ((isset($gt3_photo_gallery['gt3pg_border_col'])) ? 'value='. $gt3_photo_gallery['gt3pg_border_col'] : '') . ' />
											<input type="text" class="hidden" name="gt3pg_border_col" data-setting="border_col"/>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control">
									<div class="gt3pg_innerpadding">
										<label class="gt3pg_setting">
											<h2 class="gt3pg_option_heading">' . __("Custom CSS", "gt3pg") . '</h2>
											<p>' .  __("You can add custom CSS to the gallery.", "gt3pg") . '</p>
											<div class="gt3pg_admin_input nofloat">
											<textarea name="gt3pg_text_before_head" ' . ((isset($gt3_photo_gallery['gt3pg_text_before_head'])) ? 'value=' . $gt3_photo_gallery['gt3pg_text_before_head'] : '') . ' ></textarea>
											</div>
										</label>
									</div>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control gt3pg_video_tutorial_cont">
									<h2 class="gt3pg_option_heading">How to Use Gallery. Video Tutorial.</h2>
									<p>Please watch this short video tutorial to see how to use our GT3 photo & video gallery.</p>
									<iframe width="100%" height="350" src="https://www.youtube.com/embed/eIUfmr91D8g" frameborder="0" allowfullscreen></iframe>
								</div>

								<div class="gt3pg_stand_setting gt3pg_admin_mix-tab-control gt3pg_video_tutorial_cont">
									<h2 class="gt3pg_option_heading">Premium Photography WordPress Themes</h2>
									<p>Check out our professionally developed Photo and Video WordPress themes. Easy way to build your awesome website.</p>
									<div class="gt3pg-banner_items-wrapper">';

									foreach ($theme_list as $theme_item) {
										$output .= '<div class="gt3pg-banner_item-wrapper"><a href="'.$theme_item["item_url"].'" class="gt3pg-banner_item_link" target="_blank"><span>View Demo</span><img class="gt3pg-banner-image" src="'.$theme_item["image_url"].'" alt="gt3themes"></a></div>';
									}

									$output .= '</div>
								</div>


								<div class="clear"></div>
								<div class="gt3pg_theme_settings_submit_cont albotoom">
									<div class="gt3pg_theme_settings_submit_cont">
									  <input type="button" name="gt3pg_reset_theme_settings" class="gt3pg_admin_reset_settings gt3pg_admin_button gt3pg_admin_danger_btn" value="Reset Settings" />
									  <input type="submit" name="gt3pg_submit_theme_settings" class="gt3pg_admin_save_all gt3pg_admin_button gt3pg_admin_ok_btn" value="Save Settings" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

	</form>
	</div>
	</div>';

	echo $output;

}

#Work with options
if (!function_exists('gt3pg_get_option'))
{
	function gt3pg_get_option($optionname, $defaultValue = "")
	{
		$returnedValue = get_option("gt3pg_" . $optionname, $defaultValue);

		if (gettype($returnedValue) == "string")
		{
			return stripslashes($returnedValue);
		} else
		{
			return $returnedValue;
		}
	}
}

if (!function_exists('gt3pg_delete_option'))
{
	function gt3pg_delete_option($optionname)
	{
		return delete_option("gt3pg_" . $optionname);
	}
}

if (!function_exists('gt3pg_update_option'))
{
	function gt3pg_update_option($optionname, $optionvalue)
	{
		if (update_option("gt3pg_" . $optionname, $optionvalue))
		{
			return true;
		}
	}
}

if (!function_exists('gt3_banner_addon'))
{
	function gt3_banner_addon () {

		$url = 'https://s3.amazonaws.com/gt3themes/api/items/photo-plugin.json';
		$json = wp_remote_request($url);

		if (!is_wp_error($json)) {
	        $json = wp_remote_retrieve_body($json);
	        $json = json_decode($json, true);

	        if (!empty($json) && !empty($json['items'])) {
	            return $json['items'];
	        }
	    }

		return array();
	}
}

