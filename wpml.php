<?php
// if not translate delete hreflang
function otgs_custom_hreflang( $hreflang_items ){
       
    if( is_array($hreflang_items) && !empty( $hreflang_items ) ){
           
        // Check if there are no translations available.
        if( 1 == count( $hreflang_items ) ){
            return null;
        }
    }
 
    return $hreflang_items;
}
add_filter( 'wpml_hreflangs', 'otgs_custom_hreflang' );
