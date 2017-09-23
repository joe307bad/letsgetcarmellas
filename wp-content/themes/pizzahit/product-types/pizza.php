<?php

/**
 * Register the custom product type after init
 */
function register_simple_rental_product_type() {

    /**
     * This should be in its own separate file.
     */
    class WC_Product_Simple_Rental extends WC_Product_Simple {

        public function __construct( $product ) {

            $this->product_type = 'simple_rental';

            parent::__construct( $product );

        }

    }

}
add_action( 'init', 'register_simple_rental_product_type' );

function add_simple_rental_product( $types ){

    // Key should be exactly the same as in the class product_type parameter
    $types[ 'simple_rental' ] = __( 'Simple Rental' );

    return $types;

}
add_filter( 'product_type_selector', 'add_simple_rental_product' );

/**
 * Add a custom product tab.
 */
function custom_product_tabs( $tabs) {
    $tabs['rental'] = array(
        'label'		=> __( 'Rental', 'woocommerce' ),
        'target'	=> 'rental_options',
        'class'		=> array( 'show_if_simple_rental', 'show_if_variable_rental'  ),
    );
    return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );
/**
 * Contents of the rental options product tab.
 */
function rental_options_product_tab_content() {
    global $post;
    ?><div id='rental_options' class='panel woocommerce_options_panel'><?php
    ?><div class='options_group'><?php
    woocommerce_wp_checkbox( array(
        'id' 		=> '_enable_option',
        'label' 	=> __( 'Enable rental option X', 'woocommerce' ),
    ) );
    woocommerce_wp_text_input( array(
        'id'			=> '_text_input_y',
        'label'			=> __( 'What is the value of Y', 'woocommerce' ),
        'desc_tip'		=> 'true',
        'description'	=> __( 'A handy description field', 'woocommerce' ),
        'type' 			=> 'text',
    ) );
    ?></div>

    </div><?php
}
add_action( 'woocommerce_product_data_panels', 'rental_options_product_tab_content' );
/**
 * Save the custom fields.
 */
function save_rental_option_field( $post_id ) {

    $rental_option = isset( $_POST['_enable_renta_option'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_enable_renta_option', $rental_option );

    if ( isset( $_POST['_text_input_y'] ) ) :
        update_post_meta( $post_id, '_text_input_y', sanitize_text_field( $_POST['_text_input_y'] ) );
    endif;

}
add_action( 'woocommerce_process_product_meta_simple_rental', 'save_rental_option_field'  );
add_action( 'woocommerce_process_product_meta_variable_rental', 'save_rental_option_field'  );