<?php
add_action('woocommerce_check_cart_items', 'yourdomain_check_pending_orders');
function yourdomain_check_pending_orders() {
  $user_id = get_current_user_id();
  // Get the user's pending orders
  $pending_orders = wc_get_orders(array(
    'status' => 'wc-pending',
    'customer' => $user_id,
  ));
  if (!empty($pending_orders)) {
    wc_add_notice(__('You have pending orders. Please complete or cancel them before checking out.'), 'error');
    return false; // Prevent checkout
  }
}
