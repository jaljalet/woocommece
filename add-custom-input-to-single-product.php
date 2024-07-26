<?php
	// Add custom field
	function action_woocommerce_product_options_pricing() {
		woocommerce_wp_text_input( array(
			'id'            => '_buy_in_marketplace',
			'label'         => __( 'Link to Marketplace', 'woocommerce' ),
			'description'   => __( 'This is a for marketplace url field write here url.', 'woocommerce' ),
			'desc_tip'      => 'true',
			'type'          => 'text'
		) );
	}
	add_action( 'woocommerce_product_options_pricing', 'action_woocommerce_product_options_pricing' );

	// Save custom field
	function action_woocommerce_admin_process_product_object( $product ) {
		// Isset
		if ( isset( $_POST['_buy_in_marketplace'] ) ) {        
			// Update
			$product->update_meta_data( '_buy_in_marketplace', sanitize_text_field( $_POST['_buy_in_marketplace'] ) );
		}
	}
	add_action( 'woocommerce_admin_process_product_object', 'action_woocommerce_admin_process_product_object', 10, 1 );

	// Display on single product page
	function action_woocommerce_after_add_to_cart_button() {
		global $product;

		// Is a WC product
		if ( is_a( $product, 'WC_Product' ) ) {
			// Get meta
			$buyInMarketplace = $product->get_meta( '_buy_in_marketplace' );

			// NOT empty
			if ( ! empty ( $buyInMarketplace ) ) {
				echo '<a href="' . $buyInMarketplace . '" id="buy_in_marketplace" "class="button alt" target="_blank">Pazaryerinde satın al</a>';
			}
		}
	}
	add_action( 'woocommerce_after_add_to_cart_button', 'action_woocommerce_after_add_to_cart_button', 1 );
