<?php
/**
 * Plugin Name: 	WooCommerce Custom Product Type
 * Plugin URI:		http://jeroensormani.com
 * Description:		A simple demo plugin on how to add a custom product type.
 */

/**
 * Register the custom product type after init
 */
function register_pizza_product_type() {

    /**
     * This should be in its own separate file.
     */
    class WC_Product_Pizza extends WC_Product {

        public function __construct( $product ) {

            $this->product_type = 'pizza';

            parent::__construct( $product );

        }

    }

}
add_action( 'init', 'register_pizza_product_type' );


/**
 * Add to product type drop down.
 */
function add_pizza_product( $types ){

    // Key should be exactly the same as in the class
    $types[ 'pizza' ] = __( 'Pizza' );

    return $types;

}
add_filter( 'product_type_selector', 'add_pizza_product' );


/**
 * Show pricing fields for pizza product.
 */
function pizza_custom_js() {

    if ( 'product' != get_post_type() ) :
        return;
    endif;

    ?><script type='text/javascript'>
        jQuery( document ).ready( function() {
            jQuery( '.options_group.pricing' ).addClass( 'show_if_pizza' ).show();
        });

    </script><?php

}
add_action( 'admin_footer', 'pizza_custom_js' );



/**
 * Contents of the rental options product tab.
 */
function pizza_sizes_product_tab_content() {

    global $post;

    ?><div id='pizza_sizes' class='panel woocommerce_options_panel'><?php

    ?><div class='options_group'><?php


    woocommerce_wp_text_input( array(
        'id'			=> '_six_cut_price',
        'label'			=> __( '6 cut Small Price', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of a small pizza', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    woocommerce_wp_text_input( array(
        'id'			=> '_eight_cut_price',
        'label'			=> __( '8 cut Large Price', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of a large pizza', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    woocommerce_wp_text_input( array(
        'id'			=> '_twelve_cut_price',
        'label'			=> __( '12 cut XLarge Price', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of an xlarge pizza', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    ?></div>

    </div><?php


}
add_action( 'woocommerce_product_data_panels', 'pizza_sizes_product_tab_content' );


/**
 * Save the custom fields.
 */
function save_pizza_size_field( $post_id ) {

    $pizza_size = isset( $_POST['_enable_pizza_sizes'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_enable_pizza_sizes', $pizza_size );

    if ( isset( $_POST['_six_cut_price'] ) ) :
        update_post_meta( $post_id, '_six_cut_price', sanitize_text_field( $_POST['_six_cut_price'] ) );
    endif;
    if ( isset( $_POST['_eight_cut_price'] ) ) :
        update_post_meta( $post_id, '_eight_cut_price', sanitize_text_field( $_POST['_eight_cut_price'] ) );
    endif;
    if ( isset( $_POST['_twelve_cut_price'] ) ) :
        update_post_meta( $post_id, '_twelve_cut_price', sanitize_text_field( $_POST['_twelve_cut_price'] ) );
    endif;

}
add_action( 'woocommerce_process_product_meta_pizza', 'save_pizza_size_field'  );
add_action( 'woocommerce_process_product_meta_variable_rental', 'save_pizza_size_field'  );

