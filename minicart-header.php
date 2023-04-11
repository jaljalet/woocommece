
<?php
// Minicart Header
if (!function_exists('yourdomain_mini_cart')) :
  function yourdomain_mini_cart($fragments) {

    ob_start();
    $count = WC()->cart->cart_contents_count; ?>
    <span class="cart-content">
      <?php if ($count > 0) { ?>
        <span class="cart-content-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light"><?php echo esc_html($count); ?></span><span class="cart-total ms-1 d-none d-md-inline"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
      <?php } ?>
    </span>

  <?php
    $fragments['span.cart-content'] = ob_get_clean();

    return $fragments;
  }
  add_filter('woocommerce_add_to_cart_fragments', 'yourdomain_mini_cart');

endif;
// Minicart Header End
