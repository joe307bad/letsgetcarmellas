<?php get_header();
$gt3_theme_pagebuilder = gt3_get_default_pb_settings();
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];
?>

  <div class="container">
    <div class="content_block row <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">
      <div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
        <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "<div class='row'>" : ""); ?>
        <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">
          <div class="contentarea">
            <div class="search_listing_container">
              <?php
              global $paged, $offset, $posts_per_page;

              $offset = 0;
              $posts_per_page = 10;
              $foundSomething = false;

              $defaults = array('numberposts' => 10, 'offset' => 0, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false, 's' => get_search_query(), 'paged' => $paged);
              $query = http_build_query($defaults);
              $posts = get_posts($query);

              if (!empty($posts)) echo '<h2>' . esc_html__('Search Results:', 'pizzahit'). '</h2>';

              foreach ($posts as $post) {
                setup_postdata($post);

                if (isset($categories) && is_array($categories)) {
                  $post_categ = '';
                  foreach ($categories as $category) {
                    $post_categ = $post_categ . '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->cat_name) . '</a>' . ', ';
                  }
                  $post_category_compile = trim($post_categ, ', ');
                }

                if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "no-sidebar") {
                  $excerpt = ((strlen(get_the_excerpt()) > 0) ? gt3_smarty_modifier_truncate(get_the_excerpt(), 500, '...') : gt3_smarty_modifier_truncate(get_the_content(), 500, '...'));
                } else {
                  $excerpt = ((strlen(get_the_excerpt()) > 0) ? gt3_smarty_modifier_truncate(get_the_excerpt(), 340, '...') : gt3_smarty_modifier_truncate(get_the_content(), 340, '...'));
                }
                ?>
                <div class="search_item">
                  <div class="item_title">
                    <h3 class="headings">
                      <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_html(get_the_title(get_the_ID())); ?></a>
                    </h3>
                  </div>
                  <div class="item_meta">
                    <span class="post_date">
                      <?php echo esc_html(get_the_time(get_option( 'date_format' ))); ?>
                    </span>
                    <?php
                    if (isset($categories)) {
                      ?>
                      <?php echo esc_html('/'); ?>
                      <span class="post_category">
                        <?php echo $post_category_compile; ?>
                      </span>
                    <?php
                    }
                    ?>
                    <?php echo esc_html('/'); ?>
                    <span class="post_author">
                      <?php echo esc_html__('by', 'pizzahit'); ?>
                      <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author_meta('display_name')); ?></a>
                    </span>
                  </div>
                  <div class="search_content">
                    <?php
                    echo $excerpt;
                    ?>
                  </div>
                  <a class="shortcode_button btn_small btn_type1" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_html__('Read more', 'pizzahit'); ?></a>
                </div><!-- search_item -->
                <?php

                $foundSomething = true;
              }

              if ($foundSomething == true) {
                ?>
                <div class="post_divider_wrapper">
                  <div class="post_divider"></div>
                </div>
                <?php
              }

              if ($foundSomething == false) {
                ?>
                <div class="error404_block">
                  <h2><?php echo esc_html__('Sorry! No Posts Were Found', 'pizzahit'); ?></h2>
                  <?php get_search_form(true); ?>
                </div>
              <?php
              }
              ?>

              <?php
              echo gt3_get_theme_pagination();
              ?>
            </div><!-- search_listing_container -->
          </div><!-- contentarea -->
        </div><!-- posts-block -->
        <?php get_sidebar('left'); ?>
        <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "</div>" : ""); ?>
      </div><!-- fl-container -->
      <?php get_sidebar('right'); ?>
      <div class="clear"></div>
    </div><!-- content_block -->
  </div><!-- container -->

<?php get_footer(); ?>