<?php
/**
 * Change Free Price to 0.01 - Woo Discount Rules
 */

if ( is_plugin_active('woo-discount-rules/woo-discount-rules.php') && is_plugin_active('woo-discount-rules-pro/woo-discount-rules-pro.php') ) {
  add_filter('woocommerce_product_get_price', function ($price, $product){
    if(isset($product->is_awdr_free_product)){
      if($product->is_awdr_free_product){
        $price = 0.01;
      }
    }

    return $price;
  }, PHP_INT_MAX, 2);
  add_filter('woocommerce_product_variation_get_price', function ($price, $product){
    if(isset($product->is_awdr_free_product)){
      if($product->is_awdr_free_product){
        $price = 0.01;
      }
    }

    return $price;
  }, PHP_INT_MAX, 2);
}
