<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ndrscrs
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			$ch = curl_init();

			$productID = get_field('product_id');
			$apiKey = '0804f07642e66e6ea0f18eb356b3079c';
			$pwd = '10873519cffcddb7f84951a786c6eb5c';
			//#{apikey}:#{password}@#{shop-name}.myshopify.com/admin/#{resource}.json

			$baseUrl = "https://" . $apiKey . ":" . $pwd . "@cofodesign-com.myshopify.com/admin/products/" . $productID . ".json";

			curl_setopt($ch, CURLOPT_URL, $baseUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$product = json_decode(curl_exec($ch));
			curl_close($ch);

			$product = $product->product;

			// var_dump($product); 
			// //Get the variants in arrays to aid the variant picker
			// $megaArray = [];
			// foreach($product->variants as $variant){
			// 	$variantArray = [];
			// 	if(!in_array($variant->option1, $variantArray)){
			// 		array_push($variantArray,$variant->option1,$variant->option2);
   //      		}
			// 	array_push($megaArray,$variantArray);
			// }
			// var_dump($megaArray);

			?>
			<!-- Add fallback for no product available -->

			<div class="product-hero hero">
				<div class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div>
				<div class="description">
					<?php the_content(); ?>
					<div class="social">
						<p>Share <i class="fa fa-pinterest-p" aria-hidden="true"></i><i class="fa fa-facebook" aria-hidden="true"></i><i class="fa fa-instagram" aria-hidden="true"></i></p>
					</div>
				</div>
			</div>


			<div class="product-details">
				<h4><?php echo $product->variants[0]->price; ?></h4>
				<h3><?php echo $product->title; ?></h3>

<?php
				foreach ($product->options as $option) :
?>
				<div class="variant-attribute">
					<h5><?php echo $option->name; ?></h5>
					<ul id="variant-attribute-options">
<?php 
					$cnt = 0;
					foreach($product->variants as $variant) : // This inner loop will need to change when there are more than one $production->options
?>
						<li>
							<input type="radio" name="variant" value="<?php echo $variant->id; ?>" id="<?php echo $variant->product_id . "_" . $variant->id; ?>" <?php if(!$cnt) { ?>checked<?php } ?>>
							<label for="<?php echo $variant->product_id . "_" . $variant->id; ?>"><?php echo $variant->title; ?></label>
						</li>
<?php
						$cnt++;
					endforeach;
?>
					</ul>
				</div>

<?php
				endforeach;
?>
				<button id="add-to-cart">Add to cart</button>
			</div>


			<div class="product-explore">
				<!-- 360 image goes here -->
				<?php if( have_rows('product_shots') ): ?>
	    			<?php while( have_rows('product_shots') ): the_row(); 
	    				
	    				$image = get_sub_field('image');
	    				$content = get_sub_field('text'); ?>

	    				<?php if( $image ): ?>
    						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
    					<?php endif; ?>

	    				<div class="details">
	    					<p><?php if( $content ): ?>
	    						<?php echo $content; ?>
	    					<?php endif; ?></p>
	    				</div>

	    			<?php endwhile; ?>
	    		<?php endif; ?>
			</div>
			<div class="product-dimensions">
				<h2>Imagine <?php the_title(); ?> in your space</h2>
				<?php $image = get_field('product_dimensions_image');
				if( !empty($image) ): ?>
					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				<?php endif; ?>
			</div>
			<div class="product-craftsmanship text-images-section">
				<p class="pre-header">Craftsmanship</p>
				<h2><?php the_field('craftsmanship_title'); ?></h2>
				<div class="inner">
		    		<?php if( have_rows('craftsmanship_details') ): ?>
		    			<?php while( have_rows('craftsmanship_details') ): the_row(); 
		    				get_template_part( 'template-parts/content', 'imagetext' );
		    			endwhile; ?>
		    		<?php endif; ?>
		    	</div>
			</div>
			<?php $post_object = get_field('designer');

			if( $post_object ): 

				$post = $post_object;
				setup_postdata( $post ); 

				?>
			   <div class="product-designer">
			    	<p>Designed by</p>
			    	<h2><?php the_title(); ?></h2>
			    	<div class="inner">
			    		<p><?php the_content(); ?></p>
			    		<?php if( have_rows('designer_info') ): ?>
			    			<?php while( have_rows('designer_info') ): the_row(); 
			    				
			    			get_template_part( 'template-parts/content', 'imagetext' );

			    			endwhile; ?>
			    		<?php endif; ?>
			    	</div>
			    </div>
			    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
			</div>

<?php 
		echo "<pre>";
		var_dump($product); 
		echo "</pre>";

		endwhile; // End of the loop.
?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
