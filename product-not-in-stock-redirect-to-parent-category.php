<?php
	// If product not in stock redirect to parent category
	add_action('wp', 'yourdomain_custom_redirect');
	
	function yourdomain_custom_redirect() {
		$product = wc_get_product();
		//for product details page
		if (is_product()) {
			if($product->stock_status == 'outofstock' || $product->status == 'private') {
				wp_redirect(get_term_link( $product->category_ids[0], 'product_cat' )); //replace it with your URL
				exit();
			}
		}
	}
