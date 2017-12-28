<?php

/*
Plugin Name: Shopify by GRNDWRK
Description: Integrate Shopify functionality into WordPress
Version: 1.0
Author: GRNDWRK Inc.
Author URI: https://www.grndwrk.ca
*/


// https://help.shopify.com/themes/customization/products/features/add-color-swatches#upload-your-color-images




// Define some constants
define( 'API_KEY','0804f07642e66e6ea0f18eb356b3079c' );
define( 'PASSWORD', '10873519cffcddb7f84951a786c6eb5c' );
define( 'GWSH_VERSION', '1.0' );
define( 'GWSH_CPT','product' );

//#{apikey}:#{password}@#{shop-name}.myshopify.com/admin/#{resource}.json
// https://0804f07642e66e6ea0f18eb356b3079c:10873519cffcddb7f84951a786c6eb5c@cofodesign-com.myshopify.com/admin/products.json


add_action( 'edit_form_after_title', function($p) { 
	
	wp_nonce_field( basename(__FILE__), 'gwsh_product_nonce'); 

	if( $p->post_type == GWSH_CPT ) {
		$ch = curl_init();

		$baseUrl = "https://" . API_KEY . ":" . PASSWORD . "@cofodesign-com.myshopify.com/admin/products.json";

		curl_setopt($ch, CURLOPT_URL, $baseUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$products = json_decode(curl_exec($ch));
		curl_close($ch);

		// echo "<pre>";
		// var_dump($p);
		// echo "</pre>";

		$post_meta_product_id = get_post_meta($p->ID, "gwsh_product_id");
		$post_meta_product_title = get_post_meta($p->ID, "gwsh_product_title") || get_the_title();
?>

	<div class="inside">
	<div id="edit-slug-box" class="hide-if-no-js">
	<strong>Shopify Products:</strong>
	<select id="gwsh_product_title" name="gwsh_product_title" <?php if ($p->post_status == "publish") {?>disabled<?php } ?>>
		<option value="">Select one</option>
		<option value="">----------------</option>
<?php
	foreach ($products->products as $product) :
		if($product->published_at) {
?>
		<option value="<?php echo $product->title; ?>" data-id="<?php echo $product->id; ?>" <?php if($product->id == $post_meta_product_id || $product->title == $post_meta_product_title) {?>selected<?php } ?>><?php echo $product->title; ?></option>
<?php
		}
	endforeach;
?>
	</select>
	<small>Select a product from the drop down to build a product page.</small>
	</div>
	</div>

<?php 
	if ($p->post_status == "publish") {
?>
	<span id="gswh_edit_product"><button type="button" class="edit-product button button-small hide-if-no-js" aria-label="Edit product">Edit</button></span>
<?php 
	} 
?>

	<input type="hidden" id="gwsh_product_id" name="gwsh_product_id" value="" />
<?php 
	}
});



/**************************************************
 *
 * Function: gwsh_save_post()
 *
 **************************************************/
function gwsh_save_post($post_id) {
	// STEP 1

	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );

    //Get original post meta so we can check if it's been updated
    $lead_metadata_before = get_post_meta($post_id);

   if ( isset( $_POST[ 'gwsh_product_nonce' ] ) && wp_verify_nonce( $_POST[ 'gwsh_product_nonce' ], basename( __FILE__ ) ) ) {
   		 $is_valid_nonce = true;
		}
   	else {
   		 $is_valid_nonce = false;
	}
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed 
    if( isset( $_POST[ 'gwsh_product_id' ] ) ) {
        update_post_meta( $post_id, 'gwsh_product_id', sanitize_text_field( $_POST[ 'gwsh_product_id' ] ) );
        update_post_meta( $post_id, 'gwsh_product_title', sanitize_text_field( $_POST[ 'gwsh_product_title' ] ) );
    }
}
add_action('save_post', 'gwsh_save_post');



/**************************************************
 *
 * Function: gwsh_enqueue_scripts()
 *
 **************************************************/
if ( ! function_exists('gwsh_enqueue_scripts') ) {
	function gwsh_enqueue_scripts( $hook ) {
		global $post;

		if ( ('post.php' === $hook || 'post-new.php' === $hook) && $post->post_type == GWSH_CPT ) {
			wp_enqueue_script( 'gwsh_scripts', plugins_url('js/scripts.js', __FILE__), false, null, true );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'gwsh_enqueue_scripts' );




/**************************************************
 *
 * Function: gw_activate_plugin()
 *
 **************************************************/
function gwsh_activate_plugin() {
	global $wp_rewrite;
	add_option( "gwsh_version", GWSH_VERSION ); // Add to WP Option tbl

	//Flush rewrite rules
	//cwl_create_leads_post_type();
	//$wp_rewrite->flush_rules();
}

register_activation_hook( __FILE__, 'gwsh_activate_plugin' );

