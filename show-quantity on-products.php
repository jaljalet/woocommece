<?php
/**
 *	Show Quantity On Products
 */

add_action( 'woocommerce_before_add_to_cart_quantity', 'your_theme_echo_qty_front_add_cart' );
 
function your_theme_echo_qty_front_add_cart() {
 echo '<div class="qty-txt">Quantity: </div>'; 
}


/**
 * Plus Minus Quantity Buttons @ WooCommerce Single Product Page
 */
  
// -------------
// 1. Show Buttons
  
add_action( 'woocommerce_before_add_to_cart_quantity', 'your_theme_display_quantity_plus' );
  
function your_theme_display_quantity_plus() {
   echo '<button type="button" class="minus" >-</button>';
}
  
add_action( 'woocommerce_after_add_to_cart_quantity', 'your_theme_display_quantity_minus' );
  
function your_theme_display_quantity_minus() {
   echo '<button type="button" class="plus" >+</button>';
}
 
// Note: to place minus @ left and plus @ right replace above add_actions with:
// add_action( 'woocommerce_before_add_to_cart_quantity', 'your_theme_display_quantity_minus' );
// add_action( 'woocommerce_after_add_to_cart_quantity', 'your_theme_display_quantity_plus' );
  
// -------------
// 2. Trigger jQuery script
  
add_action( 'wp_footer', 'your_theme_add_cart_quantity_plus_minus' );
  
function your_theme_add_cart_quantity_plus_minus() {
   ?>
      <script type="text/javascript">
           
      jQuery(document).ready(function($){   
           
         $('.woocommerce-variation-add-to-cart').on( 'click', 'button.plus, button.minus', function() {

            // Get current quantity values
            if ( $( this ).is( '.minus' ) ) {
            	var qty = $(this).next().find('.qty');
        	} else {
        		var qty = $(this).prev().find('.qty');
        	}
            var val   = parseFloat(qty.val());
            console.log(val);
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));
  
            // Change the value if plus or minus
            if ( $( this ).is( '.plus' ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            }
              
         });
           
      });
           
      </script>
   <?php
}
