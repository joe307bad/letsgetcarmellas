<?php

#Frontend
if (!function_exists('css_js_register')) {
    function css_js_register()
    {
        $wp_upload_dir = wp_upload_dir();

        #CSS
        wp_enqueue_style('gt3_default_style', get_bloginfo('stylesheet_url'));
        wp_enqueue_style("bootstrap", get_template_directory_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style("gt3_base", get_template_directory_uri() . '/css/base.css');
        wp_enqueue_style("font_awesome", get_template_directory_uri() . '/css/font-awesome.min.css');
        wp_enqueue_style("gt3_theme", get_template_directory_uri() . '/css/theme.css');
        wp_enqueue_style("gt3_custom", add_query_arg('gt3_show_only_css', '1', esc_url(home_url('/'))));

        #JS
        wp_enqueue_script('gt3_base_js', get_template_directory_uri() . '/js/base.js', array(), false, true);
        wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, true);
        wp_enqueue_script('gt3_theme_js', get_template_directory_uri() . '/js/theme.js', array('jquery'), false, true);
        wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), false, true);
        wp_enqueue_script('selectBox_js', get_template_directory_uri() . '/core/admin/js/jquery.selectBox.js');
    }
}
add_action('wp_enqueue_scripts', 'css_js_register');

#Admin
add_action('admin_enqueue_scripts', 'admin_css_js_register');
function admin_css_js_register()
{
    #CSS (MAIN)
    wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/core/admin/css/jquery-ui.css');
    wp_enqueue_style('gallery_css', get_template_directory_uri() . '/core/admin/css/gallery.css');
    wp_enqueue_style('colorbox', get_template_directory_uri() . '/core/admin/css/colorbox.css');
    wp_enqueue_style('selectBox', get_template_directory_uri() . '/core/admin/css/jquery.selectBox.css');
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/core/admin/css/admin.css');
    wp_enqueue_style( 'wp-color-picker' );
    #CSS OTHER

    #JS (MAIN)
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script('admin_js', get_template_directory_uri() . '/core/admin/js/admin.js');
    wp_enqueue_script('ajaxupload_js', get_template_directory_uri() . '/core/admin/js/ajaxupload.js');
    wp_enqueue_script('selectBox', get_template_directory_uri() . '/core/admin/js/jquery.selectBox.js');
    wp_enqueue_script(array("jquery-ui-core", "jquery-ui-dialog", "jquery-ui-sortable"));
    wp_enqueue_media();
}

#Custom CSS and JS
add_filter('query_vars', 'gt3_register_custom_query_vars');
function gt3_register_custom_query_vars($vars)
{
    $vars[] = 'gt3_show_only_css';
    $vars[] = 'gt3_show_only_js';
    return $vars;
}

add_action('template_redirect', 'gt3_trigger_check');
function gt3_trigger_check()
{
    #Show CSS
    if (intval(get_query_var('gt3_show_only_css')) == 1) {
    header("Content-type: text/css");

echo '
    body {
        font-family:' . esc_attr(gt3_get_theme_option("main_font")) . ', sans-serif;
        font-size: ' . esc_attr(gt3_get_theme_option("main_content_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("main_content_line_height")) . ';
        font-weight:' . esc_attr(gt3_get_theme_option("content_weight")) . ';
        color:' . esc_attr(gt3_get_theme_option("content_color")) . ';
    }
    
    /* Header */
    header {
        background-color: ' . esc_attr(gt3_get_theme_option("header_bg_color")) . '!important;
        color: ' . esc_attr(gt3_get_theme_option("header_color")) . ';
    }
    header .right_block p {
        line-height: ' . esc_attr(gt3_get_theme_option("main_content_line_height")) . ';
    }
    header .menu a,
    .menu_mobile .menu > li a,
    header .menu_mobile .menu li .sub-menu li a,
    header .menu_mobile .menu li .sub-menu li:before,
    .one-half-header > span,
    .header_cart_content a {
        font-family: ' . esc_attr(gt3_get_theme_option("main_menu_font")) . ';
        font-size: ' . esc_attr(gt3_get_theme_option("menu_font_size")) . ';
        font-weight: ' . esc_attr(gt3_get_theme_option("menu_weight")) . ';
        color: ' . esc_attr(gt3_get_theme_option("menu_color")) . ';
    }

    header .menu li:hover > a {
        color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    header .menu li a:before,
    header .total_price i,
    .shortcode_accordion_item_title.state-active {
        background: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    .shortcode_accordion_item_title.state-active {
       border-color: ' . esc_attr(gt3_get_theme_option("theme_color")) . '; 
    }

    header .menu li .sub-menu,
    .header_cart_content .cart_submenu p.empty {
        background: ' . esc_attr(gt3_get_theme_option("submenu_bg")) . ';
    }

    header .menu li .sub-menu li a,
    header .menu li .sub-menu li .sub-menu li:hover a,
    header .menu li .sub-menu li.current-menu-ancestor .sub-menu li a,
    header .sub-menu li.menu-item-has-children:before {
        font-size: ' . esc_attr(gt3_get_theme_option("submenu_font_size")) . '!important;
        color: ' . esc_attr(gt3_get_theme_option("submenu_color")) . ';
    }

    @media (max-width: 991px) {
        header .menu li .sub-menu li a,
        header .menu li .sub-menu li .sub-menu li:hover a,
        header .menu li .sub-menu li.current-menu-ancestor .sub-menu li a,
        header .sub-menu li.menu-item-has-children:before {
            color: ' . esc_attr(gt3_get_theme_option("menu_color")) . ';
        }

        header .menu li .sub-menu li.current-menu-ancestor::before {
            color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
        }
    }

    header .menu li .sub-menu li:hover > a,
    header .menu li .sub-menu li.current-menu-item a,
    header .menu li .sub-menu li .sub-menu li:hover > a,
    header .menu li .sub-menu li .sub-menu li.current-menu-item a,
    header .menu li .sub-menu li.current-menu-ancestor a,
    header .menu li.current-menu-item a,
    .footer_menu li:hover a,
    a.cart_contents:hover,
    header .sub-menu li.menu-item-has-children:hover:before,
    header .menu_mobile .sub-menu li.menu-item-has-children:hover:before,
    header .menu li.current-menu-ancestor a,
    header .menu li.current-menu-ancestor:before {
        color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }
    header .right_block {
        color: ' . esc_attr(gt3_get_theme_option("header_color")) . ';
        font-size: ' . esc_attr(gt3_get_theme_option("menu_font_size")) . ';
    }
    header .sub-menu:before,
    .dish_counter {
        background: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }
    .toggle-inner, 
    .toggle-inner::before, 
    .toggle-inner::after {
        background-color: ' . esc_attr(gt3_get_theme_option("menu_color")) . ';
    }
    /* Footer */
    footer {
        background: ' . esc_attr(gt3_get_theme_option("footer_bg_color")) . ';
        color: ' . esc_attr(gt3_get_theme_option("footer_color")) . ';
    }

    .footer_manu ul li a,
    footer .circle_socials ul li a {
        color: ' . esc_attr(gt3_get_theme_option("footer_color")) . ';
    }
    footer .circle_socials ul li a {
        border-color: rgba(' . gt3_HexToRGB(substr(gt3_get_theme_option("footer_color"),1)) . ', .5);
    }
    .footer_manu ul li a:before {
        background: ' . esc_attr(gt3_get_theme_option("footer_color")) . ';
    }
    .footer_copyright_text {
        color:' . esc_attr(gt3_get_theme_option("content_color")) . ';
        font-size: ' . esc_attr(gt3_get_theme_option("main_content_font_size")) . ';
    }
    .module_dishes .text h6 {
        color:' . esc_attr(gt3_get_theme_option("content_color")) . ';
        font-family:' . esc_attr(gt3_get_theme_option("main_font")) . ', sans-serif;
    }
    .sidepanel li a,
    .sidepanel li a.rsswidget:hover,
    .featured_items_meta span,
    .widget_archive li::after, 
    .widget_categories li::after, 
    .widget_pages li::after, 
    .widget_recent_entries li::after,
    .sidepanel,
    .widget_calendar .calendar_wrap table tfoot a,
    .sidepanel.widget_calendar td a:hover,
    .post-meta, .post-meta a,
    .pagerblock li a,
    .contactform7_type .module_content input {
       color:' . esc_attr(gt3_get_theme_option("content_color")) . ';
    }
    .sidepanel li a:hover,
    .sidepanel li:hover:after,
    .sidepanel.widget_recent_entries li:hover > a,
    .sidepanel.widget_categories li:hover > a,
    .sidepanel.widget_archive li:hover > a,
    .sidepanel.widget_pages li:hover > a,
    li a.rsswidget,
    .widget_calendar .calendar_wrap table tfoot a:hover,
    .sidepanel.widget_calendar td a,
    .widget_meta li:hover a,
    .widget_nav_menu li:hover > a,
    a.shortcode_button.btn_type5:hover,
    .post-meta a:hover,
    .pagerblock li a.current,
    blockquote p cite,
    .shortcode_iconbox a:hover h5,
    .woocommerce .woocommerce-message::before {
       color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }
    input[type="submit"]:hover,
    .input-row input[type="submit"]:hover,
    .protected-post-form input[type="submit"]:hover,
    .search_form input[type="submit"]:hover,
    a.btn_type1:hover,
    a.btn_type4:hover,
    a.btn_type2,
    a.btn_type3:hover {
        background-color: ' . esc_attr(gt3_get_theme_option("hover_color")) . ';
        border-color:  ' . esc_attr(gt3_get_theme_option("hover_color")) . '!important;
    }
    a.btn_type2:hover {
        border-color:  ' . esc_attr(gt3_get_theme_option("hover_color")) . ';
    }
    .dish_link,
    .contactform7_type #mc_signup_submit {
        background-color: ' . esc_attr(gt3_get_theme_option("arrow_button_color")) . ';
    }
    .woocommerce .woocommerce-message {
        border-top-color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }
    #today,
    .tagcloud a:hover,
    .shortcode_button.btn_type1,
    .shortcode_button.btn_type4,
    a.shortcode_button.btn_type2:hover,
    .iconbox_wrapper span,
    input[type="submit"],
    .contactform7_type .module_content {
        background-color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }
    .shortcode_button.btn_type1,
    .shortcode_button.btn_type4 {
        border-color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }
    ul.slick-dots li.slick-active button,
    ul.slick-dots li:hover button,
    .pagerblock li a:hover {
        background-color: ' . esc_attr(gt3_get_theme_option("hover_color")) . '!important;
    }
    .dish_link:hover,
    .contactform7_type #mc_signup_submit:hover {
        background-color: ' . esc_attr(gt3_get_theme_option("arrow_button_hover_color")) . '!important;
    }
    .chart.easyPieChart span,
    .shortcode_button.btn_type5 {
        color: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }
    .widget_posts .post_title,
    .widget_tag_cloud a,
    .adblock_slogan,
    .sidepanel h6 {
        font-family: ' . esc_attr(gt3_get_theme_option("text_headers_font")) . ';
        color: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }
    .dropcap,
    .single-post .tag_share a,
    .header_cart_content .cart_submenu ul.product_posts li a.title,
    .woocommerce ul.products li.product .price,
    .woocommerce-page ul.product_list_widget li a,
    .widget_product_tag_cloud .tagcloud a,
    .single-product .product .summary .price,
    .single-product .product .summary .price ins {
        font-family: ' . esc_attr(gt3_get_theme_option("text_headers_font")) . ';
    }
    .slick_testim_info:after {
        color: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }
    ::selection {
      background:' . esc_attr(gt3_get_theme_option("theme_color")) . ';
      color: #fff;
    }
    ::-moz-selection {
      background:' . esc_attr(gt3_get_theme_option("theme_color")) . ';
      color: #fff;
    }

    /* Typography */
    h1, h2, h3, h4, h5, h6,
    h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
    h1 a:focus, h2 a:focus, h3 a:focus, h4 a:focus, h5 a:focus, h6 a:focus {
        font-family: ' . esc_attr(gt3_get_theme_option("text_headers_font")) . ';
        font-weight: ' . esc_attr(gt3_get_theme_option("headers_weight")) . ';
        color: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }

    h1, h1 a {
        font-size: ' . esc_attr(gt3_get_theme_option("h1_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("h1_line_height")) . ';
    }

    h2, h2 a {
        font-size: ' . esc_attr(gt3_get_theme_option("h2_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("h2_line_height")) . ';
    }

    h3, h3 a {
        font-size: ' . esc_attr(gt3_get_theme_option("h3_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("h3_line_height")) . ';
    }

    h4, h4 a {
        font-size: ' . esc_attr(gt3_get_theme_option("h4_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("h4_line_height")) . ';
    }

    h5, h5 a {
        font-size: ' . esc_attr(gt3_get_theme_option("h5_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("h5_line_height")) . ';
    }

    h6, h6 a {
        font-size: ' . esc_attr(gt3_get_theme_option("h6_font_size")) . ';
        line-height: ' . esc_attr(gt3_get_theme_option("h6_line_height")) . ';
    }

    input[type="text"]::-webkit-input-placeholder,
    input[type="password"]::-webkit-input-placeholder,
    input[type="email"]::-webkit-input-placeholder,
    input[type="submit"]::-webkit-input-placeholder,
    input[type="tel"]::-webkit-input-placeholder,
    input[type="date"]::-webkit-input-placeholder,
    input[type="time"]::-webkit-input-placeholder,
    input[type="datetime"]::-webkit-input-placeholder,
    input[type="url"]::-webkit-input-placeholder,
    textarea::-webkit-input-placeholder {
        color:' . esc_attr(gt3_get_theme_option("content_color")) . ';
    }
    
    h1 span, 
    h2 span,
    h3 span,
    h4 span,
    h5 span,
    h6 span,
    h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover {
        color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    /* Main Color */
    a,
    .dropcap,
    .woocommerce ul.products li.product .product_category a:hover,
    .woocommerce ul.products li.product .woocommerce-LoopProduct-link:hover h3,
    .woocommerce_container .pagerblock li a.current,
    .woocommerce_container .pagerblock li a.current:hover,
    .header_cart_content:hover .cart_contents,
    .header_cart_content .cart_submenu ul.product_posts li a.title:hover,
    .header_cart_content .cart_submenu ul.product_posts li a.remove_products:hover,
    .single-product .product .summary .woocommerce-review-link:hover,
    .single-product .product .summary .product_meta .posted_in a:hover,
    .single-product .product .summary .product_meta .tagged_as a:hover,
    .module_menu .woocommerce ul.products li.product .price,
    #comments .reply_button a:hover,
    .single-post .post_meta_container a:hover,
    .woocommerce-cart table.shop_table tbody .product-name a:hover,
    .woocommerce-account .woocommerce-MyAccount-navigation a:hover,
    .woocommerce-account .woocommerce .woocommerce-MyAccount-content header a,
    .woocommerce .woocommerce-error::before,
    .woocommerce-page ul.product_list_widget li a:hover {
        color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    .woocommerce-page .widget_shopping_cart .cart_list li a.remove:hover,
    .woocommerce-page.widget_shopping_cart .cart_list li a.remove:hover,
    .woocommerce table.shop_table tbody .product-remove a.remove:hover,
    span.wpcf7-not-valid-tip {
        color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ' !important;
    }

    blockquote:before,
    .woocommerce ul.products li.product .add_to_cart_button,
    .woocommerce_container .pagerblock li a:hover,
    .woocommerce-page .widget_shopping_cart a.button,
    .woocommerce-page .widget_shopping_cart a.button.checkout:hover,
    .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
    .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
    .widget_price_filter .price_slider_amount button.button:hover,
    .header_cart_content .cart_submenu:before,
    .header_cart_content .cart_submenu .header_view_cart_button,
    .header_cart_content .cart_submenu .header_checkout_button:hover,
    .woocommerce .woocommerce-error a,
    .woocommerce .woocommerce-info a,
    .woocommerce .woocommerce-message a,
    .woocommerce-message a,
    .single-product .product .summary .cart .single_add_to_cart_button,
    .woocommerce div.product .woocommerce-tabs ul.tabs li a:after,
    .woocommerce #respond input#submit,
    .single-post .tag_share a:hover,
    .single-post .share_cont a,
    .single-post .featured_posts_container .item_list .item .featured_more_button,
    #comments .comments_number,
    #comments #respond input[type="submit"],
    .woocommerce-cart table.cart td.actions .coupon input[name="apply_coupon"],
    .woocommerce-cart table.cart td.actions input[name="update_cart"]:hover,
    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
    .woocommerce-checkout .woocommerce-checkout-payment #place_order,
    .woocommerce-account .contentarea .woocommerce form input[type="submit"],
    .woocommerce-checkout form.checkout_coupon input[type="submit"],
    .woocommerce .return-to-shop a.button,
    .single-attachment .blog_post_content .gallery_back a:hover {
        background-color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    .woocommerce .woocommerce-error {
        border-top-color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    .a {
        fill: ' . esc_attr(gt3_get_theme_option("theme_color")) . ';
    }

    /* Button Hover Color */
    .woocommerce-message::before {
        color: ' . esc_attr(gt3_get_theme_option("hover_color")) . ';
    }

    .woocommerce ul.products li.product .add_to_cart_button:hover,
    .woocommerce-page .widget_shopping_cart a.button:hover,
    .header_cart_content .cart_submenu .header_view_cart_button:hover,
    .woocommerce .woocommerce-error a:hover,
    .woocommerce .woocommerce-info a:hover,
    .woocommerce .woocommerce-message a:hover,
    .woocommerce-message a:hover,
    .single-product .product .summary .cart .single_add_to_cart_button:hover,
    .woocommerce #respond input#submit:hover,
    .single-post .featured_posts_container .item_list .item .featured_more_button:hover,
    #comments #respond input[type="submit"]:hover,
    .woocommerce-cart table.cart td.actions .coupon input[name="apply_coupon"]:hover,
    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
    .woocommerce-checkout .woocommerce-checkout-payment #place_order:hover,
    .woocommerce-account .contentarea .woocommerce form input[type="submit"]:hover,
    .woocommerce-checkout form.checkout_coupon input[type="submit"]:hover,
    .woocommerce .return-to-shop a.button:hover,
    .single-attachment .blog_post_content .gallery_back a {
        background-color: ' . esc_attr(gt3_get_theme_option("hover_color")) . ';
    }

    .woocommerce .woocommerce-message {
        border-top-color: ' . esc_attr(gt3_get_theme_option("hover_color")) . ';
    }

    /* Main Text Color */
    a:hover,
    .woocommerce ul.products li.product .product_category a,
    .woocommerce_container .pagerblock li a,
    .single-product .product .summary .woocommerce-review-link,
    .single-product .product .summary .product_meta a,
    .single-product .product .summary .product_meta .sku_wrapper .sku,
    .woocommerce div.product .woocommerce-tabs #reviews #review_form_wrapper .comment-form p.stars a,
    .module_menu ul.products li.product .prod_wrapper .custom_field_cont,
    .single-post .post_meta_container a,
    .woocommerce-cart table.shop_table tbody .product-name a,
    .woocommerce-account .woocommerce-MyAccount-navigation a,
    .woocommerce-account .woocommerce .woocommerce-MyAccount-content header a:hover {
        color: ' . esc_attr(gt3_get_theme_option("content_color")) . ';
    }

    .woocommerce-page .widget_shopping_cart .cart_list li a.remove,
    .woocommerce-page.widget_shopping_cart .cart_list li a.remove,
    .woocommerce table.shop_table tbody .product-remove a.remove {
        color: ' . esc_attr(gt3_get_theme_option("content_color")) . ' !important;
    }

    /* Headings Color */
    .dropcap.type1,
    .woocommerce ul.products li.product .price,
    .woocommerce-page ul.product_list_widget li a,
    .woocommerce-page .widget_shopping_cart a.button.checkout,
    .widget_price_filter .price_slider_amount button.button,
    .widget_product_tag_cloud .tagcloud a,
    .header_cart_content .cart_submenu .header_checkout_button,
    .woocommerce div.product .woocommerce-tabs ul.tabs li a,
    .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
    .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
    .single-post .tag_share a,
    #comments .reply_button a,
    .woocommerce-cart table.cart td.actions input[name="update_cart"] {
        color: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }

    blockquote.b_dark:before {
        background-color: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }

    .b {
        fill: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }

    .squiggle path {
        stroke: ' . esc_attr(gt3_get_theme_option("headings_color")) . ';
    }

    /* Submenu Background */
    .header_cart_content .cart_submenu {
        background-color: ' . esc_attr(gt3_get_theme_option("submenu_bg")) . ';
    }
    .module_menu .woocommerce-LoopProduct-link:hover h2.woocommerce-loop-product__title,
    ul.products .woocommerce-LoopProduct-link:hover h2.woocommerce-loop-product__title {
        color: ' . esc_attr(gt3_get_theme_option("theme_color")) . ' !important;
    }
    .module_menu .ingredients_cont {
      color:' . esc_attr(gt3_get_theme_option("content_color")) . ' !important;
    }
    ';

    exit;
}

  #Show JS
  if (intval(get_query_var('gt3_show_only_js')) == 1) {
    ?>

    ok

    <?php
    exit;
  }
}

#Additional files for plugin
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('woocommerce/woocommerce.php')) {
  if (!function_exists('woo_files')) {
    function woo_files()
    {
      wp_enqueue_style('css_woo', get_template_directory_uri() . '/css/woo.css');
      wp_enqueue_script('js_woo', get_template_directory_uri() . '/js/woo.js', array(), false, true);
    }
  }
  add_action('wp_print_styles', 'woo_files');
}
?>