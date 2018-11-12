<?php
/**
 * Template part for /shop/category/
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cofo
 */

?>

<div class="category">

	<div class="items">
		<div class="item">
			<h3 class="slideup"><?php echo str_replace(" ", "<br>", $term->name); ?></h3>
		</div>

<?php
	//Spit out the Products for this Collection
	while ( $posts->have_posts() ) : $posts->the_post();

		$permalink 		= get_the_permalink();
		$title 			= get_the_title();
		$productID 		= get_post_meta($post->ID, "gwsh_product_id", true);
		$product 		= gwsh_getProduct($productID);
		$selected 		= $product->variants[0]->product_id . "_" . $product->variants[0]->id;
		$price 			= number_format(floatval($product->variants[0]->price),2);
		$compareAtPrice = $product->variants[0]->compare_at_price;
		$designer 		= get_field('designer');
		$designerName 	= "Designer Designer";
		$designerThumb 	= get_template_directory_uri() . "/assets/images/140x140.png";
		$productImages 	= array(array("variant" => $selected, "image" => get_template_directory_uri() . "/assets/images/1500x1000.png"));
		$cnt 			= 0;

		//Get the product images
		if(have_rows('collection_images')) :
			$i = 0;
			while(have_rows('collection_images')) : the_row();
				$productImages[$i]["variant"] = get_sub_field('variant');
				$productImages[$i]["image"] = get_sub_field('image')['sizes']['medium_large'];
				$i++;
			endwhile;
		endif;

		//Get the designer details
		if( $designer ) {
			$designerThumb = get_the_post_thumbnail_url($designer,'thumbnail');
			$designerName = get_the_title($designer);
		}
?>
		<div class="item">
			<div class="item-image slideup">
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
					<img class="togglable <?php if($selected != $productImages[$i]['variant']) echo "hidden"; ?>" data-id="<?php echo $productImages[$i]['variant']; ?>" data-alt="<?php echo $i; ?>" src="<?php echo $productImages[$i]['image']; ?>" />
<?php
					}
?>
				</a>
			</div>

			<div class="item-details slideup">
				<div class="item-designer"><img src="<?php echo $designerThumb; ?>" /></div>
				<div class="item-info">
					<h4><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h4>
					<p>										
						<em>designed by <?php echo $designerName; ?></em><br>
						<?php echo do_shortcode('[geoip_detect2_hide_if not_country="US"]From $' . $price . '[/geoip_detect2_hide_if]'); ?>
					</p>
				</div>
				<div class="variant-attribute">
					<ul class="variant-attribute-options">
<?php 
		//Get the variant swatches
		if(sizeof($product->variants) > 1) :
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
								<img <?php if($cnt == 0) { ?>class="active"<?php } ?> src="<?php echo $imgSrc; ?>" data-id="#<?php echo $id; ?>" data-alt="<?php echo $cnt; ?>" alt="<?php echo $variant->title; ?>" />
							</label>
						</li>
<?php
				}
			}
				if($cnt == 0) { $cnt++; };
				$cnt++;
			endforeach;
		endif;
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