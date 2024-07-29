<?php
add_filter( 'woocommerce_product_add_to_cart_text', 'yourdomain_read_more_text', 10, 2 );
function yourdomain_read_more_text( $text, $product ) {
if ( ! $product->is_in_stock() ) {
$text = __( 'Your new text here', 'woocommerce' );
}
return $text;
}
