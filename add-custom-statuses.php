<?php
function yourdomain_register_custom_order_status() {
  // Status must start with "wc-"!
  register_post_status( 'wc-transfer', array(
    'label'                     => 'Transfer',
    'public'                    => true,
    'exclude_from_search'       => false,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count' => _n_noop( 'Transfer <span class="count">(%s)</span>', 'Transfer <span class="count">(%s)</span>', 'yourdomain' ),

  ) );
}
add_action( 'init', 'yourdomain_register_custom_order_status' );
