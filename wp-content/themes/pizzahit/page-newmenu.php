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
                $categoryName = $product_category->name;
                $cleanCategoryName
                    = strtolower(preg_replace("/[^a-zA-Z]+/", "", $categoryName));
                ?>
                <div class="category" id="<?php echo $cleanCategoryName ?>">
                    <div class="category-inner">
                        <h4>
                            <?php echo $categoryName ?>
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
                        switch ($cleanCategoryName) {
                            case "pizzas";
                                include("product-types/templates/pizzas.php");
                                break;
                            case "specialtypizza";
                                include("product-types/templates/specialty-pizzas.php");
                                break;
                            case "squarecuttraystylepizza";
                                include("product-types/templates/square-cut-pizzas.php");
                                break;
                            case "subs";
                                include("product-types/templates/subs.php");
                                break;
                            default:
                                include("product-types/templates/default.php");
                        }
                        ?>
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