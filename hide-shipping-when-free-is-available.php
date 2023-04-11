<?php
function yourtheme_hide_shipping_when_free_is_available( $rates ) {
  $free = array();
  foreach ( $rates as $rate_id => $rate ) {
    if ( 'free_shipping' === $rate->get_method_id() ) {
      $free[ $rate_id ] = $rate;
    }
  }
  return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'yourtheme_hide_shipping_when_free_is_available', 100 );
