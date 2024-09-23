<?php
/**
 * Snippet Name: WooCommerce Automatically Update Cart On Quantity Change
 */

// First, hide the Update Cart button
add_action( 'wp_head', 'yourdomain_hide_update_cart_button' );
function yourdomain_hide_update_cart_button() { ?>
	<style>
		button[name="update_cart"], input[name="update_cart"] {
			display: none;
		}
</style>
<?php }

// Second, add the jQuery to update the cart automaitcally on quantity change
add_action('template_redirect', 'yourdomain_cart_js_script');
function yourdomain_cart_js_script() {
	if ( ! is_cart() ) return;
	wc_enqueue_js( "var timeout;
	$(document.body).on('change input', 'input.qty', function(){
		if ( timeout !== undefined ) clearTimeout( timeout );
		timeout = setTimeout(function() {
			$('[name=update_cart]').trigger('click'); // trigger cart update
		}, 800 );
	});" );
}
