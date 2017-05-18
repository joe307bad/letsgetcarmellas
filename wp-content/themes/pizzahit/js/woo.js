// Price Filter
setInterval(function woopricefilter() {
    "use strict";
    jQuery('.widget_price_filter').each(function () {
        var price_box = jQuery(this).find('.price_label');
        var price_from = jQuery(this).find(price_box).find('span.from').text();
        var price_to = jQuery(this).find(price_box).find('span.to').text();
        var filter_slider = jQuery(this).find('.price_slider_wrapper');

        jQuery(filter_slider).find('.ui-slider-handle').first().attr('data-width', price_from);
        jQuery(filter_slider).find('.ui-slider-handle').last().attr('data-width-r', price_to);
    });
}, 100);

jQuery(document).ready(function(){
    "use strict";

    // Products Listing
    jQuery('ul.products li').wrapInner('<div class="prod_wrapper"></div>').find('.attachment-shop_catalog').wrap('<div class="image_cont"></div>').after('<div class="image_cont_inner"></div>');
    jQuery('.woocommerce_container .woocommerce-result-count, .woocommerce_container .woocommerce-ordering').wrapAll('<div class="shop_results_and_ordering"></div>');
    jQuery('.shop_results_and_ordering').append('<div class="clear"></div>');
    jQuery('.woocommerce-ordering').prepend('<div class="arrow_box_mask"></div>');

    jQuery('.widget_product_search .woocommerce-product-search').append('<i class="fa fa-search"></i>');
    jQuery('.widget_product_search').find('input[type="submit"]').attr('value', '');

    jQuery('.woocommerce.post-type-archive-product .woocommerce_container ul.products').isotope({
        layoutMode: 'fitRows'
    });

    jQuery('.related.products ul.products').isotope({
        layoutMode: 'fitRows'
    });

    // Module Menu
    jQuery('.module_menu').each(function(){
        jQuery(this).find('ul.products li').each(function(){
            var prod_image = jQuery(this).find('.woocommerce-LoopProduct-link img').detach();

            jQuery(this).find('.prod_wrapper').prepend('<div class="prod_image"></div>');
            jQuery(this).find('.prod_image').prepend(prod_image);
        });

        jQuery(this).find('ul.products').addClass('isotope');
    });

    // Single Product
    var prod_price_cont = jQuery('.single-product .product .summary .price'),
        old_price = jQuery(prod_price_cont).find('del').detach();

    prod_price_cont.find('ins').after(old_price);

    jQuery('.woocommerce #content div.product .woocommerce-main-image img, .woocommerce div.product .woocommerce-main-image img, .woocommerce-page #content div.product .woocommerce-main-image img, .woocommerce-page div.product .woocommerce-main-image img').wrap('<div class="image_cont"></div>').after('<div class="image_cont_inner"></div>');
    jQuery('.woocommerce #content div.product div.thumbnails a, .woocommerce div.product div.thumbnails a, .woocommerce-page #content div.product div.thumbnails a, .woocommerce-page div.product div.thumbnails a').each(function(){
        jQuery(this).find('img').wrap('<div class="thumb_wrapper"></div>').wrap('<div class="image_cont"></div>').after('<div class="image_cont_inner"></div>');
    });

    jQuery('.woocommerce-tabs #tab-reviews .commentlist .comment').each(function(){
        var comment_author = jQuery(this).find('.meta strong').detach(),
            comment_date = jQuery(this).find('.meta time').detach(),
            comment_raiting = jQuery(this).find('.star-rating').detach();

        jQuery(this).find('.meta').html('<div class="comment_author"></div><div class="comment_date"></div>');
        jQuery(this).find('.description').after('<div class="comment_raiting"></div>');
        jQuery(this).find('.comment_author').prepend(comment_author);
        jQuery(this).find('.comment_date').prepend(comment_date);
        jQuery(this).find('.comment_raiting').prepend(comment_raiting);
    });

    jQuery('.woocommerce-tabs #comments').after('<div class="comments_divider"></div>');

    var comment_author_paceholder = jQuery('form.comment-form .comment-form-author').find('label').text(),
        comment_email_placeholder = jQuery('form.comment-form .comment-form-email').find('label').text(),
        comment_message_placeholder = jQuery('form.comment-form .comment-form-comment').find('label').text();

    jQuery('form.comment-form .comment-form-author input').attr('placeholder', comment_author_paceholder);
    jQuery('form.comment-form .comment-form-email input').attr('placeholder', comment_email_placeholder);
    jQuery('form.comment-form .comment-form-comment textarea').attr('placeholder', comment_message_placeholder);

    /* Shopping Cart */
    var cart_table_prod_cont = jQuery('.woocommerce-cart table.shop_table thead .product-name'),
        cart_table_prod_name = jQuery(cart_table_prod_cont).html();

    jQuery('.woocommerce table.shop_table thead .product-thumbnail').html(cart_table_prod_name);
    cart_table_prod_cont.html('');
});




































