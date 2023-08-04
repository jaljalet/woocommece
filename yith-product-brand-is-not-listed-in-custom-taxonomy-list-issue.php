<?php
// Fix - YITH Product Brand is not listed in Custom Taxonomy List issue
add_filter('advanced_woo_discount_rules_get_custom_taxonomies', function($custom_taxonomies) {
    $yith_brand_is_available = false;
    foreach($custom_taxonomies as $tax) {
        if ($tax->name == 'yith_product_brand') {
            $yith_brand_is_available = true;
            break;
        }
    }
    if (!$yith_brand_is_available) {
        $yith_taxonomies = get_taxonomies(array(
            'name' => 'yith_product_brand',
            'show_ui' => true,
            //'show_in_menu' => true,
            'object_type' => array('product'),
        ), 'objects');

        $custom_taxonomies = array_merge($custom_taxonomies, $yith_taxonomies);
    }

    return $custom_taxonomies;
});

// Original link: https://gist.github.com/AnanthFlycart/b55c805663a397802d64cd607cd74582
