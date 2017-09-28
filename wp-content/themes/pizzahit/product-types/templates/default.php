<?php
/**
 * Created by PhpStorm.
 * User: Joseph
 * Date: 9/27/2017
 * Time: 7:43 PM
 */
?>

<?php
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
        <div class="clearfix"></div>
    </div>
<?php } ?>


