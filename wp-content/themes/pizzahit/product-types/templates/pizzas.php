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
                6 cut price<br/>Small 9"
            </h2>
        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                8 cut price<br/>Large 14"
            </h2>
        </th>
        <th>
            <h2 class="woocommerce-loop-product__title">
                12 cut price<br/>XLarge 16"
            </h2>
        </th>
    </tr>
    </thead>
    <?php
    $reversedPosts = array_reverse($products->posts);
    $products->posts = $reversedPosts;
    while ($products->have_posts()) {
        $products->the_post();
        $sixCutPrice = get_post_meta(get_the_ID(), '_six_cut_price', true);
        $eightCutPrice = get_post_meta(get_the_ID(), '_eight_cut_price', true);
        $twelveCutPrice = get_post_meta(get_the_ID(), '_twelve_cut_price', true);
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
                    <?php echo $eightCutPrice; ?>
                </span>
            </td>
            <td>
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $twelveCutPrice; ?>
                </span>
            </td>
        </tr>
        <?php
    } ?>

</table>
<div class="col-xs-12" id="crusts">
    <h2 class="woocommerce-loop-product__title">
        Crusts
    </h2>
    <p>
        Original Thin or Hand Tosses
    </p>
</div>
<div id="toppings" class="col-xs-8">
    <h2 class="woocommerce-loop-product__title">
        Toppings
    </h2>
    <div class="col-xs-4">
        <ul>
            <li>Extra Cheese</li>
            <li>Cheddar</li>
            <li>Feta</li>
            <li>Ricotta</li>
            <li>Anchovies</li>
            <li>Gyro Meat*</li>
            <li>Extra Sauce</li>
            <li>Pepperoni</li>
            <li>Sausage</li>
        </ul>
    </div>
    <div class="col-xs-4">
        <ul>
            <li>Ham</li>
            <li>Bacon</li>
            <li>Meatball*</li>
            <li>Salami</li>
            <li>Chicken*</li>
            <li>Steak*</li>
            <li>Mushrooms</li>
            <li>Green Peppers</li>
            <li>Roasted Red Peppers</li>
        </ul>
    </div>
    <div class="col-xs-4">
        <ul>
            <li>Jalapenos</li>
            <li>Mild Pepper Rings</li>
            <li>Onions</li>
            <li>Shrimp*</li>
            <li>Spinach</li>
            <li>Black Olives</li>
            <li>Artichokes</li>
            <li>Tomato</li>
            <li>Pineapple</li>
        </ul>
    </div>
</div>
<div class="col-xs-4">
    <h2 class="woocommerce-loop-product__title">
        Pizza Sauces
    </h2>
    <ul>
        <li>Red</li>
        <li>White (garlic and olive oil)</li>
        <li>Alfredo</li>
        <li>BBQ</li>
        <li>Buffalo</li>
    </ul>
</div>
<div class="clearfix"></div>


