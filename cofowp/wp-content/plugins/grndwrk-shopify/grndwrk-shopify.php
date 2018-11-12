<?php

/*
Plugin Name: Shopify by GRNDWRK
Description: Integrate Shopify functionality into WordPress
Version: 1.0
Author: GRNDWRK Inc.
Author URI: https://www.grndwrk.ca
*/

require_once("settings.php");
require_once("api.php");
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
 * Called on Save and Update
 *
 **************************************************/
function gwsh_save_post($post_id) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );

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
		
		$collections = gwsh_getCollections();
		$product = gwsh_getProduct($_POST['gwsh_product_id']);
    	
    	// Find the collection(s) that the product belongs to
    	// by going through all collections and checking if the product
    	// is a part of it. The list of collections is saved to an array.
		$productCollections = array();
    	foreach ($collections as $collection) {
    		$products = gwsh_getProductsByCollection($collection->collection_id);
    		foreach ($products as $product_id) {
    			if($product_id == $_POST['gwsh_product_id']) {
    				$productCollections[$collection->title] = $collection->body_html;
    			}
    		}
    	}
    	// Now that we have a list of all the collections this product belongs to,
    	// create a new Collection (taxonomy) Term for each, if it doesn't already exist,
    	// and link the product to the Collection Term
    	foreach ($productCollections as $collectionName => $collectionDescription) {
    		$collectionTerm = get_term_by('name', $collectionName, CPT_COLLECTION_TAXONOMY);

    		//Term doesn't currently exist
		    if(!$collectionTerm) {
				// Create new term
		    	$collectionTerm = wp_insert_term($collectionName, CPT_COLLECTION_TAXONOMY, array('description' => $collectionDescription));
		    }

		    // Link the product to the term
		    $collectionTerm = get_term_by('name', $collectionName, CPT_COLLECTION_TAXONOMY);
		    if(!has_term($collectionTerm->term_id, CPT_COLLECTION_TAXONOMY, $post_id)) {
		    	wp_set_post_terms( $post_id, array($collectionTerm->term_id), CPT_COLLECTION_TAXONOMY );
		    }
    	}


		// Create a new Category (taxonomy) Term for the product if it doesn't already exist,
    	// and link the product to the Category Term    	
    	$categoryTerm = get_term_by('name', $product->product_type, CPT_CATEGORY_TAXONOMY);
    	//Term doesn't currently exist
	    if(!$categoryTerm) {
			// Create new term
	    	$categoryTerm = wp_insert_term($product->product_type, CPT_CATEGORY_TAXONOMY);
	    }

	    // Link the product to the term
	    $categoryTerm = get_term_by('name', $product->product_type, CPT_CATEGORY_TAXONOMY);
	    if(!has_term($categoryTerm->term_id, CPT_CATEGORY_TAXONOMY, $post_id)) {
	    	wp_set_post_terms( $post_id, array($categoryTerm->term_id), CPT_CATEGORY_TAXONOMY );
	    }


    	// Update custom post meta data
    	$post_meta_product_id = get_post_meta($post_id, "gwsh_product_id", true);
    	// if($_POST['gwsh_product_id'] != $post_meta_product_id) {
		    update_post_meta( $post_id, 'gwsh_product_id', sanitize_text_field( $_POST[ 'gwsh_product_id' ] ) );
		    update_post_meta( $post_id, 'gwsh_product_title', sanitize_text_field( $_POST[ 'gwsh_product_title' ] ) );
		    update_post_meta( $post_id, 'gwsh_product_variants', sanitize_text_field( $_POST[ 'gwsh_product_variants' ] ) );
    	// }	
    }
}
add_action('save_post', 'gwsh_save_post');


/**************************************************
 *
 * Function: gwsh_enqueue_admin_scripts()
 *
 **************************************************/
if ( ! function_exists('gwsh_enqueue_admin_scripts') ) {
	function gwsh_enqueue_admin_scripts( $hook ) {
		global $post;

		if ( ('post.php' === $hook || 'post-new.php' === $hook) && $post->post_type == GWSH_CPT ) {
			wp_enqueue_script( 'gwsh_admin', plugins_url('js/admin.js', __FILE__), false, null, true );
		}
	}
	add_action( 'admin_enqueue_scripts', 'gwsh_enqueue_admin_scripts' );
}



/**************************************************
 *
 * Function: gwsh_enqueue_plugin_scripts()
 *
 **************************************************/
if ( ! function_exists('gwsh_enqueue_plugin_scripts') ) {
	function gwsh_enqueue_plugin_scripts( $hook ) {
		global $post;

		if(!is_admin()) {
			wp_enqueue_script( 'gwsh_plugin', plugins_url('js/plugin.js', __FILE__), false, null, true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'gwsh_enqueue_plugin_scripts' );
}


/**************************************************
 *
 * Function: setQueryArgs($taxonomy, $terms)
 *
 **************************************************/
function setQueryArgs($taxonomy = null, $terms = null) {
	if(isset($taxonomy) && isset($terms)) {
		$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy' 	=> $taxonomy,
						'field'		=> 'term_id',
						'terms'		=> $terms,
					)
				),
				'posts_per_page'=>-1,
				'order' 	=> 'ASC',
				'orderby' => 'menu_order',
			);
	}
	else {
		$args = array(
			'post_type' => 'product',
			'order' 	=> 'ASC',
			'orderby' => 'menu_order',
		);
	}

	return $args;
}
