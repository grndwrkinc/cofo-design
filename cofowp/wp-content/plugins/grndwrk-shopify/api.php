<?php

require_once("settings.php");

/* Product */
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

/* Collection */
function gwsh_getCollections() {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, BASEURL . 'collection_listings.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$collections = json_decode(curl_exec($ch));
	curl_close($ch);
	return $collections->collection_listings;
}

function gwsh_getProductsByCollection($collectionID) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, BASEURL . 'collection_listings/'.$collectionID.'/product_ids.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$products = json_decode(curl_exec($ch));
	curl_close($ch);
	return $products->product_ids;
}