<?php
/**
 * Created by PhpStorm.
 * User: Joseph
 * Date: 9/27/2017
 * Time: 7:42 PM
 */
?>
<div class="table-container">
<table>
    <thead>
    <tr>
        <th>

        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                1/4 tray<br/>6 cut
            </h2>
        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                1/2 tray<br/>12 cut
            </h2>
        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                Full tray<br/>24 cut
            </h2>
        </th>
    </tr>
    </thead>
    <?php
    $reversedPosts = array_reverse($products->posts);
    $products->posts = $reversedPosts;
    while ($products->have_posts()) {
        $products->the_post();
        $sixCutPrice = get_post_meta(get_the_ID(), '_sc_six_cut_price', true);
        $twelveCutPrice = get_post_meta(get_the_ID(), '_sc_twelve_cut_price', true);
        $twentyFourCutPrice
            = get_post_meta(get_the_ID(), '_sc_twenty_four_cut_price', true);
        ?>

        <tr>
            <td>
                <h2 class="woocommerce-loop-product__title">
                    <?php the_title(); ?>
                </h2>
            </td>
            <td>
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $sixCutPrice; ?>
                </span>
            </td>
            <td>
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $twelveCutPrice; ?>
                </span>
            </td>
            <td>
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $twentyFourCutPrice; ?>
                </span>
            </td>
        </tr>
        <?php
    } ?>

</table>
</div>
<p>

    <?php the_content(); ?>
<div class="clearfix"></div>
</p>

<div class="clearfix"></div>


