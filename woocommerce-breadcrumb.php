<?php
// WooCommerce Breadcrumb
if (!function_exists('bs_woocommerce_breadcrumbs')) :
  add_filter('woocommerce_breadcrumb_defaults', 'yourdomain_woocommerce_breadcrumbs');
  function yourdomain_woocommerce_breadcrumbs() {
    return array(
      'delimiter'   => '',
      'wrap_before' => "<nav aria-label='breadcrumb' class='wc-breadcrumb breadcrumb-scroller mb-4 mt-2 py-2 px-3 bg-light rounded'>
      <ol class='breadcrumb mb-0'>",
      'wrap_after'  => '</ol>
      </nav>',
      'before'      => '<li class="breadcrumb-item">',
      'after'       => '</li>',
      'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
    );
  }
endif;
