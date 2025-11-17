<?php
add_action('init', function () {
		if (!get_role('mvholding')) {
			add_role( 'mvholding', 'MV Holding', get_role( 'customer' )->capabilities );
		}
	});

	// === Автоматическая установка роли mvholding при регистрации через WooCommerce ===
	add_action('woocommerce_created_customer', function ($customer_id) {
		$user = get_user_by('id', $customer_id);
		if (!$user) return;

		$email = $user->user_email;

		// Проверяем, содержит ли email нужный домен @mvholding.com
		if (strpos($email, '@mvholding.com') !== false) {
			// Меняем роль на mvholding
			$user->set_role('mvholding');
		}
});
