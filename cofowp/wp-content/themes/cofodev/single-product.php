<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ndrscrs
 */

wp_enqueue_style('threesixty_style', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/threesixty-slider/styles/threesixty.css');
wp_enqueue_script( 'threesixty_script', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/threesixty-slider/threesixty-min.js', array('jquery'), '2.0.4', true);
wp_enqueue_script( 'threesixty_plugin', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/threesixty-slider/plugins/threesixty.fullscreen-min.js', array('threesixty_script'), '1.0.0', true);
get_header(); 
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php
		while ( have_posts() ) : the_post();
			$productVariants = get_post_meta($post->ID, "gwsh_product_variants", true);
			$productID = get_post_meta($post->ID, "gwsh_product_id", true);
			$product = gwsh_getProduct($productID);
			$selected = $product->variants[0]->product_id . "_" . $product->variants[0]->id;

			// Load the product variants into the page as a JS variable
			// that can be referenced later in scripts.js
			wp_add_inline_script('cofo-scripts', 'var variants = ' . $productVariants, 'before'); 

			//Make an array of all the product images to grab variant swatches
			$productImages = array();
			foreach($product->images as $image) {
				array_push($productImages, $image->src);
			};

?>
			<!-- Add fallback for no product available -->
			<!-- ########## HERO IMAGE ########## -->
			<div class="product-hero hero">
<?php
				if( have_rows('hero_image') ):
					while ( have_rows('hero_image') ): the_row();
						$variant = get_sub_field('variant');
	    				$image = get_sub_field('image'); 
?>
				<div class="togglable hero <?php if($selected != $variant) echo "hidden"; ?>" style="background-image: url(<?php echo $image; ?>)" data-id="<?php echo $variant; ?>"></div>
<?php
					endwhile;
				endif;
?>
			</div>

			<!-- ########## PRODUCT DETAILS (NAME, PRICE, VARIANTS, ADD TO CART) ########## -->
			<div class="product-details-container medium-container">
				<div id="product-details" class="bordered">
					<h4>$<?php echo $product->variants[0]->price; ?></h4>
					<h3><?php the_title(); ?></h3>

<?php
			foreach ($product->options as $option) :
?>
					<div class="variant-attribute">
						<p><?php echo $option->name; ?></p>
						<ul id="variant-attribute-options">
<?php 
				$cnt = 0;
				// $selected = "";

				foreach($product->variants as $variant) : // This inner loop will need to change when there are more than one $production->options

					$id = $variant->product_id . "_" . $variant->id;
					// if($cnt == 0) $selected = $id;

					//Remove special characters and whitespace from variant title to match variant swatch image name
					$scrubTitle = preg_replace("/[^a-zA-Z]/", "", strtolower($variant->title));
					foreach($productImages as $src){
						if(strpos($src, $scrubTitle)){
							$imgSrc = $src;
						}
					}
?>
							<li>
								<label class="swatch-toggle" for="<?php echo $variant->product_id . "_" . $variant->id; ?>">
									<input type="radio" name="variant" value="<?php echo $variant->id; ?>" id="<?php echo $id; ?>" <?php if(!$cnt) { ?>checked<?php } ?>>
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

				<!-- ########## PRODUCT DESCRIPTION ########## -->
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

				<!-- ########## 360 IMAGE VIEWER ########## -->
				<div class="product-360 offset">
<?php 
				if( have_rows('360_image_viewer') ): 
    				$variantCnt = 0;
    				$viewerScript = "";
	    			
	    			while( have_rows('360_image_viewer') ): the_row(); 
		    			$variant = get_sub_field('variant');
	    				$images = get_sub_field('images');

	    				// Extract the image paths from the $images array, then 
	    				// join them into a string representing an array like:
	    				// ['url1', 'url2', 'url3',...]
	    				$imageArrayString = "['" . join("','", array_column($images, 'url'))  . "']"; 
?>
					<div id="viewer_<?php echo $variant; ?>" class="threesixty togglable <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>">
						<div class="spinner"><span>0%</span></div>
						<ol class="threesixty_images"></ol>
					</div>
<?php

						$viewerScript .= "$(document).ready(function() {\n";
						$viewerScript .= "	initViewer_" . $variant . "();\n";
						$viewerScript .= "	var viewer_" . $variant . ";\n";
						$viewerScript .= "	function initViewer_" . $variant . "() {\n";
						$viewerScript .= "		viewer_" . $variant . " = $('#viewer_" . $variant . "').ThreeSixty({\n";
						$viewerScript .= "			totalFrames: " . sizeof($images) . ",\n"; // Total no. of image you have for 360 slider"
						$viewerScript .= "			endFrame: " . sizeof($images) . ",\n"; // end frame for the auto spin animation
						$viewerScript .= "			currentFrame: 1,\n"; // This the start frame for auto spin
						$viewerScript .= "			imgList: '.threesixty_images',\n"; // selector for image list
						$viewerScript .= "			progress: '#viewer_" . $variant . " .spinner',\n"; // selector to show the loading progress
						$viewerScript .= "			imgArray: " . $imageArrayString . ",\n"; // path of the image assets
						$viewerScript .= "			height: 384,\n";
						$viewerScript .= "			width: 576,\n";
						$viewerScript .= "			responsive: true,\n";
						$viewerScript .= "			showCursor: true,\n";
						$viewerScript .= "			plugins: ['ThreeSixtyFullscreen']\n";
						$viewerScript .= "		});\n";
						$viewerScript .= "	}\n";
						$viewerScript .= "});\n";

					endwhile;

					// echo "<pre>";
					// var_dump($viewerScript);
					// echo "</pre>";

					wp_add_inline_script('threesixty_script', $viewerScript, 'after'); 

				endif; 
?>
					<p><?php the_field('360_text'); ?></p>
				</div>

				<!-- ########## PRODUCT DETAIL IMAGES ########## -->
<?php 
				if( have_rows('product_shots') ): 
					
					$cnt = 0;
?>
				<div class="product-explore offset">
<?php
					while( have_rows('product_shots') ): the_row();
	    				$variant = get_sub_field('variant');
						if( have_rows('images') ) : 
							while( have_rows('images') ) : the_row();
								$image = get_sub_field('image');
								$description = get_sub_field('description');
?>
					<div class="togglable img-container <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>" >
						<img class="no<?php echo $cnt; ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
						<div class="open"></div>
    					<p><?php if( $description ) echo $description; ?></p>
					</div>
<?php
								$cnt++;
							endwhile;
						endif;
					endwhile; 
?>
				</div>
<?php
				endif; 
?>
			</div>

			<!-- ########## GALLERY ########## -->
<?php 
			get_template_part( 'template-parts/content', 'gallery' );
?>

			<!-- ########## DIMENSIONS ########## -->
<?php
				if( have_rows('product_dimensions_images') ) :
?>
			<div class="product-dimensions large-container">
				<p class="pre-header">Dimensions</p>
				<h2><span class="highlight">Imagine <?php the_title(); ?> in your space</span></h2>
<?php
					while( have_rows('product_dimensions_images')) : the_row();
						$variant = get_sub_field('variant');
						$image = get_sub_field('image');
?>
				<img class="togglable <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
<?php 
					endwhile;
?>
			</div>
<?php
				endif; 
?>

			<!-- ########## CRAFTSMANSHIP ########## -->
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

			<!-- ########## PRODUCT DESIGNER ########## -->
<?php 
			$post_object = get_field('designer');

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
		// echo "<pre>";
		// var_dump($productID);
		// echo "</pre>";

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
