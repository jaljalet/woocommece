<?php
// Showing children of current page in Posts Widget
add_action( 'elementor/query/children_filter', function( $query ) {
	$current_pageID = get_queried_object_id();
	// Modify the query
	$query->set( 'post_parent', $current_pageID );
});
