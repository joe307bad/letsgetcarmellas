<?php
/**
 * Created by PhpStorm.
 * User: Joseph
 * Date: 9/23/2017
 * Time: 8:57 AM
 */



require_once( __DIR__ . '/product-types/pizza.php');
require_once( __DIR__ . '/product-types/square-cut-pizza.php');
require_once( __DIR__ . '/product-types/sub.php');


/**
 * Add a custom product tab.
 */
function custom_product_tabs( $tabs) {

    $tabs['square_cut_pizza_sizes'] = array(
        'label'		=> __( 'Size Prices', 'woocommerce' ),
        'target'	=> 'square_cut_pizza_sizes',
        'class'		=> array( 'show_if_square_cut_pizza', 'show_if_variable_square_cut_pizza'  ),
    );
    $tabs['pizza_sizes'] = array(
        'label'		=> __( 'Size Prices', 'woocommerce' ),
        'target'	=> 'pizza_sizes',
        'class'		=> array( 'show_if_pizza', 'show_if_variable_pizza'  ),
    );
    $tabs['sub_sizes'] = array(
        'label'		=> __( 'Size Prices', 'woocommerce' ),
        'target'	=> 'sub_sizes',
        'class'		=> array( 'show_if_sub', 'show_if_variable_sub'  ),
    );

    return $tabs;

}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );


/**
 * Hide Attributes data panel.
 */
function hide_attributes_data_panel( $tabs) {

    $tabs['attribute']['class'][] = 'hide_if_pizza hide_if_variable_pizza';

    return $tabs;

}
add_filter( 'woocommerce_product_data_tabs', 'hide_attributes_data_panel' );