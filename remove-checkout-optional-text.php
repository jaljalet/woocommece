<?php

/*
 * Remove the (optional) Text from WooCommerce Checkout Fields
*/

add_filter( 'woocommerce_form_field' , 'yourdomain_remove_checkout_optional_text', 10, 4 );
function yourdomain_remove_checkout_optional_text( $field, $key, $args, $value ) {
if( is_checkout() && ! is_wc_endpoint_url() ) {
$optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
$field = str_replace( $optional, '', $field );
}
return $field;
}
