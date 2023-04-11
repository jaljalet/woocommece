<?php
function your_theme_woocommerce_loop_add_to_cart_link( $html, $product ) {
	return '<a href="' . get_permalink( $product->id ) . '" class="button">' . __( 'View Product' ) . '</a>';
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'your_theme_woocommerce_loop_add_to_cart_link', 10,2 );
