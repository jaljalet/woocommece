<?php
// Showing latest post in post same category Posts Widget
add_action( 'elementor/query/children_cat_filter', function( $query ) {
	$current_pageID = get_queried_object();
	$posts_my = get_postdata($current_pageID);
	print_r();
	// Modify the query
	$query->set( 'cat', $posts_my['Category'][0] );
});
