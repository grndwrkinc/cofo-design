<?php
/**
 * Template part for Shop filters sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cofo
 */

?>

<?php
	$obj = get_queried_object();
?>

<div id="filters">
	<button class="inverted">Catalog</button>
	<div class="inner">
	<a href="/shop/" class="slideright<?php if(is_page('shop')) { ?> active<?php } ?>">View all </a><br>
	<br>
	<strong class="slideright">Collections </strong><br>
<?php 
	//Get list of all Collection terms 
	$terms = get_terms( 'collection', array('hide_empty' => false) );
	foreach ($terms as $term) :

		//Check for Products belonging to the Collection
		$args = array(	
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'collection',
					'field'		=> 'slug',
					'terms'		=> $term->slug,
				)
			)
		);

		$posts = new WP_Query( $args );

		//If the Collection has Products, display the Collection filter
		if($posts->have_posts()) {
?>
	<a href="/shop/collection/<?php echo $term->slug; ?>" class="slideright<?php if($obj->slug == $term->slug) { ?> active<?php } ?>"><?php echo $term->name; ?></a><br>
<?php
			wp_reset_postdata();
		}
	endforeach;
?>
	 <br>
	<strong class="slideright">Categories</strong><br>
<?php 
	//Get list of all Category terms 
	$terms = get_terms( 'product_category', array('hide_empty' => false) );
	foreach ($terms as $term) :

		//Check for Products belonging to the Category filter
		$args = array(	
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'product_category',
					'field'		=> 'slug',
					'terms'		=> $term->slug,
				)
			)
		);
		$posts = new WP_Query( $args );

		//If the Collection has Products, display the Collection
		if($posts->have_posts()) {
?>
	<a href="/shop/category/<?php echo $term->slug; ?>" class="slideright<?php if($obj->slug == $term->slug) { ?> active<?php } ?>"><?php echo $term->name; ?></a><br>
<?php
			wp_reset_postdata();
		}
	endforeach;
?>
	<br>
<?php
	//Check for Sale Products
	//First, get all Products
	$args = array('post_type' => 'product');
	$posts = new WP_Query( $args );

	//Loop through all Products
	if($posts->have_posts()) : 
		while($posts->have_posts()) : $posts->the_post();
			//Get the Product's deets from Shopify
			$productID 		= get_post_meta($post->ID, "gwsh_product_id", true);
			$product 		= gwsh_getProduct($productID);
			$compareAtPrice = $product->variants[0]->compare_at_price;

			//If at least one Product is on sale, show the Sale filter
			if($compareAtPrice) :
?>
	<a href="/shop/sale/" class="slideright sale-filter<?php if($obj->slug == "sale") { ?> active<?php } ?>">Sale</a><br>
<?php
				break; // Only needed one. Let's get outta here!
			endif;
		endwhile;

		wp_reset_postdata();
	endif;
?>
	</div>
</div>