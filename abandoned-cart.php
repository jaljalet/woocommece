<?php

/*
Abandoned cart give 3 party
https://yourdomain.com/wp-json/wc/v3/abandoned-carts?consumer_key=your_wc_customer_key&consumer_secret=your_wc_secret_key
for use this code need WooCommerce Cart Abandonment Recovery by CartFlows plugin
*/
/* ABANDONED CART START */

	// 1. AUTHORIZE CHECK FUNCTION

	function abandoned_carts_permission_check() {
		$user_id = get_current_user_id();

		if (!$user_id) {
			return new WP_Error('unauthorized', 'API key is required.', ['status' => 401]);
		}

		$user = get_user_by('id', $user_id);

		if (!$user || (!in_array('administrator', $user->roles) && !in_array('shop_manager', $user->roles))) {
			return new WP_Error('forbidden', 'Access denied.', ['status' => 403]);
		}

		return true;
	}

	// 2. REGISTER API
	add_action('rest_api_init', function () {
		register_rest_route('wc/v3', '/abandoned-carts', [
			'methods'  => 'GET',
			'callback' => 'get_abandoned_carts_data',
			'permission_callback' => 'abandoned_carts_permission_check',
		]);
	});

	function get_abandoned_carts_data() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'cartflows_ca_cart_abandonment';
		$cutoff_time = time() - (72 * 60 * 60); // последние 72 часа

		$results = $wpdb->get_results($wpdb->prepare("
			SELECT * FROM $table_name
			WHERE order_status = %s
			  AND time >= %d
			ORDER BY id DESC
			LIMIT 50
		", 'abandoned', $cutoff_time));


		$carts = [];

		foreach ($results as $row) {
			$items = [];

			$cart_data = maybe_unserialize($row->cart_contents);

			if (is_array($cart_data)) {
				foreach ($cart_data as $item) {
					$items[] = [
						'product_id' => $item['product_id'] ?? null,
						'quantity'   => $item['quantity'] ?? 0,
						'name'       => is_object($item['data']) && method_exists($item['data'], 'get_name')
							? $item['data']->get_name()
							: '',
					];
				}

			}

			$carts[] = [
				'cart_id'      => $row->id,
				'email'        => $row->email,
				'abandoned_at' => date('Y-m-d H:i:s', (int) $row->time),
				'total'        => $row->cart_total,
				'items'        => $items,
			];
		}

		return rest_ensure_response([
			'success' => true,
			'count'   => count($carts),
			'data'    => $carts
		]);
	}
/* ABANDONED CART END */
