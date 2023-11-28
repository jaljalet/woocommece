<?php
/**
 * @snippet BACS Order Status 
 */
add_filter( 'woocommerce_bacs_process_payment_order_status', 'yourdomain_change_bacs_order_status', 9999, 2 );

function yourdomain_change_bacs_order_status( $status, $order ) {
  return 'transfer';
}
