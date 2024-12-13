<?php
add_filter( 'woocommerce_register_shop_order_post_statuses', 'yourdomain_register_custom_order_status' );
 
function yourdomain_register_custom_order_status( $order_statuses ) {
   // Status must start with "wc-"!
   $order_statuses['wc-custom-status'] = array(
      'label' => 'Custom Status',
      'public' => false,
      'exclude_from_search' => false,
      'show_in_admin_all_list' => true,
      'show_in_admin_status_list' => true,
      'label_count' => _n_noop( 'Custom Status <span class="count">(%s)</span>', 'Custom Status <span class="count">(%s)</span>', 'woocommerce' ),
);
   return $order_statuses;
}
 
add_filter( 'wc_order_statuses', 'yourdomain_show_custom_order_status_single_order_dropdown' );
 
function yourdomain_show_custom_order_status_single_order_dropdown( $order_statuses ) {
   $order_statuses['wc-custom-status'] = 'Custom Status';
   return $order_statuses;
}
