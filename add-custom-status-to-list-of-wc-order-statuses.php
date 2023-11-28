<?php
function yourdomain_add_custom_to_order_statuses( $order_statuses ) {
   $new_order_statuses = array();
   // add new order status after processing
   foreach ( $order_statuses as $key => $status ) {
      $new_order_statuses[ $key ] = $status;
      if ( 'wc-processing' === $key ) {
         $new_order_statuses['wc-transfer'] = 'Transfer';
      }
   }
   return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'yourdomain_add_custom_to_order_statuses' );
