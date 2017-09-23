<?php
/**
 * Plugin Name: 	WooCommerce Custom Product Type
 * Plugin URI:		http://jeroensormani.com
 * Description:		A simple demo plugin on how to add a custom product type.
 */

/**
 * Register the custom product type after init
 */
function register_square_cut_pizza_product_type() {

    /**
     * This should be in its own separate file.
     */
    class WC_Product_Square_Cut_Pizza extends WC_Product {

        public function __construct( $product ) {

            $this->product_type = 'square_cut_pizza';

            parent::__construct( $product );

        }

    }

}
add_action( 'init', 'register_square_cut_pizza_product_type' );


/**
 * Add to product type drop down.
 */
function add_square_cut_pizza_product( $types ){

    // Key should be exactly the same as in the class
    $types[ 'square_cut_pizza' ] = __( 'Square Cut Pizza' );

    return $types;

}
add_filter( 'product_type_selector', 'add_square_cut_pizza_product' );


/**
 * Show pricing fields for square_cut_pizza product.
 */
function square_cut_pizza_custom_js() {

    if ( 'product' != get_post_type() ) :
        return;
    endif;

    ?><script type='text/javascript'>
        jQuery( document ).ready( function() {
            jQuery( '.options_group.pricing' ).addClass( 'show_if_square_cut_pizza' ).show();
        });

    </script><?php

}
add_action( 'admin_footer', 'square_cut_pizza_custom_js' );


/**
 * Contents of the rental options product tab.
 */
function square_cut_pizza_sizes_product_tab_content() {

    global $post;

    ?><div id='square_cut_pizza_sizes' class='panel woocommerce_options_panel'><?php

    ?><div class='options_group'><?php


    woocommerce_wp_text_input( array(
        'id'			=> '_sc_six_cut_price',
        'label'			=> __( '6 cut Small Price', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of a small pizza', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    woocommerce_wp_text_input( array(
        'id'			=> '_sc_twelve_cut_price',
        'label'			=> __( '12 cut Large Price', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of an Large pizza', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    woocommerce_wp_text_input( array(
        'id'			=> '_sc_twenty_four_cut_price',
        'label'			=> __( '24 cut XLarge Price', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of an xlarge pizza', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    ?></div>

    </div><?php


}
add_action( 'woocommerce_product_data_panels', 'square_cut_pizza_sizes_product_tab_content' );


/**
 * Save the custom fields.
 */
function save_square_cut_pizza_size_field( $post_id ) {

    $pizza_size = isset( $_POST['_enable_square_cut_pizza_sizes'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_enable_square_cut_pizza_sizes', $pizza_size );

    if ( isset( $_POST['_sc_six_cut_price'] ) ) :
        update_post_meta( $post_id, '_sc_six_cut_price', sanitize_text_field( $_POST['_sc_six_cut_price'] ) );
    endif;
    if ( isset( $_POST['_sc_twelve_cut_price'] ) ) :
        update_post_meta( $post_id, '_sc_twelve_cut_price', sanitize_text_field( $_POST['_sc_twelve_cut_price'] ) );
    endif;
    if ( isset( $_POST['_sc_twenty_four_cut_price'] ) ) :
        update_post_meta( $post_id, '_sc_twenty_four_cut_price', sanitize_text_field( $_POST['_sc_twenty_four_cut_price'] ) );
    endif;

}
add_action( 'woocommerce_process_product_meta_square_cut_pizza', 'save_square_cut_pizza_size_field'  );
add_action( 'woocommerce_process_product_meta_variable_rental', 'save_square_cut_pizza_size_field'  );

