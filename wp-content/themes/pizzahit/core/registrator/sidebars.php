<?php

$all_sidebars = gt3_get_theme_sidebars_for_admin();

if (function_exists('register_sidebar'))
{

	#default values
	$register_sidebar_attr = array(
		'description' => esc_html__('Add the widgets appearance for Custom Sidebar. Drag the widget from the available list on the left, configure widgets options and click Save button. Select the sidebar on the posts or pages in just few clicks.', 'pizzahit'),
		'before_widget' => '<div class="sidepanel %2$s">',
		'after_widget' => '<div class="clear"></div></div>',
		'before_title' => '<h6 class="sidebar_header">',
		'after_title' => '</h6>'
	);

    #REGISTER DEFAULT SIDEBARS
    $register_sidebar_attr['name'] = "Default";
    $register_sidebar_attr['id'] = 'page-sidebar-1';
    register_sidebar($register_sidebar_attr);

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active('woocommerce/woocommerce.php')) {
        $register_sidebar_attr['name'] = "WooCommerce";
        $register_sidebar_attr['id'] = 'page-sidebar-99';
        register_sidebar($register_sidebar_attr);
    }

	$sidebar_id = 100;
	if (is_array($all_sidebars))
	{
		foreach ($all_sidebars as $sidebarName)
		{
			$register_sidebar_attr['name'] = $sidebarName;
			$register_sidebar_attr['id'] = 'page-sidebar-' . $sidebar_id++ ;
			register_sidebar($register_sidebar_attr);
			$sidebar_id++;
		}
	}

	if (GT3_HEADER_TYPE == 4 || GT3_HEADER_TYPE == 6 || GT3_HEADER_TYPE == 10 || GT3_HEADER_TYPE == 12 || GT3_HEADER_TYPE == 15 || GT3_HEADER_TYPE == 20 || GT3_HEADER_TYPE == 22 || GT3_HEADER_TYPE == 25 || GT3_HEADER_TYPE == 28 || GT3_HEADER_TYPE == 30 || GT3_HEADER_TYPE == 32 || GT3_HEADER_TYPE == 34 || GT3_HEADER_TYPE == 40 || GT3_HEADER_TYPE == 42)
	{	
	#REGISTER DEFAULT SIDEBARS
	$register_sidebar_attr['name'] = "Side Menu";
	$register_sidebar_attr['id'] = 'page-sidemenu-1';
	register_sidebar($register_sidebar_attr);
	}

	if (GT3_FOOTER_TYPE == 1 || GT3_FOOTER_TYPE == 2 || GT3_FOOTER_TYPE == 4 || GT3_FOOTER_TYPE == 5 || GT3_FOOTER_TYPE == 10 || GT3_FOOTER_TYPE == 13 || GT3_FOOTER_TYPE == 14)
	{
	}
}