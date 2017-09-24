<?php
/*
 * Template Name: Menu
 * Description: Menu
 */

get_header();

$product_categories = get_terms('product_cat');
$args = array(
    'orderby'    => 'title',
    'order'      => 'ASC',
);
$product_categories = get_terms( 'product_cat', $args );
$count = count($product_categories);
if ( $count > 0 ){
    foreach ( $product_categories as $product_category ) {
        echo '<h4><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</a></h4>';
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
        $products = new WP_Query( $args );
        echo "<ul>";
        while ( $products->have_posts() ) {
            $products->the_post();
            ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </li>
            <?php
        }
        echo "</ul>";
    }
}
get_footer();
?>