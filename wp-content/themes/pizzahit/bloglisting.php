<?php
  $wp_get_attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
  $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
                        
    if (strlen($wp_get_attachment_url)) {
        $gt3_featured_image_url = aq_resize($wp_get_attachment_url, 1170, 845, true, true, true);
        $featured_image = '<img alt="" src="' . $gt3_featured_image_url . '" />';
    } else {
        $featured_image = '';
    }

    $post_format = get_post_format(get_the_ID());
    if (empty($post_format)) $post_format = "standard";

    $comments_num = '' . get_comments_number(get_the_ID()) . '';

    if ($comments_num == 1) {
        $comments_text = '' . esc_html__('comment', 'pizzahit') . '';
    } else {
        $comments_text = '' . esc_html__('comments', 'pizzahit') . '';
    }

    if (get_the_category()) $categories = get_the_category();

    $post_category_compile = '';
    if ($categories) {
        $post_categ = '';
        foreach ($categories as $category) {
            $post_categ = $post_categ . '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->cat_name) . '</a>' . ', ';
        }
        $post_category_compile = trim($post_categ, ', ');
    }

    if (get_the_tags() !== '') {
      $posttags = get_the_tags();
    }
    if ($posttags) {
      $post_tags = '';
      $post_tags_compile = '';
      foreach ($posttags as $tag) {
        $post_tags = $post_tags . '<a href="' . get_term_link($tag) . '">' . $tag->name . '</a>' . ', ';
      }
      $post_tags_compile .= '' . trim($post_tags, ', ');
    } else {
      $post_tags_compile = '';
    }
    if ( is_sticky() ) {
        $pf_icon = '<i class="fa fa-thumb-tack"></i>';
    } else {
        $pf_icon = '';
    }
  ?>

<div class="blog_listing_item default_post_listing"><div <?php post_class(); ?>></div>
    <div class="blog_listing_item_wrapper">
        <?php
        if (strlen($wp_get_attachment_url)) {
            ?>
            <div class="img_block">
                <?php echo gt3_get_pf_type_output(array("pf" => $post_format, "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder)); ?>
            </div>
            <?php
        }
        ?>
        <div class="featured_item_descr <?php echo esc_attr(((strlen($wp_get_attachment_url)) ? 'width_image' : '')); ?> ">
            <h3 class="headings">
                <?php echo $pf_icon; ?><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_html(get_the_title(get_the_ID())); ?></a>
            </h3>
            <div class="post-meta">
                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><span class="post_date">
                    <?php echo esc_html(get_the_time(get_option( 'date_format' ))); ?>
                </span></a>
                <?php echo esc_html('/'); ?>
                <span class="post_author">
                    <?php echo esc_html__('by', 'pizzahit'); ?>
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author_meta('display_name')); ?></a>
                </span>
                <?php if ($post_category_compile != '') { echo esc_html('/'); ?>
                <span class="post_category">
                    <?php echo esc_html__('in ', 'pizzahit') . $post_category_compile; ?>
                </span>
                <?php } if ($post_tags_compile != '') { echo esc_html('/'); ?>
                <span class="post_tags">
                    <?php echo $post_tags_compile; ?>
                </span>
                <?php } ?> 
            </div>
            <div class="featured_item_content">
                <?php echo get_the_excerpt(); ?>
            </div>
            <a class="shortcode_button btn_normal btn_type1" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_html__('Read more', 'pizzahit'); ?></a>
        </div><!-- featured_item_descr -->
    </div><!-- featured_item_wrapper -->
</div><!-- featured_item -->