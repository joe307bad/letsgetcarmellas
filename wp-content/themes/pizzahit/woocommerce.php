<?php get_header();
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$gt3_theme_pagebuilder['settings']['selected-sidebar-name'] = "WooCommerce";
?>

	<div class="container">
        <div class="row <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">
            <div class="main_container woo_wrap">
                <div class="shop_title_cont">
                    <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
                    <?php do_action('gt3_archive_description'); ?>
                    <div class="subtitle_divider"></div>
                </div>

                <div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">
                        <div class="contentarea woocommerce_container">
                            <?php
                            woocommerce_content();
                            wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'pizzahit') . ': ', 'after' => '</div>'));
                            ?>
                        </div>
                    </div>
                    <?php get_sidebar('left'); ?>
                </div>
                <?php get_sidebar('right'); ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <?php
    if (is_plugin_active("instagram-feed/instagram-feed.php")) {
        if (isset($gt3_theme_pagebuilder['settings']['show_instagram_area'])) {
            ?>
            <div class="instagram_cont">
                <?php
                    if (strlen(gt3_get_theme_option("footer_instagram_feed_shortcode")) > 0) {
                        echo  do_shortcode(esc_attr(gt3_get_theme_option("footer_instagram_feed_shortcode")));
                    }
                ?>
            </div>
            <?php
        }
    }


get_footer();
