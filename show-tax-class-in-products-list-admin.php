<?php

	// Add new column to All Products page list
	add_filter( 'manage_edit-product_columns', 'tax_class_product_column');
	function tax_class_product_column($columns){
		$new_columns = [];
		foreach( $columns as $key => $column ){
			$new_columns[$key] = $columns[$key];
			if( $key == 'is_in_stock' ) {
				$new_columns['tax_class'] = __( 'Tax class','woocommerce');
			}
		}
		return $new_columns;
	}

	add_action( 'manage_product_posts_custom_column', 'tax_class_product_column_content', 10, 2 );
	function tax_class_product_column_content( $column, $post_id ){
		if( $column == 'tax_class' ){
			global $post, $product;

			// Excluding variable and grouped products
			if( is_a( $product, 'WC_Product' ) ) {
				$args = wc_get_product_tax_class_options();
				//print_r($args);
				echo $args[$product->get_tax_class()];
			}
		}
	}

	// Make the Tax Status column sortable
	add_filter( 'manage_edit-product_sortable_columns', function( $columns ) {
		$columns['tax_class'] = 'tax_class';
		return $columns;
	} );

	// Custom sorting for the Tax Status column
	add_filter( 'request', function( $vars ) {
		if ( isset( $vars['orderby'] ) && 'tax_class' === $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => '_tax_class',
				'orderby' => 'meta_value',
			) );
		}
		return $vars;
	} );
