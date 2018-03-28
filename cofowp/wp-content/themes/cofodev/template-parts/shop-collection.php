<?php
/**
 * Template part for /shop/collection/
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cofo
 */

?>

<div class="collection">
	<div class="collection-about anm-container">
		<p class="pre-header anm-item slideright-item">Collection</p>
		<h2 class="anm-item slideright-item"><span class="highlight"><?php echo str_replace(" ", "<br>", $term->name); ?></span></h2>
		<p class="anm-item slideright-item collection-description"><?php echo $term->description; ?></p>
	</div>
	<div class="collection-items-container">
		<img class="collection-hero slideup" src="<?php echo $collection_image; ?>" />

		<div class="collection-items">
<?php
	//Spit out the Products for this Collection
	while ( $posts->have_posts() ) : $posts->the_post();

		$permalink 		= get_the_permalink();
		$title 			= get_the_title();
		$productID 		= get_post_meta($post->ID, "gwsh_product_id", true);
		$product 		= gwsh_getProduct($productID);
		$price 			= number_format(floatval($product->variants[0]->price),2);
		$compareAtPrice = $product->variants[0]->compare_at_price;
		$designer 		= get_field('designer');
		$designerName 	= "Designer Designer";
		$designerThumb 	= get_template_directory_uri() . "/assets/images/140x140.png";
		$productImages 	= array(get_template_directory_uri() . "/assets/images/1500x1000.png", get_template_directory_uri() . "/assets/images/1500x1000.png");
		$cnt 			= 0;

		//Get the product images
		if(have_rows('360_image_viewer')) {
			$threesixty_images = get_field('360_image_viewer');
			//Assume there's only one variant, so the hover image should be the same
			$productImages[0] = $productImages[1] = $threesixty_images[0]["images"][0]["url"];
			if(sizeof($threesixty_images[0]["images"]) > 2) {
				$productImages[1] = $threesixty_images[0]["images"][2]["url"];
			}
			if(sizeof($threesixty_images) > 1) {
				for($i=1; $i < sizeof($threesixty_images); $i++) {
					$productImages[$i] = $threesixty_images[$i]["images"][0]["url"];
				}
			}
		}

		//Get the designer details
		if( $designer ) {
			$designerThumb = get_the_post_thumbnail_url($designer);
			$designerName = get_the_title($designer);
		}
?>
			<div class="item slideup">
				<div class="item-image">
<?php 
		if($compareAtPrice) {
?>
					<div class="sale-tag">Sale</div>
<?php
		}
?>
					<a href="<?php echo $permalink; ?>">
<?php
		for($i=0; $i<sizeof($productImages); $i++) {
?>
						<img data-alt="<?php echo $i; ?>" src="<?php echo $productImages[$i]; ?>" />
<?php
		}
?>
					</a>
				</div>

				<div class="item-details">
					<div class="item-designer"><img src="<?php echo $designerThumb; ?>" /></div>
					<div class="item-info">
						<h4><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h4>
						<p>										
							<em>designed by <?php echo $designerName; ?></em><br>
							$<?php echo $price ; ?>
						</p>
					</div>
					<div class="variant-attribute">
						<ul class="variant-attribute-options">
<?php 
		//Get the variant swatches
		foreach($product->variants as $variant) : // This inner loop will need to change when there are more than one $production->options

			$id = $variant->product_id . "_" . $variant->id;

			//Remove special characters and whitespace from variant title to match variant swatch image name
			$scrubTitle = preg_replace("/[^a-zA-Z]/", "", strtolower($variant->title));
			$imgSrc = "";
			foreach($product->images as $image) {
				if(strpos($image->src, $scrubTitle)) {
					$imgSrc = $image->src;
?>
							<li>
								<label class="swatch-toggle" for="<?php echo $variant->product_id . "_" . $variant->id; ?>">
									<?php /* <input type="radio" name="variant" value="<?php echo $variant->id; ?>" id="<?php echo $id; ?>" <?php if(!$cnt) { ?>checked<?php } ?>> */?>
									<img src="<?php echo $imgSrc; ?>" data-id="#<?php echo $id; ?>" data-alt="<?php echo $cnt; ?>" alt="<?php echo $variant->title; ?>" />
								</label>
							</li>
<?php
				}
			}
			$cnt++;
		endforeach;
?>
						</ul>
					</div>
				</div>
			</div>
<?php
	endwhile;
?>
		</div>
	</div>
</div>