<?php
/**
 * Plugin Name: 	WooCommerce Custom Product Type
 * Plugin URI:		http://jeroensormani.com
 * Description:		A simple demo plugin on how to add a custom product type.
 */

/**
 * Register the custom product type after init
 */
function register_sub_product_type() {

    /**
     * This should be in its own separate file.
     */
    class WC_Product_Sub extends WC_Product {

        public function __construct( $product ) {

            $this->product_type = 'sub';

            parent::__construct( $product );

        }

    }

}
add_action( 'init', 'register_sub_product_type' );


/**
 * Add to product type drop down.
 */
function add_sub_product( $types ){

    // Key should be exactly the same as in the class
    $types[ 'sub' ] = __( 'Sub' );

    return $types;

}
add_filter( 'product_type_selector', 'add_sub_product' );


/**
 * Show pricing fields for sub product.
 */
function sub_custom_js() {

    if ( 'product' != get_post_type() ) :
        return;
    endif;

    ?><script type='text/javascript'>
        jQuery( document ).ready( function() {
            jQuery( '.options_group.pricing' ).addClass( 'show_if_sub' ).show();
        });

    </script><?php

}
add_action( 'admin_footer', 'sub_custom_js' );


/**
 * Contents of the rental options product tab.
 */
function sub_sizes_product_tab_content() {

    global $post;

    ?><div id='sub_sizes' class='panel woocommerce_options_panel'><?php

    ?><div class='options_group'><?php


    woocommerce_wp_text_input( array(
        'id'			=> '_six_inch_price',
        'label'			=> __( '6 inch', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of a 6 in sub', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    woocommerce_wp_text_input( array(
        'id'			=> '_twelve_inch_price',
        'label'			=> __( '12 inch', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'Price of a 12 in sub', 'woocommerce' ),
        'type' 			=> 'text',
    ) );

    ?></div>

    </div><?php


}
add_action( 'woocommerce_product_data_panels', 'sub_sizes_product_tab_content' );


/**
 * Save the custom fields.
 */
function save_sub_size_field( $post_id ) {

    $sub_size = isset( $_POST['_enable_sub_sizes'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_enable_sub_sizes', $sub_size );

    if ( isset( $_POST['_six_inch_price'] ) ) :
        update_post_meta( $post_id, '_six_inch_price', sanitize_text_field( $_POST['_six_inch_price'] ) );
    endif;
    if ( isset( $_POST['_twelve_inch_price'] ) ) :
        update_post_meta( $post_id, '_twelve_inch_price', sanitize_text_field( $_POST['_twelve_inch_price'] ) );
    endif;

}
add_action( 'woocommerce_process_product_meta_sub', 'save_sub_size_field'  );
add_action( 'woocommerce_process_product_meta_variable_rental', 'save_sub_size_field'  );

