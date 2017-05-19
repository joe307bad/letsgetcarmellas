<?php
if ( !post_password_required() ) {
  get_header();
  the_post();
  $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
  $gt3_theme_featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
  if (isset($gt3_theme_pagebuilder['page_settings']['fw_featured']) && $gt3_theme_pagebuilder['page_settings']['fw_featured'] == 'on') {
    $fw_featured = true;
  } else {
    $fw_featured = false;
  }
  if (isset($gt3_theme_pagebuilder['rev_slider_shortcode']))
  if (strlen($gt3_theme_pagebuilder['rev_slider_shortcode'])) {
    echo '<div class="rev_slider_presents">' . do_shortcode($gt3_theme_pagebuilder['rev_slider_shortcode']) . '</div>';
  }
?>
    <div class="container">
        <div class="content_block <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">
            <?php
            if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || ($gt3_theme_pagebuilder['settings']['show_title']) !== 'no') {
                ?>
                <div class="page_title text_align_<?php echo esc_attr((isset($gt3_theme_pagebuilder['page_settings']['page_title_alignment']) ? $gt3_theme_pagebuilder['page_settings']['page_title_alignment'] : 'center')); ?>">
                    <h1>
                        <?php esc_html(the_title()); ?>
                    </h1>

                    <?php
                    if (isset($gt3_theme_pagebuilder['page_settings']['page_subtitle']) && $gt3_theme_pagebuilder['page_settings']['page_subtitle'] !== '') {
                        ?>
                        <div class="page_subtitle text_align_<?php echo esc_attr((isset($gt3_theme_pagebuilder['page_settings']['page_subtitle_alignment']) ? $gt3_theme_pagebuilder['page_settings']['page_subtitle_alignment'] : 'center')); ?>">
                            <p><?php echo $gt3_theme_pagebuilder['page_settings']['page_subtitle']; ?></p>
                        </div>
                        <?php
                    }

                    if (!isset($gt3_theme_pagebuilder['page_settings']['title_divider']) || $gt3_theme_pagebuilder['page_settings']['title_divider'] !== 'hide') {
                        ?>
                        <div class="subtitle_divider"></div>
                        <?php
                    }
                    ?>

                </div><!-- page_title -->
                <?php
            }
            ?>
            <div class="fl-container <?php echo esc_attr((($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : "")); ?>">
                <div class="posts-block <?php echo esc_attr(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : "")); ?>">
                    <div class="contentarea">
                        <?php
                        the_content(esc_html__('Read more!', 'pizzahit'));
                        wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'pizzahit') . ': ', 'after' => '</div>'));

                        if (gt3_get_theme_option("page_comments") == "enabled") { ?>
                          <div class="clea_r"></div>
                          <div class="row">
                            <div class="col-sm-12 pt35">
                              <?php comments_template(); ?>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="clear"></div>
                    </div><!-- contentarea -->
                </div><!-- posts-block -->
                <?php get_sidebar('left'); ?>
            </div><!-- fl-container -->
            <?php get_sidebar('right'); ?>
            <div class="clear"></div>
        </div><!-- content_block -->
    </div><!-- container -->

<?php get_footer();
} ?>

<img id="background-image" src="<?php echo get_template_directory_uri(); ?>/img/background.png" />
