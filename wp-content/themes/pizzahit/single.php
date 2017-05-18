<?php get_header();
the_post();


/* LOAD PAGE BUILDER ARRAY */
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$gt3_theme_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );

if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar" || $gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar") {
	$posts_per_line = '2';
} else {
	$posts_per_line = '3';
}

$post_category_compile = '';
$post_categ = '';
$categories = '';

if (get_the_category()) $categories = get_the_category();

if ($categories) {
	$post_categ = '';
	$post_category_compile = '<span>';
	foreach ($categories as $category) {
		$post_categ = $post_categ . '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . ', ';
	}
	$post_category_compile .= ' ' . trim($post_categ, ', ') . '</span>';		
}

$pft = get_post_format();
if ($pft !== "image" && $pft !== "video") {
	$pft = "standart";
}

if (get_the_tags() !== '') {
	$posttags = get_the_tags();
}
if ($posttags) {
	$post_tags = '';
	$post_tags_compile = '';
	foreach ($posttags as $tag) {
		$post_tags = $post_tags . '<a href="' . get_term_link($tag) . '">' . $tag->name . '</a>';
	}
	$post_tags_compile .= '' . trim($post_tags, '') . '';
} else {
	$post_tags_compile = '';
}

$comments_num = '' . get_comments_number(get_the_ID()) . '';
	
if ($comments_num == 1) {
	$comments_text = '' . esc_html__('comment', 'pizzahit') . '';
} else {
	$comments_text = '' . esc_html__('comments', 'pizzahit') . '';
}
?>
    <div class="content_wrapper">
        <div class="share_popup_cont">
            <div class="share_cont">

            </div>
        </div>
        <div class="container">
            <div class="content_block row <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">
                <div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">
                        <div <?php post_class(); ?>></div>
                        <div class="post_title">
                            <h1><?php esc_html(the_title()); ?></h1>

                        </div>

                        <div class="post_meta_container">
                            <span class="post_date">
                                <?php echo get_the_time(get_option('date_format')); ?>
                            </span>
                            <?php echo esc_html('/'); ?>
                            <span class="post_author">
                                <?php echo esc_html__('by ', 'pizzahit'); ?>
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author_meta('display_name')); ?></a>
                            </span>
                            <?php echo esc_html('/'); ?>
                            <span class="post_category">
                                <?php echo esc_html__('in', 'pizzahit'); ?>
                                <?php echo esc_html(the_category(', ')); ?>
                            </span>
                        </div>

                        <div class="media_output_container <?php echo((isset($gt3_theme_featured_image[0]) && $gt3_theme_featured_image[0] !== '') ? '' : 'without_image'); ?>">
                            <?php echo gt3_get_pf_type_output(array("pf" => get_post_format(), "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder)); ?>
                        </div>

                        <div class="blog_content clearfix">
                            <?php
                            the_content(esc_html__('Read more!', 'pizzahit'));
                            wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'pizzahit') . ': ', 'after' => '</div>'));
                            ?>
                        </div>
                        <div class="dn"><?php posts_nav_link(); ?></div>

                        <div class="row tags_and_share_cont">
                            <?php
                            if (is_array(get_the_tags())) {
                                ?>
                                <div class="col-sm-8 tag_share">
                                    <?php esc_html(the_tags('', '')); ?>
                                </div>
                                <div class="col-sm-4 share_cont">
                                    <a target="_blank"
                                       href="http://www.facebook.com/share.php?u=<?php echo esc_url(get_permalink()); ?>"
                                       class="share_facebook">
                                       <i class="fa fa-facebook"></i>
                                    </a>

                                    <a target="_blank"
                                       href="https://twitter.com/intent/tweet?text=<?php echo esc_url(get_the_title()); ?>&amp;url=<?php echo get_permalink(); ?>"
                                       class="share_tweet">
                                       <i class="fa fa-twitter"></i>
                                    </a>

                                    <a target="_blank"
                                       href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>"
                                       class="share_gplus">
                                       <i class="fa fa-google-plus"></i>
                                    </a>

                                    <a target="_blank"
                                       href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo (strlen($gt3_theme_featured_image[0]) > 0) ? $gt3_theme_featured_image[0] : gt3_get_theme_option("logo"); ?>"
                                       class="share_pinterest">
                                       <i class="fa fa-pinterest-p"></i>
                                    </a>
                                    <a class="share_button" href="<?php echo esc_js('javascript:void(0)'); ?>"><i class="fa fa-share-alt"></i></a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col-sm-12 share_cont">
                                    <a target="_blank"
                                       href="http://www.facebook.com/share.php?u=<?php echo esc_url(get_permalink()); ?>"
                                       class="share_facebook">
                                        <i class="fa fa-facebook"></i>
                                    </a>

                                    <a target="_blank"
                                       href="https://twitter.com/intent/tweet?text=<?php echo esc_url(get_the_title()); ?>&amp;url=<?php echo get_permalink(); ?>"
                                       class="share_tweet">
                                        <i class="fa fa-twitter"></i>
                                    </a>

                                    <a target="_blank"
                                       href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>"
                                       class="share_gplus">
                                        <i class="fa fa-google-plus"></i>
                                    </a>

                                    <a target="_blank"
                                       href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo (strlen($gt3_theme_featured_image[0]) > 0) ? $gt3_theme_featured_image[0] : gt3_get_theme_option("logo"); ?>"
                                       class="share_pinterest">
                                        <i class="fa fa-pinterest-p"></i>
                                    </a>
                                    <a class="share_button" href="<?php echo esc_js('javascript:void(0)'); ?>"><i class="fa fa-share-alt"></i></a>
                                </div>
                                <?php
                            }
                            ?>


                        </div>

                        <!-- Featured Posts Module -->
                        <?php
                        if (gt3_get_theme_option('related_posts') == 'on') {
                            if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == 'no-sidebar') {
                                $posts_per_line = 3;
                            } else {
                                $posts_per_line = 2;
                            }
                            ?>
                            <div class="featured_posts_container">
                                <h5 class="featured_posts_heading">
                                    <?php echo esc_html__('Related Posts', 'pizzahit') ?>
                                </h5>
                                <div class="featured_items clearfix">
                                    <div class="items_<?php echo $posts_per_line ?> featured_posts">
                                        <div class="item_list">
                                            <?php
                                            $gt3_wp_query = new WP_Query();

                                            $args = array(
                                                'posts_per_page' => $posts_per_line,
                                                'orderby' => 'rand',
                                                'ignore_sticky_posts' => 1
                                            );

                                            $gt3_wp_query->query($args);
                                            while ($gt3_wp_query->have_posts()) : $gt3_wp_query->the_post();

                                                $wp_get_attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');

                                                if (strlen($wp_get_attachment_url)) {
                                                    $gt3_featured_image_url = aq_resize($wp_get_attachment_url, 400, 300, true, true, true);
                                                    $featured_image = '<img alt="" src="' . $gt3_featured_image_url . '" />';
                                                } else {
                                                    $featured_image = '';
                                                }

                                                if (get_the_category()) $categories = get_the_category();

                                                if ($categories) {
                                                    $post_categ = '';
                                                    foreach ($categories as $category) {
                                                        $post_categ = $post_categ .'<a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a>, ';
                                                    }
                                                }

                                                $post_categ = substr($post_categ,0,-2);
                                            ?>

                                                <div class="item">
                                                    <div class="img_cont wrapped_img">
                                                        <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>">
                                                            <span class="featured_item_fader"></span>
                                                            <?php echo $featured_image; ?>
                                                        </a>
                                                    </div>
                                                    <div class="item_wrapper">
                                                        <div class="featured_items_body">
                                                            <h6>
                                                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_html(get_the_title(get_the_ID())); ?></a>
                                                            </h6>
                                                            <div class="post-meta">
                                                                <span class="post_date">
                                                                    <?php echo esc_html(get_the_time(get_option( 'date_format' ))); ?>
                                                                </span>
                                                                <?php echo esc_html('/'); ?>
                                                                <span class="post_author">
                                                                    <?php echo esc_html__('by', 'pizzahit'); ?>
                                                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author_meta('display_name')); ?></a>
                                                                </span>
                                                                <?php echo esc_html('/'); ?>
                                                                <span class="post_category">
                                                                    <?php echo esc_html__('in', 'pizzahit'); ?>
                                                                    <?php echo trim($post_categ, ', '); ?>
                                                                </span>
                                                            </div><!-- post-meta -->
                                                            <div class="featured_item_content">
                                                                <?php echo substr(get_the_excerpt(), 0, 150); ?>
                                                            </div>
                                                            <a class="featured_more_button" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"></a>
                                                        </div><!-- featured_items_body -->
                                                    </div><!-- item_wrapper -->
                                                </div><!-- item -->

                                            <?php
                                            endwhile;
                                            wp_reset_postdata();
                                            ?>
                                            <div class="clear"></div>
                                        </div><!-- item_list -->
                                    </div><!-- featured_posts -->
                                </div><!-- featured_items -->
                            </div><!-- featured_posts_container -->
                            <?php
                        }
                        ?>

                        <!-- Comments Module -->
                        <div class="comments_module">
                            <?php comments_template(); ?>
                        </div>
                    </div><!-- posts-block -->
                    <?php get_sidebar('left'); ?>
                </div><!-- fl-container -->
                <?php get_sidebar('right'); ?>
                <div class="clear"></div>
            </div><!-- content_block -->
        </div><!-- container -->
    </div><!-- content_wrapper -->

<?php get_footer(); ?>