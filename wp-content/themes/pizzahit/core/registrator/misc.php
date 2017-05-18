<?php
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('post', 'page', 'team', 'testimonials', 'gallery', 'product'));
    add_theme_support('automatic-feed-links');

    add_theme_support('post-formats', array('image', 'video', 'gallery'));
}

function gt3_adjust_post_formats() {
    if (isset($_GET['post'])) {
        $post = get_post($_GET['post']);
        if ($post)
            $post_type = $post->post_type;
    } elseif (!isset($_GET['post_type']))
        $post_type = 'post';
    elseif (in_array($_GET['post_type'], get_post_types(array('show_ui' => true ))))
        $post_type = $_GET['post_type'];
    else
        return;

    if ('post' == $post_type)
        add_theme_support('post-formats', array('image', 'video'));
}
add_action('load-post.php','gt3_adjust_post_formats');

#Support menus
add_action('init', 'register_my_menus');
function register_my_menus() {
	register_nav_menus(
		array(
		'main_menu' => 'Main menu',
        'footer' => 'Footer Menu'
		)
	);
}

#ADD localization folder
add_action('init', 'enable_pomo_translation');
function enable_pomo_translation(){
    load_theme_textdomain( 'pizzahit', get_template_directory() . '/core/languages/' );
}

add_action('admin_head', 'reg_font_js');
function reg_font_js() {
    global $gt3_themeconfig;
    ?>
    <script type="text/javascript" >
        <?php
            $compile = array();
            echo "var fontsarray = '';";
        ?>
    </script>
<?php
}

add_action( 'add_meta_boxes', 'side_sidebar_settings_meta_box' );
function side_sidebar_settings_meta_box()
{
    $types = array( 'post', 'page', 'product' );

    foreach( $types as $type ) {
        add_meta_box(
            'side_sidebar_settings_meta_box', // id, used as the html id att
            esc_html__( 'Custom Sidebars', 'pizzahit' ), // meta box title, like "Page Attributes"
            'side_sidebar_settings_meta_box_cb', // callback function, spits out the content
            $type, // post type or page. We'll add this to pages only
            'side', // context (where on the screen
            'low' // priority, where should this go in the context?
        );
    }
}

function side_sidebar_settings_meta_box_cb( $post )
{
    $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder($post->ID, array("not_prepare_sidebars" => "true"));
    $available_sidebars = array("default" => "Default", "no-sidebar" => "None", "left-sidebar" => "Left", "right-sidebar" => "Right");

    echo '<div class="select_sidebar_layout sidebar_option">Sidebar Layout:<br><select name="pagebuilder[settings][layout-sidebars]" class="sidebar_layout admin_newselect">';
    foreach ($available_sidebars as $sidebar_id => $sidebar_caption) {
        echo "<option ".((isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && $gt3_theme_pagebuilder['settings']['layout-sidebars'] == $sidebar_id) ? 'selected="selected"' : '')." value='$sidebar_id'>$sidebar_caption</option>";
    }
    echo '</select></div>';

    $all_available_sidebars = array("Default");
    $theme_sidebars = gt3_get_theme_option("theme_sidebars");
    if (!is_array($theme_sidebars)) {
        $theme_sidebars = array();
    }

    $i = 1;
    foreach ($theme_sidebars as $theme_sidebar) {
        $all_available_sidebars[$i] = $theme_sidebar;
        $i++;
    }

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active('woocommerce/woocommerce.php')) {
        $all_available_sidebars[$i] = "WooCommerce";
        $i++;
    }

    echo '<div class="select_sidebar sidebar_option '.(gt3_get_theme_option("default_sidebar_layout") == "no-sidebar" ? "sidebar_none" : "").'">Select sidebar:<br><select name="pagebuilder[settings][selected-sidebar-name]" class="sidebar_name admin_newselect">';
    foreach ($all_available_sidebars as $sidebar_id => $sidebar_caption) {
        echo "<option ".((isset($gt3_theme_pagebuilder['settings']['selected-sidebar-name']) && $gt3_theme_pagebuilder['settings']['selected-sidebar-name'] == $sidebar_caption) ? 'selected="selected"' : '')." value='$sidebar_caption'>$sidebar_caption</option>";
    }
    echo '</select></div>';
}


#Work with Custom background
add_action( 'add_meta_boxes', 'side_bg_settings_meta_box' );
function side_bg_settings_meta_box()
{
    $types = array( 'post', 'page', 'gallery' );

    foreach( $types as $type ) {
        add_meta_box(
            'side_bg_settings_meta_box', // id, used as the html id att
            esc_html__( 'Custom Layout', 'pizzahit' ), // meta box title, like "Page Attributes"
            'side_bg_settings_meta_box_cb', // callback function, spits out the content
            $type, // post type or page. We'll add this to pages only
            'side', // context (where on the screen
            'low' // priority, where should this go in the context?
        );
    }
}

function side_bg_settings_meta_box_cb( $post )
{
  $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder($post->ID);

	if ($post->post_type == 'gallery'){

		//gallery_options-slider
		echo "		
		<script>
			var def_gal_style = '". gt3_get_theme_option('default_gallery_style') ."';
			jQuery(document).ready(function(){";
				if (isset($gt3_theme_pagebuilder['settings']['gallery_style'])) {
					$selectedGallery = $gt3_theme_pagebuilder['settings']['gallery_style'];
				} else {
					$selectedGallery = 'default';
				}

				if ($selectedGallery == 'fw-gallery-post' || ($selectedGallery == 'default' && gt3_get_theme_option('default_gallery_style') == 'fw-gallery-post')) {
					echo "jQuery('.gallery_options-slider').show();";
					echo "jQuery('#postdivrich').show();";
					
				} else {
					echo "jQuery('.gallery_options-slider').hide();";
					echo "jQuery('#postdivrich').hide();";
				}
		echo "
				jQuery('.pf_style_select').change(function(){
					if (jQuery(this).val() == 'fw-gallery-post' || (jQuery(this).val() == 'default' && def_gal_style == 'fw-gallery-post')) {
						jQuery('.gallery_options-slider').slideDown(300);
						jQuery('#postdivrich').show();
					} else {
						jQuery('.gallery_options-slider').slideUp(300);
						jQuery('#postdivrich').hide();
					}
				});
			});
		</script>
		";		
	}
			
  echo '<div class="custom_select_bcarea title_bcarea layout_bcarea">';

	if ( get_page_template_slug() !== "page-landing1.php" && get_page_template_slug() !== "page-countdown.php") {
		echo '<span class="htitle">Title:</span><select name="pagebuilder[settings][show_title]" class="admin_newselect">';
		$available_variants = array("yes" => "Show", "no" => "Hide");
		foreach ($available_variants as $var_id => $var_caption) {
			echo "<option ".((isset($gt3_theme_pagebuilder['settings']['show_title']) && $gt3_theme_pagebuilder['settings']['show_title'] == $var_id) ? 'selected="selected"' : '')." value='$var_id'>$var_caption</option>";
		}
		echo '</select>';
	}
	echo '</div>
	<div class="clear"></div>';
	if ( get_page_template_slug() !== "page-landing1.php" && get_page_template_slug() !== "page-countdown.php") {
		echo '<div class="custom_select_bcarea">';	
		echo '<span class="htitle">Instagram Shortcode:</span><select name="pagebuilder[settings][show_instagram_area]" class="admin_newselect">';
		$available_variants = array("yes" => "Show", "no" => "Hide");
		foreach ($available_variants as $var_id => $var_caption) {
			echo "<option ".((isset($gt3_theme_pagebuilder['settings']['show_instagram_area']) && $gt3_theme_pagebuilder['settings']['show_instagram_area'] == $var_id) ? 'selected="selected"' : '')." value='$var_id'>$var_caption</option>";
		}
		echo '</select>';
	}
	
		echo '</div>
		<div class="clear"></div>';

}


if (!defined("GT3PBVERSION")) {

    function gt3_update_theme_pagebuilder_without_plugin($post_id, $variableName, $gt3_theme_pagebuilderArray)
    {
        update_post_meta($post_id, $variableName, $gt3_theme_pagebuilderArray);
        return true;
    }

    add_action('save_post', 'save_postdata_in_theme');
    function save_postdata_in_theme($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return;}

        #CHECK PERMISSIONS
        if (!current_user_can('edit_post', $post_id)) {return;}

        #START SAVING
        if (!isset($_POST['pagebuilder'])) {
            $pbsavedata = array();
        } else {
            $pbsavedata = $_POST['pagebuilder'];
            gt3_update_theme_pagebuilder_without_plugin($post_id, "pagebuilder", $pbsavedata);
        }
    }
}

#Only demo stuff
 // gt3_update_theme_option("demo_server", "true");
#gt3_delete_theme_option("demo_server");