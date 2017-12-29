<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ndrscrs
 */

get_header(); 
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php
		while ( have_posts() ) : the_post();
			// $productID = get_field('product_id');
			$productID = get_post_meta($post->ID, "gwsh_product_id", true);
			$product = gwsh_getProduct($productID);

			//Make an array of all the product images to grab variant swatches
			$productImages = array();
			foreach($product->images as $image) {
				array_push($productImages, $image->src);
			};

?>
			<!-- Add fallback for no product available -->

			<div class="product-hero hero">
				<div class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div>
			</div>
			<div class="medium-container fixed">
				<div class="product-details bordered">
					<h4>$<?php echo $product->variants[0]->price; ?></h4>
					<h3><?php echo $product->title; ?></h3>

<?php
					foreach ($product->options as $option) :
?>
					<div class="variant-attribute">
						<p><?php echo $option->name; ?></p>
						<ul id="variant-attribute-options">
<?php 
						$cnt = 0;
						foreach($product->variants as $variant) : // This inner loop will need to change when there are more than one $production->options
							//Remove special characters and whitespace from variant title to match variant swatch image name
							$scrubTitle = preg_replace("/[^a-zA-Z]/", "", strtolower($variant->title));
							foreach($productImages as $src){
								if(strpos($src, $scrubTitle)){
									$imgSrc = $src;
								}
							}
						    
?>
							<li>
								<label for="<?php echo $variant->product_id . "_" . $variant->id; ?>">
									
									<input type="radio" name="variant" value="<?php echo $variant->id; ?>" id="<?php echo $variant->product_id . "_" . $variant->id; ?>" <?php if(!$cnt) { ?>checked<?php } ?>>
									<img src="<?php echo $imgSrc; ?>" alt="">
								</label>
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
			</div>
			<div class="medium-container product-container">

				<div class="product-text offset">
					<?php the_content(); ?>
					<div class="social">
						<p>Share</p>
						<div class="social-nav">
							<ul>
								<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="product-360 offset">
					<?php if( have_rows('360_images') ): ?>
						<div class="360-images-container">
		    			<?php while( have_rows('360_images') ): the_row(); 
		    				
		    				$image = get_sub_field('360_single_image'); ?>
		    				<?php if( $image ): ?>
	    						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
	    					<?php endif; ?>

		    			<?php endwhile; ?>
		    			</div>
		    		<?php endif; ?>
					<p><?php the_field('360_image_text'); ?></p>
				</div>

				<div class="product-explore offset">
					<?php if( have_rows('product_shots') ): 
						$cnt = 0; ?>
		    			<?php while( have_rows('product_shots') ): the_row(); 
		    				
		    				$image = get_sub_field('image');
		    				$content = get_sub_field('text'); ?>

		    				<?php if( $image ): ?>
		    					<div class="img-container">
	    							<img class="no<?php echo $cnt; ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
	    							<div class="open"></div>
		    					</div>
	    					<?php endif; ?>

	    					<p><?php if( $content ): ?>
	    						<?php echo $content; ?>
	    					<?php endif; ?></p>

		    			<?php $cnt++;
							endwhile; ?>
		    		<?php endif; ?>
				</div>
			</div>

			<?php 
				get_template_part( 'template-parts/content', 'gallery' );
			?>

			<div class="product-dimensions large-container">
				<p class="pre-header">Dimensions</p>
				<h2><span class="highlight">Imagine <?php the_title(); ?> in your space</span></h2>
				<?php $image = get_field('product_dimensions_image');
				if( !empty($image) ): ?>
					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				<?php endif; ?>
			</div>

			<div class="product-craftsmanship text-images-section">
				<p class="pre-header">Craftsmanship</p>
				<h2><span class="highlight"><?php the_field('craftsmanship_title'); ?></span></h2>
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
		   		<div class="designer-details">
		   			<img src="<?php the_post_thumbnail_url(); ?>" alt="">
		   			<div class="details">
				    	<p class="pre-header">Designed by</p>
				    	<h2><span class="highlight"><?php the_title(); ?></span></h2>
			    		<p><?php the_content(); ?></p>
		   			</div>
		   		</div>
	    		<?php if( have_rows('designer_info') ): ?>
	    			<div class="designer-extras">
	    			<?php while( have_rows('designer_info') ): the_row(); 
	    				
	    			get_template_part( 'template-parts/content', 'imagetext' );

	    			endwhile; ?>
	    			</div>
	    		<?php endif; ?>
		    </div>
		    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>

<?php 
		echo "<pre>";
		var_dump($productID);
		echo "</pre>";

		endwhile; // End of the loop.
?>
		<div class="challenge-cta bordered">
			<h4>Design Challenge</h4>
			<p>If you are a student or recent graduate and want to see your ideas in the real world, enter now. </p>
			<a href="/design-challenge" class="btn">View Challenge Details</a>
		</div>	
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
