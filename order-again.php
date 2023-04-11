<?php
/**
	 * Order Again @ My Account Orders
	 */
	add_filter( 'woocommerce_my_account_my_orders_actions', 'yourdomain_order_again_action', 50, 2 );

	function yourdomain_order_again_action( $actions, $order ) {
		if ( $order->has_status( 'completed' ) ) {
			$actions['order-again'] = array(
				'url' => wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ),
				'name' => __( 'Order again', 'woocommerce' ),
			);
		}
		return $actions;
	}
