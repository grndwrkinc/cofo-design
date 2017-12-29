<?php

/*
Plugin Name: Shopify by GRNDWRK
Description: Integrate Shopify functionality into WordPress
Version: 1.0
Author: GRNDWRK Inc.
Author URI: https://www.grndwrk.ca
*/

require_once("settings.php");
require_once("product.php");
require_once("ajax.php");

// Get a list of all the product from Shopify
// Display the list in a <select> field
add_action( 'edit_form_after_title', function($p) { 
	
	wp_nonce_field( basename(__FILE__), 'gwsh_product_nonce'); 

	if( $p->post_type == GWSH_CPT ) {
		
		$products = gwsh_getProducts();

		// echo "<pre>";
		// var_dump($products->products);
		// echo "</pre>";

		$post_meta_product_id = get_post_meta($p->ID, "gwsh_product_id", true);
		$post_meta_product_title = get_post_meta($p->ID, "gwsh_product_title", true);
		$post_meta_product_variants = get_post_meta($p->ID, "gwsh_product_variants", true);
?>

	<div class="inside">
		<div id="edit-slug-box" class="hide-if-no-js">
			<strong>Shopify Product:</strong>
			<select id="gwsh_select_product" name="gwsh_select_product" <?php if ($p->post_status == "publish") {?>disabled<?php } ?>>
				<option value="">Pick one</option>
<?php
				foreach ($products as $product) {
					if($product->published_at) {
?>
				<option value="<?php echo $product->title; ?>" data-id="<?php echo $product->id; ?>" <?php if($product->id == $post_meta_product_id || $product->title == $post_meta_product_title) {?>selected<?php } ?>><?php echo $product->title; ?></option>
<?php
					}
				}
?>
			</select>

			<span id="gwsh_product_select">
<?php 
			if ($p->post_status == "publish") {
?>
				<button type="button" class="edit-product button button-small hide-if-no-js" aria-label="Edit product">Edit</button>
<?php 
			}
			else {
?>
				<button type="button" class="select-product button button-small hide-if-no-js" aria-label="Select product">Select</button>
<?php
			}
?>
			</span>
			<input type='hidden' id='gwsh_product_id' name='gwsh_product_id' value='<?php echo $post_meta_product_id; ?>' />
			<input type='hidden' id='gwsh_product_title' name='gwsh_product_title' value='<?php echo $post_meta_product_title; ?>' />
			<input type='hidden' id='gwsh_product_variants' name='gwsh_product_variants' value='<?php echo $post_meta_product_variants; ?>' />
		</div>
	</div>
<?php 
	}
});




/**************************************************
 *
 * Function: acf_load_variant_field_choices()
 *
 **************************************************/
function acf_load_variant_field_choices( $field ) {
	global $post;

	$variants = json_decode(get_post_meta($post->ID, "gwsh_product_variants", true));

	if(sizeof($variants)) {
		//reset choices
		$field['choices'] = array();

		//loop through and add the variants to the choices
		if(is_array($variants)) {
			foreach ($variants as $variant) {
				$field['choices'][$variant->product_id . "_" . $variant->id] = $variant->title;
			}
		}
	}
	
	return $field;	
}
add_filter('acf/load_field/name=variant', 'acf_load_variant_field_choices');



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
    if(isset($_POST['gwsh_product_id'])) {
    	if($_POST['gwsh_product_id'] != $post_meta_product_id) {
		    update_post_meta( $post_id, 'gwsh_product_id', sanitize_text_field( $_POST[ 'gwsh_product_id' ] ) );
		    update_post_meta( $post_id, 'gwsh_product_title', sanitize_text_field( $_POST[ 'gwsh_product_title' ] ) );
		    update_post_meta( $post_id, 'gwsh_product_variants', sanitize_text_field( $_POST[ 'gwsh_product_variants' ] ) );
    	}
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
	add_action( 'admin_enqueue_scripts', 'gwsh_enqueue_scripts' );
}


