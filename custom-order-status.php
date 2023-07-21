<?php
function register_shipment_arrival_order_status() {
   register_post_status( 'wc-arrival-shipment', array(
       'label'                     => 'Shipment Arrival',
       'public'                    => true,
       'show_in_admin_status_list' => true,
       'show_in_admin_all_list'    => true,
       'exclude_from_search'       => false,
       'label_count'               => _n_noop( 'Shipment Arrival <span class="count">(%s)</span>', 'Shipment Arrival <span class="count">(%s)</span>' )
   ) );
}
add_action( 'init', 'register_shipment_arrival_order_status' );
