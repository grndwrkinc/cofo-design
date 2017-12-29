<?php

add_action( 'wp_ajax_gwsh_get_product_variants', 'gwsh_get_product_variants');

function gwsh_get_product_variants() {
	global $wpdb;

	//do some stuff;
	$variants = gwsh_getProductVariants($_POST['productID']);

	echo json_encode($variants);

	wp_die();
}
