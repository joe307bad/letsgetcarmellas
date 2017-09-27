<?php
/*
 * Template Name: Menu
 * Description: Menu
 */

get_header();

$product_categories = get_terms('product_cat');
$args = array(
    'orderby' => 'title',
    'order' => 'ASC',
);
$product_categories = get_terms('product_cat', $args);
$count = count($product_categories);
?>
    <div id="menu-container">
        <?php
        if ($count > 0) {
            foreach ($product_categories as $product_category) {
                ?>
                <div class="category">
                    <div class="category-inner col-xs-6">
                        <h4>
                            <?php echo $product_category->name ?>
                        </h4>
                        <div class="heading_title_divider"></div>
                        <?php
                        $args = array(
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    // 'terms' => 'white-wines'
                                    'terms' => $product_category->slug
                                )
                            ),
                            'post_type' => 'product',
                            'orderby' => 'title,'
                        );
                        $products = new WP_Query($args);
                        while ($products->have_posts()) {
                            $products->the_post();
                            $price =
                                get_post_meta(get_the_ID(), '_regular_price', true);
                            ?>
                            <div class="col-xs-4">
                                <a>
                                    <h2 class="woocommerce-loop-product__title">
                                        <?php the_title(); ?>
                                    </h2>
                                    <span class="woocommerce-Price-amount amount">
                        <span class="woocommerce-Price-currencySymbol">$</span>
                                        <?php echo $price; ?>
                    </span>
                                    <p>
                                        <?php the_content(); ?>
                                    <div class="clearfix"></div>
                                    </p>
                                </a>
                            </div>
                            <?php
                        } ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            }
        }
        ?>
        <div class="clearfix"></div>
    </div>
<?php
get_footer();
?>