<?php

require_once("settings.php");

function gwsh_getProducts() {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, BASEURL . 'products.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$products = json_decode(curl_exec($ch));
	curl_close($ch);
	return $products->products;
}

function gwsh_getProduct($productID) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, BASEURL . 'products/'. $productID . '.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$product = json_decode(curl_exec($ch));
	curl_close($ch);
	return $product->product;
}

function gwsh_getProductVariants($productID) {
	$product = gwsh_getProduct($productID);
	return $product->variants;
}
