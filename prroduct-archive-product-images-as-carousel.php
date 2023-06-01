<?php
// Product Archive Product images as carousel
	function thelifecoshop_woocommerce_product_archive_slider() {
		global $product;
		$post_thumbnail_id = $product->get_image_id();
		$attachment_ids = $product->get_gallery_image_ids();
		
		if($post_thumbnail_id) {
			array_unshift($attachment_ids, $post_thumbnail_id);
		}
		?>
		<a class="archive_product_image_slider_link" href="<?php echo get_permalink($product->get_id()); ?>" title="<?php echo get_the_title($product->get_id()); ?>">
			<div class="owl-carousel archive_product_image_slider">
				<?php foreach ( $attachment_ids as $attachment_id ) { ?>
					<div class="item"><?php echo wp_get_attachment_image($attachment_id, 'woocommerce_thumbnail'); ?></div>
				<?php } ?>
			</div>
		</a>
		<?php
	}	
	add_action( 'woocommerce_before_shop_loop_item_title', 'thelifecoshop_woocommerce_product_archive_slider', 20 );
