/*
	* Reduce the strength requirement for woocommerce registration password.
	* Strength Settings:
	* 0 = Nothing = Anything
	* 1 = Weak
	* 2 = Medium
	* 3 = Strong (default)
	*/

	add_filter( 'woocommerce_min_password_strength', 'thelifecoshop_woocommerce_password_filter', 10 );
	function thelifecoshop_woocommerce_password_filter() {
	return 2; } //2 represent medium strength password
