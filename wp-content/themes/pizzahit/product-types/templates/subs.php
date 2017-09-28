<?php
/**
 * Created by PhpStorm.
 * User: Joseph
 * Date: 9/27/2017
 * Time: 7:42 PM
 */
?>
<table>
    <thead>
    <tr>
        <th>

        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                6 inch
            </h2>
        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                12 inch
            </h2>
        </th>
    </tr>
    </thead>
    <?php
    $reversedPosts = array_reverse($products->posts);
    $products->posts = $reversedPosts;
    while ($products->have_posts()) {
        $products->the_post();
        $sixInchPrice = get_post_meta(get_the_ID(), '_six_inch_price', true);
        $twelveInchPrice = get_post_meta(get_the_ID(), '_twelve_inch_price', true);
        ?>

        <tr>
            <td>
                <h2 class="woocommerce-loop-product__title">
                    <?php the_title(); ?>
                </h2>
                <?php the_content(); ?>
            </td>
            <td>
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $sixInchPrice; ?>
                </span>
            </td>
            <td>
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $twelveInchPrice; ?>
                </span>
            </td>
        </tr>
        <?php
    } ?>

</table>
<div class="clearfix"></div>


